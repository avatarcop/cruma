<?php

namespace App\Http\Controllers\Staffrole\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;
class staffroleController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	$staffrole = \App\Models\staffrole::select('id', 'role_code', 'role_name', 'created_at', 'updated_at')->get();

    	return view('staffrole.staffrole', compact('staffrole'));
    }

    public function create()
    {
        return view('staffrole.createStaffrole');
    }

    public function store(Request $request)
    {


        $simpan = new \App\Models\staffrole;
        $simpan->route_access_list = json_encode(['routelist' => Input::get('routelist')]);
        $simpan->role_code = Input::get('role_code');
        $simpan->role_name = Input::get('role_name');
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Staffrole was successfully added!');

        return redirect('staffrole');

    }

    public function edit($id)
    {
        $edit = \App\Models\staffrole::find($id);
        return view('staffrole.editStaffrole', compact('edit'));   
    }

    public function update($id, Request $request)
    {

        $update = \App\Models\staffrole::find($id);
        $update->route_access_list = json_encode(['routelist' => Input::get('routelist')]);
        $update->role_code = Input::get('role_code');
        $update->role_name = Input::get('role_name');
        $update->update();
        
        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Staffrole was successfully updated !');

        return redirect('staffrole');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\staffrole::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Staffrole was successfully deleted !');

        return redirect('staffrole');
    }

    public function checkrolecode()
    {
        $cek = \App\Models\staffrole::where('role_code', Input::get('role_code'))->get();
        if(count($cek) > 0)
        {
            return "false";
        }else
        {
            return "true";
        }
    }
}
