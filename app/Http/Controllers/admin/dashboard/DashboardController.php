<?php

namespace App\Http\Controllers\admin\dashboard;

use App\core\bookingregister\BookingRegisterInterface;
use App\core\member\MemberInterface;
use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    private $memberInterface, $bookingRegisterInterface;
    public function __construct(MemberInterface $memberInterface, BookingRegisterInterface $bookingRegisterInterface)
    {
        $this->memberInterface = $memberInterface;
        $this->bookingRegisterInterface = $bookingRegisterInterface;
    }
    public function dashboard()
    {
        return view('admin.dashboard.dashboard', [
            'membersCount' => $this->memberInterface->getAllMembers()->count(),
            'bookingCount' => $this->bookingRegisterInterface->getAllBookings()->count(),
            'patientCount' => User::query()->role()->count(),
            'latestBookings' => $this->bookingRegisterInterface->getAllBookings()->paginate(5),
        ]);
    }
}
