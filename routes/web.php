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
Route::delete('/requests/out/{id}', 'AmigoX\GroupMembersController@destroyFromGroup')->name('requests.out');
Route::resource('requests', 'AmigoX\GroupMembersController');
Route::get('/create-session/{group}', 'AmigoX\SessionController@createSession')->name('sessions.createSession');
Route::get('/edit-session/{session}/{group}', 'AmigoX\SessionController@editSession')->name('sessions.editSession');
Route::get('/session/{session}/generate', 'AmigoX\SessionController@generatePairs')->name('sessions.generatePairs');
Route::get('/sessions/group/{group}', 'AmigoX\SessionController@sessionsGroup')->name('sessions.sessionsGroup');
Route::delete('/sessions/removeParticipant/{user}/{session}', 'AmigoX\SessionController@destroyParticipant')->name('sessions.destroyParticipant');
Route::get('/message', 'MessageController@index')->name('message');
Route::post('/message', 'MessageController@store')->name('message.store');
Route::resource('sessions', 'AmigoX\SessionController');
Route::resource('chats', 'AmigoX\ChatController');

Route::get('/notify', function(){
  Auth::user()->notify(new \App\Notifications\Notify('Someone'));
  // Notification::send(Auth::user(), new \App\Notifications\StatusLiked('Someone'));
  return "Notification has been sent!";
});