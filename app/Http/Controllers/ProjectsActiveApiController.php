<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
        $posts = $projectRepo->getWpListingMostActiveProjects(50);
        $posts = $projectRepo->filterMetaFieldsWith(MetaFields::LP_OPTIONS_FIELD, $posts)
            ->filter(function ($item) {
                if (array_key_exists('short_description', $item->fields))
                {
                    return !Str::contains($item->fields['short_description'], 'inactive ***');
                }

                return true;
            });


        return response()->json([
            'status' => 'ok',
            'count' => $posts->count(),
            'code' => Response::HTTP_OK,
            'data' => $posts,
            'links' => ['self' => route('api.projects.active')],
        ], Response::HTTP_OK
        );
    }
}
