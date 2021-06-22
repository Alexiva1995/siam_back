<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends CrudController
{
    protected $attribute = 'categorie'; // workaround para que soporte la carga de la vista en CrudController
    protected $label = ['Categoría', 'Categorías', 'Nueva'];

    public function __construct(Category $model) {
        $this->model = $model;
    }

    public function index() {
        $this->model = $this->model->orderBy('es_title');
        return parent::index();
    }

    public function store(Request $request, $store_id = NULL) {
        $this->form_validator_fields = [
            'es_title' => ['required', 'max:255'],
            'en_title' => ['required', 'max:255']
        ];
        $this->form_data = [
            'es_title' => $request->input('es_title'),
            'en_title' => $request->input('en_title')
        ];
        return parent::store($request, $store_id);
    }
}
