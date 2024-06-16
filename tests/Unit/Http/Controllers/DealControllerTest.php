<?php

namespace Tests\Feature;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DealControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker; // If you need faker for generating random data

    protected function setUp(): void
    {
        parent::setUp();

        // Create users for testing
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->agent = User::factory()->create(['role' => 'agent']);
    }

    public function test_store_creates_deal()
    {
        // Given
        $lead = Lead::factory()->create([
            'name' => 'Test Lead',
            'email' => 'testlead@example.com',
            'phone' => '1234567890',
            'agent_id' => $this->agent->id,
        ]);

        $dealData = [
            'lead_id' => $lead->id,
            'deal_value' => 5000,
        ];

        // When
        $response = $this->actingAs($this->admin)->post(route('deals.store'), $dealData);

        // Then
        $response->assertRedirect(route('leads.index'));
        $response->assertSessionHas('success', 'Deal created successfully.');

        $this->assertDatabaseHas('deals', [
            'lead_id' => $lead->id,
            'deal_value' => 5000,
        ]);
    }

    public function test_index_displays_all_deals_for_admin()
    {
        // Given
        $deal1 = Deal::factory()->create(['agent_id' => $this->agent->id]);
        $deal2 = Deal::factory()->create();

        // When
        $response = $this->actingAs($this->admin)->get(route('deals.index'));

        // Then
        $response->assertStatus(200);
        $response->assertViewIs('deals.index');
        $response->assertSee($deal1->name);
        $response->assertDontSee($deal2->name);
    }

    public function test_edit_displays_edit_view()
    {
        // Given
        $deal = Deal::factory()->create();

        // When
        $response = $this->actingAs($this->admin)->get(route('deals.edit', $deal->id));

        // Then
        $response->assertStatus(200);
        $response->assertViewIs('deals.edit');
        $response->assertViewHas('deal', $deal);
    }

    public function test_update_updates_deal()
    {
        // Given
        $deal = Deal::factory()->create();
        $newAgent = User::factory()->create(['role' => 'agent']);

        // When
        $response = $this->actingAs($this->admin)->put(route('deals.update', $deal->id), [
            'name' => 'Updated Deal Name',
            'email' => 'updated@example.com',
            'phone' => '9876543210',
            'message' => 'Updated message',
            'agent_id' => $newAgent->id,
            'deal_value' => 7000,
        ]);

        // Then
        $response->assertRedirect(route('deals.index'));
        $response->assertSessionHas('success', 'Deal updated successfully.');

        $deal->refresh();

        $this->assertEquals('Updated Deal Name', $deal->name);
        $this->assertEquals('updated@example.com', $deal->email);
        $this->assertEquals('9876543210', $deal->phone);
        $this->assertEquals('Updated message', $deal->message);
        $this->assertEquals($newAgent->id, $deal->agent_id);
        $this->assertEquals(7000, $deal->deal_value);
    }

    public function test_destroy_deletes_deal()
    {
        // Given
        $deal = Deal::factory()->create();

        // When
        $response = $this->actingAs($this->admin)->delete(route('deals.destroy', $deal->id));

        // Then
        $response->assertRedirect(route('deals.index'));
        $response->assertSessionHas('success', 'Deal deleted successfully.');

        $this->assertDatabaseMissing('deals', ['id' => $deal->id]);
    }
}
