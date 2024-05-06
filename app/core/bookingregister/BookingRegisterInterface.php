<?php
namespace App\core\bookingregister;

interface BookingRegisterInterface {
    public function checkIfPatientExist($givenInput);
    public function getAllBookings();
    public function getAllBookingTypes();
    
    
}