<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard Routes (Role-based)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $redirectRoute = match($user->role) {
            'admin' => 'dashboard.admin',
            'receptionist' => 'dashboard.receptionist',
            'doctor' => 'dashboard.doctor',
            default => 'dashboard.admin',
        };
        return redirect()->route($redirectRoute);
    })->name('dashboard');

    // Admin Dashboard
    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin', [
            'totalPatients' => \App\Models\Patient::count(),
            'todayAppointments' => \App\Models\Appointment::whereDate('date', today())->count(),
            'monthlyRevenue' => \App\Models\Billing::whereMonth('date', now()->month)->whereYear('date', now()->year)->where('status', 'paid')->sum('amount'),
            'activeDoctors' => \App\Models\Doctor::count(),
            'recentAppointments' => \App\Models\Appointment::with(['patient', 'doctor'])->orderBy('created_at', 'desc')->take(5)->get(),
            'notifications' => [],
        ]);
    })->middleware('role:admin')->name('dashboard.admin');

    // Receptionist Dashboard
    Route::get('/dashboard/receptionist', function () {
        return view('dashboard.receptionist', [
            'waitingRoomCount' => \App\Models\Appointment::where('date', today())->where('status', 'waiting')->count(),
            'todayAppointments' => \App\Models\Appointment::whereDate('date', today())->count(),
            'incomingPatients' => \App\Models\Appointment::with(['patient', 'doctor'])->where('date', today())->orderBy('time')->get(),
        ]);
    })->middleware('role:receptionist')->name('dashboard.receptionist');

    // Doctor Dashboard
    Route::get('/dashboard/doctor', function () {
        $doctorId = auth()->user()->doctor->id ?? null;
        return view('dashboard.doctor', [
            'completedToday' => \App\Models\Appointment::where('doctor_id', $doctorId)->whereDate('date', today())->where('status', 'completed')->count(),
            'remainingToday' => \App\Models\Appointment::where('doctor_id', $doctorId)->whereDate('date', today())->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'nextPatient' => \App\Models\Appointment::with('patient')->where('doctor_id', $doctorId)->where('date', today())->whereNotIn('status', ['completed', 'cancelled'])->orderBy('time')->first(),
            'patientQueue' => \App\Models\Appointment::with('patient')->where('doctor_id', $doctorId)->where('date', today())->orderBy('time')->get(),
        ]);
    })->middleware('role:doctor')->name('dashboard.doctor');
});

// Patient Routes (Admin & Receptionist)
Route::middleware(['auth', 'role:admin,receptionist'])->group(function () {
    Route::resource('patients', PatientController::class);
});

// Doctor Routes (Admin only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('doctors', DoctorController::class);
});

// Appointment Routes
Route::middleware(['auth'])->group(function () {
    // Admin & Receptionist: Full access
    Route::middleware('role:admin,receptionist')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
        Route::post('/appointments/check-availability', [AppointmentController::class, 'checkAvailabilityAjax'])->name('appointments.check-availability');
    });

    // Doctor: Read-only access to own appointments
    Route::middleware('role:doctor')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    });
});

// Billing Routes
Route::middleware(['auth'])->group(function () {
    // Admin & Receptionist: Full access
    Route::middleware('role:admin,receptionist')->group(function () {
        Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
        Route::get('/billing/create', [BillingController::class, 'create'])->name('billing.create');
        Route::post('/billing', [BillingController::class, 'store'])->name('billing.store');
        Route::get('/billing/{billing}/edit', [BillingController::class, 'edit'])->name('billing.edit');
        Route::put('/billing/{billing}', [BillingController::class, 'update'])->name('billing.update');
        Route::delete('/billing/{billing}', [BillingController::class, 'destroy'])->name('billing.destroy');
        Route::post('/billing/{billing}/mark-paid', [BillingController::class, 'markAsPaid'])->name('billing.mark-paid');
    });

    // All authenticated: View invoices
    Route::get('/billing/{billing}', [BillingController::class, 'show'])->name('billing.show');
    Route::get('/billing/{billing}/print', [BillingController::class, 'print'])->name('billing.print');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
