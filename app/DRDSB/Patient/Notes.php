<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{

    protected $table = 'notes';

    protected $fillable = [
        'appointment_id',
        'description',
    ];


    public function getCreatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }

    public function getUpdatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }

    public function appointment()
    {
        return $this->belongsTo('App\DRDSB\Patient\Appointment', 'appointment_id', 'id');
    }
}
