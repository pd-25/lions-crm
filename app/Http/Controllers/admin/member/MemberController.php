<?php

namespace App\Http\Controllers\admin\member;

use App\core\member\MemberInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $memberInterface;
    public function __construct( MemberInterface $memberInterface){
        $this->memberInterface = $memberInterface;
    }
    public function index()
    {
        return view('admin.member.index', [
            'members' => $this->memberInterface->getAllMembers()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|string'
        ]);

        $insertMember = $this->memberInterface->addNewMember($request->only('name', 'email', 'phone', 'join_date', 'image'));
        if($insertMember) {
            return redirect()->route('members.index')->with('msg', 'Member Added Successfully..');
        }else{
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
        return view('admin.member.edit', [
            'member' => $this->memberInterface->getMember($slug)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|string'
        ]);

        $insertMember = $this->memberInterface->updateMember($request->only('name', 'email', 'phone', 'join_date', 'image'), $slug);
        if($insertMember) {
            return back()->with('msg', 'Member Data Editied Successfully..');
        }else{
            return back()->with('msg', 'Some error occur..');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $deleteMember = $this->memberInterface->deleteMember($slug);
        if($deleteMember) {
            return back()->with('msg', 'The Member Has been deleted successfully..');
        }else{
            return back()->with('msg', 'Some error occur..');
        }
    }
}
