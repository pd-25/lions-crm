<?php

namespace App\core\bookingregister;

use App\core\bookingregister\BookingRegisterInterface;
use App\Models\BookingPayment;
use App\Models\BookingType;
use App\Models\RegisterBooking;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
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

            $bookingRecords = $this->bookingRegisterModel->with('patient')->where('booking_id', $givenInput)->get();

            if ($bookingRecords->isEmpty()) {
                $phoneRecords = $this->userModel->where('phone_number', $givenInput)->get();

                if ($phoneRecords->isNotEmpty()) {
                    $data['status'] = true;
                    $data['patients'] = [];

                    foreach ($phoneRecords as $record) {
                        $data['patients'][] = [
                            'patient_name' => $record->name,
                            'phone_number' => $record->phone_number,
                            'address' => $record->address,
                            'user_id' => $record->id
                        ];
                    }
                } else {
                    $data['status'] = false;
                    $data['msg'] = 'No data found';
                }
            } else {
                $data['status'] = true;
                $data['patients'] = [];

                foreach ($bookingRecords as $record) {
                    $data['patients'][] = [
                        'patient_name' => $record->patient->name,
                        'phone_number' => $record->patient->phone_number,
                        'address' => $record->patient->address,
                        'user_id' => $record->patient->id

                    ];
                }
            }

            return $data;
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => $th->getMessage(),
            ];
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

    public function getSingleBookingType($slug)
    {
        return $this->bookingTypeModel->where('slug', $slug)->first();
    }
    public function addNewBookingType(array $typeData)
    {
        $slug = Str::slug($typeData['type_name']);
        $slug_count = DB::table('booking_types')->where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug = random_int(100000, 999999) . '-' . $slug;
        }
        $typeData['slug'] = $slug;
        return $this->bookingTypeModel->create($typeData);
    }
    public function updateBookingType($data, $slug)
    {

        return $this->bookingTypeModel->where('slug', $slug)->update($data);
    }
    public function deletebookingType($slug)
    {
        return $this->bookingTypeModel->where('slug', $slug)->delete();
    }

    public function createBookingRegister(array $userData, array $bookingData)
    {
        try {
            return DB::transaction(function () use ($userData, $bookingData) {
                $bookingData['user_id'] = $this->checkUserByExistingId($userData);
                $bookingData['booking_id'] = $this->generateUniqueBookingId();

                $createBooking = $this->bookingRegisterModel->create($bookingData);

                if ($createBooking instanceof RegisterBooking) {
                    BookingPayment::create([
                        "amount" => $bookingData["initial_paid_amount"],
                        "register_booking_id" => $createBooking->id
                    ]);
                    return true;
                }
                return false;
            });
        } catch (\Throwable $th) {
            $this->getLogs($th);
            return false;
        }
    }

    public function checkUserByExistingId($userData)
    {
        if ($userData["existing_patient_id"] > 0) {
            $findUser = $this->userModel->where('id', $userData['existing_patient_id'])->first();
            if ($findUser) {
                return $findUser->id;
            } else {
                throw new Exception("Patient not found in system", 401);
            }
        } elseif ($userData["existing_patient_id"] == 0) {
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
