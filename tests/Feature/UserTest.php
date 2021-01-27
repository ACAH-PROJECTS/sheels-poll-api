<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /* @test */
    public function test_a_user_can_be_created()
    {
        $user = User::factory()->make();

        $response = $this->post(route('users.store'), [
            'names' => $user->names,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'password' => $user->password,
        ], $this->headers);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'names',
                'lastname',
                'email',
                'created_at',
                'updated_at'
            ],
            'meta' => [
                'success',
                'message'
            ]
        ]);
    }

    /* @test */
    public function test_users_can_be_listed()
    {

        $user = User::factory()->create();

        $response = $this->get(route('users.index'), $this->headers);

        $response->assertSuccessful();
        $response->assertSee($user->id);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'names',
                    'lastname',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ],
            'meta' => [
                'count'
            ]
        ]);
    }

    public function test_can_get_a_user_by_id() {

        $user = User::factory()->create();

        $response = $this->get(route('users.show', ['user' => $user->id]), $this->headers);

        $response->assertSuccessful();
        $response->assertSee($user->names);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'names',
                'lastname',
                'email'
            ]
        ]);

    }


    public function test_a_user_can_be_deleted_by_id() {

        $user = User::factory()->create();

        $response = $this->get(route('users.destroy', ['user' => $user->id]), $this->headers);

        $response->assertSuccessful();

    }

    public function test_an_user_can_register() {

        $user = User::factory()->make();

        $response = $this->post(route('auth.register'), [
            'names' => $user->names,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'token'
        ]);

    }
}
