@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
@endpush

@section('content-classes', 'wrapper')

@section('content')

    <section class="panel panel-default">
        <header class="panel-heading bg-light clearfix">
            <span class="m-t-xs inline">Medicamentos</span>
        </header>
        <table id="medicines-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Creado</th>
                <th>Actualizado</th>
            </tr>
            </thead>
        </table>
    </section>
    <div id="user-delete-dialog" aria-hidden="true" role="dialog" tabindex="-1" class="modal fade in">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span>
                    </button>
                    <h4 id="myModalLabel" class="modal-title">Eliminar usuario</h4>
                </div>
                <div class="modal-body">
                    <p>¿Confirma que desea eliminar a este usuario?</p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                    <button class="btn btn-primary" type="button">Aceptar</button>
                </div>

            </div>
        </div>
    </div>
    <!--<div id="user-delete-dialog" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>-->
@endsection

@push('scripts')
    <!-- Datatables-->
    <script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
    <script>
        var editor;
        $(function() {
            var usersTable;
            $.fn.dataTable.ext.buttons.add = {
                text: 'Nuevo',
                action: function ( e, dt, node, config ) {
                    window.location.href = '{{ url('admin/users/add') }}';
                }
            };

            $.fn.dataTable.ext.buttons.edit = {
                text: 'Editar',
                action: function ( e, dt, node, config ) {
                    var row = usersTable.row( { selected: true } ),
                            indx = usersTable.row( { selected: true } ).index(),
                            selected = row.indexes().length !== 0,
                            usrId = usersTable.cell(indx, 0).data();

                    if (selected) {
                        window.location.href = '{{ url('admin/users/update') }}/' + usrId;
                    }
                }
            };

            $.fn.dataTable.ext.buttons.remove = {
                text: 'Eliminar',
                action: function ( e, dt, node, config ) {
                    var row = usersTable.row( { selected: true } ),
                            indx = row.index(),
                            selected = row.indexes().length !== 0,
                            usrId = usersTable.cell(indx, 0).data();

                    if (selected) {
                        window.location.href = '{{ url('admin/users/remove') }}/' + usrId;
                    }
                }
            };

            usersTable = $('#users-table').DataTable({
                //processing: true,
                stateSave: true,
                serverSide: true,
                fixedHeader: true,
                select: {
                    style: 'single'
                },
                ajax: '{!! url('admin/users-data') !!}',
                dom: "Bfrtip",
                buttons: [
                    'add',
                    'edit',
                    'remove'
                ],
                columns: [
                    { data: 'id', name: 'users.id' },
                    { data: 'name', name: 'users.name' },
                    { data: 'email', name: 'users.email' },
                    { data: 'rolename', name: 'roles.name'  },
                    { data: 'created_at', name: 'users.created_at' },
                    { data: 'updated_at', name: 'users.updated_at' }
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
