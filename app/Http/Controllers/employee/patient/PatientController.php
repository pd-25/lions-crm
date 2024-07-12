<?php

namespace App\Http\Controllers\employee\patient;

use App\core\bookingregister\BookingRegisterInterface;
use App\core\patient\PatientInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patientInterface, $bookingRegisterInterface;
    public function __construct( PatientInterface $patientInterface, BookingRegisterInterface $bookingRegisterInterface){
        $this->patientInterface = $patientInterface;
        $this->bookingRegisterInterface = $bookingRegisterInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('employee.patient.index', [
            'patients' => $this->patientInterface->getAllPatients($request)->paginate(10)
        ]);
    }

    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        return view('employee.patient.show', [
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

    public function downloadPdf($slug){
       return $this->bookingRegisterInterface->generatePdf($slug);
    }
}
