<?php

namespace App\DRDSB\Patient;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

	protected $table = 'appointments';

	protected $fillable = [
		'doctor_id',
		'patient_id',
		'start',
		'end',
		'first_notified',
		'type',
		'comment',
		'second_notified',
		'tomorrow_notified'
	];

	protected $dates = [ 'start', 'end', 'created_at', 'updated_at' ];

	public function getStartUntilAttribute()
	{
		Carbon::setLocale( config( 'app.locale' ) );
		$date  = new Carbon( date( 'Y-m-d H:i:s' ) );
		$start = new Carbon( $this->attributes['start'] );


		if ( $start->gt( $date ) ) {
			return 'dentro de ' . $date->diffForHumans( $start, true );
		}

		return 'hace ' . $date->diffForHumans( $start, true );
	}

	public function getStartGTCTAttribute()
	{
		$date  = new Carbon( date( 'Y-m-d H:i:s' ) );
		$start = new Carbon( $this->attributes['start'] );

		return $start->gt( $date );
	}

	public function getStartMDAttribute()
	{
		$date = new Carbon( $this->attributes['start'] );

		return $date->format( 'd/m/Y H:i:s a' );
	}


	public function getStartMailAttribute()
	{
		$date = new Carbon( $this->attributes['start'] );

		return $date->format( 'd/m/Y \a \l\a\s H:i' );
	}

	public function getStartAttribute( $date )
	{
		$date = new Carbon( $date );

		return $date->format( 'd/m/Y H:i:s' );
	}

	public function getStartJSAttribute()
	{
		$date = new Carbon( $this->attributes['start'] );

		return $date->format( 'Y/m/d H:i:s' );
	}

	public function getEndJSAttribute()
	{
		$date = new Carbon( $this->attributes['end'] );

		return $date->format( 'Y/m/d H:i:s' );
	}

	public function getEndAttribute( $date )
	{
		$date = new Carbon( $date );

		return $date->format( 'd/m/y H:i:s' );
	}

	public function getCreatedAtAttribute( $date )
	{
		$date = new Carbon( $date );

		return $date->format( 'd/m/Y h:i:s a' );
	}

	public function getStartDateAttribute()
	{
		$date = new Carbon( $this->attributes['start'] );

		return $date->format( 'd/m/Y' );
	}

	public function getStartDateFancyAttribute()
	{
		Carbon::setLocale( config( 'app.locale' ) );

		$date = new Carbon( $this->attributes['start'] );

		return $date->format( 'd/m/Y' );
	}

	public function getStartDateTimeFancyAttribute()
	{
		Carbon::setLocale( config( 'app.locale' ) );
		$date = new Carbon( $this->attributes['start'] );
		setlocale( LC_TIME, 'es_GT.UTF-8' );
		$time = $date->format( ' \a \l\a\s H:i' );

		return ucfirst( $date->formatLocalized( '%A %d de %B del %Y' ) ) . $time;
	}


	public function getStartTimeAttribute()
	{
		$date = new Carbon( $this->attributes['start'] );

		return $date->format( 'H:i' );
	}

	public function getDurationAttribute()
	{
		Carbon::setLocale( config( 'app.locale' ) );

		$start = new Carbon( $this->attributes['start'] );
		$end   = new Carbon( $this->attributes['end'] );

		return $end->diffForHumans( $start, true );

	}

	public function getUpdatedAtAttribute( $date )
	{
		$date = new Carbon( $date );

		return $date->format( 'd/m/Y h:i:s a' );
	}

	public function patient()
	{
		return $this->belongsTo( 'App\DRDSB\Patient\Patient', 'patient_id', 'id' );
	}

	public function doctor()
	{
		return $this->belongsTo( 'App\DRDSB\User\User', 'doctor_id', 'id' );
	}

	public function feedback()
	{
		return $this->hasMany( 'App\DRDSB\Patient\Feedback', 'appointment_id', 'id' );
	}

	public function prescriptions()
	{
		return $this->hasMany( 'App\DRDSB\Patient\Prescription', 'appointment_id', 'id' );
	}

	public function prescriptionsCount()
	{
		return $this->hasOne( 'App\DRDSB\Patient\Prescription' )->selectRaw( 'appointment_id, count(*) as aggregate' )->groupBy( 'appointment_id' );
	}

	public function getPrescriptionsCountAttribute()
	{
		if ( ! array_key_exists( 'prescriptionsCount', $this->relations ) ) {
			$this->load( 'prescriptionsCount' );
		}

		$related = $this->getRelation( 'prescriptionsCount' );

		return ( $related ) ? (int) $related->aggregate : 0;
	}
}
