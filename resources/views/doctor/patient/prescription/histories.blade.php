@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
@endpush

@section('content-classes', 'wrapper')

@section('content')
    <!--<div class="m-b-md">
        <h3 class="m-b-none">Pacientes</h3>
    </div>-->
    <section class="panel panel-default">
        <header class="panel-heading bg-light clearfix">
            <span class="m-t-xs inline">Fullcalendar</span>
        </header>
        <table id="history-table" class="table table-striped dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
            <thead>
            <tr>
                <th>ID {{ $patient->id }}</th>
                <th>Descripción</th>
                <th class="all">Acción</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script>
    var editor;
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $.fn.dataTable.ext.buttons.add = {
            text: 'Nuevo',
            action: function (e, dt, node, config) {
                window.location.href = '{{ url('patients/add') }}';
            }
        };

        var patientsTable = $('#history-table').DataTable({
            //processing: true,
            stateSave: true,
            serverSide: true,
            fixedHeader: true,
            responsive: true,
            /*select: {
                style: 'single'
            },*/
            lengthMenu: [[1, 10, 25, 50], [1, 10, 25, 50,]],
            serverMethod: 'POST',
            ajax: '{!! url('history-data') !!}',//l
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
            //"<'row'<'col-sm-2'l>>"+
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",//"Bfrtip",
            //paginationType: 'full_numbers',
            /*columnDefs: [
                {targets: '-1',
                className: 'all',}
            ],*/
            buttons: [
                'add',
                'pageLength'
            ],

            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            language: spanishDT
        });
    });
</script>
@endpush
