<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientBookingController extends Controller
{
    /**
     * Get client's bookings.
     *
     * @param Client $client
     *
     * @return Collection
     */
    public function index(Client $client): Collection
    {
        return $client->bookings;
    }

    /**
     * Get a booking.
     *
     * @param Booking $booking
     *
     * @return Booking
     */
    public function show(Booking $booking): Booking
    {
        return $booking;
    }
}
