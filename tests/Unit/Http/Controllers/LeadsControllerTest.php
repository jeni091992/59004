<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LeadsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users for testing
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->agent = User::factory()->create(['role' => 'agent']);
    }

    public function test_index_displays_all_leads_for_admin()
    {
        Auth::login($this->admin);

        Lead::factory()->count(5)->create();

        $response = $this->get(route('leads.index'));

        $response->assertStatus(200);
        $response->assertViewIs('leads.index');
        $response->assertViewHas('leads');
    }

    public function test_index_displays_only_agent_leads_for_agent()
    {
        Auth::login($this->agent);

        Lead::factory()->create(['agent_id' => $this->agent->id]);
        Lead::factory()->create(); // Lead not assigned to agent

        $response = $this->get(route('leads.index'));

        $response->assertStatus(200);
        $response->assertViewIs('leads.index');
        $this->assertCount(1, $response->viewData('leads'));
    }

    public function test_create_displays_create_view()
    {
        Auth::login($this->admin);

        $response = $this->get(route('leads.create'));

        $response->assertStatus(200);
        $response->assertViewIs('leads.create');
        $response->assertViewHas('agents');
    }

    public function test_store_creates_lead()
    {
        Auth::login($this->admin);

        $agent = User::factory()->create(['role' => 'agent']);
        $leadData = [
            'name' => 'Test Lead',
            'email' => 'testlead@example.com',
            'phone' => '1234567890',
            'agent_id' => $agent->id,
        ];

        $response = $this->post(route('leads.store'), $leadData);

        $response->assertRedirect(route('leads.index'));
        $response->assertSessionHas('success', 'Lead created successfully.');

        $this->assertDatabaseHas('leads', $leadData);
    }

    public function test_edit_displays_edit_view()
    {
        Auth::login($this->admin);

        $lead = Lead::factory()->create();

        $response = $this->get(route('leads.edit', $lead));

        $response->assertStatus(200);
        $response->assertViewIs('leads.edit');
        $response->assertViewHas('lead', $lead);
        $response->assertViewHas('agents');
    }

    public function test_update_updates_lead()
    {
        Auth::login($this->admin);

        $lead = Lead::factory()->create();
        $updatedData = [
            'name' => 'Updated Lead',
            'email' => 'updatedlead@example.com',
            'phone' => '0987654321',
            'stage' => 'Qualified'
        ];

        $response = $this->put(route('leads.update', $lead), $updatedData);

        $response->assertRedirect(route('leads.index'));
        $response->assertSessionHas('success', 'Lead updated successfully.');

        $lead->refresh();

        $this->assertEquals('Updated Lead', $lead->name);
        $this->assertEquals('updatedlead@example.com', $lead->email);
        $this->assertEquals('0987654321', $lead->phone);
        $this->assertEquals('Qualified', $lead->stage);
    }

    public function test_destroy_deletes_lead()
    {
        Auth::login($this->admin);

        $lead = Lead::factory()->create();

        $response = $this->delete(route('leads.destroy', $lead));

        $response->assertRedirect(route('leads.index'));
        $response->assertSessionHas('success', 'Lead deleted successfully.');

        $this->assertDatabaseMissing('leads', ['id' => $lead->id]);
    }

    
}
