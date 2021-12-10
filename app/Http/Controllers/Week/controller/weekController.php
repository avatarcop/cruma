<?php

namespace App\Http\Controllers\Week\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;

class weekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	$week = \App\Models\week::all();
        return view('week.week', compact('week'));
    }

    public function create()
    {
        return view('week.createWeek');
    }

    public function store(Request $request)
    {
        $bulanskrg= substr(Input::get('tgl_awal'), 5, 2);
        $tahunskrg= substr(Input::get('tgl_awal'), 0, 4);
       
        $simpan = new \App\Models\week;
        $simpan->week = Input::get('week'); 
        $simpan->bulan = $bulanskrg;
        $simpan->tahun = $tahunskrg;
        $simpan->tgl_awal = substr(Input::get('tgl_awal'), 0, 10).' 00:00:00';
        $simpan->tgl_akhir =substr(Input::get('tgl_akhir'), 0, 10).' 23:59:00';
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Week was successfully added!');

        return redirect('week');

    }

    public function edit($id)
    {
        $edit = \App\Models\week::find($id);
        return view('week.editWeek', compact('edit'));   
    }

    public function update($id, Request $request)
    {
        $bulanskrg= substr(Input::get('tgl_awal'), 5, 2);
        $tahunskrg= substr(Input::get('tgl_awal'), 0, 4);
        
        $rubah = \App\Models\week::find($id);
        $rubah->week = Input::get('week');
        $rubah->bulan = $bulanskrg;
        $rubah->tahun = $tahunskrg;
        $rubah->tgl_awal = substr(Input::get('tgl_awal'), 0, 10).' 00:00:00';
        $rubah->tgl_akhir = substr(Input::get('tgl_akhir'), 0, 10).' 23:59:00';
        $rubah->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Week was successfully updated !');

        return redirect('week');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\week::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Week was successfully deleted !');

        return redirect('week');
    }

}
