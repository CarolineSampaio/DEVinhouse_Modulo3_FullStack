<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_admin_can_login()
    {
        $response = $this->post('/api/login', [
            'email' => env("DEFAULT_EMAIL"),
            'password' => env("DEFAULT_PASSWORD")
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            "message" => "Autorizado",
            "status" => 201,
            'data' => [
                "token" => true,
                "permissions" => true,
                "name" => true,
                "profile" => "ADMIN"
            ]
        ]);
    }

    public function test_user_admin_permissions_load_correct()
    {
        $response = $this->post('/api/login', [
            'email' => env("DEFAULT_EMAIL"),
            'password' => env("DEFAULT_PASSWORD")
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'data' => [
                'permissions' => [
                    'create-races',
                    'get-races',
                    'create-species',
                    'get-species',
                    'delete-species',
                    'create-pets',
                    'get-pets',
                    'delete-pets',
                    'create-professionals',
                    'get-professionals',
                    'create-users',
                    'export-pdf-pets',
                    'create-vaccines',
                ]
            ]
        ]);
    }

    public function test_user_vet_permissions_load_correct()
    {
        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'data' => [
                'permissions' => [
                    "create-races",
                    "get-races",
                    "create-species",
                    "get-species",
                    "delete-species",
                    "create-pets",
                    "get-pets",
                    "delete-pets",
                    "create-vaccines"
                ]
            ]
        ]);
    }


    public function test_user_receptionist_permissions_load_correct()
    {
        $user = User::factory()->create(['profile_id' => 3, 'password' => '12345678']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'data' => [
                'permissions' => [
                    "create-pets",
                    "get-races",
                    "get-pets",
                    "delete-pets",
                    "export-pet-pets",
                    "create-clients",
                    "get-clients",
                    "get-species"
                ]
            ]
        ]);
    }

    public function test_check_bad_request_login_api_response(): void
    {
        $response = $this->post('/api/login', [
            'email' => env("DEFAULT_EMAIL"),
            'password' => "12345678"
        ]);

        $response->assertStatus(401);

        $response->assertJson([
            "message" => "Credenciais inválidas",
            "status" => 401,
            "errors" => [],
            "data" => []
        ]);
    }

    /*
    VALIDAR LOGOUT

    public function test_make_logout_in_application(): void
    {
        $this->seed(Profiles::class);
        $this->seed(InitialUser::class);

        $user = User::factory()->create(['profile_id' => 1, ]);

        $response = $this->actingAs($user)->post('/api/logout');

        $response->assertStatus(204);

    }
    */
}
