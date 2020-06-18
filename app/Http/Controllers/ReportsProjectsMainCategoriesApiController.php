<?php

namespace App\Http\Controllers;

use App\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ReportsProjectsMainCategoriesApiController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $taxonomies = Taxonomy::all()->map(function ($taxonomy) {
            $taxonomy->name = Str::replaceFirst("&amp;", "&", $taxonomy->term->name);
            unset($taxonomy->term);

            return $taxonomy;
        })->filter(function ($taxonomy) {
            return $taxonomy->taxonomy === 'listing-category' && $taxonomy->parent === 0;
        });

        return response()->json([
                'status' => 'ok',
                'code' => Response::HTTP_OK,
                'data' => $taxonomies->sortByDesc('count')->values(),
                'chart_title' => 'Project main mainCategories distribution',
                'links' => ['self' => route('api.reports.projects_by_main_categories')],
            ]
        );
    }
}
