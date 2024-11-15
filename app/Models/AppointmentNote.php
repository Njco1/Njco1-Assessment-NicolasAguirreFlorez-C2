<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentNote extends Model
{
    use HasFactory;

    protected $fillable = ['appointment_id', 'note'];

    // Relación con la cita
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
