<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Appointment;
use App\DRDSB\Patient\Disease;
use App\DRDSB\Patient\DiseasePatient;
use App\DRDSB\Patient\PatientMedicine;
use App\DRDSB\Patient\PmaPatient;
use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use App\DRDSB\Patient\Patient;
use Bican\Roles\Models\Role;
use DateTime;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use Validator;

class PatientsController extends Controller
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    protected $messages = array(
        'full_name.required'                      => 'Debe ingresar su nombre completo',
        'medical_insurance.required'              => 'Debe seleccionar sí o no',
        'medical_insurance.in'                    => 'Debe seleccionar sí o no',
        'medical_insurance_name.required_if'      => 'Debe ingresar el nombre del seguro médico',
        'religion.required'                       => 'Debe ingresar su religión',
        'email.required'                          => 'Debe ingresar una dirección de correo',
        'email.email'                             => 'Debe ingresar una dirección de correo válida',
        'email.unique'                            => 'Esta dirección de correo ya esta registrada',
        'birth_date.required'                     => 'Debe ingresar la fecha de nacimiento',
        'birth_location.required'                 => 'Debe ingresar el lugar de nacimiento',
        'age.required'                            => 'Debe ingresar la edad',
        'age.digits_between'                      => 'Debe ingresar una edad de 1 a 120',
        'address.required'                        => 'Debe ingresar su dirección',
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
        'full_name'                 => 'required',
        'medical_insurance'         => 'required|in:Y,N',
        'medical_insurance_name'    => 'required_if:medical_insurance,Y',
        'email'                     => 'required|email|unique:patients',
        //'religion'                  => 'required',
        'birth_date'                => 'required',
        //'birth_location'            => 'required',
        'address'                   => 'required',
        'pref_phone_num'            => 'required|numeric',
        'alt_phone_num'             => 'numeric',
        //'occupation'                => 'required',
        //'employer'                  => 'required',
        'other_provider_country'    => 'required_if:seen_other_provider,Y',
        'x_ray_date'                => 'required_if:x_rays,Y',
        'operated_info'             => 'required_if:operated,Y',
        //'medical_inquiry_reason'    => 'required',
        //'medical_problem_time'      => 'required',
        'medical_problem_coup_info' => 'required_if:medical_problem_coup,Y',
        'sport_practice_info'       => 'required_if:sport_practice,Y',
        'exercise_info'             => 'required_if:exercise,Y',
        'alcohol_usage'             => 'required_if:alcohol,Y',
        'smokes_per_day'            => 'required_if:smokes,Y',
        //'smokes_years'              => 'required_if:smokes,Y',
        'medicine.*.name'           => 'required_with:medicine.*.dose_frequency',
        'medicine.*.dose_frequency' => 'required_with:medicine.*.name',
        'allergies_cause'           => 'required_with:allergies',
        'allergies_reaction'        => 'required_with:allergies'
    );

    public function getPatientsData(Request $request)
    {
        return Datatables::of(Patient::where('doctor_id', '=', $this->auth->id()))
            ->addColumn('action', function ($patient) {
                $activate_patient_account = '';
                $associate_doctor         = '';
                if ($patient->customer_id == 0) {
                    $activate_patient_account = '<a data-pid="' . $patient->id . '" title="Activar paciente" class="btn btn-default btn-xs dt-activate-patient" href="' . url('patient/activate', $patient->id) . '"><i class="fa fa-user-plus"></i></a>';
                } elseif ($patient->customer_id != 0 && $patient->associated == 'N') {
                    $associate_doctor = '<a data-pid="' . $patient->id . '" title="Asociar paciente con los demás doctores" class="btn btn-default btn-xs dt-assoc-patient" href="' . url('patient/associate', $patient->customer_id) . '"><i class="fa fa-user-md"></i></a>';
                }

                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-pid="' . $patient->id . '" data-remodal-target="update-patient" class="dt-update-patient" href="#">Editar información</a></li>
                            <li><a data-pid="' . $patient->id . '" data-remodal-target="remove-patient" class="dt-remove-patient" href="#">Eliminar paciente</a></li>                           
                        </ul>
                        ' . $activate_patient_account . '
                        ' . $associate_doctor . '
                        <a href="' . url('appointments', $patient->id) . '" title="Agendar cita" class="btn btn-default btn-xs"><i class="fa fa-calendar"></i></a>
                        <a href="' . url('patients/view', $patient->id) . '" title="Ver información paciente" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>
                    </div>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('status') && $request->get('status') == 'active') {
                    $query->where('customer_id', '<>', '0');
                } elseif ($request->has('status') && $request->get('status') == 'inactive') {
                    $query->where('customer_id', '=', '0');
                }

                if ($keyword = $request->get('search')['value']) {
                    $query->whereRaw("(LOWER(`id`) LIKE '%%$keyword%%' or LOWER(`full_name`) LIKE '%%$keyword%%' or LOWER(`email`) LIKE '%%$keyword%%' or LOWER(`marital_status`) LIKE '%%$keyword%%' or LOWER(`birth_date`) LIKE '%%$keyword%%' or LOWER(`age`) LIKE '%%$keyword%%' or LOWER(`sex`) LIKE '%%$keyword%%' or LOWER(`address`) LIKE '%%$keyword%%' or LOWER(`pref_phone_num`) LIKE '%%$keyword%%' or LOWER(`alt_phone_num`) LIKE '%%$keyword%%' or LOWER(`occupation`) LIKE '%%$keyword%%' or LOWER(`employer`) LIKE '%%$keyword%%' or LOWER(`seen_other_provider`) LIKE '%%$keyword%%' or LOWER(`x_rays`) LIKE '%%$keyword%%' or LOWER(`x_ray_date`) LIKE '%%$keyword%%' or LOWER(`created_at`) LIKE '%%$keyword%%' or LOWER(`updated_at`) LIKE '%%$keyword%%')");
                }
            })
            ->make(true);
    }

    public function postAssociatePatient(Request $request)
    {
        $patient = Patient::find($request->get('pid'));

        $doctor_id = $this->auth->id() == 2 ? 3 : $this->auth->id() == 3 ? 2 : 0;

        $doctors = User::select('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.slug', 'doctor')
            ->where('users.id', '<>', $this->auth->id())
            ->get();

        if ($patient) {

            foreach ($doctors as $doctor) {
                Patient::create(array(
                    'doctor_id'      => $doctor->id,
                    'customer_id'    => $patient->customer_id,
                    'full_name'      => $patient->full_name,
                    'email'          => $patient->email,
                    'marital_status' => $patient->marital_status,
                    'birth_date'     => $patient->birth_date_db,
                    'age'            => $patient->age,
                    'sex'            => $patient->sex,
                    'address'        => $patient->address,
                    'pref_phone_num' => $patient->pref_phone_num,
                    'alt_phone_num'  => $patient->alt_phone_num,
                    'associated'     => 'Y'
                ));
            }

            $patient->associated = 'Y';
            $patient->save();

            return response()->json(['success' => true, 'patient_full_name' => $patient->full_name], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'errors' => 'Error al asociar paciente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getPatientInfo($id)
    {
        $patient = Patient::find($id);
        return response()->json(['info' => View::make('doctor.patient.ajax-update', ['patient' => $patient])->render(), 'patient' => $patient], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getPatients()
    {
        if ($this->auth->id() == 3) {
            $diseases = Disease::all();
            return view('doctor.pma_patient.patients', ['diseases' => $diseases]);
        }


        $diseases = Disease::all();
        return view('doctor.patient.patients', ['diseases' => $diseases]);

    }

    public function getAddPatient()
    {
        return view('doctor.patient.new');
    }

    public function getViewPatient($id)
    {
        $currentDateTime       = date('Y-m-d H:i:s');
        $patient               = Patient::with(['doctor', 'appointments', 'appointmentsCount', 'diseases', 'medicines'])->find($id);
        $nexPatientAppointment = Appointment::with(['doctor'])->where('patient_id', $id)->where('start', '>=', $currentDateTime)->orderBy('start', 'asc')->first();

        return view('doctor.patient.view', ['patient' => $patient, 'nextAppointment' => $nexPatientAppointment]);
    }

    public function postPatientActivate(Request $request)
    {
        $formData = $request->all();

        $patientRole = Role::where('slug', 'patient')->first();
        $password    = '4Urs2TBRDJbtTGBGgqKGmbMrDMxKUt';
        $patient     = Patient::find($formData['pid']);

        if ($patient) {

            $account = User::create(array(
                'name'     => $patient->full_name,
                'email'    => $patient->email,
                'password' => bcrypt($password)
            ));

            $account->attachRole($patientRole);
            $patient->customer_id = $account['id'];
            $patient->save();

            view()->composer('auth.emails.password', function ($view) {
                $view->with([
                    'activated' => true
                ]);
            });

            Password::sendResetLink(['email' => $patient->email], function ($message) {
                $message->subject('Su cuenta ha sido activada');
            });

            return response()->json(['success' => true, 'patient_full_name' => $patient->full_name], 200, [], JSON_UNESCAPED_UNICODE);
        }


        return response()->json(['success' => false, 'error' => 'Error al activar paciente'], 200, [], JSON_UNESCAPED_UNICODE);

    }

    public function postAddPatient(Request $request)
    {
        $formData = $request->all();

        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $patient = $this->create($formData);

        if ($patient) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al agregar paciente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getUpdatePatient($id)
    {
        $patient  = Patient::with(['medicines', 'diseases'])->where('id', $id)->first();
        $diseases = Disease::all();

        return view('doctor.patient.update', ['patient' => $patient, 'diseases' => $diseases]);
    }

    public function postUpdatePatient(Request $request)
    {
        $formData = $request->all();

        $this->validationRules['email'] = 'required|email|unique:users,email,' . $request->get('customer_id');
        $validation                     = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $patient = $this->update($formData);

        if ($patient) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar el paciente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getRemovePatient($id)
    {
        $user = Patient::find($id);

        return view('doctor.patient.remove', ['patient' => $user]);
    }

    public function postRemovePatient(Request $request)
    {
        $formData = $request->all();
        $patient  = $this->remove($formData);

        if ($patient) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar paciente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    protected function validateInput(Request $request, $rules, array $messages)
    {
        return Validator::make($request->all(), $rules, $messages);
    }

    protected function remove($data)
    {
        $patient = Patient::find($data['pid']);

        if ($patient) {
            if ($patient->customer_id != 0) {
                $user = User::find($patient->customer_id);
                if ($user) {
                    $user->delete();
                }

                $appointments = Appointment::where('patient_id', $patient->id)->get();
                foreach ($appointments as $appointment) {
                    $apt = Appointment::find($appointment->id);

                    if ($apt) {
                        $apt->delete();
                    }
                }
            }


            $patient->delete();


            return true;
        }

        return false;
    }

    protected function update($data)
    {
        $patient  = Patient::find($data['patient_id']);
        $patients = Patient::where('customer_id', $data['customer_id'])->where('id', '<>', $data['patient_id'])->get();
        $user     = User::find($data['customer_id']);

        if ($patient) {

            $user->name = $data['full_name'];
            $user->email = $data['email'];
            $user->save();

            foreach ($patients as $c_patient) {
                $c_patient->email = $data['email'];
                $c_patient->save();
            }

            $patient_diseases = DiseasePatient::all()->where('patient_id', $patient->id);
            if (!$patient_diseases->isEmpty()) {
                foreach ($patient_diseases as $patient_disease) {
                    $patient_disease->delete();
                }
            }

            if (!empty($data['diseases'])) {
                $diseases = $data['diseases'];

                foreach ($diseases as $disease) {
                    if ($disease != 0)
                        DiseasePatient::create(array(
                            'disease_id' => $disease,
                            'patient_id' => $patient->id
                        ));
                }
            }

            if (!empty($data['medicine'])) {
                $medicines = $data['medicine'];

                foreach ($medicines as $medicine) {

                    if ($medicine['id'] == 0) {
                        PatientMedicine::create(array(
                            'patient_id'     => $patient->id,
                            'name'           => $medicine['name'],
                            'dose_frequency' => $medicine['dose_frequency']
                        ));
                    } else {
                        $up_medicine = PatientMedicine::find($medicine['id']);

                        if ($up_medicine) {
                            $up_medicine->name           = $medicine['name'];
                            $up_medicine->dose_frequency = $medicine['dose_frequency'];

                            $up_medicine->save();
                        }
                    }
                }
            }

            $XRayDate = '0000-00-00';
            if ($data['x_rays'] == 'Y') {
                $XRayDate = DateTime::createFromFormat('d/m/Y', $data['x_ray_date'])->format('Y-m-d');
            }

            $exerciseInfo = '';
            if ($data['exercise'] == 'Y') {
                $exerciseInfo = $data['exercise_info'];
            }

            $birth_date = DateTime::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');
            $from       = new DateTime($birth_date);
            $today      = new DateTime('today');
            $age        = $from->diff($today)->y;

            $patient->full_name                 = $data['full_name'];
            $patient->surgery_name              = $data['surgery_name'];
            $patient->medical_insurance         = $data['medical_insurance'];
            $patient->medical_insurance_name    = ($data['medical_insurance'] == 'Y' ? $data['medical_insurance_name'] : '');
            $patient->email                     = $data['email'];
            $patient->religion                  = $data['religion'];
            $patient->birth_date                = $birth_date;
            $patient->birth_location            = $data['birth_location'];
            $patient->marital_status            = $data['marital_status'];
            $patient->referred_by               = $data['referred_by'];
            $patient->age                       = $age;
            $patient->sex                       = $data['sex'];
            $patient->address                   = $data['address'];
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
            $patient->alcohol_usage             = ($data['alcohol'] == 'Y' ? $data['alcohol_usage'] : '');
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

    protected function create($data)
    {
        $XRayDate = '0000-00-00';
        if ($data['x_rays'] == 'Y') {
            $XRayDate = $XRayDate = DateTime::createFromFormat('d/m/Y', $data['x_ray_date'])->format('Y-m-d');
        }

        $exerciseInfo = '';
        if ($data['exercise'] == 'Y') {
            $exerciseInfo = $data['exercise_info'];
        }

        $birth_date = DateTime::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');
        $from       = new DateTime($birth_date);
        $today      = new DateTime('today');
        $age        = $from->diff($today)->y;

        $patient = Patient::create(array(
            'doctor_id'                 => $this->auth->id(),
            'full_name'                 => $data['full_name'],
            'surgery_name'              => $data['surgery_name'],
            'medical_insurance'         => $data['medical_insurance'],
            'medical_insurance_name'    => ($data['medical_insurance'] == 'Y' ? $data['medical_insurance_name'] : ''),
            'email'                     => $data['email'],
            'religion'                  => $data['religion'],
            'marital_status'            => $data['marital_status'],
            'birth_date'                => $birth_date,
            'referred_by'               => $data['referred_by'],
            'birth_location'            => $data['birth_location'],
            'age'                       => $age,
            'sex'                       => $data['sex'],
            'address'                   => $data['address'],
            'pref_phone_num'            => $data['pref_phone_num'],
            'alt_phone_num'             => $data['alt_phone_num'],
            'occupation'                => $data['occupation'],
            'employer'                  => $data['employer'],
            'seen_other_provider'       => $data['seen_other_provider'],
            'other_provider_country'    => $data['other_provider_country'],
            'x_rays'                    => $data['x_rays'],
            'x_ray_date'                => $XRayDate,
            'operated'                  => $data['operated'],
            'operated_info'             => $data['operated_info'],
            'medical_inquiry_reason'    => $data['medical_inquiry_reason'],
            'medical_problem_time'      => $data['medical_problem_time'],
            'medical_problem_coup'      => $data['medical_problem_coup'],
            'medical_problem_coup_info' => $data['medical_problem_coup_info'],
            'sport_practice'            => $data['sport_practice'],
            'sport_practice_info'       => $data['sport_practice_info'],
            'exercise'                  => $data['exercise'],
            'exercise_info'             => $exerciseInfo,
            'alcohol'                   => $data['alcohol'],
            'alcohol_usage'             => ($data['alcohol'] == 'Y' ? $data['alcohol_usage'] : ''),
            'smokes'                    => $data['smokes'],
            'smokes_per_day'            => $data['smokes_per_day'],
            'smokes_years'              => $data['smokes_years'],
            'allergies'                 => $data['allergies'],
            'allergies_cause'           => $data['allergies_cause'],
            'allergies_reaction'        => $data['allergies_reaction'],
        ));


        if (!empty($data['diseases'])) {
            $diseases = $data['diseases'];

            foreach ($diseases as $disease) {
                if ($disease != 0)
                    DiseasePatient::create(array(
                        'disease_id' => $disease,
                        'patient_id' => $patient['id']
                    ));
            }
        }

        if (!empty($data['medicine'])) {
            $medicines = $data['medicine'];

            foreach ($medicines as $medicine) {
                PatientMedicine::create(array(
                    'patient_id'     => $patient['id'],
                    'name'           => $medicine['name'],
                    'dose_frequency' => $medicine['dose_frequency']
                ));
            }
        }


        return $patient;
    }

}
