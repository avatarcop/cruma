<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    public $table = 'staffs';

    public function staffrole() {
        return $this->belongsTo('\App\Models\staffrole', 'role_id', 'id');
    }

    public function division() {
        return $this->belongsTo('\App\Models\division', 'division_id', 'id');
    }

    public function user() {
        return $this->belongsTo('\App\Models\user', 'user_id', 'id');
    }


}
