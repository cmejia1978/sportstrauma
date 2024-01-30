@extends('layouts.app')

@section('title', 'Inicio')

@push('styles')
<link href="{{ asset('assets/js/calendar/bootstrap_calendar.css') }}" rel="stylesheet">
@role ('patient')
<link href="{{ asset('assets/js/datatables/datatablescm.min.css') }}" rel="stylesheet">
@endrole
@endpush


@section('content-classes', 'scrollable padder')

@section('content')

    <div class="m-b-md">
        <h3 class="m-b-none">Sportrauma Center</h3>
        <small>Bienvenido, {{ Auth::user()->name}}</small>
    </div>
    @role ('admin|doctor')
    <section class="panel panel-default">
        <div class="row m-l-none m-r-none bg-light lter">
            @if (Auth::user()->id != 3)
                <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                      <i class="fa fa-circle fa-stack-2x text-info"></i>
                      <i class="fa fa-user-md fa-stack-1x text-white"></i>
                    </span>
                    <a href="{{ url('patients') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong>{{ $patients->count() }}</strong></span>
                        <small class="text-muted text-uc">Pacientes</small>
                    </a>
                </div>
                <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                      <i class="fa fa-circle fa-stack-2x text-warning"></i>
                      <i class="fa fa-files-o fa-stack-1x text-white"></i>
                      <span data-update="3000" data-target="#bugs" data-animate="2000" data-line-cap="butt" data-size="50" data-scale-color="false" data-track-color="#fff" data-line-width="4" data-percent="100" class="easypiechart pos-abt easyPieChart" style="width: 50px; height: 50px; line-height: 50px;"><canvas height="50" width="50"></canvas></span>
                    </span>
                    <a href="{{ url('media') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong id="bugs">{{ $files->count() }}</strong></span>
                        <small class="text-muted text-uc">Medios</small>
                    </a>
                </div>
                <div class="col-sm-6 col-md-3 padder-v b-r b-light">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                      <i class="fa fa-circle fa-stack-2x text-danger"></i>
                      <i class="fa fa-calendar fa-stack-1x text-white"></i>
                      <span data-update="5000" data-target="#firers" data-animate="3000" data-line-cap="butt" data-size="50" data-scale-color="false" data-track-color="#f5f5f5" data-line-width="4" data-percent="100" class="easypiechart pos-abt easyPieChart" style="width: 50px; height: 50px; line-height: 50px;"><canvas height="50" width="50"></canvas></span>
                    </span>
                    <a href="{{ url('calendar') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong id="firers">{{ $appointments->count() }}</strong></span>
                        <small class="text-muted text-uc">Calendario</small>
                    </a>
                </div>
                <div class="col-sm-6 col-md-3 padder-v b-r b-light lt">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                      <i class="fa fa-circle fa-stack-2x icon-muted"></i>
                      <i class="fa fa-medkit fa-stack-1x text-white"></i>
                    </span>
                    <a href="{{ url('medicines') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong>{{ $medicines->count() }}</strong></span>
                        <small class="text-muted text-uc">Medicamentos</small>
                    </a>
                </div>
            @else
                <div class="col-sm-6 col-md-4 padder-v b-r b-light">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                      <i class="fa fa-circle fa-stack-2x text-info"></i>
                      <i class="fa fa-user-md fa-stack-1x text-white"></i>
                    </span>
                    <a href="{{ url('patients') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong>{{ $patients->count() }}</strong></span>
                        <small class="text-muted text-uc">Pacientes</small>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 padder-v b-r b-light lt">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                      <i class="fa fa-circle fa-stack-2x text-warning"></i>
                      <i class="fa fa-files-o fa-stack-1x text-white"></i>
                      <span data-update="3000" data-target="#bugs" data-animate="2000" data-line-cap="butt" data-size="50" data-scale-color="false" data-track-color="#fff" data-line-width="4" data-percent="100" class="easypiechart pos-abt easyPieChart" style="width: 50px; height: 50px; line-height: 50px;"><canvas height="50" width="50"></canvas></span>
                    </span>
                    <a href="{{ url('media') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong id="bugs">{{ $files->count() }}</strong></span>
                        <small class="text-muted text-uc">Medios</small>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 padder-v b-r b-light">
                    <span class="fa-stack fa-2x pull-left m-r-sm">
                      <i class="fa fa-circle fa-stack-2x text-danger"></i>
                      <i class="fa fa-calendar fa-stack-1x text-white"></i>
                      <span data-update="5000" data-target="#firers" data-animate="3000" data-line-cap="butt" data-size="50" data-scale-color="false" data-track-color="#f5f5f5" data-line-width="4" data-percent="100" class="easypiechart pos-abt easyPieChart" style="width: 50px; height: 50px; line-height: 50px;"><canvas height="50" width="50"></canvas></span>
                    </span>
                    <a href="{{ url('calendar') }}" class="clear">
                        <span class="h3 block m-t-xs"><strong id="firers">{{ $appointments->count() }}</strong></span>
                        <small class="text-muted text-uc">Calendario</small>
                    </a>
                </div>
            @endif
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <section class="panel panel-default">
                <header class="panel-heading font-bold"><strong>Citas del día</strong></header>
                <div class="list-group m-l-n-xxs m-r-n-xxs">
                    @foreach ($todaysAppointments as $appointment)
                        <a href="{{ url('appointments/view', $appointment->id) }}" class="list-group-item text-ellipsis bg-light dk dt-fr-vpt">
                            <span class="badge {{ $appointment->start_gtct ? 'bg-success' : 'bg-danger' }}">{{ $appointment->start_time }}</span>
                            Cita {{ $appointment->start_until }} - {{ $appointment->patient['full_name'] }}
                        </a>
                    @endforeach
                    @if ($todaysAppointments->isEmpty())
                        <span class="list-group-item bg-light dk text-bold">
                            No hay ninguna cita para hoy.
                        </span>
                    @endif
                </div>
            </section>
        </div>
    </div>
    @if ($nextAppointment)
        <div class="row">
            <div class="col-md-12">
                <section class="panel panel-default">
                    <header class="panel-heading font-bold">Próxima cita</header>
                    <a href="{{ url('appointments/view', $nextAppointment->id) }}" class="dt-fr-vpt">
                        <div class="bg-light dk wrapper">
                            <span class="pull-right">{{ $nextAppointment->start_date_time_fancy }}</span>
                        <span class="h4">{{ $nextAppointment->patient['full_name'] }}<br>
                            <small class="text-muted"><i class="fa fa-clock-o"></i> Duración {{ $nextAppointment->duration }}</small> -
                            <small class="text-muted"><i class="fa fa-clock-o"></i> {{ ucfirst($nextAppointment->start_until) }}</small>
                        </span>
                        </div>
                    </a>
                </section>
            </div>
        </div>
    @endif
    @endrole
    @role ('patient')
    <div class="row">
        <div class="col-md-6">
            <section class="panel b-light">
                <header class="panel-heading bg-primary dker no-border"><strong>Próximas citas</strong></header>
                <div class="list-group m-l-n-xxs m-r-n-xxs">
                    {{ Hashids::setDefaultConnection('patient_appointment') }}
                    @foreach ($nextUserAppointments as $appointment)
                        <a href="#" data-aid="{{ Hashids::encode($appointment->id) }}" data-remodal-target="ptappointment" class="list-group-item text-ellipsis bg-primary text-bold dt-fr-vpt">
                            <span class="badge {{ $appointment->start_gtct ? 'bg-success' : 'bg-danger' }}">{{ $appointment->start_time }}</span>
                            Cita {{ $appointment->start_until }} - {{ $appointment->doctor->name }}
                        </a>
                    @endforeach
                    @if ($nextUserAppointments->isEmpty())
                        <span class="list-group-item bg-primary text-bold">
                            No hay próximas citas que mostrar.
                        </span>
                    @endif
                </div>
            </section>
        </div>
        <div class="col-md-6">
            <section class="panel b-light">
                <header class="panel-heading bg-primary dker no-border"><strong>Citas del día</strong></header>
                <div class="list-group m-l-n-xxs m-r-n-xxs">
                    {{ Hashids::setDefaultConnection('patient_appointment') }}
                    @foreach ($todaysUserAppointments as $appointment)
                        <a href="#" data-aid="{{ Hashids::encode($appointment->id) }}" data-remodal-target="ptappointment" class="list-group-item text-ellipsis bg-primary text-bold dt-fr-vpt">
                            <span class="badge {{ $appointment->start_gtct ? 'bg-success' : 'bg-danger' }}">{{ $appointment->start_time }}</span>
                            Cita {{ $appointment->start_until }} - {{ $appointment->doctor->name }}
                        </a>
                    @endforeach
                    @if ($todaysUserAppointments->isEmpty())
                        <span class="list-group-item bg-primary text-bold">
                            No hay ninguna cita para hoy.
                        </span>
                    @endif
                </div>
            </section>
        </div>
    </div>
    @if ($nexUserAppointment)
    <div class="row">
        <div class="col-md-12">
            <section class="panel panel-default">
                <header class="panel-heading font-bold">Próxima cita</header>
                {{ Hashids::setDefaultConnection('patient_appointment') }}
                <a href="#" data-remodal-target="ptappointment" data-aid="{{ Hashids::encode($nexUserAppointment->id) }}" class="dt-fr-vpt">
                    <div class="bg-light dk wrapper">
                        <span class="pull-right">{{ $nexUserAppointment->start_date_time_fancy }}</span>
                        <span class="h4">{{ $nexUserAppointment->doctor->name }}<br>
                            <small class="text-muted"><i class="fa fa-clock-o"></i> {{ $nexUserAppointment->duration }}</small>
                        </span>
                    </div>
                </a>
            </section>
        </div>
    </div>
    @endif
    <div class="remodal-bg"></div>
    <div class="remodal" id="pt-modal" data-remodal-id="ptappointment"
         data-remodal-options="hashTracking: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div id="patient-appointment" style="display: none;">
        </div>
        <div class="loader-backdrop dt-loader" style="display: none;">
            <div data-loader="circle-side"></div>
        </div>
    </div>


    @endrole
@endsection

@push('scripts')
<script src="{{ asset('assets/js/calendar/bootstrap_calendar.js') }}"></script>
@role ('patient')
<script src="{{ asset('assets/js/datatables/datatablescm.min.js') }}"></script>
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $(document).on('click', '.dt-fr-vpt', function (e) {
            var _this = $(this), aid = _this.data('aid');

            $('#patient-appointment').html('').hide();
            $('#pt-modal .dt-loader').show();

            $.ajax({
                url: '{{ url('patient/appointment') }}/' + aid,
                method: 'GET',
                success: function(res) {
                    $('#patient-appointment').html(res).fadeIn();

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

                    $('#pt-modal .dt-loader').fadeOut();

                }
            });
        });


        var cTime = new Date(), month = cTime.getMonth()+1, year = cTime.getFullYear();

        theMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        theDays = ["S", "M", "T", "W", "T", "F", "S"];
        events = [
            [
                "5/"+month+"/"+year,
                'Meet a friend',
                '#',
                '#fb6b5b',
                'Contents here'
            ],
            [
                "5/"+month+"/"+year,
                'Testing',
                '#',
                '#fb6b5b',
                'Test 3'
            ],
            [
                "8/"+month+"/"+year,
                'Kick off meeting!',
                '#',
                '#ffba4d',
                'Have a kick off meeting with .inc company'
            ],
            [
                "18/"+month+"/"+year,
                'Milestone release',
                '#',
                '#ffba4d',
                'Contents here'
            ],
            [
                "19/"+month+"/"+year,
                'A link',
                'https://github.com/blog/category/drinkup',
                '#cccccc'
            ]
        ];
        $('#calendar').calendar({
            months: theMonths,
            days: theDays,
            events: events,
            popover_options:{
                placement: 'top',
                html: true
            }
        });
    });
</script>
@endrole

@endpush