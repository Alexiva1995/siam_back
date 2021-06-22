<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Slide;

class SlideController extends ApiController
{
    public function __construct(Slide $model) {
        $this->model = $model;
    }

    public function transform(Request $request, $slide) {
        $data = [
            'id' => $slide->id,
            'link' => $slide->link,
            'image' => $slide->image_url
        ];

        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $data += [
                'title' => $slide->es_title,
                'caption' => $slide->es_caption,
                'description_short' => $slide->es_description_short,
            ];
        } else {
            $data += [
                'title' => $slide->en_title,
                'caption' => $slide->en_caption,
                'description_short' => $slide->en_description_short,
            ];
        }

        return $data;
    }
}
