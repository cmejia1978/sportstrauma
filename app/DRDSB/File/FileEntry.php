<?php namespace App\DRDSB\File;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model
{

    protected $table = 'file_entries';

    protected $fillable = ['user_id', 'appointment_id', 'filename', 'mime', 'original_filename'];

    public function user() {
        return $this->belongsTo('App\DRDSB\User\User', 'user_id', 'id');
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
