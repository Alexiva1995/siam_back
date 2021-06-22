<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Store;

class StoreController extends ApiController
{
    protected $order_by;
    
    public function __construct(Store $model) {
        $this->model = $model;
        $this->order_by = 'name';
    }

    public function index(Request $request) {
        if ($request->has('category_id')) {
            $this->model = $this->model->where('category_id', $request->input('category_id'));
        }
        return parent::index($request);
    }

    public function transform(Request $request, $store) {
        $data = [
            'id' => $store->id,
            'name' => $store->name,
            'hour_from' => $store->hour_from,
            'hour_to' => $store->hour_to,
            'phone_number' => $store->phone_number,
            'url' => $store->url,
            'images' => $store->images_url,
            'logo' => $store->logo_url,
            'share_url' => $store->share_url
        ];

        if (!empty($user = $request->user('api'))) {
            $data += [
                'user_fav' => $store->users_model->where('id', $user->id)->count() ? true : false
            ];
        }

        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $data += [
                'description_short' => $store->es_description_short,
                'description' => $store->es_description,
                'location' => $store->es_location,
                'category' => $store->category ? [
                    'id' => $store->category->id,
                    'title' => $store->category->es_title,
                ] : NULL
            ];
        } else {
            $data += [
                'description_short' => $store->en_description_short,
                'description' => $store->en_description,
                'location' => $store->en_location,
                'category' => $store->category ? [
                    'id' => $store->category->id,
                    'title' => $store->category->en_title,
                ] : NULL
            ];
        }

        return $data;
    }
}
