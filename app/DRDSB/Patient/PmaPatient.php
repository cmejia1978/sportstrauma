<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Hashids;
use stdClass;

class PmaPatient extends Model
{
    use Sortable;

    protected $table = 'patients';

    protected $fillable = [
        'doctor_id',
        'customer_id',
        'full_name',
        'email',
        'marital_status',
        'referred_by',
        'birth_date',
        'age',
        'sex',
        'address',
        'pref_phone_num',
        'alt_phone_num',
        'tutor_name',
        'children_info',
        'mental_services',
        'mental_services_info',
        'medicines_usage',
        'medicines_usage_info',
        'associated'
    ];

    public function getPhotoAttribute()
    {
        $hashed_id = Hashids::connection('user_picture')->encode($this->attributes['customer_id']);

        $hashed_id = $hashed_id ? $hashed_id : '';

        if (file_exists(public_path() . '/profile-pic/cropped-' . $hashed_id . '.png')) {
            return '/profile-pic/cropped-' . $hashed_id . '.png';
        }

        return '/assets/images/user.png';
    }

    public function getPhotoFullAttribute()
    {
        $hashed_id = Hashids::connection('user_picture')->encode($this->attributes['customer_id']);

        $hashed_id = $hashed_id ? $hashed_id : '';

        if (file_exists(public_path() . '/profile-pic/' . $hashed_id . '.jpg')) {
            return '/profile-pic/' . $hashed_id . '.jpg';
        }

        return '/assets/images/user.png';
    }

    public function getBirthDateAttribute($date)
    {
        $date = new Carbon($date);

        return $date->format('d/m/Y');
    }

    public function getXRayDateAttribute($date)
    {
        if ($date != '0000-00-00') {
            $date = new Carbon($date);

            return $date->format('d/m/Y');
        } else {
            return $date;
        }

    }

    public function getShortNameAttribute()
    {
        $full_name  = $this->attributes['full_name'];
        $name_parts = explode(' ', $full_name);
        $first_name = '';
        $last_name  = '';

        switch (sizeof($name_parts)) {
            case 0:
                break;
            case 1:
                $first_name = $name_parts[0];
                break;
            case 2:
                $first_name = $name_parts[0];
                $last_name  = $name_parts[1];
                break;
            case 3:
                $first_name = $name_parts[0];
                $last_name  = $name_parts[2];
                break;
            default:
                $first_name = $name_parts[0];
                $last_name  = $name_parts[2];
                break;
        }

        return trim("$first_name $last_name");
    }

    public function appointments()
    {
        return $this->hasMany('App\DRDSB\Patient\Appointment', 'patient_id', 'id');
    }

    public function appointmentsCount()
    {
        return $this->hasOne('App\DRDSB\Patient\Appointment')->selectRaw('patient_id, count(*) as aggregate')->groupBy('patient_id');
    }

    public function getAppointmentsCountAttribute()
    {
        if (!array_key_exists('appointmentsCount', $this->relations))
            $this->load('appointmentsCount');

        $related = $this->getRelation('appointmentsCount');

        return ($related) ? (int)$related->aggregate : 0;
    }

    public function doctor()
    {
        return $this->belongsTo('App\DRDSB\User\User', 'doctor_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\DRDSB\User\User', 'customer_id', 'id');
    }

    public function surgeryFiles()
    {
        return $this->hasMany('App\DRDSB\File\SurgeryFileEntry', 'id', 'patient_id');
    }

    public function medicines()
    {
        return $this->hasMany('App\DRDSB\Patient\PatientMedicine', 'patient_id', 'id');
    }

    public function getMedicinesFieldsAttribute()
    {
        $medicines = $this->medicines()->get();

        $fields = array();

        for ($i = 0; $i < 5; $i++) {
            $field = new stdClass();
            if (isset($medicines[$i])) {
                $field->id             = $medicines[$i]['id'];
                $field->name           = $medicines[$i]['name'];
                $field->dose_frequency = $medicines[$i]['dose_frequency'];
            } else {
                $field->id             = 0;
                $field->name           = '';
                $field->dose_frequency = '';
            }

            $fields[] = $field;
        }

        return $fields;
    }
}
