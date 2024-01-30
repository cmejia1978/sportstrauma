<?php

namespace App\Http\Controllers;

use App\DRDSB\File\FileEntry;
use App\DRDSB\Medicine\Medicine;
use App\DRDSB\Patient\Appointment;
use App\DRDSB\Patient\Patient;
use App\DRDSB\User\User;
use App\Http\Requests;
use DateTime;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $auth;

    public function __construct(Guard $guard)
    {
        $this->auth = $guard;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user         = User::with(['patient'])->where('id', $this->auth->id())->firstOrFail();
        $sel_doctor   = $request->session()->get('selected_doctor', '0');
        $params       = array();
        $patients     = Patient::where('doctor_id', $this->auth->id())->get();
        $files        = FileEntry::where('user_id', $this->auth->id())->where('appointment_id', 0)->get();
        $appointments = Appointment::where('doctor_id', $this->auth->id())->get();
        $medicines    = Medicine::where('doctor_id', $this->auth->id())->get();

        $currentDateTime       = date('Y-m-d H:i:s');
        $currentDate           = date('Y-m-d');
        $appointmentsToday = Appointment::with(['patient'])->where('doctor_id', $this->auth->id())->whereDate('start', '=', $currentDate)->orderBy('start', 'asc')->get();
        $appointmentsNext  = Appointment::with(['patient'])->where('doctor_id', $this->auth->id())->whereDate('start', '>', $currentDate)->orderBy('start', 'asc')->get();
        $nextAppointment    = Appointment::with(['patient'])->where('doctor_id', $this->auth->id())->where('start', '>=', $currentDateTime)->orderBy('start', 'asc')->first();

        $params['todaysAppointments'] = $appointmentsToday;
        $params['nextAppointments'] = $appointmentsNext;
        $params['nextAppointment'] = $nextAppointment;



        $params['patients'] = $patients;
        $params['files'] = $files;
        $params['appointments'] = $appointments;
        $params['medicines'] = $medicines;


        // patient
        /*
         * $currentDateTime    = date('Y-m-d H:i:s');
            $patient            = Patient::with(['doctor', 'diseases', 'medicines'])->where('customer_id', $this->auth->id())->first();
            $nexUserAppointment = Appointment::with(['doctor'])->where('patient_id', $patient->id)->where('start', '>=', $currentDateTime)->orderBy('start', 'asc')->first();
         */

        if ($user->is('patient') && $user->patient['associated'] == 'Y') {

            if ($sel_doctor == '2' || $sel_doctor == '3') {
                return redirect('patient/profile', 302);
            } else {
                return redirect('patient/select-doctor', 302);
            }

        } elseif ($user->is('patient') && $user->patient['associated'] == 'N') {
            return redirect('patient/profile', 302);
        }

        /*$nex30Min = new DateTime;
        $nex30Min->modify('+30 minutes');

        $nextDate              = $nex30Min->format('Y-m-d H:i:s');*/
        /*if ($user->is('patient')) {
            $currentDateTime       = date('Y-m-d H:i:s');
            $currentDate           = date('Y-m-d');
            $userPatient           = Patient::where('customer_id', $this->auth->id())->first();
            $userAppointmentsToday = Appointment::with(['doctor'])->where('patient_id', $userPatient->id)->whereDate('start', '=', $currentDate)->orderBy('start', 'asc')->get();
            $userAppointmentsNext  = Appointment::with(['doctor'])->where('patient_id', $userPatient->id)->whereDate('start', '>', $currentDate)->orderBy('start', 'asc')->get();
            $nexUserAppointment    = Appointment::with(['doctor'])->where('patient_id', $userPatient->id)->where('start', '>=', $currentDateTime)->orderBy('start', 'asc')->first();


            $params['todaysUserAppointments'] = $userAppointmentsToday;
            $params['nextUserAppointments'] = $userAppointmentsNext;
            $params['nexUserAppointment'] = $nexUserAppointment;
        }*/

        //$nexUserAppointment    = Appointment::with(['doctor'])->where('patient_id', $userPatient->id)->whereDate('start', '>=', $nextDate)->first();

        return view('welcome', $params);
    }
}
