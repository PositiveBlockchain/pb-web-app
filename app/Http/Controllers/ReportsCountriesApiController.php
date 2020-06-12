<?php

namespace App\Http\Controllers;

use App\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportsCountriesApiController extends Controller {

    public function __invoke(Request $request)
    {
        $taxonomies = Taxonomy::all()->map(function ($taxonomy) {
            $taxonomy->name = $taxonomy->term->name;
            unset($taxonomy->term);

            return $taxonomy;
        })->filter(function ($taxonomy) {
            return $taxonomy->taxonomy === 'location';
        });

        return response()->json([
                'status' => 'ok',
                'code' => Response::HTTP_OK,
                'data' => $taxonomies->values(),
                'chart_title' => 'Project country distribution',
                'links' => ['self' => route('api.reports.projects_by_locations')],
            ]
        );
    }
}
