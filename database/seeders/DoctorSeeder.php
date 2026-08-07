<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create([
            'name' => 'Dr. Michael Chen',
            'specialization' => 'Cardiology',
            'contact' => '+1-555-0101',
            'working_hours' => 'Mon-Fri 9AM-5PM',
        ]);

        Doctor::create([
            'name' => 'Dr. Emily Rodriguez',
            'specialization' => 'Neurology',
            'contact' => '+1-555-0102',
            'working_hours' => 'Mon-Fri 8AM-4PM',
        ]);

        Doctor::create([
            'name' => 'Dr. James Wilson',
            'specialization' => 'Orthopedics',
            'contact' => '+1-555-0103',
            'working_hours' => 'Tue-Sat 10AM-6PM',
        ]);

        Doctor::create([
            'name' => 'Dr. Sarah Thompson',
            'specialization' => 'General Medicine',
            'contact' => '+1-555-0104',
            'working_hours' => 'Mon-Fri 9AM-5PM',
        ]);
    }
}
