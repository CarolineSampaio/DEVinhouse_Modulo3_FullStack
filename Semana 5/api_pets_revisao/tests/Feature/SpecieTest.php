<?php

namespace Tests\Feature;

use App\Models\Breeds;
use App\Models\Pet;
use App\Models\Specie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpecieTest extends TestCase
{
    public function test_user_can_list_species(): void
    {
        Specie::factory(5)->create();
        $this->assertDatabaseCount('species', 5);

        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);
        $response = $this->actingAs($user)->get('/api/species');

        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    public function test_user_can_create_specie(): void
    {
        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);
        $response = $this->actingAs($user)->post('/api/species', ['name' => 'Test Specie']);

        $response->assertStatus(201)->assertJson([
            'name' => 'Test Specie',
            'id' => true,
            'created_at' => true,
            'updated_at' => true
        ]);
    }

    public function test_cannot_create_specie_without_name(): void
    {
        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->actingAs($user)->post('/api/species', ['name' => " "]);

        $response->assertStatus(500);
        $response->assertJson([
            "message" => "The name field is required.",
            "status" => 500,
            "errors" => [],
            "data" => []
        ]);
    }

    public function test_user_can_delete_specie(): void
    {
        $specie = Specie::factory()->create();

        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->actingAs($user)->delete("/api/species/{$specie->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('species', ['id' => $specie->id]);
    }

    public function test_user_can_delete_specie_with_other_species_database(): void
    {
        Specie::factory(10)->create();
        $specieCreated = Specie::factory()->create();

        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->actingAs($user)->delete("/api/species/{$specieCreated->id}");

        $this->assertDatabaseCount('species', 10);
        $this->assertDatabaseMissing('species', ['id' => $specieCreated->id]);
        $response->assertStatus(204);
    }

    public function test_use_can_delete_specie_with_pet(): void
    {
        $specie = Specie::factory()->create();
        $breed = Breeds::factory()->create();
        Pet::factory()->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);

        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);
        $response = $this->actingAs($user)->delete("/api/species/$specie->id");

        $response->assertStatus(409);
        $response->assertJson([
            'status' => 409,
            'message' => 'Não é possível remover a espécie, pois existem animais cadastrados com ela!',
            'errors' => [],
            'data' => []
        ]);
        $this->assertDatabaseHas('species', ['id' =>  $specie->id]);
    }
}
