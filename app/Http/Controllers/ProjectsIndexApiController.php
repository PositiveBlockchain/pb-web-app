<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFieldRenamer;
use App\Helpers\MetaFields;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProjectsIndexApiController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $limit = 10; // default limit
        if ($request->has('limit'))
        {
            $limit = $request->get('limit');
        }
        $posts = Post::type('listing')->published()->limit($limit)->get();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => $this->filteredPosts($posts, MetaFields::LP_OPTIONS_FIELD),
            'endpoint' => route('api.projects.index'),
        ], Response::HTTP_OK
        );
    }

    /**
     * @param $posts
     * @param string $filter
     * @return mixed
     */
    private function filteredPosts($posts, string $filter)
    {
        return $posts->map(function ($post) use ($filter) {
            if ($post->meta->count() > 0)
            {
                $listingMetaValues = MetaFields::filterListingMetaFields($post, $filter);

                $post = MetaFields::appendMetaFields($listingMetaValues, $post);

                //remove all default meta data
                unset($post->meta);

                return $post;
            }
        });
    }

}
