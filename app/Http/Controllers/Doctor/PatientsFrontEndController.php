<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Appointment;
use App\DRDSB\Patient\Disease;
use App\DRDSB\Patient\DiseasePatient;
use App\DRDSB\Patient\Patient;
use App\DRDSB\Patient\PatientMedicine;
use App\DRDSB\Patient\PmaPatient;
use App\DRDSB\User\User;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Validator;
use Vinkla\Hashids\HashidsManager;
use Yajra\Datatables\Datatables;

class PatientsFrontEndController extends Controller
{
	protected $auth;
	protected $hashids;

	public function __construct( Guard $auth, HashidsManager $hashids )
	{
		$this->auth    = $auth;
		$this->hashids = $hashids;
		$this->hashids->setDefaultConnection( 'doctor' );
	}

	protected $messages = array(
		'address.required'                        => 'Debe ingresar su dirección',
		'medical_insurance.required'              => 'Debe seleccionar sí o no',
		'medical_insurance.in'                    => 'Debe seleccionar sí o no',
		'medical_insurance_name.required_if'      => 'Debe ingresar el nombre del seguro médico',
		'pref_phone_num.required'                 => 'Debe ingresar un número de teléfono',
		'pref_phone_num.numeric'                  => 'Debe ingresar un número de teléfono (solo números)',
		'alt_phone_num.numeric'                   => 'Debe ingresar un número de teléfono (solo números)',
		'occupation.required'                     => 'Debe ingresar una ocupación',
		'other_provider_country.required_if'      => 'Debe ingresar el país',
		'employer.required'                       => 'Debe ingresar el nombre de la empresa en la que trabaja',
		'x_ray_date.required_if'                  => 'Debe ingresar la fecha de las radiografías',
		'operated_info.required_if'               => 'Debe ingresar de que ha sido operado',
		'medical_inquiry_reason.required'         => 'Debe ingresar la razón de su consulta',
		'medical_problem_time.required'           => 'Debe ingresar el tiempo de tener el problema',
		'medical_problem_coup_info.required_if'   => 'Debe ingresar como fué el golpe',
		'sport_practice_info.required_if'         => 'Debe ingresar que deporte practica',
		'exercise_info.required_if'               => 'Debe seleccionar un ejercicio',
		'alcohol_usage.required_if'               => 'Debe seleccionar cada cuando consume alcohol',
		'smokes_per_day.required_if'              => 'Debe ingresar cuántos cigarillos fuma al día',
		'smokes_year.required_if'                 => 'Debe ingresar cuántos años lleva de fumar',
		'medicine.*.name.required_with'           => 'Debe ingresar el nombre del medicamento',
		'medicine.*.dose_frequency.required_with' => 'Debe ingreasar la dosis/Frecuencia',
		'allergies_cause.required_with'           => 'Debe ingresar que le causa alergía',
		'allergies_reaction.required_with'        => 'Debe ingresar que reacción tuvo',
	);

	protected $validationRules = array(
		'medical_insurance'         => 'required|in:Y,N',
		'medical_insurance_name'    => 'required_if:medical_insurance,Y',
		'address'                   => 'required',
		'pref_phone_num'            => 'required|numeric',
		'alt_phone_num'             => 'numeric',
		'other_provider_country'    => 'required_if:seen_other_provider,Y',
		'x_ray_date'                => 'required_if:x_rays,Y',
		'operated_info'             => 'required_if:operated,Y',
		'medical_problem_coup_info' => 'required_if:medical_problem_coup,Y',
		'sport_practice_info'       => 'required_if:sport_practice,Y',
		'exercise_info'             => 'required_if:exercise,Y',
		'alcohol_usage'             => 'required_if:alcohol,Y',
		'smokes_per_day'            => 'required_if:smokes,Y',
		'medicine.*.name'           => 'required_with:medicine.*.dose_frequency',
		'medicine.*.dose_frequency' => 'required_with:medicine.*.name',
		'allergies_cause'           => 'required_with:allergies',
		'allergies_reaction'        => 'required_with:allergies'
	);

	protected $pma_messages = array(
		'medical_insurance.required'         => 'Debe seleccionar sí o no',
		'medical_insurance.in'               => 'Debe seleccionar sí o no',
		'medical_insurance_name.required_if' => 'Debe ingresar el nombre del seguro médico',
		'address.required'                   => 'Debe ingresar su dirección',
		'pref_phone_num.required'            => 'Debe ingresar un número de teléfono',
		'pref_phone_num.numeric'             => 'Debe ingresar un número de teléfono (solo números)',
		'alt_phone_num.numeric'              => 'Debe ingresar un número de teléfono (solo números)',
		'mental_services_info.required_if'   => 'Debe ingresar el tipo de servicio de salud mental',
		'medicines_usage_info.required_if'   => 'Debe ingresar el tiempo y la información de los medicamentos',
		'tutor_name.required'                => 'Debe ingresar el nombre del padre/tutor',
	);

	protected $pma_validationRules = array(
		'medical_insurance'      => 'required|in:Y,N',
		'medical_insurance_name' => 'required_if:medical_insurance,Y',
		'address'                => 'required',
		'pref_phone_num'         => 'required|numeric',
		'alt_phone_num'          => 'numeric',
		'mental_services_info'   => 'required_if:mental_services,Y',
		'medicines_usage_info'   => 'required_if:medicines_usage,Y',
	);

	public function getPatientInfo( $id )
	{
		$patient = Patient::find( $id );

		return response()->json( [
			'info'    => View::make( 'doctor.patient.ajax-update', [ 'patient' => $patient ] )->render(),
			'patient' => $patient
		], 200, [], JSON_UNESCAPED_UNICODE );
	}

	public function getPatients()
	{
		return view( 'doctor.patient.patients' );
	}

	public function getAddPatient()
	{
		$doctors = User::select( 'users.*' )
		               ->leftJoin( 'role_user', 'users.id', '=', 'role_user.user_id' )
		               ->leftJoin( 'roles', 'role_user.role_id', '=', 'roles.id' )
		               ->where( 'roles.slug', 'doctor' )
		               ->get();

		return view( 'doctor.patient.fre_register', [ 'doctors' => $doctors ] );
	}

	public function getViewPatient( $id )
	{
		$patient = Patient::with( [ 'appointments', 'appointmentsCount' ] )->find( $id );

		return view( 'doctor.patient.view', [ 'patient' => $patient ] );
	}

	public function postAddPatient( Request $request )
	{
		$employer          = $request->get( 'employer' );
		$spousePartner     = $request->get( 'spouse_partner' );
		$seenOtherProvider = $request->get( 'seen_other_provider' );
		$xRays             = $request->get( 'x_rays' );
		$formData          = $request->all();

		if ( ! empty( $employer ) ) {
			$this->validationRules['employer_phone_num'] = 'required|integer';
		}

		if ( ! empty( $spousePartner ) ) {
			$this->validationRules['spouse_partner_phone_num'] = 'required|integer';
		}

		if ( $seenOtherProvider == 'Y' ) {
			$this->validationRules['other_provider'] = 'required';
		} else {
			$formData['other_provider'] = 'N/A';
		}

		if ( $xRays == 'Y' ) {
			$this->validationRules['x_ray_date'] = 'required';
		} else {
			$formData['x_ray_date'] = '00/00/0000';
		}

		$validation = $this->validateInput( $request, $this->validationRules, $this->messages );

		if ( $validation->fails() ) {
			return response()->json( [
				'success' => false,
				'error'   => $validation->getMessageBag()
			], 200, [], JSON_UNESCAPED_UNICODE );
		}

		$patient = $this->create( $formData );

		if ( $patient ) {
			return response()->json( [ 'success' => true ], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al agregar paciente'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	public function getFrontProfile( Request $request )
	{
		$sel_doctor      = $request->session()->get( 'selected_doctor', '0' );
		$current_patient = Patient::where( 'customer_id', $this->auth->id() )->firstOrFail();

		if ( $current_patient->associated == 'Y' ) {
			if ( $sel_doctor == '2' || $sel_doctor == '3' ) {
				$currentDateTime    = date( 'Y-m-d H:i:s' );
				$patient            = Patient::with( [
					'doctor',
					'diseases',
					'medicines'
				] )->where( 'customer_id', $this->auth->id() )->where( 'doctor_id', $sel_doctor )->first();
				$nexUserAppointment = Appointment::with( [ 'doctor' ] )->where( 'patient_id', $patient->id )->where( 'type', '=', 'N' )->where( 'start', '>=', $currentDateTime )->orderBy( 'start', 'asc' )->first();

				return view( 'doctor.patient.fre_profile', [
					'patient'         => $patient,
					'nextAppointment' => $nexUserAppointment,
					'selected_doctor' => $sel_doctor
				] );
			} else {
				return redirect( 'patient/select-doctor', 302 );
			}
		} elseif ( $current_patient->associated == 'N' ) {
			$currentDateTime    = date( 'Y-m-d H:i:s' );
			$patient            = Patient::with( [
				'doctor',
				'diseases',
				'medicines'
			] )->where( 'customer_id', $this->auth->id() )->first();
			$nexUserAppointment = Appointment::with( [ 'doctor' ] )->where( 'patient_id', $patient->id )->where( 'type', '=', 'N' )->where( 'start', '>=', $currentDateTime )->orderBy( 'start', 'asc' )->first();

			return view( 'doctor.patient.fre_profile', [
				'patient'         => $patient,
				'nextAppointment' => $nexUserAppointment,
				'selected_doctor' => $sel_doctor
			] );
		}

	}

	public function postSelectDoctor( Request $request )
	{
		$doctor_id = $this->hashids->decode( $request->get( 'doctor' ) )[0];
		$doctor    = User::find( $doctor_id );

		if ( $doctor ) {
			$request->session()->set( 'selected_doctor', $doctor->id );

			return response()->json( [
				'success'     => true,
				'profile_url' => url( 'patient/profile' )
			], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al procesar la solicitud,'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	public function getSelectDoctor()
	{
		$doctors = User::select( 'users.*' )
		               ->join( 'role_user', 'users.id', '=', 'role_user.user_id' )
		               ->join( 'roles', 'role_user.role_id', '=', 'roles.id' )
		               ->where( 'roles.slug', 'doctor' )
		               ->whereIn( 'users.id', [ 2, 3 ] )
		               ->get();

		return view( 'doctor.patient.fre_select_doctor', [ 'doctors' => $doctors ] );
	}

	public function getFrontPatientInfo()
	{
		$patient = Patient::where( 'customer_id', $this->auth->id() )->first();

		return view( 'doctor.patient.edit-profile-ajax', [ 'patient' => $patient, ] );
	}

	public function getUpdatePatient( $id )
	{
		$patient = Patient::find( $id );

		return view( 'doctor.patient.update', [ 'patient' => $patient, ] );
	}

	public function postUpdatePatient( Request $request )
	{
		$employer          = $request->get( 'employer' );
		$spousePartner     = $request->get( 'spouse_partner' );
		$seenOtherProvider = $request->get( 'seen_other_provider' );
		$xRays             = $request->get( 'x_rays' );
		$formData          = $request->all();

		if ( ! empty( $employer ) ) {
			$this->validationRules['employer_phone_num'] = 'required|integer';
		}

		if ( ! empty( $spousePartner ) ) {
			$this->validationRules['spouse_partner_phone_num'] = 'required|integer';
		}

		if ( $seenOtherProvider == 'Y' ) {
			$this->validationRules['other_provider'] = 'required';
		} else {
			$formData['other_provider'] = 'N/A';
		}

		if ( $xRays == 'Y' ) {
			$this->validationRules['x_ray_date'] = 'required';
		} else {
			$formData['x_ray_date'] = '00/00/0000';
		}

		$this->validationRules['email'] = 'required|email|unique:patients,email,' . $request->get( 'patient_id' );
		$validation                     = $this->validateInput( $request, $this->validationRules, $this->messages );


		if ( $validation->fails() ) {
			return response()->json( [
				'success' => false,
				'error'   => $validation->getMessageBag()
			], 200, [], JSON_UNESCAPED_UNICODE );
		}

		$patient = $this->update( $formData );

		if ( $patient ) {
			return response()->json( [ 'success' => true ], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al editar el paciente'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	public function getRemovePatient( $id )
	{
		$user = Patient::find( $id );

		return view( 'doctor.patient.remove', [ 'patient' => $user ] );
	}

	public function getUpdateFrontProfile( Request $request )
	{
		$sel_doctor      = $request->session()->get( 'selected_doctor', '0' );
		$current_patient = Patient::where( 'customer_id', $this->auth->id() )->firstOrFail();
		$patient         = '';

		if ( $current_patient->associated == 'Y' ) {
			if ( $sel_doctor == '2' || $sel_doctor == '3' ) {
				$patient = Patient::with( [ 'doctor', 'medicines', 'diseases' ] )
				                  ->where( 'customer_id', $this->auth->id() )
				                  ->where( 'doctor_id', $sel_doctor )
				                  ->first();
			}

		} elseif ( $current_patient->associated == 'N' ) {
			$patient = Patient::with( [ 'doctor', 'medicines', 'diseases' ] )
			                  ->where( 'customer_id', $this->auth->id() )
			                  ->first();
		}

		if ( $patient->doctor['id'] == 3 ) {
			return view( 'doctor.pma_patient.fre_edit_information', [ 'patient' => $patient ] );
		}

		$diseases = Disease::all();

		return view( 'doctor.patient.fre_edit_information', [ 'patient' => $patient, 'diseases' => $diseases ] );
	}

	public function postUpdateFrontProfile( Request $request )
	{
		$formData   = $request->all();
		$sel_doctor = $request->session()->get( 'selected_doctor', '0' );

		if ( $sel_doctor == '2' || $sel_doctor == '3' ) {
			$patient = Patient::with( [ 'doctor' ] )
			                  ->where( 'customer_id', $this->auth->id() )
			                  ->where( 'doctor_id', $sel_doctor )
			                  ->first();
		} else {
			$patient = Patient::with( [ 'doctor' ] )->where( 'customer_id', $this->auth->id() )->first();
		}

		//$this->validationRules['email'] = 'required|email|unique:patients,email,' . $patient->id;

		if ( $patient->doctor['id'] == 3 ) {
			if ( $patient->age < 18 ) {
				$this->pma_validationRules['tutor_name'] = 'required';
			}

			$validation = $this->validateInput( $request, $this->pma_validationRules, $this->pma_messages );

			if ( $validation->fails() ) {
				return response()->json( [
					'success' => false,
					'error'   => $validation->getMessageBag()
				], 200, [], JSON_UNESCAPED_UNICODE );
			}

			$patient = $this->pma_update( $formData );
		} else {
			$validation = $this->validateInput( $request, $this->validationRules, $this->messages );

			if ( $validation->fails() ) {
				return response()->json( [
					'success' => false,
					'error'   => $validation->getMessageBag()
				], 200, [], JSON_UNESCAPED_UNICODE );
			}

			$patient = $this->update( $formData );
		}

		if ( $patient ) {
			return response()->json( [ 'success' => true ], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al editar el paciente'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	public function postRemovePatient( Request $request )
	{
		$formData = $request->all();
		$patient  = $this->remove( $formData );

		if ( $patient ) {
			return response()->json( [ 'success' => true ], 200, [], JSON_UNESCAPED_UNICODE );
		} else {
			return response()->json( [
				'success' => false,
				'error'   => 'Error al eliminar paciente'
			], 200, [], JSON_UNESCAPED_UNICODE );
		}
	}

	public function getGeneralInfoTab()
	{
		$patient = Patient::where( 'customer_id', $this->auth->id() )->first();

		return view( 'doctor.patient.general_info_tab', [ 'patient' => $patient ] );
	}

	protected function validateInput( Request $request, $rules, array $messages )
	{
		return Validator::make( $request->all(), $rules, $messages );
	}

	protected function remove( $data )
	{
		$patient = Patient::find( $data['pid'] );

		if ( $patient ) {
			$patient->delete();

			return true;
		}

		return false;
	}

	protected function update( $data )
	{
		$sel_doctor = Session::get( 'selected_doctor', '0' );
		$patient    = Patient::where( 'customer_id', $this->auth->id() )->first();

		if ( $patient->associated == 'Y' ) {
			$patient = Patient::where( 'customer_id', $this->auth->id() )->where( 'doctor_id', $sel_doctor )->first();
		}

		if ( $patient ) {
			$patient_diseases = DiseasePatient::all()->where( 'patient_id', $patient->id );
			if ( ! $patient_diseases->isEmpty() ) {
				foreach ( $patient_diseases as $patient_disease ) {
					$patient_disease->delete();
				}
			}

			if ( ! empty( $data['diseases'] ) ) {
				$diseases = $data['diseases'];

				foreach ( $diseases as $disease ) {
					if ( $disease != 0 ) {
						DiseasePatient::create( array(
							'disease_id' => $disease,
							'patient_id' => $patient->id
						) );
					}
				}
			}

			if ( ! empty( $data['medicine'] ) ) {
				$medicines = $data['medicine'];


				foreach ( $medicines as $medicine ) {

					if ( $medicine['id'] == 0 ) {
						PatientMedicine::create( array(
							'patient_id'     => $patient->id,
							'name'           => $medicine['name'],
							'dose_frequency' => $medicine['dose_frequency']
						) );
					} else {
						$up_medicine = PatientMedicine::find( $medicine['id'] );

						if ( $up_medicine ) {
							$up_medicine->name           = $medicine['name'];
							$up_medicine->dose_frequency = $medicine['dose_frequency'];

							$up_medicine->save();
						}
					}
				}
			}

			$XRayDate = '0000-00-00';
			if ( $data['x_rays'] == 'Y' ) {
				$XRayDate = DateTime::createFromFormat( 'd/m/Y', $data['x_ray_date'] )->format( 'Y-m-d' );
			}

			$exerciseInfo = '';
			if ( $data['exercise'] == 'Y' ) {
				$exerciseInfo = $data['exercise_info'];
			}

			/*$birth_date = DateTime::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');
			$from       = new DateTime($birth_date);
			$today      = new DateTime('today');
			$age        = $from->diff($today)->y;*/

			//$patient->full_name                 = $data['full_name'];
			//$patient->email                     = $data['email'];
			$patient->religion = $data['religion'];
			//$patient->birth_date                = $birth_date;
			$patient->birth_location = $data['birth_location'];
			//$patient->marital_status            = $data['marital_status'];
			//$patient->age                       = $age;
			//$patient->sex                       = $data['sex'];
			$patient->medical_insurance         = $data['medical_insurance'];
			$patient->medical_insurance_name    = $data['medical_insurance'] == 'Y' ? $data['medical_insurance_name'] : '';
			$patient->address                   = $data['address'];
			$patient->referred_by               = $data['referred_by'];
			$patient->pref_phone_num            = $data['pref_phone_num'];
			$patient->alt_phone_num             = $data['alt_phone_num'];
			$patient->occupation                = $data['occupation'];
			$patient->employer                  = $data['employer'];
			$patient->seen_other_provider       = $data['seen_other_provider'];
			$patient->other_provider_country    = $data['other_provider_country'];
			$patient->x_rays                    = $data['x_rays'];
			$patient->x_ray_date                = $XRayDate;
			$patient->operated                  = $data['operated'];
			$patient->operated_info             = $data['operated_info'];
			$patient->medical_inquiry_reason    = $data['medical_inquiry_reason'];
			$patient->medical_problem_time      = $data['medical_problem_time'];
			$patient->medical_problem_coup      = $data['medical_problem_coup'];
			$patient->medical_problem_coup_info = $data['medical_problem_coup_info'];
			$patient->sport_practice            = $data['sport_practice'];
			$patient->sport_practice_info       = $data['sport_practice_info'];
			$patient->exercise                  = $data['exercise'];
			$patient->exercise_info             = $exerciseInfo;
			$patient->alcohol                   = $data['alcohol'];
			$patient->alcohol_usage             = ( $data['alcohol'] == 'Y' ? $data['alcohol_usage'] : '' );
			$patient->smokes                    = $data['smokes'];
			$patient->smokes_per_day            = $data['smokes_per_day'];
			$patient->smokes_years              = $data['smokes_years'];
			$patient->allergies                 = $data['allergies'];
			$patient->allergies_cause           = $data['allergies_cause'];
			$patient->allergies_reaction        = $data['allergies_reaction'];

			$patient->save();
		}

		return $patient;
	}

	protected function pma_update( $data )
	{
		$patient = PmaPatient::where( 'customer_id', $this->auth->id() )->first();

		if ( $patient ) {

			$patient->medical_insurance      = $data['medical_insurance'];
			$patient->medical_insurance_name = $data['medical_insurance'] == 'Y' ? $data['medical_insurance_name'] : '';
			$patient->address                = $data['address'];
			$patient->referred_by            = $data['referred_by'];
			$patient->pref_phone_num         = $data['pref_phone_num'];
			$patient->alt_phone_num          = $data['alt_phone_num'];
			$patient->tutor_name             = $data['tutor_name'];
			$patient->children_info          = $data['children_info'];
			$patient->mental_services        = $data['mental_services'];
			$patient->mental_services_info   = $data['mental_services_info'];
			$patient->medicines_usage        = $data['medicines_usage'];
			$patient->medicines_usage_info   = $data['medicines_usage_info'];

			$patient->save();
		}

		return $patient;
	}

	protected function create( $data )
	{

		$XRayDate = '0000-00-00';
		if ( $data['x_rays'] == 'Y' ) {
			$XRayDate = date( 'Y-m-d', strtotime( $data['x_ray_date'] ) );
		}

		$patient = Patient::create( array(
			'doctor_id'                => $data['doctor'],
			'first_name'               => $data['first_name'],
			'middle_name'              => $data['middle_name'],
			'last_name'                => $data['last_name'],
			'email'                    => $data['email'],
			'marital_status'           => $data['marital_status'],
			'social_sec_num'           => $data['social_sec_num'],
			'birth_date'               => date( 'Y-m-d', strtotime( $data['birth_date'] ) ),
			'age'                      => $data['age'],
			'sex'                      => $data['sex'],
			'mailing_address'          => $data['mailing_address'],
			'city'                     => $data['city'],
			'state'                    => $data['city'],
			'zip'                      => $data['zip'],
			'pref_phone_num'           => $data['pref_phone_num'],
			'alt_phone_num'            => $data['alt_phone_num'],
			'occupation'               => $data['occupation'],
			'employer'                 => $data['employer'],
			'employer_phone_num'       => $data['employer_phone_num'],
			'employment_status'        => $data['employment_status'],
			'spouse_partner'           => $data['spouse_partner'],
			'spouse_partner_phone_num' => $data['spouse_partner_phone_num'],
			'seen_other_provider'      => $data['seen_other_provider'],
			'other_provider'           => $data['other_provider'],
			'x_rays'                   => $data['x_rays'],
			'x_ray_date'               => $XRayDate
		) );

		return $patient;
	}

	// Image upload

	protected $image_rules    = [
		'img' => 'required|mimes:png,gif,jpeg,jpg,bmp'
	];
	protected $image_messages = [
		'img.mimes'    => 'Formato de archivo no permitido',
		'img.required' => 'Imagen requerida'
	];

	public function postUpload( Request $request )
	{
		$form_data = $request->all();
		$validator = Validator::make( $form_data, $this->image_rules, $this->image_messages );
		if ( $validator->fails() ) {
			return response()->json( [
				'status'  => 'error',
				'message' => $validator->messages()->first(),
			], 200 );
		}
		$photo                     = $form_data['img'];
		$original_name             = $photo->getClientOriginalName();
		$original_name_without_ext = substr( $original_name, 0, strlen( $original_name ) - 4 );
		$filename                  = $original_name_without_ext;
		$allowed_filename          = $this->createUniqueFilename( $filename );
		$filename_ext              = $allowed_filename . '.png';
		$manager                   = new ImageManager();
		$image                     = $manager->make( $photo )->encode( 'png' )->save( public_path() . '/profile-pic/' . $filename_ext );
		if ( ! $image ) {
			return response()->json( [
				'status'  => 'error',
				'message' => 'Server error while uploading',
			], 200 );
		}

		return response()->json( [
			'status' => 'success',
			'url'    => asset( 'profile-pic/' . $filename_ext ),
			'width'  => $image->width(),
			'height' => $image->height()
		], 200 );
	}

	public function postCrop( Request $request )
	{
		$form_data      = $request->all();
		$temp_image_url = explode( '?', $form_data['imgUrl'] );
		$image_url      = $temp_image_url[0];
		// resized sizes
		$imgW = $form_data['imgW'];
		$imgH = $form_data['imgH'];
		// offsets
		$imgY1 = $form_data['imgY1'];
		$imgX1 = $form_data['imgX1'];
		// crop box
		$cropW = $form_data['width'];
		$cropH = $form_data['height'];
		// rotation angle
		$angle          = $form_data['rotation'];
		$filename_array = explode( '/', $image_url );
		$filename       = $filename_array[ sizeof( $filename_array ) - 1 ];
		$manager        = new ImageManager();
		$image          = $manager->make( $image_url );
		$image->resize( $imgW, $imgH )->rotate( - $angle )->crop( $cropW, $cropH, $imgX1, $imgY1 )->save( ( public_path() . '/profile-pic/cropped-' . $filename ) );
		if ( ! $image ) {
			return response()->json( [
				'status'  => 'error',
				'message' => 'Server error while uploading',
			], 200 );
		}

		return response()->json( [
			'status' => 'success',
			'url'    => asset( 'profile-pic/cropped-' . $filename )
		], 200 );
	}

	private function createUniqueFilename( $filename )
	{
		$this->hashids->setDefaultConnection( 'user_picture' );
		$filename = $this->hashids->encode( $this->auth->id() );

		return $filename;
	}

}
