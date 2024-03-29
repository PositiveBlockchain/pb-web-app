<?php

use App\Http\Controllers\ProjectsExportController;

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
})->name('web.welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::view('/projects-active', 'pages.projects-active')->name('web.projects.active');
Route::view('/sdgs', 'pages.sdgs')->name('web.sdgs');
Route::view('/map', 'pages.map')->name('web.map');

Route::get('/projects/export', 'ProjectsExportController');

