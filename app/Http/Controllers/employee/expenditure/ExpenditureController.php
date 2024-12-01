<?php

namespace App\Http\Controllers\employee\expenditure;

use App\core\expenditure\ExpenditureInterface;
use App\core\member\MemberInterface;
use App\enum\ExpenditureCategoryEnum;
use App\enum\ExpenditurePaymentModeEnum;
use App\enum\ExpenditureTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    public $expenditureInterface, $memberInterface;
    public function __construct(ExpenditureInterface $expenditureInterface, MemberInterface $memberInterface)
    {
        $this->expenditureInterface = $expenditureInterface;
        $this->memberInterface = $memberInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        return view('employee.expenditure.index', [
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
        return view('employee.expenditure.create', [
            'stuffs' => $this->memberInterface->getAllMembers('stuffs'),
            'members' => $this->memberInterface->getAllMembers('members')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'donation_type' => 'required|in:' . implode(',', ExpenditureCategoryEnum::values()),
            'ammount' => 'required|numeric',
            'debit_or_credit' => 'required|in:' . implode(',', ExpenditureTypeEnum::values()),
            'note' => 'required|string|max:1000',
            'date' => "required|date",
            'unique_personal_doc_name' => $request?->donation_type == 'Donation' ? 'required|string' : 'nullable',
            'unique_personal_doc_id' => $request?->donation_type == 'Donation' ? 'required|string' : 'nullable',
            'id_code' => $request?->donation_type == 'Donation' ? 'required|string' : 'nullable',
            'section_code' => $request?->donation_type == 'Donation' ? 'required|string' : 'nullable',
            'payment_mode' => $request?->donation_type == 'Donation' ? 'required|in:' . implode(',', ExpenditurePaymentModeEnum::values()) : 'nullable',
            'name_of_donor' => $request?->donation_type == 'Donation' ? 'required|string' : 'nullable',
            'address_of_donor' => $request?->donation_type == 'Donation' ? 'required|string' : 'nullable',
            'member_id' => ($request?->donation_type == 'Salary' || $request?->donation_type == 'Member Payment') ? 'required|exists:members,id' : 'nullable',

        ]);

        if ($this->expenditureInterface->storeExpenditure($data)) {
            return response()->json([
                "status" => "success",
                "toUrl" => route('recep-expenditure-manages.index'),
                "msg" => $request?->donation_type . " Added Successfully..!"
            ]);
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
        return view('employee.expenditure.edit', [
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
