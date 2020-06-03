<?php

namespace App;

use Corcel\Model\Post as CorcelPost;

class Post extends CorcelPost {

    protected $connection = 'wordpress';
}
