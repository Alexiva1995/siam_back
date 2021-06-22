<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\Validator;
use App\Device;
use App\Slide;
use App\Store;
use App\Discount;

class NotificationController extends CrudController
{
    protected $attribute = 'notification';
    protected $label = ['Notificación', 'Notificaciones', 'Nueva'];

    public function __construct(Notification $model) {
        $this->model = $model;
    }

    public function form(Request $request, $item_id = NULL) {
        $stores = Store::get()->pluck('id','name')->mapWithKeys(function($id, $name) {
            return ['/store-detail/' . $id => '- ' . $name];
        })->toArray();
        
        $discounts = Discount::get()->pluck('id','title')->mapWithKeys(function($id, $title) {
            return ['/discount-detail/' . $id => '- ' . $title];
        })->toArray();

        $services = ['/tabs/services' => 'Listado'];

        $this->extra_data = [
            'links' => [
                'Tiendas' => array_merge(['/tabs/stores' => 'Listado'], $stores),
                'Servicios' => $services,
                'Promociones' => array_merge(['/tabs/discounts' => 'Listado'], $discounts)
            ]
        ];
        return parent::form($request, $item_id);
    }

    public function send(Request $request) {
        $required_config = ['APN_KEY', 'APN_KEY_ID', 'APN_TEAM_ID', 'APN_URL', 'FCM_API_KEY', 'FCM_URL'];
        foreach($required_config as $key) {
            if (!env($key)) {
                $type = 'danger';
                $message = 'Error de configuración';
                return redirect('/' . $this->attribute . 's')->with($type, $message);
            }
        }

        Validator::make($request->all(), [
            'es_title' => ['required', 'max:255'],
            'es_body' => ['required', 'max:255'],
            'en_title' => ['required', 'max:255'],
            'en_body' => ['required', 'max:255'],
        ], [
            'required' => 'Este campo es obligatorio',
            'max' => 'Este campo debe tener máximo de :max caracteres',
        ])->validate();

        // -- NOTIFICACIONES PARA IOS
        $time = round(microtime(true));
        $header = base64_encode(sprintf('{ "alg": "ES256", "kid": "%s" }', env('APN_KEY_ID')));
        $claims = base64_encode(sprintf('{ "iss": "%s", "iat": %d }', env('APN_TEAM_ID'), $time));
        
        $string = $header . '.' . $claims;
        openssl_sign($string, $signature, openssl_pkey_get_private(env('APN_KEY')), OPENSSL_ALGO_SHA256);
        $jwt = $string . '.' . base64_encode($signature);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'authorization: bearer ' . $jwt,
            'apns-topic: com.siamapp'
        ]);
        
        $devices_ios = Device::where('device_type', 'ios')->get();

        $responses = [];
        foreach($devices_ios as $device) {
            if ($device->language == 'es') {
                $title = $request->input('es_title');
                $body = $request->input('es_body');
            } else {
                $title = $request->input('en_title');
                $body = $request->input('en_body');
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"aps": {"alert": {"title": "' . $title . '", "body": "' . $body . '"}, "link": "' . $request->input('link') . '"}}');
            curl_setopt($ch, CURLOPT_URL, env('APN_URL') . $device->token);
            if ($resp = curl_exec($ch)) {
                $responses[] = $resp;
            }
        }
        curl_close($ch);
        // -- FIN NOTIFICACIONES IOS

        // -- NOTIFICACIONES ANDROID
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key=' . env('FCM_API_KEY'),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_URL, env('FCM_URL'));
        $devices_android = Device::where('device_type', 'android')->get();

        foreach($devices_android as $device) {
            if ($device->language == 'es') {
                $title = $request->input('es_title');
                $body = $request->input('es_body');
            } else {
                $title = $request->input('en_title');
                $body = $request->input('en_body');
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"to": "' . $device->token . '", "notification": {"title": "' . $title . '", "body": "' . $body . '"}, "data": {"link": "' . $request->input('link') . '"}, "priority": 10}');
            if ($resp = curl_exec($ch)) {
                $resp_obj = json_decode($resp);
                if ($resp_obj->failure) {
                    $responses[] = $resp;
                }
            }
        }
        curl_close($ch);
        // -- FIN NOTIFICACIONES ANDROID

        if (count($responses) == count($devices_android) && count($responses) == count($devices_ios)) {
            $type = 'danger';
            if (!count($devices_android) && !count($devices_ios)) {
                $message = 'No hay dispositivos registrados';
            } else {
                $message = 'No se han podido enviar las notificaciones. ' . implode(", ", $responses);
            }
        // } elseif (count($responses)) {
        //     $type = 'warning';
        //     $message = 'Las notificaciones se han enviado unicamente a algunos dispositivos. ' . implode(", ", $responses);
        //     $this->store($request);
        } else {
            $type = 'success';
            $message = 'Las notificaciones se han enviado correctamente.';
            $this->store($request);
        }

        return redirect('/' . $this->attribute . 's')->with($type, $message);
    }

    public function store(Request $request, $item_id = NULL) {
        $this->model->create([
            'es_title' => $request->input('es_title'),
            'es_body' => $request->input('es_body'),
            'en_title' => $request->input('en_title'),
            'en_body' => $request->input('en_body'),
            'link' => $request->has('link') ? $request->input('link') : NULL
        ]);
    }
}
