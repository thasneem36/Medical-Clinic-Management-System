<?php

namespace Database\Seeders;

use App\Models\Billing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Billing::create([
            'patient_id' => 1,
            'doctor_id' => 1,
            'appointment_id' => 1,
            'amount' => 150.00,
            'status' => 'paid',
            'payment_method' => 'credit_card',
            'notes' => 'Consultation fee',
            'date' => now()->subDays(5)->toDateString(),
        ]);

        Billing::create([
            'patient_id' => 2,
            'doctor_id' => 2,
            'appointment_id' => 2,
            'amount' => 200.00,
            'status' => 'pending',
            'payment_method' => 'insurance',
            'notes' => 'Neurology consultation',
            'date' => now()->subDays(2)->toDateString(),
        ]);

        Billing::create([
            'patient_id' => 3,
            'doctor_id' => 3,
            'appointment_id' => 3,
            'amount' => 175.00,
            'status' => 'pending',
            'payment_method' => 'cash',
            'notes' => 'Orthopedic evaluation',
            'date' => now()->toDateString(),
        ]);

        Billing::create([
            'patient_id' => 4,
            'doctor_id' => 4,
            'amount' => 125.00,
            'status' => 'paid',
            'payment_method' => 'credit_card',
            'notes' => 'General consultation',
            'date' => now()->subWeek()->toDateString(),
        ]);
    }
}
