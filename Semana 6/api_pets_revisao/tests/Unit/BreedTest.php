<?php

namespace Tests\Feature;

use App\Models\Breeds;
use App\Models\User;
use Tests\TestCase;

class BreedTest extends TestCase
{
    public function test_user_can_add_new_Breed(): void
    {
        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->actingAs($user)->post('/api/breeds', ['name' => 'Gato']);

        $response->assertStatus(201);
        $response->assertJson([
            'name' => 'Gato',
            'id' => true,
            'created_at' => true,
            'updated_at' => true
        ]);
    }

    public function test_user_cannot_create_breed_with_invalid_name(): void
    {
        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->actingAs($user)->post('/api/breeds', ['name' => 1]);

        $response->assertStatus(400);
        $response->assertJson([
            "message" => "The name field must be a string.",
            "status" => 400,
            "errors" => [],
            "data" => []
        ]);
    }

    public function test_user_cannot_create_breed_without_name(): void
    {
        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->actingAs($user)->post('/api/breeds', ['name' => " "]);

        $response->assertStatus(400);
        $response->assertJson([
            "message" => "The name field is required.",
            "status" => 400,
            "errors" => [],
            "data" => []
        ]);
    }

    public function test_user_can_list_all_Breeds()
    {
        Breeds::factory(5)->create();

        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);
        $response = $this->actingAs($user)->get('/api/breeds');

        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'created_at',
                'updated_at',
                'name',
                'id'
            ]
        ]);
    }
}
