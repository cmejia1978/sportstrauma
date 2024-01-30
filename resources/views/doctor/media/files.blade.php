@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
@endpush

@section('content-classes', 'scrollable')

@section('title')
    Medios - {{ auth()->user()->name }}
@endsection

@section('content')
    <section class="panel panel-default">
        <header class="panel-heading bg-light clearfix">
            <span class="m-t-xs inline">Medios <small> {{ auth()->user()->name }}</small></span>
        </header>
        <table id="general-files-table"
               class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
               width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Preview</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Paciente</th>
                <th>Tipo Archivo</th>
                <th>Creado</th>
                <th>Acción</th>
            </tr>
            </thead>
        </table>
    </section>
    @include('doctor.media.view');

    @include('doctor.media.new')
    @include('doctor.media.remove')
    @include('doctor.media.update')
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
            <div class="form-group">
                <label class="control-label" for="input-general-file-description-{%=i%}">Descripción</label>
                <input id="input-general-file-description-{%=i%}" class="form-control" name="description[]" placeholder="Descripción" data-inid="input-general-file-description-group-{%=i%}" data-required="yes">
                <span class="help-block"></span>
            </div>
            <div class="form-group general-file-category-{%=i%}">
                <label class="control-label" for="input-general-file-category-{%=i%}">Categoría</label>
                <select id="input-general-file-category-{%=i%}" class="form-control" name="category[]">
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
             <div class="form-group general-file-patient-{%=i%}">
                <label class="control-label" for="input-general-file-patient-{%=i%}">Paciente</label>
                <select id="input-general-file-patient-{%=i%}" class="form-control" name="patient[]">
                    <option value="0">Ninguno</option>
                    @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->full_name }}</option>
                    @endforeach
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
<script src="{{ asset('assets/js/blueimp/tmpl.min.js') }}"></script>
<script src="{{ asset('assets/js/blueimp/load-image.all.min.js') }}"></script>
<script src="{{ asset('assets/js/blueimp/canvas-to-blob.min.js') }}"></script>
<script src="{{ asset('assets/js/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-image.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-audio.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-video.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-validate.js') }}"></script>
<script src="{{ asset('assets/js/jquery-file-upload/jquery.fileupload-ui.js') }}"></script>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        var generalFilesTable,
            addGeneralFileModal    = $('[data-remodal-id=add-general-file]').remodal(),
            removeGeneralFileModal = $('[data-remodal-id=remove-general-file]').remodal(),
            removeGeneralFileForm  = $('#remove-general-file-form'),
            fileViewer             = $('[data-remodal-id=file-viewer]').remodal(),
            updateGeneralFileModal = $('[data-remodal-id=update-general-file]').remodal(),
            updateGeneralFileForm  = $('#update-general-file-form'),
            generalFileStatus      = 'Todos',
            generalFilePatient     = 'Todos',
            loader                 = $('.dt-loader');



        /***jquery file upload surgery media*/

        $(document).on('click', '.dt-update-general-file', function(e) {
            var fid = $(this).data('fid');
            updateGeneralFileForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('media/general') !!}/' + fid,
                method: 'GET',
                success: function(res) {
                    updateGeneralFileForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        updateGeneralFileForm.on('submit', function(e) {
            e.preventDefault();

            $('#update-general-file-form .description-group').removeClass('has-error');
            $('#update-general-file-form .message-description').hide();
            $('#update-general-file-form .category-group').removeClass('has-error');
            $('#update-general-file-form .message-category').hide();

            loader.show();

            $.ajax({
                url: '{!! url('media/general/update') !!}',
                data: updateGeneralFileForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        generalFilesTable.ajax.reload();
                        updateGeneralFileForm[0].reset();
                        updateGeneralFileModal.close();
                    } else {
                        if (res.error.description) {
                            $('#update-general-file-form .description-group').addClass('has-error');
                            $('#update-general-file-form .message-description').html(res.error.description).fadeIn();
                        }

                        if (res.error.category) {
                            $('#update-general-file-form .category-group').addClass('has-error');
                            $('#update-general-file-form .message-category').html(res.error.category).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        $(document).on('click', '.dt-view-general-file', function (e) {
            e.preventDefault();
            var _this = $(this),
                fid   = _this.data('fid');

            $('#file-viewer-container').html('');
            loader.fadeIn();

            $.ajax({
                url: '{{ url('media/general/view') }}',
                method: 'POST',
                data: { fid: fid },
                success: function(res) {
                    $('#file-viewer-container').html(res);

                    loader.hide();
                }
            });
        });


        $('#general-file-upload').fileupload({
            previewMaxHeight: 200,
            previewMaxWidth: 300,
            previewCrop: true,
            uploadTemplateId: 'general-template-upload',
            downloadTemplateId: 'general-template-download',
            url: '{{ url('media/general/upload') }}',
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            maxFileSize: 1073741824,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|bmp|dds|png|psd|pspimage|tif?f|yuv|wmv|vob|swf|srt|rm|mpg|mov|m4v|flv|avi|asf|3gp|3g2|mp4|wma|wav|mpa|mid|m4a|m3u|iff|aif|mp3|xml|tar|sdf|pptx|ppt|pps|keychain|key|ged|dat|csv|txt|doc?x|log|msg|otd|pages|rtf|tex|wpd|wps|7z|cbr|deb|gz|pkg|rar|rpm|sitx|gz|zip?x|pdf|pct|indd)$/i,
            messages: {
                maxNumberOfFiles: 'Número máximo de archivos excedido',
                acceptFileTypes: 'Tipo de archivo no permitido',
                maxFileSize: 'El archivo es demasiado grande',
                minFileSize: 'El archivo es demasiado pequeño'
            },
            submit: function (e, data) {
                var inputs     = data.context.find(':input'),
                    validInput = true;
                inputs.each(function(index) {
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
                generalFilesTable.order( [ 0, 'desc' ] ).draw();
            }
        });

        $('#general-file-upload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

        $(document).on('click', '.dt-remove-general-file', function (e) {
            var fid = $(this).data('fid');
            $('#remove-general-fid').val(fid);
        });

        removeGeneralFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/general/delete') !!}',
                method: 'POST',
                data: removeGeneralFileForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        generalFilesTable.ajax.reload();
                        removeGeneralFileForm[0].reset();
                        removeGeneralFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        generalFilesTable = $('#general-files-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            deferRender: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: {
                url: '{!! url('media-general-data') !!}',
                data: function (d) {
                    d.category = generalFileStatus;
                    d.patient  = generalFilePatient;
                }
            },
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                {
                    text: 'Agregar archivo(s)',
                    action: function (e, dt, node, config) {
                        addGeneralFileModal.open();
                    }
                },
                {
                    extend: 'collection',
                    text: 'Filtrar por categoría',
                    autoClose: true,
                    buttons:[{text:'Todos',action:function(e,dt,node,config){generalFileStatus='Todos';generalFilesTable.draw();}},{text:'Artroscopia de Hombro',action:function(e,dt,node,config){generalFileStatus='Artroscopia de Hombro';generalFilesTable.draw();}},{text:'Artroscopia de Codo',action:function(e,dt,node,config){generalFileStatus='Artroscopia de Codo';generalFilesTable.draw();}},{text:'Artroscopia de Rodilla',action:function(e,dt,node,config){generalFileStatus='Artroscopia de Rodilla';generalFilesTable.draw();}},{text:'Artroscopia de Tobillo',action:function(e,dt,node,config){generalFileStatus='Artroscopia de Tobillo';generalFilesTable.draw();}},{text:'Corrección quirúrgica',action:function(e,dt,node,config){generalFileStatus='Corrección quirúrgica';generalFilesTable.draw();}},{text:'Reparación quirúrgica',action:function(e,dt,node,config){generalFileStatus='Reparación quirúrgica';generalFilesTable.draw();}},{text:'Osteosíntesis',action:function(e,dt,node,config){generalFileStatus='Osteosíntesis';generalFilesTable.draw();}},{text:'Artroplastia de Hombro',action:function(e,dt,node,config){generalFileStatus='Artroplastia de Hombro';generalFilesTable.draw();}},{text:'Artroplastia de Rodilla',action:function(e,dt,node,config){generalFileStatus='Artroplastia de Rodilla';generalFilesTable.draw();}},{text:'Otros',action:function(e,dt,node,config){generalFileStatus='Otros';generalFilesTable.draw();}}],
                    fade: true
                },
                {
                    extend: 'collection',
                    text: 'Filtrar por paciente',
                    autoClose: true,
                    buttons:[
                            {text:'Todos',action:function(e,dt,node,config){generalFilePatient='Todos';generalFilesTable.draw();}},
                            @foreach ($patients as $patient)
                            {text: '{{ $patient->full_name }}',action:function(e,dt,node,config){generalFilePatient='{{ $patient->id }}';generalFilesTable.draw();}},
                            @endforeach
                    ],
                    fade: true
                },
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
                {data: 'description', name: 'description'},
                {data: 'file_category', name: 'file_category'},
                {data: 'patient_id', name: 'patient_id'},
                {data: 'mime', name: 'mime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: {
                "sProcessing":     "Procesando por favor espere...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_ archivos",
                "sInfoEmpty":      "Mostrando del 0 al 0 de 0 archivos",
                "sInfoFiltered":   "(filtrado de _MAX_ archivos)",
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
                        _: "Mostrar %d archivos"
                    }
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        $(document).on('closing', '.remodal', function (e) {
            if (fileViewer.getState() == 'closing') {
                $('#file-viewer-container').empty();
                /*var drplayer = $('#dr-media-player');
                drplayer.attr('src', '');*/
            }

            if (addGeneralFileModal.getState() == 'closing') {
                $('table tbody.files').empty();
                $('#general-file-upload')[0].reset();
            }

            loader.hide();
        });
    });
</script>
@endpush