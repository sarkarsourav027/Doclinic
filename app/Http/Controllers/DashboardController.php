<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\ClinicalTest;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $clinical_test_count = ClinicalTest::query()->count();
        $doctors = Doctor::query()->count();
        $patients = Patient::query()->count();
        $today_appointment_count = Appointment::query()->latest()->whereDate('appointment_date', Carbon::today())->count();
        $today_appointment = Appointment::query()
            ->latest()
            ->with(['doctor','patient'])
            ->filter($request->only('search'))
            ->whereDate('appointment_date', Carbon::today())
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();

        return Inertia::render('Dashboard',[
            'clinical_test_count' => $clinical_test_count,
            'total_doctors' => $doctors,
            'total_patients' => $patients,
            'today_appointment_count' => $today_appointment_count,
            'today_appointment' => AppointmentResource::collection($today_appointment),
            'filters' => $request->only('search')
        ]);
    }
}
