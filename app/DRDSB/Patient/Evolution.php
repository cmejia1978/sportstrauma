<?php namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Evolution extends Model
{

    protected $table = 'evolutions';

    protected $fillable = [
        'patient_id',
        'description'
    ];

    public function getCreatedAtAttribute($date)
    {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:i a');
    }
}
