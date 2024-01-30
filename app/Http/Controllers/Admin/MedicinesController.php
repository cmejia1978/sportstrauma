<?php

namespace App\Http\Controllers\Admin;

use App\DRDSB\Medicine\Medicine;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Validator;

class MedicinesController extends Controller
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    protected $messages = array(
        'name.required'     => 'Debe ingresar un medicamento',
    );

    public function getMedicinesData() {
        return Datatables::of(Medicine::where('doctor_id', $this->auth->id()))
            ->addColumn('action', function ($medicine) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-mid="' . $medicine->id . '" data-remodal-target="update-medicine" class="dt-update-medicine" href="#">Editar medicamento</a></li>
                            <li><a data-mid="' . $medicine->id . '" data-remodal-target="remove-medicine" class="dt-remove-medicine" href="#">Eliminar medicamento</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getMedicines()
    {
        return view('admin.medicine.medicines');
    }

    public function getMedicineInfo($id)
    {
        $medicine = Medicine::find($id);

        return view('admin.medicine.ajax-update', ['medicine' => $medicine]);
    }

    public function getAddMedicine()
    {
        return view('admin.medicine.new');
    }

    public function postAddMedicine(Request $request)
    {
        $formData = $request->all();

        $validation = $this->validateInput($request, [
            'name'     => 'required',
        ], $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $medicine = $this->create($formData);

        if ($medicine) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al agregar el medicamento'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getUpdateMedicine($id)
    {
        $medicine = Medicine::get()->find($id);

        return view('admin.medicine.update', ['medicine' => $medicine]);
    }

    public function postUpdateMedicine(Request $request)
    {
        $formData = $request->all();

        $validation = $this->validateInput($request, [
            'name'     => 'required',
        ], $this->messages);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $medicine = $this->update($formData);

        if ($medicine) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al editar el medicamento'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getRemoveMedicine($id)
    {
        $medicine = Medicine::find($id);

        return view('admin.medicine.remove', ['medicine' => $medicine]);
    }

    public function postRemoveMedicine(Request $request)
    {
        $formData = $request->all();
        $medicine = $this->remove($formData);

        if ($medicine) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar medicamento'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    protected function validateInput(Request $request, $rules, array $messages)
    {
        return Validator::make($request->all(), $rules, $messages);
    }

    protected function remove($data)
    {
        $medicine = Medicine::find($data['mid']);

        if ($medicine) {
            $medicine->delete();

            return true;
        }

        return false;
    }

    protected function update($data)
    {
        $medicine = Medicine::find($data['mid']);

        if ($medicine) {
            $medicine->name = $data['name'];
            $medicine->save();
        }

        return $medicine;
    }

    protected function create($data)
    {
        $medicine = Medicine::create(array(
            'doctor_id' => $this->auth->id(),
            'name' => $data['name']
        ));

        return $medicine;
    }

}
