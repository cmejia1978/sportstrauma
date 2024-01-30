<?php

namespace App\DRDSB\Medicine;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{

    protected $table = 'medicines';

    protected $fillable = [
        'doctor_id', 'name'
    ];

    public function getCreatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:m:s a');
    }

    public function getUpdatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:m:s a');
    }

    public function prescriptions() {
        return $this->hasMany('App\DRDSB\Patient\Prescription', 'id', 'medicine_id');
    }

    public function getRecNameAttribute()
    {
        $tmp_name = $this->attributes['name'];
        $split = explode(',', $tmp_name);
        $name = trim($split[0]);

        return $name;
    }

    public function getRecIndicationAttribute()
    {
        $tmp_name = $this->attributes['name'];
        $split = explode(',', $tmp_name);
        $indication = '';
        if (count($split) == 2) {
            $indication = trim($split[1]);
        }

        return $indication;
    }
}
