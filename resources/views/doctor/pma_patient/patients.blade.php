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
        <header class="panel-heading bg-light clearfix"><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
            <span class="m-t-xs inline">Pacientes</span> - <span id="patients-status">Activos</span>
        </header>
        <table id="patients-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Correo</th>
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
    @include('doctor.pma_patient.new')
    @include('doctor.pma_patient.update')
    @include('doctor.pma_patient.remove')

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

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

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
                url: '{!! url('pma-patients/remove') !!}',
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
            $('#update-patient-form .message-medical-insurance').hide();
            $('#update-patient-form .message-medical-insurance-name').hide();
            $('#update-patient-form .message-tutor-name').hide();
            $('#update-patient-form .message-email').hide();
            $('#update-patient-form .message-birth-date').hide();
            $('#update-patient-form .message-address').hide();
            $('#update-patient-form .message-pref-phone-num').hide();
            $('#update-patient-form .message-alt-phone-num').hide();
            $('#update-patient-form .message-mental-services-info');
            $('#update-patient-form .message-medicines-usage-info');

            $('#update-patient-form .full-name-group').removeClass('has-error');
            $('#update-patient-form .medical-insurance-group').removeClass('has-error');
            $('#update-patient-form .medical-insurance-name-group').removeClass('has-error');
            $('#update-patient-form .tutor-name-group').removeClass('has-error');
            $('#update-patient-form .email-group').removeClass('has-error');
            $('#update-patient-form .birth-date-group').removeClass('has-error');
            $('#update-patient-form .address-group').removeClass('has-error');
            $('#update-patient-form .pref-phone-num-group').removeClass('has-error');
            $('#update-patient-form .alt-phone-num-group').removeClass('has-error');
            $('#update-patient-form .mental-services-info-group').removeClass('has-error');
            $('#update-patient-form .medicines-usage-info-group').removeClass('has-error');


            loader.show();

            $.ajax({
                url: '{!! url('pma-patients/update') !!}',
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

                        if (res.error.tutor_name) {
                            $('#update-patient-form .tutor-name-group').addClass('has-error');
                            $('#update-patient-form .message-tutor-name').html(res.error.tutor_name).fadeIn();
                        }

                        if (res.error.email) {
                            $('#update-patient-form .email-group').addClass('has-error');
                            $('#update-patient-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.birth_date) {
                            $('#update-patient-form .birth-date-group').addClass('has-error');
                            $('#update-patient-form .message-birth-date').html(res.error.birth_date).fadeIn();
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

                        if (res.error.mental_services_info) {
                            $('#update-patient-form .mental-services-info-group').addClass('has-error');
                            $('#update-patient-form .message-mental-services-info').html(res.error.mental_services_info).fadeIn();
                        }

                        if (res.error.medicines_usage_info) {
                            $('#update-patient-form .medicines-usage-info-group').addClass('has-error');
                            $('#update-patient-form .message-mental-services-info').html(res.error.medicines_usage_info).fadeIn();
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
                url: '{!! url('pma-patients/info') !!}/' + pid,
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
                        maxDate: moment().format('12/01/YYYY'),
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
            $('#add-patient-form .message-medical-insurance').hide();
            $('#add-patient-form .message-medical-insurance-name').hide();
            $('#add-patient-form .message-tutor-name').hide();
            $('#add-patient-form .message-email').hide();
            $('#add-patient-form .message-birth-date').hide();
            $('#add-patient-form .message-address').hide();
            $('#add-patient-form .message-pref-phone-num').hide();
            $('#add-patient-form .message-alt-phone-num').hide();
            $('#add-patient-form .message-mental-services-info');
            $('#add-patient-form .message-medicines-usage-info');

            $('#add-patient-form .full-name-group').removeClass('has-error');
            $('#add-patient-form .medical-insurance-group').removeClass('has-error');
            $('#add-patient-form .medical-insurance-name-group').removeClass('has-error');
            $('#add-patient-form .tutor-name-group').removeClass('has-error');
            $('#add-patient-form .email-group').removeClass('has-error');
            $('#add-patient-form .birth-date-group').removeClass('has-error');
            $('#add-patient-form .address-group').removeClass('has-error');
            $('#add-patient-form .pref-phone-num-group').removeClass('has-error');
            $('#add-patient-form .alt-phone-num-group').removeClass('has-error');
            $('#add-patient-form .mental-services-info-group').removeClass('has-error');
            $('#add-patient-form .medicines-usage-info-group').removeClass('has-error');

            loader.show();

            $.ajax({
                url: '{!! url('pma-patients/add') !!}',
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

                        if (res.error.tutor_name) {
                            $('#add-patient-form .tutor-name-group').addClass('has-error');
                            $('#add-patient-form .message-tutor-name').html(res.error.tutor_name).fadeIn();
                        }

                        if (res.error.email) {
                            $('#add-patient-form .email-group').addClass('has-error');
                            $('#add-patient-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.birth_date) {
                            $('#add-patient-form .birth-date-group').addClass('has-error');
                            $('#add-patient-form .message-birth-date').html(res.error.birth_date).fadeIn();
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

                        if (res.error.mental_services_info) {
                            $('#add-patient-form .mental-services-info-group').addClass('has-error');
                            $('#add-patient-form .message-mental-services-info').html(res.error.mental_services_info).fadeIn();
                        }

                        if (res.error.medicines_usage_info) {
                            $('#add-patient-form .medicines-usage-info-group').addClass('has-error');
                            $('#add-patient-form .message-mental-services-info').html(res.error.medicines_usage_info).fadeIn();
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
                $('#add-patient-form .message-email').hide();
                $('#add-patient-form .message-birth-date').hide();
                $('#add-patient-form .message-address').hide();
                $('#add-patient-form .message-pref-phone-num').hide();
                $('#add-patient-form .message-alt-phone-num').hide();
                $('#add-patient-form .message-mental-services-info');
                $('#add-patient-form .message-medicines-usage-info');

                $('#add-patient-form .full-name-group').removeClass('has-error');
                $('#add-patient-form .email-group').removeClass('has-error');
                $('#add-patient-form .birth-date-group').removeClass('has-error');
                $('#add-patient-form .address-group').removeClass('has-error');
                $('#add-patient-form .pref-phone-num-group').removeClass('has-error');
                $('#add-patient-form .alt-phone-num-group').removeClass('has-error');
                $('#add-patient-form .mental-services-info-group').removeClass('has-error');
                $('#add-patient-form .medicines-usage-info-group').removeClass('has-error');
            }

            if (updatePatientModal.getState() == 'closing') {
                updatePatientForm[0].reset();
                $('#update-patient-form .message-full-name').hide();
                $('#update-patient-form .message-tutor-name').hide();
                $('#update-patient-form .message-email').hide();
                $('#update-patient-form .message-birth-date').hide();
                $('#update-patient-form .message-address').hide();
                $('#update-patient-form .message-pref-phone-num').hide();
                $('#update-patient-form .message-alt-phone-num').hide();
                $('#update-patient-form .message-mental-services-info');
                $('#update-patient-form .message-medicines-usage-info');

                $('#update-patient-form .full-name-group').removeClass('has-error');
                $('#update-patient-form .tutor-name-group').removeClass('has-error');
                $('#update-patient-form .email-group').removeClass('has-error');
                $('#update-patient-form .birth-date-group').removeClass('has-error');
                $('#update-patient-form .address-group').removeClass('has-error');
                $('#update-patient-form .pref-phone-num-group').removeClass('has-error');
                $('#update-patient-form .alt-phone-num-group').removeClass('has-error');
                $('#update-patient-form .mental-services-info-group').removeClass('has-error');
                $('#update-patient-form .medicines-usage-info-group').removeClass('has-error');
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
            maxDate: moment().format('12/01/YYYY')
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
            language: spanishDT
        });

        patientsTable.on('draw.dt', function () {
            patientsTable.columns.adjust().responsive.recalc();
        });

    });

</script>
@endpush
