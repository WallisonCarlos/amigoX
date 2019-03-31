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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/my-groups', 'AmigoX\GroupController@myGroups')->name('my-groups');
Route::resource('groups', 'AmigoX\GroupController');
Route::resource('requests', 'AmigoX\GroupMembersController');
Route::get('/create-session/{group}', 'AmigoX\SessionController@createSession')->name('sessions.createSession');
Route::get('/session/{session}/generate', 'AmigoX\SessionController@generatePairs')->name('sessions.generatePairs');
Route::get('/sessions/group/{group}', 'AmigoX\SessionController@sessionsGroup')->name('sessions.sessionsGroup');
Route::resource('sessions', 'AmigoX\SessionController');