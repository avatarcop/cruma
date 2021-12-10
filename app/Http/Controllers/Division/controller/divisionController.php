<?php

namespace App\Http\Controllers\Division\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;

class divisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	$division = \App\Models\division::select('id', 'nama', 'desc', 'created_at', 'updated_at')->get();

        return view('division.division', compact('division'));
    }
    
    public function create()
    {
        return view('division.createDivision');
    }

    public function store(Request $request)
    {
        $simpan = new \App\Models\division;
        $simpan->nama = Input::get('nama'); 
        $simpan->desc = Input::get('desc');
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Division was successfully added!');

        return redirect('division');

    }

    public function edit($id)
    {
        $edit = \App\Models\division::find($id);
        return view('division.editDivision', compact('edit'));   
    }

    public function update($id, Request $request)
    {
    	
        $rubah = \App\Models\division::find($id);
        $rubah->nama = Input::get('nama');
        $rubah->desc = Input::get('desc');
        $rubah->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Division was successfully updated !');

        return redirect('division');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\division::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Division was successfully deleted !');

        return redirect('division');
    }


}
