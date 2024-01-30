<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\File\FileEntry;
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

class FilesController extends Controller
{

    protected $auth;
    protected $userDir;

    public function __construct(Guard $guard)
    {
        $this->auth    = $guard;
        $this->userDir = 'user_' . $this->auth->id() . '/';
    }

    public function getFilesData()
    {
        return Datatables::of(FileEntry::where('user_id', '=', $this->auth->id())->where('appointment_id', 0))
            ->editColumn('mime', function ($fileEntry) {
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
            })
            ->editColumn('original_filename', '<a href="' . url('media/file/{{ $filename }}') . '">{{ $original_filename }}</a>')
            ->addColumn('action', function ($fileEntry) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-fid="' . $fileEntry->id . '" data-remodal-target="remove-file" class="dt-remove-file" href="#">Eliminar archivo</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }


    public function getAppointmentFilesData($id)
    {
        return Datatables::of(FileEntry::where('user_id', $this->auth->id())->where('appointment_id', $id))
            ->editColumn('mime', function ($fileEntry) {
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
            })
            ->editColumn('original_filename', '<a href="' . url('media/file/{{ $filename }}') . '">{{ $original_filename }}</a>')
            ->addColumn('action', function ($fileEntry) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-fid="' . $fileEntry->id . '" data-remodal-target="remove-file" class="dt-remove-file" href="#">Eliminar archivo</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getFileView($fileId, $width = 100, $height = 100)
    {
        $fileEntry   = FileEntry::where('id', '=', $fileId)->firstOrFail();
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        if (strpos($fileEntry->mime, 'image') !== false) {
            $filePath = $storagePath . $this->userDir . $fileEntry->filename;
            $image    = Image::make($filePath)->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            });
        } elseif (strpos($fileEntry->mime, 'video') !== false) {
            $filePath = $storagePath . 'video_default.png';
            $image    = Image::make($filePath)->resize($width, $height);
        } else {
            $filePath = $storagePath . 'document_default.png';
            $image    = Image::make($filePath)->resize($width, $height);
        }


        return $image->response();
    }

    public function getFiles()
    {
        return view('doctor.media.files');
    }


    public function postUpload(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $userId = $this->auth->id();
            $this->createFile($file, $userId);

            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al subir el archivo'], 200, [], JSON_UNESCAPED_UNICODE);
        }

    }

    public function postAppointmentUploadFile(Request $request)
    {
        $file     = $request->file('file');
        $formData = $request->all();
        if ($file) {
            $userId        = $this->auth->id();
            $appointmentId = $formData['aid'];
            $this->createAppointmentFile($file, $userId, $appointmentId);

            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al subir el archivo'], 200, [], JSON_UNESCAPED_UNICODE);
        }

    }

    public function postAppointmentDeleteFile(Request $request)
    {
        $formData  = $request->all();
        $fileEntry = $this->removeAppointmentFile($formData);

        if ($fileEntry) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar el archivo'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postDelete(Request $request)
    {
        $formData  = $request->all();
        $fileEntry = $this->removeFile($formData);

        if ($fileEntry) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar el archivo'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getFile($filename)
    {
        $entry = FileEntry::where('filename', '=', $filename)->firstOrFail();

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $donwloadFile = $storagePath . $this->userDir . $entry->filename;

        return response()->download($donwloadFile, $entry->original_filename, ['Content-Type: ' . $entry->mime]);
    }

    protected function createAppointmentFile($file, $userId, $appointmentId)
    {
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($this->userDir . $file->getFilename() . '.' . $extension, File::get($file));

        FileEntry::create(array(
            'user_id'           => $userId,
            'appointment_id'    => $appointmentId,
            'filename'          => $file->getFilename() . '.' . $extension,
            'mime'              => $file->getClientMimeType(),
            'original_filename' => $file->getClientOriginalName()
        ));
    }

    protected function removeAppointmentFile($data)
    {
        $fileEntry = FileEntry::where('id', $data['fid'])->where('user_id', $this->auth->id())->where('appointment_id', $data['aid'])->first();

        if ($fileEntry) {
            Storage::disk('local')->delete($this->userDir . $fileEntry->filename);
            $fileEntry->delete();

            return true;
        }

        return false;
    }

    protected function createFile($file, $userId)
    {
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($this->userDir . $file->getFilename() . '.' . $extension, File::get($file));

        FileEntry::create(array(
            'user_id'           => $userId,
            'filename'          => $file->getFilename() . '.' . $extension,
            'mime'              => $file->getClientMimeType(),
            'original_filename' => $file->getClientOriginalName()
        ));
    }

    protected function removeFile($data)
    {
        $fileEntry = FileEntry::find($data['fid']);

        if ($fileEntry) {
            Storage::disk('local')->delete($this->userDir . $fileEntry->filename);
            $fileEntry->delete();

            return true;
        }

        return false;
    }

    public function getCalendar()
    {
        return view('doctor.calendar.calendar');
    }

}
