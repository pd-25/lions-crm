<?php

namespace App\Http\Controllers\admin\expenditure;

use App\core\expenditure\ExpenditureInterface;
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
    public function index()
    {
        return view('admin.expenditure.index', [
            'expenditures' => $this->expenditureInterface->getAllExpenditures()->paginate(20)
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
