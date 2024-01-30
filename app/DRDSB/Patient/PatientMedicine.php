<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PatientMedicine extends Model
{

    protected $table = 'patient_medicines';

    protected $fillable = [
        'patient_id',
        'name',
        'dose_frequency'
    ];

    public function getCreatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }

    public function getUpdatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }

    public function patient()
    {
        return $this->belongsTo('App\DRDSB\Patient\Patient', 'patient_id', 'id');
    }

}
