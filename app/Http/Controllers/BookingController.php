<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

class BookingController extends Controller
{
    /**
     * Get all bookings.
     *
     * @return Collection
     */
    public function index()
    {
        return Booking::all();
    }
}
