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
    public function test_a_admin_can_create_a_user()
    {
        $user = User::factory()->make();

        $response = $this->post(route('users.store'), [
            'names' => $user->names,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'role' => $user->role,
            'password' => 'password',
        ], $this->headers);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'names',
                'lastname',
                'email',
                'role',
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
                    'role',
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
                'email',
                'created_at',
                'updated_at'
            ]
        ]);

    }

    public function test_a_user_can_be_edited() {

        $user = User::factory()->create();
        $user->names = 'Fernando Jose';
        $user->lastname = 'Herrera Perez';

        $response = $this->put(route('users.update', ['user' => $user->id]), [
            'names' => $user->names,
            'lastname' => $user->lastname
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
        $this->assertDatabaseHas('users', [
            'names' => $user->names,
            'lastname' => $user->lastname
        ]);

    }


    public function test_a_user_can_be_deleted_by_id() {

        $user = User::factory()->create();

        $response = $this->get(route('users.destroy', ['user' => $user->id]), $this->headers);

        $response->assertSuccessful();

    }
}
