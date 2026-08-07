<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'doctor') {
            $appointments = Appointment::where('doctor_id', $user->doctor->id ?? null)
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->paginate(10);
        } else {
            $appointments = Appointment::with(['patient', 'doctor'])
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->paginate(10);
        }
        
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        
        // Generate available dates for the next 14 days
        $availableDates = [];
        for ($i = 0; $i < 14; $i++) {
            $date = now()->addDays($i);
            $availableDates[] = [
                'day' => $date->format('D'),
                'date' => $date->format('j'),
                'full_date' => $date->format('Y-m-d'),
                'selected' => $i === 0,
            ];
        }
        
        // Generate time slots
        $morningSlots = [
            ['time' => '09:00 AM', 'available' => true],
            ['time' => '09:30 AM', 'available' => true],
            ['time' => '10:00 AM', 'available' => true],
            ['time' => '10:30 AM', 'available' => true],
            ['time' => '11:00 AM', 'available' => false],
            ['time' => '11:30 AM', 'available' => true],
        ];
        
        $afternoonSlots = [
            ['time' => '02:00 PM', 'available' => true],
            ['time' => '02:30 PM', 'available' => true],
            ['time' => '03:00 PM', 'available' => true],
            ['time' => '03:30 PM', 'available' => false],
            ['time' => '04:00 PM', 'available' => true],
            ['time' => '04:30 PM', 'available' => true],
        ];
        
        return view('appointments.create', compact(
            'patients', 
            'doctors', 
            'availableDates', 
            'morningSlots', 
            'afternoonSlots'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        // Check availability before creating
        $isAvailable = $this->checkAvailability(
            $request->doctor_id,
            $request->date,
            $request->time
        );
        
        if (!$isAvailable) {
            return back()->withInput()
                ->with('error', 'The selected doctor is not available at this time. Please choose a different time slot.');
        }
        
        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'time' => $request->time,
            'reason' => $request->reason,
            'status' => $request->status ?? 'scheduled',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    /**
     * Check if a doctor is available at a given date/time.
     */
    public function checkAvailability($doctorId, $date, $time)
    {
        $existingAppointment = Appointment::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('time', $time)
            ->whereNotIn('status', ['cancelled'])
            ->first();
        
        return !$existingAppointment;
    }

    /**
     * AJAX endpoint to check availability.
     */
    public function checkAvailabilityAjax(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required|string',
        ]);
        
        $isAvailable = $this->checkAvailability(
            $request->doctor_id,
            $request->date,
            $request->time
        );
        
        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable 
                ? 'This time slot is available.' 
                : 'This time slot is already booked. Please choose another time.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'billing']);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'reason' => 'nullable|string|max:500',
            'status' => 'nullable|in:scheduled,confirmed,completed,cancelled',
        ]);

        // If changing date/time, check availability
        if ($appointment->date != $validated['date'] || $appointment->time != $validated['time'] || $appointment->doctor_id != $validated['doctor_id']) {
            $isAvailable = $this->checkAvailability(
                $validated['doctor_id'],
                $validated['date'],
                $validated['time']
            );
            
            // Exclude current appointment from check
            $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
                ->where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->where('id', '!=', $appointment->id)
                ->whereNotIn('status', ['cancelled'])
                ->first();
            
            if ($conflict) {
                return back()->withInput()
                    ->with('error', 'The selected doctor is not available at this time. Please choose a different time slot.');
            }
        }

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled successfully.');
    }
}
