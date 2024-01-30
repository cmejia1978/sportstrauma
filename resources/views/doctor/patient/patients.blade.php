@extends('layouts.app')


@section('title', 'Pacientes')

@push('styles')
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fullcalendar/fullcalendarv2.css') }}" rel="stylesheet">
<link href="<?php echo e(asset('assets/js/toastr/toastr.css')); ?>" rel="stylesheet">
@endpush

@section('content-classes', 'scrollable')

@section('content')
    <section class="panel panel-default">
        <header class="panel-heading bg-light clearfix">
            <span class="m-t-xs inline">Pacientes</span> - <span id="patients-status">Activos</span>
        </header>
        <table id="patients-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Correo</th>
                <th>Cirugía</th>
                <th>Estado Civil</th>
                <th>Fecha Nacimiento</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Dirección</th>
                <th>Teléfono casa</th>
                <th>Teléfono celular</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th class="all">Acción</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>
    <div class="remodal-bg"></div>
    @include('doctor.patient.new', ['diseases' => $diseases])
    @include('doctor.patient.update')
    @include('doctor.patient.remove')

@endsection

@push('scripts')
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script src="{{ asset('assets/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar/fullcalendarv2.min.js') }}"></script>
<script src="<?php echo e(asset('assets/js/toastr/toastr.min.js')); ?>"></script>
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        toastr.options = {
            showDuration: '300',
            hideDuration: '100',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
            newestOnTop: true,
            positionClass: 'toast-top-right'
        };

        var patientsTable,
            $SOT               = $('#input-other-provider'),
            $R_SOT             = $('input[type=radio][data-add=seen-other-provider]'),
            $R_SOT_VAL         = $('input[type=radio][data-add=seen-other-provider]:checked').val(),
            $XR_DATE           = $('#input-x-ray-date'),
            $R_XR              = $('input[type=radio][data-add=x-rays]'),
            $R_XR_VAL          = $('input[type=radio][data-add=x-rays]:checked').val(),
            addPatientModal    = $('[data-remodal-id=add-patient]').remodal(),
            addPatientForm     = $('#add-patient-form'),
            updatePatientModal = $('[data-remodal-id=update-patient]').remodal(),
            updatePatientForm  = $('#update-patient-form'),
            removePatientModal = $('[data-remodal-id=remove-patient]').remodal(),
            removePatientForm  = $('#remove-patient-form'),
            patientStatus      = 'active',
            loader             = $('.dt-loader');

        $(document).on('click', '.dt-assoc-patient', function(e) {
            e.preventDefault();

            var pid = $(this).data('pid');

            $.ajax({
                url: '{{ url('patients/associate') }}',
                method: 'POST',
                data: { pid: pid },
                success: function(res) {
                    if (res.success) {
                        patientsTable.draw();
                        toastr.success('La cuenta del paciente <strong>' + res.patient_full_name + '</strong> ha sido asociada al otro doctor');
                    }
                }
            })
        });

        $(document).on('click', '.dt-activate-patient', function(e) {
            e.preventDefault();

            var pid = $(this).data('pid');


            $.ajax({
                url: '{{ url('patients/activate') }}',
                method: 'POST',
                data: { pid: pid },
                success: function(res) {
                    if (res.success) {
                        patientsTable.draw();
                        toastr.success('La cuenta del paciente <strong>' + res.patient_full_name + '</strong> ha sido activada');
                    }
                }
            })
        });


        $(document).on('click', '.dt-remove-patient', function(e) {
            var pid = $(this).data('pid');
            $('#remove-pid').val(pid);
        });

        removePatientForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('patients/remove') !!}',
                method: 'POST',
                data: removePatientForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        patientsTable.ajax.reload();
                        removePatientForm[0].reset();
                        removePatientModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        updatePatientForm.on('submit', function(e) {
            e.preventDefault();

            $('#update-patient-form .message-full-name').hide();
            $('#update-patient-form .message-email').hide();
            $('#update-patient-form .message-religion').hide();
            $('#update-patient-form .message-birth-date').hide();
            $('#update-patient-form .message-birth-location').hide();
            $('#update-patient-form .message-address').hide();
            $('#update-patient-form .message-pref-phone-num').hide();
            $('#update-patient-form .message-alt-phone-num').hide();
            $('#update-patient-form .message-occupation').hide();
            $('#update-patient-form .message-employer').hide();
            $('#update-patient-form .message-other-provider').hide();
            $('#update-patient-form .message-other-provider-country').hide();
            $('#update-patient-form .message-x-rays').hide();
            $('#update-patient-form .message-x-ray-date').hide();
            $('#update-patient-form .message-operated_info').hide();
            $('#update-patient-form .message-medical-inquiry-reason').hide();
            $('#update-patient-form .message-medical-problem-time').hide();
            $('#update-patient-form .message-medical-problem-coup-info').hide();
            $('#update-patient-form .message-sport-practice-info').hide();
            $('#update-patient-form .message-exercise-info').hide();
            $('#update-patient-form .message-alcohol-usage').hide();
            $('#update-patient-form .message-smokes-per-day').hide();
            $('#update-patient-form .message-smokes-years').hide();
            $('#update-patient-form .message-allergies-cause').hide();
            $('#update-patient-form .message-allergies-reaction').hide();
            $('#update-patient-form .message-medicine-1-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-1-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-2-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-2-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-3-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-3-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-4-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-4-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-5-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-5-dose-frequency').removeClass('has-error');

            $('#update-patient-form .full-name-group').removeClass('has-error');
            $('#update-patient-form .email-group').removeClass('has-error');
            $('#update-patient-form .religion-group').removeClass('has-error');
            $('#update-patient-form .birth-date-group').removeClass('has-error');
            $('#update-patient-form .birth-location-group').removeClass('has-error');
            $('#update-patient-form .address-group').removeClass('has-error');
            $('#update-patient-form .pref-phone-num-group').removeClass('has-error');
            $('#update-patient-form .alt-phone-num-group').removeClass('has-error');
            $('#update-patient-form .occupation-group').removeClass('has-error');
            $('#update-patient-form .employer-group').removeClass('has-error');
            $('#update-patient-form .other-provider-country-group').removeClass('has-error');
            $('#update-patient-form .x-ray-date-group').removeClass('has-error');
            $('#update-patient-form .operated-info-group').removeClass('has-error');
            $('#update-patient-form .medical-inquiry-reason-group').removeClass('has-error');
            $('#update-patient-form .medical-problem-time-group').removeClass('has-error');
            $('#update-patient-form .medical-problem-coup-info-group').removeClass('has-error');
            $('#update-patient-form .sport-practice-info-group').removeClass('has-error');
            $('#update-patient-form .exercise-info-group').removeClass('has-error');
            $('#update-patient-form .alcohol-usage-group').removeClass('has-error');
            $('#update-patient-form .smokes-per-day-group').removeClass('has-error');
            $('#update-patient-form .smokes-year-group').removeClass('has-error');
            $('#update-patient-form .allergies-cause-group').removeClass('has-error');
            $('#update-patient-form .allergies-reaction-group').removeClass('has-error');
            $('#update-patient-form .medicine-1-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-1-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-2-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-2-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-3-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-3-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-4-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-4-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-5-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-5-dose-frequency-group').removeClass('has-error');

            loader.show();

            $.ajax({
                url: '{!! url('patients/update') !!}',
                method: 'POST',
                data: updatePatientForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        patientsTable.ajax.reload();
                        updatePatientForm[0].reset();
                        updatePatientModal.close();
                    } else {

                        if (res.error.full_name) {
                            $('#update-patient-form .full-name-group').addClass('has-error');
                            $('#update-patient-form .message-full-name').html(res.error.full_name).fadeIn();
                        }
                        
                        if (res.error.medical_insurance) {
                            $('#update-patient-form .medical-insurance-group').addClass('has-error');
                            $('#update-patient-form .message-medical-insurance').html(res.error.medical_insurance).fadeIn();
                        }
                        
                        if (res.error.medical_insurance_name) {
                            $('#update-patient-form .medical-insurance-name-group').addClass('has-error');
                            $('#update-patient-form .message-medical-insurance-name').html(res.error.medical_insurance_name).fadeIn();
                        }

                        if (res.error.religion) {
                            $('#update-patient-form .religion-group').addClass('has-error');
                            $('#update-patient-form .message-religion').html(res.error.religion).fadeIn();
                        }

                        if (res.error.email) {
                            $('#update-patient-form .email-group').addClass('has-error');
                            $('#update-patient-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.birth_date) {
                            $('#update-patient-form .birth-date-group').addClass('has-error');
                            $('#update-patient-form .message-birth-date').html(res.error.birth_date).fadeIn();
                        }

                        if (res.error.birth_location) {
                            $('#update-patient-form .birth-location-group').addClass('has-error');
                            $('#update-patient-form .message-birth-location').html(res.error.birth_location).fadeIn();
                        }

                        if (res.error.address) {
                            $('#update-patient-form .address-group').addClass('has-error');
                            $('#update-patient-form .message-address').html(res.error.address).fadeIn();
                        }

                        if (res.error.pref_phone_num) {
                            $('#update-patient-form .pref-phone-num-group').addClass('has-error');
                            $('#update-patient-form .message-pref-phone-num').html(res.error.pref_phone_num).fadeIn();
                        }

                        if (res.error.alt_phone_num) {
                            $('#update-patient-form .alt-phone-num-group').addClass('has-error');
                            $('#update-patient-form .message-alt-phone-num').html(res.error.alt_phone_num).fadeIn();
                        }

                        if (res.error.occupation) {
                            $('#update-patient-form .occupation-group').addClass('has-error');
                            $('#update-patient-form .message-occupation').html(res.error.occupation).fadeIn();
                        }
                        
                        if (res.error.alcohol_usage) {
                            $('#update-patient-form .alcohol-usage-group').addClass('has-error');
                            $('#update-patient-form .message-alcohol-usage').html(res.error.alcohol_usage).fadeIn();
                        }

                        if (res.error.other_provider_country) {
                            $('#update-patient-form .other-provider-country-group').addClass('has-error');
                            $('#update-patient-form .message-other-provider-country').html(res.error.other_provider_country).fadeIn();
                        }

                        if (res.error.x_ray_date) {
                            $('#update-patient-form .x-ray-date-group').addClass('has-error');
                            $('#update-patient-form .message-x-ray-date').html(res.error.x_ray_date).fadeIn();
                        }

                        if (res.error.operated_info) {
                            $('#update-patient-form .operated-info-group').addClass('has-error');
                            $('#update-patient-form .message-operated-info').html(res.error.operated_info).fadeIn();
                        }

                        if (res.error.medical_inquiry_reason) {
                            $('#update-patient-form .medical-inquiry-reason-group').addClass('has-error');
                            $('#update-patient-form .message-medical-inquiry-reason').html(res.error.medical_inquiry_reason).fadeIn();
                        }

                        if (res.error.employer) {
                            $('#update-patient-form .employer-group').addClass('has-error');
                            $('#update-patient-form .message-employer').html(res.error.employer).fadeIn();
                        }

                        if (res.error.medical_problem_time) {
                            $('#update-patient-form .medical-problem-time-group').addClass('has-error');
                            $('#update-patient-form .message-medical-problem-time').html(res.error.medical_problem_time).fadeIn();
                        }

                        if (res.error.medical_problem_coup_info) {
                            $('#update-patient-form .medical-problem-coup-info-group').addClass('has-error');
                            $('#update-patient-form .message-medical-problem-coup-info').html(res.error.medical_problem_coup_info).fadeIn();
                        }

                        if (res.error.sport_practice_info) {
                            $('#update-patient-form .sport-practice-info-group').addClass('has-error');
                            $('#update-patient-form .message-sport-practice-info').html(res.error.sport_practice_info).fadeIn();
                        }

                        if (res.error.smokes_per_day) {
                            $('#update-patient-form .smokes-per-day-group').addClass('has-error');
                            $('#update-patient-form .message-smokes-per-day').html(res.error.smokes_per_day).fadeIn();
                        }

                        if (res.error.smokes_years) {
                            $('#update-patient-form .smokes-year-group').addClass('has-error');
                            $('#update-patient-form .message-smokes-years').html(res.error.smokes_years).fadeIn();
                        }

                        if (res.error['medicine.1.name']) {
                            $('#update-patient-form .medicine-1-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-1-name').html(res.error['medicine.1.name']).fadeIn();
                        }

                        if (res.error['medicine.1.dose_frequency']) {
                            $('#update-patient-form .medicine-1-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-1-dose-frequency').html(res.error['medicine.1.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.2.name']) {
                            $('#update-patient-form .medicine-2-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-2-name').html(res.error['medicine.2.name']).fadeIn();
                        }

                        if (res.error['medicine.2.dose_frequency']) {
                            $('#update-patient-form .medicine-2-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-2-dose-frequency').html(res.error['medicine.2.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.3.name']) {
                            $('#update-patient-form .medicine-3-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-3-name').html(res.error['medicine.3.name']).fadeIn();
                        }

                        if (res.error['medicine.3.dose_frequency']) {
                            $('#update-patient-form .medicine-3-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-3-dose-frequency').html(res.error['medicine.3.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.4.name']) {
                            $('#update-patient-form .medicine-4-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-4-name').html(res.error['medicine.4.name']).fadeIn();
                        }

                        if (res.error['medicine.4.dose_frequency']) {
                            $('#update-patient-form .medicine-4-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-4-dose-frequency').html(res.error['medicine.4.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.5.name']) {
                            $('#update-patient-form .medicine-5-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-5-name').html(res.error['medicine.5.name']).fadeIn();
                        }

                        if (res.error['medicine.5.dose_frequency']) {
                            $('#update-patient-form .medicine-5-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-5-dose-frequency').html(res.error['medicine.5.dose_frequency']).fadeIn();
                        }

                        if (res.error.allergies_cause) {
                            $('#update-patient-form .allergies-cause-group').addClass('has-error');
                            $('#update-patient-form .message-allergies-cause').html(res.error.allergies_cause).fadeIn();
                        }

                        if (res.error.allergies_reaction) {
                            $('#update-patient-form .allergies-reaction-group').addClass('has-error');
                            $('#update-patient-form .message-allergies-reaction').html(res.error.allergies_reaction).fadeIn();
                        }

                    }

                    loader.fadeOut();
                }
            });
        });
        
        $(document).on('click', '.dt-update-patient', function(e) {
            var pid = $(this).data('pid');
            updatePatientForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('patients/info') !!}/' + pid,
                method: 'GET',
                success: function(res) {
                    updatePatientForm.html(res.info);
                    $('.radio-custom > input[type=radio]').each(function () {var $this = $(this);if ($this.data('radio')) return; $this.radio($this.data());});
                    $('.checkbox-custom > input[type=checkbox]').each(function () {var $this = $(this);if ($this.data('checkbox')) return;$this.checkbox($this.data());});

                    var $_SOT        = $('#input-update-other-provider'),
                        $_R_SOT      = $('input[type=radio][data-update=seen-other-provider]'),
                        $_R_SOT_VAL  = $('input[type=radio][data-update=seen-other-provider]:checked').val(),
                        $_XR_DATE    = $('#input-update-x-ray-date'),
                        $_R_XR       = $('input[type=radio][data-update=x-rays]'),
                        $_R_XR_VAL   = $('input[type=radio][data-update=x-rays]:checked').val(),
                        $_BIRTH_DATE = $('#input-update-birth-date');

                    $_BIRTH_DATE.daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: true,
                        locale: spanishCL,
                        startDate: res.patient.birth_date,
                        minDate: '01/01/1920',
                        maxDate: moment().format('12/01/YYYY')
                    });

                    $_XR_DATE.daterangepicker({
                        singleDatePicker: true,
                        locale: spanishCL,
                        drops: 'up',
                        showDropdowns: true,
                        minDate: '01/01/1920',
                        maxDate: moment().format('DD/MM/YYYY'),
                        startDate: res.patient.x_ray_date == '0000-00-00' ? '01/01/2015' : res.patient.x_ray_date
                    });

                    /*if ($_R_XR_VAL == 'Y') {
                        $_XR_DATE.daterangepicker({
                            singleDatePicker: true,
                            locale: spanishCL,
                            drops: 'up'
                            //startDate: res.patient.x_ray_date
                        });
                    } else {
                        $_XR_DATE.data('daterangepicker').container.remove();
                    }*/


                    changeInputState($_R_SOT_VAL, $_SOT, 'N/A', true);
                    changeInputState($_R_XR_VAL, $_XR_DATE, '00/00/0000', true);

                    $_R_SOT.change(function () {
                        changeInputState(this.value, $_SOT, 'N/A', true);
                    });

                    $_R_XR.change(function () {
                        changeInputState(this.value, $_XR_DATE, '00/00/0000', true);
                    });

                    function changeInputState(value, el, inval, disen) {
                        if (value == 'Y') {
                            if (disen) {
                                el.prop('disabled', false);
                            }

                            if (res.patient.x_ray_date != '0000-00-00' && inval == '00/00/0000') {
                                el.val(res.patient.x_ray_date);
                            } else if (inval == '00/00/0000') {
                                el.val(moment().format('DD/MM/YYYY'));
                            } else if (res.patient.other_provider != 'N/A' && inval == 'N/A') {
                                el.val(res.patient.other_provider);
                            } else {
                                el.val('');
                            }

                        } else {
                            if (disen) {
                                el.prop('disabled', true);
                            }
                            el.val(inval);
                        }
                    }

                    loader.fadeOut();
                }
            })
        });

        addPatientForm.on('submit', function(e) {
            e.preventDefault();

            $('#add-patient-form .message-full-name').hide();
            $('#add-patient-form .message-surgery-name').hide();
            $('#add-patient-form .message-medical-insurance').hide();
            $('#add-patient-form .message-medical-insurance-name').hide();
            $('#add-patient-form .message-email').hide();
            $('#add-patient-form .message-religion').hide();
            $('#add-patient-form .message-birth-date').hide();
            $('#add-patient-form .message-birth-location').hide();
            $('#add-patient-form .message-address').hide();
            $('#add-patient-form .message-pref-phone-num').hide();
            $('#add-patient-form .message-alt-phone-num').hide();
            $('#add-patient-form .message-occupation').hide();
            $('#add-patient-form .message-employer').hide();
            $('#add-patient-form .message-other-provider').hide();
            $('#add-patient-form .message-other-provider-country').hide();
            $('#add-patient-form .message-x-rays').hide();
            $('#add-patient-form .message-x-ray-date').hide();
            $('#add-patient-form .message-operated_info').hide();
            $('#add-patient-form .message-medical-inquiry-reason').hide();
            $('#add-patient-form .message-medical-problem-time').hide();
            $('#add-patient-form .message-medical-problem-coup-info').hide();
            $('#add-patient-form .message-sport-practice-info').hide();
            $('#add-patient-form .message-exercise-info').hide();
            $('#add-patient-form .message-alcohol-usage').hide();
            $('#add-patient-form .message-smokes-per-day').hide();
            $('#add-patient-form .message-smokes-years').hide();
            $('#add-patient-form .message-allergies-cause').hide();
            $('#add-patient-form .message-allergies-reaction').hide();
            $('#add-patient-form .message-medicine-1-name').removeClass('has-error');
            $('#add-patient-form .message-medicine-1-dose-frequency').removeClass('has-error');
            $('#add-patient-form .message-medicine-2-name').removeClass('has-error');
            $('#add-patient-form .message-medicine-2-dose-frequency').removeClass('has-error');
            $('#add-patient-form .message-medicine-3-name').removeClass('has-error');
            $('#add-patient-form .message-medicine-3-dose-frequency').removeClass('has-error');
            $('#add-patient-form .message-medicine-4-name').removeClass('has-error');
            $('#add-patient-form .message-medicine-4-dose-frequency').removeClass('has-error');
            $('#add-patient-form .message-medicine-5-name').removeClass('has-error');
            $('#add-patient-form .message-medicine-5-dose-frequency').removeClass('has-error');

            $('#add-patient-form .full-name-group').removeClass('has-error');
            $('#add-patient-form .surgery-name-group').removeClass('has-error');
            $('#add-patient-form .medical-insurance-group').removeClass('has-error');
            $('#add-patient-form .medical-insurance-name-group').removeClass('has-error');
            $('#add-patient-form .email-group').removeClass('has-error');
            $('#add-patient-form .religion-group').removeClass('has-error');
            $('#add-patient-form .birth-date-group').removeClass('has-error');
            $('#add-patient-form .birth-location-group').removeClass('has-error');
            $('#add-patient-form .address-group').removeClass('has-error');
            $('#add-patient-form .pref-phone-num-group').removeClass('has-error');
            $('#add-patient-form .alt-phone-num-group').removeClass('has-error');
            $('#add-patient-form .occupation-group').removeClass('has-error');
            $('#add-patient-form .employer-group').removeClass('has-error');
            $('#add-patient-form .other-provider-country-group').removeClass('has-error');
            $('#add-patient-form .x-ray-date-group').removeClass('has-error');
            $('#add-patient-form .operated-info-group').removeClass('has-error');
            $('#add-patient-form .medical-inquiry-reason-group').removeClass('has-error');
            $('#add-patient-form .medical-problem-time-group').removeClass('has-error');
            $('#add-patient-form .medical-problem-coup-info-group').removeClass('has-error');
            $('#add-patient-form .sport-practice-info-group').removeClass('has-error');
            $('#add-patient-form .exercise-info-group').removeClass('has-error');
            $('#add-patient-form .alcohol-usage-group').removeClass('has-error');
            $('#add-patient-form .smokes-per-day-group').removeClass('has-error');
            $('#add-patient-form .smokes-year-group').removeClass('has-error');
            $('#add-patient-form .allergies-cause-group').removeClass('has-error');
            $('#add-patient-form .allergies-reaction-group').removeClass('has-error');
            $('#add-patient-form .medicine-1-name-group').removeClass('has-error');
            $('#add-patient-form .medicine-1-dose-frequency-group').removeClass('has-error');
            $('#add-patient-form .medicine-2-name-group').removeClass('has-error');
            $('#add-patient-form .medicine-2-dose-frequency-group').removeClass('has-error');
            $('#add-patient-form .medicine-3-name-group').removeClass('has-error');
            $('#add-patient-form .medicine-3-dose-frequency-group').removeClass('has-error');
            $('#add-patient-form .medicine-4-name-group').removeClass('has-error');
            $('#add-patient-form .medicine-4-dose-frequency-group').removeClass('has-error');
            $('#add-patient-form .medicine-5-name-group').removeClass('has-error');
            $('#add-patient-form .medicine-5-dose-frequency-group').removeClass('has-error');

            loader.show();

            $.ajax({
                url: '{!! url('patients/add') !!}',
                method: 'POST',
                data: addPatientForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        patientsTable.order( [ 0, 'desc' ] ).draw();
                        patientsTable.ajax.reload();
                        addPatientForm[0].reset();
                        addPatientModal.close();
                    } else {

                        if (res.error.full_name) {
                            $('#add-patient-form .full-name-group').addClass('has-error');
                            $('#add-patient-form .message-full-name').html(res.error.full_name).fadeIn();
                        }
                        
                        if (res.error.medical_insurance) {
                            $('#add-patient-form .medical-insurance-group').addClass('has-error');
                            $('#add-patient-form .message-medical-insurance').html(res.error.medical_insurance).fadeIn();
                        }
                        
                        if (res.error.medical_insurance_name) {
                            $('#add-patient-form .medical-insurance-name-group').addClass('has-error');
                            $('#add-patient-form .message-medical-insurance-name').html(res.error.medical_insurance_name).fadeIn();
                        }

                        if (res.error.religion) {
                            $('#add-patient-form .religion-group').addClass('has-error');
                            $('#add-patient-form .message-religion').html(res.error.religion).fadeIn();
                        }

                        if (res.error.email) {
                            $('#add-patient-form .email-group').addClass('has-error');
                            $('#add-patient-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.birth_date) {
                            $('#add-patient-form .birth-date-group').addClass('has-error');
                            $('#add-patient-form .message-birth-date').html(res.error.birth_date).fadeIn();
                        }

                        if (res.error.birth_location) {
                            $('#add-patient-form .birth-location-group').addClass('has-error');
                            $('#add-patient-form .message-birth-location').html(res.error.birth_location).fadeIn();
                        }

                        if (res.error.address) {
                            $('#add-patient-form .address-group').addClass('has-error');
                            $('#add-patient-form .message-address').html(res.error.address).fadeIn();
                        }

                        if (res.error.pref_phone_num) {
                            $('#add-patient-form .pref-phone-num-group').addClass('has-error');
                            $('#add-patient-form .message-pref-phone-num').html(res.error.pref_phone_num).fadeIn();
                        }

                        if (res.error.alt_phone_num) {
                            $('#add-patient-form .alt-phone-num-group').addClass('has-error');
                            $('#add-patient-form .message-alt-phone-num').html(res.error.alt_phone_num).fadeIn();
                        }

                        if (res.error.occupation) {
                            $('#add-patient-form .occupation-group').addClass('has-error');
                            $('#add-patient-form .message-occupation').html(res.error.occupation).fadeIn();
                        }

                        if (res.error.other_provider_country) {
                            $('#add-patient-form .other-provider-country-group').addClass('has-error');
                            $('#add-patient-form .message-other-provider-country').html(res.error.other_provider_country).fadeIn();
                        }

                        if (res.error.x_ray_date) {
                            $('#add-patient-form .x-ray-date-group').addClass('has-error');
                            $('#add-patient-form .message-x-ray-date').html(res.error.x_ray_date).fadeIn();
                        }

                        if (res.error.operated_info) {
                            $('#add-patient-form .operated-info-group').addClass('has-error');
                            $('#add-patient-form .message-operated-info').html(res.error.operated_info).fadeIn();
                        }

                        if (res.error.medical_inquiry_reason) {
                            $('#add-patient-form .medical-inquiry-reason-group').addClass('has-error');
                            $('#add-patient-form .message-medical-inquiry-reason').html(res.error.medical_inquiry_reason).fadeIn();
                        }

                        if (res.error.employer) {
                            $('#add-patient-form .employer-group').addClass('has-error');
                            $('#add-patient-form .message-employer').html(res.error.employer).fadeIn();
                        }

                        if (res.error.medical_problem_time) {
                            $('#add-patient-form .medical-problem-time-group').addClass('has-error');
                            $('#add-patient-form .message-medical-problem-time').html(res.error.medical_problem_time).fadeIn();
                        }

                        if (res.error.medical_problem_coup_info) {
                            $('#add-patient-form .medical-problem-coup-info-group').addClass('has-error');
                            $('#add-patient-form .message-medical-problem-coup-info').html(res.error.medical_problem_coup_info).fadeIn();
                        }
                        
                        if (res.error.alcohol_usage) {
                            $('#add-patient-form .alcohol-usage-group').addClass('has-error');
                            $('#add-patient-form .message-alcohol-usage').html(res.error.alcohol_usage).fadeIn();
                        }

                        if (res.error.sport_practice_info) {
                            $('#add-patient-form .sport-practice-info-group').addClass('has-error');
                            $('#add-patient-form .message-sport-practice-info').html(res.error.sport_practice_info).fadeIn();
                        }

                        if (res.error.smokes_per_day) {
                            $('#add-patient-form .smokes-per-day-group').addClass('has-error');
                            $('#add-patient-form .message-smokes-per-day').html(res.error.smokes_per_day).fadeIn();
                        }

                        if (res.error.smokes_years) {
                            $('#add-patient-form .smokes-year-group').addClass('has-error');
                            $('#add-patient-form .message-smokes-years').html(res.error.smokes_years).fadeIn();
                        }

                        if (res.error['medicine.1.name']) {
                            $('#add-patient-form .medicine-1-name-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-1-name').html(res.error['medicine.1.name']).fadeIn();
                        }

                        if (res.error['medicine.1.dose_frequency']) {
                            $('#add-patient-form .medicine-1-dose-frequency-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-1-dose-frequency').html(res.error['medicine.1.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.2.name']) {
                            $('#add-patient-form .medicine-2-name-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-2-name').html(res.error['medicine.2.name']).fadeIn();
                        }

                        if (res.error['medicine.2.dose_frequency']) {
                            $('#add-patient-form .medicine-2-dose-frequency-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-2-dose-frequency').html(res.error['medicine.2.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.3.name']) {
                            $('#add-patient-form .medicine-3-name-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-3-name').html(res.error['medicine.3.name']).fadeIn();
                        }

                        if (res.error['medicine.3.dose_frequency']) {
                            $('#add-patient-form .medicine-3-dose-frequency-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-3-dose-frequency').html(res.error['medicine.3.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.4.name']) {
                            $('#add-patient-form .medicine-4-name-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-4-name').html(res.error['medicine.4.name']).fadeIn();
                        }

                        if (res.error['medicine.4.dose_frequency']) {
                            $('#add-patient-form .medicine-4-dose-frequency-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-4-dose-frequency').html(res.error['medicine.4.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.5.name']) {
                            $('#add-patient-form .medicine-5-name-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-5-name').html(res.error['medicine.5.name']).fadeIn();
                        }

                        if (res.error['medicine.5.dose_frequency']) {
                            $('#add-patient-form .medicine-5-dose-frequency-group').addClass('has-error');
                            $('#add-patient-form .message-medicine-5-dose-frequency').html(res.error['medicine.5.dose_frequency']).fadeIn();
                        }

                        if (res.error.allergies_cause) {
                            $('#add-patient-form .allergies-cause-group').addClass('has-error');
                            $('#add-patient-form .message-allergies-cause').html(res.error.allergies_cause).fadeIn();
                        }

                        if (res.error.allergies_reaction) {
                            $('#add-patient-form .allergies-reaction-group').addClass('has-error');
                            $('#add-patient-form .message-allergies-reaction').html(res.error.allergies_reaction).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });

        $(document).on('closing', '.remodal', function (e) {
            if (addPatientModal.getState() == 'closing') {
                addPatientForm[0].reset();
                $('#add-patient-form .message-full-name').hide();
                $('#add-patient-form .message-surgery-name').hide();
                $('#add-patient-form .message-medical-insurance').hide();
                $('#add-patient-form .message-medical-insurance-name').hide();
                $('#add-patient-form .message-first-name').hide();
                $('#add-patient-form .message-middle-name').hide();
                $('#add-patient-form .message-last-name').hide();
                $('#add-patient-form .message-email').hide();
                $('#add-patient-form .message-social-sec-num').hide();
                $('#add-patient-form .message-birth-date').hide();
                $('#add-patient-form .message-age').hide();
                $('#add-patient-form .message-mailing-address').hide();
                $('#add-patient-form .message-city').hide();
                $('#add-patient-form .message-state').hide();
                $('#add-patient-form .message-zip').hide();
                $('#add-patient-form .message-pref-phone-num').hide();
                $('#add-patient-form .message-alt-phone-num').hide();
                $('#add-patient-form .message-occupation').hide();
                $('#add-patient-form .message-employer').hide();
                $('#add-patient-form .message-employment-status').hide();
                $('#add-patient-form .message-spouse-partner').hide();
                $('#add-patient-form .message-spouse-partner-phone-num').hide();
                $('#add-patient-form .message-seen-other-provider').hide();
                $('#add-patient-form .message-other-provider').hide();
                $('#add-patient-form .message-x-rays').hide();
                $('#add-patient-form .message-x-ray-date').hide();

                $('#add-patient-form .full-name-group').removeClass('has-error');
                $('#add-patient-form .surgery-name-group').removeClass('has-error');
                $('#add-patient-form .medical-insurance-group').removeClass('has-error');
                $('#add-patient-form .medical-insurance-name-group').removeClass('has-error');
                $('#add-patient-form .first-name-group').removeClass('has-error');
                $('#add-patient-form .middle-name-group').removeClass('has-error');
                $('#add-patient-form .last-name-group').removeClass('has-error');
                $('#add-patient-form .email-group').removeClass('has-error');
                $('#add-patient-form .social-sec-num-group').removeClass('has-error');
                $('#add-patient-form .birth-date-group').removeClass('has-error');
                $('#add-patient-form .age-group').removeClass('has-error');
                $('#add-patient-form .mailing-address-group').removeClass('has-error');
                $('#add-patient-form .city-group').removeClass('has-error');
                $('#add-patient-form .state-group').removeClass('has-error');
                $('#add-patient-form .zip-group').removeClass('has-error');
                $('#add-patient-form .pref-phone-num-group').removeClass('has-error');
                $('#add-patient-form .alt-phone-num-group').removeClass('has-error');
                $('#add-patient-form .occupation-group').removeClass('has-error');
                $('#add-patient-form .employer-group').removeClass('has-error');
                $('#add-patient-form .employer-phone-num-group').removeClass('has-error');
                $('#add-patient-form .spouse-partner-phone-num-group').removeClass('has-error');
                $('#add-patient-form .other-provider-group').removeClass('has-error');
                $('#add-patient-form .x-ray-date-group').removeClass('has-error');
            }

            if (updatePatientModal.getState() == 'closing') {
                updatePatientForm[0].reset();
                $('#update-patient-form .message-full-name').hide();
                $('#update-patient-form .message-surgery-name').hide();
                $('#update-patient-form .message-medical-insurance').hide();
                $('#update-patient-form .message-medical-insurance-name').hide();
                $('#update-patient-form .message-first-name').hide();
                $('#update-patient-form .message-middle-name').hide();
                $('#update-patient-form .message-last-name').hide();
                $('#update-patient-form .message-email').hide();
                $('#update-patient-form .message-social-sec-num').hide();
                $('#update-patient-form .message-birth-date').hide();
                $('#update-patient-form .message-age').hide();
                $('#update-patient-form .message-mailing-address').hide();
                $('#update-patient-form .message-city').hide();
                $('#update-patient-form .message-state').hide();
                $('#update-patient-form .message-zip').hide();
                $('#update-patient-form .message-pref-phone-num').hide();
                $('#update-patient-form .message-alt-phone-num').hide();
                $('#update-patient-form .message-occupation').hide();
                $('#update-patient-form .message-employer').hide();
                $('#update-patient-form .message-employment-status').hide();
                $('#update-patient-form .message-spouse-partner').hide();
                $('#update-patient-form .message-spouse-partner-phone-num').hide();
                $('#update-patient-form .message-seen-other-provider').hide();
                $('#update-patient-form .message-other-provider').hide();
                $('#update-patient-form .message-x-rays').hide();
                $('#update-patient-form .message-x-ray-date').hide();

                $('#update-patient-form .full-name-group').removeClass('has-error');
                $('#update-patient-form .surgery-name-group').removeClass('has-error');
                $('#update-patient-form .medical-insurance-group').removeClass('has-error');
                $('#update-patient-form .medical-insurance-name-group').removeClass('has-error');
                $('#update-patient-form .first-name-group').removeClass('has-error');
                $('#update-patient-form .middle-name-group').removeClass('has-error');
                $('#update-patient-form .last-name-group').removeClass('has-error');
                $('#update-patient-form .email-group').removeClass('has-error');
                $('#update-patient-form .social-sec-num-group').removeClass('has-error');
                $('#update-patient-form .birth-date-group').removeClass('has-error');
                $('#update-patient-form .age-group').removeClass('has-error');
                $('#update-patient-form .mailing-address-group').removeClass('has-error');
                $('#update-patient-form .city-group').removeClass('has-error');
                $('#update-patient-form .state-group').removeClass('has-error');
                $('#update-patient-form .zip-group').removeClass('has-error');
                $('#update-patient-form .pref-phone-num-group').removeClass('has-error');
                $('#update-patient-form .alt-phone-num-group').removeClass('has-error');
                $('#update-patient-form .occupation-group').removeClass('has-error');
                $('#update-patient-form .employer-group').removeClass('has-error');
                $('#update-patient-form .employer-phone-num-group').removeClass('has-error');
                $('#update-patient-form .spouse-partner-phone-num-group').removeClass('has-error');
                $('#update-patient-form .other-provider-group').removeClass('has-error');
                $('#update-patient-form .x-ray-date-group').removeClass('has-error');
            }

            loader.hide();
        });

        $('#input-birth-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: spanishCL,
            startDate: '01/01/2015',
            minDate: '01/01/1920',
            maxDate: moment().format('12/01/YYYY')
        });

        $XR_DATE .daterangepicker({
            singleDatePicker: true,
            locale: spanishCL,
            drops: "up",
            startDate: '01/01/2015',
            showDropdowns: true,
            minDate: '01/01/1920',
            maxDate: moment().format('DD/MM/YYYY')
        });

        /*if ($R_XR_VAL == 'Y') {
            $XR_DATE .daterangepicker({
                singleDatePicker: true,
                locale: spanishCL,
                drops: "up"
            });
        } else {
            $XR_DATE.data('daterangepicker').container.remove();
        }*/


        changeInputState($R_SOT_VAL, $SOT, 'N/A', true);
        changeInputState($R_XR_VAL, $XR_DATE, '00/00/0000', true);

        $R_SOT.change(function() {
            changeInputState(this.value, $SOT, 'N/A', true);
        });

        $R_XR.change(function() {
            changeInputState(this.value, $XR_DATE, '00/00/0000', true);
        });

        function changeInputState(value, el, inval, disen) {
            if (value == 'Y') {
                if (disen) {
                    el.prop('disabled', false);
                }

                if (inval == '00/00/0000') {
                    el.val(moment().format('DD/MM/YYYY'));
                } else {
                    el.val('');
                }
            } else {
                if (disen) {
                    el.prop('disabled', true);
                }
                el.val(inval);
            }
        }

        $.fn.dataTable.ext.buttons.add = {
            text: 'Nuevo',
            action: function (e, dt, node, config) {
                addPatientModal.open();
            }
        };


        patientsTable = $('#patients-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            responsive: true,
            serverMethod: 'POST',
            ajax: {
                url: '{!! url('patients-data') !!}',
                data: function (d) {
                    d.status = patientStatus;
                }
            },
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                'add',
                {
                    text: 'Activos',
                    action: function (e, dt, node, config) {
                        patientStatus = 'active';
                        patientsTable.draw();
                        $('#patients-status').html('Activos');
                    }
                },
                {
                    text: 'Pendientes de activar',
                    action: function () {
                        patientStatus = 'inactive';
                        patientsTable.draw();
                        $('#patients-status').html('Pendientes de activar');
                    }
                },
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'full_name'},
                {data: 'email', name: 'email'},
                {data: 'surgery_name', name: 'surgery_name'},
                {data: 'marital_status', name: 'marital_status'},
                {data: 'birth_date', name: 'birth_date'},
                {data: 'age', name: 'age'},
                {data: 'sex', name: 'sex'},
                {data: 'address', name: 'address'},
                {data: 'pref_phone_num', name: 'pref_phone_num'},
                {data: 'alt_phone_num', name: 'alt_phone_num'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false, render: function (data, type, row) { return '<div style="width:120px;">' + data + '</div>'; }}
            ],
            createdRow: function( row, data, dataIndex ) {
                if ($.trim(data['surgery_name']).length !== 0) {
                    $(row).addClass('has-surgery');
                }
            },
            language: spanishDT
        });

        patientsTable.on('draw.dt', function () {
            patientsTable.columns.adjust().responsive.recalc();
        });
    });

</script>
@endpush
