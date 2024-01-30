@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/cropic/croppic.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
@endpush

@section('title', 'Perfil')

@section('content-classes', '')

@section('content')
    <section class="hbox stretch">
        <aside class="aside-xl bg-light lter b-r">
            <section class="vbox">
                <section class="scrollable">
                    <div class="wrapper">
                        <div class="clearfix m-b">
                            <a class="thumb-lg thumb-center m-r" href="#" data-remodal-target="edit-profile-picture">
                                <img class="img-circle" src="{{ $patient->photo }}" id="c-profile-pic"></a>
                            <div class="clear text-center">
                                <div class="h3 m-t-xs m-b-xs">{{ $patient->short_name }}</div>
                            </div>
                        </div>

                        @if ($nextAppointment)
                            <div class="panel wrapper panel-success">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <span class="m-b-xs h4 block">Próxima cita</span>
                                        <small class="text-muted">{{ $nextAppointment->start_md }}
                                            <br> {{ ucfirst($nextAppointment->start_until) }}</small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="panel wrapper panel-success">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <span class="m-b-xs h4 block">Próxima cita</span>
                                        <small class="text-muted">No hay próxima cita</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="btn-group btn-group-justified m-b">
                            <a data-loading-text="Enviando" class="btn btn-primary btn-rounded">
                                <i class="fa fa-calendar"></i> Solicitar cita
                            </a>
                            <a href="{{ url('patient/profile/update') }}"
                               class="btn btn-dark btn-rounded">
                                <i class="fa fa-edit"></i> Editar perfil
                            </a>
                        </div>
                        <div>
                            <div class="line"></div>
                            <small class="text-uc text-xs text-muted">Información</small>
                            <ul class="list-unstyled inf-list">
                                @if ($patient->doctor['id'] == 3 || $selected_doctor == 3)
                                    <li>
                                        <i class="fa fa-phone user-profile-icon"></i> <a
                                                href="tel:{{ $patient->pref_phone_num }}">{{ $patient->pref_phone_num }}</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone-square user-profile-icon"></i> <a
                                                href="tel:{{ $patient->alt_phone_num }}">{{ $patient->alt_phone_num }}</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope user-profile-icon"></i> <a
                                                href="mailto:{{ $patient->email }}">{{ $patient->email }}</a>
                                    </li>
                                @elseif ($patient->doctor['id'] == 2 || $selected_doctor == 2)
                                    <li>
                                        <i class="fa fa-briefcase user-profile-icon"></i> {{ $patient->occupation }}
                                    </li>
                                    <li>
                                        <i class="fa fa-phone user-profile-icon"></i> <a
                                                href="tel:{{ $patient->pref_phone_num }}">{{ $patient->pref_phone_num }}</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone-square user-profile-icon"></i> <a
                                                href="tel:{{ $patient->alt_phone_num }}">{{ $patient->alt_phone_num }}</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope user-profile-icon"></i> <a
                                                href="mailto:{{ $patient->email }}">{{ $patient->email }}</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="line"></div>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
        <aside class="bg-white">
            <section class="vbox">
                <header class="header bg-light bg-gradient">
                    <ul class="nav nav-tabs nav-white">
                        <li class="active" id="parent-pfi"><a data-toggle="tab" href="#patient-full-info">Información General</a></li>
                        <li class=""><a data-toggle="tab" href="#appointments-info">Citas</a></li>
                    </ul>
                </header>
                <section class="scrollable">
                    <div class="tab-content">
                        <div id="patient-full-info" class="tab-pane active">
                            <div class="padder">
                                @if ($patient->doctor['id'] == 3)
                                    <h6><strong>Nombre completo: </strong>{{ $patient->full_name }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Seguro médico: </strong>{{ $patient->medical_insurance == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Seguro médico: </strong>{{ $patient->medical_insurance == 'Y' ? $patient->medical_insurance_name : 'N/A' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Nombre padre/tutor: </strong>{{ $patient->tutor_name }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Correo electrónico: </strong>{{ $patient->email }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Referido por: </strong>{{ $patient->referred_by }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Estado civil: </strong>{{ $patient->marital_status }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Hijos, edades: </strong>{{ $patient->children_info }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Fecha nacimiento: </strong>{{ $patient->birth_date }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Edad: </strong>{{ $patient->age }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Sexo: </strong>{{ $patient->sex }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Dirección casa: </strong>{{ $patient->address }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Teléfono casa: </strong>{{ $patient->pref_phone_num }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Teléfono celular: </strong>{{ $patient->alt_phone_num }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Servicios de salud mental: </strong>{{ $patient->mental_services == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Tipo de servicios de salud mental: </strong>{{ $patient->mental_services == 'Y' ? $patient->mental_services_info : 'N/A' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Tomando medicamentos: </strong>{{ $patient->medicines_usage == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Cuales, tiempo: </strong>{{ $patient->medicines_usage == 'Y' ? $patient->medicines_usage_info : 'N/A' }}</h6>
                                    <div class="line"></div>
                                @else
                                    <h6><strong>Nombre completo: </strong>{{ $patient->full_name }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Seguro médico: </strong>{{ $patient->medical_insurance == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Seguro médico: </strong>{{ $patient->medical_insurance == 'Y' ? $patient->medical_insurance_name : 'N/A' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Correo electrónico: </strong>{{ $patient->email }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Religión: </strong>{{ $patient->religion }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Referido por: </strong>{{ $patient->referred_by }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Estado civil: </strong>{{ $patient->marital_status }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Fecha nacimiento: </strong>{{ $patient->birth_date }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Lugar nacimiento: </strong>{{ $patient->birth_location }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Edad: </strong>{{ $patient->age }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Sexo: </strong>{{ $patient->sex }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Dirección casa: </strong>{{ $patient->address }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Teléfono casa: </strong>{{ $patient->pref_phone_num }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Teléfono celular: </strong>{{ $patient->alt_phone_num }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Ocupación: </strong>{{ $patient->occupation }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Empresa: </strong>{{ $patient->employer }}</h6>
                                    <div class="line"></div>
                                    <div class="line"></div>
                                    <h6><strong>Visto por otro
                                            médico: </strong>{{ $patient->seen_other_provider == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>País: </strong>{{ $patient->other_provider_country }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Tiene radiografías: </strong>{{ $patient->x_rays == 'Y' ? 'Sí' : 'No' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Fecha
                                            radiografías: </strong>{{ $patient->x_rays == 'Y' ? $patient->x_ray_date : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Operado: </strong>{{ $patient->operated == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Operación
                                            realizada: </strong>{{ $patient->operated == 'Y' ? $patient->operated_info : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Razón consulta: </strong>{{ $patient->medical_inquiry_reason }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Tiempo del problema: </strong>{{ $patient->medical_problem_time }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Problema por
                                            golpe: </strong>{{ $patient->medical_problem_coup == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6>
                                        <strong>Golpe: </strong>{{ $patient->medical_proble_coup == 'Y' ? $patient->problem_coup_info : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Deporte: </strong>{{ $patient->sport_practice == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Deporte que
                                            practica: </strong>{{ $patient->sport_practice == 'Y' ? $patient->sport_practice_info : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Enfermedades: </strong></h6>
                                    @if ($patient->diseases->isEmpty())
                                        <span>No hay enfermedades seleccionadas</span>
                                    @else
                                        <table class="table table-np">
                                            <tbody>
                                            @foreach ($patient->diseases as $disease)
                                                <tr>
                                                    <td>{{ $disease->name }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    <div class="line"></div>
                                    <h6><strong>Ejercicio: </strong>{{ $patient->exercise == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Ejercicio que
                                            practica: </strong>{{ $patient->exercise == 'Y' ? $patient->exercise_info : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Consume alcohol: </strong>{{ $patient->alcohol == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6>
                                        <strong>Consumo: </strong>{{ $patient->alcohol == 'Y' ? $patient->alcohol_usage : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Fuma: </strong>{{ $patient->smokes == 'Y' ? 'Sí' : 'No' }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Cigarrillos por
                                            día: </strong>{{ $patient->smokes == 'Y' ? $patient->smokes_per_day : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Años de
                                            fumar: </strong>{{ $patient->smokes == 'Y' ? $patient->smokes_years : 'N/A' }}
                                    </h6>
                                    <div class="line"></div>
                                    <h6><strong>Medicamentos: </strong></h6>
                                    @if ($patient->medicines->isEmpty())
                                        <span>No hay medicamentos</span>
                                    @else
                                        <table class="table table-np">
                                            <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Dosis/Frecuencia</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($patient->medicines as $medicine)
                                                @if (!empty($medicine->name))
                                                    <tr>
                                                        <td>{{ $medicine->name }}</td>
                                                        <td>{{ $medicine->dose_frequency }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    <div class="line"></div>
                                    <h6><strong>Alergias: </strong>{{ $patient->allergies}}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Causa alergia: </strong>{{ $patient->allergies_cause }}</h6>
                                    <div class="line"></div>
                                    <h6><strong>Reacción: </strong>{{ $patient->allergies_reaction }}</h6>
                                @endif
                            </div>
                        </div>
                        <div id="appointments-info" class="tab-pane">
                            <section class="panel panel-default panel-nbd" style="min-height: 172px;">
                                <table id="appointments-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Doctor</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Finalización</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
    </section>
    <div class="remodal-bg"></div>
    @include('doctor.patient.edit-picture')
    @include('doctor.patient.edit-profile')

    <div class="remodal" id="pt-modal" data-remodal-id="ptappointment"
         data-remodal-options="hashTracking: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div id="patient-appointment" style="display: none;">
        </div>
        <div class="loader-backdrop dt-loader" style="display: none;">
            <div data-loader="circle-side"></div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script src="{{ asset('assets/js/cropic/croppic.min.js') }}"></script>
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        var historyTable,
            addHistoryModal         = $('[data-remodal-id=add-med-history]').remodal(),
            addHistoryForm          = $('#add-history-form'),
            updateHistoryModal      = $('[data-remodal-id=update-med-history]').remodal(),
            updateHistoryForm       = $('#update-history-form'),
            removeHistoryModal      = $('[data-remodal-id=remove-med-history]').remodal(),
            removeHistoryForm       = $('#remove-history-form'),
            editPatientProfile      = $('#edit-patient-prof'),
            editPatientProfileForm  = $('#edit-profile-form'),
            editPatientProfileModal = $('[data-remodal-id=edit-profile]').remodal(),
            editPatientPictureForm  = $('#edit-patient-picture'),
            loader                  = $('.dt-loader');


        $(document).on('click.button.data-api', '[data-loading-text]', function (e) {
            var $this = $(e.target);
            $this.is('i') && ($this = $this.parent());
            $this.button('loading');

            $.ajax({
                url: '{{ url('patient/appointment/request') }}',
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        $(e.target).html('<i class="fa fa-check"></i> Enviada');
                    }
                }
            });

        });

        $(document).on('click', '.dt-fr-vpt', function (e) {
            var _this = $(this), aid = _this.data('aid');

            $('#patient-appointment').html('').hide();
            $('#pt-modal .dt-loader').show();

            $.ajax({
                url: '{{ url('patient/appointment') }}/' + aid,
                method: 'GET',
                success: function(res) {
                    $('#patient-appointment').html(res);

                    $(document).on("click",".remodal li a",function()
                    {
                        tab = $(this).attr("href");
                        $(".remodal .tab-content div").each(function(){
                            $(this).removeClass("active");
                        });
                        $(".remodal .tab-content "+tab).addClass("active");
                    });

                    var notesTable = $('#notes-table').DataTable({
                        stateSave: true,
                        serverSide: true,
                        fixedHeader: {
                            header: true,
                            headerOffset: $('#nav-head').outerHeight()
                        },
                        responsive: true,
                        serverMethod: 'POST',
                        ajax: '{!! url('patient/notes-data') !!}/' + aid,
                        dom:
                        "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        buttons: [
                            'pageLength'
                        ],
                        columns: [
                            {data: 'description', name: 'description'}
                        ],
                        language: spanishDT
                    });

                    var prescriptionsTable = $('#prescriptions-table').DataTable({
                        stateSave: true,
                        serverSide: true,
                        fixedHeader: {
                            header: true,
                            headerOffset: $('#nav-head').outerHeight()
                        },
                        responsive: true,
                        serverMethod: 'POST',
                        ajax: '{!! url('patient/prescriptions-data') !!}/' + aid,
                        dom:
                        "<'row'<'col-sm-7'B><'col-sm-5'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        buttons: [
                            { text: 'Exportar a pdf', action: function ( e, dt, node, config ) { window.location.href = '{{ url('patient/prescriptions/pdf/download') }}/' + aid; } },
                            'pageLength'
                        ],
                        columns: [
                            {data: 'medicine_id', name: 'medicine_id'},
                            {data: 'indication', name: 'indication'},
                        ],
                        language: spanishDT
                    });


                    $('#patient-appointment').fadeIn();
                    $('#pt-modal .dt-loader').fadeOut();

                }
            });
        });


        editPatientProfileForm.on('submit', function (e) {
            e.preventDefault();

            $('#edit-profile-form .message-email').hide();
            $('#edit-profile-form .message-mailing-address').hide();
            $('#edit-profile-form .message-pref-phone-num').hide();

            $('#edit-profile-form .email-group').removeClass('has-error');
            $('#edit-profile-form .mailing-address-group').removeClass('has-error');
            $('#edit-profile-form .pref-phone-num-group').removeClass('has-error');

            loader.show();

            $.ajax({
                url: '{{ url('patient/profile/update') }}',
                method: 'POST',
                data: editPatientProfileForm.serialize(),
                success: function (res) {
                    //$('#patient-full-info').fadeOut();

                    if (res.success) {

                        $.ajax({
                            url: '{{ url('patient/profile-gen-info-tab') }}',
                            method: 'GET',
                            success: function(res) {
                                /*$('.nav-tabs li').removeClass('active');
                                $('#parent-pfi').addClass('active');
                                $('#patient-full-info').html(res).fadeIn();*/

                                loader.fadeOut();

                                editPatientProfileForm[0].reset();
                                editPatientProfileModal.close();
                            }
                        });
                    } else {

                        if (res.error.email) {
                            $('#edit-profile-form .email-group').addClass('has-error');
                            $('#edit-profile-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.mailing_address) {
                            $('#edit-profile-form .mailing-address-group').addClass('has-error');
                            $('#edit-profile-form .message-mailing-address').html(res.error.mailing_address).fadeIn();
                        }

                        if (res.error.pref_phone_num) {
                            $('#edit-profile-form .pref-phone-num-group').addClass('has-error');
                            $('#edit-profile-form .message-pref-phone-num').html(res.error.pref_phone_num).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });

        editPatientProfile.on('click', function (e) {

            loader.show();
            $('#edit-profile-form').html('').hide();

            $.ajax({
                url: '{{ url('patient/profile-info') }}',
                method: 'GET',
                success: function (res) {
                    $('#edit-profile-form').html(res).fadeIn();


                    loader.fadeOut();
                }
            });
        });

        var eyeCandy       = $('#cropContainerEyecandy');
        var croppedOptions = {
            imgEyecandy: false,
            imgEyecandyOpacity: 0.2,
            doubleZoomControls: false,
            rotateControls: false,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onAfterImgCrop: function (res) {
                $('#c-profile-pic').attr('src', res.url + '?timestamp=' + new Date().getTime());
                $('#c-nav-profile-pic').attr('src', res.url + '?timestamp=' + new Date().getTime());
            },
            uploadUrl: '{{ url('patient/profile/upload') }}',
            cropUrl: '{{ url('patient/profile/crop') }}',
            cropData: {
                'width': eyeCandy.width(),
                'height': eyeCandy.height()
            }
        };
        var cropperBox     = new Croppic('cropContainerEyecandy', croppedOptions);


        var appointmentsTable = $('#appointments-table').DataTable({
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('patient/appointments-data') !!}',
            dom:
            "<'row'<'col-sm-12'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                'pageLength'
            ],
            columns: [
                {data: 'doctor_id', name: 'doctor_id'},
                {data: 'start', name: 'start'},
                {data: 'end', name: 'end'}
            ],
            language: {
                "sProcessing":     "Procesando por favor espere...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_ citas",
                "sInfoEmpty":      "Mostrando del 0 al 0 de 0 citas",
                "sInfoFiltered":   "(filtrado de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                select: {
                    rows: {
                        _: "You have selected %d rows",
                        0: "",
                        1: "1 fila seleccionada"
                    }
                },
                buttons: {
                    pageLength: {
                        _: "Mostrar %d citas"
                    }
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>
@endpush
