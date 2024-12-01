<?php

namespace App\core\expenditure;

use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenditureRepository implements ExpenditureInterface
{
    // public function getAllExpenditures(Request $request)
    // {
    //     $query = Expenditure::query()->orderByDesc('id');

    //     // Apply date filters if provided
    //     if ($request->has('from_date') && $request->has('to_date')) {
    //         $fromDate = $request->input('from_date');
    //         $toDate = $request->input('to_date');
    //         $query->whereBetween('created_at', [$fromDate, $toDate]);
    //     }

    //     return $query;
    // }
    public function getAllExpenditures(Request $request)
    {

        $query = Expenditure::query()->orderByDesc('id');

        if ($request->from_date && $request->to_date) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            Log::info('Filtering expenditures from ' . $fromDate . ' to ' . $toDate);
            try {
                $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
                $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();
            } catch (\Exception $e) {
                Log::error('Invalid date format: ' . $e->getMessage());
            }

            $query->whereBetween('date', [$fromDate, $toDate]);
        }
        if ($request->donation_type) {
            $query->Where('donation_type', $request->donation_type);
        }


        return $query;
    }

    public function storeExpenditure(array $data)
    {
        if (Auth::guard('admin')->check()) {
            $data['done_by_user_or_admin'] = 'admin';
            $data['receptionist_id'] = auth()->guard('admin')->id();
        } elseif (Auth::check()) {
            $data['done_by_user_or_admin'] = 'user';
            $data['receptionist_id'] = auth()->id();
        }

        // $data['receptionist_id'] = 
        $store = Expenditure::create($data);
        if ($store instanceof Expenditure) {
            return true;
        } else {
            return false;
        }
    }

    public function getExpenditure(int $id)
    {
        return Expenditure::findOrFail($id);
    }

    public function updateExpenditure($data, $id)
    {
        $findExpenditure = Expenditure::findOrFail($id);
        if ($findExpenditure) {
            return $findExpenditure->update($data);
        } else {
            return false;
        }
    }

    public function deleteExpenditure($id)
    {
        $findExpenditure = Expenditure::findOrFail($id);
        if ($findExpenditure) {
            return $findExpenditure->delete();
        } else {
            return false;
        }
    }

    // public function getSeperateExpenditureTotal($type, $fromDate = null, $toDate = null)
    // {
    //     $query = Expenditure::where('debit_or_credit', $type);

    //     if ($fromDate && $toDate) {
    //         $query->whereBetween('created_at', [$fromDate, $toDate]);
    //     }

    //     return $query->sum('ammount');
    // }
    public function getSeperateExpenditureTotal($type, $fromDate = null, $toDate = null)
    {
        $query = Expenditure::where('debit_or_credit', $type);

        if ($fromDate && $toDate) {
            $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
            $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        return $query->sum('ammount');
    }
}
