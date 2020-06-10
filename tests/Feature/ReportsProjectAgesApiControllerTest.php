<?php


namespace Tests\Feature;


use Tests\TestCase;

class ReportsProjectAgesApiControllerTest extends TestCase {

    public function testToCallReportsProjectsAgesEndpoint()
    {
        $response = $this->get(route('api.reports.projects_by_ages'));
        $structure = ['status', 'code', 'data'];
        $response->assertOk()
            ->assertJsonStructure($structure);
    }

}
