<?php

namespace App\core\bookingregister;

use App\core\bookingregister\BookingRegisterInterface;
use App\Models\BookingPayment;
use App\Models\BookingType;
use App\Models\RegisterBooking;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use illuminate\Support\Str;

class BookingRegisterRepository implements BookingRegisterInterface
{

    private $bookingRegisterModel;
    private $userModel;
    private $bookingTypeModel;
    public function __construct()
    {
        $this->bookingRegisterModel = RegisterBooking::query();
        $this->userModel = User::query();
        $this->bookingTypeModel = BookingType::query();
    }
    public function checkIfPatientExist($givenInput)
    {
        try {
            $data = [];
            $ifBookingId = $this->bookingRegisterModel->with('patient')->where('booking_id', $givenInput)->first();
            if (!$ifBookingId) {
                $ifPhoneNumber = $this->userModel->with('registerBooking')->where('phone_number', $givenInput)->first();
                if ($ifPhoneNumber) {
                    $data['status'] = true;
                    $data['patient_name'] = $ifPhoneNumber->name;
                    $data['phone_number'] = $ifPhoneNumber->phone_number;
                    $data['address'] = $ifPhoneNumber->address;
                } else {
                    $data['status'] = false;
                    $data['msg'] = 'No data found';
                }
                return $data;
            } else {
                $data['status'] = true;
                $data['patient_name'] = $ifBookingId->patient->name;
                $data['phone_number'] = $ifBookingId->patient->phone_number;
                $data['address'] = $ifBookingId->patient->address;
                return $data;
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['msg'] = $th->getMessage();
            return $data;
        }
    }

    public function getAllBookings($request)
    {
        $query = $this->bookingRegisterModel->with('patient');

        if (isset($request->search_text) && !empty($request->search_text)) {
            $searchText = $request->search_text;

            $query->where(function ($q) use ($searchText) {
                $q->where('booking_id',  $searchText)
                    ->orWhereHas('patient', function ($query) use ($searchText) {
                        $query->where('name', 'like', "%{$searchText}%")
                            ->orWhere('phone_number', 'like', "%{$searchText}%");
                    });
            });
        }

        return $query->orderByDesc('id');
        // if(isset($request->search_text) && !empty($request->search_text)){
        //     $this->bookingRegisterModel->orWhere("booking_id", $request->search_text)
        //                                 ->orWhere()
        // }
        // return $this->bookingRegisterModel->with('patient')->orderByDesc('id');
    }

    public function getAllBookingTypes()
    {
        return $this->bookingTypeModel->orderByDesc('id')->get();
    }

    public function createBookingRegister(array $userData, array $bookingData)
    {
        try {
            $bookingData['user_id'] = $this->checkUserByNumber($userData);
            $bookingData['booking_id'] = $this->generateUniqueBookingId();
            // dd($bookingData);
            $createBooking = $this->bookingRegisterModel->create($bookingData);
            if ($createBooking instanceof RegisterBooking) {
                BookingPayment::create([
                    "amount" => $bookingData["initial_paid_amount"],
                    "register_booking_id" => $createBooking->id
                ]);
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            $this->getLogs($th);
            return false;
        }
    }

    public function checkUserByNumber($userData)
    {
        $findUser = $this->userModel->where('phone_number', $userData['phone_number'])->first();
        if ($findUser) {
            if ($findUser->update([
                'name' => $userData['patient_name'],
                'address' => $userData['address']
            ])) {
                return $findUser->id;
            }
        } else {
            $newUser = $this->userModel->create([
                'name' => $userData['patient_name'],
                'address' => $userData['address'],
                'phone_number' => $userData['phone_number']
            ]);
            return $newUser->id;
        }
    }



    private function generateUniqueBookingId(): int
    {
        $prefix = rand(100, 999);
        $random_number = rand(100000, 999999);
        $booking_id = $prefix . sprintf("%06d", $random_number);
        $existing_booking = RegisterBooking::where('booking_id', $booking_id)->exists();
        if ($existing_booking) {
            return $this->generateUniqueBookingId();
        }
        return intval($booking_id);
    }

    public function getBookingRegister($slug)
    {
        return $this->bookingRegisterModel->where('slug', $slug)->with('patient', 'bookingType')->firstOrFail();
    }

    public function getLogs($th)
    {
        Log::debug('ErrorFile-', [$th->getFile()]);
        Log::debug('ErrorMsg-', [$th->getMessage()]);
    }

    // public function generatePdf($slug)
    // {
    //     $bookingInfo = $this->getBookingRegister($slug);
    //     $pdf = Pdf::loadView('pdf.registerbooking-pdf', [
    //         'bookingInfo' => $bookingInfo
    //     ])->setPaper('a4','landscape')->setOptions(['defaultFont' => 'sans-serif']);

    //     return $pdf->download('booking-'.$bookingInfo->booking_id.'.pdf');
    // }
    public function generatePdf($slug)
    {
        $bookingInfo = $this->getBookingRegister($slug);
        // return view('pdf.registerbooking-pdf', [
        //     'bookingInfo' => $bookingInfo
        // ]
        // );


        // Custom paper size close to A4 landscape dimensions (in points)
        $customPaper = [0, 0, 841.89, 595.28];

        $pdf = Pdf::loadView('pdf.registerbooking-pdf', [
            'bookingInfo' => $bookingInfo
        ])
            // ->setPaper('letter', 'portrait')
            ->setPaper($customPaper, 'legal')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download('booking-' . $bookingInfo->booking_id . '.pdf');
    }

    public function updatePayment($dueAmount, $booking_id, $originalAmount)
    {
        try {
            $sumOfPaidAmounts = BookingPayment::where('register_booking_id', $booking_id)->sum('amount');
            if ($dueAmount > ($originalAmount - $sumOfPaidAmounts)) {
                return 2;
            }
            $updateAmount = BookingPayment::create([
                "register_booking_id" => $booking_id,
                "amount" => $dueAmount
            ]);
            if ($updateAmount) {
                return true;
            }
        } catch (\Throwable $th) {
            $this->getLogs($th);
            return false;
        }
    }
}
