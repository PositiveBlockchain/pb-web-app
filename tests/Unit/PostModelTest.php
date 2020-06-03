<?php


namespace Tests\Unit;


use App\Post;
use Tests\TestCase;

class PostModelTest extends TestCase {

    public function testToGetPosts()
    {
        $posts = Post::all();
        $this->assertTrue(count($posts) > 0);
    }

    public function testToGetAllPostsWithListingType()
    {
        $posts = Post::type('listing')->get();
        $this->assertTrue(count($posts) == 877);
    }



}
