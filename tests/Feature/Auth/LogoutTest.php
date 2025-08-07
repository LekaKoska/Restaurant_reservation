<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    public function test_successfully_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/auth/logout');


        $this->assertDatabaseMissing('personal_access_tokens',
            [
                'tokenable_id' => $user->id
            ]);
        $response->assertJsonFragment(
            [
                'message' => 'Logged out successfully and token has been deleted'
            ]);
    }
}
