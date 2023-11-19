<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;


    public function testUserLogout()
    {

        $user = \App\Models\User::factory()->create([
            'access_token' => 'sample_access_token',
            'username' => 'sample_username',
        ]);

        $headers = ['access_token' => 'sample_access_token',];

        $response = $this->postJson('/api/logout', [], $headers);

        $response->assertStatus(200)
            ->assertJson([
                'msg' => 'Logged Out successfully',
            ]);
    }


    public function testLogoutWithIncorrectAccessToken()
    {
        $headers = [
            'access_token' => 'incorrect_access_token',
        ];

        $response = $this->postJson('/api/logout', [], $headers);

        $response->assertStatus(403)
            ->assertJson([
                'msg' => 'access token not correct',
            ]);
    }


    public function testLogoutWithoutAccessToken()
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(404)
            ->assertJson([
                'msg' => 'Access token not found.',
            ]);
    }
}