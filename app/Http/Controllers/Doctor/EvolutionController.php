<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Evolution;
use App\Http\Controllers\Controller;
use App\DRDSB\User\User;
use App\DRDSB\Patient\Patient;
use Bican\Roles\Models\Role;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;

class EvolutionController extends Controller
{
    protected $auth;

    protected $messages = array(
        'patient_id.required'  => 'Tratando de hacer trampas?',
        'description.required' => 'Debe ingresar una descripción'
    );

    protected $validationRules = array(
        'description' => 'required'
    );


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function getEvolutionData($id)
    {
        return Datatables::of(Evolution::where('patient_id', '=', $id))
            ->editColumn('description', function ($evolution) {
                return '<a data-eid="' . $evolution->id . '" data-remodal-target="update-patient-evolution" class="dt-update-evolution" href="#">' . str_limit($evolution->description, 25) . '</a>';
            })
            ->addColumn('action', function ($evolution) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-eid="' . $evolution->id . '" data-remodal-target="update-patient-evolution" class="dt-update-evolution" href="#">Editar evolución</a></li>
                            <li><a data-eid="' . $evolution->id . '" data-remodal-target="remove-patient-evolution" class="dt-remove-evolution" href="#">Eliminar evolución</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getPatientEvolution($id)
    {
        $evolution = Evolution::find($id);

        return view('doctor.patient.evolution.ajax-update', ['evolution' => $evolution]);
    }

    public function postAddEvolution(Request $request)
    {
        $this->validationRules['patient_id'] = 'required';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $evolution = $this->create($formData);

        if ($evolution) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al agregar al historial'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postUpdateEvolution(Request $request)
    {
        $this->validationRules['patient_id'] = '';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $evolution = $this->update($formData);

        if ($evolution) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar el historial'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postRemoveEvolution(Request $request)
    {
        $formData = $request->all();
        $evolution = $this->remove($formData);

        if ($evolution) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar del historial'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function remove($data)
    {
        $evolution = Evolution::find($data['eid']);

        if ($evolution) {
            $evolution->delete();

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
        $evolution = Evolution::find($data['eid']);

        if ($evolution) {
            $evolution->description = $data['description'];

            $evolution->save();
        }

        return $evolution;
    }

    protected function create($data)
    {
        $evolution = Evolution::create(array(
            'patient_id'  => $data['patient_id'],
            'description' => $data['description'],
        ));

        return $evolution;
    }

}
