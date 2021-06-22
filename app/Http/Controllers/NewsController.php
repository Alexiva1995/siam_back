<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

class NewsController extends CrudController
{
    protected $attribute = 'news';
    protected $label = ['Noticia', 'Noticias', 'Nueva'];
    protected $list_blade = 'news-list';
    protected $form_blade = 'news-form';
    protected $url = 'news';

    public function __construct(News $model) {
        $this->model = $model;
    }

    public function store(Request $request, $event_id = NULL) {
        $this->form_validator_fields = [
            'es_title' => ['required', 'max:255'],
            'es_caption' => ['max:255'],
            'es_description' => ['max:255'],
            'en_title' => ['required', 'max:255'],
            'en_caption' => ['max:255'],
            'en_description' => ['max:255'],
            'image' => 'image',
            'share_url' => ['nullable', 'url', 'max:255']
        ];
        $this->form_data = [
            'es_title' => $request->input('es_title'),
            'es_caption' => $request->has('es_caption') ? $request->input('es_caption') : NULL,
            'es_description' => $request->has('es_description') ? $request->input('es_description') : NULL,
            'es_long_text' => $request->has('es_long_text') ? $request->input('es_long_text') : NULL,
            'en_title' => $request->input('en_title'),
            'en_caption' => $request->has('en_caption') ? $request->input('en_caption') : NULL,
            'en_description' => $request->has('en_description') ? $request->input('en_description') : NULL,
            'en_long_text' => $request->has('en_long_text') ? $request->input('en_long_text') : NULL,
            'share_url' => $request->has('share_url') ? $request->input('share_url') : NULL
        ];
        return parent::store($request, $event_id);
    }
}
