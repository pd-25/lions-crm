<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Factory::create();
        // for ($i = 1; $i <= 4; $i++) {
        //     $data = new User();
        //     $data->name = $faker->name();
        //     // $data->slug = $faker->unique()->slug(3);
        //     $data->email = $faker->email;
        //     $data->phone_number = $faker->phoneNumber;
        //     $data->address = $faker->address;
        //     $data->password = Hash::make('12345678');
        //     $data->save();
        // }

        //Receptionist user
        User::create([
            'name' => 'Lion Receptionist',
            'slug' => 'lion-receptionist',
            'email' => 'recep@mail.com',
            'phone_number' => 9382930382,
            'address' => 'Nawadip, lions point',
            'password' => Hash::make('12345678'),
            'role' => 1
        ]);



       
    }
}
