<?php


namespace App\Helpers;


use App\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MetaFields {

    const LP_OPTIONS_FIELD = 'lp_listingpro_options_fields';
    const CREATION_YEAR_FIELD = 'creation_year';
    const ORGANIZATION_TYPE_FIELD = 'organization_type';
    const STAGE_FIELD = 'stage';

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

    /**
     * @param array $fields
     * @return Collection
     */
    public static function guessSameFieldsAndMergeValues(array $fields): Collection
    {
        $similarFields = collect([]);
        $fieldsLowerKeys = collect($fields)->mapWithKeys(function ($field, $originalKey) {
            $lowerCaseKey = Str::lower($originalKey);

            return [$lowerCaseKey => $field];
        });

        $matchedFields = $fieldsLowerKeys->map(function ($fieldValue, $key) use ($fieldsLowerKeys, $similarFields) {
            $newValue = $fieldValue;
            if (Str::startsWith($key, " "))
            {
                $trimmedkey = trim($key);
                if ($fieldsLowerKeys->has($trimmedkey))
                {
                    $newValue = $fieldValue + $fieldsLowerKeys[$trimmedkey];
                    $similarFields->put($trimmedkey, $newValue);
                }
            }

            return $newValue;
        });

        $similarFieldsKeys = $similarFields->mapWithKeys(function ($field, $key) {
            return [trim($key) => $field];
        });

        return $matchedFields
            ->forget($similarFieldsKeys->keys()->toArray())
            ->mapWithKeys(function ($field, $key) {
                return [trim($key) => $field];
            });
    }

}
