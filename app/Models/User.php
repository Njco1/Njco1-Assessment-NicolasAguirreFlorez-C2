<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    // Relation with the role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relation with the appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    // Relación with the doctors
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
}


