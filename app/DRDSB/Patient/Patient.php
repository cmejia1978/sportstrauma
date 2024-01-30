<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Hashids;
use stdClass;

class Patient extends Model
{
    use Sortable;

    protected $table = 'patients';

    protected $fillable = [
        'doctor_id',
        'customer_id',
        'full_name',
        'surgery_name',
        'medical_insurance',
        'medical_insurance_name',
        'email',
        'marital_status',
        'religion',
        'referred_by',
        'birth_location',
        'birth_date',
        'age',
        'sex',
        'address',
        'pref_phone_num',
        'alt_phone_num',
        'occupation',
        'employer',
        'seen_other_provider',
        'other_provider_country',
        'x_rays',
        'x_ray_date',
        'operated',
        'operated_info',
        'medical_inquiry_reason',
        'medical_problem_time',
        'medical_problem_coup',
        'medical_problem_coup_info',
        'sport_practice',
        'sport_practice_info',
        'exercise',
        'exercise_info',
        'alcohol',
        'alcohol_usage',
        'smokes',
        'smokes_per_day',
        'smokes_years',
        'allergies',
        'allergies_cause',
        'allergies_reaction',
        'associated'
    ];
    
    protected $appends = [
        'short_name'
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
    
    public function getAgeAttribute($age)
    {
        return Carbon::parse($this->attributes['birth_date'])->age;
    }

    public function getBirthDateAttribute($date)
    {
        $date = new Carbon($date);

        return $date->format('d/m/Y');
    }

    public function getBirthDateDbAttribute()
    {
        return $this->attributes['birth_date'];
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

        switch (count($name_parts)) {
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
                $last_name  = $name_parts[1];
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
        return $this->belongsTo('App\DRDSB\User\User', 'id', 'customer_id');
    }

    public function diseases()
    {
        return $this->belongsToMany('App\DRDSB\Patient\Disease', 'disease_patient');
    }

    public function getCheckboxDiseasesAttribute()
    {
        $db_diseases = Disease::all();

        $checkbox_diseases = array();
        $diseases          = $this->diseases()->get();


        foreach ($db_diseases as $disease) {
            $tmp_disease          = new stdClass();
            $tmp_disease->id      = $disease->id;
            $tmp_disease->name    = $disease->name;
            $tmp_disease->checked = false;

            foreach ($diseases as $checked_disease) {
                if ($disease->id == $checked_disease->id) {
                    $tmp_disease->checked = 'yes';
                    break;
                } else {
                    $tmp_disease->checked = 'no';
                }
            }

            $checkbox_diseases[] = $tmp_disease;
        }

        return $checkbox_diseases;
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
