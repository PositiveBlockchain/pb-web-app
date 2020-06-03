<?php


namespace Tests\Unit;


use Corcel\Database;
use Corcel\Model\Post;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WordPressDBConnectionTest extends TestCase {

    public function testCorcelDBConnection()
    {
        $params = array(
            'database'  => env('WP_DB_DATABASE'),
            'username'  => env('WP_DB_USERNAME'),
            'password'  => env('WP_DB_PASSWORD'),
            'prefix'    => env('WP_DB_PREFIX'),
        );
        Database::connect($params);
        $posts = Post::published()->get();
        $this->assertInstanceOf($posts->first(),Post::class);
    }


    public function testToConnect()
    {
        $query = "SELECT * from wp_377038_posts";
        $posts = DB::connection('wordpress')->select($query);
        $this->assertIsArray($posts);
        $this->assertTrue(count($posts) > 0);
    }



}
