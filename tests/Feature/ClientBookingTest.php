<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\AbstractDatabaseTestCase;

class ClientBookingTest extends AbstractDatabaseTestCase
{
    /**
     * Test client bookings list.
     */
    public function test_returns_a_list_of_client_bookings(): void
    {
        $client = Booking::first()->client;
        $response = $this->getJson("/api/clients/$client->id/bookings");

        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->has(Booking::whereBelongsTo($client)->count())
            ->each(fn(AssertableJson $json) => $json->whereAllType([
                'id' => 'integer',
                'price' => ['double', 'integer'],
                'check_in_date' => 'string',
                'check_out_date' => 'string',
                'client_id' => 'integer',
                'created_at' => 'string',
                'updated_at' => 'string',
            ]))
        );
    }
}
