<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the appointments of the logged in patient, if it is a patient
        if (auth()->user()->role->name == 'patient') {
            $appointments = Appointment::where('patient_id', auth()->id())->get();
        } elseif (auth()->user()->role->name == 'doctor') {
            // Get appointments from the logged in doctor, if he is a doctor
            $appointments = Appointment::where('doctor_id', auth()->id())->get();
        } else {
            // If you are an administrator, show all appointments
            $appointments = Appointment::all();
        }

        // Return view with appointments
        return view('dashboard.index', compact('appointments'));
    }
}
