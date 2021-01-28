<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    public function test_a_user_can_register() {

        $user = User::factory()->make();

        $response = $this->post(route('auth.register'), [
            'names' => $user->names,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'token'
        ]);

    }

    public function test_a_user_can_be_logged() {

        $response = $this->post(route('auth.login'), [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'token'
        ]);

    }

    public function test_a_user_can_logout() {

        $response = $this->post(route('auth.logout'), [], $this->headers);

        $response->assertSuccessful();

    }
}
