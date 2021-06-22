<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\Store;
use App\Discount;

class SlideController extends CrudController
{
    protected $attribute = 'slide';
    protected $label = ['Slide', 'Slides'];

    public function __construct(Slide $model) {
        $this->model = $model;
        $this->image_size = [750, 1270];
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

    public function store(Request $request, $store_id = NULL) {
        $this->form_validator_fields = [
            'es_title' => ['required', 'max:255'],
            'es_caption' => ['max:255'],
            'es_description_short' => ['max:255'],
            'en_title' => ['required', 'max:255'],
            'en_caption' => ['max:255'],
            'en_description_short' => ['max:255'],
            'link' => ['max:255'],
            'image' => 'image'
        ];
        $this->form_data = [
            'es_title' => $request->has('es_title') ? $request->input('es_title') : NULL,
            'es_caption' => $request->has('es_caption') ? $request->input('es_caption') : NULL,
            'es_description_short' => $request->has('es_description_short') ? $request->input('es_description_short') : NULL,
            'en_title' => $request->has('en_title') ? $request->input('en_title') : NULL,
            'en_caption' => $request->has('en_caption') ? $request->input('en_caption') : NULL,
            'en_description_short' => $request->has('en_description_short') ? $request->input('en_description_short') : NULL,
            'link' => $request->has('link') ? $request->input('link') : NULL
        ];
        return parent::store($request, $store_id);
    }
}
