<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class scrum extends Model
{
    public $table = 'scrums';

    public function project() {
        return $this->belongsTo('\App\Models\project', 'project_id', 'id');
    }

    public function urgency() {
        return $this->belongsTo('\App\Models\urgency', 'urgency_id', 'id');
    }

    public function estimate() {
        return $this->belongsTo('\App\Models\estimate', 'estimate_id', 'id');
    }

    public function analyst() {
        return $this->belongsTo('\App\Models\staff', 'analyst_id', 'id');
    }

    public function status() {
        return $this->belongsTo('\App\Models\status', 'status_id', 'id');
    }

    public function transaction() {
        return $this->hasOne('App\Models\transaction', 'scrum_id', 'id');
    }
}
