<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request): Booking
    {
        $validator = Validator::make(
            $request->all(),
            [
                'price' => 'required|decimal:2',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date',
                'client_id' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
    }
}
