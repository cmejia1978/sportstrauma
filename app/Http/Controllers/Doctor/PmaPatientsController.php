<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Appointment;
use App\DRDSB\Patient\Disease;
use App\DRDSB\Patient\DiseasePatient;
use App\DRDSB\Patient\PatientMedicine;
use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use App\DRDSB\Patient\PmaPatient;
use Bican\Roles\Models\Role;
use DateTime;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use Validator;

class PmaPatientsController extends Controller
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    protected $messages = array(
        'full_name.required'                 => 'Debe ingresar su nombre completo',
        'medical_insurance.required'         => 'Debe seleccionar sí o no',
        'medical_insurance.in'               => 'Debe seleccionar sí o no',
        'medical_insurance_name.required_if' => 'Debe ingresar el nombre del seguro médico',
        'email.required'                     => 'Debe ingresar una dirección de correo',
        'email.email'                        => 'Debe ingresar una dirección de correo válida',
        'email.unique'                       => 'Esta dirección de correo ya esta registrada',
        'birth_date.required'                => 'Debe ingresar la fecha de nacimiento',
        'age.required'                       => 'Debe ingresar la edad',
        'age.digits_between'                 => 'Debe ingresar una edad de 1 a 120',
        'address.required'                   => 'Debe ingresar su dirección',
        'pref_phone_num.required'            => 'Debe ingresar un número de teléfono',
        'pref_phone_num.numeric'             => 'Debe ingresar un número de teléfono (solo números)',
        'alt_phone_num.numeric'              => 'Debe ingresar un número de teléfono (solo números)',
        'mental_services_info.required_if'   => 'Debe ingresar el tipo de servicio de salud mental',
        'medicines_usage_info.required_if'   => 'Debe ingresar el tiempo y la información de los medicamentos',
        'tutor_name.required'                => 'Debe ingresar el nombre del padre/tutor',
    );

    protected $validationRules = array(
        'full_name'              => 'required',
        'medical_insurance'      => 'required|in:Y,N',
        'medical_insurance_name' => 'required_if:medical_insurance,Y',
        'email'                  => 'required|email|unique:patients',
        'birth_date'             => 'required',
        'address'                => 'required',
        'pref_phone_num'         => 'required|numeric',
        'alt_phone_num'          => 'numeric',
        'mental_services_info'   => 'required_if:mental_services,Y',
        'medicines_usage_info'   => 'required_if:medicines_usage,Y',
    );

    public function getPatientsData(Request $request)
    {
        return Datatables::of(PmaPatient::where('doctor_id', '=', $this->auth->id()))
            ->addColumn('action', function ($patient) {
                $activate_patient_account = '';
                $associate_doctor         = '';
                if ($patient->customer_id == 0) {
                    $activate_patient_account = '<a data-pid="' . $patient->id . '" title="Activar paciente" class="btn btn-default btn-xs dt-activate-patient" href="' . url('patient/activate', $patient->id) . '"><i class="fa fa-user-plus"></i></a>';
                } elseif ($patient->customer_id != 0 && $patient->associated == 'N') {
                    $associate_doctor = '<a data-pid="' . $patient->id . '" title="Asociar paciente con los demás doctores" class="btn btn-default btn-xs dt-assoc-patient" href="' . url('patient/associate', $patient->pid) . '"><i class="fa fa-user-md"></i></a>';
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

    public function getPatientInfo($id)
    {
        $patient = PmaPatient::find($id);
        return response()->json(['info' => View::make('doctor.pma_patient.ajax-update', ['patient' => $patient])->render(), 'patient' => $patient], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getPatients()
    {
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
        $patient               = PmaPatient::with(['appointments', 'appointmentsCount', 'diseases', 'medicines'])->find($id);
        $nexPatientAppointment = Appointment::with(['doctor'])->where('patient_id', $id)->where('start', '>=', $currentDateTime)->orderBy('start', 'asc')->first();

        return view('doctor.patient.view', ['patient' => $patient, 'nextAppointment' => $nexPatientAppointment]);
    }

    public function postPatientActivate(Request $request)
    {
        $formData = $request->all();

        $patientRole = Role::where('slug', 'patient')->first();
        $password    = '4Urs2TBRDJbtTGBGgqKGmbMrDMxKUt';
        $patient     = PmaPatient::find($formData['pid']);

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

        $birth_date = DateTime::createFromFormat('d/m/Y', $formData['birth_date'])->format('Y-m-d');
        $from       = new DateTime($birth_date);
        $today      = new DateTime('today');
        $age        = $from->diff($today)->y;

        if ($age < 18) {
            $this->validationRules['tutor_name'] = 'required';
        }

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
        $patient  = PmaPatient::with(['medicines', 'diseases'])->where('id', $id)->first();
        $diseases = Disease::all();

        return view('doctor.patient.update', ['patient' => $patient, 'diseases' => $diseases]);
    }

    public function postUpdatePatient(Request $request)
    {
        $formData = $request->all();

        $birth_date = DateTime::createFromFormat('d/m/Y', $formData['birth_date'])->format('Y-m-d');
        $from       = new DateTime($birth_date);
        $today      = new DateTime('today');
        $age        = $from->diff($today)->y;

        if ($age < 18) {
            $this->validationRules['tutor_name'] = 'required';
        }

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
        $user = PmaPatient::find($id);

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
        $patient = PmaPatient::find($data['pid']);

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
        $patient  = PmaPatient::find($data['patient_id']);
        $patients = PmaPatient::where('customer_id', $data['customer_id'])->where('id', '<>', $data['patient_id'])->get();
        $user     = User::find($data['customer_id']);

        if ($patient) {

            if ($user) {
                $user->name = $data['full_name'];
                $user->email = $data['email'];
                $user->save();
            }

            /*foreach ($patients as $c_patient) {
                $c_patient->email = $data['email'];
                $c_patient->save();
            }*/

            $birth_date = DateTime::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');
            $from       = new DateTime($birth_date);
            $today      = new DateTime('today');
            $age        = $from->diff($today)->y;

            $patient->full_name              = $data['full_name'];
            $patient->medical_insurance      = $data['medical_insurance'];
            $patient->medical_insurance_name = $data['medical_insurance'] == 'Y' ? $data['medical_insurance_name'] : '';
            $patient->email                  = $data['email'];
            $patient->birth_date             = $birth_date;
            $patient->marital_status         = $data['marital_status'];
            $patient->referred_by            = $data['referred_by'];
            $patient->age                    = $age;
            $patient->sex                    = $data['sex'];
            $patient->address                = $data['address'];
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

    protected function create($data)
    {
        $birth_date = DateTime::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');
        $from       = new DateTime($birth_date);
        $today      = new DateTime('today');
        $age        = $from->diff($today)->y;

        $patient = PmaPatient::create(array(
            'doctor_id'              => $this->auth->id(),
            'full_name'              => $data['full_name'],
            'medical_insurance'      => $data['medical_insurance'],
            'medical_insurance_name' => $data['medical_insurance'] == 'Y' ? $data['medical_insurance_name'] : '',
            'email'                  => $data['email'],
            'marital_status'         => $data['marital_status'],
            'birth_date'             => $birth_date,
            'referred_by'            => $data['referred_by'],
            'age'                    => $age,
            'sex'                    => $data['sex'],
            'address'                => $data['address'],
            'pref_phone_num'         => $data['pref_phone_num'],
            'alt_phone_num'          => $data['alt_phone_num'],
            'tutor_name'             => $data['tutor_name'],
            'children_info'          => $data['children_info'],
            'mental_services'        => $data['mental_services'],
            'mental_services_info'   => $data['mental_services_info'],
            'medicines_usage'        => $data['medicines_usage'],
            'medicines_usage_info'   => $data['medicines_usage_info'],
        ));


        return $patient;
    }

}
