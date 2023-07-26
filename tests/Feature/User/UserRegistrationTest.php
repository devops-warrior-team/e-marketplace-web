<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    //traits
    use RefreshDatabase;

    public function test_guest_user_can_view_register_page(): void
    {
        $response = $this->get('/user/register');

        $response->assertStatus(200);
    }

    public function test_guest_user_can_register(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // Simulate a POST request to the user registration endpoint
        $response = $this->post('/user/register', $data);
        
        // Assert that the user was successfully created in the database
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);

        // Assert that the user is redirected to the home page after registration
        $response->assertRedirect('/home');

    }
}
