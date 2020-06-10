<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ReportsProjectOrganizationTypesApiController extends Controller {

    public function __invoke(Request $request)
    {
        $projectRepo = new ProjectRepository();

        $projectYears = $projectRepo->getWpListingFields()
            ->map(function ($post) {
                if (!Arr::exists($post->fields, MetaFields::ORGANIZATION_TYPE_FIELD)
                    || empty($post->fields[MetaFields::ORGANIZATION_TYPE_FIELD])
                )
                {
                    $fields = $post->fields;
                    $fields[MetaFields::ORGANIZATION_TYPE_FIELD] = 'unkown';
                    $post->fields = $fields;
                }

                return $post->fields;
            })->groupBy(MetaFields::ORGANIZATION_TYPE_FIELD)->map->count();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => $projectYears,
            'link' => ['self' => route('api.reports.projects_by_ages')],
        ], Response::HTTP_OK
        );
    }
}
