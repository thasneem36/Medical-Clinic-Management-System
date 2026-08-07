# Current Project Documentation

## Project Overview
This is a **Medical Clinic Management System** built with Laravel 12.0. The application manages patients, doctors, appointments, and billing with role-based access control for different user types.

## Technology Stack

### Backend
- **Framework**: Laravel 12.0
- **PHP Version**: ^8.2
- **Database**: SQLite (default)
- **Authentication**: Laravel Breeze ^2.4
- **Queue**: Database driver
- **Cache**: Database driver
- **Session**: Database driver

### Frontend
- **CSS Framework**: TailwindCSS ^3.1.0
- **Build Tool**: Vite ^7.0.7
- **JavaScript**: Alpine.js ^3.4.2
- **HTTP Client**: Axios ^1.11.0
- **Forms**: @tailwindcss/forms ^0.5.2

### Development Tools
- **Testing**: PHPUnit ^11.5.50
- **Code Style**: Laravel Pint ^1.24
- **Development Server**: Laravel Sail ^1.41
- **Logging**: Laravel Pail ^1.2.2
- **Faker**: ^1.23

## Project Structure

```
thasneem/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AppointmentController.php
│   │   │   ├── BillingController.php
│   │   │   ├── DoctorController.php
│   │   │   ├── PatientController.php
│   │   │   ├── ProfileController.php
│   │   │   └── Auth/ (Laravel Breeze authentication)
│   │   ├── Middleware/
│   │   │   └── CheckRole.php (Role-based access control)
│   │   └── Requests/
│   │       ├── StoreAppointmentRequest.php
│   │       ├── StoreBillingRequest.php
│   │       ├── StoreDoctorRequest.php
│   │       ├── StorePatientRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Models/
│   │   ├── User.php (Authentication with roles)
│   │   ├── Patient.php
│   │   ├── Doctor.php
│   │   ├── Appointment.php
│   │   └── Billing.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_08_06_190942_add_role_to_users_table.php
│   │   ├── 2026_08_06_191009_create_patients_table.php
│   │   ├── 2026_08_06_191011_create_doctors_table.php
│   │   ├── 2026_08_06_191016_create_appointments_table.php
│   │   └── ├── 2026_08_06_191017_create_billings_table.php
│   ├── factories/
│   │   └── UserFactory.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── appointments/ (Appointment management views)
│   │   ├── auth/ (Authentication views)
│   │   ├── billing/ (Billing/invoice views)
│   │   ├── components/ (Blade components)
│   │   ├── dashboard/ (Role-specific dashboards)
│   │   ├── layouts/ (Layout templates)
│   │   ├── patients/ (Patient management views)
│   │   ├── profile/ (User profile views)
│   │   ├── dashboard.blade.php
│   │   └── welcome.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       ├── app.js
│       └── bootstrap.js
├── routes/
│   ├── web.php (Main application routes)
│   ├── auth.php (Authentication routes)
│   └── console.php
├── config/ (Laravel configuration files)
├── public/ (Public assets)
├── storage/ (Application storage)
└── tests/ (Test files)
```

## Database Schema

### Users Table
- **id**: Primary key
- **name**: User name
- **email**: Unique email address
- **role**: Enum ('admin', 'receptionist', 'doctor') - default: 'receptionist'
- **password**: Hashed password
- **email_verified_at**: Timestamp
- **remember_token**: Token for "remember me" functionality
- **timestamps**: created_at, updated_at

### Patients Table
- **id**: Primary key
- **name**: Full patient name
- **age**: Integer (0-150)
- **gender**: String ('male', 'female', 'other')
- **contact**: Phone number (max 20 chars)
- **email**: Nullable email address
- **address**: Nullable text
- **medical_notes**: Nullable text (max 2000 chars)
- **timestamps**: created_at, updated_at

### Doctors Table
- **id**: Primary key
- **name**: Doctor name
- **specialization**: Medical specialization
- **contact**: Contact information (max 20 chars)
- **working_hours**: Working hours description (max 100 chars)
- **timestamps**: created_at, updated_at

### Appointments Table
- **id**: Primary key
- **patient_id**: Foreign key to patients (cascade delete)
- **doctor_id**: Foreign key to doctors (cascade delete)
- **date**: Appointment date
- **time**: Appointment time
- **reason**: Nullable text (max 500 chars)
- **status**: Enum ('scheduled', 'confirmed', 'completed', 'cancelled', 'waiting') - default: 'scheduled'
- **timestamps**: created_at, updated_at

### Billings Table
- **id**: Primary key
- **patient_id**: Foreign key to patients (cascade delete)
- **doctor_id**: Foreign key to doctors (cascade delete)
- **appointment_id**: Nullable foreign key to appointments (cascade delete)
- **amount**: Decimal (10,2)
- **status**: Enum ('paid', 'pending', 'overdue') - default: 'pending'
- **payment_method**: String ('credit_card', 'cash', 'insurance', 'bank_transfer')
- **notes**: Nullable text (max 1000 chars)
- **date**: Billing date
- **timestamps**: created_at, updated_at

## Model Relationships

### User Model
- Uses `HasFactory` and `Notifiable` traits
- Extends `Authenticatable`
- **fillable**: name, email, password
- **hidden**: password, remember_token
- **casts**: email_verified_at → datetime, password → hashed

### Patient Model
- **fillable**: name, age, gender, contact, address, medical_notes
- **Relationships**:
  - `appointments()`: hasMany(Appointment::class)
  - `billings()`: hasMany(Billing::class)

### Doctor Model
- **fillable**: name, specialization, contact, working_hours
- **Relationships**:
  - `appointments()`: hasMany(Appointment::class)

### Appointment Model
- **fillable**: patient_id, doctor_id, date, time, status
- **Relationships**:
  - `patient()`: belongsTo(Patient::class)
  - `doctor()`: belongsTo(Doctor::class)
  - `billing()`: hasOne(Billing::class)

### Billing Model
- **fillable**: patient_id, appointment_id, amount, status, date
- **Relationships**:
  - `patient()`: belongsTo(Patient::class)
  - `appointment()`: belongsTo(Appointment::class)

## User Roles & Permissions

### Roles
1. **admin**: Full access to all features
2. **receptionist**: Can manage patients, appointments, and billing
3. **doctor**: Read-only access to own appointments

### Permission Matrix

| Feature | Admin | Receptionist | Doctor |
|---------|-------|--------------|--------|
| View Dashboard | ✅ | ✅ | ✅ |
| Manage Patients | ✅ | ✅ | ❌ |
| Manage Doctors | ✅ | ❌ | ❌ |
| Create Appointments | ✅ | ✅ | ❌ |
| Edit Appointments | ✅ | ✅ | ❌ |
| View Own Appointments | ✅ | ✅ | ✅ |
| Create Billing | ✅ | ✅ | ❌ |
| Edit Billing | ✅ | ✅ | ❌ |
| View Invoices | ✅ | ✅ | ✅ |

## Routes Structure

### Main Routes (web.php)

#### Authentication
- `/` → Redirect to login
- `/register` → Registration form
- `/login` → Login form
- `/logout` → Logout action
- Password reset routes

#### Dashboard
- `/dashboard` → Role-based redirect
- `/dashboard/admin` → Admin dashboard (admin only)
- `/dashboard/receptionist` → Receptionist dashboard (receptionist only)
- `/dashboard/doctor` → Doctor dashboard (doctor only)

#### Patients (Admin & Receptionist)
- `GET /patients` → Index
- `GET /patients/create` → Create form
- `POST /patients` → Store
- `GET /patients/{patient}` → Show
- `GET /patients/{patient}/edit` → Edit form
- `PUT /patients/{patient}` → Update
- `DELETE /patients/{patient}` → Destroy

#### Doctors (Admin only)
- `GET /doctors` → Index
- `GET /doctors/create` → Create form
- `POST /doctors` → Store
- `GET /doctors/{doctor}` → Show
- `GET /doctors/{doctor}/edit` → Edit form
- `PUT /doctors/{doctor}` → Update
- `DELETE /doctors/{doctor}` → Destroy

#### Appointments
- Admin & Receptionist: Full CRUD
- Doctor: Read-only (index, show)
- `POST /appointments/check-availability` → AJAX availability check

#### Billing
- Admin & Receptionist: Full CRUD + mark as paid
- All authenticated: View invoices + print
- `POST /billing/{billing}/mark-paid` → Mark as paid
- `GET /billing/{billing}/print` → Print invoice

#### Profile
- `GET /profile` → Edit profile
- `PATCH /profile` → Update profile
- `DELETE /profile` → Delete account

## Controllers

### AppointmentController
- **index()**: Lists appointments (filtered by user role)
- **create()**: Shows appointment creation form with available dates/time slots
- **store()**: Creates appointment with availability check
- **checkAvailability()**: Checks if doctor is available at given date/time
- **checkAvailabilityAjax()**: AJAX endpoint for availability checking
- **show()**: Shows appointment details
- **edit()**: Shows edit form
- **update()**: Updates appointment with conflict checking
- **destroy()**: Deletes appointment

### BillingController
- **index()**: Lists invoices with statistics (monthly revenue, pending payments)
- **create()**: Shows invoice creation form
- **store()**: Creates invoice (calculates total from items if provided)
- **show()**: Shows invoice details
- **print()**: Shows printable invoice view
- **markAsPaid()**: Marks invoice as paid
- **edit()**: Shows edit form
- **update()**: Updates invoice
- **destroy()**: Deletes invoice

### DoctorController
- **index()**: Lists doctors
- **create()**: Shows creation form
- **store()**: Creates doctor
- **show()**: Shows doctor with appointments
- **edit()**: Shows edit form
- **update()**: Updates doctor
- **destroy()**: Deletes doctor

### PatientController
- **index()**: Lists patients
- **create()**: Shows registration form
- **store()**: Creates patient (combines first_name + last_name)
- **show()**: Shows patient with appointments and billings
- **edit()**: Shows edit form (splits name into first/last)
- **update()**: Updates patient
- **destroy()**: Deletes patient

### ProfileController
- Standard Laravel Breeze profile management

## Middleware

### CheckRole
- **Purpose**: Role-based access control
- **Usage**: `->middleware('role:admin')` or `->middleware('role:admin,receptionist')`
- **Logic**: Checks if authenticated user has specified role, returns 403 if not
- **Location**: `app/Http/Middleware/CheckRole.php`

## Request Validation

### StoreAppointmentRequest
- **Authorization**: Admin or Receptionist only
- **Rules**:
  - patient_id: required, exists in patients
  - doctor_id: required, exists in doctors
  - date: required, date, after_or_equal:today
  - time: required, string
  - reason: nullable, string, max:500
  - status: nullable, in:scheduled,confirmed,completed,cancelled

### StoreBillingRequest
- **Authorization**: Admin or Receptionist only
- **Rules**:
  - patient_id: required, exists in patients
  - doctor_id: required, exists in doctors
  - appointment_id: nullable, exists in appointments
  - amount: required, numeric, min:0
  - status: nullable, in:pending,paid,overdue
  - payment_method: required, in:credit_card,cash,insurance,bank_transfer
  - notes: nullable, string, max:1000
  - items: nullable, array
  - items.*.name: required_with:items, string, max:255
  - items.*.quantity: required_with:items, integer, min:1
  - items.*.price: required_with:items, numeric, min:0

### StoreDoctorRequest
- **Authorization**: Admin only
- **Rules**:
  - name: required, string, max:255
  - specialization: required, string, max:255
  - contact: required, string, max:20
  - working_hours: required, string, max:100

### StorePatientRequest
- **Authorization**: Admin or Receptionist only
- **Rules**:
  - first_name: required, string, max:255
  - last_name: required, string, max:255
  - age: required, integer, min:0, max:150
  - gender: required, in:male,female,other
  - contact: required, string, max:20
  - email: nullable, email, max:255
  - address: nullable, string, max:500
  - medical_notes: nullable, string, max:2000

## Key Features

### Appointment System
- Time slot availability checking
- Conflict detection when booking/editing
- AJAX endpoint for real-time availability
- Status tracking (scheduled, confirmed, completed, cancelled, waiting)
- 14-day advance booking window

### Billing System
- Invoice generation with itemized billing
- Payment status tracking (pending, paid, overdue)
- Multiple payment methods (credit_card, cash, insurance, bank_transfer)
- Monthly revenue calculation
- Pending payment tracking
- Printable invoices

### Dashboard System
- Role-specific dashboards
- **Admin Dashboard**: Total patients, today's appointments, monthly revenue, active doctors, recent appointments
- **Receptionist Dashboard**: Waiting room count, today's appointments, incoming patients queue
- **Doctor Dashboard**: Completed today, remaining today, next patient, patient queue

## Configuration

### Environment Variables (.env)
- **APP_NAME**: Application name
- **APP_ENV**: Environment (local/production)
- **APP_DEBUG**: Debug mode (true/false)
- **APP_URL**: Application URL
- **DB_CONNECTION**: Database connection (sqlite default)
- **SESSION_DRIVER**: Session storage (database)
- **QUEUE_CONNECTION**: Queue driver (database)
- **CACHE_STORE**: Cache driver (database)

### Composer Scripts
- `composer setup`: Full project setup (install, migrate, npm install, build)
- `composer dev`: Development server with queue, logs, and vite
- `composer test`: Run tests

### NPM Scripts
- `npm run dev`: Start Vite development server
- `npm run build`: Build for production

## Setup Instructions

### Initial Setup
```bash
composer setup
```

This will:
1. Install PHP dependencies
2. Copy .env.example to .env
3. Generate application key
4. Run migrations
5. Install NPM dependencies
6. Build frontend assets

### Development Server
```bash
composer dev
```

This starts:
- PHP artisan server (port 8000)
- Queue worker
- Log viewer (Pail)
- Vite development server

### Manual Setup
```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate

# Build assets
npm run build

# Start server
php artisan serve
```

## Important Notes

### Database
- Uses SQLite by default (database/database.sqlite)
- All foreign keys have cascade delete
- Sessions stored in database
- Cache stored in database

### Authentication
- Uses Laravel Breeze for authentication
- Email verification available but not required
- Password reset functionality included
- Role-based access control via CheckRole middleware

### Frontend
- Blade templates with TailwindCSS
- Alpine.js for interactivity
- Vite for asset bundling
- Responsive design

### Business Logic
- Patient names stored as single field, split on forms
- Appointment availability checked before booking
- Billing can calculate total from items or use provided amount
- Doctors linked to users via role (doctor role users should have doctor relationship)
- Time slots are predefined (morning: 9AM-11:30AM, afternoon: 2PM-4:30PM)

## File Locations Quick Reference

- **Routes**: `routes/web.php`, `routes/auth.php`
- **Models**: `app/Models/`
- **Controllers**: `app/Http/Controllers/`
- **Middleware**: `app/Http/Middleware/`
- **Requests**: `app/Http/Requests/`
- **Migrations**: `database/migrations/`
- **Views**: `resources/views/`
- **Assets**: `resources/css/`, `resources/js/`
- **Config**: `config/`
- **Environment**: `.env`

## Common Tasks

### Add New Role
1. Update `users` table migration role enum
2. Update CheckRole middleware if needed
3. Add role-specific routes in web.php
4. Create role-specific dashboard view

### Add New Model
1. Create migration: `php artisan make:migration create_xxx_table`
2. Create model: `php artisan make:model Xxx`
3. Define relationships in model
4. Create controller: `php artisan make:controller XxxController`
5. Add routes in web.php
6. Create views in resources/views/xxx/

### Modify Validation
- Edit request classes in `app/Http/Requests/`
- Rules are defined in `rules()` method
- Authorization in `authorize()` method

## Testing
- PHPUnit configured in `phpunit.xml`
- Test files in `tests/Feature/` and `tests/Unit/`
- Run tests: `composer test` or `php artisan test`

## Deployment Considerations
- Set `APP_ENV=production` and `APP_DEBUG=false`
- Run `php artisan config:cache`
- Run `php artisan route:cache`
- Run `npm run build` for production assets
- Configure production database in .env
- Set up queue worker for production
- Configure proper file permissions for storage/
