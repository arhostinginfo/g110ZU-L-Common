<?php

namespace Database\Seeders;

use App\Models\Employees;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Employees::create(
            [
                'employee_email' => 'BYuVOmAvjoz7nn48arQMwtngu@gmail.com',
                'employee_password' => Hash::make('iQa08cCYSs6bB8R6W3wHgw9tm'),
            ]

        );

        
    }
}
