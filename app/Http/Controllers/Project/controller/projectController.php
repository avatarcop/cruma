<?php

namespace App\Http\Controllers\Project\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;
class projectController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
    	$project = \App\Models\project::select('id', 'project_code', 'project_name', 'client_id', 'division_id', 'status', 'created_at', 'updated_at')->get();

    	// Flash Message / Alert
    	// $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('project.project', compact('project'));
    }

    public function create()
    {
        $client = \App\Models\client::orderBy('client_name', 'asc')->get();
        $division = \App\Models\division::orderBy('nama', 'asc')->get();

        return view('project.createProject', compact('client', 'division'));
    }

    public function store(Request $request)
    {
        $simpan = new \App\Models\project;
        $simpan->project_code = Input::get('project_code'); 
        $simpan->project_name = Input::get('project_name'); 
        $simpan->client_id = Input::get('client_id'); 
        $simpan->division_id = Input::get('division_id'); 
        // $simpan->project_type_id = Input::get('project_type_id'); 
        $simpan->status = Input::get('status'); 
        $simpan->save();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Project was successfully added !');

        return redirect('project');

    }

    public function edit($id)
    {
        $edit = \App\Models\project::find($id);
        $client = \App\Models\client::orderBy('client_name', 'asc')->get();
        $division = \App\Models\division::orderBy('nama', 'asc')->get();

        return view('project.editProject', compact('edit', 'client', 'division'));   
    }

    public function update($id, Request $request)
    {
        
        $rubah = \App\Models\project::find($id);
        $rubah->project_name = Input::get('project_name'); 
        $rubah->client_id = Input::get('client_id'); 
        $rubah->division_id = Input::get('division_id'); 
        // $rubah->project_type_id = Input::get('project_type_id'); 
        $rubah->status = Input::get('status'); 
        $rubah->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Project was successfully updated !');

        return redirect('project');
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\project::find($id);
        $hapus->delete();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Project was successfully deleted !');

        return redirect('project');
    }

    public function checkprojectcode()
    {
        $cek = \App\Models\project::where('project_code', Input::get('project_code'))->get();
        if(count($cek) > 0)
        {
            return "false";
        }else
        {
            return "true";
        }
    }


}
