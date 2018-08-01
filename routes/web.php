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
Route::get('/', 'LoginController@index')->name('top');
Route::post('/check','AuthController@check')->name('login');

Route::group(['middleware'=>['loginCheck']],function(){
    Route::get('/mypage', 'KintaiController@index')->name('mypage');
    Route::get('/logout','AuthController@logout')->name('logout');

    Route::post('/dakoku', 'KintaiController@store')->name('dakoku');
    Route::get('/archives', 'KintaiController@archives')->name('archives');
    Route::get('/archivesUpdate','KintaiController@archivesUpdate')->name('archivesupdate');
    Route::get('/archives/{ym}','KintaiController@getArchivesList')->name('archiveslist');



});
