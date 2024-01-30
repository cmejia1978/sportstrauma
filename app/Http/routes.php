<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('register-patient', 'Doctor\PatientsRegisterFrontEndController@getAddPatient');
Route::post('register-patient', 'Doctor\PatientsRegisterFrontEndController@postAddPatient');

Route::get('thank-you', function() {
    return view('doctor.patient.thank_you');
});

/*Route::get('/clear', function() {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    return redirect()->back();
});*/

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin'], function () {
        //Admin - users
        Route::get('users', 'Admin\UsersController@getUsers');
        Route::get('users-data', 'Admin\UsersController@getUsersData');
        Route::get('users/add', 'Admin\UsersController@getAddUser');
        Route::get('users/update/{id?}', 'Admin\UsersController@getUpdateUser');
        Route::get('users/remove/{id?}', 'Admin\UsersController@getRemoveUser');
        Route::post('users/add', 'Admin\UsersController@postAddUser');
        Route::post('users/update/{id?}', 'Admin\UsersController@postUpdateUser');
        Route::post('users/remove/{id?}', 'Admin\UsersController@postRemoveUser');
    });

    Route::group(['middleware' => 'role:admin|doctor'], function () {
        // Doctor profile
        Route::get('profile/edit', 'Doctor\DoctorProfileController@getUpdateProfile');
        Route::post('profile/edit', 'Doctor\DoctorProfileController@postUpdateProfile');
        Route::post('profile/upload', 'Doctor\DoctorProfileController@postUpload');
        Route::post('profile/crop', 'Doctor\DoctorProfileController@postCrop');

        // Evolution
        Route::get('evolution/{id?}', 'Doctor\EvolutionController@getPatientEvolution');
        Route::post('evolution-data/{id?}', 'Doctor\EvolutionController@getEvolutionData');
        Route::post('evolution/add', 'Doctor\EvolutionController@postAddEvolution');
        Route::post('evolution/update/{id?}', 'Doctor\EvolutionController@postUpdateEvolution');
        Route::post('evolution/remove', 'Doctor\EvolutionController@postRemoveEvolution');

        // Patients
        Route::get('patients/info/{id?}', 'Doctor\PatientsController@getPatientInfo');
        Route::get('patients', 'Doctor\PatientsController@getPatients');
        Route::get('patients/add', 'Doctor\PatientsController@getAddPatient');
        Route::get('patients/update/{id?}', 'Doctor\PatientsController@getUpdatePatient');
        Route::get('patients/remove/{id?}', 'Doctor\PatientsController@getRemovePatient');
        Route::get('patients/view/{id?}', 'Doctor\PatientsController@getViewPatient');
        Route::post('patients-data', 'Doctor\PatientsController@getPatientsData');
        Route::post('patients/activate', 'Doctor\PatientsController@postPatientActivate');
        Route::post('patients/associate', 'Doctor\PatientsController@postAssociatePatient');
        Route::post('patients/add', 'Doctor\PatientsController@postAddPatient');
        Route::post('patients/update/', 'Doctor\PatientsController@postUpdatePatient');
        Route::post('patients/remove/', 'Doctor\PatientsController@postRemovePatient');

        // Pma Patient
        Route::get('pma-patients/info/{id?}', 'Doctor\PmaPatientsController@getPatientInfo');
        Route::post('pma-patients-data', 'Doctor\PmaPatientsController@getPatientsData');
        Route::post('pma-patients/activate', 'Doctor\PmaPatientsController@postPatientActivate');
        Route::post('pma-patients/add', 'Doctor\PmaPatientsController@postAddPatient');
        Route::post('pma-patients/update/', 'Doctor\PmaPatientsController@postUpdatePatient');
        Route::post('pma-patients/remove/', 'Doctor\PmaPatientsController@postRemovePatient');

        // History
        Route::get('history/{id?}', 'Doctor\MedicalHistoryController@getPatientMedicalHistory');
        Route::post('history-data/{id?}', 'Doctor\MedicalHistoryController@getMedicalHistoryData');
        Route::post('history/add', 'Doctor\MedicalHistoryController@postAddHistory');
        Route::post('history/update/{id?}', 'Doctor\MedicalHistoryController@postUpdateHistory');
        Route::post('history/remove', 'Doctor\MedicalHistoryController@postRemoveHistory');

        // Calendar
        Route::get('calendar', 'Doctor\CalendarController@getCalendar');

        // Appointments
        Route::get('appointments/view/{id?}', 'Doctor\AppointmentsController@getViewAppointment');
        Route::get('appointments/{id?}', 'Doctor\AppointmentsController@getAppointments');
        Route::post('appointments/notify', 'Doctor\AppointmentsController@postNotify');
        Route::post('appointments/add', 'Doctor\AppointmentsController@postAddAppointment');
        Route::post('appointments/update', 'Doctor\AppointmentsController@postUpdateAppointment');
        Route::post('appointments/remove', 'Doctor\AppointmentsController@postRemoveAppointment');

        // Prescriptions
        Route::get('prescriptions/info/{id?}', 'Doctor\PrescriptionsController@getPrescriptionInfo');
        Route::get('prescriptions/pdf/view/{id?}', 'Doctor\PrescriptionsController@getViewPdf');
        Route::get('prescriptions/pdf/print/{id?}', 'Doctor\PrescriptionsController@getPrintPdf');
        Route::get('prescriptions/pdf/download/{id?}', 'Doctor\PrescriptionsController@getDownloadPdf');
        Route::get('prescriptions/debug-pdf/{id?}', 'Doctor\PrescriptionsController@getDebugPdf');
        Route::post('prescriptions/pdf/send', 'Doctor\PrescriptionsController@postSendPdf');
        Route::post('prescriptions-data/{id?}', 'Doctor\PrescriptionsController@getPrescriptionsData');
        Route::post('prescriptions/add', 'Doctor\PrescriptionsController@postAddPrescription');
        Route::post('prescriptions/update', 'Doctor\PrescriptionsController@postUpdatePrescription');
        Route::post('prescriptions/remove', 'Doctor\PrescriptionsController@postRemovePrescription');

        // Feedback
        Route::get('feedback/{id?}', 'Doctor\FeedbackController@getAppointmentFeedback');
        Route::post('feedback-data/{id?}', 'Doctor\FeedbackController@getFeedbackData');
        Route::post('feedback/add', 'Doctor\FeedbackController@postAddFeedback');
        Route::post('feedback/update/{id?}', 'Doctor\FeedbackController@postUpdateFeedback');
        Route::post('feedback/remove', 'Doctor\FeedbackController@postRemoveFeedback');

        // Notes
        Route::get('notes/{id?}', 'Doctor\NotesController@getAppointmentNotes');
        Route::post('notes-data/{id?}', 'Doctor\NotesController@getNotesData');
        Route::post('notes/add', 'Doctor\NotesController@postAddNotes');
        Route::post('notes/update/{id?}', 'Doctor\NotesController@postUpdateNotes');
        Route::post('notes/remove', 'Doctor\NotesController@postRemoveNotes');

        // media general
        //Route::get('media', 'Doctor\FilesController@getFiles');
        Route::post('media-data', 'Doctor\FilesController@getFilesData');
        Route::post('media/upload', 'Doctor\FilesController@postUpload');
        Route::post('media/delete', 'Doctor\FilesController@postDelete');
        Route::get('media/file-render/{id?}/{width?}/{height?}', 'Doctor\FilesController@getFileView');
        Route::get('media/file/{filename?}', 'Doctor\FilesController@getFile');
        // media - patient general
        Route::get('media', 'Doctor\GeneralFilesController@getFiles');
        Route::get('media/general/upload', 'Doctor\GeneralFilesController@getUploadFile');
        Route::get('media/general/{id?}', 'Doctor\GeneralFilesController@getUpdateFile');
        Route::get('media/general/download/{filename?}', 'Doctor\GeneralFilesController@getFile');
        Route::post('media-general-data', 'Doctor\GeneralFilesController@getFilesData');
        Route::post('media/general/update', 'Doctor\GeneralFilesController@postUpdateFile');
        Route::post('media/general/upload', 'Doctor\GeneralFilesController@postUploadFile');
        Route::post('media/general/delete', 'Doctor\GeneralFilesController@postDeleteFile');
        Route::post('media/general/view', 'Doctor\GeneralFilesController@postViewFile');
        // media - appointment
        /*Route::post('media-appointment-data/{id?}', 'Doctor\FilesController@getAppointmentFilesData');
        Route::post('media/appointment/upload', 'Doctor\FilesController@postAppointmentUploadFile');
        Route::post('media/appointment/delete', 'Doctor\FilesController@postAppointmentDeleteFile');*/
        Route::get('media/appointment/upload', 'Doctor\AppointmentFilesController@getUploadFile');
        Route::get('media/appointment/{id?}', 'Doctor\AppointmentFilesController@getUpdateFile');
        Route::get('media/appointment/download/{filename?}', 'Doctor\AppointmentFilesController@getFile');
        Route::post('media-appointment-data', 'Doctor\AppointmentFilesController@getFilesData');
        Route::post('media/appointment/update', 'Doctor\AppointmentFilesController@postUpdateFile');
        Route::post('media/appointment/upload', 'Doctor\AppointmentFilesController@postUploadFile');
        Route::post('media/appointment/delete', 'Doctor\AppointmentFilesController@postDeleteFile');
        Route::post('media/appointment/view', 'Doctor\AppointmentFilesController@postViewFile');
        // media - patient surgery
        Route::get('media/surgery/upload', 'Doctor\SurgeriesFilesController@getUploadFile');
        Route::get('media/surgery/{id?}', 'Doctor\SurgeriesFilesController@getUpdateFile');
        Route::get('media/surgery/download/{filename?}', 'Doctor\SurgeriesFilesController@getFile');
        Route::post('media-surgery-data', 'Doctor\SurgeriesFilesController@getFilesData');
        Route::post('media/surgery/update', 'Doctor\SurgeriesFilesController@postUpdateFile');
        Route::post('media/surgery/upload', 'Doctor\SurgeriesFilesController@postUploadFile');
        Route::post('media/surgery/delete', 'Doctor\SurgeriesFilesController@postDeleteFile');
        Route::post('media/surgery/view', 'Doctor\SurgeriesFilesController@postViewFile');
        // media - patient oprecord
        Route::get('media/oprecord/upload', 'Doctor\OPRecordFilesController@getUploadFile');
        Route::get('media/oprecord/{id?}', 'Doctor\OPRecordFilesController@getUpdateFile');
        Route::get('media/oprecord/download/{filename?}', 'Doctor\OPRecordFilesController@getFile');
        Route::post('media-oprecord-data', 'Doctor\OPRecordFilesController@getFilesData');
        Route::post('media/oprecord/update', 'Doctor\OPRecordFilesController@postUpdateFile');
        Route::post('media/oprecord/upload', 'Doctor\OPRecordFilesController@postUploadFile');
        Route::post('media/oprecord/delete', 'Doctor\OPRecordFilesController@postDeleteFile');
        Route::post('media/oprecord/view', 'Doctor\OPRecordFilesController@postViewFile');
        // media - patient lab
        Route::get('media/lab/upload', 'Doctor\LabFilesController@getUploadFile');
        Route::get('media/lab/{id?}', 'Doctor\LabFilesController@getUpdateFile');
        Route::get('media/lab/download/{filename?}', 'Doctor\LabFilesController@getFile');
        Route::post('media-lab-data', 'Doctor\LabFilesController@getFilesData');
        Route::post('media/lab/update', 'Doctor\LabFilesController@postUpdateFile');
        Route::post('media/lab/upload', 'Doctor\LabFilesController@postUploadFile');
        Route::post('media/lab/delete', 'Doctor\LabFilesController@postDeleteFile');
        Route::post('media/lab/view', 'Doctor\LabFilesController@postViewFile');
        // media - patient report
        Route::get('media/report/upload', 'Doctor\ReportsFilesController@getUploadFile');
        Route::get('media/report/{id?}', 'Doctor\ReportsFilesController@getUpdateFile');
        Route::get('media/report/download/{filename?}', 'Doctor\ReportsFilesController@getFile');
        Route::post('media-report-data', 'Doctor\ReportsFilesController@getFilesData');
        Route::post('media/report/update', 'Doctor\ReportsFilesController@postUpdateFile');
        Route::post('media/report/upload', 'Doctor\ReportsFilesController@postUploadFile');
        Route::post('media/report/delete', 'Doctor\ReportsFilesController@postDeleteFile');
        Route::post('media/report/view', 'Doctor\ReportsFilesController@postViewFile');


        // Medicines
        Route::get('medicines/info/{id?}', 'Admin\MedicinesController@getMedicineInfo');
        Route::get('medicines', 'Admin\MedicinesController@getMedicines');
        Route::post('medicines-data', 'Admin\MedicinesController@getMedicinesData');
        Route::get('medicines/add', 'Admin\MedicinesController@getAddMedicine');
        Route::get('medicines/update/{id?}', 'Admin\MedicinesController@getUpdateMedicine');
        Route::get('medicines/remove/{id?}', 'Admin\MedicinesController@getRemoveMedicine');
        Route::post('medicines/add', 'Admin\MedicinesController@postAddMedicine');
        Route::post('medicines/update/{id?}', 'Admin\MedicinesController@postUpdateMedicine');
        Route::post('medicines/remove/{id?}', 'Admin\MedicinesController@postRemoveMedicine');

        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    });

    Route::group(['middleware' => 'role:patient', 'prefix' => 'patient'], function () {
        Route::get('appointment/{id?}', 'Doctor\AppointmentsController@getViewFrontAppointment');
        Route::get('prescriptions/pdf/download/{id?}', 'Doctor\PrescriptionsController@getFrontDownloadPdf');
        Route::get('profile', 'Doctor\PatientsFrontEndController@getFrontProfile');
        Route::get('select-doctor', 'Doctor\PatientsFrontEndController@getSelectDoctor');
        Route::post('select-doctor', 'Doctor\PatientsFrontEndController@postSelectDoctor');
        Route::get('profile-info', 'Doctor\PatientsFrontEndController@getFrontPatientInfo');
        Route::get('profile-gen-info-tab', 'Doctor\PatientsFrontEndController@getGeneralInfoTab');
        Route::get('profile/update', 'Doctor\PatientsFrontEndController@getUpdateFrontProfile');

        Route::post('prescriptions-data/{id?}', 'Doctor\PrescriptionsController@getFrontPrescriptionsData');
        Route::post('notes-data/{id?}', 'Doctor\NotesController@getFrontNotesData');
        Route::post('appointments-data', 'Doctor\AppointmentsController@postPatientAppointmentsData');
        Route::post('appointment/request', 'Doctor\AppointmentsController@postPatientAppointmentsRequest');
        Route::post('profile/update', 'Doctor\PatientsFrontEndController@postUpdateFrontProfile');

        Route::post('profile/upload', 'Doctor\PatientsFrontEndController@postUpload');
        Route::post('profile/crop', 'Doctor\PatientsFrontEndController@postCrop');
    });



    Route::get('/', 'HomeController@index');

});


