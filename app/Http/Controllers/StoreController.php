<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Category;

class StoreController extends CrudController
{
    protected $attribute = 'store';
    protected $label = ['Tienda', 'Tiendas', 'Nueva'];

    public function __construct(Store $model) {
        $this->model = $model;
        $this->image_size = [500, 700];
    }

    public function form(Request $request, $item_id = NULL) {

        $this->extra_data = [
            'categories' => Category::orderBy('es_title')->get()
        ];

        return parent::form($request, $item_id);
    }

    public function store(Request $request, $store_id = NULL) {
        $this->form_validator_fields = [
            'name' => ['required', 'max:255'],
            'es_description_short' => ['required', 'max:255'],
            'en_description_short' => ['required', 'max:255'],
            'es_description' => ['required'],
            'en_description' => ['required'],
            'es_location' => ['required', 'max:255'],
            'en_location' => ['required', 'max:255'],
            'images.*' => 'image',
            'logo' => 'image',
            'category_id' => ['required', 'exists:categories,id'],
            'share_url' => ['nullable', 'url', 'max:255']
        ];
        $this->form_data = [
            'name' => $request->input('name'),
            'es_description_short' => $request->input('es_description_short'),
            'es_description' => $request->input('es_description'),
            'es_location' => $request->input('es_location'),
            'en_description_short' => $request->input('en_description_short'),
            'en_description' => $request->input('en_description'),
            'en_location' => $request->input('en_location'),
            'hour_from' => $request->input('hour_from') ? str_replace(":", "", $request->input('hour_from')) : NULL,
            'hour_to' => $request->input('hour_to') ? str_replace(":", "", $request->input('hour_to')) : NULL,
            'phone_number' => $request->input('phone_number'),
            'url' => $request->input('url'),
            'category_id' => $request->input('category_id'),
            'share_url' => $request->has('share_url') ? $request->input('share_url') : NULL
        ];
        return parent::store($request, $store_id);
    }
}
