<?php

namespace App\Http\Controllers\admin\dashboard;

use App\core\bookingregister\BookingRegisterInterface;
use App\core\member\MemberInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $memberInterface, $bookingRegisterInterface;
    public function __construct(MemberInterface $memberInterface, BookingRegisterInterface $bookingRegisterInterface)
    {
        $this->memberInterface = $memberInterface;
        $this->bookingRegisterInterface = $bookingRegisterInterface;
    }
    public function dashboard(Request $request)
    {
        return view('admin.dashboard.dashboard', [
            'membersCount' => $this->memberInterface->getAllMembers()->count(),
            'bookingCount' => $this->bookingRegisterInterface->getAllBookings($request)->count(),
            'patientCount' => User::query()->role()->count(),
            'latestBookings' => $this->bookingRegisterInterface->getAllBookings($request)->paginate(5),
        ]);
    }
}
