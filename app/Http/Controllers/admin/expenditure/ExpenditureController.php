<?php

namespace App\Http\Controllers\admin\expenditure;

use App\core\expenditure\ExpenditureInterface;
use App\core\member\MemberInterface;
use App\enum\ExpenditureCategoryEnum;
use App\enum\ExpenditurePaymentModeEnum;
use App\enum\ExpenditureTypeEnum;
use App\Exports\ExpenditureExport;
use App\Http\Controllers\Controller;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        return view('admin.expenditure.create', [
            'stuffs' => $this->memberInterface->getAllMembers('stuffs'),
            'members' => $this->memberInterface->getAllMembers('members')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'ammount' => 'required|numeric',
        //     'debit_or_credit' => 'required|in:' . implode(',', ExpenditureTypeEnum::values()),
        //     'note' => 'required|string|max:1000',
        //     'date' => "required"
        // ]);
        $data = $request->validate([
            'donation_type' => 'required|in:' . implode(',', ExpenditureCategoryEnum::values()),
            'donation_sub_type' => function ($attribute, $value, $fail) use ($request) {
                $donationType = $request->donation_type;
                $debitOrCredit = $request->debit_or_credit;
                $validSubTypes = ExpenditureCategoryEnum::categoriesByType()[$debitOrCredit][$donationType] ?? [];
                if (!in_array($value, $validSubTypes)) {
                    $fail("The selected sub-category is invalid for the {$debitOrCredit} type and {$donationType} category.");
                }
            },
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
            'member_id' => ($request?->donation_sub_type == 'Salary' || $request?->donation_sub_type == 'New Member Subscription' || $request?->donation_sub_type == 'Old Member Subscription') ? 'required|exists:members,id' : 'nullable',

        ]);

        if ($this->expenditureInterface->storeExpenditure($data)) {
            return response()->json([
                "status" => "success",
                "toUrl" => route('expenditure-manages.index'),
                "msg" => $request?->donation_type . " Added Successfully..!"
            ]);
            // return redirect()->route('expenditure-manages.index')->with('msg', 'Expenditure Added Successfully..');
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

    public function export(Request $request)
    {
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');
        $donationType = $request->query('donation_type');
        $query = Expenditure::query()->with('member');
        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        if ($donationType) {
            $query->where('donation_type', $donationType);
        }

        $expenditures = $query->get();

        return Excel::download(new ExpenditureExport($expenditures), 'expenditures.xlsx');
    }
}
