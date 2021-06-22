<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends CrudController
{

    protected $attribute = 'service';
    protected $label = ['Servicio', 'Servicios'];
    
    public function __construct(Service $model) {
        $this->model = $model;
        // $this->image_size = [500, 300];
    }

    public function store(Request $request, $service_id = NULL) {
        $this->form_validator_fields = [
            'es_title' => ['required', 'max:255'],
            'en_title' => ['required', 'max:255'],
            'images.*' => 'image',
            'icon' => 'image',
            'share_url' => ['nullable', 'url', 'max:255']
        ];
        $this->form_data = [
            'es_title' => $request->input('es_title'),
            'en_title' => $request->input('en_title'),
            'vip' => $request->input('vip') ? 1 : 0,
            'es_description' => $request->has('es_description') ? $request->input('es_description') : NULL,
            'en_description' => $request->has('en_description') ? $request->input('en_description') : NULL,
            'share_url' => $request->has('share_url') ? $request->input('share_url') : NULL
        ];

        return parent::store($request, $service_id);
    }
}
