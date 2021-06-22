<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\News;

class NewsController extends ApiController
{
    public function __construct(News $model) {
        $this->model = $model;
    }

    public function transform(Request $request, $news) {
        $data = [
            'id' => $news->id,
            'image' => $news->image_url,
            'share_url' => $news->share_url,
        ];

        if (!empty($user = $request->user('api'))) {
            $data += [
                'user_fav' => $news->users_model->where('id', $user->id)->count() ? true : false
            ];
        }

        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $data += [
                'title' => $news->es_title,
                'caption' => $news->es_caption,
                'description' => $news->es_description,
                'long_text' => $news->es_long_text
            ];
        } else {
            $data += [
                'title' => $news->en_title,
                'caption' => $news->en_caption,
                'description' => $news->en_description,
                'long_text' => $news->en_long_text
            ];
        }

        return $data;
    }
}
