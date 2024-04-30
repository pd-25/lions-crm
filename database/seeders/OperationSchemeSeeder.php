<?php

namespace Database\Seeders;

use App\Models\OperationScheme;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationSchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 11; $i++) {
            $data = new OperationScheme();
            $data->name = $faker->name();
            $data->price = $faker->numberBetween($min = 500, $max = 1000);
            $data->slug = $faker->unique()->slug(3);
            $data->save();
        }
    }
}
