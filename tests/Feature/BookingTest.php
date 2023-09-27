<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\AbstractDatabaseTestCase;

class BookingTest extends AbstractDatabaseTestCase
{
    /**
     * Test bookings list.
     */
    public function test_returns_a_list_of_bookings(): void
    {
        $response = $this->getJson('/api/bookings');

        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->has(Booking::count())
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

    /**
     * Test getting a booking.
     */
    public function test_getting_a_booking(): void
    {
        $booking = Booking::first();
        $response = $this->getJson("/api/bookings/$booking->id");

        $response->assertOk();
        $response->assertJson(fn(AssertableJson $json) => $json->where('id', $booking->id)
            ->where('price', $booking->price)
            ->where('check_in_date', $booking->check_in_date)
            ->where('check_out_date', $booking->check_out_date)
            ->where('client_id', $booking->client->id)
            ->etc()
        );
    }
}
