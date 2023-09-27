<?php

namespace Tests\Feature;

use App\Models\Client;
use Generator;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\AbstractDatabaseTestCase;

class ClientTest extends AbstractDatabaseTestCase
{
    /**
     * Test client list.
     */
    public function test_returns_a_list_of_clients(): void
    {
        $response = $this->getJson('/api/clients');

        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->has(5)
            ->each(fn(AssertableJson $json) => $json->whereAllType([
                'id' => 'integer',
                'username' => 'string',
                'name' => 'string',
                'email' => 'string',
                'phone' => 'string',
                'created_at' => 'string',
                'updated_at' => 'string',
            ]))
        );
    }

    /**
     * Test getting a client.
     */
    public function test_getting_a_client(): void
    {
        $client = Client::first();
        $response = $this->getJson("/api/clients/$client->id");

        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $client->id)
            ->where('username', $client->username)
            ->where('name', $client->name)
            ->where('email', $client->email)
            ->where('phone', $client->phone)
            ->etc()
        );
    }

    /**
     * Test creating a client successfully.
     *
     * @dataProvider clientsDataProvider
     *
     * @param string $username
     * @param string $name
     * @param string $email
     * @param string $phone
     */
    public function test_creating_a_client_successfully(string $username, string $name, string $email, string $phone): void
    {
        $response = $this->postJson(
            '/api/clients',
            [
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ]
        );

        $response->assertCreated();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', 6)
            ->where('username', $username)
            ->where('name', $name)
            ->where('email', $email)
            ->where('phone', $phone)
            ->whereType('created_at', 'string')
            ->whereType('updated_at', 'string')
        );
    }

    /**
     * Test failing creating a client.
     */
    public function test_failure_creating_a_client(): void
    {
        $response = $this->postJson('/api/clients');

        $response->assertUnprocessable();
        $response->assertJson(fn(AssertableJson $json) => $json->where('message', 'The username field is required. (and 2 more errors)')
            ->has('errors', fn(AssertableJson $json) => $json->where('username.0', 'The username field is required.')
                ->where('name.0', 'The name field is required.')
                ->where('email.0', 'The email field is required.'))

        );
    }

    /**
     * Test updating a client successfully.
     *
     * @dataProvider clientsDataProvider
     *
     * @param string $username
     * @param string $name
     * @param string $email
     * @param string $phone
     */
    public function test_updating_a_client_successfully(string $username, string $name, string $email, string $phone): void
    {
        $clients = Client::all();

        // Just update username
        $response = $this->patchJson(
            "/api/clients/{$clients[0]->id}",
            [
                'username' => $username,
            ]
        );
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $clients[0]->id)
            ->where('username', $username)
            ->where('name', $clients[0]->name)
            ->where('email', $clients[0]->email)
            ->where('phone', $clients[0]->phone)
            ->whereType('created_at', 'string')
            ->whereType('updated_at', 'string')
        );

        // Just update name
        $response = $this->patchJson(
            "/api/clients/{$clients[1]->id}",
            [
                'name' => $name,
            ]
        );
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $clients[1]->id)
            ->where('username', $clients[1]->username)
            ->where('name', $name)
            ->where('email', $clients[1]->email)
            ->where('phone', $clients[1]->phone)
            ->whereType('created_at', 'string')
            ->whereType('updated_at', 'string')
        );

        // Just update email
        $response = $this->patchJson(
            "/api/clients/{$clients[2]->id}",
            [
                'email' => $email,
            ]
        );
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $clients[2]->id)
            ->where('username', $clients[2]->username)
            ->where('name', $clients[2]->name)
            ->where('email', $email)
            ->where('phone', $clients[2]->phone)
            ->whereType('created_at', 'string')
            ->whereType('updated_at', 'string')
        );

        // Just update phone
        $response = $this->patchJson(
            "/api/clients/{$clients[3]->id}",
            [
                'phone' => $phone,
            ]
        );
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $clients[3]->id)
            ->where('username', $clients[3]->username)
            ->where('name', $clients[3]->name)
            ->where('email', $clients[3]->email)
            ->where('phone', $phone)
            ->whereType('created_at', 'string')
            ->whereType('updated_at', 'string')
        );
    }

    /**
     * Clients data provider.
     *
     * @return Generator
     */
    public function clientsDataProvider(): Generator
    {
        for ($i = 0; $i < 5; $i++) {
            yield [
                $this->faker('en')->userName(),
                $this->faker('en')->firstName(),
                $this->faker('en')->email(),
                $this->faker('en')->e164PhoneNumber(),
            ];
        }
    }
}
