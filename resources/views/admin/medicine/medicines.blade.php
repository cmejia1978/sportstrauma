@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
@endpush

@section('content-classes', 'scrollable')

@section('content')
    <section class="panel panel-default">
        <header class="panel-heading bg-light clearfix">
            <span class="m-t-xs inline">Medicamentos</span>
        </header>
        <table id="medicines-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Medicamento</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th class="all">Acción</th>
            </tr>
            </thead>
        </table>
    </section>
    @include('admin.medicine.new')
    @include('admin.medicine.update')
    @include('admin.medicine.remove')
@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });


        var medicinesTable,
            addMedicineModal    = $('[data-remodal-id=add-medicine]').remodal(),
            addMedicineForm     = $('#add-medicine-form'),
            updateMedicineModal = $('[data-remodal-id=update-medicine]').remodal(),
            updateMedicineForm  = $('#update-medicine-form'),
            removeMedicineModal = $('[data-remodal-id=remove-medicine]').remodal(),
            removeMedicineForm  = $('#remove-medicine-form'),
            loader              = $('.dt-loader');

        $(document).on('click', '.dt-remove-medicine', function(e) {
            var mid = $(this).data('mid');
            $('#remove-mid').val(mid);
        });

        removeMedicineForm.on('submit', function (e) {
            e.preventDefault();

            loader.show();

            $.ajax({
                url: '{!! url('medicines/remove') !!}',
                method: 'POST',
                data: removeMedicineForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        medicinesTable.ajax.reload();
                        removeMedicineForm[0].reset();
                        removeMedicineModal.close();
                    }

                    loader.fadeOut();
                }
            })

        });

        updateMedicineForm.on('submit', function(e) {
            e.preventDefault();

            $('#update-medicine-form .name-group').removeClass('has-error');
            $('#update-medicine-form .message-name').hide();
            loader.show();

            $.ajax({
                url: '{!! url('medicines/update') !!}',
                data: updateMedicineForm.serialize(),
                method: 'POST',
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        medicinesTable.ajax.reload();
                        updateMedicineForm[0].reset();
                        updateMedicineModal.close();
                    } else {
                        if (res.error.name) {
                            $('#update-medicine-form .name-group').addClass('has-error');
                            $('#update-medicine-form .message-name').html(res.error.name).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });

        });

        $(document).on('click', '.dt-update-medicine', function(e) {
            var mid = $(this).data('mid');
            updateMedicineForm.html('');
            loader.show();
            $.ajax({
                url: '{!! url('medicines/info') !!}/' + mid,
                method: 'GET',
                success: function(res) {
                    updateMedicineForm.html(res);
                    loader.fadeOut();
                }
            })
        });

        addMedicineForm.on('submit', function(e) {
            e.preventDefault();

            $('#add-medicine-form .name-group').removeClass('has-error');
            $('#add-medicine-form .message-name').html('').hide();
            loader.show();

            $.ajax({
                url: '{!! url('medicines/add') !!}',
                method: 'POST',
                data: addMedicineForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        addMedicineForm[0].reset();
                        medicinesTable.order( [ 0, 'desc' ] ).draw();
                        addMedicineModal.close();
                    } else {
                        if (res.error.name) {
                            $('#add-medicine-form .name-group').addClass('has-error');
                            $('#add-medicine-form .message-name').html(res.error.name).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            })
        });

        $.fn.dataTable.ext.buttons.add = {
            text: 'Nuevo',
            action: function ( e, dt, node, config ) {
                addMedicineModal.open();
            }
        };

        $.fn.dataTable.ext.buttons.edit = {
            text: 'Editar',
            action: function ( e, dt, node, config ) {
                var row = medicinesTable.row( { selected: true } ),
                    index = medicinesTable.row( { selected: true } ).index(),
                    selected = row.indexes().length !== 0,
                    usrId = medicinesTable.cell(index, 0).data();

                if (selected) {
                    window.location.href = '{{ url('medicines/update') }}/' + usrId;
                }
            }
        };


        medicinesTable = $('#medicines-table').DataTable({
            processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: {
                header: true,
                headerOffset: $('#nav-head').outerHeight()
            },
            responsive: true,
            serverMethod: 'POST',
            ajax: '{!! url('medicines-data') !!}',
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [
                'add',
                'pageLength'
            ],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: {
                "sProcessing":     "Procesando por favor espere...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_ medicamentos",
                "sInfoEmpty":      "Mostrando del 0 al 0 de 0 medicamentos",
                "sInfoFiltered":   "(filtrado de _MAX_ medicamentos)",
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
                        _: "Mostrar %d medicamentos"
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
