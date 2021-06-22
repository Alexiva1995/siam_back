<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Discount;

class DiscountController extends ApiController
{
    public function __construct(Discount $model) {
        $this->model = $model;
    }

    // Deprecated: se deja este metodo por retrocompatibilidad
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

    public function transform(Request $request, $discount) {
        $data = [
            'id' => $discount->id,
            'vip' => $discount->vip ? true : false,
            'date_from' => $discount->original_date_from,
            'date_to' => $discount->original_date_to,
            'image' => $discount->image_url,
            'share_url' => $discount->share_url,
        ];

        if (!empty($user = $request->user('api'))) {
            $data += [
                'user_fav' => $discount->users_model->where('id', $user->id)->count() ? true : false
            ];
        }

        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $data += [
                'title' => $discount->es_title,
                'caption' => $discount->es_caption,
                'description' => $discount->es_description
            ];
        } else {
            $data += [
                'title' => $discount->en_title,
                'caption' => $discount->en_caption,
                'description' => $discount->en_description
            ];
        }

        return $data;
    }
}
