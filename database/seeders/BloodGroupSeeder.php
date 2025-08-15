<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ← THIS is what was missing

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('blood_groups')->insert([
            ['name' => 'A+', 'description' => 'A positive'],
            ['name' => 'A-', 'description' => 'A negative'],
            ['name' => 'B+', 'description' => 'B positive'],
            ['name' => 'B-', 'description' => 'B negative'],
            ['name' => 'AB+', 'description' => 'AB positive'],
            ['name' => 'AB-', 'description' => 'AB negative'],
            ['name' => 'O+', 'description' => 'O positive'],
            ['name' => 'O-', 'description' => 'O negative'],
        ]);
    }
}
