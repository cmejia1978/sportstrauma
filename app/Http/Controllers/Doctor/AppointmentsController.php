<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Medicine\Medicine;
use App\DRDSB\Patient\Appointment;
use stdClass;
use Vinkla\Hashids\HashidsManager;
use App\DRDSB\Patient\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Mail;
use Validator;

class AppointmentsController extends Controller
{
	protected $auth;
	protected $hashids;

	public function __construct( Guard $auth, HashidsManager $hasids )
	{
		$this->auth    = $auth;
		$this->hashids = $hasids;
		$this->hashids->setDefaultConnection( 'patient_appointment' );
	}

	public function getViewAppointment( $id )
	{
		$appointment = Appointment::with( [ 'patient' ] )->where( 'id', $id )->where( 'doctor_id', $this->auth->id() )->firstOrFail();
		$medicines   = Medicine::where( 'doctor_id', $this->auth->id() )->get();

		return view( 'doctor.patient.appointment.view', [ 'appointment' => $appointment, 'medicines' => $medicines ] );
	}

	public function postPatientAppointmentsData( Request $request )
	{
		$sel_doctor = $request->session()->get( 'selected_doctor', '0' );

		$patient = Patient::where( 'customer_id', $this->auth->id() )->first();

		if ( $patient->associated == 'Y' ) {
			if ( $sel_doctor == '2' || $sel_doctor == '3' ) {
				$patient = Patient::where( 'customer_id', $this->auth->id() )
				                  ->where( 'doctor_id', $sel_doctor )
				                  ->first();
			}
		}

		return Datatables::of( Appointment::with( [ 'doctor' ] )->where( 'patient_id', $patient->id )->orderBy( 'start', 'asc' ) )
		                 ->editColumn( 'doctor_id', function ( $appointment )
		                 {
			                 return '<a href="' . url( 'patient/appointment/' . $this->hashids->encode( $appointment->id ) ) . '">' . $appointment->doctor->name . '</a>';
		                 } )
		                 ->editColumn( 'start', function ( $appointment )
		                 {
			                 return '<a href="' . url( 'patient/appointment/' . $this->hashids->encode( $appointment->id ) ) . '">' . $appointment->start . '</a>';
		                 } )
		                 ->editColumn( 'end', function ( $appointment )
		                 {
			                 return '<a href="' . url( 'patient/appointment/' . $this->hashids->encode( $appointment->id ) ) . '">' . $appointment->end . '</a>';
		                 } )
		                 ->make( true );
	}

	public function postPatientAppointmentsRequest( Request $request )
	{
		$sel_doctor = $request->session()->get( 'selected_doctor', '0' );
		$patient    = Patient::with( [ 'doctor' ] )->where( 'customer_id', $this->auth->id() )->first();

		if ( $patient->associated == 'Y' ) {
			$patient = Patient::with( [ 'doctor' ] )->where( 'customer_id', $this->auth->id() )->where( 'doctor_id', $sel_doctor )->first();
		}

		Mail::send( 'doctor.patient.appointment.emails.request', [ 'patient' => $patient ], function ( $message ) use ( $patient )
		{
			$message->to( $patient->doctor['email'] );
			$message->subject( 'Solicitud de cita - ' . $patient->full_name );
		} );

		if ( ! empty( $patient->doctor['notify_email'] ) ) {
			Mail::send( 'doctor.patient.appointment.emails.request', [ 'patient' => $patient ], function ( $message ) use ( $patient )
			{
				$message->to( $patient->doctor['notify_email'] );
				$message->subject( 'Solicitud de cita - ' . $patient->full_name );
			} );
		}

		return response()->json( [ 'success' => true ], 200, [], JSON_UNESCAPED_UNICODE );
	}

	public function getAppointments( $id )
	{
		$appointments = Appointment::where( 'doctor_id', '=', $this->auth->id() )->get();
		$patient      = Patient::find( $id );

		return view( 'doctor.patient.appointment.appointments', [
			'appointments' => $appointments,
			'patient'      => $patient
		] );
	}

	protected function getEvents( $id, $new_aid )
	{
		$appointments = Appointment::with( [ 'patient' ] )->where( 'doctor_id', '=', $this->auth->id() )->get();

		$events = array();

		foreach ( $appointments as $appointment ) {
			$event = new stdClass();
			if ( $appointment->patient_id == $id ) {
				$event->id    = $appointment->id;
				$event->title = $appointment->patient['full_name'];

				if ( $appointment->type == 'C' ) {
					$event->title = $appointment->comment;
				}

				$event->start     = $appointment->start_js;
				$event->end       = $appointment->end_js;
				$event->allDay    = false;
				$event->url       = url( 'appointments/view', $appointment->id );
				$event->editable  = true;
				$event->className = 'current-usr-event';
				$event->sticky    = true;
				$event->type      = $appointment->type;
			} else {
				$event->id        = $appointment->id;
				$event->title     = $appointment->patient['full_name'];
				$event->start     = $appointment->start_js;
				$event->end       = $appointment->end_js;
				$event->allDay    = false;
				$event->url       = url( 'appointments/view', $appointment->id );
				$event->editable  = false;
				$event->className = 'other-usr-event';
				$event->sticky    = true;
			}

			if ( $new_aid > 0 ) {
				if ( $appointment->id == $new_aid ) {
					$event->code_status = 'added';
				} else {
					$event->code_status = 'updated';
				}

			}

			$events[] = $event;
		}

		return $events;
	}

	public function getViewFrontAppointment( Request $request, $id )
	{
		$sel_doctor = $request->session()->get( 'selected_doctor', '0' );

		$id      = $this->hashids->decode( $id )[0];
		$patient = Patient::with( [ 'doctor' ] )->where( 'customer_id', $this->auth->id() )->first();


		if ( $patient->associated == 'Y' ) {
			if ( $sel_doctor == '2' || $sel_doctor == '3' ) {
				$patient = Patient::where( 'customer_id', $this->auth->id() )
				                  ->where( 'doctor_id', $sel_doctor )
				                  ->first();
			}
		}

		$appointment = Appointment::with( [
			'doctor',
			'patient'
		] )->where( 'id', $id )->where( 'patient_id', $patient->id )->first();
		$medicines   = Medicine::where( 'doctor_id', $this->auth->id() )->get();

		return view( 'doctor.patient.appointment.view_fre', [
			'appointment' => $appointment,
			'medicines'   => $medicines,
			'patient'     => $patient
		] );
	}

	public function postNotify( Request $request )
	{
		$patient_id   = $request->get( 'pid' );
		$appointments = $request->get( 'events' );

		$patient = Patient::find( $patient_id );

		foreach ( $appointments as $appointment ) {
			$apt = Appointment::find( $appointment['id'] );

			if ( isset( $appointment['code_status'] ) && $appointment['code_status'] == 'added' ) {
				Mail::send( 'doctor.patient.appointment.emails.notify_add', [ 'appointment' => $apt ], function ( $message ) use ( $patient )
				{
					$message->to( $patient->email );
					$message->subject( 'Nueva cita' );
				} );
			} else {
				Mail::send( 'doctor.patient.appointment.emails.notify_update', [ 'appointment' => $apt ], function ( $message ) use ( $patient )
				{
					$message->to( $patient->email );
					$message->subject( 'Actualización Cita' );
				} );
			}
		}

		return response()->json( [ 'success' => true ], 200, [], JSON_UNESCAPED_UNICODE );
	}

	public function postAddAppointment( Request $request )
	{
		$formData    = $request->all();
		$appointment = $this->create( $formData );

		if ( $appointment ) {
			$patient = Patient::find( $appointment->patient_id );
			/*Mail::send('doctor.patient.appointment.emails.notify_add', ['appointment' => $appointment], function ($message) use ($patient) {
				$message->to($patient->email);
				$message->subject('Nueva cita');
			});*/

			$events = $this->getEvents( $request->get( 'pid' ), $appointment->id );

			return response()->json( [
				'success' => true,
				'aid'     => $appointment->id,
				'events'  => $events
			], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al agregar cita'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	public function postUpdateAppointment( Request $request )
	{
		$formData = $request->all();

		$appointment = $this->update( $formData );

		if ( $appointment ) {
			return response()->json( [ 'success' => true ], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al actualizar cita'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	public function postRemoveAppointment( Request $request )
	{
		$formData = $request->all();

		$appointment = $this->remove( $formData );

		if ( $appointment ) {
			$events = $this->getEvents( $request->get( 'pid' ), 0 );

			return response()->json( [ 'success' => true, 'events' => $events ], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al eliminar cita'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	protected function remove( $data )
	{
		$appointment = Appointment::find( $data['aid'] );

		if ( $appointment ) {
			$appointment->delete();

			return true;
		}

		return false;
	}

	protected function update( $data )
	{
		$appointment = Appointment::find( $data['aid'] );

		if ( $appointment ) {
			$appointment->start             = $data['start'];
			$appointment->end               = $data['end'];
			$appointment->first_notified    = 'N';
			$appointment->second_notified   = 'N';
			$appointment->tomorrow_notified = 'N';

			$appointment->save();
		}

		return $appointment;
	}

	protected function create( $data )
	{
		$appointment = Appointment::create( array(
			'doctor_id'         => $this->auth->id(),
			'patient_id'        => $data['pid'],
			'start'             => $data['start'],
			'end'               => $data['end'],
			'type'              => $data['type'],
			'comment'           => $data['comment'],
			'first_notified'    => 'N',
			'second_notified'   => 'N',
			'tomorrow_notified' => 'N'
		) );

		return $appointment;
	}

}
