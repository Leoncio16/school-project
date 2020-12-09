<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
Route::get('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return Redirect::back()->withErrors(['Link został wysłany, proszę sprawdzić pocztę']);
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/', 'PageController@main')->middleware('auth');
Route::group([
'middleware' => 'roles',
'roles' => ['User', 'Writer', 'Moderator', 'Admin']

],function(){
  Route::post('/comments/add', 'PageController@comment_add');
  Route::get('/comments/delete/{id}', 'PageController@comment_del');
  Route::post('/comments/edit', 'PageController@comment_edit');
});
Route::group([
'middleware' => 'roles',
'roles' => ['Moderator']

],function(){

  Route::get('/moderator', 'PageController@moderator');


});
Route::group([
'middleware' => 'roles',
'roles' => 'Admin'

],function(){
  Route::get('/admin', 'PageController@admin');
  Route::get('/admin/posts', 'PageController@posts');
  Route::post('/admin/posts/create', 'PageController@posts_create');
  Route::get('/admin/posts/delete', 'PageController@posts');
  Route::get('/admin/posts/delete/{id}', 'PageController@posts_delete');
  Route::post('/admin/posts/edit', 'PageController@posts_edit');
  Route::get('/admin/users', 'PageController@users_list');
  Route::get('/admin/users/delete/{id}', 'PageController@users_delete');
  Route::post('/admin/users/edit', 'PageController@users_edit');
  Route::post('/admin/users/find', 'PageController@users_find');
  Route::post('/admin/users/find_group', 'PageController@users_find_group');
  Route::get('/admin/newsletter', 'PageController@admin_newsletter');
  Route::post('/admin/newsletter/create', 'PageController@newsletter_create');
});
Route::group([
'middleware' => 'roles',
'roles' => 'Writer'

],function(){
  Route::get('/writer', 'PageController@writer_panel');
  Route::get('/writer/posts', 'PageController@writer_panel_posts');
  Route::get('/writer/posts/delete/{id}', 'PageController@posts_delete');
  Route::post('/writer/posts/create', 'PageController@posts_create');
  Route::post('/writer/posts/edit', 'PageController@posts_edit');
});

Route::get('/pages/{slug}', 'PageController@show');
Route::get('/pages', 'PageController@index');
Route::get('/main', 'PageController@main');
Route::get('/articles', 'PageController@articles')->name('articles');
Route::get('/plus/{id}', 'PageController@plus');
Route::get('/minus/{id}', 'PageController@minus');
Route::post('/newsletter', 'PageController@newsletter');


#Auth::routes();
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
