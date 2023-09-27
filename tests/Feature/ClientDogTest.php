<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Dog;
use Generator;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\AbstractDatabaseTestCase;

class ClientDogTest extends AbstractDatabaseTestCase
{
    /**
     * Test client dogs list.
     */
    public function test_returns_a_list_of_client_dogs(): void
    {
        $client = Dog::first()->client;
        $response = $this->getJson("/api/clients/$client->id/dogs");

        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->has(Dog::whereBelongsTo($client)->count())
            ->each(fn(AssertableJson $json) => $json->whereAllType([
                'id' => 'integer',
                'client_id' => 'integer',
                'name' => 'string',
                'age' => 'integer',
                'created_at' => 'string',
                'updated_at' => 'string',
            ]))
        );
    }

    /**
     * Test get client's dog.
     */
    public function test_getting_a_clients_dog(): void
    {
        $dog = Dog::first();
        $client = $dog->client;
        $response = $this->getJson("/api/clients/$client->id/dogs/$dog->id");

        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $dog->id)
            ->where('name', $dog->name)
            ->where('age', $dog->age)
            ->where('client_id', $client->id)
            ->etc()
        );
    }

    /**
     * Test creating a client's dog successfully.
     *
     * @dataProvider dogsDataProvider
     *
     * @param string $name
     * @param int $age
     */
    public function test_creating_a_clients_dog_successfully(string $name, int $age): void
    {
        $client = Client::first();
        $nDogs = Dog::count();
        $response = $this->postJson(
            "/api/clients/$client->id/dogs",
            [
                'name' => $name,
                'age' => $age,
            ]
        );

        $response->assertCreated();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $nDogs + 1)
            ->where('name', $name)
            ->where('age', $age)
            ->where('client_id', $client->id)
            ->etc()
        );
    }

    /**
     * Test failing creating a client's dog.
     */
    public function test_failure_creating_a_clients_dog(): void
    {
        $client = Client::first();
        $response = $this->postJson("/api/clients/$client->id/dogs");

        $response->assertUnprocessable();
        $response->assertJson(fn(AssertableJson $json) => $json->where('message', 'The name field is required. (and 1 more error)')
            ->has('errors', fn(AssertableJson $json) => $json->where('name.0', 'The name field is required.')
                ->where('age.0', 'The age field is required.'))

        );
    }

    /**
     * Test updating a client's dog successfully.
     *
     * @dataProvider dogsDataProvider
     *
     * @param string $name
     * @param int $age
     */
    public function test_updating_a_clients_dog_successfully(string $name, int $age): void
    {
        $client = Client::factory()->create();
        $client->dogs()->saveMany(Dog::factory(2)->make());
        $dogs = $client->dogs;

        // Just update name
        $response = $this->patchJson(
            "/api/clients/{$dogs[0]->client->id}/dogs/{$dogs[0]->id}",
            [
                'name' => $name,
            ]
        );
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $dogs[0]->id)
            ->where('name', $name)
            ->where('age', $dogs[0]->age)
            ->where('client_id', $dogs[0]->client->id)
            ->etc()
        );

        // Just update age
        $response = $this->patchJson(
            "/api/clients/{$dogs[1]->client->id}/dogs/{$dogs[1]->id}",
            [
                'age' => $age,
            ]
        );
        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $dogs[1]->id)
            ->where('name', $dogs[1]->name)
            ->where('age', $age)
            ->where('client_id', $dogs[1]->client->id)
            ->etc()
        );
    }

    /**
     * Dogs data provider.
     *
     * @return Generator
     */
    public function dogsDataProvider(): Generator
    {
        for ($i = 0; $i < 1; $i++) {
            yield [
                $this->faker('en')->firstName(),
                $this->faker('en')->numberBetween(3, 10),
            ];
        }
    }
}
