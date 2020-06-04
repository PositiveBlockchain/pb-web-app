<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFieldRenamer;
use App\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProjectsIndexApiController extends Controller {

    public function __invoke()
    {
        $posts = Post::type('listing')->published()->limit(10)->get();
        $filteredPosts = $posts->map(function ($project) {
            if ($project->meta->count() > 0)
            {
                $listingMetaValues = $project->meta->filter(function ($value, $key) {
                    return $value->meta_key === 'lp_listingpro_options_fields';
                });
                $project->fields = MetaFieldRenamer::arrayKeyFromKebapToSnake(Arr::first($listingMetaValues)['value']);

                //remove all default meta data
                unset($project->meta);

                return $project;
            }
        });

        return response()->json($filteredPosts, Response::HTTP_OK);
    }
}
