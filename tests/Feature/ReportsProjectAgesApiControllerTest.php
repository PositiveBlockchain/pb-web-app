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
        $response = $this->get(route('api.reports.projects_by_ages'));
        $structure = ['status', 'code', 'data'];
        $response->assertOk()
            ->assertJsonStructure($structure);
    }

}
