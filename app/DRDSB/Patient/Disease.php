<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{

    protected $table = 'diseases';

    protected $fillable = [
        'name',
    ];

    public function getCreatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }

    public function getUpdatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }

    public function patients()
    {
        return $this->belongsToMany('App\DRDSB\Patient\Patient', 'disease_patient');
    }


}
