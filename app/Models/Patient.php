<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'age', 'gender', 'contact', 'address', 'medical_notes'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}
