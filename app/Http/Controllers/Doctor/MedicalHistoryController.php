<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\MedicalHistory;
use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use App\DRDSB\Patient\Patient;
use Bican\Roles\Models\Role;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;

class MedicalHistoryController extends Controller
{
    protected $auth;

    protected $messages = array(
        'patient_id.required'  => 'Tratando de hacer trampas?',
        'description.required' => 'Debe ingresar una descripción para el historial'
    );

    protected $validationRules = array(
        'description' => 'required'
    );


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function getMedicalHistoryData($id)
    {
        return Datatables::of(MedicalHistory::where('patient_id', '=', $id))
            ->editColumn('description', function ($history) {
                return '<a data-hid="' . $history->id . '" data-remodal-target="update-med-history" class="dt-update-history" href="#">' . str_limit($history->description, 25) . '</a>';
            })
            ->addColumn('action', function ($history) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-hid="' . $history->id . '" data-remodal-target="update-med-history" class="dt-update-history" href="#">Editar historial</a></li>
                            <li><a data-hid="' . $history->id . '" data-remodal-target="remove-med-history" class="dt-remove-history" href="#">Eliminar historial</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getPatientMedicalHistory($id)
    {
        $history = MedicalHistory::find($id);

        return view('doctor.patient.history.ajax-update', ['history' => $history]);
    }

    public function postAddHistory(Request $request)
    {
        $this->validationRules['patient_id'] = 'required';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $history = $this->create($formData);

        if ($history) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al agregar al historial'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postUpdateHistory(Request $request)
    {
        $this->validationRules['patient_id'] = '';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $history = $this->update($formData);

        if ($history) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar el historial'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postRemoveHistory(Request $request)
    {
        $formData = $request->all();
        $history = $this->remove($formData);

        if ($history) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar del historial'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function remove($data)
    {
        $history = MedicalHistory::find($data['hid']);

        if ($history) {
            $history->delete();

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
        $history = MedicalHistory::find($data['hid']);

        if ($history) {
            $history->description = $data['description'];

            $history->save();
        }

        return $history;
    }

    protected function create($data)
    {
        $history = MedicalHistory::create(array(
            'patient_id'  => $data['patient_id'],
            'description' => $data['description'],
        ));

        return $history;
    }

}
