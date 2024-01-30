@extends('layouts.app')
@section('title', 'Calendario')

@push('styles')
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fullcalendar/fullcalendarv2.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/toastr/toastr.css') }}" rel="stylesheet">
@endpush

@section('content')

    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <section class="scrollable">
                    <section class="panel panel-default">
                        <header class="panel-heading bg-light clearfix">
                            <div data-toggle="buttons" class="btn-group pull-right">
                                <label id="weekview" class="btn btn-sm btn-bg btn-default active">
                                    <input type="radio" name="options">Semana
                                </label>
                                <label id="dayview" class="btn btn-sm btn-bg btn-default">
                                    <input type="radio" name="options">Día
                                </label>
                            </div>
                            <div id="calendar-trash" class="calendar-trash text-dark pull-right">
                                <i class="fa fa-trash-o"></i>
                            </div>
                            <span class="m-t-xs inline sonar sonar-fill sonar-infinite">Calendario Citas - {{ $patient->full_name }}</span>
                        </header>
                        <div class="calendar" id="calendar">

                        </div>
                    </section>
                </section>
            </section>
        </aside>
        <aside class="aside-lg b-l">
            <div class="padder">
                <h5>Paciente</h5>
                <div class="line"></div>
                <div id="patient-appointment" class="clearfix m-b no-border no-padder patient-list">
                    <ul class="list-unstyled">
                        <li class="label bg-dark" data-title="{{ $patient->full_name }}" data-type="N" data-pid='{{ $patient->id }}'>{{ $patient->short_name }}</li>
                    </ul>
                </div>
                <div class="line"></div>
                <div class="checkbox">
                    <label class="checkbox-custom"><input type='checkbox' id='edit-mode' /><i class="fa fa-square-o"></i> Cambiar cita a otra semana</label>
                </div>
                <div class="line"></div>
                <div id="custom-event">
                    <h5>Temporales</h5>
                    <div class="line"></div>
                    <div id="custom-events" class="clearfix m-b no-border no-padder patient-list">
                        <ul class="list-unstyled">
                        </ul>
                    </div>
                    <button type="button" id="add-custom-event" class="btn btn-dark btn-sm btn-block" data-remodal-target="add-custom-appointment">Agregar temporal</button>
                </div>
                <div class="line"></div>
                <div style="display: none;" id="edit-history">
                    <h5>Historial de cambios</h5>
                    <div class="clearfix m-b no-border no-padder list-history">
                        <ul class="list-unstyled" id="history-list"></ul>
                        <button id="history-notify" style="margin-bottom: 20px;" class="btn btn-dark btn-s-md btn-block sonar sonar-fill sonar-slow sonar-infinite active">Notificar al paciente</button>
                    </div>
                </div>
            </div>
        </aside>
    </section>
    <div class="remodal-bg"></div>
    @include('doctor.patient.appointment.remove')
    @include('doctor.patient.appointment.new-custom')
@endsection


@push('scripts')
<script src="{{ asset('assets/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar/fullcalendarv2.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>

<script>
    $(window).load(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        var calendar,
            trashcan                  = $('#calendar-trash'),
            editModeToggle            = $('#edit-mode'),
            editMode                  = false,
            editedEvents              = [],
            editHistory               = $('#edit-history'),
            historyNotify             = $('#history-notify'),
            selectedEvent             = false,
            viewPAppointmentUrl       = '{{ url('appointments/view') }}',
            removeAppointmentModal    = $('[data-remodal-id=remove-appointment]').remodal(),
            addCustomAppointmentModal = $('[data-remodal-id=add-custom-appointment]').remodal(),
            addCustomAppointmenForm   = $('#add-custom-appointment-form'),
            customAppointments        = $('#custom-events'),
            loader                    = $('.dt-loader'),
            addedApt                  = [];



        $(document).on('closing', '.remodal', function (e) {
            if (addCustomAppointmentModal.getState() == 'closing') {
                addCustomAppointmenForm[0].reset();
                $('#add-custom-appointment-form .message-name').text('').hide().parent().removeClass('has-error');
            }
        });


        addCustomAppointmenForm.on('submit', function(e) {
            e.preventDefault();

            loader.show();

            var _this = $(this);
            var input = _this.find('input[name=name]');
            var message = _this.find('.message-name');
            var parent = input.parent();

            message.text('').hide();
            parent.removeClass('has-error');

            if (!input.val().length) {
                message.text('Debe ingresar un valor').fadeIn();
                parent.addClass('has-error');
            } else {
                var eventTpl = '<li class="label bg-dark">' + $.trim(input.val()) + '</li>';
                var event = $(eventTpl);
                event.data('event', {
                    title: $.trim(input.val()),
                    stick: true,
                    editable: true,
                    allDay: false,
                    type: 'C',
                    className: 'current-usr-event'
                });
                event.draggable({
                    zIndex: 999,
                    revert: true,
                    revertDuration: 0
                });
                input.val('');
                customAppointments.find('ul').append(event);
                addCustomAppointmentModal.close();
            }

            setTimeout(function() {
                loader.fadeOut();
            }, 500);
        });

        function is_new(event) {
            for (var i = 0, len = addedApt.length; i < len; i ++) {
                if (addedApt[i] == event.id)
                    return true;
            }
            return false;
        }

        editModeToggle.on('change', function(e) {
            editMode = $(this).is(':checked');
        });

        historyNotify.on('click', function(e) {
            var pid          = '{{ $patient->id }}',
                appointments = [];

            for (var i = 0, len = editedEvents.length; i < len; i++) {
                var aid = editedEvents[i].id, codeStatus = (is_new(editedEvents[i]) ? 'added' : ''), startDT = editedEvents[i].start.locale("es").format('YYYY-MM-DD HH:mm:ss'), endDT = editedEvents[i].end.locale("es").format('YYYY-MM-DD HH:mm:ss'), tapt = { id: aid, start: startDT, end: endDT, code_status: codeStatus };
                appointments.push(tapt);
            }

            $.ajax({
                url: '{{ url('appointments/notify') }}',
                method: 'POST',
                data: { pid: pid, events: appointments },
                success: function(res) {
                    if (res.success) {
                        editHistory.fadeOut();
                        addedApt = [];
                        editedEvents = [];
                        toastr.success('Se ha notificado al paciente de los cambios');
                    }
                }
            });
        });

        $('#patient-appointment').find('li').each(function() {
            $(this).data('event', {
                title: $.trim($(this).data('title')),
                stick: true,
                editable: true,
                type: $(this).data('type'),
                allDay: false,
                className: 'current-usr-event'
            });
            $(this).draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            });
        });


        var addToHistory = function (event) {
            var foundEvent = $.grep(editedEvents, function (e) {
                return e.id == event.id;
            });

            if (foundEvent.length == 0) {
                editedEvents.push(event);
            } else if (foundEvent.length == 1) {
                foundEvent[0].start = event.start;
                foundEvent[0].end = event.end;
            }

            drawHistory();
        };

        var removeFromHistory = function (event) {
            if (editedEvents.length > 1) {
                for( var i = editedEvents.length-1; i--;){
                    if (editedEvents[i].id == event.id) {
                        editedEvents.splice(i, 1);
                    }
                }

                drawHistory();
            } else {
                if (editedEvents[0] != undefined && editedEvents[0].id == event.id) {
                    editedEvents = [];
                    editHistory.fadeOut();
                }
            }
        };

        var drawHistory = function() {
            var html = '';

            for (var i = 0, len = editedEvents.length; i < len; i++) {
                var startDT = editedEvents[i].start.format('DD/MM/YYYY HH:mm'), endDT = editedEvents[i].end.format('YYYY-MM-DD HH:mm');
                html += '<li class="label bg-light text-ellipsis"> Cita para: ' + startDT + '</li>';
            }

            $('#history-list').html(html);
            editHistory.fadeIn();
        };

        var appointments = [
            @foreach ($appointments as $appointment)
                @if ($appointment->patient_id == $patient->id)
                    {
                        id: '{{ $appointment->id }}',
                        title: '{{ $appointment->type == 'N' ? $appointment->patient['full_name'] : $appointment->comment }}',
                        start: new Date('{{ $appointment->start_js }}'),
                        end: new Date('{{ $appointment->end_js }}'),
                        allDay: false,
                        url: '{{ url('appointments/view', $appointment->id) }}',
                        editable: true,
                        type: '{{ $appointment->type }}',
                        comment: '{{ $appointment->comment }}',
                        className: 'current-usr-event',
                        sticky: true
                    },
                @else
                    {
                        id: '{{ $appointment->id }}',
                        title: '{{ $appointment->patient['full_name'] }}',
                        start: new Date('{{ $appointment->start_js }}'),
                        end: new Date('{{ $appointment->end_js }}'),
                        allDay: false,
                        url: '{{ url('appointments/view', $appointment->id) }}',
                        editable: false,
                        className: 'other-usr-event',
                        sticky: true
                    },
                @endif
            @endforeach
        ];

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

        calendar = $('#calendar').fullCalendar({
            buttonText: {
                month: "Mes",
                week: "Semana",
                day: "Día",
                list: "Agenda"
            },
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
            allDayHtml: "Todo<br/>el día",
            eventLimitText: "más",
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            views: {
                week: {
                    titleFormat: 'MMMM DD [del] YYYY',
                    columnFormat: 'dddd DD'
                },
                day: {
                    titleFormat: ' DD MMMM, YYYY'
                }
            },
            hiddenDays: [ 0 ],
            aspectRatio: 1.2,
            selectable: true,
            selectHelper: false,
            selectConstraint:{
                start: '6:00',
                end: '19:00'
            },
            eventConstraint: {
                start: moment().startOf('minute'),
                end: '2100-01-01'
            },
            eventClick: function( event, jsEvent, view ) {
                if (editMode && event.editable) {
                    editModeToggle.trigger('click');
                    event.backgroundColor = 'green';
                    selectedEvent = event;
                    calendar.fullCalendar( 'rerenderEvents' );
                } else if (!editMode) {
                    return true;
                }

                return false;
            },
            select: function( start, end, jsEvent, view) {
                if (selectedEvent && start.isAfter(moment()) && selectedEvent.editable) {
                    var startDT       = start.format('YYYY-MM-DD HH:mm:ss'),
                        endDT         = end.format('YYYY-MM-DD HH:mm:ss'),
                        appointmentId = selectedEvent.id;

                    $.ajax({
                        url: '{{ url('appointments/update') }}',
                        method: 'POST',
                        data: { aid: appointmentId, start: startDT, end: endDT },
                        success: function(res) {
                            if (res.success) {
                                selectedEvent.start = start;
                                selectedEvent.end = end;
                                selectedEvent.backgroundColor = '#0c0e26';
                                calendar.fullCalendar( 'rerenderEvents' );
                                calendar.fullCalendar('updateEvent', selectedEvent);
                                if (selectedEvent.type == 'N') {
                                    var tempEvent = { id: appointmentId, start: start, end: end };
                                    addToHistory(tempEvent);
                                    toastr.success('Cita del paciente: <strong>{{ $patient->short_name }}</strong> actualizada');
                                }
                                selectedEvent = false;
                            }
                        }
                    });
                }
            },
            eventDragStop: function(event, jsEvent) {
                trashcan.toggleClass('sonar sonar-fill sonar-infinite active');

                var ofs = trashcan.offset(),
                    x1 = ofs.left,
                    x2 = ofs.left + trashcan.outerWidth(true),
                    y1 = ofs.top,
                    y2 = ofs.top + trashcan.outerHeight(true);

                if (jsEvent.pageX >= x1 && jsEvent.pageX <= x2 && jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                    removeAppointmentModal.open();
                    $(document).on('closing', '.remodal', function (e) {
                        if (e.reason == 'confirmation') {
                            $.ajax({
                                url: '{{ url('appointments/remove') }}',
                                method: 'POST',
                                data: { aid: event.id, pid: '{{ $patient->id }}' },
                                success: function(res) {
                                    if (res.success) {
                                        removeFromHistory(event);
                                        calendar.fullCalendar('removeEvents');
                                        calendar.fullCalendar('addEventSource', res.events);
                                        calendar.fullCalendar('rerenderEvents' );
                                    }
                                }
                            });
                        }
                    });
                }

            },
            dragRevertDuration: 0,
            eventDragStart: function( event, jsEvent, ui, view ) {
                trashcan.toggleClass('sonar sonar-fill sonar-infinite active');
            },
            forceEventDuration: true,
            businessHours: {
                start: moment().format('HH:mm'),
                end: '19:00',
                dow: [0,1,2,3,4,5,6]
            },
            droppable: true,
            minTime: '06:00:00',
            maxTime: '19:00:00',
            eventOverlap: false,
            editable: true,
            dragOpacity: '0.3',
            defaultView: 'agendaWeek',
            defaultTimedEventDuration: '00:30:00',
            slotDuration: '00:30:00',
            allDaySlot: false,
            height: 'auto',
            selectOverlap: false,
            drop: function( date, jsEvent, ui, resourceId ) {
                var _this = $(this);
                var event = _this.data('event');
                if (event.type == 'C') {
                    $(this).remove();
                }
            },
            eventRender: function (event, element) {
                element.find('.fc-title').html(element.find('.fc-title').text());
            },
            eventResize: function( event, delta, revertFunc, jsEvent, ui, view ) {
                var startDT = event.start.format('YYYY-MM-DD HH:mm:ss'),
                    endDT   = event.end.format('YYYY-MM-DD HH:mm:ss');
                $.ajax({
                    url: '{{ url('appointments/update') }}',
                    method: 'POST',
                    data: { aid: event.id, start: startDT, end: endDT },
                    success: function(res) {
                        if (res.success) {
                            if (event.type == 'N') {
                                addToHistory(event);
                                toastr.success('Cita del paciente: <strong>{{ $patient->short_name }}</strong> actualizada');
                            } else {
                                toastr.success('Temporal actualizado');
                            }
                        }
                    }
                });
            },
            eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {
                var startDT = event.start.format('YYYY-MM-DD HH:mm:ss'),
                    endDT   = event.end.format('YYYY-MM-DD HH:mm:ss');
                $.ajax({
                    url: '{{ url('appointments/update') }}',
                    method: 'POST',
                    data: { aid: event.id, start: startDT, end: endDT },
                    success: function(res) {
                        if (res.success) {
                            if (event.type == 'N') {
                                addToHistory(event);
                                toastr.success('Cita del paciente: <strong>{{ $patient->short_name }}</strong> actualizada');
                            } else {
                                toastr.success('Temporal actualizado');
                            }
                        }
                    }
                });
            },
            eventReceive: function(event) {
                var startDT = event.start.format('YYYY-MM-DD HH:mm:ss'),
                    endDT   = event.end.format('YYYY-MM-DD HH:mm:ss'),
                    title   = event.title,
                    type    = event.type;
                $.ajax({
                    url: '{{ url('appointments/add') }}',
                    data: { pid: '{{ $patient->id }}', start: startDT, end: endDT, type: type, comment: title  },
                    method: 'POST',
                    success: function(res) {
                        addedApt.push(res.aid);
                        event.id = res.aid;
                        event.url = viewPAppointmentUrl + '/' + res.aid;
                        calendar.fullCalendar('removeEvents');
                        calendar.fullCalendar('addEventSource', res.events);
                        calendar.fullCalendar('rerenderEvents' );
                        if (res.success) {
                            if (event.type == 'N') {
                                addToHistory(event);
                                toastr.success('Cita del paciente: <strong>{{ $patient->short_name }}</strong> agregada');
                            } else {
                                toastr.success('Temporal agregado');
                            }


                        }
                    }
                });
            },
            events: appointments,
            axisFormat: 'HH:mm',
            timeFormat: '(HH:mm)'
        });

        $('#dayview').on('click', function() {
            calendar.fullCalendar('changeView', 'agendaDay')
        });

        $('#weekview').on('click', function() {
            calendar.fullCalendar('changeView', 'agendaWeek')
        });

    });
</script>
@endpush