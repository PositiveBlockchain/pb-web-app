<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFields;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ReportsProjectAgesApiController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $posts = Post::type('listing')->published()->get();
        $projectYears = $this->filteredPosts($posts, MetaFields::LP_OPTIONS_FIELD)
            ->map(function ($post) {
                if (!Arr::exists($post->fields, MetaFields::CREATION_YEAR_FIELD)
                    || empty($post->fields[MetaFields::CREATION_YEAR_FIELD])
                    || !is_numeric($post->fields[MetaFields::CREATION_YEAR_FIELD])
                )
                {
                    $fields = $post->fields;
                    $fields[MetaFields::CREATION_YEAR_FIELD] = 'unkown';
                    $post->fields = $fields;
                }

                return $post->fields;
            })->groupBy(MetaFields::CREATION_YEAR_FIELD)->map->count();

        return response()->json([
            'status' => 'ok',
            'code' => Response::HTTP_OK,
            'data' => $projectYears,
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
