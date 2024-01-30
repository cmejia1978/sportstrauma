<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Vinkla\Hashids\HashidsManager;
use Validator;
use stdClass;

class DoctorProfileController extends Controller
{

    protected $auth;
    protected $userDir;
    protected $hashids;

    protected $rules = array(
        'name'         => 'required',
        'password'     => 'confirmed|min:6',
        'notify_email' => 'required|email',
    );

    protected $messages = array(
        'name.required'         => 'Debe ingresar su nombre',
        'password.min'          => 'La contraseña debe tener 6 caracteres como mínimo',
        'password.confirmed'    => 'La confirmación de la contraseña no concuerda',
        'notify_email.required' => 'Debe ingresar un correo para notificaciones',
        'notify_email.email'    => 'Debe ingresar un correo válido para notificaciones',
    );

    public function __construct(Guard $guard, HashidsManager $hashids)
    {
        $this->auth    = $guard;
        $this->hashids = $hashids;
    }

    protected function validateInput($input, $rules, array $messages)
    {
        return Validator::make($input, $rules, $messages);
    }

    public function getUpdateProfile()
    {
        $user = User::find($this->auth->id());

        return view('doctor.ajax-update', ['doctor' => $user]);
    }

    public function postUpdateProfile(Request $request)
    {
        $form_data                   = $request->all();

        $validation = $this->validateInput($form_data, $this->rules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $doctor = $this->update($form_data);

        if ($doctor) {
            return response()->json(['success' => true, 'doctor_name' => $doctor->name], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar información'], 200, [], JSON_UNESCAPED_UNICODE);
        }

    }

    protected function update($data)
    {
        $doctor = User::find($this->auth->id());

        if ($doctor) {
            $doctor->name         = $data['name'];
            $doctor->notify_email = $data['notify_email'];

            if (!empty($data['password'])) {
                $doctor->password     = bcrypt($data['password']);
            }


            $doctor->save();

            return $doctor;
        }

        return false;
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
