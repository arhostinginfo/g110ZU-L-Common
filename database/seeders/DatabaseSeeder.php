<?php

namespace Database\Seeders;

use App\Models\Admin;  
use App\Models\Taluka;  
use App\Models\District;  

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

        Admin::create(
            [
                'employee_email' => 'BJAsrkasjUYTz7n52353n48arQMwtngu@gmail.com',
                'employee_password' => Hash::make('iQaKJASLIjsiouraiosuIUIO3wHgw9tm'),
            ]

        );

        District::create(
            [
                'district_name' => 'Nasik',
            ]

        );


        Taluka::create(
            [
                'district_id' => '1',
                'taluka_name' => 'Nandgaon',
            ]

        );

        
    }
}
