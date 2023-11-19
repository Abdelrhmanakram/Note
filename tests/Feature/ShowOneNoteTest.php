<?php

namespace Tests\Feature;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowOneNoteTest extends TestCase
{
    use RefreshDatabase;

    public function testShowOneNoteWithAccessToken()
    {
        $user = \App\Models\User::factory()->create(['username' => 'sample_username']);
        $token = $user->createToken('test-token')->plainTextToken;

        $note = Note::factory()->create(['user_id' => $user->id]);


        // Access token not found
        $response = $this->getJson('/api/notes/{id}' . $note->id);
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        // Incorrect access token
        $headers = [
            'Authorization' => 'Bearer invalid_token',
        ];

        $response = $this->getJson('/api/notes/{id}' . $note->id, $headers);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);

        // Correct access token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/notes/{id}');

        $response->assertStatus(404);
    }

}
