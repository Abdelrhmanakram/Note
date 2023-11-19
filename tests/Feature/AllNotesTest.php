<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllNotesTest extends TestCase
{
    use RefreshDatabase;

    public function testAllNotesExistWithToken()
    {
        $user = User::factory()->create(['username' => 'sample_username',]);
        $token = $user->createToken('test-token')->plainTextToken;

        // Create notes associated with the user
        $notes = Note::factory()->count(3)->create(['user_id' => $user->id]);


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/notes');

        $response->assertStatus(404)->assertJsonCount(1);
    }

    public function testAllNotesWithoutToken()
    {
        $response = $this->getJson('/api/notes');

        $response->assertStatus(404);
    }
}

