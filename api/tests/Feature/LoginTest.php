<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_using_the_login_form()
    {
        $user = User::factory()->create();
        
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->get(route('auth.sanctum'));

        $response = $this->post(route('auth.user'), $credentials);

        $response->assertAuthenticated();

        // $response->assertRedirect(route('newsPage'));
    }

    public function test_user_can_not_login_using_the_login_form()
    {
        $user = User::factory()->create();
        
        $credentials = [
            'email' => $user->email,
            'password' => 'test_password_wrong'
        ];

        $response = $this->post(route('auth.user'), $credentials);

        $response->assertStatus(404);
    }


    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->get(route('logout.user'));

        $response->assertStatus(200);
    }


}
