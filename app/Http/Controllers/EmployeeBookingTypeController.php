<?php

namespace App\Http\Controllers;

use App\core\bookingregister\BookingRegisterInterface;
use Illuminate\Http\Request;

class EmployeeBookingTypeController extends Controller
{
    private $bookingRegisterInterface;
    public function __construct(BookingRegisterInterface $bookingRegisterInterface){
        $this->bookingRegisterInterface = $bookingRegisterInterface;
    }
    public function index()
    {
        return view('employee.bookingtype.index', [
            'bookingtypes' => $this->bookingRegisterInterface->getAllBookingTypes()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("employee.bookingtype.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string',
            'price' => 'nullable|numeric'
        ]);

        $insertMember = $this->bookingRegisterInterface->addNewBookingType($request->only('type_name', 'price', 'status'));
        if ($insertMember) {
            return redirect()->route('employee-booking-types.index')->with('msg', 'New Booking Added Successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $data["bookingtype"] =  $this->bookingRegisterInterface->getSingleBookingType($slug);
        return view("employee.bookingtype.edit", $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $request->validate([
            'type_name' => 'required|string',
            'price' => 'nullable|numeric'
        ]);

        $insertMember = $this->bookingRegisterInterface->updateBookingType($request->only('type_name', 'price', 'status'), $slug);
        if ($insertMember) {
            return redirect()->route('employee-booking-types.index')->with('msg', 'Booking Type Updated Successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $bookingType = $this->bookingRegisterInterface->deletebookingType($slug);
        if ($bookingType) {
            return back()->with('msg', 'The Bookign Type Has been deleted successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }
}
