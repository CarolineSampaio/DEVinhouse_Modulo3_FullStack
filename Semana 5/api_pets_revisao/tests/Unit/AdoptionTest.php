<?php

namespace Tests\Feature;

use App\Models\Adoption;
use App\Models\Breeds;
use App\Models\People;
use App\Models\Pet;
use App\Models\Specie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdoptionTest extends TestCase
{
    public function test_user_can_add_new_adoptions(): void
    {
        $specie = Specie::factory()->create();
        $breed = Breeds::factory()->create();
        $pet  = Pet::factory()->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);
        Pet::factory(20)->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);

        $body = [
            'name' => 'Caroline',
            'contact' => '8599181-1333',
            'email' => 'testing@email.com',
            'cpf' => '999.999.999-99',
            'observations' => 'This is a test observations',
            'pet_id' => $pet->id,
        ];

        $response = $this->post('/api/pets/adocao', $body);

        $this->assertDatabaseCount('adoptions', 1);
        $response->assertStatus(201)->assertJson([
            ...$body,
            'status' => 'PENDENTE',
        ]);
    }

    public function test_user_cannot_add_new_adoptions_without_name(): void
    {
        $specie = Specie::factory()->create();
        $breed = Breeds::factory()->create();
        $pet  = Pet::factory()->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);
        Pet::factory(20)->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);

        $body = [
            'name' => '',
            'contact' => '8599181-1333',
            'email' => 'testing@email.com',
            'cpf' => '999.999.999-99',
            'observations' => 'This is a test observations',
            'pet_id' => $pet->id,
        ];

        $response = $this->post('/api/pets/adocao', $body);

        $response->assertStatus(400)->assertJson([
            'message' => 'The name field must be a string. (and 1 more error)',
            'status' => 400,
            'errors' => [],
            'data' => []
        ]);
    }

    public function test_user_cannot_add_new_adoptions_without_contact(): void
    {
        $specie = Specie::factory()->create();
        $breed = Breeds::factory()->create();
        $pet  = Pet::factory()->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);
        Pet::factory(20)->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);

        $body = [
            'name' => 'Caroline',
            'contact' => '',
            'email' => 'testing@email.com',
            'cpf' => '999.999.999-99',
            'observations' => 'This is a test observations',
            'pet_id' => $pet->id,
        ];

        $response = $this->post('/api/pets/adocao', $body);

        $response->assertStatus(400)->assertJson([
            'message' => 'The contact field must be a string. (and 1 more error)',
            'status' => 400,
            'errors' => [],
            'data' => []
        ]);
    }

    public function test_user_cannot_add_new_adoptions_without_email(): void
    {
        $specie = Specie::factory()->create();
        $breed = Breeds::factory()->create();
        $pet  = Pet::factory()->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);
        Pet::factory(20)->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);

        $body = [
            'name' => 'Caroline',
            'contact' => '8599181-1333',
            'email' => '',
            'cpf' => '999.999.999-99',
            'observations' => 'This is a test observations',
            'pet_id' => $pet->id,
        ];

        $response = $this->post('/api/pets/adocao', $body);

        $response->assertStatus(400)->assertJson([
            'message' => 'The email field must be a string. (and 1 more error)',
            'status' => 400,
            'errors' => [],
            'data' => []
        ]);
    }

    public function test_user_cannot_add_new_adoptions_without_cpf(): void
    {
        $specie = Specie::factory()->create();
        $specie = Specie::factory()->create();
        $breed = Breeds::factory()->create();
        $pet  = Pet::factory()->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);
        Pet::factory(20)->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);

        $body = [
            'name' => 'Caroline',
            'contact' => '8599181-1333',
            'email' => 'testing@email.com',
            'cpf' => '',
            'observations' => 'This is a test observations',
            'pet_id' => $pet->id,
        ];

        $response = $this->post('/api/pets/adocao', $body);

        $response->assertStatus(400)->assertJson([
            'message' => 'The cpf field must be a string. (and 1 more error)',
            'status' => 400,
            'errors' => [],
            'data' => []
        ]);
    }

    public function test_user_cannot_add_new_adoptions_without_observations(): void
    {
        $specie = Specie::factory()->create();
        $specie = Specie::factory()->create();
        $breed = Breeds::factory()->create();
        $pet  = Pet::factory()->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);
        Pet::factory(20)->create(['breed_id' => $breed->id, 'specie_id' => $specie->id]);

        $body = [
            'name' => 'Caroline',
            'contact' => '8599181-1333',
            'email' => 'testing@email.com',
            'cpf' => '999.999.999-99',
            'observations' => '',
            'pet_id' => $pet->id,
        ];

        $response = $this->post('/api/pets/adocao', $body);

        $response->assertStatus(400)->assertJson([
            'message' => 'The observations field must be a string. (and 1 more error)',
            'status' => 400,
            'errors' => [],
            'data' => []
        ]);
    }
}
