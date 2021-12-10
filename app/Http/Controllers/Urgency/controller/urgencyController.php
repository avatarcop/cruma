<?php

namespace App\Http\Controllers\Urgency\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Session;

use Response;

use \Carbon\Carbon;
class urgencyController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $urgency = \App\Models\urgency::select('id', 'urgency_name', 'created_at')->get();

        return view('urgency.urgency', compact('urgency'));
    }

    public function create()
    {
        return view('urgency.createUrgency');
    }

    public function store(Request $request)
    {
        $simpan = new \App\Models\urgency;
        $simpan->urgency_name = Input::get('urgency_name'); 
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Urgency was successfully added !');

        return redirect('urgency');

    }

    public function edit($id)
    {
        $edit = \App\Models\urgency::find($id);
        return view('urgency.editUrgency', compact('edit'));   
    }

    public function update($id, Request $request)
    {
        
        $rubah = \App\Models\urgency::find($id);
        $rubah->urgency_name = Input::get('urgency_name');
        $rubah->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Urgency was successfully updated !');

        return redirect('urgency');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\urgency::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Urgency was successfully deleted !');

        return redirect('urgency');
    }

  
}
