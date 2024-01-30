<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Notes;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Vinkla\Hashids\HashidsManager;
use Yajra\Datatables\Datatables;
use Validator;

class NotesController extends Controller
{
    protected $auth;
    protected $hashids;

    protected $messages = array(
        'appointment_id.required' => 'Tratando de hacer trampas?',
        'description.required'    => 'Debe ingresar una descripción para la bitácora'
    );

    protected $validationRules = array(
        'description' => 'required'
    );


    public function __construct(Guard $auth, HashidsManager $hasids)
    {
        $this->auth = $auth;
        $this->hashids = $hasids;
        $this->hashids->setDefaultConnection('patient_appointment');

    }

    public function getNotesData($id)
    {
        return Datatables::of(Notes::where('appointment_id', $id))
            ->addColumn('action', function ($note) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-nid="' . $note->id . '" data-remodal-target="update-note" class="dt-update-note" href="#">Editar nota</a></li>
                            <li><a data-nid="' . $note->id . '" data-remodal-target="remove-note" class="dt-remove-note" href="#">Eliminar nota</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getFrontNotesData($id)
    {
        $id = $this->hashids->decode($id)[0];
        return Datatables::of(Notes::where('appointment_id', $id))
            ->make(true);
    }

    public function getAppointmentNotes($id)
    {
        $note = Notes::find($id);

        return view('doctor.patient.note.ajax-update', ['note' => $note]);
    }

    public function postAddNotes(Request $request)
    {
        //$this->validationRules['patient_id'] = 'required';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $note = $this->create($formData);

        if ($note) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al agregar nota'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postUpdateNotes(Request $request)
    {
        //$this->validationRules['patient_id'] = '';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $note = $this->update($formData);

        if ($note) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar nota'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postRemoveNotes(Request $request)
    {
        $formData = $request->all();
        $note = $this->remove($formData);

        if ($note) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar nota'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function remove($data)
    {
        $note = Notes::find($data['nid']);

        if ($note) {
            $note->delete();

            return true;
        }

        return false;
    }

    protected function validateInput(Request $request, $rules, array $messages)
    {
        return Validator::make($request->all(), $rules, $messages);
    }

    protected function update($data)
    {
        $note = Notes::find($data['nid']);

        if ($note) {
            $note->description = $data['description'];

            $note->save();
        }

        return $note;
    }

    protected function create($data)
    {
        $note = Notes::create(array(
            'appointment_id' => $data['aid'],
            'description'    => $data['description'],
        ));

        return $note;
    }

}
