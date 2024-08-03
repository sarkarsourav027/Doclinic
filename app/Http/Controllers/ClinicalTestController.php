<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClinicalTestResource;
use App\Models\ClinicalTest;
use App\Http\Requests\StoreClinicalTestRequest;
use App\Http\Requests\UpdateClinicalTestRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
class ClinicalTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clinical_test = ClinicalTest::query()
            ->where('client_id',$request->user()->client_id)
            ->latest()
            ->filter($request->only('search'))
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();
        return Inertia::render('ClinicalTest/index',[
            'clinical_test' => ClinicalTestResource::collection($clinical_test),
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ClinicalTest/ClinicalTestForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClinicalTestRequest $request)
    {

        $request->merge([
            'client_id' => $request->user()->client_id,
        ]);
        ClinicalTest::create($request->all());
        return redirect()->route('clinical-test.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClinicalTest $clinicalTest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClinicalTest $clinicalTest)
    {
        return Inertia::render('ClinicalTest/ClinicalTestForm',[
            'clinicalTest'=> ClinicalTestResource::make($clinicalTest)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClinicalTestRequest $request, ClinicalTest $clinicalTest)
    {
        $clinicalTest->update($request->validated());
        return redirect()->route('clinical-test.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClinicalTest $clinicalTest)
    {
        //
    }
}
