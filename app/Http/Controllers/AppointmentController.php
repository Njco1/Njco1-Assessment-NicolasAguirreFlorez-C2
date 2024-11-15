<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
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

        return view('appointments-create', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        return view('appointments-create', compact('doctors'));
    }

    public function store(Request $request)
    {
        // Validate the entry
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_time' => 'required|date',
            'reason' => 'required|string',
        ]);

        // Check if the doctor is available
        $isAvailable = Appointment::checkDoctorAvailability($request->doctor_id, $request->appointment_time);

        if (!$isAvailable) {
            return back()->withErrors(['error' => 'El médico no está disponible en este horario']);
        }

        // Crear the Appointment
        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Cita agendada con éxito');
    }
}

