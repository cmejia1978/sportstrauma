<?php namespace App\DRDSB\File;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GeneralFileEntry extends Model
{

    protected $table = 'general_file_entries';

    protected $fillable = ['user_id', 'patient_id', 'description', 'file_category', 'filename', 'mime', 'original_filename'];

    public function user() {
        return $this->belongsTo('App\DRDSB\User\User', 'user_id', 'id');
    }

    public function patient() {
        return $this->belongsTo('App\DRDSB\Patient\Patient', 'patient_id', 'id');
    }

    public function getCreatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:m:s a');
    }

    public function getUpdatedAtAttribute($date) {
        $date = new Carbon($date);
        return $date->format('d/m/Y h:m:s a');
    }

}
