<?php

namespace App;

use Corcel\Model\Option;
use Corcel\Model\Post as CorcelPost;
use Illuminate\Database\Eloquent\Builder;

class Post extends CorcelPost {

    protected $connection = 'wordpress';

    protected $dates = [
        'post_date',
        'post_modified',
    ];

    protected $casts = [
        'post_date' => 'datetime:d-m-Y',
        'post_modified' => 'datetime:d-m-Y',
    ];

    protected $hidden = [
        'type',
        'countries',
        'url',
        'slug',
        'terms',
        'guid',
        'comment_count',
        'comment_status',
        'post_title',
        'post_name',
        'post_author',
        'post_content',
        'mime_type',
        'author_id',
        'parent_id',
        'post_status',
        'post_password',
        'menu_order',
        'post_mime_type',
        'post_excerpt',
        'post_type',
        'to_ping',
        'ping_status',
        'pinged',
        'post_content_filtered',
        'post_date_gmt',
        'post_parent',
        'post_modified_gmt',
        'image',
        'status',
        'excerpt',
        'keywords_str',
    ];

    public function __construct()
    {
        parent::__construct();
        // append via the constructor and not via class protected property $appends
        // otherwise all appends from parent are lost
        array_push($this->appends, 'permalink');
    }

    /**
     * @return mixed|null
     */
    public function getPermalinkAttribute()
    {
        return Option::get('siteurl') . '/database/' . $this->slug . '/';
    }

    /**
     * @param $query Builder
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereRaw('post_date < post_modified AND post_type = "listing"');
    }

    /**
     * @param Builder $query
     * @param int $limit
     * @return Builder
     */
    public function scopeMostActive(Builder $query, int $limit): Builder
    {
        return $query->whereRaw('post_date < post_modified AND post_type = "listing" order by post_modified desc limit ' . $limit);
    }

}
