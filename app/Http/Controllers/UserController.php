<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Carbon\Carbon;

class UserController extends CrudController
{
    protected $attribute = 'user';
    protected $label = ['Usuario', 'Usuarios'];

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function store(Request $request, $user_id = NULL) {
        $this->form_validator_fields = [
            'name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'password' => !$user_id ? ['required'] : ['nullable'],
            'image' => 'image'
        ];
        $this->form_data = [
            'admin' => $request->input('admin') ? 1 : 0,
            'language' => $request->input('language'),
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'birthdate' => $request->input('birthdate') ? Carbon::createFromFormat('d/m/Y', $request->input('birthdate'))->format("Y-m-d") : NULL,
            'phone_number' => $request->has('phone_number') ? $request->input('phone_number') : NULL,
            'address' => $request->has('address') ? $request->input('address') : NULL,
            'zip_code' => $request->has('zip_code') ? $request->input('zip_code') : NULL
        ];
        if (!empty($request->input('password'))) {
            $this->form_data['password'] = Hash::make($request->input('password'));
        }
        return parent::store($request, $user_id);
    }
}
