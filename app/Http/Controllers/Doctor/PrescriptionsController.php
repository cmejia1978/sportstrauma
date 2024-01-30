<?php

namespace App\Http\Controllers\Doctor;

use App\DRDSB\Medicine\Medicine;
use App\DRDSB\Patient\Appointment;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\HashidsManager;
use App\DRDSB\Patient\Prescription;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use PDF;
use Validator;

class PrescriptionsController extends Controller
{
    protected $auth;
    protected $hashids;

    protected $messages = array(
        'medicine.required'   => 'Debe seleccionar un medicamento'
    );

    protected $validationRules = array(
        'medicine'   => 'required'
    );

    public function __construct(Guard $auth, HashidsManager $hashids)
    {
        $this->auth    = $auth;
        $this->hashids = $hashids;
        $this->hashids->setDefaultConnection('patient_appointment');
    }

    public function getPrescriptionsData($id)
    {
        return Datatables::of(Prescription::with(['medicine'])->where('appointment_id', $id))
            ->editColumn('medicine_id', '{{ $medicine[\'name\'] }}')
            ->addColumn('action', function ($prescription) {
                return
                    '<div class="btn-group">
                        <a href="#" class="dropdown-toggle btn btn-default btn-xs" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a data-psid="' . $prescription->id . '" data-remodal-target="update-prescription" class="dt-update-prescription" href="#">Editar receta</a></li>
                            <li><a data-psid="' . $prescription->id . '" data-remodal-target="remove-prescription" class="dt-remove-prescription" href="#">Eliminar receta</a></li>
                        </ul>
                    </div>';
            })
            ->make(true);
    }

    public function getFrontPrescriptionsData($id)
    {
        $id = $this->hashids->decode($id)[0];
        return Datatables::of(Prescription::with(['medicine'])->where('appointment_id', $id))
            ->editColumn('medicine_id', '{{ $medicine[\'name\'] }}')
            ->make(true);
    }

    public function getPrescriptionInfo($id)
    {
        $prescription = Prescription::find($id);
        $medicines    = Medicine::all();

        return response()->json(['info' => View::make('doctor.patient.prescription.ajax-update', ['prescription' => $prescription, 'medicines' => $medicines])->render(), 'prescription' => $prescription], 200, [], JSON_UNESCAPED_UNICODE);
    }

    protected function validateInput(Request $request, $rules, array $messages)
    {
        return Validator::make($request->all(), $rules, $messages);
    }

    public function postAddPrescription(Request $request)
    {
        $formData = $request->all();

        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $prescription = $this->create($formData);

        if ($prescription) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al agregar receta'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postUpdatePrescription(Request $request)
    {
        $formData = $request->all();

        $validation = $this->validateInput($request, $this->validationRules, $this->messages);

        if ($validation->fails()) {
            return response()->json(['success' => false, 'error' => $validation->getMessageBag()], 200, [], JSON_UNESCAPED_UNICODE);
        }

        $prescription = $this->update($formData);

        if ($prescription) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al actualizar receta'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function postRemovePrescription(Request $request)
    {
        $formData = $request->all();

        $prescription = $this->remove($formData);

        if ($prescription) {
            return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al eliminar receta'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getViewPdf($id)
    {
        $prescriptions   = Prescription::with(['medicine'])->where('appointment_id', $id)->orderBy('created_at')->get();
        $appointment_num = $id;
        $pdf             = PDF::loadView('doctor.patient.prescription.pdf', ['prescriptions' => $prescriptions, 'appointment_num' => $appointment_num]);

        $file_name = 'recetas_cita_no' . $appointment_num . '.pdf';

        return $pdf->setPaper('a4')->stream($file_name);
    }

    public function getPrintPdf($id)
    {
        $prescriptions   = Prescription::with(['medicine'])->where('appointment_id', $id)->orderBy('created_at')->get();
        $appointment_num = $id;
        $pdf             = PDF::loadView('doctor.patient.prescription.pdf_print', ['prescriptions' => $prescriptions, 'appointment_num' => $appointment_num]);

        $file_name = 'recetas_cita_no' . $appointment_num . '.pdf';

        return $pdf->setPaper('a5')->stream($file_name);
    }

    public function getViewPdfPatient($id)
    {
        $prescriptions   = Prescription::with(['medicine'])->where('appointment_id', $id)->orderBy('created_at')->get();
        $appointment_num = $id;
        $pdf             = PDF::loadView('doctor.patient.prescription.pdf', ['prescriptions' => $prescriptions, 'appointment_num' => $appointment_num]);

        $file_name = 'recetas_cita_no' . $appointment_num . '.pdf';

        return $pdf->setPaper('a4')->stream($file_name);
    }

    public function getDownloadPdf($id)
    {
        $prescriptions   = Prescription::with(['medicine'])->where('appointment_id', $id)->orderBy('created_at')->get();
        $appointment_num = $id;
        $pdf             = PDF::loadView('doctor.patient.prescription.pdf', ['prescriptions' => $prescriptions, 'appointment_num' => $appointment_num]);

        $file_name = 'recetas_cita_no' . $appointment_num . '.pdf';

        return $pdf->setPaper('a4')->download($file_name);
    }

    public function getFrontDownloadPdf($id)
    {
        $id = $this->hashids->decode($id)[0];
        $prescriptions   = Prescription::with(['medicine'])->where('appointment_id', $id)->orderBy('created_at')->get();
        $appointment_num = $id;
        $pdf             = PDF::loadView('doctor.patient.prescription.pdf', ['prescriptions' => $prescriptions, 'appointment_num' => $appointment_num]);

        $file_name = 'recetas_cita_no' . $appointment_num . '.pdf';

        return $pdf->setPaper('a4')->download($file_name);
    }

    public function postSendPdf(Request $request)
    {
        $formData = $request->all();

        $aid = $formData['aid'];

        $prescriptions   = Prescription::with(['medicine'])->where('appointment_id', $aid)->orderBy('created_at')->get();
        $pdf             = PDF::loadView('doctor.patient.prescription.pdf', ['prescriptions' => $prescriptions, 'appointment_num' => $aid]);

        $file_name = 'recetas_cita_no' . $aid . '.pdf';

        $appointment     = Appointment::with(['patient'])->find($aid);

        $pdf_attachment = $pdf->setPaper('a4')->stream($file_name);

        Mail::send('doctor.patient.prescription.emails.prescriptions', ['appointment' => $appointment], function ($message) use ($appointment, $pdf_attachment) {
            $message->to($appointment->patient->email);
            //$message->to('tulioenriqueboch@gmail.com');
            $message->subject('Receta para la cita del día ' . $appointment->start_mail);
            $message->attachData($pdf_attachment, 'receta.pdf', ['mime' => 'application/pdf']);
        });

        return response()->json(['success' => true], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getDebugPdf($id)
    {
        /*$pdf = PDF::loadView('doctor.patient.prescription.pdf');
        return $pdf->download('invoice.pdf');*/
        $prescriptions = Prescription::with(['medicine'])->where('appointment_id', $id)->get();

        return view('doctor.patient.prescription.pdf', ['prescriptions' => $prescriptions]);
    }

    protected function remove($data)
    {
        $prescription = Prescription::find($data['psid']);

        if ($prescription) {
            $prescription->delete();

            return true;
        }

        return false;
    }

    protected function update($data)
    {
        $prescription = Prescription::find($data['psid']);

        if ($prescription) {
            $prescription->medicine_id = $data['medicine'];

            $prescription->save();
        }

        return $prescription;
    }

    protected function create($data)
    {
        $prescription = Prescription::create(array(
            'medicine_id'    => $data['medicine'],
            'patient_id'     => $data['pid'],
            'appointment_id' => $data['aid'],
        ));

        return $prescription;
    }

}
