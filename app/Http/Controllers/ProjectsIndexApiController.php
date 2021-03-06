<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectsIndexApiController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $projectRepo = new ProjectRepository();
        $limit = 10; // default limit move to config later
        if ($request->has('limit'))
        {
            $limit = $request->get('limit');
        }
        $posts = $projectRepo->getWpListingProjectsWithLimit($limit);

        return response()->json([
            'status' => 'ok',
            'count' => $posts->count(),
            'code' => Response::HTTP_OK,
            'data' => $projectRepo->filterMetaFieldsWith(MetaFields::LP_OPTIONS_FIELD, $posts),
            'links' => ['self' => route('api.projects.index')],
        ], Response::HTTP_OK
        );
    }

}
