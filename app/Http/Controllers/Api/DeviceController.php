<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Device;

class DeviceController extends ApiController
{
    public function __construct(Device $model) {
        $this->model = $model;
    }

    public function store(Request $request, $device_id = NULL) {
        $this->form_validator_fields = [
            'token' => ['required', 'max:255'],
            'device_type' => ['required', 'max:255']
        ];

        $this->form_data = [
            'token' => $request->input('token'),
            'device_type' => $request->input('device_type'),
            'language' => empty($request->server('HTTP_ACCEPT_LANGUAGE')) ? 'es' : $request->server('HTTP_ACCEPT_LANGUAGE')
        ];

        $device = Device::where('token', $request->input('token'))->first();
        if (!empty($device)) {
            $device_id = $device->id;
        }
        
        return parent::store($request, $device_id);
    }
}
