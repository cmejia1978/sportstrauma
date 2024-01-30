<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\File\GeneralFileEntry;
use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use App\DRDSB\Patient\Patient;
use Bican\Roles\Models\Role;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Datatables;
use Validator;
use stdClass;

class GeneralFilesController extends Controller
{

    protected $auth;
    protected $userDir;

    protected $validationRules = array(
        'description' => 'required',
        'category'    => 'required'
    );

    protected $validationMessages = array(
        'description.required' => 'Debe ingresar una descripción',
        'category.required'    => 'Debe seleccionar una categoría',
    );

    protected $categories = array(
        '1'  => 'Artroscopia de Hombro',
        '2'  => 'Artroscopia de Codo',
        '3'  => 'Artroscopia de Rodilla',
        '4'  => 'Artroscopia de Tobillo',
        '5'  => 'Corrección quirúrgica',
        '6'  => 'Reparación quirúrgica',
        '7'  => 'Osteosíntesis',
        '8'  => 'Artroplastia de Hombro',
        '9'  => 'Artroplastia de Rodilla',
        '10' => 'Otros',
    );

    public function __construct(Guard $guard)
    {
        $this->auth    = $guard;
        $this->userDir = 'user_' . $this->auth->id() . '/';
    }

    public function getFilesData(Request $request)
    {


        $datatables = Datatables::of(GeneralFileEntry::with(['patient'])->where('user_id', $this->auth->id()));

        $datatables->editColumn('mime', function ($fileEntry) {
            $icon  = 'fa fa-file-o';
            $ftype = 'Documento';
            if (strpos($fileEntry->mime, 'video') !== false) {
                $icon  = 'fa fa-file-movie-o';
                $ftype = 'Video';
            }
            if (strpos($fileEntry->mime, 'audio') !== false) {
                $icon  = 'fa fa-file-audio-o';
                $ftype = 'Audio';
            }
            if (strpos($fileEntry->mime, 'image') !== false) {
                $icon  = 'fa fa-file-image-o';
                $ftype = 'Imagen';
            }

            return '<i title="Imagen" class="' . $icon . '" style="font-size: 20px;"></i> <span style="padding-left: 5px; vertical-align: top;">' . $ftype . '</span>';
        });
        $datatables->editColumn('original_filename', '<a href="' . url('media/file/{{ $filename }}') . '">{{ $original_filename }}</a>');
        $datatables->editColumn('patient_id', function ($fileEntry) {
            if ($fileEntry->patient_id) {
                return '<a href="' . url('patients/view/' . $fileEntry->patient_id) . '">' . $fileEntry->patient['full_name'] . '</a>';
            } else {
                return 'Ninguno';
            }

        });
        $datatables->addColumn('thumbnail', function ($fileEntry) {
            $src = asset('thumbnails/file.png');

            if (strpos($fileEntry->mime, 'image') !== false) {
                $src = asset('thumbnails/' . $fileEntry->filename);
                return '<a href="#" class="dt-view-general-file" data-remodal-target="file-viewer" data-fid="' . $fileEntry->id . '"><img class="img-thumbnail-table" src="' . $src . '"></a>';
            } elseif (strpos($fileEntry->mime, 'video') !== false || strpos($fileEntry->mime, 'audio') !== false) {
                $src = asset('thumbnails/video-play.png');
                return '<a href="#" class="dt-view-general-file" data-remodal-target="file-viewer" data-fid="' . $fileEntry->id . '"><img class="img-thumbnail-table" src="' . $src . '"></a>';
            } elseif (strpos($fileEntry->mime, 'text/plain') !== false ||
                strpos($fileEntry->mime, 'application/pdf') !== false ||
                strpos($fileEntry->filename, 'pdf') !== false) {
                return '<a href="#" class="dt-view-general-file" data-remodal-target="file-viewer" data-fid="' . $fileEntry->id . '"><img class="img-thumbnail-table" src="' . $src . '"></a>';
            } else {
                return '<a href="' . url('media/general/download/' . $fileEntry->filename) . '"><img class="img-thumbnail-table" src="' . $src . '"></a>';
            }

        });
        $datatables->addColumn('action', function ($fileEntry) {
            return
                '<div class="btn-group">
                    <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a data-fid="' . $fileEntry->id . '" data-remodal-target="update-general-file" class="dt-update-general-file" href="#">Editar información archivo</a></li>
                        <li><a data-fid="' . $fileEntry->id . '" data-remodal-target="remove-general-file" class="dt-remove-general-file" href="#">Eliminar archivo</a></li>
                    </ul>
                </div>';
        });

        $datatables->filter(function ($query) use ($request, $datatables) {
            if ($request->has('category') && $request->get('category') != 'Todos') {
                $query->where('file_category', '=', $request->get('category'));
            }

            if ($request->has('patient') && $request->get('patient') != 'Todos') {
                $query->where('patient_id', '=', $request->get('patient'));
            }

            if ($keyword = $request->get('search')['value']) {
                $query->whereRaw("(LOWER(`id`) LIKE '%%$keyword%%' or LOWER(`description`) LIKE '%%$keyword%%' or LOWER(`mime`) LIKE '%%$keyword%%' or LOWER(`created_at`) LIKE '%%$keyword%%')");
            }
        });

        return $datatables->make(true);
    }

    public function postViewFile(Request $request)
    {
        $fid  = $request->get('fid');
        $file = GeneralFileEntry::find($fid);

        return view('doctor.media.view_file', ['file' => $file]);
    }

    public function getFiles()
    {
        $patients = Patient::where('doctor_id', $this->auth->id())->where('customer_id', '<>', 0)->get();

        return view('doctor.media.files', ['patients' => $patients]);
    }

    public function getUploadFile(Request $request)
    {
        $files = array();

        return response()->json(['files' => $files], 200, [], JSON_UNESCAPED_UNICODE);

    }

    public function getUpdateFile($id)
    {
        $file     = GeneralFileEntry::find($id);
        $patients = Patient::where('doctor_id', $this->auth->id())->where('customer_id', '<>', 0)->get();

        return view('doctor.media.ajax-update', ['file' => $file, 'patients' => $patients]);
    }

    public function postUpdateFile(Request $request)
    {
        $formData = $request->all();

        $validation = $this->validateInput($formData, $this->validationRules, $this->validationMessages);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $file = $this->updateFile($formData);

        if ($file) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar archivo'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postUploadFile(Request $request)
    {
        $file     = $request->file('file');
        $formData = $request->all();
        $errors   = array();
        $success  = new stdClass();

        if ($file) {
            foreach ($file as $index => $new_file) {
                $input = array(
                    'description' => $formData['description'][$index],
                    'category'    => $formData['category'][$index],
                );

                $validation = $this->validateInput($input, $this->validationRules, $this->validationMessages);

                if ($validation->fails()) {
                    $errors[$index] = $validation->getMessageBag();
                } else {
                    $userId     = $this->auth->id();
                    $patient_id = $formData['patient'][$index];
                    $desc       = $formData['description'][$index];
                    $cat        = $formData['category'][$index];
                    $upload     = $this->createFile($new_file, $userId, $patient_id, $desc, $cat);

                    if ($upload) {
                        $thumb_url = asset('thumbnails/file.png');
                        if (strpos($upload->mime, 'image') !== false) {
                            $thumb_url = asset('thumbnails/' . $upload->filename);
                        } elseif (strpos($upload->mime, 'video') !== false || strpos($upload->mime, 'audio') !== false) {
                            $thumb_url = asset('thumbnails/video-play.png');
                        }

                        $success->name         = $upload->original_filename;
                        $success->size         = $new_file->getSize();
                        $success->url          = '';
                        $success->thumbnailUrl = $thumb_url;
                        $success->deleteUrl    = '';
                        $success->deleteType   = '';
                        $success->success      = true;
                    }
                }
            }

            if (!empty($errors)) {
                return response()->json(['success' => false, 'error' => $errors], 400, [], JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(['success' => true, 'files' => array($success)], 200, [], JSON_UNESCAPED_UNICODE);
            }
        } else {
            return response()->json(['success' => false, 'error' => 'Error al subir el archivo'], 200, [], JSON_UNESCAPED_UNICODE);
        }

    }

    public function postDeleteFile(Request $request)
    {
        $formData  = $request->all();
        $fileEntry = $this->removeFile($formData);

        if ($fileEntry) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar el archivo'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    protected function validateInput($input, $rules, array $messages)
    {
        return Validator::make($input, $rules, $messages);
    }

    public function getFile($filename)
    {
        $entry = GeneralFileEntry::where('filename', '=', $filename)->firstOrFail();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $donwloadFile = $storagePath . $this->userDir . $entry->filename;

        return response()->download($donwloadFile, $entry->original_filename, ['Content-Type: ' . $entry->mime]);
    }

    protected function createFile($file, $userId, $patient_id, $description, $category)
    {
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($this->userDir . $file->getFilename() . '.' . $extension, File::get($file));

        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $filename     = $file->getFilename() . '.' . $extension;

        $filepath = $storage_path . $this->userDir . $filename;
        File::copy($filepath, public_path() . '/previews/' . $filename);

        if (strpos($file->getClientMimeType(), 'image') !== false) {
            $image = Image::make($filepath)->fit(150, 150, function ($constraint) {
                $constraint->upsize();
            });
            $image->save(public_path() . '/thumbnails/' . $filename);
        }

        $file = GeneralFileEntry::create(array(
            'user_id'           => $userId,
            'patient_id'        => $patient_id,
            'description'       => $description,
            'file_category'     => $this->categories[$category],
            'filename'          => $file->getFilename() . '.' . $extension,
            'mime'              => $file->getClientMimeType(),
            'original_filename' => $file->getClientOriginalName()
        ));

        return $file;
    }

    protected function removeFile($data)
    {
        $fileEntry = GeneralFileEntry::where('id', $data['fid'])->where('user_id', $this->auth->id())->first();

        if ($fileEntry) {
            Storage::disk('local')->delete($this->userDir . $fileEntry->filename);
            File::delete(public_path() . '/thumbnails/' . $fileEntry->filename, public_path() . '/previews/' . $fileEntry->filename);
            $fileEntry->delete();

            return true;
        }

        return false;
    }

    protected function updateFile($data)
    {
        $fileEntry = GeneralFileEntry::where('id', $data['fid'])->where('user_id', $this->auth->id())->first();

        if ($fileEntry) {

            $fileEntry->description   = $data['description'];
            $fileEntry->file_category = $this->categories[$data['category']];
            $fileEntry->patient_id    = $data['patient'];
            $fileEntry->save();

            return true;
        }

        return false;
    }

}
