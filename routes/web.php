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

// ログイン前
Route::get('/', 'IndexController@index');
Route::get( 'loginTask', 'LoginTaskController@index');
Route::post( 'loginTask', 'LoginTaskController@loginTask');
Route::get( 'logoutTask', 'LoginTaskController@logoutTask');
Route::get( 'signup', 'SignUpController@index');
Route::post( 'signup', 'SignUpController@create');

Route::get( 'passwordRemindSend', 'PasswordRemindSendContoroller@index');
Route::get( 'passwordRemindRecieve', 'PasswordRemindRecieveController@index');

// ログイン後
Route::get( 'task', 'TaskController@index');
Route::get( 'task/done', 'TaskController@done');
Route::post('task/create', 'TaskController@create');
Route::get('doneTask', 'DoneTaskController@index');
Route::get('doneTask/restore', 'DoneTaskController@restore');
Route::get('editTask', 'EditTaskController@index');
Route::post('editTask', 'EditTaskController@edit');

Route::get( 'myMenu', 'MyMenuController@index');
Route::post( 'myMenu/registCategory', 'MyMenuController@registCategory');

// お問い合わせ
Route::get('contact', 'ContactController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

