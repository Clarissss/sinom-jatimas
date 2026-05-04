<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_send_chat_message_in_own_project()
    {
        $client = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $this->actingAs($client);

        $response = $this->post("/projects/{$project->id}/chat", [
            'message' => 'Halo, ini pesan dari klien',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('chat_messages', [
            'project_id' => $project->id,
            'sender_id' => $client->id,
            'message' => 'Halo, ini pesan dari klien',
        ]);
    }

    public function test_admin_can_send_chat_message_in_any_project()
    {
        $admin = User::factory()->admin()->create();
        $project = Project::factory()->create();
        $this->actingAs($admin);

        $response = $this->post("/projects/{$project->id}/chat", [
            'message' => 'Halo dari admin',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('chat_messages', [
            'project_id' => $project->id,
            'sender_id' => $admin->id,
            'message' => 'Halo dari admin',
        ]);
    }

    public function test_client_cannot_send_chat_in_other_project()
    {
        $client = User::factory()->client()->create();
        $otherClient = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $otherClient->id]);
        $this->actingAs($client);

        $response = $this->post("/projects/{$project->id}/chat", [
            'message' => 'Ini seharusnya gagal',
        ]);

        $response->assertStatus(403);
    }

    public function test_unread_count_endpoint_works()
    {
        $client = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        ChatMessage::factory()->create([
            'project_id' => $project->id,
            'is_read' => false,
        ]);
        $this->actingAs($client);

        $response = $this->getJson("/projects/{$project->id}/chat/unread");
        $response->assertStatus(200);
        $response->assertJsonStructure(['count']);
    }
}
