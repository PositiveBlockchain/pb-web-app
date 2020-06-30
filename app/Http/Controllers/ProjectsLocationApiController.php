<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Repositories\ProjectRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProjectsLocationApiController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $projectRepo = new ProjectRepository();
        $allPosts = $projectRepo->getWpListingProjects();
        $posts = $projectRepo->filterMetaFieldsWith(MetaFields::LP_OPTIONS_FIELD, $allPosts)->filter(function ($post) {
            return (
                Arr::has($post->fields, 'latitude')
                && Arr::has($post->fields, 'longitude')
                && $post->fields['latitude'] !== ""
                && $post->fields['longitude'] !== ""
            );
        })->map(function ($post) {
            $post->main_category = Str::replaceFirst("&amp;", "&", $post->main_category);
            $post->taxonomies = $post->taxonomies->map(function ($item) {
                $item->term->name = Str::replaceFirst("&amp;", "&", $item->term->name);

                return $item;
            });

            return $post;
        });

        return response()->json([
            'status' => 'ok',
            'count_with_location' => $posts->count(),
            'count' => $allPosts->count(),
            'code' => Response::HTTP_OK,
            'data' => $posts->values(),
            'links' => ['self' => route('api.projects.locations')],
        ], Response::HTTP_OK
        );
    }
}
