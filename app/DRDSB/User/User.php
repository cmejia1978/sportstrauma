<?php

namespace App\DRDSB\User;

use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Bican\Roles\Traits\HasRoleAndPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Hashids;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'notify_email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function patient()
    {
        return $this->hasOne('App\DRDSB\Patient\Patient', 'customer_id', 'id');
    }

    public function patients()
    {
        return $this->hasMany('App\DRDSB\Patient\Patient', 'customer_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany('App\DRDSB\Patient\Appointment', 'id', 'doctor_id');
    }

    public function getPhotoAttribute()
    {
        $hashed_id = Hashids::connection('user_picture')->encode(Auth::user()->id);

        if(file_exists( public_path() . '/profile-pic/cropped-' . $hashed_id . '.png')) {
            return '/profile-pic/cropped-' . $hashed_id . '.png';
        } else {
            return '/assets/images/user.png';
        }
    }
}
