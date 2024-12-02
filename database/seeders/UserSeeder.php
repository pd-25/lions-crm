<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        User::truncate();

        DB::table("users")->insert([
            [
                'name' => 'Frontoffice',
                'slug' => 'lion2-receptionist',
                'email' => 'Frontoffice@lionsclub.com',
                'phone_number' => 9382930382,
                'address' => 'Nawadip, lions point',
                'password' => Hash::make('Front#321'),
                'role' => 1
            ],
            [
                'name' => 'Nandi',
                'slug' => 'lion3-receptionist',
                'email' => 'Nandi@lionsclub.com',
                'phone_number' => 9382930382,
                'address' => 'Nawadip, lions point',
                'password' => Hash::make('Employeetwo@12345'),
                'role' => 1
            ],
            [
                'name' => 'Puja',
                'slug' => 'lion4-receptionist',
                'email' => 'Puja@lionsclub.com',
                'phone_number' => 9382930382,
                'address' => 'Nawadip, lions point',
                'password' => Hash::make('Puja#lion21'),
                'role' => 1
            ]
        ]);
    }
}
