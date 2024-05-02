<?php

namespace App\Http\Controllers\admin\registerbooking;

use App\core\bookingregister\BookingRegisterInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterBookingController extends Controller
{
    private $bookingRegisterInterface;
    public function __construct(BookingRegisterInterface $bookingRegisterInterface){
        $this->bookingRegisterInterface = $bookingRegisterInterface;
    }
    public function index()
    {
        return view('admin.registerbooking.index', [
            'allbookings' => $this->bookingRegisterInterface->getAllBookings()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.registerbooking.create');
    }

    public function store(Request $request)
    {
        //
    }

    
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function checkPatientPriviousBooking(Request $request){
       if(!empty($request->userinput)){
           $checkIfPatientExist = $this->bookingRegisterInterface->checkIfPatientExist($request->userinput);
          if(isset($checkIfPatientExist['status'])  && $checkIfPatientExist['status']){
            return response()->json([
                'status' => true,
                $checkIfPatientExist
            ]);
          }else{
            return response()->json([
                'status' => false
            ]);
          }
       }
    }
}
