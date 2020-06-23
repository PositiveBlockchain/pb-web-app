<?php


namespace Tests\Feature;


use Tests\TestCase;

class ProjectsApiControllerTest extends TestCase {

    public function testToCallProjectsWithCorrectAttributes()
    {
        $response = $this->get(route('api.projects.index'));
        $response->assertOk()
            ->assertDontSee('meta_key');
    }

    public function testToCallProjectsShowApiEndpoint()
    {
        $response = $this->get(route('api.projects.show', 62));
        $structure = ['status', 'code', 'data', 'links'];
        $response->assertOk()
            ->assertJsonStructure($structure);
    }

}
