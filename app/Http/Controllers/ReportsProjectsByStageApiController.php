<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ReportsProjectsByStageApiController extends Controller {

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $projectRepo = new ProjectRepository();

        $projectStages = $projectRepo->getWpListingFields()
            ->map(function ($post) {
                if (!Arr::exists($post->fields, MetaFields::STAGE_FIELD)
                    || empty($post->fields[MetaFields::STAGE_FIELD])
                )
                {
                    $fields = $post->fields;
                    $fields[MetaFields::STAGE_FIELD] = 'unknown';
                    $post->fields = $fields;
                }

                return $post->fields;
            })->groupBy(MetaFields::STAGE_FIELD)->map->count();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => MetaFields::guessSameFieldsAndMergeValues($projectStages->toArray())->sortDesc()->forget('unknown'),
            'chart_title' => 'Project stages',
            'link' => ['self' => route('api.reports.projects_by_stages')],
        ], Response::HTTP_OK
        );
    }
}
