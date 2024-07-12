<?php

namespace App\Http\Controllers\admin\patient;

use App\core\patient\PatientInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patientInterface;
    public function __construct( PatientInterface $patientInterface){
        $this->patientInterface = $patientInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin.patient.index', [
            'patients' => $this->patientInterface->getAllPatients($request)->paginate(10)
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        return view('admin.patient.show', [
            'patient' => $this->patientInterface->getSinglePatient($slug)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
