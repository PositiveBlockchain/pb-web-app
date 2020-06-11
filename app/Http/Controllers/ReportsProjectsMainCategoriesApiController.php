<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportsProjectsMainCategoriesApiController extends Controller {

    public function __invoke(Request $request)
    {
        $projectRepo = new ProjectRepository();
        $mainCategoriesCounts = $projectRepo->getWpListingProjects()
            ->map(function ($post) {
                if (!property_exists($post, 'main_category'))
                {
                    $post->main_category = 'unknown';
                }

                return $post;
            })->groupBy('main_category')
            ->filter(function ($item, $key) {
                return $key !== 'Global';
            })
            ->sort()
            ->map->count();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => $mainCategoriesCounts,
            'link' => ['self' => route('api.reports.projects_by_ages')],
        ], Response::HTTP_OK
        );
    }
}
