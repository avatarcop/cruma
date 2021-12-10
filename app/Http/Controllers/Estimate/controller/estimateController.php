<?php

namespace App\Http\Controllers\Estimate\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;

class estimateController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	$estimate = \App\Models\estimate::select('id', 'hour', 'desc', 'created_at', 'updated_at')->get();

    	// Flash Message / Alert
    	// $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('estimate.estimate', compact('estimate'));
    }

    public function create()
    {
        return view('estimate.createEstimate');
    }

    public function store(Request $request)
    {
        $simpan = new \App\Models\estimate;
        $simpan->hour = Input::get('hour'); 
        $simpan->desc = Input::get('desc'); 
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Estimate was successfully added !');

        return redirect('estimate');

    }

    public function edit($id)
    {
        $edit = \App\Models\estimate::find($id);
        return view('estimate.editEstimate', compact('edit'));   
    }

    public function update($id, Request $request)
    {
        
        $rubah = \App\Models\estimate::find($id);
        $rubah->hour = Input::get('hour');
        $rubah->desc = Input::get('desc');
        $rubah->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Estimate was successfully updated !');

        return redirect('estimate');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\estimate::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Estimate was successfully deleted !');

        return redirect('estimate');
    }
}
