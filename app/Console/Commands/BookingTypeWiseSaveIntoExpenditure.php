<?php

namespace App\Console\Commands;

use App\enum\ExpenditureCategoryEnum;
use App\enum\ExpenditureTypeEnum;
use App\Models\Expenditure;
use App\Models\RegisterBooking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BookingTypeWiseSaveIntoExpenditure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:booking-type-wise-save-into-expenditure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterdayStart = Carbon::yesterday()->startOfDay();
        $yesterdayEnd = Carbon::yesterday()->endOfDay();

        // $yesterdaysBooking = RegisterBooking::with('bookingType')
        // ->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
        // ->get()
        // ->groupBy(function ($booking) {
        //     return $booking->bookingType->type_name ?? 'Unknown'; // Group by type name
        // })
        // ->map(function ($bookings, $typeName) {
        //     $totalPayment = $bookings->sum(function ($booking) {
        //         return $booking->bookingPaymrnts->sum('amount'); // Sum of payments for each booking
        //     });
        //     return [
        //         'type_name' => $typeName,
        //         'total_payment' => $totalPayment,
        //     ];
        // });

        $yesterdaysBooking = RegisterBooking::selectRaw('booking_types.type_name, SUM(booking_payments.amount) as total_payment')
            ->join('booking_types', 'register_bookings.booking_type_id', '=', 'booking_types.id')
            ->join('booking_payments', 'register_bookings.id', '=', 'booking_payments.register_booking_id')
            ->whereBetween('register_bookings.created_at', [$yesterdayStart, $yesterdayEnd])
            ->groupBy('booking_types.type_name')->get();
        if (!empty($yesterdaysBooking)) {

            $yesterdaysBooking->each(function ($booking) {
                $registerBookingTypeName = trim(str_replace('collection', '', strtolower($booking->type_name)));
                foreach (ExpenditureCategoryEnum::categoriesByType()['Credit']['Service'] as $serviceTypeName) {
                    $typeName = trim(str_replace('collection', '', strtolower($serviceTypeName)));

                    if ($typeName == $registerBookingTypeName) {
                        $expenditure = new Expenditure();
                        $expenditure->done_by_user_or_admin = 'admin';
                        $expenditure->ammount = $booking->total_payment;
                        $expenditure->debit_or_credit = ExpenditureTypeEnum::CREDIT;
                        $expenditure->note = 'Automated created by booking type wise on ' . Carbon::yesterday()->format('Y-m-d');
                        $expenditure->date = Carbon::yesterday()->format('Y-m-d');
                        $expenditure->name_of_donor = 'Automated';
                        $expenditure->address_of_donor = 'Automated';
                        $expenditure->donation_type = ExpenditureCategoryEnum::SERVICE;
                        $expenditure->receptionist_id = 1;
                        $expenditure->donation_sub_type = $serviceTypeName;
                        $expenditure->save();
                        echo "Expenditure created for " . $serviceTypeName . " with amount " . $booking->total_payment . "\n";
                       logger("Expenditure created for " . $serviceTypeName . " with amount " . $booking->total_payment . "\n");
                    }
                };
               
            });
        }
    }
}
