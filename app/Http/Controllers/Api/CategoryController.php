<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends ApiController
{
    protected $order_by;
    
    public function __construct(Category $model) {
        $this->model = $model;
    }

    public function index(Request $request) {
        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $this->order_by = 'es_title';
        } else {
            $this->order_by = 'en_title';
        }

        return parent::index($request);
    }

    public function transform(Request $request, $category) {
        $data = [
            'id' => $category->id
        ];
        if (empty($request->server('HTTP_ACCEPT_LANGUAGE')) || $request->server('HTTP_ACCEPT_LANGUAGE') == 'es') {
            $data['title'] = $category->es_title;
        } else {
            $data['title'] = $category->en_title;
        }

        return $data;
    }
}
