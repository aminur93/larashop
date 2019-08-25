<?php

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

    /*
    * Admin Routes
    */

Route::prefix('admins')->group(function (){
    
    Route::middleware('auth:admins')->group(function (){
        //DashBoard Routes
        Route::get('/','DashBoardController@index');
    
        //Products Routes
        Route::resource('/products','ProductController');
    
        //orders Routes
        Route::resource('/orders','OrderController');
        Route::get('/pending/{id}','OrderController@pending')->name('orders.pending');
        Route::get('/confirmed/{id}','OrderController@confirmed')->name('orders.confirmed');
    
        //Users Routes
        Route::resource('/users','UserController');
        
        //Logout
        Route::get('/logout','AdminUserController@logout');
        
    });
    
    //admin login
    Route::get('/login', 'AdminUserController@index');
    Route::post('/login', 'AdminUserController@store');
    
});
    
    /*
    * frontend Routes
    */

Route::get('/','front\HomeController@index');

//user registration
Route::get('/user/register','front\RegistrationController@index');
Route::post('/user/register','front\RegistrationController@store');

//user Login
Route::get('/user/login','front\LoginController@index');
Route::post('/user/login','front\LoginController@store');

//user logout
Route::get('/user/logout','front\LoginController@logout');

//user profile
Route::get('/user/profile', 'front\UserProfileController@index');
Route::get('/user/profile/edit/{id}', 'front\UserProfileController@edit');
Route::post('/user/profile/update/{id}','front\UserProfileController@update');
Route::get('/user/order/{id}', 'front\UserProfileController@show');

//cart
Route::get('/user/cart','front\CartController@index');
Route::post('/user/cart','front\CartController@store')->name('user.cart');
Route::patch('/cart/update/{product}','front\CartController@update')->name('cart.update');
Route::delete('/user/cart/remove/{product}','front\CartController@destroy')->name('cart.destroy');
Route::post('/user/cart/saveLater/{product}','front\CartController@saveLater')->name('cart.saveLater');

//save for later
Route::delete('/saveLater/destroy/{product}','front\SaveLaterController@destroy')->name('saveLater.destroy');
Route::post('/cart/moveToCart/{product}','front\SaveLaterController@moveToCart')->name('saveLater.moveToCart');

//checkout
Route::get('/checkout','front\CheckoutController@index');
Route::post('/checkout','front\CheckoutController@store')->name('checkout');
    
    Route::get('empty', function () {
        Cart::instance('default')->destroy();
});

