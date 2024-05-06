<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $data = [
           [
            'slug' => $faker->unique()->slug(3), 
            'type_name' => 'General Outdoor', 
            'price' => 200,
            'status' => 1
           ],
           [
            'slug' => $faker->unique()->slug(3), 
            'type_name' => 'Operation', 
            'price' => 5000,
            'status' => 1
           ],
           [
            'slug' => $faker->unique()->slug(3), 
            'type_name' => 'Eye Checkup', 
            'price' => 500,
            'status' => 1
           ],
        ];
        DB::table('booking_types')->insert($data);
    }
}
