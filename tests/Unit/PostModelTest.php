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
        $postMeta = PostMeta::where('meta_key', 'lp_listingpro_options_fields')->get();
        $emptyPostMeta = $postMeta->where('meta_value', '!=', "");
        $this->assertTrue(count($postMeta) == 663);
        $this->assertTrue(count($emptyPostMeta) == 505);
    }

    public function testToUnserializeMetaValue()
    {
        $postMeta = PostMeta::where('meta_key', 'lp_listingpro_options_fields')
                    ->where('meta_value', '!=', "")->get()->first();
        $value = unserialize($postMeta->meta_value);
        $this->assertInstanceOf('something', $value);
    }


}
