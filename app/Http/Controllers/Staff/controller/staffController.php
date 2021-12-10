<?php

namespace App\Http\Controllers\Staff\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;

class staffController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	$staff = \App\Models\staff::all();

    	// Flash Message / Alert
    	// $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('staff.staff', compact('staff'));
    }

    public function create()
    {
        $division = \App\Models\division::orderBy('nama', 'asc')->get();
        $staffrole = \App\Models\staffrole::orderBy('role_name', 'asc')->get();
        return view('staff.createStaff', compact('division', 'staffrole'));
    }

    public function store(Request $request)
    {
        $user = new \App\Models\user;
        $user->name = $request->staff_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username = $request->staff_code; 
        $user->role_id = $request->role_id;
        $user->save();

        $simpan = new \App\Models\staff;        
            $file = $request->file('avatar');
            $fileName = $file->getClientOriginalName();
            $request->file('avatar')->move("assets/images/", $fileName);

        $simpan->avatar = $fileName;
        $simpan->staff_code = $request->staff_code; 
        $simpan->staff_name = $request->staff_name;
        $simpan->division_id = $request->division_id;
        $simpan->status = $request->status;
        $simpan->user_id = $user->id;
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Staff was successfully added!');

        return redirect('staff');

    }

    public function edit($id)
    {
        $edit = \App\Models\staff::find($id);
        $division = \App\Models\division::orderBy('nama', 'asc')->get();
        $staffrole = \App\Models\staffrole::orderBy('role_name', 'asc')->get();
        return view('staff.editStaff', compact('edit', 'division', 'staffrole'));   
    }

    public function update($id, Request $request)
    {
        
        $rubah = \App\Models\staff::find($id);
        $user = \App\Models\user::find($rubah->user_id);

        $user->name = Input::get('staff_name');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->role_id = Input::get('role_id');
        $user->update();

        if($request->avatar != '')
        { 
            $file = $request->file('avatar');
            $fileName = $file->getClientOriginalName();
            $request->file('avatar')->move("assets/images/", $fileName);

            $rubah->avatar = $fileName;             
        }

        $rubah->staff_name = Input::get('staff_name');
        $rubah->division_id = Input::get('division_id');
        $rubah->status = Input::get('status');
        $rubah->update();

        

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Staff was successfully updated !');

        return redirect('staff');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\staff::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Staff was successfully deleted !');

        return redirect('staff');
    }

    public function checkstaffcode()
    {
        $cek = \App\Models\staff::where('staff_code', Input::get('staff_code'))->get();
        if(count($cek) > 0)
        {
            return "false";
        }else
        {
            return "true";
        }
    }


}
