<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $patient = Patient::query()
            ->where('client_id',$request->user()->client_id)
            ->latest()
            ->filter($request->only('search'))
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();
        return Inertia::render('Patient/PatientIndex',[
            'patient' => PatientResource::collection($patient),
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $appointments = $patient->appointments()->with(['patient', 'doctor', 'clinicalTests'])->latest()->paginate(config('basicSetting.paginate'));
        return Inertia::render('Patient/PatientShow',[
            'patient' => PatientResource::make($patient),
            'appointments' => AppointmentResource::collection($appointments),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
