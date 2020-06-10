<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    // Projects routes
    Route::get('projects', 'ProjectsIndexApiController')->name('api.projects.index');
    Route::get('projects/{id}', 'ProjectsShowApiController')->name('api.projects.show');

    // Reports routes
    Route::get('reports/project-categories', 'ReportsProjectsByCategoryApiController')->name('api.reports.projects_by_categories');
    Route::get('reports/project-locations', 'ReportsLocationsApiController')->name('api.reports.projects_by_locations');
    Route::get('reports/project-ages', 'ReportsProjectAgesApiController')->name('api.reports.projects_by_ages');
});
