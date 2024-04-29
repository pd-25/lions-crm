<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 40; $i++) {
            $data = new Member();
            $data->name = $faker->title;
            $data->email = $faker->email;
            $data->join_date = $faker->date;
            $data->phone = $faker->phoneNumber;
            $data->slug = $faker->unique()->slug(3);


            $data->save();
        }
    }
}
