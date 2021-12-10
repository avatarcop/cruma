<?php

namespace App\Http\Controllers\Status\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;
class statusController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	$status = \App\Models\status::select('id', 'status_code', 'status_name', 'created_at', 'updated_at')->get();

    	// Flash Message / Alert
    	// $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('status.status', compact('status'));
    }

    public function create()
    {
        return view('status.createStatus');
    }

    public function store(Request $request)
    {
        $simpan = new \App\Models\status;
        $simpan->status_code = Input::get('status_code'); 
        $simpan->status_name = Input::get('status_name');
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Status was successfully added!');

        return redirect('status');

    }

    public function edit($id)
    {
        $edit = \App\Models\status::find($id);
        return view('status.editStatus', compact('edit'));   
    }

    public function update($id, Request $request)
    {
        
        $rubah = \App\Models\status::find($id);
        $rubah->status_name = Input::get('status_name');
        $rubah->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Status was successfully updated !');

        return redirect('status');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\status::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Status was successfully deleted !');

        return redirect('status');
    }

    public function checkstatuscode()
    {
        $cek = \App\Models\status::where('status_code', Input::get('status_code'))->get();
        if(count($cek) > 0)
        {
            return "false";
        }else
        {
            return "true";
        }
    }
}
