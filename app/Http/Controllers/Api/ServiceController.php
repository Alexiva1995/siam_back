<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends ApiController
{
    public function __construct(Service $model) {
        $this->model = $model;
    }

    public function index(Request $request) {
        $this->model = $this->model->where('vip', 0);
        
        return parent::index($request);
    }

    public function indexVip(Request $request) {
        $this->model = $this->model->where('vip', 1);
        
        return parent::index($request);
    }

    public function get(Request $request, $discount_id) {
        if ($request->user('api')) {
            $this->model = $this->model;
        } else {
            $this->model = $this->model->where('vip', 0);
        }

        return parent::get($request, $discount_id);
    }

    public function transform(Request $request, $service) {
        $data = [
            'id' => $service->id,
            'vip' => $service->vip ? true : false,
            'image' => $service->image_url,
            'icon' => $service->icon_url,
            'share_url' => $service->share_url,
        ];

        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $data += [
                'title' => $service->es_title,
                'description' => $service->es_description
            ];
        } else {
            $data += [
                'title' => $service->en_title,
                'description' => $service->en_description
            ];
        }

        return $data;
    }
}
