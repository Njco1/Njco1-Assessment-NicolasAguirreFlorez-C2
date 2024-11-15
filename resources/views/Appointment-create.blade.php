@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Agendar Cita</h2>
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="doctor_id">Select the Doctor:</label>
                <select name="doctor_id" id="doctor_id" class="form-control">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->user->name }} - {{ $doctor->specialty->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="appointment_time">Fecha y Hora de la Cita:</label>
                <input type="datetime-local" name="appointment_time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for
