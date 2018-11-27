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
Auth::routes();

Route::get('/', 'EmailsController@guest');
Route::get('/home', 'EmailsController@index')->middleware('auth');
Route::get('/proxy', 'EmailsController@proxy')->middleware('auth');
Route::get('/hash', 'EmailsController@hash')->middleware('auth');
Route::post('/makehash', 'EmailsController@makehash')->middleware('auth');
Route::post('/send_all', 'EmailsController@send_all')->middleware('auth');
Route::get('/my_queue', 'EmailsController@my_queue')->middleware('auth');
Route::get('/failed_queue', 'EmailsController@failed_queue')->middleware('auth');
Route::get('/my_postmans', 'EmailsController@my_postmans')->middleware('auth');
Route::post('/clear_attempts', 'EmailsController@clear_attempts')->middleware('auth');
Route::post('/run_jobs', 'EmailsController@run_jobs')->middleware('auth');
Route::post('/try_again/{id}', 'EmailsController@try_again')->middleware('auth');
Route::post('/try_again_all', 'EmailsController@try_again_all')->middleware('auth');
Route::post('/add_email', 'EmailsController@add_email')->middleware('auth');
Route::post('/delete_email/{id}', 'EmailsController@delete_email')->middleware('auth');
Route::post('/enable_email/{id}', 'EmailsController@enable_email')->middleware('auth');
Route::post('/disable_email/{id}', 'EmailsController@disable_email')->middleware('auth');
Route::post('/delete_failed_all', 'EmailsController@delete_failed_all')->middleware('auth');
