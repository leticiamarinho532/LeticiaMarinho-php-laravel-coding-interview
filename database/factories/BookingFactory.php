<?php

namespace Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkInDate = fake()->dateTime('1 month ago');
        $checkOutDate = clone $checkInDate;
        $checkOutDate->add(new DateInterval('P1Y'));

        return [
            'price' => fake()->randomFloat(2, 10, 300),
            'check_in_date' => $checkInDate,
            'check_out_date' => fake()->dateTimeBetween($checkInDate, $checkOutDate),
        ];
    }
}
