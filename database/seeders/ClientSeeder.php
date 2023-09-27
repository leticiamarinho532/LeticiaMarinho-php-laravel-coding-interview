<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Dog;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Start with 5 clients
        Client::factory(5)->create()->each(static function (Client $client) {
            // Create dogs
            $dogs = Dog::factory(random_int(1, 3))->make();
            $client->dogs()->saveMany($dogs);

            // Create bookings
            $bookings = Booking::factory(random_int(1, 5))->make();
            $client->bookings()->saveMany($bookings);
        });
    }
}
