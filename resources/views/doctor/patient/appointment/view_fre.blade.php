@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
@endpush

@section('content-classes', 'scrollable')

@section('content')
    <section class="panel panel-default text-left" style="margin-bottom: 0;">
        <header class="panel-heading font-bold">Detalles de la cita <span class="pull-right">{{ $appointment->start_date_time_fancy  }}</span></header>
        <div class="bg-light dk wrapper">
            <span class="pull-right">{{ ucfirst($appointment->start_until) }}</span>
            <span class="h4">{{ $appointment->doctor['name'] }}<br>
            <small class="text-muted"><i class="fa fa-clock-o"></i> {{ $appointment->duration }}</small>
        </span>
        </div>
        <div class="panel-body" style="padding: 0;">
            <div class="text-center" style="margin-top: 10px;">
                <span class="h5 block text-bold">Información sobre la cita</span>
            </div>
            <div class="line" style="margin-bottom: 0;"></div>
            <aside class="bg-white">
                <section class="vbox">
                    <header class="header bg-light bg-gradient">
                        <ul class="nav nav-tabs nav-white" id="tabs-app">
                            @if ($patient->doctor['id'] != 3 && $appointment->prescriptions_count > 0)
                            <li class="active"><a data-toggle="tab" href="#prescriptions">Receta</a></li>
                            @endif
                            <li class="{{ $patient->doctor['id'] == 3 ? 'active' : ($patient->doctor['id'] != 3 && $appointment->prescriptions_count == 0) ? 'active' : '' }}">
                                <a data-toggle="tab" href="#notes">Notas</a>
                            </li>
                        </ul>
                    </header>
                    <div class="scrollable" style="max-height: 300px;">
                        <div class="tab-content">
                            <div class="tab-content">
                                @if ($patient->doctor['id'] != 3 && $appointment->prescriptions_count > 0)
                                <div id="prescriptions" class="tab-pane active">
                                    <section class="panel panel-default panel-nbd" style="min-height: 172px;">
                                        <table id="prescriptions-table" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Medicamento</th>
                                                <th>Indicación</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </section>
                                </div>
                                @endif
                                <div id="notes" class="tab-pane {{ $patient->doctor['id'] == 3 ? 'active' : ($patient->doctor['id'] != 3 && $appointment->prescriptions_count == 0) ? 'active' : '' }}">
                                    <section class="panel panel-default panel-nbd" style="min-height: 172px;">
                                        <table id="notes-table"
                                               class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th>Descripción</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script>
    $(function () {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
        {{ Hashids::setDefaultConnection('patient_appointment') }}

        var aid = '{{ Hashids::encode($appointment->id) }}';
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

        @if (Auth::user()->id != 3 && $appointment->prescriptions_count > 0)
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
                { text: 'Descargar receta', action: function ( e, dt, node, config ) { window.location.href = '{{ url('patient/prescriptions/pdf/download') }}/' + aid; } },
                'pageLength'
            ],
            columns: [
                {data: 'medicine_id', name: 'medicine_id'},
                {data: 'indication', name: 'indication'},
            ],
            language: spanishDT
        });
        @endif
    });
</script>
@endpush