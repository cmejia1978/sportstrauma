@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/select2/select2.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/toastr/toastr.css') }}" rel="stylesheet">
@if ($appointment->prescriptions_count == 0)
<style>
    .dt_dl_rcpt, .dt_vw_rcpt, .dt_prt_rcpt, .dt_snd_rcpt { display : none; }
</style>
@endif
@endpush

@section('title')
    Cita No. {{ $appointment->id }}
@endsection

@section('content-classes', '')

@section('content')
    <header class="header bg-white b-b b-light">
        <p class="h3 m-t-xs m-b-xs b-ttl">Cita para el {{ $appointment->start_date_time_fancy }}</p>
    </header>
    <section class="hbox stretch">
        <aside class="aside-lg bg-light lter b-r">
            <section class="vbox">
                <section class="scrollable">
                    <div class="wrapper">
                        <div class="clearfix m-b">
                            <a class="thumb-lg thumb-center m-r" href="{{ url('patients/view', $appointment->patient->id ) }}">
                                <img class="img-circle" src="{{ $appointment->patient->photo }}"></a>
                            <div class="clear text-center">
                                <div class="h3 m-t-xs m-b-xs">{{ $appointment->patient->short_name }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="line"></div>
                            <small class="text-uc text-xs text-muted">Información - cita</small>
                            <ul class="list-unstyled inf-list">
                                <li>
                                    <i class="fa fa-calendar user-profile-icon"></i> {{ $appointment->start_date }}
                                </li>
                                <li>
                                    <i class="fa fa-clock-o user-profile-icon"></i> {{ $appointment->start_time }}
                                </li>
                                <li>
                                    <i class="fa fa-circle-o-notch user-profile-icon"></i> {{ $appointment->duration }}
                                </li>

                            </ul>
                            <div class="line"></div>
                            <small class="text-uc text-xs text-muted">Información - contacto</small>
                            <ul class="list-unstyled inf-list">
                                <li>
                                    <i class="fa fa-phone user-profile-icon"></i> <a
                                            href="tel:{{ $appointment->patient->pref_phone_num }}">{{ $appointment->patient->pref_phone_num }}</a>
                                </li>
                                <li>
                                    <i class="fa fa-phone-square user-profile-icon"></i> <a
                                            href="tel:{{ $appointment->patient->pref_phone_num }}">{{ $appointment->patient->pref_phone_num }}</a>
                                </li>
                                <li>
                                    <i class="fa fa-envelope user-profile-icon"></i> <a
                                            href="mailto:{{ $appointment->patient->email }}">{{ $appointment->patient->email }}</a>
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
                <header class="header bg-light bg-gradient">
                    <ul class="nav nav-tabs nav-white">
                        @if (Auth::user()->id != 3)
                            <li class="active"><a data-toggle="tab" href="#prescriptions">Receta</a></li>
                        @endif
                        <li class="{{ Auth::user()->id == 3 ? 'active' : '' }}"><a data-toggle="tab" href="#media-files">Medios</a></li>
                        <!--<li class=""><a data-toggle="tab" href="#feedback">Bitácora</a></li>-->
                        <li class=""><a data-toggle="tab" href="#notes">Notas para el paciente</a></li>
                    </ul>
                </header>
                <section class="scrollable">
                    <div class="tab-content">
                        @if (Auth::user()->id != 3)
                            <div id="prescriptions" class="tab-pane active">
                                <section class="panel panel-default panel-nbd">
                                    <table id="prescriptions-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Medicamento</th>
                                            <th>Creado</th>
                                            <th>Actualizado</th>
                                            <th class="all">Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </section>
                            </div>
                        @endif
                        <div id="media-files" class="tab-pane {{ Auth::user()->id == 3 ? 'active' : '' }}">
                            <section class="panel panel-default panel-nbd">
                                <table id="appointment-files-table"
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
                        <div id="feedback" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="feedback-table"
                                        class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                        width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th class="all">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </section>
                        </div>
                        <div id="notes" class="tab-pane">
                            <section class="panel panel-default panel-nbd">
                                <table id="notes-table"
                                        class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                        width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripción</th>
                                        <th class="all">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
            <div class="remodal-bg"></div>
            @include('doctor.patient.prescription.new', ['appointment' => $appointment, 'medicines' => $medicines])
            @include('doctor.patient.prescription.update')
            @include('doctor.patient.prescription.remove')

            @include('doctor.media.appointment.new', ['appointment' => $appointment])
            @include('doctor.media.appointment.remove', ['appointment' => $appointment])
            @include('doctor.media.appointment.update')

            @include('doctor.patient.feedback.new', ['appointment' => $appointment])
            @include('doctor.patient.feedback.update')
            @include('doctor.patient.feedback.remove')

            @include('doctor.patient.note.new', ['appointment' => $appointment])
            @include('doctor.patient.note.update')
            @include('doctor.patient.note.remove')

            @include('doctor.media.view')
        </aside>
    </section>
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
            <input type="hidden" name="aid[]" value="{{ $appointment->id }}">
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
<script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>
<script>
    (function(){if(jQuery&&jQuery.fn&&jQuery.fn.select2&&jQuery.fn.select2.amd)var e=jQuery.fn.select2.amd;return e.define("select2/i18n/es",[],function(){return{errorLoading:function(){return"La carga falló"},inputTooLong:function(e){var t=e.input.length-e.maximum,n="Por favor, elimine "+t+" car";return t==1?n+="ácter":n+="acteres",n},inputTooShort:function(e){var t=e.minimum-e.input.length,n="Por favor, introduzca "+t+" car";return t==1?n+="ácter":n+="acteres",n},loadingMore:function(){return"Cargando más resultados…"},maximumSelected:function(e){var t="Sólo puede seleccionar "+e.maximum+" elemento";return e.maximum!=1&&(t+="s"),t},noResults:function(){return"No se encontraron resultados"},searching:function(){return"Buscando…"}}}),{define:e.define,require:e.require}})();
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


        if ($.fn.select2) {
            $("#input-medicine").select2({language: 'es'});
        }
        var prescriptionsTable,
            appointmentFilesTable,
            feedbackTable,
            notesTable,
            addPrescriptionModal    = $('[data-remodal-id=add-prescription]').remodal(),
            addPrescriptionForm     = $('#add-prescription-form'),
            updatePrescriptionModal = $('[data-remodal-id=update-prescription]').remodal(),
            updatePrescriptionForm  = $('#update-prescription-form'),
            removePrescriptionModal = $('[data-remodal-id=remove-prescription]').remodal(),
            removePrescriptionForm  = $('#remove-prescription-form'),

            addAppointmentFileModal         = $('[data-remodal-id=add-appointment-file]').remodal(),
            removeAppointmentFileModal      = $('[data-remodal-id=remove-appointment-file]').remodal(),
            removeAppointmentFileForm       = $('#remove-appointment-file-form'),
            updateAppointmentFileModal      = $('[data-remodal-id=update-appointment-file]').remodal(),
            updateAppointmentFileForm       = $('#update-appointment-file-form'),

            addFeedbackModal        = $('[data-remodal-id=add-feedback]').remodal(),
            addFeedbackForm         = $('#add-feedback-form'),
            updateFeedbackModal     = $('[data-remodal-id=update-feedback]').remodal(),
            updateFeedbackForm      = $('#update-feedback-form'),
            removeFeedbackModal     = $('[data-remodal-id=remove-feedback]').remodal(),
            removeFeedbackForm      = $('#remove-feedback-form'),

            addNoteModal            = $('[data-remodal-id=add-note]').remodal(),
            addNoteForm             = $('#add-note-form'),
            updateNoteModal         = $('[data-remodal-id=update-note]').remodal(),
            updateNoteForm          = $('#update-note-form'),
            removeNoteModal         = $('[data-remodal-id=remove-note]').remodal(),
            removeNoteForm          = $('#remove-note-form'),

            loader                  = $('.dt-loader');

        $(document).on('closing', '.remodal', function (e) {
            if (addPrescriptionModal.getState() == 'closing') {
                addPrescriptionForm[0].reset();

                clearPrescriptionFields();
            }

            if (updatePrescriptionModal.getState() == 'closing') {
                updatePrescriptionForm[0].reset();

                clearPrescriptionFields();
            }

            if (addAppointmentFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#appointment-file-upload')[0].reset();
            }


            if (addFeedbackModal.getState() == 'closing') {
                addFeedbackForm[0].reset();
                $('#add-feedback-form .description-group').removeClass('has-error');
                $('#add-feedback-form .message-description').hide();
            }

            if (updateNoteModal.getState() == 'closing') {
                updateNoteForm[0].reset();
                $('#update-note-form .description-group').removeClass('has-error');
                $('#update-note-form .message-description').hide();
            }

            if (removeNoteModal.getState() == 'closing') {
                removeNoteForm[0].reset();
            }


            if (addNoteModal.getState() == 'closing') {
                addNoteForm[0].reset();
                $('#add-note-form .description-group').removeClass('has-error');
                $('#add-note-form .message-description').hide();
            }

            if (updateNoteModal.getState() == 'closing') {
                updateNoteForm[0].reset();
                $('#update-note-form .description-group').removeClass('has-error');
                $('#update-note-form .message-description').hide();
            }

            if (removeNoteModal.getState() == 'closing') {
                removeNoteForm[0].reset();
            }


            loader.hide();
        });


        /*** notes **/

        $(document).on('click', '.dt-remove-note', function(e) {
            var nid = $(this).data('nid');
            $('#remove-note-nid').val(nid);
        });

        removeNoteForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('notes/remove') !!}',
                method: 'POST',
                data: removeNoteForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        notesTable.ajax.reload();
                        removeNoteForm[0].reset();
                        removeNoteModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-note', function(e) {
            var nid = $(this).data('nid');
            updateNoteForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('notes') !!}/' + nid,
                method: 'GET',
                success: function(res) {
                    updateNoteForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateNoteForm.on('submit', function(e) {
            e.preventDefault();

            $('#update-note-form .description-group').removeClass('has-error');
            $('#update-note-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('notes/update') !!}',
                data: updateNoteForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        notesTable.ajax.reload();
                        updateNoteForm[0].reset();
                        updateNoteModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-note-form .description-group').addClass('has-error');
                            $('#update-note-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        addNoteForm.on('submit', function(e){
            e.preventDefault();

            $('#add-note-form .description-group').removeClass('has-error');
            $('#add-note-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('notes/add') !!}',
                data: addNoteForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        notesTable.order( [ 0, 'desc' ] ).draw();
                        addNoteForm[0].reset();
                        addNoteModal.close();
                    } else {
                        if (res.error.description) {
                            $('#add-note-form .description-group').addClass('has-error');
                            $('#add-note-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });


        notesTable = $('#notes-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('notes-data', $appointment->id) !!}',
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                { text: 'Nuevo', action: function ( e, dt, node, config ) { addNoteModal.open(); } },
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });

        /*** feedback **/

        $(document).on('click', '.dt-remove-feedback', function(e) {
            var fid = $(this).data('fid');
            $('#remove-feedback-fid').val(fid);
        });

        removeFeedbackForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('feedback/remove') !!}',
                method: 'POST',
                data: removeFeedbackForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        feedbackTable.ajax.reload();
                        removeFeedbackForm[0].reset();
                        removeFeedbackModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-feedback', function(e) {
            var fid = $(this).data('fid');
            updateFeedbackForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('feedback') !!}/' + fid,
                method: 'GET',
                success: function(res) {
                    updateFeedbackForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateFeedbackForm.on('submit', function(e) {
            e.preventDefault();

            $('#update-feedback-form .description-group').removeClass('has-error');
            $('#update-feedback-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('feedback/update') !!}',
                data: updateFeedbackForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        feedbackTable.ajax.reload();
                        updateFeedbackForm[0].reset();
                        updateFeedbackModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-feedback-form .description-group').addClass('has-error');
                            $('#update-feedback-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        addFeedbackForm.on('submit', function(e){
            e.preventDefault();

            $('#add-feedback-form .description-group').removeClass('has-error');
            $('#add-feedback-form .message-description').hide();
            loader.show();

            $.ajax({
                url: '{!! url('feedback/add') !!}',
                data: addFeedbackForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        feedbackTable.order( [ 0, 'desc' ] ).draw();
                        addFeedbackForm[0].reset();
                        addFeedbackModal.close();
                    } else {
                        if (res.error.description) {
                            $('#add-feedback-form .description-group').addClass('has-error');
                            $('#add-feedback-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });


        feedbackTable = $('#feedback-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('feedback-data', $appointment->id) !!}',
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                { text: 'Nuevo', action: function ( e, dt, node, config ) { addFeedbackModal.open(); } },
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });



        /*** files **/

        $(document).on('click', '.dt-remove-appointment-file', function (e) {
            var fid = $(this).data('fid');
            $('#remove-appointment-fid').val(fid);
        });

        removeAppointmentFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/appointment/delete') !!}',
                method: 'POST',
                data: removeAppointmentFileForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        appointmentFilesTable.ajax.reload();
                        removeAppointmentFileForm[0].reset();
                        removeAppointmentFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-update-appointment-file', function (e) {
            var fid = $(this).data('fid');
            updateAppointmentFileForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('media/appointment') !!}/' + fid,
                method: 'GET',
                success: function (res) {
                    updateAppointmentFileForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateAppointmentFileForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-appointment-file-form .description-group').removeClass('has-error');
            $('#update-appointment-file-form .message-description').hide();
            $('#update-appointment-file-form .message-category').hide();

            loader.show();

            $.ajax({
                url: '{!! url('media/appointment/update') !!}',
                data: updateAppointmentFileForm.serialize(),
                method: 'POST',
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        appointmentFilesTable.ajax.reload();
                        updateAppointmentFileForm[0].reset();
                        updateAppointmentFileModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-appointment-file-form .description-group').addClass('has-error');
                            $('#update-appointment-file-form .message-description').html(res.error.description).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        $(document).on('click', '.dt-view-appointment-file', function (e) {
            e.preventDefault();
            var _this = $(this),
                fid   = _this.data('fid');

            $('#file-viewer-container').html('');
            loader.fadeIn();

            $.ajax({
                url: '{{ url('media/appointment/view') }}',
                method: 'POST',
                data: {fid: fid},
                success: function (res) {
                    $('#file-viewer-container').html(res);

                    loader.hide();
                }
            });
        });


        $('#appointment-file-upload').fileupload({
            previewMaxHeight: 200,
            previewMaxWidth: 300,
            previewCrop: true,
            uploadTemplateId: 'general-template-upload',
            downloadTemplateId: 'general-template-download',
            url: '{{ url('media/appointment/upload') }}',
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
                appointmentFilesTable.order([0, 'desc']).draw();
            }
        });

        $('#lab-file-upload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

        appointmentFilesTable = $('#appointment-files-table').DataTable({
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
                url: '{!! url('media-appointment-data') !!}',
                data: function (d) {
                    d.aid      = '{{ $appointment->id }}';
                }
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                {
                    text: 'Agregar archivo(s)',
                    action: function (e, dt, node, config) {
                        addAppointmentFileModal.open();
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


        // **** prescriptions **//
        function clearPrescriptionFields() {
            $('#add-prescription-form .medicine-group').removeClass('has-error');
            $('#add-prescription-form .message-medicine').hide();
            $('#add-prescription-form .indication-group').removeClass('has-error');
            $('#add-prescription-form .message-indication').hide();

            $('#update-prescription-form .medicine-group').removeClass('has-error');
            $('#update-prescription-form .message-medicine').hide();
            $('#update-prescription-form .indication-group').removeClass('has-error');
            $('#update-prescription-form .message-indication').hide();
        }


        removePrescriptionForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('prescriptions/remove') !!}',
                method: 'POST',
                data: removePrescriptionForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        prescriptionsTable.ajax.reload();
                        prescriptionsTable.draw(false);
                        removePrescriptionForm[0].reset();
                        removePrescriptionModal.close();
                        var len = prescriptionsTable.data().length - 1;
                        if (len <= 0) {
                            $('.dt_dl_rcpt').css("display","none");
                            $('.dt_vw_rcpt').css("display","none");
                            $('.dt_snd_rcpt').css("display","none");
                        }
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('click', '.dt-remove-prescription', function(e) {
            var psid = $(this).data('psid');
            $('#remove-psid').val(psid);
        });

        updatePrescriptionForm.on('submit', function(e) {
            e.preventDefault();

            clearPrescriptionFields();
            loader.show();

            $.ajax({
                url: '{{ url('prescriptions/update') }}',
                method: 'POST',
                data: updatePrescriptionForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        prescriptionsTable.ajax.reload();
                        updatePrescriptionForm[0].reset();
                        updatePrescriptionModal.close();
                    } else {

                        if (res.error.medicine) {
                            $('#update-prescription-form .medicine-group').addClass('has-error');
                            $('#update-prescription-form .message-medicine').html(res.error.medicine).fadeIn();
                        }

                        if (res.error.indication) {
                            $('#update-prescription-form .indication-group').addClass('has-error');
                            $('#update-prescription-form .message-indication').html(res.error.indication).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            })
        });

        $(document).on('click', '.dt-update-prescription', function(e) {
            var psid = $(this).data('psid');
            updatePrescriptionForm.html('');

            loader.show();
            $.ajax({
                url: '{!! url('prescriptions/info') !!}/' + psid,
                method: 'GET',
                success: function(res) {
                    updatePrescriptionForm.html(res.info);
                    if ($.fn.select2) { $("#input-update-medicine").select2({language: 'es'}); }
                    $("#input-update-medicine").val(res.prescription.medicine_id).trigger("change");
                    loader.fadeOut();
                }
            })
        });

        addPrescriptionForm.on('submit', function(e) {
            e.preventDefault();

            clearPrescriptionFields();
            loader.show();

            $.ajax({
                url: '{{ url('prescriptions/add') }}',
                method: 'POST',
                data: addPrescriptionForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        @if ($appointment->prescriptions_count == 0)
                        $('.dt_dl_rcpt').css("display","inline-block");
                        $('.dt_vw_rcpt').css("display","inline-block");
                        $('.dt_prt_rcpt').css("display","inline-block");
                        $('.dt_snd_rcpt').css("display","inline-block");
                        @endif
                        loader.fadeOut();
                        prescriptionsTable.order( [ 0, 'desc' ] ).draw();
                        addPrescriptionForm[0].reset();
                        addPrescriptionModal.close();
                    } else {
                        if (res.error.medicine) {
                            $('#add-prescription-form .medicine-group').addClass('has-error');
                            $('#add-prescription-form .message-medicine').html(res.error.medicine).fadeIn();
                        }

                        if (res.error.indication) {
                            $('#add-prescription-form .indication-group').addClass('has-error');
                            $('#add-prescription-form .message-indication').html(res.error.indication).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            })
        });

        prescriptionsTable = $('#prescriptions-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('prescriptions-data', $appointment->id   ) !!}',
            dom:
            "<'row'<'col-sm-12'B><'col-sm-12'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                { text: 'Agregar medicamento a receta', action: function ( e, dt, node, config ) { addPrescriptionModal.open(); } },
                { text: 'Descargar receta', className: 'dt_dl_rcpt', action: function ( e, dt, node, config ) { window.location.href = '{{ url('prescriptions/pdf/download', $appointment->id) }}'; } },
                { text: 'Ver receta', className: 'dt_vw_rcpt', action: function ( e, dt, node, config ) { window.open('{{ url('prescriptions/pdf/view', $appointment->id) }}', '_blank'); } },
                { text: 'Imprimir receta', className: 'dt_prt_rcpt', action: function ( e, dt, node, config ) { window.open('{{ url('prescriptions/pdf/print', $appointment->id) }}', '_blank'); } },
                { text: 'Enviar receta al paciente', className: 'dt_snd_rcpt',
                    action: function ( e, dt, node, config ) {
                        $.ajax({
                            url: '{{ url('prescriptions/pdf/send') }}',
                            data: { aid: '{{ $appointment->id }}'},
                            method: 'POST',
                            success: function(res) {
                                if (res.success) {
                                    toastr.success('El correo ha sido enviado');
                                } else {
                                    toastr.error('Error al enviar el correo');
                                }
                            }
                        });
                    }},
                'pageLength'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'medicine_id', name: 'medicine_id'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT,
            drawCallback: function( settings ) {

            }
        });
    });
</script>
@endpush
