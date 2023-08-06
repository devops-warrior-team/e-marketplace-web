<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticateWithGoogleAccountTest extends TestCase
{
    use RefreshDatabase;

    protected function boot_mocker($type, $social_account_id) {

        $mock_user = Mockery::mock('Laravel\Socialite\Two\User');
        $mock_user
            ->shouldReceive('getId')
            ->andReturn($social_account_id)
            ->shouldReceive('getName')
            ->andReturn(Str::random(10))
            ->shouldReceive('getEmail')
            ->andReturn(Str::random(10) . '@gmail.com')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');
    
        $mock_provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $mock_provider
            ->shouldReceive('user')
            ->andReturn($mock_user);
        $mock_provider
            ->shouldReceive('stateless')
            ->andReturn($mock_provider);
    
        Socialite::shouldReceive('driver')
            ->with($type)
            ->andReturn($mock_provider)
            ->once();
    }

    public function test_new_user_login_via_social_oauth_google() {
        $type = 'google';
        $social_key = 'social->' . $type;
        $social_account_id = Str::random(10);

        $this->assertDatabaseMissing('users', [
            $type.'_id' => $social_account_id,
        ]);

        $this->boot_mocker($type, $social_account_id);

        $response = $this->get('/auth/google/callback');
        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
            
        /*$token_from_request_cookie = $response->headers->getCookies()[0]->getValue();
        $auth_response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token_from_request_cookie
            ])
            ->get(route('auth.user.show'));

        $auth_response->assertStatus(200);
        */
    }
}
