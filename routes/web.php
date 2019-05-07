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

Route::get('/home', 'DashboardController@index');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/list', 'AdminController@index');
Route::get('/admin/create', 'AdminController@create');
Route::post('/admin/ajaxrequest', 'AdminController@ajaxrequest');
Route::get('/admin/detail/{id_admin}', 'AdminController@detail');

Route::get('/group', 'GroupController@index');
Route::get('/group/list', 'GroupController@index');
Route::get('/group/create', 'GroupController@create');
Route::post('/group/ajaxrequest', 'GroupController@ajaxrequest');
Route::get('/group/detail/{id_group}', 'GroupController@detail');
Route::get('/group/access/{id_group}', 'GroupController@access');

Route::get('/menu', 'MenuController@index');
Route::get('/menu/list', 'MenuController@index');
Route::get('/menu/create', 'MenuController@create');
Route::post('/menu/ajaxrequest', 'MenuController@ajaxrequest');
Route::get('/menu/detail/{id_menu}', 'MenuController@detail');

Route::get('/login', 'LoginController@index');
Route::get('/', 'LoginController@index');
Route::get('/login/logout', 'LoginController@logout');
Route::post('/login/try', 'LoginController@ajaxrequest');

Route::get('/error/notauthorize',  'ErrorController@index');

Route::get('/superadmin/list',  'SuperadminController@index');
