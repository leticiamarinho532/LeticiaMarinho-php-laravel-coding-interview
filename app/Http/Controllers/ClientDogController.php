<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientDogController extends Controller
{
    /**
     * Client's dogs.
     *
     * @param Client $client
     *
     * @return Collection
     */
    public function index(Client $client): Collection
    {
        return $client->dogs();
    }

    /**
     * Create a dog.
     *
     * @param Request $request
     * @param Client $client
     *
     * @return JsonResponse
     */
    public function store(Request $request, Client $client): JsonResponse
    {
        $dog = new Dog($this->getValidatedData($request));
        $client->dogs()->save($dog);

        return response()->json($dog, 201);
    }

    /**
     * Get a dog.
     *
     * @param Client $client
     * @param int $dog
     *
     * @return Dog
     */
    public function show(Client $client, int $dog): Dog
    {
        return Dog::whereBelongsTo($client)->where('id', $dog)->firstOrFail();
    }

    /**
     * Update a dog.
     *
     * @param Request $request
     * @param Client $client
     * @param int $dog
     *
     * @return Dog
     */
    public function update(Request $request, Client $client, int $dog): Dog
    {
        $dog = Dog::whereBelongsTo($client)->where('id', $dog)->firstOrFail();
        $dog->update($this->getValidatedData($request));

        return $dog;
    }

    /**
     * Get validated data.
     *
     * @param Request $request
     *
     * @return array
     */
    private function getValidatedData(Request $request): array
    {
        return $request->validate([
            'name' => [
                ...(!$request->isMethod('PATCH') ? ['required'] : []),
                'max:255',
            ],
            'age' => [
                ...(!$request->isMethod('PATCH') ? ['required'] : []),
                'gte:1',
            ],
        ]);
    }
}
