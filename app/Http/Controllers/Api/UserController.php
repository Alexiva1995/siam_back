<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Libraries\AcumbamailAPI;
use Illuminate\Support\Facades\Storage;
use App\Traits\CardNumber;
use App\Services\ImageService;

class UserController extends ApiController
{
    use CardNumber;

    public function __construct(User $model, ImageService $image_service) {
        $this->model = $model;

        parent::__construct($image_service);
    }

    public function getCurrentUser(Request $request) {
        $user = $request->user('api');
        if (!$user) return response()->json([], 200);

        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'card_number' => $user->card_number,
            'image' => $user->image_url,
            'birthdate' => $user->original_birthdate,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'zip_code' => $user->zip_code,
            'language' => $user->language
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request, $user_id = NULL) {
        $this->form_validator_fields = [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'password' => !$user_id ? ['required'] : ['nullable']
        ];
        if (User::when($user_id, function($query, $user_id) {
            $query->where('id', '!=', $user_id);
        })->where('email', $request->input('email'))->withTrashed()->count() > 0) {
            return response()->json(['message' => 'El email ya existe'], 400);
        }
        
        $this->form_data = [
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'birthdate' => $request->has('birthdate') ? Carbon::parse($request->input('birthdate'))->format("Y-m-d") : NULL,
            'phone_number' => $request->has('phone_number') ? $request->input('phone_number') : NULL,
            'address' => $request->has('address') ? $request->input('address') : NULL,
            'zip_code' => $request->has('zip_code') ? $request->input('zip_code') : NULL,
            'language' => $request->has('language') ? $request->input('language') : 'es'
        ];
        if (!$user_id) {
            do {
                $this->form_data['card_number'] = $this->generateCardNumber();
            } while($this->model->where('card_number', $this->form_data['card_number'])->count() > 0);

            // Almaceno la información del usuario en AcumbaMail
            if (env('ACUMBA_AUTH_TOKEN')) {
                $api = new AcumbamailAPI(env('ACUMBA_AUTH_TOKEN'));
                $response = $api->addSubscriber("358459", array(
                    'name' => $request->input('name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email')
                ));
            }
        }

        if (!empty($request->input('password'))) {
            $this->form_data['password'] = Hash::make($request->input('password'));
        }
        return parent::store($request, $user_id);
    }

    public function newImage(Request $request) {
        $user = $request->user('api');
        if (!$user) return response()->json([], 200);
        
        $data = $this->resizeAndStore($request->input('photo'));
        if (!empty($data)) {
            if ($user->image) {
                Storage::delete('public/' . $user->image->path);
            }
            $user->image = json_encode($data);
            $user->save();

            return response()->json([
                'image' => $user->image_url
            ], 200);
        }
        
        return response()->json([], 200);
    }
}
