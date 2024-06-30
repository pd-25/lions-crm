<?php

namespace App\core\bookingregister;

use App\core\bookingregister\BookingRegisterInterface;
use App\Models\BookingType;
use App\Models\RegisterBooking;
use App\Models\User;
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

    public function getAllBookings()
    {
        return $this->bookingRegisterModel->with('patient')->orderByDesc('id');
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

    public function getBookingRegister($slug){
        return $this->bookingRegisterModel->where('slug', $slug)->with('patient', 'bookingType')->firstOrFail();
    }

    public function getLogs($th)
    {
        Log::debug('ErrorFile-', [$th->getFile()]);
        Log::debug('ErrorMsg-', [$th->getMessage()]);
    }
}
