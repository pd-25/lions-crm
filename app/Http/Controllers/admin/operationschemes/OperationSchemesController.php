<?php

namespace App\Http\Controllers\admin\operationschemes;

use App\core\operationschemes\OperationSchemeInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperationSchemesController extends Controller
{
    private $operationSchemeInterface;
    public function __construct(OperationSchemeInterface $operationSchemeInterface)
    {
        $this->operationSchemeInterface = $operationSchemeInterface;
    }

    public function index()
    {
        return view('admin.operationschemes.index', [
            'operationschemes' => $this->operationSchemeInterface->getAllOperationSchemes()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.operationschemes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'nullable|numeric'
        ]);

        $insertMember = $this->operationSchemeInterface->addNewOperationScheme($request->only('name', 'price'));
        if ($insertMember) {
            return redirect()->route('operation-schemes.index')->with('msg', 'Operation Schemes Added Successfully..');
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
    public function edit(string $slug)
    {
        return view('admin.operationschemes.edit', [
            'operationscheme' => $this->operationSchemeInterface->getOperationScheme($slug)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'nullable|numeric'
        ]);

        $insertMember = $this->operationSchemeInterface->updateOperationScheme($request->only('name', 'price'), $slug);
        if ($insertMember) {
            return redirect()->route('operation-schemes.index')->with('msg', 'Operation Schemes Updated Successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $deleteOperationScheme = $this->operationSchemeInterface->deleteOperationScheme($slug);
        if ($deleteOperationScheme) {
            return back()->with('msg', 'The Operation Scheme Has been deleted successfully..');
        } else {
            return back()->with('msg', 'Some error occur..');
        }
    }
}
