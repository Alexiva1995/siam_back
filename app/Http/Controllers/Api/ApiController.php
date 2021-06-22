<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\ImageService;

class ApiController extends Controller
{
    protected $model;
    protected $order_by;
    protected $image_service;

    public function __construct(ImageService $image_service) {
        $this->image_service = $image_service;
    }

    public function index(Request $request) {
        if (!empty($this->order_by)) {
            $model = $this->model->orderBy($this->order_by);
        } else{
            $model = $this->model;
        }
        $items = $model->get()->map(function($item) use ($request) {
            return $this->transform($request, $item);
        });

        return response()->json($items, 200);
    }

    public function get(Request $request, $item_id) {
        $item = $this->transform($request, $this->model->where('id', $item_id)->firstOrFail());

        return response()->json($item, 200);
    }

    public function doValidate(Request $request) {
        Validator::make($request->all(), $this->form_validator_fields, [
            'required' => 'Este campo es obligatorio',
            'max' => 'Este campo debe tener máximo de :max caracteres',
            'image' => 'Los archivos subidos deben ser imagenes',
            'date' => 'La fecha no es válida',
            'email' => 'El email debe ser una dirección de correo válida'
        ])->validate();
    }

    public function store(Request $request, $item_id = NULL) {
        $this->doValidate($request);

        if ($item_id) {
            $this->model->where('id', $item_id)->update($this->form_data);
            $message = 'El registro ha sido actualizado correctamente';
        } else {
            $this->model->create($this->form_data);
            $message = 'El registro ha sido creado correctamente';
        }

        return response()->json([
            'message' => $message
        ], 200);
    }

    public function transform(Request $request, $item) {
        
    }

    public function saveFav(Request $request, $item_id) {
        $user = $request->user('api');
        if (!$user) return response()->json([], 200);

        $item = $this->model->where('id', $item_id)->firstOrFail();
        if (!count($item->users_model->where('id', $user->id))) {
            $item->users_model()->save($user, ['created_at' => Carbon::now()]);
        }
        return response()->json([], 200);
    }
    
    public function deleteFav(Request $request, $item_id) {
        $user = $request->user('api');
        if (!$user) return response()->json([], 200);

        $item = $this->model->where('id', $item_id)->firstOrFail();
        $item->users_model->where('id', $user->id)->each(function($rel) {
            $rel->pivot->delete();
        });

        return response()->json([], 200);
    }

    public function resizeAndStore($image, $image_size = NULL) {
        return $this->image_service->resizeAndStore($image, $image_size);
    }
}
