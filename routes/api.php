<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['api'])->group(function () {
    // SLIDES
    Route::get('/slides', 'Api\SlideController@index');

    // USUARIOS
    Route::post('/users/add', 'Api\UserController@store');
    Route::get('/user', 'Api\UserController@getCurrentUser');
    Route::put('/users/edit/{user_id}', 'Api\UserController@store');
    Route::post('/user/new-image', 'Api\UserController@newImage');

    // PROMOCIONES
    Route::get('/discounts', 'Api\DiscountController@index');
    Route::get('/discounts-vip', 'Api\DiscountController@indexVip'); // Deprecated: se deja este endpoint por retrocompatibilidad
    Route::get('/discounts/{discount_id}', 'Api\DiscountController@get');
    Route::post('/discounts/{discount_id}/fav', 'Api\DiscountController@saveFav');
    Route::delete('/discounts/{discount_id}/fav', 'Api\DiscountController@deleteFav');

    // LOCALES
    Route::get('/stores', 'Api\StoreController@index');
    Route::get('/categories', 'Api\CategoryController@index');
    Route::get('/stores/{store_id}', 'Api\StoreController@get');
    Route::post('/stores/{store_id}/fav', 'Api\StoreController@saveFav');
    Route::delete('/stores/{store_id}/fav', 'Api\StoreController@deleteFav');
    
    // SERVICIOS
    Route::get('/services', 'Api\ServiceController@index');
    Route::get('/services-vip', 'Api\ServiceController@indexVip');
    Route::get('/services/{service_id}', 'Api\ServiceController@get');

    // EVENTOS
    Route::get('/events', 'Api\EventController@index');
    Route::get('/events/{event_id}', 'Api\EventController@get');
    Route::post('/events/{event_id}/fav', 'Api\EventController@saveFav');
    Route::delete('/events/{event_id}/fav', 'Api\EventController@deleteFav');
    
    // NOTICIAS
    Route::get('/news', 'Api\NewsController@index');
    Route::get('/news/{news_id}', 'Api\NewsController@get');
    Route::post('/news/{news_id}/fav', 'Api\NewsController@saveFav');
    Route::delete('/news/{news_id}/fav', 'Api\NewsController@deleteFav');

    // DISPOSITIVOS
    Route::post('/devices', 'Api\DeviceController@store');
});

Route::middleware(['auth:api'])->group(function () {
    
});