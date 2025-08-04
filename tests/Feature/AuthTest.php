<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;


    public function test_register_new_user()
    {


       $response = $this->post('/api/auth/register',
       [
           'name' => "Test",
           'email' => "test@gmail.com",
           'password' => 'Password123',
           'password_confirmation' => 'Password123'

       ]);

       $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
        ]);


    }

    public function test_invalid_password_format()
    {
        $response = $this->postJson('api/auth/register',
            [
                'name' => "Test",
                'email' => 'leka@gmail.com',
                'password' => '123',
                'password_confirmation' => '123'
            ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrorFor('password');

    }

    public function test_invalid_email_format()
    {
        $response = $this->postJson('api/auth/register',
            [
                'name' => "Test",
                'email' => 'wrong-email@wrongemail.doesntexist',
                'password' => "Password123",
                'password_confirmation' => "Password123"
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor("email");
    }

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
