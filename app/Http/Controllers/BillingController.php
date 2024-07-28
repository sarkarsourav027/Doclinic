<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Http\Resources\BillingResource;
use App\Http\Resources\ClinicalTestResource;
use App\Models\Appointment;
use App\Models\Billing;
use App\Http\Requests\StoreBillingRequest;
use App\Http\Requests\UpdateBillingRequest;
use App\Models\ClinicalTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Inertia\Inertia;
use Mpdf\Mpdf;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $billings = Billing::query()
            ->with(['appointment', 'appointment.doctor', 'appointment.patient', 'appointment.clinicalTests'])
            ->latest()
            ->filter($request->only('search'))
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();
        return Inertia::render('Billing/BillingIndex', [
            'billings' => BillingResource::collection($billings),
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $select_clinical_tests = ClinicalTest::query()->latest()->pluck('name', 'id');
        $clinical_tests = ClinicalTest::query()->select('id', 'name', 'amount')->latest()->get();
        $appointments = Appointment::query()->pluck('appointment_id', 'id')->mapWithKeys(function ($appointment_id, $id) {
            return [$id => ['id' => $id, 'name' => $appointment_id]];
        })->values();
        return Inertia::render('Billing/BillingForm', [
            'appointments' => $appointments,
            'select_clinical_tests' => $select_clinical_tests,
            'clinical_tests' => ClinicalTestResource::collection($clinical_tests),
            'appointment' => Inertia::lazy(fn() => AppointmentResource::make(Appointment::query()->with(['doctor', 'patient'])->where('id', $request->appointment_id)->first())),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillingRequest $request)
    {
        DB::transaction(function () use ($request) {

            $invoice_number = 'INV' . substr(str_shuffle(str_repeat('0123456789', 10)), 0, 5) . time();
            $billing_date = $request->input('billing_date');
            $doctor_fees = $request->input('doctor_fees');
            $doctor_name = $request->input('doctor_name');
            $billing_amount = $request->input('billing_amount');
            $is_gst_bill = $request->input('is_gst_bill');
            $gst_percentage = $request->input('gst_percentage');
            $clinical_test_amount = $request->input('clinical_test_amount');
            $gst_amount = $request->input('gst_amount');
            $mpdf = new Mpdf();

            $mpdf->imageVars['logo'] = file_get_contents(public_path('assets/logo-letter.png'));
            $mpdf->WriteHTML(view('invoice.invoice', [
                'invoice_number' => $invoice_number,
                'billing_date' => $billing_date,
                'patient_name' => $request->input('name'),
                'patient_phone_number' => $request->input('phone_number'),
                'patient_email' => $request->input('email'),
                'patient_address' => $request->input('address'),
                'payment_mode' => $request->input('payment_mode'),
                'doctor_name' => $doctor_name,
                'is_gst_bill' => $is_gst_bill,
                'gst_percentage' => $gst_percentage,
                'clinical_test_amount' => $clinical_test_amount,
                'doctor_fees' => $doctor_fees,
                'billing_amount' => $billing_amount,
                'gst_amount' => $gst_amount,
                'billing_amount_in_word' => Number::spell($billing_amount)
            ])->render());
            $mpdf->SetHTMLFooter(view('invoice.invoice-footer')->render());

            $invoice_file = $invoice_number . '.pdf';
            $mpdf->Output(storage_path('app/public/invoice/' . $invoice_file));

            Billing::create([
                'invoice_file' => $invoice_file,
                'invoice_number' => $invoice_number,
                'appointment_id' => $request->input('appointment_id')['id'],
                'billing_date' => $request->input('billing_date'),
                'doctor_fees' => $request->input('doctor_fees'),
                'clinical_test_amount' => $request->input('clinical_test_amount'),
                'billing_amount' => $request->input('billing_amount'),
                'payment_mode' => $request->input('payment_mode'),
                'is_gst_bill' => $request->input('is_gst_bill'),
                'gst_percentage' => $request->input('gst_percentage'),
            ]);

            if ($request->filled('clinical_test_information')) {
                $clinicalTests = collect($request->input('clinical_test_information'));
                $appointmentId = $request->input('appointment_id')['id'];

                Appointment::find($appointmentId)
                    ->clinicalTests()
                    ->attach(
                        $clinicalTests->mapWithKeys(function ($test) {
                            return [$test['test_id'] => ['clinical_test_amount' => $test['amount']]];
                        })->toArray()
                    );
            }
        });
        return redirect()->route('billing.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Billing $billing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Billing $billing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillingRequest $request, Billing $billing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billing $billing)
    {
        //
    }
}
