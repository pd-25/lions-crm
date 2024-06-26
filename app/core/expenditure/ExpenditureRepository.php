<?php

namespace App\core\expenditure;

use App\Models\Expenditure;
use Illuminate\Http\Request;

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

        // Apply date filters if provided
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            
            // Debugging dates
            \Log::info('Filtering expenditures from ' . $fromDate . ' to ' . $toDate);
            
            // Ensure dates are in correct format
            try {
                $fromDate = \Carbon\Carbon::parse($fromDate)->startOfDay();
                $toDate = \Carbon\Carbon::parse($toDate)->endOfDay();
            } catch (\Exception $e) {
                \Log::error('Invalid date format: ' . $e->getMessage());
            }

            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }

        return $query;
    }

    public function storeExpenditure(array $data)
    {
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
