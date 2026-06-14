<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    protected function adminUser()
    {
        return User::factory()->admin()->create();
    }

    public function test_admin_can_create_invoice()
    {
        $admin = $this->adminUser();
        $client = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $this->actingAs($admin);

        $response = $this->post('/admin/invoices', [
            'client_id' => $client->id,
            'project_id' => $project->id,
            'termin_percentage' => 30,
            'due_date' => now()->addMonth()->format('Y-m-d'),
            'items' => [
                ['item_name' => 'Pekerjaan 1', 'quantity' => 1, 'unit' => 'ls', 'price' => 5000000],
            ],
        ]);

        $response->assertRedirect('/admin/invoices');
        $this->assertDatabaseHas('invoices', [
            'project_id' => $project->id,
            'termin_percentage' => 30,
            'amount' => 5000000,
            'status' => 'sent',
        ]);
    }

    public function test_admin_can_send_invoice()
    {
        $admin = $this->adminUser();
        $invoice = Invoice::factory()->create(['status' => 'draft']);
        $this->actingAs($admin);

        $response = $this->post("/admin/invoices/{$invoice->id}/send");
        $response->assertRedirect();
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'sent',
        ]);
    }

    public function test_admin_can_mark_invoice_as_paid()
    {
        $admin = $this->adminUser();
        $invoice = Invoice::factory()->create(['status' => 'sent']);
        $this->actingAs($admin);

        $response = $this->post("/admin/invoices/{$invoice->id}/mark-paid");
        $response->assertRedirect();
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => 'paid',
        ]);
    }

    public function test_client_can_view_own_invoices()
    {
        $client = User::factory()->client()->create();
        $project = Project::factory()->create(['client_id' => $client->id]);
        $invoice = Invoice::factory()->create(['project_id' => $project->id]);
        $this->actingAs($client);

        $response = $this->get('/client/invoices');
        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
    }

    public function test_client_cannot_access_admin_invoice_routes()
    {
        $client = User::factory()->client()->create();
        $this->actingAs($client);

        $response = $this->get('/admin/invoices');
        $response->assertStatus(403);
    }
}
