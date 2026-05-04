<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_access_own_project()
    {
        $client = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $this->actingAs($client);

        $response = $this->get("/client/projects/{$project->id}");
        $response->assertStatus(200);
        $response->assertViewIs('client.projects.show');
    }

    public function test_client_cannot_access_other_client_project()
    {
        $client = User::factory()->client()->create();
        $otherClient = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $otherClient->id]);
        $this->actingAs($client);

        $response = $this->get("/client/projects/{$project->id}");
        $response->assertStatus(403);
    }

    public function test_client_dashboard_shows_own_projects()
    {
        $client = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        Project::factory()->create(); // other client's project
        $this->actingAs($client);

        $response = $this->get('/client/dashboard');
        $response->assertStatus(200);
        $response->assertSee($project->name);
    }
}
