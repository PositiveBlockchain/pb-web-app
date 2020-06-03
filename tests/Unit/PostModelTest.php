<?php


namespace Tests\Unit;


use App\Post;
use Corcel\Model\Meta\PostMeta;
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

    public function testToGetListingFieldsFromPostMeta()
    {
           $posts = PostMeta::where('meta_key', 'lp_listingpro_options_fields')->get();
        $this->assertTrue(count($posts) == 663);
    }


}
