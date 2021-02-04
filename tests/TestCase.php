<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    protected $client, $user, $token, $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            '/'
        );
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $this->client->id,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        $this->user = User::factory()->create(['role' => 'ADMIN']);
        $this->token = $this->user->createToken('TestToken', [])->accessToken;

        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer ' . $this->token;
    }
}
