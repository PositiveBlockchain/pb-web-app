<?php


namespace App\Helpers;


use App\Post;
use Illuminate\Support\Arr;

class MetaFields {

    const LP_OPTIONS_FIELD = 'lp_listingpro_options_fields';

    /**
     * @param Post $post
     * @param string $filter
     * @return mixed
     */
    public static function filterListingMetaFields(Post $post, string $filter)
    {
        return $post->meta->filter(function ($value) use ($filter) {
            return $value->meta_key === $filter;
        });
    }

    /**
     * @param $listingMetaValues
     * @param Post $post
     * @return Post
     */
    public static function appendMetaFields($listingMetaValues, Post $post): Post
    {
        $fieldValues = Arr::first($listingMetaValues);
        if (is_null($fieldValues))
        {
            $post->fields = [];
        }
        else
        {
            $post->fields = MetaFieldRenamer::arrayKeyFromKebapToSnake($fieldValues['value']);
        }

        $post->resource_link = route('api.projects.show', $post->ID);

        return $post;
    }

}
