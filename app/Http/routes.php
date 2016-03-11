<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Models\Pais;

Route::bind('post',function($post){
    return \App\Models\Post::findOrFail($post);
});
Route::bind('autor',function($id){
    return \App\Models\Autor::findOrFail($id);
});

Route::get('/', 'PostController@index');
Route::get('post', 'PostController@listado');
Route::post('post/{post}/comentario','ComentariosController@store');
Route::get('autores',function(){
    $paises = Pais::all();
    return view('autor.index',compact('paises'));
});
Route::resource('autor','AutorController',['except'=>['create','show','edit']]);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
