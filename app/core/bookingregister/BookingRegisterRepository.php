<?php

namespace App\core\bookingregister;

use App\core\bookingregister\BookingRegisterInterface;
use App\Models\BookingType;
use App\Models\RegisterBooking;
use App\Models\User;
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

    public function getAllBookings() {
        return $this->bookingRegisterModel->with('patient')->orderByDesc('id');
    }

    public function getAllBookingTypes() {
        return $this->bookingTypeModel->orderByDesc('id')->get();
    }
}
