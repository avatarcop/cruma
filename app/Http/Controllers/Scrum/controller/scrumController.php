<?php

namespace App\Http\Controllers\Scrum\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;
class scrumController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	$scrum = \App\Models\scrum::select('id', 'scrum_card_no', 'project_id', 'urgency_id', 'estimate_id', 'deadline', 'analyst_id', 'status_id', 'subject', 'scrum_desc', 'notes', 'image', 'assign_time', 'finish_time', 'qc_time', 'created_at', 'updated_at')->get();

    	// Flash Message / Alert
    	// $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('scrum.scrum', compact('scrum'));
    }

    public function create()
    {
        $project = \App\Models\project::orderBy('project_name', 'asc')->where('status', 1)->get();
        $urgency = \App\Models\urgency::orderBy('urgency_name', 'asc')->get();
        $estimate = \App\Models\estimate::orderBy('hour', 'asc')->get();
        $status = \App\Models\status::orderBy('status_code', 'asc')->get();
        $division = \App\Models\division::orderBy('nama', 'asc')->get();
        $staffrole = \App\Models\staffrole::orderBy('role_name', 'asc')->get();

        $role_dev = \App\Models\staffrole::where('role_code', 'developer')->first();
        $role_ana = \App\Models\staffrole::where('role_code', 'analyst')->first();

        $developer = \App\Models\staff::orderBy('staff_name', 'asc')
                    ->whereHas('user', function($q) use ($role_dev) {
                        $q->where('role_id', $role_dev->id);
                    })
                    ->get();

        $analyst = \App\Models\staff::orderBy('staff_name', 'asc')
                    ->whereHas('user', function($q) use ($role_ana){
                        $q->where('role_id', $role_ana->id);
                    })
                    ->get();

        return view('scrum.createScrum', compact('project', 'urgency', 'estimate', 'status', 'division', 'staffrole', 'analyst', 'developer'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = \Carbon\Carbon::now();

        $project_data = \App\Models\project::where('id', $request->project_id)->first();
        $division_data = \App\Models\division::where('id', $project_data->division_id)->first();
        $status_data = \App\Models\status::where('id', $request->status_id)->first();

        $invoiceNumber = $project_data->project_code."".$division_data->division_code.$now->format('ymdHis');
        

        $simpan = new \App\Models\scrum;

        if($request->images != '')
        {
            $file = $request->file('images');
            $fileName = $file->getClientOriginalName();
            $request->file('images')->move("assets/images/", $fileName);

            $simpan->image = $fileName;
        }        

        $simpan->scrum_card_no = $invoiceNumber; 

        $simpan->project_id = $request->project_id;
        $simpan->urgency_id = $request->urgency_id;
        $simpan->estimate_id = $request->estimate_id;
        $simpan->deadline = $request->deadline;
        $simpan->analyst_id = $request->analyst_id;
        $simpan->status_id = $request->status_id;
        $simpan->subject = $request->subject;
        $simpan->scrum_desc = $request->scrum_desc;
        $simpan->notes = $request->notes;

        if($request->developer_id != '')
        {
            if($status_data->status_code == '1')
            {
                $simpan->assign_time = $now;    
            }elseif($status_data->status_code == '2')
            {
                $simpan->qc_time = $now;    
            }elseif($status_data->status_code == '4')
            {
                $simpan->finish_time = $now;    
            }
            
        }

        $simpan->save();

        if($request->developer_id != '')
        {
            // Transactions simpan developer
            $transaction = new \App\Models\transaction;
            $transaction->scrum_id = $simpan->id;
            $transaction->developer_id = $request->developer_id;
            $transaction->save();
        }

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Scrum was successfully added!');

        // Jika analis
        if(\App\Models\user::find(\Auth::user()->id)->role_id == '2')
        {
            return redirect('myscrum_analyst');
        }else{
            return redirect('scrum');
        }

    }

    public function edit($id)
    {

        $project = \App\Models\project::orderBy('project_name', 'asc')->where('status', 1)->get();
        $urgency = \App\Models\urgency::orderBy('urgency_name', 'asc')->get();
        $estimate = \App\Models\estimate::orderBy('hour', 'asc')->get();
        $status = \App\Models\status::orderBy('status_name', 'asc')->get();
        $division = \App\Models\division::orderBy('nama', 'asc')->get();
        $staffrole = \App\Models\staffrole::orderBy('role_name', 'asc')->get();

        $role_dev = \App\Models\staffrole::where('role_code', 'developer')->first();
        $role_ana = \App\Models\staffrole::where('role_code', 'analyst')->first();

        $developer = \App\Models\staff::orderBy('staff_name', 'asc')
                    ->whereHas('user', function ($query) use ($role_dev){
                        $query->where('role_id', $role_dev->id);
                    })
                    ->get();

        $analyst = \App\Models\staff::orderBy('staff_name', 'asc')
                    ->whereHas('user', function ($query) use ($role_ana){
                        $query->where('role_id', $role_ana->id);
                    })
                    ->get();

        $edit = \App\Models\scrum::find($id);

        return view('scrum.editScrum', compact('edit', 'project', 'urgency', 'estimate', 'status', 'division', 'staffrole', 'analyst', 'developer'));   
        

        
    }

    public function update($id, Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $now = \Carbon\Carbon::now();

        $project_data = \App\Models\project::where('id', $request->project_id)->first();
        $division_data = \App\Models\division::where('id', $project_data->division_id)->first();
        $status_data = \App\Models\status::where('id', $request->status_id)->first();

        // $invoiceNumber = $project_data->project_code."".$division_data->division_code.$now->format('ymdHis');
        

        $edit = \App\Models\scrum::find($id);

        if($request->images != '')
        {
            $file = $request->file('images');
            $fileName = $file->getClientOriginalName();
            $request->file('images')->move("assets/images/", $fileName);

            $simpan->image = $fileName;
        }        

        // $edit->scrum_card_no = $invoiceNumber; 

        $edit->project_id = $request->project_id;
        $edit->urgency_id = $request->urgency_id;
        $edit->estimate_id = $request->estimate_id;
        $edit->deadline = $request->deadline;
        $edit->analyst_id = $request->analyst_id;
        $edit->status_id = $request->status_id;
        $edit->subject = $request->subject;
        $edit->scrum_desc = $request->scrum_desc;
        $edit->notes = $request->notes;

        if($request->developer_id != '')
        {
            if($status_data->status_code == '1')
            {
                $edit->assign_time = $now;    
            }elseif($status_data->status_code == '2')
            {
                $edit->qc_time = $now;    
            }elseif($status_data->status_code == '4')
            {
                $edit->finish_time = $now;    
            }
            
        }

        $edit->update();

        // Transactions edit developer
        $transaction = \App\Models\transaction::where('scrum_id', $edit->id)->first();

        if($transaction === null)
        {
            $transaction = new \App\Models\transaction;
            $transaction->scrum_id = $edit->id;
            $transaction->developer_id = $request->developer_id;
            $transaction->save();   
               
        }else{
            $transaction->developer_id = $request->developer_id;
            $transaction->update(); 
        }
    

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Scrum was successfully updated !');

        // Jika analis
        if(\App\Models\user::find(\Auth::user()->id)->role_id == '2')
        {
            return redirect('myscrum_analyst');
        }else{
            return redirect('scrum');
        }
    }

    public function delete($id, Request $request)
    {
        $hapus = \App\Models\transaction::where('scrum_id', $id)->first();
        
        $hapus->delete();

        $hapus = \App\Models\scrum::find($id);

        $hapus->delete();


        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Scrum was successfully deleted !');

        return redirect('myscrum_analyst');
    }

    public function take($id, Request $request)
    {
        $id_staff = \App\Models\staff::where('user_id', \Auth::user()->id)->first();
        $status_id = \App\Models\status::where('status_code', '1')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($id);
        $take->status_id = $status_id;
        $take->assign_time = \Carbon\Carbon::now();
        $take->update();


        // Update transaction
        $trans_old = \App\Models\transaction::where('scrum_id', $take->id)->get();
        
        if(count($trans_old) > 0)
        {
            foreach ($trans_old as $key) {
                $trans_old = \App\Models\transaction::find($key->id);
                $trans_old->delete();
            }
        }

        // Update Transaction (DEFAULT AKBAR DEVELOPER)
        $transaction = new \App\Models\transaction;
        $transaction->scrum_id = $take->id;
        $transaction->developer_id = $id_staff->id;
        $transaction->save();    

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Scrum was successfully taken !');

        return redirect('scrummarket');
    }

    public function finish($id, Request $request)
    {
        $status_id = \App\Models\status::where('status_code', '4')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($id);
        $take->status_id = $status_id;
        $take->finish_time = \Carbon\Carbon::now();
        $take->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Scrum was successfully finished !');

        return redirect('myscrum_analyst');
    }

    public function finishdev($id, Request $request)
    {
        $status_id = \App\Models\status::where('status_code', '2')->first()->id;
        
        // Update scrum status dan assigntime
        $finish = \App\Models\scrum::find($id);
        $finish->status_id = $status_id;
        $finish->qc_time = \Carbon\Carbon::now();
        $finish->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Scrum was successfully finished !');

        return redirect('myscrum_dev');
    }

    public function finetuning($id, Request $request)
    {
        $status_id = \App\Models\status::where('status_code', '3')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($id);
        $take->status_id = $status_id;
        $take->update();

        // Flash Message / Alert
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Scrum was successfully become fine tuning !');

        return redirect('myscrum_analyst');
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



    public function myscrum_dev(Request $request)
    {
        $status_waiting = \App\Models\status::where('status_code', '2')->first()->id;
        $status_noassign = \App\Models\status::where('status_code', '0')->first()->id;
        $status_finish = \App\Models\status::where('status_code', '4')->first()->id;

        $staff_id = \App\Models\staff::where('user_id', \Auth::user()->id)->first()->id;

        $scrum = \App\Models\scrum::with('transaction')
            ->whereHas('transaction', function($q) use ($staff_id){
                $q->where('developer_id', $staff_id);
            })
            ->where('status_id', '!=', $status_noassign)
            ->orderBy('deadline', 'asc')
            ->get();

        

        // Flash Message / Alert
        // $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('scrum.myscrumdev', compact('scrum', 'status_waiting', 'status_finish'));
    }

    public function myscrum_analyst(Request $request)
    {
        $staff_id = \App\Models\staff::where('user_id', \Auth::user()->id)->first()->id;

        $scrum = \App\Models\scrum::with('transaction')
            ->where('analyst_id', $staff_id)
            ->orderBy('deadline', 'asc')
            ->get();

        $status_waiting = \App\Models\status::where('status_code', '2')->first()->id;
        $status_finetuning = \App\Models\status::where('status_code', '3')->first()->id;
        $status_finish = \App\Models\status::where('status_code', '4')->first()->id;
        $status_progress = \App\Models\status::where('status_code', '1')->first()->id;
        $status_noassign = \App\Models\status::where('status_code', '0')->first()->id;
        // Flash Message / Alert
        // $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('scrum.myscrumanalyst', compact('scrum', 'status_waiting', 'status_noassign', 'status_finetuning', 'status_finish', 'status_progress'));
    }


    public function scrummarket(Request $request)
    {
        $id_user = \Auth::user()->id;
        $staff = \App\Models\staff::where('user_id', $id_user)->first();

        if($staff->division_id == '')
        {
            $scrum = \App\Models\scrum::with('status')
            ->whereHas('status', function($q){
                $q->where('status_code', '0');
            })
            ->orderBy('deadline', 'asc')
            ->get();    
        }else{
            $division = \App\Models\division::find($staff->division_id);
            $division_id = $division->id;

            $scrum = \App\Models\scrum::with('status', 'project')
                ->whereHas('status', function($q){
                    $q->where('status_code', '0');
                })
                ->whereHas('project', function($q) use ($division_id){
                    $q->where('division_id', $division_id);
                })
                ->orderBy('deadline', 'asc')
                ->get(); 
             
        }

        


        // Flash Message / Alert
        // $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('scrum.scrummarket', compact('scrum'));
    }








}
