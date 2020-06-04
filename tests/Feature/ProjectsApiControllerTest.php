<?php


namespace Tests\Feature;


use Tests\TestCase;

class ProjectsApiControllerTest extends TestCase {

    public function testToCallProjectsWithCorrectAttributes()
    {
        $response = $this->get(route('api.projects'));
        $response->assertOk()
            ->assertDontSee('meta_key');
    }
}
