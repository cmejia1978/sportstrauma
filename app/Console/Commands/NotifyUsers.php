<?php

namespace App\Console\Commands;

use App\DRDSB\Patient\Appointment;
use App\DRDSB\User\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use DateTime;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users 30 minutes and 2 Hours before an appointment';

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
        $appointments = Appointment::with(['patient'])
            ->where('start', '>=', DB::raw('DATE_ADD(NOW(), INTERVAL 1439 MINUTE)'))
            ->where('start', '<=', DB::raw('DATE_ADD(NOW(), INTERVAL 1440 MINUTE)'))
	        ->where('type', '=', 'N')
            ->where('first_notified', '=' , 'N')
            ->get();

        foreach ($appointments as $appointment) {
            $tmp = Appointment::find($appointment->id);
            $tmp->first_notified = 'Y';
            $tmp->save();

            Mail::send('doctor.patient.appointment.emails.notify_next', ['appointment' => $appointment, 'apt_time' => ' 24 horas ' ], function ($message) use ($appointment) {
                $message->to($appointment->patient['email']);
                $message->subject('Notificación para próxima cita');
            });
        }

        $appointments = Appointment::with(['patient'])
            ->where('start', '>=', DB::raw('DATE_ADD(NOW(), INTERVAL 119 MINUTE)'))
            ->where('start', '<=', DB::raw('DATE_ADD(NOW(), INTERVAL 120 MINUTE)'))
	        ->where('type', '=', 'N')
            ->where('second_notified', '=' , 'N')
            ->get();

        foreach ($appointments as $appointment) {
            $tmp = Appointment::find($appointment->id);
            $tmp->second_notified = 'Y';
            $tmp->save();

            Mail::send('doctor.patient.appointment.emails.notify_next', ['appointment' => $appointment, 'apt_time' => ' 2 horas ' ], function ($message) use ($appointment) {
                $message->to($appointment->patient['email']);
                $message->subject('Notificación para próxima cita');
            });
        }
    }
}
