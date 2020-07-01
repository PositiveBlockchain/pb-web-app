<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ReportProjectsSdgDistributionApiController extends Controller {

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $projectRepo = new ProjectRepository();
        $projects = $projectRepo->getWpListingProjects();
        $projectsWithFields = $projectRepo->filterMetaFieldsWith(MetaFields::LP_OPTIONS_FIELD, $projects);

        $sdgs = $projectsWithFields->flatMap(function ($item) {
            if (Arr::exists($item->fields, 'sdg'))
            {
                return $item->fields['sdg'];
            }
        })->countBy();

        return response()->json([
            'status' => 'ok',
            'count' => $projects->count(),
            'code' => Response::HTTP_OK,
            'data' => $sdgs,
            'chart_title' => 'Distribution of all projects to one or more SDG goals',
            'links' => ['self' => route('api.projects.index')],
        ], Response::HTTP_OK
        );
    }
}
