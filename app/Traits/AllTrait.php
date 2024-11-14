<?php

namespace App\Traits;

use Illuminate\Support\Facades\View;

trait AllTrait
{
    public function getPrint($slug)
    {
        $data['bookingInfo'] = $this->bookingRegisterInterface->getBookingRegister($slug);
        return View::make('pdf.registerbooking-pdf', $data);
    }

    public function getPescriptionPrint($slug)
    {
        $data['bookingInfo'] = $this->bookingRegisterInterface->getBookingRegister($slug);
        return View::make('pdf.pescription', $data);
    }

    
}
