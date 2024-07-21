<?php

namespace App\Http\Controllers;

use App\Enums\DaysOfWeek;
use App\Enums\DoctorType;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $doctor = Doctor::query()
            ->latest()
            ->filter($request->only('search'))
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();
        return Inertia::render('Doctor/index',[
            'doctor' => DoctorResource::collection($doctor),
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctorTypes = DoctorType::getValues();

        $daysOfWeek = collect(DaysOfWeek::getValues())->mapWithKeys(function ($name, $id) {
            return [$id => ['id' => $name, 'name' => $name]];
        })->values();
        return Inertia::render('Doctor/DoctorForm',[
            'doctorTypes'=>$doctorTypes,
            'daysOfWeek'=>$daysOfWeek,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $request['available_days'] = collect($request->input('available_days'))->pluck('name')->toArray();
        Doctor::create($request->only(['doctor_type','name','phone_number','available_days']));
        return redirect()->route('doctor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $doctorTypes = DoctorType::getValues();

        $daysOfWeek = collect(DaysOfWeek::getValues())->mapWithKeys(function ($name, $id) {
            return [$id => ['id' => $name, 'name' => $name]];
        })->values();
        return Inertia::render('Doctor/DoctorForm',[
            'doctor'=> DoctorResource::make($doctor),
            'doctorTypes'=>$doctorTypes,
            'daysOfWeek'=>$daysOfWeek,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $request['available_days'] = collect($request->input('available_days'))->pluck('name')->toArray();
        $doctor->update($request->only(['doctor_type','name','phone_number','available_days']));
        return redirect()->route('doctor.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
