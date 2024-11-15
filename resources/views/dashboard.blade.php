@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>welcome to the Dashboard, {{ auth()->user()->name }}!</h2>
                <p>Tu rol: {{ auth()->user()->role->name }}</p>

                @if(auth()->user()->role->name == 'patient')
                    <h4>Your upcoming appointments </h4>
                    @if($appointments->isEmpty())
                        <p>You have no appointments scheduled.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Date and hour</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->doctor->user->name }}</td>
                                        <td>{{ $appointment->appointment_time }}</td>
                                        <td>{{ $appointment->reason }}</td>
                                        <td>{{ ucfirst($appointment->status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @elseif(auth()->user()->role->name == 'doctor')
                    <h4>Tus Citas Próximas</h4>
                    @if($appointments->isEmpty())
                        <p>You have no appointments scheduled.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Date and hour</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->patient->name }}</td>
                                        <td>{{ $appointment->appointment_time }}</td>
                                        <td>{{ $appointment->reason }}</td>
                                        <td>{{ ucfirst($appointment->status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @else
                    <h4>Appointment Management</h4>
                    <p>Welcome again Admin!, here you can manage all appointments and users.</p>
                    <!-- Here you can add more options for the administrator -->
                @endif
            </div>
        </div>
    </div>
@endsection
