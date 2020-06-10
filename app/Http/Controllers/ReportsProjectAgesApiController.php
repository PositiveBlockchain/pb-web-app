<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ReportsProjectAgesApiController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $posts = Post::type('listing')->published()->get();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => $this->filteredPosts($posts, MetaFields::LP_OPTIONS_FIELD),
            'link' => ['self' => route('api.reports.projects_by_ages')],
        ], Response::HTTP_OK
        );
    }

    /**
     * @param Collection $posts
     * @param string $filter
     * @return Collection
     */
    private function filteredPosts(Collection $posts, string $filter): Collection
    {
        return $posts->map(function ($post) use ($filter) {
            if ($post->meta->count() > 0)
            {
                $listingMetaValues = MetaFields::filterListingMetaFields($post, $filter);

                $post = MetaFields::appendMetaFields($listingMetaValues, $post);

                //remove all default meta data
                unset($post->meta);
            }

            return $post;
        });
    }
}
