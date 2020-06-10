<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ReportsProjectAgesApiController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $projectRepo = new ProjectRepository();

        $projectYears = $projectRepo->getWpListingFields()
            ->map(function ($post) {
                if (!Arr::exists($post->fields, MetaFields::CREATION_YEAR_FIELD)
                    || empty($post->fields[MetaFields::CREATION_YEAR_FIELD])
                    || !is_numeric($post->fields[MetaFields::CREATION_YEAR_FIELD])
                )
                {
                    $fields = $post->fields;
                    $fields[MetaFields::CREATION_YEAR_FIELD] = 'unkown';
                    $post->fields = $fields;
                }

                return $post->fields;
            })->groupBy(MetaFields::CREATION_YEAR_FIELD)->map->count();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => $projectYears,
            'link' => ['self' => route('api.reports.projects_by_ages')],
        ], Response::HTTP_OK
        );
    }
}
