<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    public $table = 'transactions';
    protected $appends = array('developer_name');

    public function scrum()
    {
    	return $this->belongsTo('\App\Models\scrum', 'scrum_id', 'id');
    }

    public function developer()
    {
        return $this->belongsTo('App\Models\staff', 'developer_id', 'id');
    }

    public function getDeveloperNameAttribute()
    {
       $project = \DB::table('staffs')->find($this->developer_id);

       if($project){
            return $project->staff_name;

        }else{
            return '';
        }


    }


}
