<?php

namespace App\Console\Commands;

use App\DRDSB\Patient\Appointment;
use App\DRDSB\User\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use DateTime;

class AppointmentsNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify doctors about their next day appointments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tomorrow = date('Y-m-d', strtotime("+1 day"));
        $doctors  = User::select('users.*')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.slug', 'doctor')
            ->whereIn('users.email', ['lpcarranza@toptrauma.com', 'lbarraza@toptrauma.com'])
            ->get();
            
        //Mail::send('errors.503', [], function($message) { $message->to('tulioenriqueboch@gmail.com')->subject('Testing Gmail'); });

        foreach ($doctors as $doctor) {
            $appointments = Appointment::with(['doctor'])
                ->whereDate('start', '=', $tomorrow)
                //->whereDate('start', '=', '2020-02-03')
                ->where('type', '=', 'N')
                ->where('tomorrow_notified', '=', 'N')
                ->where('doctor_id', $doctor->id)
                ->orderBy('start', 'asc')
                ->get();

            if (count($appointments) != 0) {

                foreach ($appointments as $appointment) {
                    $tmp = Appointment::find($appointment->id);
                    
                    if ($tmp) {
                        $tmp->tomorrow_notified = 'Y';
                        $tmp->save();
                    }
                }

                Mail::send('doctor.patient.appointment.emails.notify_tomorrow', ['appointments' => $appointments], function ($message) use ($doctor) {
                    //$message->to('tulioenriqueboch@gmail.com');
                    $message->to($doctor->email);
                    $message->to('lpcsmd@gmail.com');
                    $message->bcc(['clinicasportrauma@gmail.com', 'julio@webs.gt', 'tulioenriqueboch@gmail.com']);
                    $message->subject('Notificación citas para mañana');
                });
            }
        }
    }
}
