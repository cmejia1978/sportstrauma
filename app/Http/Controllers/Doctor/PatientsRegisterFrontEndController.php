<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Appointment;
use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use App\DRDSB\Patient\Patient;
use DateTime;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManager;
use Vinkla\Hashids\HashidsManager;
use Yajra\Datatables\Datatables;
use Validator;

class PatientsRegisterFrontEndController extends Controller
{
    protected $auth;
    protected $hashids;

    public function __construct(Guard $auth, HashidsManager $hashids)
    {
        $this->auth    = $auth;
        $this->hashids = $hashids;
    }

    protected $messages = array(
        'medical_insurance.required'         => 'Debe seleccionar sí o no',
        'medical_insurance.in'               => 'Debe seleccionar sí o no',
        'medical_insurance_name.required_if' => 'Debe ingresar el nombre del seguro médico',
        'full_name.required'                 => 'Debe ingresar su nombre completo',
        'email.required'                     => 'Debe ingresar una dirección de correo',
        'email.email'                        => 'Debe ingresar una dirección de correo válida',
        'email.unique'                       => 'Esta dirección de correo ya esta registrada',
        'birth_date.required'                => 'Debe ingresar la fecha de nacimiento',
        'address.required'                   => 'Debe ingresar una dirección de envío',
        'city.required'                      => 'Debe ingresar una ciudad',
        'state.required'                     => 'Debe ingresar un estado',
        'zip.required'                       => 'Debe ingresar un código postal',
        'pref_phone_num.required'            => 'Debe ingresar un número de teléfono',
        'pref_phone_num.numeric'             => 'Debe ingresar un número de teléfono (solo números)',
        'alt_phone_num.numeric'              => 'Debe ingresar un número de teléfono (solo números)',
        //'occupation.required'               => 'Debe ingresar una ocupación',
        //'employer_phone_num.required'       => 'Debe ingresar el número de teléfono de la empresa',
        //'employer_phone_num.integer'        => 'Debe ingresar el número de teléfono de la empresa (solo números)',
        //'spouse_partner_phone_num.required' => 'Debe ingresar el número de teléfono del Cónyuge / pareja',
        //'spouse_partner_phone_num.integer'  => 'Debe ingresar el número de teléfono del Cónyuge / pareja (solo números)',
        //'other_provider.required'           => 'Debe ingresar el nombre del doctor',
        //'x_ray_date.required'               => 'Debe ingresar la fecha de las radiografías',
    );

    protected $validationRules = array(
        'full_name'              => 'required',
        'medical_insurance'      => 'required|in:Y,N',
        'medical_insurance_name' => 'required_if:medical_insurance,Y',
        'email'             => 'required|email|unique:patients',
        //'social_sec_num'  => 'required|numeric',
        'birth_date'        => 'required',
        //'age'             => 'required|digits_between:1,120',
        'address'           => 'required',
        //'city'            => 'required',
        //'state'           => 'required',
        //'zip'             => 'required',
        'pref_phone_num'    => 'required|numeric',
        'alt_phone_num'     => 'numeric',
        //'occupation'      => 'required',
    );

    public function getPatientsData()
    {
        return Datatables::of(Patient::where('doctor_id', '=', $this->auth->id()))
            ->addColumn('action', function ($patient) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-pid="' . $patient->id . '" data-remodal-target="update-patient" class="dt-update-patient" href="#">Editar información</a></li>
                            <li><a data-pid="' . $patient->id . '" data-remodal-target="remove-patient" class="dt-remove-patient" href="#">Eliminar paciente</a></li>
                            <li class="divider"></li>
                            <li><a href="' . url('appointments', $patient->id) . '">Agendar cita</a></li>
                            <li><a href="' . url('patients/view', $patient->id) . '">Ver información completa</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getPatientInfo($id)
    {
        $patient = Patient::find($id);
        return response()->json(['info' => View::make('doctor.patient.ajax-update', ['patient' => $patient])->render(), 'patient' => $patient], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getPatients()
    {
        return view('doctor.patient.patients');
    }

    public function getAddPatient()
    {
        $doctors = User::select('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.slug', 'doctor')
            ->get();
        return view('doctor.patient.fre_register', ['doctors' => $doctors]);
    }

    public function getViewPatient($id)
    {
        $patient = Patient::with(['appointments', 'appointmentsCount'])->find($id);

        return view('doctor.patient.view', ['patient' => $patient]);
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

    public function getFrontProfile()
    {
        $currentDateTime    = date('Y-m-d H:i:s');
        $patient            = Patient::where('customer_id', $this->auth->id())->first();
        $nexUserAppointment = Appointment::with(['doctor'])->where('patient_id', $patient->id)->where('start', '>=', $currentDateTime)->orderBy('start', 'asc')->first();

        return view('doctor.patient.fre_profile', [
            'patient'         => $patient,
            'nextAppointment' => $nexUserAppointment
        ]);
    }

    public function getFrontPatientInfo()
    {
        $patient = Patient::where('customer_id', $this->auth->id())->first();

        return view('doctor.patient.edit-profile-ajax', ['patient' => $patient,]);
    }

    public function getUpdatePatient($id)
    {
        $patient = Patient::find($id);

        return view('doctor.patient.update', ['patient' => $patient,]);
    }

    public function postUpdatePatient(Request $request)
    {
        $employer          = $request->get('employer');
        $spousePartner     = $request->get('spouse_partner');
        $seenOtherProvider = $request->get('seen_other_provider');
        $xRays             = $request->get('x_rays');
        $formData          = $request->all();

        if (!empty($employer)) {
            $this->validationRules['employer_phone_num'] = 'required|integer';
        }

        if (!empty($spousePartner)) {
            $this->validationRules['spouse_partner_phone_num'] = 'required|integer';
        }

        if ($seenOtherProvider == 'Y') {
            $this->validationRules['other_provider'] = 'required';
        } else {
            $formData['other_provider'] = 'N/A';
        }

        if ($xRays == 'Y') {
            $this->validationRules['x_ray_date'] = 'required';
        } else {
            $formData['x_ray_date'] = '00/00/0000';
        }

        $this->validationRules['email'] = 'required|email|unique:patients,email,' . $request->get('patient_id');
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

    public function postUpdateFrontProfile(Request $request)
    {
        $patient  = Patient::where('customer_id', $this->auth->id())->first();

        $rules = [
            'email'           => 'required|email|unique:patients,email,' . $patient->id,
            'mailing_address' => 'required',
            'pref_phone_num'  => 'required|numeric',
        ];

        $messages = [
            'email.required'           => 'Debe ingresar una dirección de correo',
            'email.email'              => 'Debe ingresar una dirección de correo válida',
            'email.unique'             => 'Esta dirección de correo ya esta registrada',
            'mailing_address.required' => 'Debe ingresar una dirección de envío',
            'pref_phone_num.required'  => 'Debe ingresar un número de teléfono',
            'pref_phone_num.numeric'   => 'Debe ingresar un número de teléfono (solo números)',
        ];

        $this->validationRules['email'] = 'required|email|unique:patients,email,' . $request->get('patient_id');
        $validation                     = $this->validateInput($request, $rules, $messages);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $patient = $this->update($request->all());

        if ($patient) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar el paciente'], 200, [], JSON_UNESCAPED_UNICODE);
        }
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

    public function getGeneralInfoTab()
    {
        $patient = Patient::where('customer_id', $this->auth->id())->first();

        return view('doctor.patient.general_info_tab', ['patient' => $patient]);
    }

    protected function validateInput(Request $request, $rules, array $messages)
    {
        return Validator::make($request->all(), $rules, $messages);
    }

    protected function remove($data)
    {
        $patient = Patient::find($data['pid']);

        if ($patient) {
            $patient->delete();
            return true;
        }

        return false;
    }

    protected function update($data)
    {
        $patient = Patient::where('customer_id', $this->auth->id())->first();

        if ($patient) {
            $patient->email           = $data['email'];
            $patient->mailing_address = $data['mailing_address'];
            $patient->pref_phone_num  = $data['pref_phone_num'];

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

        $patient = Patient::create(array(
            'doctor_id'              => $data['doctor'],
            'full_name'              => $data['full_name'],
            'medical_insurance'      => $data['medical_insurance'],
            'medical_insurance_name' => $data['medical_insurance_name'],
            'email'                  => $data['email'],
            'marital_status'         => $data['marital_status'],
            'birth_date'             => $birth_date,
            'age'                    => $age,
            'sex'                    => $data['sex'],
            'address'                => $data['address'],
            'pref_phone_num'         => $data['pref_phone_num'],
            'alt_phone_num'          => $data['alt_phone_num'],
        ));

        return $patient;
    }

    // Image upload

    protected $image_rules = [
        'img' => 'required|mimes:png,gif,jpeg,jpg,bmp'
    ];
    protected $image_messages = [
        'img.mimes'    => 'Formato de archivo no permitido',
        'img.required' => 'Imagen requerida'
    ];

    public function postUpload(Request $request)
    {
        $form_data = $request->all();
        $validator = Validator::make($form_data, $this->image_rules, $this->image_messages);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $photo                     = $form_data['img'];
        $original_name             = $photo->getClientOriginalName();
        $original_name_without_ext = substr($original_name, 0, strlen($original_name) - 4);
        $filename                  = $original_name_without_ext;
        $allowed_filename          = $this->createUniqueFilename($filename);
        $filename_ext              = $allowed_filename . '.png';
        $manager                   = new ImageManager();
        $image                     = $manager->make($photo)->encode('png')->save(public_path() . '/profile-pic/' . $filename_ext);
        if (!$image) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Server error while uploading',
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'url'    => asset('profile-pic/' . $filename_ext),
            'width'  => $image->width(),
            'height' => $image->height()
        ], 200);
    }

    public function postCrop(Request $request)
    {
        $form_data      = $request->all();
        $temp_image_url = explode('?', $form_data['imgUrl']);
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
        $filename_array = explode('/', $image_url);
        $filename       = $filename_array[sizeof($filename_array) - 1];
        $manager        = new ImageManager();
        $image          = $manager->make($image_url);
        $image->resize($imgW, $imgH)->rotate(-$angle)->crop($cropW, $cropH, $imgX1, $imgY1)->save((public_path() . '/profile-pic/cropped-' . $filename));
        if (!$image) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Server error while uploading',
            ], 200);
        }
        return response()->json([
            'status' => 'success',
            'url'    => asset('profile-pic/cropped-' . $filename)
        ], 200);
    }

    private function createUniqueFilename($filename)
    {
        $this->hashids->setDefaultConnection('user_picture');
        $filename = $this->hashids->encode($this->auth->id());

        return $filename;
    }

}
