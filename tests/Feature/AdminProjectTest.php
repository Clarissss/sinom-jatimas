<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function adminUser()
    {
        return User::factory()->admin()->create();
    }

    public function test_admin_can_access_project_index()
    {
        $admin = $this->adminUser();
        $this->actingAs($admin);

        $response = $this->get('/admin/projects');
        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.index');
    }

    public function test_admin_can_create_project()
    {
        $admin = $this->adminUser();
        $client = User::factory()->client()->create();
        $this->actingAs($admin);

        $response = $this->post('/admin/projects', [
            'name' => 'Proyek Baru',
            'client_id' => $client->id,
            'description' => 'Deskripsi proyek',
            'location' => 'Jakarta',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'status' => 'in_progress',
            'progress_percentage' => 0,
            'contract_value' => 10000000,
        ]);

        $response->assertRedirect('/admin/projects');
        $this->assertDatabaseHas('projects', [
            'name' => 'Proyek Baru',
            'client_id' => $client->id,
        ]);
    }

    public function test_admin_can_update_project()
    {
        $admin = $this->adminUser();
        $project = Project::factory()->create();
        $this->actingAs($admin);

        $response = $this->put("/admin/projects/{$project->id}", [
            'name' => 'Proyek Updated',
            'client_id' => $project->client_id,
            'description' => $project->description,
            'location' => $project->location,
            'start_date' => $project->start_date?->format('Y-m-d'),
            'end_date' => $project->end_date?->format('Y-m-d'),
            'status' => $project->status,
            'progress_percentage' => $project->progress_percentage,
            'contract_value' => $project->contract_value,
        ]);

        $response->assertRedirect('/admin/projects');
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Proyek Updated',
        ]);
    }

    public function test_admin_can_delete_project()
    {
        $admin = $this->adminUser();
        $project = Project::factory()->create();
        $this->actingAs($admin);

        $response = $this->delete("/admin/projects/{$project->id}");
        $response->assertRedirect('/admin/projects');
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_client_cannot_access_admin_project_routes()
    {
        $client = User::factory()->client()->create();
        $this->actingAs($client);

        $response = $this->get('/admin/projects');
        $response->assertStatus(403);
    }
}
