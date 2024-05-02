<?php

namespace Database\Seeders;

use App\Models\RegisterBooking;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegisterBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 40; $i++) {
            $data = new RegisterBooking();
            $data->slug = $faker->unique()->slug(3);
            $data->booking_id = $this->generateUniqueBookingId();
            $data->amount = 100;
            $data->user_id = User::all()->random()->id;
            $data->save();
        }
    }

    private function generateUniqueBookingId(): int
    {
        $prefix = rand(100, 999); // Adding a random 3-digit prefix
        $random_number = rand(100000, 999999); // Generate a random 6-digit number
        $booking_id = $prefix . sprintf("%06d", $random_number); // Concatenate and format to ensure 6 digits

        // Check if the generated booking ID already exists in the database
        $existing_booking = RegisterBooking::where('booking_id', $booking_id)->exists();

        // If the generated booking ID already exists, recursively call the function to generate a new one
        if ($existing_booking) {
            return $this->generateUniqueBookingId();
        }

        return intval($booking_id); // Convert to integer
    }
}
