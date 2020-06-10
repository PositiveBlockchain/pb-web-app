<?php


namespace App\Helpers;


use App\Post;
use Illuminate\Support\Arr;

class MetaFields {

    const LP_OPTIONS_FIELD = 'lp_listingpro_options_fields';
    const CREATION_YEAR_FIELD = 'creation_year';
    const ORGANIZATION_TYPE_FIELD = 'organization_type';

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
            $value = $fieldValues['value'];
            if (is_array($value))
            {
                $post->fields = MetaFieldRenamer::arrayKeyFromKebapToSnake($fieldValues['value']);
            }
            if (is_string($value))
            {
                $post->fields = [$value];
            }
        }

        $post->links = ['self' => route('api.projects.show', $post->ID)];

        return $post;
    }

}
