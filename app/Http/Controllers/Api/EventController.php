<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Event;

class EventController extends ApiController
{
    public function __construct(Event $model) {
        $this->model = $model;
    }

    public function transform(Request $request, $event) {
        $user = $request->user('api');

        $data = [
            'id' => $event->id,
            'image' => $event->image_url,
            'share_url' => $event->share_url,
        ];

        if (!empty($user)) {
            $data += [
                'user_subscribed' => $event->users->where('id', $user->id)->count() ? true : false
            ];
        }

        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $data += [
                'title' => $event->es_title,
                'caption' => $event->es_caption,
                'description' => $event->es_description,
                'short_text' => $event->es_short_text,
                'long_text' => $event->es_long_text
            ];
        } else {
            $data += [
                'title' => $event->en_title,
                'caption' => $event->en_caption,
                'description' => $event->en_description,
                'short_text' => $event->en_short_text,
                'long_text' => $event->en_long_text
            ];
        }

        return $data;
    }
}
