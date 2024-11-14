<?php

namespace App\Http\Controllers\admin\expenditure;

use App\core\expenditure\ExpenditureInterface;
use App\enum\ExpenditureTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public $expenditureInterface;
    public function __construct(ExpenditureInterface $expenditureInterface)
    {
        $this->expenditureInterface = $expenditureInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
    
        return view('admin.expenditure.index', [
            'expenditures' => $this->expenditureInterface->getAllExpenditures($request)->paginate(20),
            'totalCredit' => $this->expenditureInterface->getSeperateExpenditureTotal(ExpenditureTypeEnum::CREDIT, $fromDate, $toDate),
            'totalDebit' => $this->expenditureInterface->getSeperateExpenditureTotal(ExpenditureTypeEnum::DEBIT, $fromDate, $toDate),
            'fromDate' => $fromDate,
            'toDate' => $toDate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenditure.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ammount' => 'required|numeric',
            'debit_or_credit' => 'required|in:' . implode(',', ExpenditureTypeEnum::values()),
            'note' => 'required|string|max:1000',
            'date' => "required"
        ]);

        if ($this->expenditureInterface->storeExpenditure($data)) {
            return redirect()->route('expenditure-manages.index')->with('msg', 'Expenditure Added Successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.expenditure.edit', [
            'expenditure' => $this->expenditureInterface->getExpenditure(decrypt($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'ammount' => 'required|numeric',
            'debit_or_credit' => 'required|in:' . implode(',', ExpenditureTypeEnum::values()),
            'note' => 'required|string|max:1000',
            'date' => "required"
        ]);

        if ($this->expenditureInterface->updateExpenditure($data, $id)) {
            return back()->with('msg', 'Expenditure Updated Successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->expenditureInterface->deleteExpenditure($id)) {
            return back()->with('msg', 'Expenditure Deleted Successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }
}
