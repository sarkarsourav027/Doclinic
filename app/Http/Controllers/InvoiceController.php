<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClinicalTestResource;
use App\Http\Resources\InvoiceResource;
use App\Models\ClinicalTest;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Number;
use Inertia\Inertia;
use Mpdf\Mpdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoices = Invoice::query()
            ->latest()
            ->filter($request->only('search'))
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();
        return Inertia::render('Invoice/InvoiceIndex', [
            'invoices' => InvoiceResource::collection($invoices),
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $select_clinical_tests = ClinicalTest::query()->latest()->pluck('name', 'id');
        $clinical_tests = ClinicalTest::query()->select('id', 'name', 'amount')->latest()->get();
        return Inertia::render('Invoice/InvoiceForm', [
            'select_clinical_tests' => $select_clinical_tests,
            'clinical_tests' => ClinicalTestResource::collection($clinical_tests),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        DB::transaction(function () use ($request) {

            $invoice_number = 'INV' . substr(str_shuffle(str_repeat('0123456789', 10)), 0, 5) . time();
            $billing_date = $request->input('invoice_date');
            $billing_amount = $request->input('invoice_amount');
            $is_gst_bill = $request->input('is_gst_bill');
            $gst_percentage = $request->input('gst_percentage');
            $clinical_test_amount = $request->input('clinical_test_amount');
            $gst_amount = $request->input('gst_amount');

            $clinicalTestInformation = $request->input('clinical_test_information');
            $testIds = collect($clinicalTestInformation)->pluck('test_id')->toArray();
            $clinicalTests = ClinicalTest::whereIn('id', $testIds)->get();

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
                'is_add_doctor_fees' => false,
                'doctor_name' => '',
                'is_gst_bill' => $is_gst_bill,
                'gst_percentage' => $gst_percentage,
                'clinical_test_amount' => $clinical_test_amount,
                'doctor_fees' => 0.00,
                'billing_amount' => $billing_amount,
                'gst_amount' => $gst_amount,
                'billing_amount_in_word' => ucfirst(Number::spell($billing_amount)),
                'clinical_test' => $clinicalTests
            ])->render());
            $mpdf->SetHTMLFooter(view('invoice.invoice-footer')->render());

            $invoice_file = $invoice_number . '.pdf';
            $mpdf->Output(storage_path('app/public/invoice/' . $invoice_file));

            Invoice::create([
                'invoice_file' => $invoice_file,
                'invoice_number' => $invoice_number,
                'invoice_date' => $billing_date,
                'doctor_fees' => 0.00,
                'clinical_test_amount' => $request->input('clinical_test_amount'),
                'invoice_amount' => $billing_amount,
                'payment_mode' => $request->input('payment_mode'),
                'is_gst_bill' => $request->input('is_gst_bill'),
                'gst_percentage' => $request->input('gst_percentage'),
            ]);
        });

        return redirect()->route('regular-invoice.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
