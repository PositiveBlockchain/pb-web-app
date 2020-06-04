<?php

namespace App\Http\Controllers;

use App\Helpers\MetaFieldRenamer;
use App\Helpers\MetaFields;
use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProjectsShowApiController extends Controller {

    /**
     * @param int $id
     */
    public function __invoke(int $id)
    {
        try
        {
            $post = Post::findOrFail($id);
            $listingMetaValues = MetaFields::filterListingMetaFields($post, MetaFields::LP_OPTIONS_FIELD);
            $post = MetaFields::appendMetaFields($listingMetaValues, $post);
            unset($post->meta);

            return response()->json([
                'status' => 'ok',
                'code' => Response::HTTP_OK,
                'data' => $post,
                'endpoint' => route('api.projects.show', $id),
            ]);
        }
        catch (ModelNotFoundException $exception)
        {
            return response()->json([
                'status' => 'error',
                'code' => Response::HTTP_NOT_FOUND,
                'data' => ['id' => $id],
                'endpoint' => route('api.projects.show', $id),
            ]);
        }
    }
}
