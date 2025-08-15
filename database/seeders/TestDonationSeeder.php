<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\User;
use App\Models\BloodGroup;
use App\Models\Institution;
use Carbon\Carbon;

class TestDonationSeeder extends Seeder
{
    public function run()
    {
        // Get or create an institution
        $institution = Institution::firstOrCreate([
            'name' => 'Test Hospital',
            'type' => 'hospital',
            'location' => 'Test City',
            'contact_number' => '1234567890',
            'email' => 'test@hospital.com'
        ]);

        // Get donors and blood groups
        $donors = User::where('role', 'donor')->take(5)->get();
        $bloodGroups = BloodGroup::all();

        if ($donors->count() > 0 && $bloodGroups->count() > 0) {
            // Create test donations
            for ($i = 0; $i < 15; $i++) {
                Donation::create([
                    'user_id' => $donors->random()->id,
                    'blood_group_id' => $bloodGroups->random()->id,
                    'institution_id' => $institution->id,
                    'volume_ml' => rand(400, 500),
                    'donation_date' => Carbon::now()->subDays(rand(1, 60)),
                    'created_by' => 1,
                    'updated_by' => 1
                ]);
            }
            
            $this->command->info('Added 15 test donations successfully!');
        } else {
            $this->command->error('No donors or blood groups found. Please seed users and blood groups first.');
        }
    }
} 