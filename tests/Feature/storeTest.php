<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class storeTest extends TestCase
{
    public function testStoreNoteWithAccessToken()
    {
        $user = \App\Models\User::factory()->create(['username' => 'sample_username']);
        $token = $user->createToken('test-token')->plainTextToken;


        // Access token not found
        $response = $this->postJson('/api/notes');
        $response->assertStatus(404)
            ->assertJson([
                'msg' => 'Access token not found.',
            ]);


        // Incorrect access token
        $headers = [
            'Authorization' => 'Bearer invalid_token',
        ];

        $response = $this->withHeaders($headers)
            ->postJson('/api/notes');

        $response->assertStatus(404)
            ->assertJson([
                'msg' => 'Access token not found.',
            ]);


        // Incorrect request data
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];

        $invalidData = [
            'title' => 'Note Title',
            //
            'user_id' => $user->id,
        ];

        $response = $this->withHeader('$invalidData', '$headers')
            ->postJson('/api/notes');

        $response->assertStatus(404)
            ->assertJson([
                'msg' => 'Access token not found.',
            ]);

        // Correct request data
        $validData = [
            'title' => 'Note Title',
            'content' => 'Note Content',
            'user_id' => $user->id,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/notes');

        $response->assertStatus(404)
            ->assertJson([

            ]);
    }

}
