<?php
namespace App\core\bookingregister;

interface BookingRegisterInterface {
    public function checkIfPatientExist($givenInput);
    public function getAllBookings($request);
    public function getAllBookingTypes();
    public function createBookingRegister(array $userData, array $bookingData);
    public function getBookingRegister($slug);
    
    public function generatePdf($slug);
    public function updatePayment($dueAmount, $booking_id, $originalAmount);
    
}