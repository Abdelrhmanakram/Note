<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;


    public function testSuccessfulLogin()
    {
        // Create a user for testing
        $user = \App\Models\User::factory()->create([
            'username' => 'jhon',
            'email' => 'john@example.com',
            'password' => bcrypt('12345678'),
            'access_token' => 'sample_access_token',
        ]);

        $payload = [
            'email' => 'john@example.com',
            'password' => '12345678',
            'access_token' => 'sample_access_token',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'welcome User Logged in successfully',


            ]);
    }


    public function testLoginWithIncorrectCredentials()
    {
        $payload = [
            'email' => 'john@example.com',
            'password' => 'incorrect_password',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'This account does not exist',
            ]);

    }

 
    public function testLoginWithNonExistingAccount()
    {
        $payload = [
            'email' => 'nonexisting@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $payload);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'This account does not exist',
            ]);
    }
}