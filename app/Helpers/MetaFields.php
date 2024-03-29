<?php


namespace App\Helpers;


use App\Post;
use Corcel\Model\Meta\PostMeta;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MetaFields {

    const LP_OPTIONS_FIELD = 'lp_listingpro_options_fields';
    const CREATION_YEAR_FIELD = 'creation_year';
    const ORGANIZATION_TYPE_FIELD = 'organization_type';
    const SHORT_DESCRIPTION_FIELD = 'short_description';
    const TAGLINE_FIELD = 'tagline_text';
    const WEBSITE_FIELD = 'website';
    const LONG_DESCRIPTION_FIELD = 'description';
    const SERVICING_AREA_FIELD = 'servicing_area';
    const LOGO_FIELD = 'business_logo';
    const SDG_FIELD = 'sdg';
    const BLOCKCHAIN_TECH_FIELD = 'blockchain_technology';
    const CONTENT_FIELD = 'content';
    const CLAIMED_STATUS_FIELD = 'claimed_section';
    const STAGE_FIELD = 'stage';
    const META_KEY_FIELD = 'meta_key';
    const LP_META_OPTIONS = 'lp_listingpro_options';

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
        $deserialzedValues = $post->meta
            ->where(MetaFields::META_KEY_FIELD, MetaFields::LP_META_OPTIONS)
            ->first();

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
        if ($deserialzedValues instanceof PostMeta || is_array($deserialzedValues))
        {
            if (is_array($deserialzedValues->value))
            {
                $post->fields = array_merge(static::removeUnusedFields($deserialzedValues->value), static::removeUnusedFields($post->fields));
            }
            else
            {
                $post->fields = array_merge(static::removeUnusedFields([$deserialzedValues->value]), static::removeUnusedFields($post->fields));
            }
        }

        $post->links = ['self' => route('api.projects.show', $post->ID)];

        return $post;
    }

    /**
     * @param array $fields
     * @return array
     */
    static function removeUnusedFields(array $fields)
    {
        return collect($fields)->filter(function ($item, $key) {
            return !Str::of($key)->endsWith(['_mfilter', 'list_price', 'list_price_to', 'Plan_id', 'lp_purchase_days', 'reviews_ids', 'campaign_id', 'changed_planid', 'listing_reported_by', 'listing_reported', 'additional_information']);
        })->toArray();
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
