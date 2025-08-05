<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create(
            [
                'password' => bcrypt("Password123")
            ]);

        $response = $this->postJson('/api/auth/login',
            [
                'email' => $user->email,
                'password' => 'Password123'
            ]);

        $response->assertCreated();

        $this->assertAuthenticated();
    }


    public function test_invalid_credentials_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login',
            [
                'email' => $user->email,
                'password' => 'wrong-password'
            ]);

        $response->assertStatus(403);

        $this->assertGuest();

        $response->assertJson(
            [
                'message' => 'Invalid credentials'
            ]);


    }

}
