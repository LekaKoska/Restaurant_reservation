<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
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
}
