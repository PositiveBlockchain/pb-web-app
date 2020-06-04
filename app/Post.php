<?php

namespace App;

use Corcel\Model\Post as CorcelPost;

class Post extends CorcelPost {

    protected $connection = 'wordpress';

    protected $hidden = [
        'type',
        'taxonomies',
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
        'post_date',
        'post_date_gmt',
        'post_parent',
        'post_modified',
        'post_modified_gmt',
        'image',
        'status',
        'excerpt',
        'keywords_str',
    ];
}
