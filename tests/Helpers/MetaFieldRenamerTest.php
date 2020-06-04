<?php


namespace Tests\Helpers;


use App\Helpers\MetaFieldRenamer;
use Tests\TestCase;

class MetaFieldRenamerTest extends TestCase {

    public function testToRenameKebapCase()
    {
        $kebapArray = ['hello-my-name' => 'Some value', 'this-is-my-key' => 123];
        $snakeArray = MetaFieldRenamer::arrayKeyFromKebapToSnake($kebapArray);
        $this->assertArrayHasKey('hello_my_name', $snakeArray);
        $this->assertArrayHasKey('this_is_my_key', $snakeArray);
    }

}
