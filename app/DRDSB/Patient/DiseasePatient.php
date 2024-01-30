<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DiseasePatient extends Model
{

    protected $table = 'disease_patient';

    protected $fillable = [
        'disease_id',
        'patient_id'
    ];

    public function getCreatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }

    public function getUpdatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i:s a');
    }
}
