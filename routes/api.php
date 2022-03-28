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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

// Route::group(['middleware' => ['jwt.verify']], function (){

    // Route::group(['middleware' => ['api.superadmin']], function ()
    // {
        Route::delete('/customer/{id}', 'CustomerController@destroy');
        Route::delete('/product/{id}', 'ProductController@destroy');
        Route::delete('/admin/{id}', 'AdminController@destroy');
        Route::delete('/order/{id}', 'OrderController@destroy');
        Route::delete('/detail_order/{id}', 'DetailOrderController@destroy');
    // });

    // Route::group(['middleware' => ['api.admin']], function ()
    // {
        Route::post('/customer', 'CustomerController@add'); 
        Route::put('/customer/{id}', 'CustomerController@update');

        Route::post('/product', 'ProductController@add');
        Route::put('/product/{id}', 'ProductController@update');

        Route::post('/admin', 'AdminController@add');
        Route::put('/admin/{id}', 'AdminController@update');

        Route::post('/order', 'OrderController@add');
        Route::put('/order/{id}', 'OrderController@update');
        
        Route::post('/detail_order', 'DetailOrderController@add');
        Route::put('/detail_order/{id}', 'DetailOrderController@update');
    // });

    Route::get('/customer', 'CustomerController@show'); 
    Route::get('/customer/{id}', 'CustomerController@detail');

    Route::get('/product', 'ProductController@show'); 
    Route::get('/product/{id}', 'ProductController@detail');

    Route::get('/admin', 'AdminController@show'); 
    Route::get('/admin/{id}', 'AdminController@detail');

    Route::get('/order', 'OrderController@show');
    Route::get('/order/{id}', 'OrderController@detail');

    Route::get('/detail_order', 'DetailOrderController@show');
    Route::get('detail_order/{id}', 'DetailOrderController@detail');
// });