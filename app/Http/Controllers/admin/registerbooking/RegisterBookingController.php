<?php

namespace App\Http\Controllers\admin\registerbooking;

use App\core\bookingregister\BookingRegisterInterface;
use App\core\operationschemes\OperationSchemeInterface;
use App\Http\Controllers\Controller;
use App\Traits\AllTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterBookingController extends Controller
{
    use AllTrait;

    private $bookingRegisterInterface, $operationSchemeInterface;
    public function __construct(BookingRegisterInterface $bookingRegisterInterface, OperationSchemeInterface $operationSchemeInterface)
    {
        $this->bookingRegisterInterface = $bookingRegisterInterface;
        $this->operationSchemeInterface = $operationSchemeInterface;
    }

    public function index(Request $request)
    {
        return view('admin.registerbooking.index', [
            'allbookings' => $this->bookingRegisterInterface->getAllBookings($request)->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.registerbooking.create', [
            'bookingTypes' => $this->bookingRegisterInterface->getAllBookingTypes(),
            'operationId' => config('constants.operation_id'),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'patient_name' => 'required|string|max:50',
                    'phone_number' => 'required|string|max:11',
                    'address' => 'required|string|max:200',
                    'booking_type_id' => 'required|exists:booking_types,id',
                    'amount' => 'required|numeric',
                    'initial_paid_amount' => 'required|numeric',
                    'about_patient_problem' => 'nullable|max:500',
                    'operation_scheme_id' => $request->booking_type_id == config('constants.operation_id') ? 'required|exists:operation_schemes,id' : 'nullable',
                ],
                [
                    'operation_scheme_id.required' => 'Operation scheme ID is required when booking type is operation.',
                ],
            );
            $userData = $request->only('patient_name', 'phone_number', 'address');
            $bookingData = $request->only('booking_type_id', 'amount', 'about_patient_problem', 'operation_scheme_id', 'initial_paid_amount');
            if ($this->bookingRegisterInterface->createBookingRegister($userData, $bookingData)) {
                return response()->json([
                    "status" => "success",
                    "msg" => "Booking created successfully!"
                ]);
            }
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'errors' => $e->errors()], 422);
        }
    }

    public function show(string $slug)
    {
        return view('admin.registerbooking.show', [
            'registerBooking' => $this->bookingRegisterInterface->getBookingRegister($slug)
        ]);
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

    public function checkPatientPriviousBooking(Request $request)
    {
        if (!empty($request->userinput)) {
            $checkIfPatientExist = $this->bookingRegisterInterface->checkIfPatientExist($request->userinput);
            if (isset($checkIfPatientExist['status']) && $checkIfPatientExist['status']) {
                return response()->json([
                    'status' => true,
                    $checkIfPatientExist,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }
        }
    }

    public function checkIfBookingTypeOperation()
    {
        return response()->json([
            'status' => true,
            'allBookingTypes' => $this->operationSchemeInterface->getAllOperationSchemes()->get(),
        ]);
    }

    public function updatePayment(Request $request, $booking_slug)
    {
        $checkBooking = $this->bookingRegisterInterface->getBookingRegister($booking_slug);
        if ($checkBooking) {
            $updatingPayment = $this->bookingRegisterInterface->updatePayment($request->input("due_amount"), $checkBooking->id, $checkBooking->amount);
          
            if ($updatingPayment === 2) {
                return response()->json([
                    "status" => false,
                    "msg" => "Given amount should not be greter than due amount"
                ]);
            } elseif ($updatingPayment === false) {
                return response()->json([
                    "status" => false,
                    "msg" => "Some error occur."
                ]);
            } else {
                return response()->json([
                    "status" => true,
                    "msg" => "Payment updated successfully."
                ]);
            }
        }
    }
}
