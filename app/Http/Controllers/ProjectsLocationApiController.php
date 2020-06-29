<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProjectsLocationApiController extends Controller {

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
        $posts = $projectRepo->filterMetaFieldsWith(MetaFields::LP_OPTIONS_FIELD, $posts)->filter(function ($post) {
            return (
                Arr::has($post->fields, 'latitude')
                && Arr::has($post->fields, 'longitude')
                && $post->fields['latitude'] !== ""
                && $post->fields['longitude'] !== ""
            );
        });

        return response()->json([
            'status' => 'ok',
            'count' => $posts->count(),
            'code' => Response::HTTP_OK,
            'data' => $posts,
            'links' => ['self' => route('api.projects.locations')],
        ], Response::HTTP_OK
        );
    }
}
