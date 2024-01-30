@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Usuarios</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="users-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<!--Appended scripts-->
<!-- Datatables-->
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<!--<script src="{{ asset('assets/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.tools.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.editor.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables/dataTables.scroller.min.js') }}"></script>-->


<!-- pace -->
<!--<script src="{{ asset('assets/js/pace/pace.min.js') }}"></script>-->
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
            language: spanishDT
        });
    });
</script>
@endpush
