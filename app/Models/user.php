<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    public $table = 'users';

    public function staffrole() {
        return $this->belongsTo('\App\Models\staffrole', 'role_id', 'id');
    }

    public function staff() {
        return $this->hasOne('\App\Models\staff', 'user_id', 'id');
    }
}
