<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes([
    'register' => false
]);

Route::get('/password-reset-ok', function () {
    return view('password-reset-ok');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // SLIDES - LISTADO
    Route::get('/slides', 'SlideController@index');

    // SLIDES - FORMS
    Route::get('/slides/add', 'SlideController@form');
    Route::get('/slides/edit/{slide_id}', 'SlideController@form');

    // SLIDES - CREACIÓN / MODIFICACIÓN
    Route::post('/slides/add', 'SlideController@store');
    Route::put('/slides/edit/{slide_id}', 'SlideController@store');

    // SLIDES - BORRADO
    Route::delete('/slides/{slide_id}', 'SlideController@delete');
    Route::delete('/slides/{slide_id}/images/{image_hash}', 'SlideController@deleteSingleImage');


    // CATEGORÍA DE LOCALES - LISTADO
    Route::get('/categories', 'CategoryController@index');

    // CATEGORÍA DE LOCALES - FORMS
    Route::get('/categories/add', 'CategoryController@form');
    Route::get('/categories/edit/{category_id}', 'CategoryController@form');
    
    // CATEGORÍA DE LOCALES - CREACIÓN / MODIFICACIÓN
    Route::post('/categories/add', 'CategoryController@store');
    Route::put('/categories/edit/{category_id}', 'CategoryController@store');
    
    // CATEGORÍA DE LOCALES - BORRADO
    Route::delete('/categories/{category_id}', 'CategoryController@delete');


    // LOCALES - LISTADO
    Route::get('/stores', 'StoreController@index');

    // LOCALES - FORMS
    Route::get('/stores/add', 'StoreController@form');
    Route::get('/stores/edit/{store_id}', 'StoreController@form');
    
    // LOCALES - CREACIÓN / MODIFICACIÓN
    Route::post('/stores/add', 'StoreController@store');
    Route::put('/stores/edit/{store_id}', 'StoreController@store');
    Route::put('/stores/{store_id}/sort-images', 'StoreController@sortImages');
    
    // LOCALES - BORRADO
    Route::delete('/stores/{store_id}', 'StoreController@delete');
    Route::delete('/stores/{store_id}/images/{image_hash}', 'StoreController@deleteImage');
    Route::delete('/stores/{service_id}/logo', 'StoreController@deleteLogo');


    // SERVICIOS - LISTADO
    Route::get('/services', 'ServiceController@index');

    // SERVICIOS - FORMS
    Route::get('/services/add', 'ServiceController@form');
    Route::get('/services/edit/{service_id}', 'ServiceController@form');

    // SERVICIOS - CREACIÓN / MODIFICACIÓN
    Route::post('/services/add', 'ServiceController@store');
    Route::put('/services/edit/{service_id}', 'ServiceController@store');

    // SERVICIOS - BORRADO
    Route::delete('/services/{service_id}', 'ServiceController@delete');
    Route::delete('/services/{service_id}/images/{image_hash}', 'ServiceController@deleteImage');
    Route::delete('/services/{service_id}/icon', 'ServiceController@deleteIcon');


    // PROMOCIONES - LISTADO
    Route::get('/discounts', 'DiscountController@index');

    // PROMOCIONES - FORMS
    Route::get('/discounts/add', 'DiscountController@form');
    Route::get('/discounts/edit/{discount_id}', 'DiscountController@form');

    // PROMOCIONES - CREACIÓN / MODIFICACIÓN
    Route::post('/discounts/add', 'DiscountController@store');
    Route::put('/discounts/edit/{discount_id}', 'DiscountController@store');

    // PROMOCIONES - BORRADO
    Route::delete('/discounts/{discount_id}', 'DiscountController@delete');
    Route::delete('/discounts/{discount_id}/images/{image_hash}', 'DiscountController@deleteImage');


    // USUARIOS - LISTADO
    Route::get('/users', 'UserController@index');

    // USUARIOS - FORMS
    Route::get('/users/add', 'UserController@form');
    Route::get('/users/edit/{user_id}', 'UserController@form');

    // USUARIOS - CREACIÓN / MODIFICACIÓN
    Route::post('/users/add', 'UserController@store');
    Route::put('/users/edit/{user_id}', 'UserController@store');

    // USUARIOS - BORRADO
    Route::delete('/users/{user_id}', 'UserController@delete');
    Route::delete('/users/{user_id}/image', 'UserController@deleteSingleImage');


    // NOTIFICATIONS
    Route::get('/notifications', 'NotificationController@index');
    Route::get('/notifications/new', 'NotificationController@form');
    Route::post('/notifications/new', 'NotificationController@send');


    // EVENTOS - LISTADO
    Route::get('/events', 'EventController@index');

    // EVENTOS - FORMS
    Route::get('/events/add', 'EventController@form');
    Route::get('/events/edit/{event_id}', 'EventController@form');
    Route::post('/events/subscriptions/{event_id}', 'EventController@downloadXLS');

    // EVENTOS - CREACIÓN / MODIFICACIÓN
    Route::post('/events/add', 'EventController@store');
    Route::put('/events/edit/{event_id}', 'EventController@store');

    // EVENTOS - BORRADO
    Route::delete('/events/{event_id}', 'EventController@delete');
    Route::delete('/events/{event_id}/image', 'EventController@deleteSingleImage');
    
    
    // NOTICIAS - LISTADO
    Route::get('/news', 'NewsController@index');

    // NOTICIAS - FORMS
    Route::get('/news/add', 'NewsController@form');
    Route::get('/news/edit/{event_id}', 'NewsController@form');
    Route::post('/news/subscriptions/{event_id}', 'NewsController@downloadXLS');

    // NOTICIAS - CREACIÓN / MODIFICACIÓN
    Route::post('/news/add', 'NewsController@store');
    Route::put('/news/edit/{event_id}', 'NewsController@store');

    // NOTICIAS - BORRADO
    Route::delete('/news/{event_id}', 'NewsController@delete');
    Route::delete('/news/{event_id}/image', 'NewsController@deleteSingleImage');
});