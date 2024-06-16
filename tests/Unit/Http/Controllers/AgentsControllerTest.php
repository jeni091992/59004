<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Controllers\AgentsController;

class AgentsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsAgents()
    {
        // Arrange
        $agents = User::factory()->count(3)->create(['role' => 'agent']);

        // Act
        $response = $this->get(route('agents.index'));

        // Assert
        $response->assertStatus(302);

        $response->assertViewHas('agents.index');
        $response->assertViewHas('agents', function ($viewAgents) use ($agents) {
            return $viewAgents->count() === $agents->count();
        });
    }

    public function testStoreCreatesAgent()
    {
        // Arrange
        $request = Request::create('/agents', 'POST', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $controller = new AgentsController();

        // Act
        $response = $controller->store($request);

        // Assert
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'agent',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('agents.index'), $response->headers->get('Location'));
    }

    public function testUpdateModifiesAgent()
    {
        // Arrange
        $agent = User::factory()->create(['role' => 'agent']);

        $request = Request::create('/agents/' . $agent->id, 'PUT', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $controller = new AgentsController();

        // Act
        $response = $controller->update($request, $agent);

        // Assert
        $this->assertDatabaseHas('users', [
            'id' => $agent->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('agents.index'), $response->headers->get('Location'));
    }

    public function testDestroyDeletesAgent()
    {
        // Arrange
        $agent = User::factory()->create(['role' => 'agent']);

        $controller = new AgentsController();

        // Act
        $response = $controller->destroy($agent);

        // Assert
        $this->assertDatabaseMissing('users', ['id' => $agent->id]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('agents.index'), $response->headers->get('Location'));
    }
}
