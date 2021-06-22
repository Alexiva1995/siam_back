<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Service;
use App\Discount;
use App\User;

class HomeController extends Controller
{
    public function index() {
        $store_count = Store::count();
        $service_count = Service::count();
        $discount_count = Discount::count();
        $user_count = User::count();

        $view_data = [
            'store_count' => $store_count,
            'service_count' => $service_count,
            'discount_count' => $discount_count,
            'user_count' => $user_count
        ];
        return view('home', $view_data);
    }
}
