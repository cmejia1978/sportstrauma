@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fullcalendar/fullcalendarv2.css') }}" rel="stylesheet">
<link href="<?php echo e(asset('assets/js/toastr/toastr.css')); ?>" rel="stylesheet">
@endpush

@section('title', 'Paciente')

@section('content-classes', '')

@section('content')
    <section class="hbox stretch">
        <aside class="aside-lg bg-light lter b-r">
            <section class="vbox">
                <section class="scrollable">
                    <div class="wrapper">
                        <div class="clearfix m-b">
                            <a class="thumb-lg thumb-center m-r" href="{{ url('patients/view', $patient->id ) }}">
                                <img class="img-circle" src="{{ $patient->photo }}"></a>
                            <div class="clear text-center">
                                <div class="h3 m-t-xs m-b-xs">{{ $patient->short_name }}</div>
                                <div class="h4 m-t-xs m-b-xs">{{ 'Edad: ' . $patient->age . ' años' }}</div>
                            </div>
                        </div>
                        <div class="panel wrapper panel-success">
                            <div class="row">
                                @if ($nextAppointment)
                                    <a href="{{ url('appointments/view', $nextAppointment->id) }}">
                                        <div class="col-xs-12 text-center">
                                            <span class="m-b-xs h4 block">Próxima cita</span>
                                            <small class="text-muted">{{ $nextAppointment->start_md }}
                                                <br> {{ ucfirst($nextAppointment->start_until) }}</small>
                                        </div>
                                    </a>
                                @else
                                    <div class="col-xs-12 text-center">
                                        <span class="m-b-xs h4 block">Próxima cita</span>
                                        <small class="text-muted">No hay próxima cita</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="line"></div>
                            <small class="text-uc text-xs text-muted">Información <a id="view-edit" data-remodal-target="update-patient" href="#"><i class="fa fa-pencil"></i></a></small>
                            <ul class="list-unstyled inf-list">
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

                            </ul>
                            <div class="line"></div>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
        <aside class="bg-white">
            <section class="vbox">
                <header id="tabs-header" class="header bg-light bg-gradient">
                    <ul class="nav nav-tabs nav-white">
                        <li class="active"><a data-toggle="tab" href="#patient-full-info">Información General</a></li>
                        <li><a data-toggle="tab" href="#patient-evolution">Evolución del paciente</a></li>
                        <li><a data-toggle="tab" href="#medical-history-info">Historial Médico</a></li>
                        <li><a data-toggle="tab" href="#appointments-info">Citas</a></li>
                        <li><a data-toggle="tab" href="#media-surgery-files">Cirugía</a></li>
                        <li><a data-toggle="tab" href="#media-op-record-files">Récord Operatorio</a></li>
                        <li><a data-toggle="tab" href="#media-laboratories-files">Laboratorios</a></li>
                        <li><a data-toggle="tab" href="#media-reports-files">Informes</a></li>
                    </ul>
                </header>
                <section class="scrollable">
                    <div class="tab-content">
                        <div id="patient-full-info" class="tab-pane active">
                            <div class="padder">
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
                                <h6><strong>Sexo: </strong>{{ $patient->sex == 'M' ? 'Masculino' : 'Femenino' }}</h6>
                                <div class="line"></div>
                                <h6><strong>Dirección casa: </strong>{{ $patient->address }}</h6>
                                <div class="line"></div>
                                <h6><strong>Número de teléfono: </strong>{{ $patient->pref_phone_num }}</h6>
                                <div class="line"></div>
                                <h6><strong>Número de teléfono alternativo: </strong>{{ $patient->alt_phone_num }}</h6>
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
                            </div>
                        </div>
                        <div id="patient-evolution" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="evolution-table"
                                       class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Creado en</th>
                                        <th class="all">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </section>
                        </div>
                        <div id="medical-history-info" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="history-table"
                                       class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th>Creado en</th>
                                        <th class="all">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </section>
                        </div>
                        <div id="appointments-info" class="tab-pane">
                            <div class="list-group bg-white">
                                @foreach ($patient->appointments as $appointment)
                                    <a class="list-group-item" href="{{ url('appointments/view', $appointment->id) }}">
                                        <i class="fa fa-chevron-right icon-muted"></i>
                                        <span class="badge bg-doctor">{{ $appointment->start_date }}</span>
                                        <i class="fa fa-calendar icon-muted fa-fw"></i>
                                        <strong>Cita No.: </strong> {{ $appointment->id }} <strong>para
                                            el:</strong> {{ $appointment->start_date_fancy }} <strong>con una Duración
                                            de:</strong> {{ $appointment->duration }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div id="media-surgery-files" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="surgery-files-table"
                                       class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Preview</th>
                                        <th>Descripción</th>
                                        <th>Categoría</th>
                                        <th>Tipo Archivo</th>
                                        <th>Creado</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                </table>
                            </section>
                        </div>
                        <div id="media-op-record-files" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="oprecord-files-table"
                                       class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Preview</th>
                                        <th>Descripción</th>
                                        <th>Tipo Archivo</th>
                                        <th>Creado</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                </table>
                            </section>
                        </div>
                        <div id="media-laboratories-files" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="lab-files-table"
                                       class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Preview</th>
                                        <th>Descripción</th>
                                        <th>Tipo Archivo</th>
                                        <th>Creado</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                </table>
                            </section>
                        </div>
                        <div id="media-reports-files" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="report-files-table"
                                       class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Preview</th>
                                        <th>Descripción</th>
                                        <th>Tipo Archivo</th>
                                        <th>Creado</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                </table>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
    </section>

    <div class="remodal-bg"></div>
    @include('doctor.patient.evolution.new', ['patient', $patient])
    @include('doctor.patient.evolution.update')
    @include('doctor.patient.evolution.remove')


    @include('doctor.patient.history.new', ['patient', $patient])
    @include('doctor.patient.history.update')
    @include('doctor.patient.history.remove')
    @include('doctor.media.view')

    @include('doctor.media.patient.surgery.new', ['patient' => $patient])
    @include('doctor.media.patient.surgery.remove', ['patient' => $patient])
    @include('doctor.media.patient.surgery.update')

    @include('doctor.media.patient.oprecord.new', ['patient' => $patient])
    @include('doctor.media.patient.oprecord.remove', ['patient' => $patient])
    @include('doctor.media.patient.oprecord.update')

    @include('doctor.media.patient.lab.new', ['patient' => $patient])
    @include('doctor.media.patient.lab.remove', ['patient' => $patient])
    @include('doctor.media.patient.lab.update')

    @include('doctor.media.patient.report.new', ['patient' => $patient])
    @include('doctor.media.patient.report.remove', ['patient' => $patient])
    @include('doctor.media.patient.report.update')

    @include('doctor.pma_patient.update')

@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script id="general-template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td class="extra-params">
            <input type="hidden" name="pid[]" value="{{ $patient->id }}">
            <div class="form-group">
                <label class="control-label" for="input-surgery-file-description-{%=i%}">Descripción</label>
                <input id="input-surgery-file-description-{%=i%}" class="form-control" name="description[]" placeholder="Descripción" data-inid="input-surgery-file-description-group-{%=i%}" data-required="yes">
                <span class="help-block"></span>
            </div>
        </td>
        <td>
            <p class="name text-ellipsis" title="{%=file.name%}">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            <div class="btn-group">
            {% if (!i && !o.options.autoUpload) { %}
                <button title="Subir archivo" class="btn btn-primary start" disabled>
                    <i class="fa fa-upload"></i>
                </button>
            {% } %}
            {% if (!i) { %}
                <button title="Cancelar" class="btn btn-warning cancel">
                    <i class="fa fa-ban"></i>
                </button>
            {% } %}
            </div>
        </td>
    </tr>
{% } %}


</script>
<script id="general-template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <img src="{%=file.thumbnailUrl%}" title="{%=file.name%}" alt="{%=file.name%}"   >
                {% } %}
            </span>
        </td>
        <td>
            {% if (file.success) { %}
                <div><span class="label label-success"><i class="fa fa-check"></i></span> Archivo subido de forma exitosa</div>
            {% } %}
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
    </tr>
{% } %}


</script>
<script id="surgery-template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td class="extra-params">
            <input type="hidden" name="pid[]" value="{{ $patient->id }}">
            <div class="form-group">
                <label class="control-label" for="input-surgery-file-description-{%=i%}">Descripción</label>
                <input id="input-surgery-file-description-{%=i%}" class="form-control" name="description[]" placeholder="Descripción" data-inid="input-surgery-file-description-group-{%=i%}" data-required="yes">
                <span class="help-block"></span>
            </div>
            <div class="form-group surgery-file-category-{%=i%}">
                <label class="control-label" for="input-surgery-file-category-{%=i%}">Categoría</label>
                <select id="input-surgery-file-category-{%=i%}" class="form-control" name="category[]">
                    <option value="1">Artroscopia de Hombro</option>
                    <option value="2">Artroscopia de Codo</option>
                    <option value="3">Artroscopia de Rodilla</option>
                    <option value="4">Artroscopia de Tobillo</option>
                    <option value="5">Corrección quirúrgica</option>
                    <option value="6">Reparación quirúrgica</option>
                    <option value="7">Osteosíntesis</option>
                    <option value="8">Artroplastia de Hombro</option>
                    <option value="9">Artroplastia de Rodilla</option>
                    <option value="10">Otros</option>
                </select>
            </div>
        </td>
        <td>
            <p class="name text-ellipsis" title="{%=file.name%}">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            <div class="btn-group">
            {% if (!i && !o.options.autoUpload) { %}
                <button title="Subir archivo" class="btn btn-primary start" disabled>
                    <i class="fa fa-upload"></i>
                </button>
            {% } %}
            {% if (!i) { %}
                <button title="Cancelar" class="btn btn-warning cancel">
                    <i class="fa fa-ban"></i>
                </button>
            {% } %}
            </div>
        </td>
    </tr>
{% } %}


</script>
<script id="surgery-template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <img src="{%=file.thumbnailUrl%}" title="{%=file.name%}" alt="{%=file.name%}"   >
                {% } %}
            </span>
        </td>
        <td>
            {% if (file.success) { %}
                <div><span class="label label-success"><i class="fa fa-check"></i></span> Archivo subido de forma exitosa</div>
            {% } %}
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
    </tr>
{% } %}


</script>
<script src="{{ asset('assets/js/jquery-file-upload/vendor/jquery.ui.widget.js') }}"></script>
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-image.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-audio.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-video.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-validate.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-ui.js') }}"></script>
<script src="{{ asset('assets/js/tabdrop/bootstrap-tabdrop.js') }}"></script>

<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar/fullcalendarv2.min.js') }}"></script>
<script src="<?php echo e(asset('assets/js/toastr/toastr.min.js')); ?>"></script>
<script>
    $(function () {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});

        var historyTable,
            evolutionTable,
            surgeryFilesTable,
            oprecordFilesTable,
            labFilesTable,
            reportFilesTable,
            viewport                = {width: $(window).width(), height: $(window).height()},

            addHistoryModal         = $('[data-remodal-id=add-med-history]').remodal(),
            addHistoryForm          = $('#add-history-form'),
            updateHistoryModal      = $('[data-remodal-id=update-med-history]').remodal(),
            updateHistoryForm       = $('#update-history-form'),
            removeHistoryModal      = $('[data-remodal-id=remove-med-history]').remodal(),
            removeHistoryForm       = $('#remove-history-form'),

            addEvolutionModal       = $('[data-remodal-id=add-patient-evolution]').remodal(),
            addEvolutionForm        = $('#add-patient-evolution-form'),
            updateEvolutionModal    = $('[data-remodal-id=update-patient-evolution]').remodal(),
            updateEvolutionForm     = $('#update-patient-evolution-form'),
            removeEvolutionModal    = $('[data-remodal-id=remove-patient-evolution]').remodal(),
            removeEvolutionForm     = $('#remove-patient-evolution-form'),

            addSurgeryFileModal     = $('[data-remodal-id=add-surgery-file]').remodal(),
            removeSurgeryFileModal  = $('[data-remodal-id=remove-surgery-file]').remodal(),
            removeSurgeryFileForm   = $('#remove-surgery-file-form'),
            updateSurgeryFileModal  = $('[data-remodal-id=update-surgery-file]').remodal(),
            updateSurgeryFileForm   = $('#update-surgery-file-form'),
            surgerFileStatus        = 'Todos',

            addOPRecordFileModal    = $('[data-remodal-id=add-oprecord-file]').remodal(),
            removeOPRecordFileModal = $('[data-remodal-id=remove-oprecord-file]').remodal(),
            removeOPRecordFileForm  = $('#remove-oprecord-file-form'),
            updateOPRecordFileModal = $('[data-remodal-id=update-oprecord-file]').remodal(),
            updateOPRecordFileForm  = $('#update-oprecord-file-form'),

            addLabFileModal         = $('[data-remodal-id=add-lab-file]').remodal(),
            removeLabFileModal      = $('[data-remodal-id=remove-lab-file]').remodal(),
            removeLabFileForm       = $('#remove-lab-file-form'),
            updateLabFileModal      = $('[data-remodal-id=update-lab-file]').remodal(),
            updateLabFileForm       = $('#update-lab-file-form'),

            addReportFileModal      = $('[data-remodal-id=add-report-file]').remodal(),
            removeReportFileModal   = $('[data-remodal-id=remove-report-file]').remodal(),
            removeReportFileForm    = $('#remove-report-file-form'),
            updateReportFileModal   = $('[data-remodal-id=update-report-file]').remodal(),
            updateReportFileForm    = $('#update-report-file-form'),

            updatePatientModal = $('[data-remodal-id=update-patient]').remodal(),
            updatePatientForm  = $('#update-patient-form'),

            loader                  = $('.dt-loader');

        $(window).bind('resize', function () {
            viewport.width = $(window).width();

            if (viewport.width <= 770) {
                $('.nav-pills, .nav-tabs').detach();
                $('#tabs-header').html(
                        '<ul class="nav nav-tabs nav-white">' +
                        '<li class="active"><a data-toggle="tab" href="#patient-full-info">Información General</a></li>' +
                        '<li><a data-toggle="tab" href="#patient-evolution">Evolución del paciente</a></li>' +
                        '<li><a data-toggle="tab" href="#medical-history-info">Historial Médico</a></li>' +
                        '<li><a data-toggle="tab" href="#appointments-info">Citas</a></li>' +
                        '<li><a data-toggle="tab" href="#media-surgery-files">Cirugía</a></li>' +
                        '<li><a data-toggle="tab" href="#media-op-record-files">Récord Operatorio</a></li>' +
                        '<li><a data-toggle="tab" href="#media-laboratories-files">Laboratorios</a></li>' +
                        '<li><a data-toggle="tab" href="#media-reports-files">Informes</a></li>' +
                        '</ul>'
                );
            } else {
                $('.nav-pills, .nav-tabs').tabdrop();
            }
        });

        $(window).trigger('resize');


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
                        window.location.reload();
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

        $('#view-edit').on('click', function(e) {
            updatePatientForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('pma-patients/info') !!}/{{ $patient->id }}',
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

        /***jquery file upload report media*/

        $(document).on('click', '.dt-remove-report-file', function (e) {
            var fid = $(this).data('fid');
            $('#remove-report-fid').val(fid);
        });

        removeReportFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/report/delete') !!}',
                method: 'POST',
                data: removeReportFileForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        reportFilesTable.ajax.reload();
                        removeReportFileForm[0].reset();
                        removeReportFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-report-file', function (e) {
            var fid = $(this).data('fid');
            updateReportFileForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('media/report') !!}/' + fid,
                method: 'GET',
                success: function (res) {
                    updateReportFileForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateReportFileForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-report-file-form .description-group').removeClass('has-error');
            $('#update-report-file-form .message-description').hide();
            $('#update-report-file-form .category-group').removeClass('has-error');
            $('#update-report-file-form .message-category').hide();

            loader.show();

            $.ajax({
                url: '{!! url('media/report/update') !!}',
                data: updateReportFileForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        reportFilesTable.ajax.reload();
                        updateReportFileForm[0].reset();
                        updateReportFileModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-report-file-form .description-group').addClass('has-error');
                            $('#update-report-file-form .message-description').html(res.error.description).fadeIn();
                        }

                        if (res.error.category) {
                            $('#update-report-file-form .category-group').addClass('has-error');
                            $('#update-report-file-form .message-category').html(res.error.category).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        $(document).on('click', '.dt-view-report-file', function (e) {
            e.preventDefault();
            var _this = $(this),
                fid   = _this.data('fid');

            $('#file-viewer-container').html('');
            loader.fadeIn();

            $.ajax({
                url: '{{ url('media/report/view') }}',
                method: 'POST',
                data: {fid: fid},
                success: function (res) {
                    $('#file-viewer-container').html(res);

                    loader.hide();
                }
            });
        });


        $('#report-file-upload').fileupload({
            previewMaxHeight: 200,
            previewMaxWidth: 300,
            previewCrop: true,
            uploadTemplateId: 'general-template-upload',
            downloadTemplateId: 'general-template-download',
            url: '{{ url('media/report/upload') }}',
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            maxFileSize: 100000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|bmp|dds|png|psd|pspimage|tif?f|yuv|wmv|vob|swf|srt|rm|mpg|mov|m4v|flv|avi|asf|3gp|3g2|mp4|wma|wav|mpa|mid|m4a|m3u|iff|aif|mp3|xml|tar|sdf|pptx|ppt|pps|keychain|key|ged|dat|csv|txt|doc?x|log|msg|otd|pages|rtf|tex|wpd|wps|7z|cbr|deb|gz|pkg|rar|rpm|sitx|gz|zip?x|pdf|pct|indd)$/i,
            messages: {
                maxNumberOfFiles: 'úmero máximo de archivos excedido',
                acceptFileTypes: 'Tipo de archivo no permitido',
                maxFileSize: 'El archivo es demasiado grande',
                minFileSize: 'El archivo es demasiado pequeño'
            },
            submit: function (e, data) {
                var inputs     = data.context.find(':input'),
                    validInput = true;
                inputs.each(function (index) {
                    var _this = $(this);
                    if (!this.value && _this.data('required') == 'yes') {
                        _this.parent().addClass('has-error').find('.help-block').text('Debe ingresar una descripción para el archivo');
                        validInput = false;
                    } else if (this.value && _this.data('required') == 'yes') {
                        validInput = true;
                        _this.parent().removeClass('has-error');
                    }
                });

                data.context.find('button').prop('disabled', false);
                data.formData = inputs.serializeArray();

                return validInput;
            },
            completed: function (e, data) {
                reportFilesTable.order([0, 'desc']).draw();
            }
        });

        $('#report-file-upload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

        reportFilesTable = $('#report-files-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: {
                url: '{!! url('media-report-data') !!}',
                data: function (d) {
                    d.category = surgerFileStatus;
                    d.pid      = '{{ $patient->id }}';
                }
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                {
                    text: 'Agregar archivo(s)',
                    action: function (e, dt, node, config) {
                        addReportFileModal.open();
                    }
                },
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
                {data: 'description', name: 'description'},
                {data: 'mime', name: 'mime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });


        /***jquery file upload lab media*/

        $(document).on('click', '.dt-remove-lab-file', function (e) {
            var fid = $(this).data('fid');
            $('#remove-lab-fid').val(fid);
        });

        removeLabFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/lab/delete') !!}',
                method: 'POST',
                data: removeLabFileForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        labFilesTable.ajax.reload();
                        removeLabFileForm[0].reset();
                        removeLabFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-lab-file', function (e) {
            var fid = $(this).data('fid');
            updateLabFileForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('media/lab') !!}/' + fid,
                method: 'GET',
                success: function (res) {
                    updateLabFileForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateLabFileForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-lab-file-form .description-group').removeClass('has-error');
            $('#update-lab-file-form .message-description').hide();
            $('#update-lab-file-form .category-group').removeClass('has-error');
            $('#update-lab-file-form .message-category').hide();

            loader.show();

            $.ajax({
                url: '{!! url('media/lab/update') !!}',
                data: updateLabFileForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        labFilesTable.ajax.reload();
                        updateLabFileForm[0].reset();
                        updateLabFileModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-lab-file-form .description-group').addClass('has-error');
                            $('#update-lab-file-form .message-description').html(res.error.description).fadeIn();
                        }

                        if (res.error.category) {
                            $('#update-lab-file-form .category-group').addClass('has-error');
                            $('#update-lab-file-form .message-category').html(res.error.category).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        $(document).on('click', '.dt-view-lab-file', function (e) {
            e.preventDefault();
            var _this = $(this),
                fid   = _this.data('fid');

            $('#file-viewer-container').html('');
            loader.fadeIn();

            $.ajax({
                url: '{{ url('media/lab/view') }}',
                method: 'POST',
                data: {fid: fid},
                success: function (res) {
                    $('#file-viewer-container').html(res);

                    loader.hide();
                }
            });
        });


        $('#lab-file-upload').fileupload({
            previewMaxHeight: 200,
            previewMaxWidth: 300,
            previewCrop: true,
            uploadTemplateId: 'general-template-upload',
            downloadTemplateId: 'general-template-download',
            url: '{{ url('media/lab/upload') }}',
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            maxFileSize: 100000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|bmp|dds|png|psd|pspimage|tif?f|yuv|wmv|vob|swf|srt|rm|mpg|mov|m4v|flv|avi|asf|3gp|3g2|mp4|wma|wav|mpa|mid|m4a|m3u|iff|aif|mp3|xml|tar|sdf|pptx|ppt|pps|keychain|key|ged|dat|csv|txt|doc?x|log|msg|otd|pages|rtf|tex|wpd|wps|7z|cbr|deb|gz|pkg|rar|rpm|sitx|gz|zip?x|pdf|pct|indd)$/i,
            messages: {
                maxNumberOfFiles: 'úmero máximo de archivos excedido',
                acceptFileTypes: 'Tipo de archivo no permitido',
                maxFileSize: 'El archivo es demasiado grande',
                minFileSize: 'El archivo es demasiado pequeño'
            },
            submit: function (e, data) {
                var inputs     = data.context.find(':input'),
                    validInput = true;
                inputs.each(function (index) {
                    var _this = $(this);
                    if (!this.value && _this.data('required') == 'yes') {
                        _this.parent().addClass('has-error').find('.help-block').text('Debe ingresar una descripción para el archivo');
                        validInput = false;
                    } else if (this.value && _this.data('required') == 'yes') {
                        validInput = true;
                        _this.parent().removeClass('has-error');
                    }
                });

                data.context.find('button').prop('disabled', false);
                data.formData = inputs.serializeArray();

                return validInput;
            },
            completed: function (e, data) {
                labFilesTable.order([0, 'desc']).draw();
            }
        });

        $('#lab-file-upload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

        labFilesTable = $('#lab-files-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: {
                url: '{!! url('media-lab-data') !!}',
                data: function (d) {
                    d.category = surgerFileStatus;
                    d.pid      = '{{ $patient->id }}';
                }
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                {
                    text: 'Agregar archivo(s)',
                    action: function (e, dt, node, config) {
                        addLabFileModal.open();
                    }
                },
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
                {data: 'description', name: 'description'},
                {data: 'mime', name: 'mime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });


        /***jquery file upload oprecord media*/

        $(document).on('click', '.dt-remove-oprecord-file', function (e) {
            var fid = $(this).data('fid');
            $('#remove-oprecord-fid').val(fid);
        });

        removeOPRecordFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/oprecord/delete') !!}',
                method: 'POST',
                data: removeOPRecordFileForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        oprecordFilesTable.ajax.reload();
                        removeOPRecordFileForm[0].reset();
                        removeOPRecordFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-oprecord-file', function (e) {
            var fid = $(this).data('fid');
            updateOPRecordFileForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('media/oprecord') !!}/' + fid,
                method: 'GET',
                success: function (res) {
                    updateOPRecordFileForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateOPRecordFileForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-oprecord-file-form .description-group').removeClass('has-error');
            $('#update-oprecord-file-form .message-description').hide();
            $('#update-oprecord-file-form .category-group').removeClass('has-error');
            $('#update-oprecord-file-form .message-category').hide();

            loader.show();

            $.ajax({
                url: '{!! url('media/oprecord/update') !!}',
                data: updateOPRecordFileForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        oprecordFilesTable.ajax.reload();
                        updateOPRecordFileForm[0].reset();
                        updateOPRecordFileModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-oprecord-file-form .description-group').addClass('has-error');
                            $('#update-oprecord-file-form .message-description').html(res.error.description).fadeIn();
                        }

                        if (res.error.category) {
                            $('#update-oprecord-file-form .category-group').addClass('has-error');
                            $('#update-oprecord-file-form .message-category').html(res.error.category).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        $(document).on('click', '.dt-view-oprecord-file', function (e) {
            e.preventDefault();
            var _this = $(this),
                fid   = _this.data('fid');

            $('#file-viewer-container').html('');
            loader.fadeIn();

            $.ajax({
                url: '{{ url('media/oprecord/view') }}',
                method: 'POST',
                data: {fid: fid},
                success: function (res) {
                    $('#file-viewer-container').html(res);

                    loader.hide();
                }
            });
        });


        $('#oprecord-file-upload').fileupload({
            previewMaxHeight: 200,
            previewMaxWidth: 300,
            previewCrop: true,
            uploadTemplateId: 'general-template-upload',
            downloadTemplateId: 'general-template-download',
            url: '{{ url('media/oprecord/upload') }}',
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            maxFileSize: 100000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|bmp|dds|png|psd|pspimage|tif?f|yuv|wmv|vob|swf|srt|rm|mpg|mov|m4v|flv|avi|asf|3gp|3g2|mp4|wma|wav|mpa|mid|m4a|m3u|iff|aif|mp3|xml|tar|sdf|pptx|ppt|pps|keychain|key|ged|dat|csv|txt|doc?x|log|msg|otd|pages|rtf|tex|wpd|wps|7z|cbr|deb|gz|pkg|rar|rpm|sitx|gz|zip?x|pdf|pct|indd)$/i,
            messages: {
                maxNumberOfFiles: 'úmero máximo de archivos excedido',
                acceptFileTypes: 'Tipo de archivo no permitido',
                maxFileSize: 'El archivo es demasiado grande',
                minFileSize: 'El archivo es demasiado pequeño'
            },
            submit: function (e, data) {
                var inputs     = data.context.find(':input'),
                    validInput = true;
                inputs.each(function (index) {
                    var _this = $(this);
                    if (!this.value && _this.data('required') == 'yes') {
                        _this.parent().addClass('has-error').find('.help-block').text('Debe ingresar una descripción para el archivo');
                        validInput = false;
                    } else if (this.value && _this.data('required') == 'yes') {
                        validInput = true;
                        _this.parent().removeClass('has-error');
                    }
                });

                data.context.find('button').prop('disabled', false);
                data.formData = inputs.serializeArray();

                return validInput;
            },
            completed: function (e, data) {
                oprecordFilesTable.order([0, 'desc']).draw();
            }
        });

        $('#oprecord-file-upload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

        oprecordFilesTable = $('#oprecord-files-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: {
                url: '{!! url('media-oprecord-data') !!}',
                data: function (d) {
                    d.category = surgerFileStatus;
                    d.pid      = '{{ $patient->id }}';
                }
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                {
                    text: 'Agregar archivo(s)',
                    action: function (e, dt, node, config) {
                        addOPRecordFileModal.open();
                    }
                },
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
                {data: 'description', name: 'description'},
                {data: 'mime', name: 'mime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });

        /***jquery file upload surgery media*/

        $(document).on('click', '.dt-update-surgery-file', function (e) {
            var fid = $(this).data('fid');
            updateSurgeryFileForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('media/surgery') !!}/' + fid,
                method: 'GET',
                success: function (res) {
                    updateSurgeryFileForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateSurgeryFileForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-surgery-file-form .description-group').removeClass('has-error');
            $('#update-surgery-file-form .message-description').hide();
            $('#update-surgery-file-form .category-group').removeClass('has-error');
            $('#update-surgery-file-form .message-category').hide();

            loader.show();

            $.ajax({
                url: '{!! url('media/surgery/update') !!}',
                data: updateSurgeryFileForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        surgeryFilesTable.ajax.reload();
                        updateSurgeryFileForm[0].reset();
                        updateSurgeryFileModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-surgery-file-form .description-group').addClass('has-error');
                            $('#update-surgery-file-form .message-description').html(res.error.description).fadeIn();
                        }

                        if (res.error.category) {
                            $('#update-surgery-file-form .category-group').addClass('has-error');
                            $('#update-surgery-file-form .message-category').html(res.error.category).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        $(document).on('click', '.dt-view-surgery-file', function (e) {
            e.preventDefault();
            var _this = $(this),
                fid   = _this.data('fid');

            $('#file-viewer-container').html('');
            loader.fadeIn();

            $.ajax({
                url: '{{ url('media/surgery/view') }}',
                method: 'POST',
                data: {fid: fid},
                success: function (res) {
                    $('#file-viewer-container').html(res);

                    loader.hide();
                }
            });
        });


        $('#surgery-file-upload').fileupload({
            previewMaxHeight: 200,
            previewMaxWidth: 300,
            previewCrop: true,
            uploadTemplateId: 'surgery-template-upload',
            downloadTemplateId: 'surgery-template-download',
            url: '{{ url('media/surgery/upload') }}',
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            maxFileSize: 100000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|bmp|dds|png|psd|pspimage|tif?f|yuv|wmv|vob|swf|srt|rm|mpg|mov|m4v|flv|avi|asf|3gp|3g2|mp4|wma|wav|mpa|mid|m4a|m3u|iff|aif|mp3|xml|tar|sdf|pptx|ppt|pps|keychain|key|ged|dat|csv|txt|doc?x|log|msg|otd|pages|rtf|tex|wpd|wps|7z|cbr|deb|gz|pkg|rar|rpm|sitx|gz|zip?x|pdf|pct|indd)$/i,
            messages: {
                maxNumberOfFiles: 'úmero máximo de archivos excedido',
                acceptFileTypes: 'Tipo de archivo no permitido',
                maxFileSize: 'El archivo es demasiado grande',
                minFileSize: 'El archivo es demasiado pequeño'
            },
            submit: function (e, data) {
                var inputs     = data.context.find(':input'),
                    validInput = true;
                inputs.each(function (index) {
                    var _this = $(this);
                    if (!this.value && _this.data('required') == 'yes') {
                        _this.parent().addClass('has-error').find('.help-block').text('Debe ingresar una descripción para el archivo');
                        validInput = false;
                    } else if (this.value && _this.data('required') == 'yes') {
                        validInput = true;
                        _this.parent().removeClass('has-error');
                    }
                });

                data.context.find('button').prop('disabled', false);
                data.formData = inputs.serializeArray();

                return validInput;
            },
            completed: function (e, data) {
                surgeryFilesTable.order([0, 'desc']).draw();
            }
        });

        $('#surgery-file-upload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

        $(document).on('click', '.dt-remove-surgery-file', function (e) {
            var fid = $(this).data('fid');
            $('#remove-surgery-fid').val(fid);
        });

        removeSurgeryFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/surgery/delete') !!}',
                method: 'POST',
                data: removeSurgeryFileForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        surgeryFilesTable.ajax.reload();
                        removeSurgeryFileForm[0].reset();
                        removeSurgeryFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        surgeryFilesTable = $('#surgery-files-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: {
                url: '{!! url('media-surgery-data') !!}',
                data: function (d) {
                    d.category = surgerFileStatus;
                    d.pid      = '{{ $patient->id }}';
                }
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                {
                    text: 'Agregar archivo(s)',
                    action: function (e, dt, node, config) {
                        addSurgeryFileModal.open();
                    }
                },
                {
                    extend: 'collection',
                    text: 'Filtrar por categoría',
                    autoClose: true,
                    buttons: [{
                        text: 'Todos', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Todos';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Artroscopia de Hombro', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Artroscopia de Hombro';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Artroscopia de Codo', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Artroscopia de Codo';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Artroscopia de Rodilla', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Artroscopia de Rodilla';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Artroscopia de Tobillo', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Artroscopia de Tobillo';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Corrección quirúrgica', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Corrección quirúrgica';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Reparación quirúrgica', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Reparación quirúrgica';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Osteosíntesis', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Osteosíntesis';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Artroplastia de Hombro', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Artroplastia de Hombro';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Artroplastia de Rodilla', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Artroplastia de Rodilla';
                            surgeryFilesTable.draw();
                        }
                    }, {
                        text: 'Otros', action: function (e, dt, node, config) {
                            surgerFileStatus = 'Otros';
                            surgeryFilesTable.draw();
                        }
                    }],
                    fade: true
                },
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
                {data: 'description', name: 'description'},
                {data: 'file_category', name: 'file_category'},
                {data: 'mime', name: 'mime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });


        /*** history **/

        $(document).on('click', '.dt-remove-history', function (e) {
            var hid = $(this).data('hid');
            $('#remove-hid').val(hid);
        });

        removeHistoryForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('history/remove') !!}',
                method: 'POST',
                data: removeHistoryForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        historyTable.ajax.reload();
                        removeHistoryForm[0].reset();
                        removeHistoryModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-history', function (e) {
            var hid = $(this).data('hid');
            updateHistoryForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('history') !!}/' + hid,
                method: 'GET',
                success: function (res) {
                    updateHistoryForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateHistoryForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-history-form .description-group').removeClass('has-error');
            $('#update-history-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('history/update') !!}',
                data: updateHistoryForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        historyTable.ajax.reload();
                        updateHistoryForm[0].reset();
                        updateHistoryModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-history-form .description-group').addClass('has-error');
                            $('#update-history-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        addHistoryForm.on('submit', function (e) {
            e.preventDefault();

            $('#add-history-form .description-group').removeClass('has-error');
            $('#add-history-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('history/add') !!}',
                data: addHistoryForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        historyTable.ajax.reload();
                        addHistoryForm[0].reset();
                        addHistoryModal.close();
                    } else {
                        if (res.error.description) {
                            $('#add-history-form .description-group').addClass('has-error');
                            $('#add-history-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });


        $(document).on('closing', '.remodal', function (e) {
            if (addHistoryModal.getState() == 'closing') {
                addHistoryForm[0].reset();
                $('#add-history-form .description-group').removeClass('has-error');
                $('#add-history-form .message-description').hide();
            }

            if (updateHistoryModal.getState() == 'closing') {
                updateHistoryForm[0].reset();
                $('#update-history-form .description-group').removeClass('has-error');
                $('#update-history-form .message-description').hide();
            }

            if (removeHistoryModal.getState() == 'closing') {
                removeHistoryForm[0].reset();
            }

            if (addSurgeryFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#surgery-file-upload')[0].reset();
            }

            if (addOPRecordFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#oprecord-file-upload')[0].reset();
            }

            if (addLabFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#lab-file-upload')[0].reset();
            }

            if (addReportFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#report-file-upload')[0].reset();
            }

            loader.hide();
        });

        $.fn.dataTable.ext.buttons.add = {
            text: 'Nuevo',
            action: function (e, dt, node, config) {
                addHistoryModal.open();
            }
        };

        historyTable = $('#history-table').DataTable({
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('history-data', $patient->id) !!}',//l
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                'add',
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });


        /*** evolution **/

        $(document).on('click', '.dt-remove-evolution', function (e) {
            var eid = $(this).data('eid');
            $('#remove-eid').val(eid);
        });

        removeEvolutionForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('evolution/remove') !!}',
                method: 'POST',
                data: removeEvolutionForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        evolutionTable.ajax.reload();
                        removeEvolutionForm[0].reset();
                        removeEvolutionModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-evolution', function (e) {
            var eid = $(this).data('eid');
            updateEvolutionForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('evolution') !!}/' + eid,
                method: 'GET',
                success: function (res) {
                    updateEvolutionForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateEvolutionForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-evolution-form .description-group').removeClass('has-error');
            $('#update-evolution-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('evolution/update') !!}',
                data: updateEvolutionForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        evolutionTable.ajax.reload();
                        updateEvolutionForm[0].reset();
                        updateEvolutionModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-evolution-form .description-group').addClass('has-error');
                            $('#update-evolution-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        addEvolutionForm.on('submit', function (e) {
            e.preventDefault();

            $('#add-evolution-form .description-group').removeClass('has-error');
            $('#add-evolution-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('evolution/add') !!}',
                data: addEvolutionForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        evolutionTable.ajax.reload();
                        addEvolutionForm[0].reset();
                        addEvolutionModal.close();
                    } else {
                        if (res.error.description) {
                            $('#add-evolution-form .description-group').addClass('has-error');
                            $('#add-evolution-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });


        $(document).on('closing', '.remodal', function (e) {
            if (addEvolutionModal.getState() == 'closing') {
                addEvolutionForm[0].reset();
                $('#add-evolution-form .description-group').removeClass('has-error');
                $('#add-evolution-form .message-description').hide();
            }

            if (updateEvolutionModal.getState() == 'closing') {
                updateEvolutionForm[0].reset();
                $('#update-evolution-form .description-group').removeClass('has-error');
                $('#update-evolution-form .message-description').hide();
            }

            if (removeEvolutionModal.getState() == 'closing') {
                removeEvolutionForm[0].reset();
            }

            if (addSurgeryFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#surgery-file-upload')[0].reset();
            }

            if (addOPRecordFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#oprecord-file-upload')[0].reset();
            }

            if (addLabFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#lab-file-upload')[0].reset();
            }

            if (addReportFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#report-file-upload')[0].reset();
            }

            loader.hide();
        });

        $.fn.dataTable.ext.buttons.add = {
            text: 'Nuevo',
            action: function (e, dt, node, config) {
                addEvolutionModal.open();
            }
        };

        evolutionTable = $('#evolution-table').DataTable({
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('evolution-data', $patient->id) !!}',//l
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                'add',
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });
    });
</script>
@endpush
