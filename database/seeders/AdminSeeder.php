<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Admin; // Adjust this path as per your structure
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => ' Leen Admin', // Change to your desired name
            'email' => 'admin@leen.com', // Change to your desired email
            'password' => Hash::make('12345678'), // Hash the password
        ]);
    }
}
