<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'doctor_id', 'appointment_time', 'reason', 'status'];

    // Relation with the patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Relation with the doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Relation with thw notes on his appointment
    public function notes()
    {
        return $this->hasMany(AppointmentNote::class);
    }

    // Method for check doctor availability
    public static function checkDoctorAvailability($doctorId, $appointmentTime)
    {
        return !self::where('doctor_id', $doctorId)
                    ->where('appointment_time', $appointmentTime)
                    ->exists();
    }

    public function store(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_time' => 'required|date',
        'reason' => 'required|string',
    ]);

    // check doctor availability
    $isAvailable = Appointment::checkDoctorAvailability($request->doctor_id, $request->appointment_time);

    if (!$isAvailable) {
        return back()->withErrors(['error' => 'The doctor is not available at this time
']);
    }

    // created the appointment
    Appointment::create([
        'patient_id' => auth()->id(),
        'doctor_id' => $request->doctor_id,
        'appointment_time' => $request->appointment_time,
        'reason' => $request->reason,
    ]);

    return redirect()->route('appointments.index');
}

public function index(Request $request)
{
    $appointments = Appointment::query();

    if ($request->filled('date')) {
        $appointments->whereDate('appointment_time', $request->date);
    }

    if ($request->filled('specialty')) {
        $appointments->whereHas('doctor.specialty', function ($query) use ($request) {
            $query->where('name', $request->specialty);
        });
    }

    if ($request->filled('reason')) {
        $appointments->where('reason', 'like', '%' . $request->reason . '%');
    }

    $appointments = $appointments->get();

    return view('appointments.index', compact('appointments'));
}

}
