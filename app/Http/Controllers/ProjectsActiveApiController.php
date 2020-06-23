<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectsActiveApiController extends Controller {

    /**
     * @param Request $request
     */
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $projectRepo = new ProjectRepository();
        $posts = $projectRepo->getWpListingActiveProjects();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => $projectRepo->filterMetaFieldsWith(MetaFields::LP_OPTIONS_FIELD, $posts),
            'link' => ['self' => route('api.projects.active')],
        ], Response::HTTP_OK
        );
    }
}
