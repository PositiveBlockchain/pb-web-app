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
    Route::get('projects-active', 'ProjectsActiveApiController')->name('api.projects.active');
    Route::get('project-locations', 'ProjectsLocationApiController')->name('api.projects.locations');

    // Reports routes
    Route::get('reports/project-sub-categories', 'ReportsProjectsBySubCategoryApiController')->name('api.reports.projects_by_sub_categories');
    Route::get('reports/project-main-categories', 'ReportsProjectsMainCategoriesApiController')->name('api.reports.projects_by_main_categories');
    Route::get('reports/project-locations', 'ReportsCountriesApiController')->name('api.reports.projects_by_locations');
    Route::get('reports/project-ages', 'ReportsProjectAgesApiController')->name('api.reports.projects_by_ages');
    Route::get('reports/project-stages', 'ReportsProjectsByStageApiController')->name('api.reports.projects_by_stages');
    Route::get('reports/project-organization-types', 'ReportsProjectOrganizationTypesApiController')->name('api.reports.projects_by_organization_type');
    Route::get('reports/project-sdgs', 'ReportProjectsSdgDistributionApiController')->name('api.reports.projects_by_sdg');

    Route::apiResource('sdgs', 'SdgGoalsApiController')->only([
        'index', 'show',
    ]);
});


