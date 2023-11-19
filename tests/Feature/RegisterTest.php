<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulRegistration()
    {
        $payload = [
            'username' => 'john_doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => 'You Registered successfully',

            ]);
    }

  
    public function testRegistrationWithValidationErrors()
    {
        $payload = [
            'username' => 'john_doe',
            'email' => 'invalid_email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'email',
                ],
            ]);
    }
}
