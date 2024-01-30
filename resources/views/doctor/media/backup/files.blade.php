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
            <span class="m-t-xs inline">Medios <small>{{ auth()->user()->name }}</small></span>
        </header>
        <table id="files-table"
                class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre Archivo</th>
                <th>Tipo</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acción</th>
            </tr>
            </thead>
        </table>
    </section>
    @include('doctor.media.backup.new')
    @include('doctor.media.backup.remove')
@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone/dropzone.js') }}"></script>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        var filesTable,
            addFileModal    = $('[data-remodal-id=add-file]').remodal(),
            removeFileModal = $('[data-remodal-id=remove-file]').remodal(),
            removeFileForm  = $('#remove-file-form'),
            loader          = $('.dt-loader');

        $(document).on('click', '.dt-remove-file', function(e) {
            var fid = $(this).data('fid');
            $('#remove-fid').val(fid);
        });

        removeFileForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('media/delete') !!}',
                method: 'POST',
                data: removeFileForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        filesTable.order( [ 0, 'desc' ] ).draw();
                        removeFileForm[0].reset();
                        removeFileModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        $(document).on('closing', '.remodal', function (e) {
            if (addFileModal.getState() == 'closing') {
                Dropzone.forElement("#mediaUploadDZ").removeAllFiles(true);
            }

            loader.hide();
        });

        $.fn.dataTable.ext.buttons.add = {
            text: 'Agregar archivo(s)',
            action: function (e, dt, node, config) {
                Dropzone.forElement("#mediaUploadDZ").removeAllFiles(true);
                addFileModal.open();
            }
        };

        $.fn.dataTable.ext.buttons.edit = {
            text: 'Cambiar nombre archivo',
            action: function (e, dt, node, config) {
                var row = filesTable.row({selected: true}),
                        indx = filesTable.row({selected: true}).index(),
                        selected = row.indexes().length !== 0,
                        usrId = filesTable.cell(indx, 0).data();

                if (selected) {
                    window.location.href = '{{ url('patients/update') }}/' + usrId;
                }
            }
        };

        $.fn.dataTable.ext.buttons.remove = {
            text: 'Eliminar archivo',
            action: function (e, dt, node, config) {
                var row = filesTable.row({selected: true}),
                        indx = row.index(),
                        selected = row.indexes().length !== 0,
                        fileId = filesTable.cell(indx, 0).data();

                if (selected) {
                    $deleteModal.modal('show');
                    $inputFileId.val(fileId);
                }
            }
        };

        Dropzone.options.mediaUploadDZ = {
            paramName: "file",
            maxFilesize: 50, // MB,
            acceptedFiles: 'image/jpeg, image/png, video/*, audio/*, .txt, .doc, .docx',
            init: function(e) {
                this.on('error', function(file, res) {
                    $(file.previewElement).find('.dz-error-message').text(res.error);
                });
            },
            queuecomplete: function(file) {
                filesTable.order( [ 0, 'desc' ] ).draw();
            }
        };

        filesTable = $('#files-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('media-data') !!}',
            dom:
            "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                'add',
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'original_filename', name: 'original_filename'},
                {data: 'mime', name: 'mime'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });
    });
</script>
@endpush