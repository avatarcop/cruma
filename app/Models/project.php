<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    public $table = 'projects';

    public function client() {
        return $this->belongsTo('\App\Models\client', 'client_id', 'id');
    }

    public function division()
    {
    	return $this->belongsTo('\App\Models\division', 'division_id', 'id');
    }


}
