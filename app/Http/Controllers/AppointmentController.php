<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Client;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $appointment = Appointment::query()
            ->where('client_id',$request->user()->client_id)
            ->with(['patient', 'doctor', 'clinicalTests'])
            ->latest()
            ->filter($request->only('search'))
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();
        return Inertia::render('Appointment/AppointmentIndex', [
            'appointment' => AppointmentResource::collection($appointment),
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::query()->latest()->pluck('name', 'id')->mapWithKeys(function ($name, $id) {
            return [$id => ['id' => $id, 'name' => $name]];
        })->values();
        return Inertia::render('Appointment/AppointmentForm', [
            'doctors' => $doctors,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $patient = Patient::firstOrCreate(
                [
                    'name' => $request->input('name'),
                    'phone_number' => $request->input('phone_number'),
                ],
                [
                    'client_id' => $request->user()->client_id,
                    'patient_id' => substr(str_shuffle(str_repeat('0123456789', 10)), 0, 5) . time()
                ]
            );

            Appointment::create([
                'client_id' => $request->user()->client_id,
                'appointment_id' => substr(str_shuffle(str_repeat('0123456789', 10)), 0, 5) . time(),
                'doctor_id' => $request->input('doctor_id')['id'],
                'patient_id' => $patient->id,
                'appointment_date' => $request->input('appointment_date')
            ]);
        });
        return redirect()->route('appointment.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor']);
        $doctors = Doctor::query()->latest()->pluck('name', 'id')->mapWithKeys(function ($name, $id) {
            return [$id => ['id' => $id, 'name' => $name]];
        })->values();
        return Inertia::render('Appointment/AppointmentForm', [
            'appointment' => AppointmentResource::make($appointment),
            'doctors' => $doctors,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        DB::transaction(function () use ($request, $appointment) {
            $patient = Patient::firstOrCreate(
                [
                    'name' => $request->input('name'),
                    'phone_number' => $request->input('phone_number'),
                ],
                [
                    'client_id' => $request->user()->client_id,
                    'patient_id' => substr(str_shuffle(str_repeat('0123456789', 10)), 0, 5) . time()
                ]
            );

            $appointment->update([
                'doctor_id' => $request->input('doctor_id')['id'],
                'patient_id' => $patient->id,
                'appointment_date' => $request->input('appointment_date')
            ]);
        });
        return redirect()->route('appointment.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
