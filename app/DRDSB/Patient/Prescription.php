<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{

    protected $table = 'prescriptions';

    protected $fillable = [
        'medicine_id',
        'patient_id',
        'appointment_id',
        'indication'
    ];

    public function getStartAttribute($date) {
        $date = new Carbon($date);
        return $date->format('Y/m/d H:i:s');
    }

    public function getEndAttribute($date) {
        $date = new Carbon($date);
        return $date->format('Y/m/d H:i:s');
    }

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

    public function medicine()
    {
        return $this->belongsTo('App\DRDSB\Medicine\Medicine', 'medicine_id', 'id');
    }
}
