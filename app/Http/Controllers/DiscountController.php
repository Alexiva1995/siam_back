<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discount;
use Carbon\Carbon;

class DiscountController extends CrudController
{
    protected $attribute = 'discount';
    protected $label = ['Promoción', 'Promociones'];

    public function __construct(Discount $model) {
        $this->model = $model;
    }

    public function store(Request $request, $discount_id = NULL) {
        $this->form_validator_fields = [
            'es_title' => ['required', 'max:255'],
            'en_title' => ['required', 'max:255'],
            'es_caption' => ['max:255'],
            'en_caption' => ['max:255'],
            'date_from' => ['nullable', 'date_format:d/m/Y'],
            'date_to' => ['nullable', 'date_format:d/m/Y'],
            'images.*' => 'image',
            'share_url' => ['nullable', 'url', 'max:255']
        ];
        $this->form_data = [
            'vip' => $request->input('vip') ? 1 : 0,
            'es_title' => $request->input('es_title'),
            'en_title' => $request->input('en_title'),
            'es_caption' => $request->input('es_caption'),
            'en_caption' => $request->input('en_caption'),
            'date_from' => $request->input('date_from') ? Carbon::createFromFormat('d/m/Y', $request->input('date_from'))->format("Y-m-d") : NULL,
            'date_to' => $request->input('date_to') ? Carbon::createFromFormat('d/m/Y', $request->input('date_to'))->format("Y-m-d") : NULL,
            'es_description' => $request->has('es_description') ? $request->input('es_description') : NULL,
            'en_description' => $request->has('en_description') ? $request->input('en_description') : NULL,
            'share_url' => $request->has('share_url') ? $request->input('share_url') : NULL
        ];
        return parent::store($request, $discount_id);
    }
}
