<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create([
            'name' => 'John Smith',
            'age' => 45,
            'gender' => 'male',
            'contact' => '+1-555-0201',
            'email' => 'john.smith@email.com',
            'address' => '123 Main St, City, State',
            'medical_notes' => 'Allergic to penicillin. History of hypertension.',
        ]);

        Patient::create([
            'name' => 'Mary Johnson',
            'age' => 32,
            'gender' => 'female',
            'contact' => '+1-555-0202',
            'email' => 'mary.johnson@email.com',
            'address' => '456 Oak Ave, City, State',
            'medical_notes' => 'No known allergies. Regular checkup.',
        ]);

        Patient::create([
            'name' => 'Robert Davis',
            'age' => 58,
            'gender' => 'male',
            'contact' => '+1-555-0203',
            'email' => 'robert.davis@email.com',
            'address' => '789 Pine Rd, City, State',
            'medical_notes' => 'Type 2 diabetes. Takes metformin.',
        ]);

        Patient::create([
            'name' => 'Lisa Anderson',
            'age' => 28,
            'gender' => 'female',
            'contact' => '+1-555-0204',
            'email' => 'lisa.anderson@email.com',
            'address' => '321 Elm St, City, State',
            'medical_notes' => 'Asthma. Uses inhaler as needed.',
        ]);

        Patient::create([
            'name' => 'David Brown',
            'age' => 67,
            'gender' => 'male',
            'contact' => '+1-555-0205',
            'email' => 'david.brown@email.com',
            'address' => '654 Maple Dr, City, State',
            'medical_notes' => 'Arthritis. Previous knee surgery.',
        ]);
    }
}
