<?php

namespace App\Http\Controllers\Client\controller;

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

class clientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $client = \App\Models\client::select('id', 'client_code', 'client_name', 'created_at')->get();

        // Flash Message / Alert
        // $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');
        
        return view('client.client', compact('client'));
    }

    public function create()
    {
        return view('client.createClient');
    }

    public function store(Request $request)
    {
        $simpan = new \App\Models\client;
        $simpan->client_code = strtoupper(Input::get('client_code')); 
        $simpan->client_name = Input::get('client_name');
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Client was successfully added!');

        return redirect('client');

    }

    public function edit($id)
    {
        $edit = \App\Models\client::find($id);
        return view('client.editClient', compact('edit'));   
    }

    public function update($id, Request $request)
    {
        
        $rubah = \App\Models\client::find($id);
        $rubah->client_name = Input::get('client_name');
        $rubah->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Client was successfully updated !');

        return redirect('client');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\client::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Client was successfully deleted !');

        return redirect('client');
    }

    public function checkclientcode()
    {
        $cek = \App\Models\client::where('client_code', Input::get('client_code'))->get();
        if(count($cek) > 0)
        {
            return "false";
        }else
        {
            return "true";
        }
    }


}
