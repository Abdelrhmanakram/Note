<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Note;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteNoteWithAccessToken()
    {
        $user = \App\Models\User::factory()->create(['access_token' => 'sample_access_token', 'username' => 'sample_username']);


        $note = Note::factory()->create(['user_id' => $user->id]);
        $headers = ['access_token' => 'sample_access_token',];
        $token = $headers['access_token'];


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->delete('/api/notes/{id}' . $note->id);

        $response->assertStatus(404);

    }

    public function testDeleteNoteWithoutAccessToken()
    {

        $user = \App\Models\User::factory()->create(['username' => 'sample_username']);

        $note = Note::factory()->create(['user_id' => $user->id]);

        $response = $this->delete('/api/notes/{id}' . $note->id);

        $response->assertStatus(404);

    }

}
