<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Patient\Feedback;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;

class FeedbackController extends Controller
{
    protected $auth;

    protected $messages = array(
        'appointment_id.required' => 'Tratando de hacer trampas?',
        'description.required'    => 'Debe ingresar una descripción para la bitácora'
    );

    protected $validationRules = array(
        'description' => 'required'
    );


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function getFeedbackData($id)
    {
        return Datatables::of(Feedback::where('appointment_id', $id))
            ->addColumn('action', function ($feedback) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-fid="' . $feedback->id . '" data-remodal-target="update-feedback" class="dt-update-feedback" href="#">Editar bitácora</a></li>
                            <li><a data-fid="' . $feedback->id . '" data-remodal-target="remove-feedback" class="dt-remove-feedback" href="#">Eliminar bitácora</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getAppointmentFeedback($id)
    {
        $feedback = Feedback::find($id);

        return view('doctor.patient.feedback.ajax-update', ['feedback' => $feedback]);
    }

    public function postAddFeedback(Request $request)
    {
        //$this->validationRules['patient_id'] = 'required';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $feedback = $this->create($formData);

        if ($feedback) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al agregar a la bitácora'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postUpdateFeedback(Request $request)
    {
        //$this->validationRules['patient_id'] = '';

        $formData   = $request->all();
        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $feedback = $this->update($formData);

        if ($feedback) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar la bitácora'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postRemoveFeedback(Request $request)
    {
        $formData = $request->all();
        $feedback = $this->remove($formData);

        if ($feedback) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar de la bitácora'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function remove($data)
    {
        $feedback = Feedback::find($data['fid']);

        if ($feedback) {
            $feedback->delete();

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
        $feedback = Feedback::find($data['fid']);

        if ($feedback) {
            $feedback->description = $data['description'];

            $feedback->save();
        }

        return $feedback;
    }

    protected function create($data)
    {
        $feedback = Feedback::create(array(
            'appointment_id' => $data['aid'],
            'description'    => $data['description'],
        ));

        return $feedback;
    }

}
