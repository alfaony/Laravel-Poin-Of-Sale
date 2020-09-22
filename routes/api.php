<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user(); 
// Route::get('/subcategori/{id}','ApiController@produkSubcategori');
});

Route::get('/subcategori','ApiController@produkSubcategori');
Route::get('/cart','ApiController@getCart');


Route::post('/toOrder','ApiController@insertToOrder');
Route::post('/totalOrder','ApiController@insertTotalOrder');
Route::post('/antrian','ApiController@antrian');

// CART
Route::post('/cart','ApiController@addToCart');
Route::post('/checkout','ApiController@checkout');
Route::put('/pluscart/{id}','ApiController@plusCart');
Route::put('/minuscart/{id}','ApiController@minusCart');
Route::delete('/cart/{id}', 'ApiController@removeCart');
Route::get('/total','ApiController@generateTotal');


// Barista
Route::get('/pembelian','ApiController@pembelian');
Route::post('/getBil','ApiController@getBil');
Route::get('/pembelianToday','ApiController@pembelianToday');
Route::get('/cookie','ApiController@getCookie');
Route::get('/getTimeWork','ApiController@getTimeWork');
Route::post('/kerja','ApiController@kerja');
Route::put('/updateBuy','ApiController@updateBuy');
Route::put('bayar','ApiController@bayar');






