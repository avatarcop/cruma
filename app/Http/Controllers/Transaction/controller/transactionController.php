<?php

namespace App\Http\Controllers\Transaction\controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use Response;
use Session;
class transactionController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
    	$transaction = \App\Models\transaction::select('id', 'scrum_id', 'developer_id', 'created_at', 'updated_at')->get();

    	// Flash Message / Alert
    	// $request->session()->flash('message.level', 'success');
     //    $request->session()->flash('message.content', 'Post was successfully added!');

        return view('transaction.transaction', compact('transaction'));
    }
}
