<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;

use DB;
use Hash;
use Session;
use Log;
use Response;

use \Carbon\Carbon;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tglpertama_blnini = Carbon::today()->startOfMonth();
        $blnkemaren = $tglpertama_blnini->copy()->subMonth();
        $skrg = \carbon\carbon::now();

        $scrum_analyst = \App\Models\scrum::all();
        
        $week = \App\Models\week::
        where('tgl_awal', '<', $skrg)
        // ->where('tgl_awal', '<', $skrg )
        ->orderBy('tgl_awal', 'desc')
        ->get();

        // // pantek week, ambil week 3
        // $week = \App\Models\week::
        // where('tgl_awal', '>', '2018-09-20')
        // ->where('tgl_awal', '<', '2018-10-26' )
        // ->get();

        return view('index', compact('week', 'scrum_analyst'));
    }

    public function grafik()
    {   
        $week = \App\Models\week::find(Input::get('week'));
        $status = \App\Models\status::where('status_code', 4)->first()->id;
       
        // analyst
        $scrum_analyst  = DB::table('scrums')
                ->select(DB::raw('scrums.analyst_id as staff_id'), DB::raw('SUM(estimates.hour) as total_scrum'))
                ->join('estimates','scrums.estimate_id','=','estimates.id')
                ->whereBetween('finish_time', [$week->tgl_awal, $week->tgl_akhir])
                ->where('status_id', $status)
                ->groupBy('scrums.analyst_id')
                ->get();

        if(count($scrum_analyst) < 1)
        {
            $datagraph_analyst = array(
                                            'y' => 0,
                                            'label' => '0 %',
                                            'indexLabel' => 'null',
                                            'color' => 'black'
                                        );
        }else{
            $datagraph_analyst=[];
            foreach($scrum_analyst as $key)
            {
                $nama = \App\Models\staff::find($key->staff_id)->staff_name or '';

                $persen = $key->total_scrum / 80 * 100;

                if($key->total_scrum > 64)
                {
                    $color = 'green';
                }else{
                    $color = 'red';
                }

                $a = array(
                        'y' => $key->total_scrum,
                        'label' => $nama.' ('.$key->total_scrum.')',
                        'indexLabel' => $persen.'%',
                        'color' => $color

                    );
                array_push($datagraph_analyst, $a);
            }
        }
        

        // programmer
        $scrum_programmer  = DB::table('scrums')
                ->select(DB::raw('transactions.developer_id as staff_id'), DB::raw('SUM(estimates.hour) as total_scrum'))
                ->join('estimates','scrums.estimate_id','=','estimates.id')
                ->join('transactions','scrums.id','=','transactions.scrum_id')
                ->whereBetween('finish_time', [$week->tgl_awal, $week->tgl_akhir])
                ->where('status_id', $status)
                ->groupBy('transactions.developer_id')
                ->get();

        if(count($scrum_programmer) < 1)
        {
            $datagraph_programmer = array(
                                            'y' => 0,
                                            'label' => '0 %',
                                            'indexLabel' => 'null',
                                            'color'=> 'black'
                                        );
        }else{
            $datagraph_programmer=[];
            foreach($scrum_programmer as $key)
            {
                $nama = \App\Models\staff::find($key->staff_id)->staff_name or '';
                $persen = $key->total_scrum / 40 * 100;

                if($key->total_scrum > 32)
                {
                    $color = 'green';
                }else{
                    $color = 'red';
                }

                $a = array(
                        'y' => $key->total_scrum,
                        'label' => $nama.' ('.$key->total_scrum.')',
                        'indexLabel' => $persen.'%',
                        'color'=> $color
                    );
                array_push($datagraph_programmer, $a);
            }
        }

        
        $this->data['datagraph_analyst'] = $datagraph_analyst;
        $this->data['datagraph_programmer'] = $datagraph_programmer;
        $this->data['periode'] = substr($week->tgl_awal, 0, 10).' - '.substr($week->tgl_akhir, 0, 10);

        return $this->data;

    }

    public function login()
    {

        try
        {

            $validator =  Validator::make(Input::all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails())
            {
                $error = $validator->errors();
                $message = 'Your data is not complete, Please kindly check the data.';
                $result = array('result'=>2,'error'=>$message,'errorField'=>$error);
            }else{

                $user = \App\Models\user::with('staffrole')->where('email', Input::get('email'))->first();
                // $staff = \App\Models\staff::where('email', Input::get('email'))->first();

                if (\Hash::check(Input::get('password'), $user->password))
                {
                    $message = "Welcome ".$user->name." !";
                    $result = array('result'=>1,'message'=>$message,'data' => $user);

                } else
                {
                    $message = "User tidak ditemukan !";
                    $result = array('result'=>0,'message'=>$message);
                }           
            }

            return $result;


        }
        catch (Exception $e) {
            $message = "Unexpected Error !";
            $result = array('result'=>0,'message'=>$message);
            return $result;
        }
        

    }

    public function login2()
    {

        try
        {

            $validator =  Validator::make(Input::all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails())
            {
                $error = $validator->errors();
                $message = 'Your data is not complete, Please kindly check the data.';
                $result = array('result'=>2,'error'=>$message,'errorField'=>$error);
            }else{

                $user = \App\Models\user::with('staffrole')
                ->where('email', Input::get('email'))
                ->whereHas('staffrole', function($q){
                    $q->where('role_code', '!=', 'superadmin');
                })
                ->first();
                
                Log::Info('User '.$user);

                if($user)
                {
                    Log::Info('1');
                    if (\Hash::check(Input::get('password'), $user->password))
                    {
                        $message = "Welcome ".$user->name." !";
                        $result = array('result'=>1,'message'=>$message,'data' => $user);

                    } else
                    {
                        Log::Info('3');
                        $message = "User tidak ditemukan !";
                        $result = array('result'=>0,'message'=>$message);
                    }           
                    
                }else{
                    Log::Info('2');
                    $message = "User tidak ditemukan !";
                    $result = array('result'=>0,'message'=>$message);
                }
            }

            return $result;


        }
        catch (Exception $e) {
            $message = "Unexpected Error !";
            $result = array('result'=>0,'message'=>$message);
            return $result;
        }
        

    }

    public function getdatadiri()
    {
        // $staff= \App\Models\user::with('staffrole')
        // ->where('email', Input::get('email'))
        // ->first();

        $staff = \App\Models\user::with('staff', 'staffrole')
        ->where('id', Input::get('user_id'))
        ->first();

        return array('result' => 1, 'data' => $staff);
    }

    public function get_scrummarket()
    {
        $user = \App\Models\user::find(Input::get('user_id'));
        $staff = \App\Models\staff::where('user_id', Input::get('user_id'))->first();
        $role = \App\Models\staffrole::find($user->role_id);
        //  $staff_id = $staff->id;
        // if($role->role_code == 'developer')
        // {
        //     $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
        //         ->whereHas('status', function($q){
        //             $q->where('status_code', '0');
        //         })
        //         ->whereHas('project', function($q) use ($staff){
        //             $q->where('division_id', $staff->division_id);
        //         })
        //         ->orderBy('deadline', 'asc')
        //         ->get();
        // }elseif($role->role_code == 'analyst')
        // {
        //     $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
        //         ->whereHas('status', function($q){
        //             $q->where('status_code', '0');
        //         })
        //         ->where('analyst_id', $staff->id)
        //         ->orderBy('deadline', 'asc')
        //         ->get();
        // }

        if($staff->division_id == '')
        {
            $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
            ->whereHas('status', function($q){
                $q->where('status_code', '0');
            })
            ->where('analyst_id', $staff->id)
            ->orderBy('deadline', 'asc')
            ->get();    
        }else{
            $division = \App\Models\division::find($staff->division_id);
            $division_id = $division->id;

            $scrum = \App\Models\scrum::with('status', 'project', 'estimate', 'urgency', 'analyst')
                ->whereHas('status', function($q){
                    $q->where('status_code', '0');
                })
                ->whereHas('project', function($q) use ($division_id){
                    $q->where('division_id', $division_id);
                })
                ->orderBy('deadline', 'asc')
                ->get(); 
             
        }

        

        return array('result' => 1, 'data' => $scrum, 'divisi' => $role->role_code);
    }

    public function get_progress()
    {
        $user = \App\Models\user::find(Input::get('user_id'));
        $staff = \App\Models\staff::where('user_id', Input::get('user_id'))->first();
        $role = \App\Models\staffrole::find($user->role_id);
        $staff_id = $staff->id;
        if($role->role_code == 'developer')
        {
            // $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
            //     ->whereHas('status', function($q){
            //         $q->where('status_code', '1');
            //     })
            //     ->whereHas('project', function($q) use ($staff){
            //         $q->where('division_id', $staff->division_id);
            //     })
            //     ->get();

            $scrum = \App\Models\scrum::with('transaction', 'status', 'estimate', 'urgency', 'analyst')
                ->whereHas('transaction', function($q) use ($staff_id){
                    $q->where('developer_id', $staff_id);
                })
                ->whereHas('status', function($q){
                    $q->where('status_code', '1');
                })
                ->orderBy('deadline', 'asc')
                ->get();
        }elseif($role->role_code == 'analyst')
        {
            $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
                ->whereHas('status', function($q){
                    $q->where('status_code', '1');
                })
                ->where('analyst_id', $staff->id)
                ->orderBy('deadline', 'asc')
                ->get();
        }

        return array('result' => 1, 'data' => $scrum, 'divisi' => $role->role_code);
    }

    public function get_waiting()
    {
        $user = \App\Models\user::find(Input::get('user_id'));
        $staff = \App\Models\staff::where('user_id', Input::get('user_id'))->first();
        $role = \App\Models\staffrole::find($user->role_id);
        $staff_id = $staff->id;
        if($role->role_code == 'developer')
        {
            $scrum = \App\Models\scrum::with('transaction', 'status', 'estimate', 'urgency', 'analyst')
                ->whereHas('transaction', function($q) use ($staff_id){
                    $q->where('developer_id', $staff_id);
                })
                ->whereHas('status', function($q){
                    $q->where('status_code', '2');
                })
                ->orderBy('deadline', 'asc')
                ->get();
        }elseif($role->role_code == 'analyst')
        {
            $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
                ->whereHas('status', function($q){
                    $q->where('status_code', '2');
                })
                ->where('analyst_id', $staff->id)
                ->orderBy('deadline', 'asc')
                ->get();
        }

        

        return array('result' => 1, 'data' => $scrum, 'divisi' => $role->role_code);
    }

    public function get_finetuning()
    {
        $user = \App\Models\user::find(Input::get('user_id'));
        $staff = \App\Models\staff::where('user_id', Input::get('user_id'))->first();
        $role = \App\Models\staffrole::find($user->role_id);
        $staff_id = $staff->id;
        if($role->role_code == 'developer')
        {
            $scrum = \App\Models\scrum::with('transaction', 'status', 'estimate', 'urgency', 'analyst')
                ->whereHas('transaction', function($q) use ($staff_id){
                    $q->where('developer_id', $staff_id);
                })
                ->whereHas('status', function($q){
                    $q->where('status_code', '3');
                })
                ->orderBy('deadline', 'asc')
                ->get();
        }elseif($role->role_code == 'analyst')
        {
            $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
                ->whereHas('status', function($q){
                    $q->where('status_code', '3');
                })
                ->where('analyst_id', $staff->id)
                ->orderBy('deadline', 'asc')
                ->get();
        }

        

        return array('result' => 1, 'data' => $scrum, 'divisi' => $role->role_code);
    }

    public function get_close()
    {
        $user = \App\Models\user::find(Input::get('user_id'));
        $staff = \App\Models\staff::where('user_id', Input::get('user_id'))->first();
        $role = \App\Models\staffrole::find($user->role_id);
        $staff_id = $staff->id;
        $skrg = \carbon\carbon::now();
        $week = \App\Models\week::
        where('tgl_awal', '<', $skrg)
        ->orderBy('tgl_awal', 'desc')
        ->first();

        $hour = 0;
       
        if($role->role_code == 'developer')
        {
            $scrum = \App\Models\scrum::with('transaction', 'status', 'estimate', 'urgency', 'analyst')
                ->whereHas('status', function($q){
                    $q->where('status_code', '4');
                })
                ->whereHas('transaction', function($q) use ($staff_id){
                    $q->where('developer_id', $staff_id);
                })
                ->whereBetween('finish_time', [$week->tgl_awal, $week->tgl_akhir])
                ->orderBy('updated_at', 'desc')
                ->get();

            foreach($scrum as $row)
            {
                $estimate_id = $row->estimate_id;
                $hour_scrum = \App\Models\estimate::find($estimate_id)->hour;
                $hour = $hour + $hour_scrum;
            }

            $total_scrum = $hour;
            $persen = $total_scrum/40*100;

        }elseif($role->role_code == 'analyst')
        {
            $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency', 'analyst')
                ->whereHas('status', function($q){
                    $q->where('status_code', '4');
                })
                ->where('analyst_id', $staff->id)
                ->whereBetween('finish_time', [$week->tgl_awal, $week->tgl_akhir])
                ->orderBy('updated_at', 'desc')
                ->get();

            foreach($scrum as $row)
            {
                $estimate_id = $row->estimate_id;
                $hour_scrum = \App\Models\estimate::find($estimate_id)->hour;
                $hour = $hour + $hour_scrum;
            }

            $total_scrum = $hour;
            $persen = $total_scrum/80*100;
        }
        
        $total_scrum = $total_scrum.' ('.$persen.'% dari target)';

        return array('result' => 1, 'data' => $scrum, 'total_scrum' => $total_scrum);
    }

    public function get_scrumdetail()
    {

        $scrum = \App\Models\scrum::with('status', 'estimate', 'urgency','analyst', 'project', 'project.client')
            ->where('id', Input::get('scrum_id'))
            ->first();

        return array('result' => 1, 'data' => $scrum);
    }

    public function take_scrum()
    {
        $scrum_id = Input::get('scrum_id');
        $user_id = Input::get('user_id');

        $staff_id = \App\Models\staff::where('user_id', $user_id)->first()->id;
        $status_id = \App\Models\status::where('status_code', '1')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($scrum_id);
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
        $transaction->developer_id = $staff_id;
        $transaction->save();  

        return array('result' => 1, 'data' => $take);
    }

    public function finish_scrum()
    {
        $scrum_id = Input::get('scrum_id');
        $user_id = Input::get('user_id');

        $staff_id = \App\Models\staff::where('user_id', $user_id)->first()->id;
        $status_id = \App\Models\status::where('status_code', '2')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($scrum_id);
        $take->status_id = $status_id;
        $take->qc_time = \Carbon\Carbon::now();
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
        $transaction->developer_id = $staff_id;
        $transaction->save();    

        return array('result' => 1, 'data' => $take);
    }

     public function finish_scrum_ana()
    {
        $scrum_id = Input::get('scrum_id');
        $user_id = Input::get('user_id');

        $staff_id = \App\Models\staff::where('user_id', $user_id)->first()->id;
        $status_id = \App\Models\status::where('status_code', '4')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($scrum_id);
        $take->status_id = $status_id;
        $take->finish_time = \Carbon\Carbon::now();
        $take->update();


        // // Update transaction
        // $trans_old = \App\Models\transaction::where('scrum_id', $take->id)->get();
      
        
        // if(count($trans_old) > 0)
        // {
        //     foreach ($trans_old as $key) {
        //         $trans_old = \App\Models\transaction::find($key->id);
        //         $trans_old->delete();
        //     }
            
        // }

        // // Update Transaction (DEFAULT AKBAR DEVELOPER)
        // $transaction = new \App\Models\transaction;
        // $transaction->scrum_id = $take->id;
        // $transaction->developer_id = $staff_id;
        // $transaction->save();    

        return array('result' => 1, 'data' => $take);
    }

    public function finetuning_scrum_ana()
    {
        $scrum_id = Input::get('scrum_id');
        $user_id = Input::get('user_id');

        $staff_id = \App\Models\staff::where('user_id', $user_id)->first()->id;
        $status_id = \App\Models\status::where('status_code', '3')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($scrum_id);
        $take->status_id = $status_id;
        $take->update();


        // // Update transaction
        // $trans_old = \App\Models\transaction::where('scrum_id', $take->id)->get();
      
        
        // if(count($trans_old) > 0)
        // {
        //     foreach ($trans_old as $key) {
        //         $trans_old = \App\Models\transaction::find($key->id);
        //         $trans_old->delete();
        //     }
            
        // }

        // // Update Transaction (DEFAULT AKBAR DEVELOPER)
        // $transaction = new \App\Models\transaction;
        // $transaction->scrum_id = $take->id;
        // $transaction->developer_id = $staff_id;
        // $transaction->save();    

        return array('result' => 1, 'data' => $take);
    }

    public function finetuning_scrum()
    {
        $scrum_id = Input::get('scrum_id');
        $user_id = Input::get('user_id');

        $staff_id = \App\Models\staff::where('user_id', $user_id)->first()->id;
        $status_id = \App\Models\status::where('status_code', '3')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($scrum_id);
        $take->status_id = $status_id;
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
        $transaction->developer_id = $staff_id;
        $transaction->save();    

        return array('result' => 1, 'data' => $take);
    }

    public function close_scrum()
    {
        $scrum_id = Input::get('scrum_id');
        $user_id = Input::get('user_id');

        $staff_id = \App\Models\staff::where('user_id', $user_id)->first()->id;
        $status_id = \App\Models\status::where('status_code', '4')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($scrum_id);
        $take->status_id = $status_id;
        $take->finish_time = \Carbon\Carbon::now();
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
        $transaction->developer_id = $staff_id;
        $transaction->save();    

        return array('result' => 1, 'data' => $take);
    }

    public function remove_scrum()
    {
        $scrum_id = Input::get('scrum_id');
        $user_id = Input::get('user_id');

        $staff_id = \App\Models\staff::where('user_id', $user_id)->first()->id;
        $status_id = \App\Models\status::where('status_code', '0')->first()->id;
        
        // Update scrum status dan assigntime
        $take = \App\Models\scrum::find($scrum_id);
        $take->status_id = $status_id;
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

        return array('result' => 1, 'data' => $take);
    }


    public function get_image()
    {
        $user = \App\Models\user::find(Input::get('user_id'));
        $staff = \App\Models\staff::where('user_id', Input::get('user_id'))->first();
        $role = \App\Models\staffrole::find($user->role_id);
       
        $data = $staff->avatar;

        

        return array('result' => 1, 'data' => $data);
    }

    public function test()
    {
        $staff_id = \App\Models\staff::where('user_id', Input::get('user_id'))->first()->id;

        $scrum = \App\Models\scrum::with('transaction')
            ->where('analyst_id', $staff_id)
            ->get();

        $status_waiting = \App\Models\status::where('status_code', '2')->first()->id;
        $status_noassign = \App\Models\status::where('status_code', '0')->first()->id;

        return $scrum;
    }


}
