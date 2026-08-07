<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::create([
            'patient_id' => 1,
            'doctor_id' => 1,
            'date' => now()->toDateString(),
            'time' => '09:00 AM',
            'reason' => 'Follow-up checkup',
            'status' => 'confirmed',
        ]);

        Appointment::create([
            'patient_id' => 2,
            'doctor_id' => 2,
            'date' => now()->toDateString(),
            'time' => '10:30 AM',
            'reason' => 'Headache consultation',
            'status' => 'scheduled',
        ]);

        Appointment::create([
            'patient_id' => 3,
            'doctor_id' => 3,
            'date' => now()->toDateString(),
            'time' => '02:00 PM',
            'reason' => 'Knee pain evaluation',
            'status' => 'waiting',
        ]);

        Appointment::create([
            'patient_id' => 4,
            'doctor_id' => 4,
            'date' => now()->addDay()->toDateString(),
            'time' => '11:00 AM',
            'reason' => 'Asthma follow-up',
            'status' => 'scheduled',
        ]);

        Appointment::create([
            'patient_id' => 5,
            'doctor_id' => 1,
            'date' => now()->addDays(2)->toDateString(),
            'time' => '09:30 AM',
            'reason' => 'Cardiac evaluation',
            'status' => 'scheduled',
        ]);
    }
}
