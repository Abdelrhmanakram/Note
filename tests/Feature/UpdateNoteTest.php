<?php

namespace Tests\Feature;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateNoteTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateNoteWithValidToken()
    {
        $user = \App\Models\User::factory()->create( ['access_token' => 'sample_access_token','username' => 'sample_username']);

          $headers = ['access_token' => 'sample_access_token'];
        $token = $headers['access_token'];

        $note = Note::factory()->create(['user_id' => $user->id]);

        $updatedTitle = 'Updated Title';
        $updatedContent = 'Updated Content';

       $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/notes/' . $note->id, [
            'title' => $updatedTitle,
            'content' => $updatedContent,
            'user_id' => $user->id,
        ]);
        $response->assertStatus(401);

    }

    public function testUpdateNoteWithoutToken()
    {
        $user = \App\Models\User::factory()->create(['username' => 'sample_username']);

        $note = Note::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson('/api/notes/{id}' . $note->id, [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'user_id' => 1, 
        ]);

        $response->assertStatus(401);
    }
}

