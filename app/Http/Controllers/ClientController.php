<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Clients list.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Client::all();
    }

    /**
     * Create a client.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(Client::create($this->getValidatedData($request)), 201);
    }

    /**
     * Get a client.
     *
     * @param Client $client
     *
     * @return Client
     */
    public function show(Client $client): Client
    {
        return $client;
    }

    /**
     * Update a client.
     *
     * @param Request $request
     * @param Client $client
     *
     * @return Client
     */
    public function update(Request $request, Client $client): Client
    {
        $client->update($this->getValidatedData($request));

        return $client;
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
            'username' => [
                ...($request->isMethod('PATCH') ? ['required'] : []),
                'unique:clients',
                'max:50',
            ],
            'name' => [
                ...(!$request->isMethod('PATCH') ? ['required'] : []),
                'max:200',
            ],
            'email' => [
                ...(!$request->isMethod('PATCH') ? ['required'] : []),
                'max:250',
            ],
            'phone' => 'max:20',
        ]);
    }
}
