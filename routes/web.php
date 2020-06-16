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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/track-shipment-details', 'HomeController@shipmentDetail');

Route::get('/track-shipment-detail-log-data/{shipment_number}' , 'HomeController@getShipmentDetailLogs');
Route::post('/track-shipment-details-filter' , 'HomeController@shipmentDetailFilter');

Route::get('/change_password','HomeController@change_password')->name('change_password');
Route::post('/change-password','HomeController@changePassword');
Route::get('/user-data','HomeController@authUserData');

Route::post('/customer_do_details','HomeController@customerDODEtails');
