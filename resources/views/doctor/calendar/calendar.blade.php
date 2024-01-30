@extends('layouts.app')
@section('title', 'Calendario')

@push('styles')
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fullcalendar/fullcalendarv2.css') }}" rel="stylesheet">
@endpush

@section('content')

    <section class="hbox stretch">
        <!-- .aside -->
        <aside>
            <section class="vbox">
                <section class="scrollable">
                    <section class="panel panel-default">
                        <header class="panel-heading bg-light clearfix">
                            <div data-toggle="buttons" class="btn-group pull-right">
                                <label id="monthview" class="btn btn-sm btn-bg btn-default">
                                    <input type="radio" name="options">Mes
                                </label>
                                <label id="weekview" class="btn btn-sm btn-bg btn-default active">
                                    <input type="radio" name="options">Semana
                                </label>
                                <label id="dayview" class="btn btn-sm btn-bg btn-default">
                                    <input type="radio" name="options">Día
                                </label>
                            </div>
                            <span class="m-t-xs inline">Calendario Citas</span>
                        </header>
                        <div class="calendar" id="calendar">

                        </div>
                    </section>
                </section>
            </section>
        </aside>
        <!-- /.aside -->
        <!-- .aside -->
        <!--<aside class="aside-lg b-l">
            <div class="padder">
                <h6>Paciente</h6>
                <div class="line"></div>
                <div id="myEvents" class="clearfix m-b no-border no-padder patient-list">
                    <ul class="list-unstyled">
                        <li class="label bg-dark">Paciente</li>
                    </ul>
                </div>
                <div class="line"></div>
            </div>
        </aside>-->
        <!-- /.aside -->
    </section>
@endsection


@push('scripts')
<!--<script src="{{ asset('assets/js/jquery-ui-1.10.3.custom.min.js') }}"></script>-->
<script src="{{ asset('assets/js/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('assets/js/fullcalendar/fullcalendarv2.min.js') }}"></script>
<!--<script src="{{ asset('assets/js/fullcalendar/demo.js') }}"></script>-->

<script>
    //!function(a){"function"==typeof define&&define.amd?define(["jquery","moment"],a):"object"==typeof exports?module.exports=a(require("jquery"),require("moment")):a(jQuery,moment)}(function(a,b){!function(){"use strict";var a="ene._feb._mar._abr._may._jun._jul._ago._sep._oct._nov._dic.".split("_"),c="ene_feb_mar_abr_may_jun_jul_ago_sep_oct_nov_dic".split("_"),d=(b.defineLocale||b.lang).call(b,"es",{months:"Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split("_"),monthsShort:function(b,d){return/-MMM-/.test(d)?c[b.month()]:a[b.month()]},weekdays:"domingo_lunes_martes_miércoles_jueves_viernes_sábado".split("_"),weekdaysShort:"dom._lun._mar._mié._jue._vie._sáb.".split("_"),weekdaysMin:"do_lu_ma_mi_ju_vi_sá".split("_"),longDateFormat:{LT:"H:mm",LTS:"H:mm:ss",L:"DD/MM/YYYY",LL:"D [de] MMMM [de] YYYY",LLL:"D [de] MMMM [de] YYYY H:mm",LLLL:"dddd, D [de] MMMM [de] YYYY H:mm"},calendar:{sameDay:function(){return"[hoy a la"+(1!==this.hours()?"s":"")+"] LT"},nextDay:function(){return"[mañana a la"+(1!==this.hours()?"s":"")+"] LT"},nextWeek:function(){return"dddd [a la"+(1!==this.hours()?"s":"")+"] LT"},lastDay:function(){return"[ayer a la"+(1!==this.hours()?"s":"")+"] LT"},lastWeek:function(){return"[el] dddd [pasado a la"+(1!==this.hours()?"s":"")+"] LT"},sameElse:"L"},relativeTime:{future:"en %s",past:"hace %s",s:"unos segundos",m:"un minuto",mm:"%d minutos",h:"una hora",hh:"%d horas",d:"un día",dd:"%d días",M:"un mes",MM:"%d meses",y:"un año",yy:"%d años"},ordinalParse:/\d{1,2}º/,ordinal:"%dº",week:{dow:1,doy:4}});return d}(),a.fullCalendar.datepickerLang("es","es",{closeText:"Cerrar",prevText:"&#x3C;Ant",nextText:"Sig&#x3E;",currentText:"Hoy",monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],monthNamesShort:["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],dayNames:["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"],dayNamesShort:["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"],dayNamesMin:["D","L","M","X","J","V","S"],weekHeader:"Sm",dateFormat:"dd/mm/yy",firstDay:1,isRTL:!1,showMonthAfterYear:!1,yearSuffix:""}),a.fullCalendar.lang("es",{buttonText:{month:"Mes",week:"Semana",day:"Día",list:"Agenda"},allDayHtml:"Todo el día",eventLimitText:"más"})});

</script>
<script>
    $(window).load(function() {

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        var started;
        var categoryClass;

        function getEventsByTime( start, stop ) {
            return $('#calendar').fullCalendar('clientEvents', function (event) {

                return (
                        ( event.start >= start && event.end <= stop ) ||
                        ( start >= event.start && stop <= event.end) ||
                        (start <= event.start && stop >= event.start) ||
                        (start >= event.start && start <= event.end)
                );
            });
        }

        var appointments = [
                @foreach ($appointments as $appointment)
                    {
                        id: '{{ $appointment->id }}',
                        title: '{{ $appointment->type == 'N' ? $appointment->patient['full_name'] : $appointment->comment }}',
                        start: new Date('{{ $appointment->start_js }}'),
                        end: new Date('{{ $appointment->end_js }}'),
                        allDay: false,
                        url: '{{ url('appointments/view', $appointment->id) }}',
                        editable: false,
                        className: 'other-usr-event',
                        sticky: true
                    },
                @endforeach
        ];

        var calendar = $('#calendar').fullCalendar({
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
            aspectRatio: 1.2,
            selectable: false,
            selectHelper: true,
            selectConstraint:{
                start: '8:00',
                end: '17:00'
            },
            eventConstraint: {
                start: date,
                end: '2100-01-01'
            },
            businessHours: {
                start: moment().format('HH:mm'),
                end: '19:00',
                dow: [0,1,2,3,4,5,6]
            },
            minTime: '07:00:00',
            maxTime: '19:00:00',
            eventOverlap: false,
            editable: true,
            disableResizing: true,
            defaultView: 'agendaWeek',
            defaultTimedEventDuration: '00:30:00',
            eventDurationEditable: false,
            allDaySlot: false,
            height: 'auto',
            slotDuration: '00:30:00',
            selectOverlap: false,
            eventRender: function (event, element) {
                element.find('.fc-title').html(element.find('.fc-title').text());
            },
            eventResizeStart: function( event, jsEvent, ui, view ) {
                console.log(event);
            },
            eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {
                console.log(event);

            },
            events: appointments,
            axisFormat: 'HH:mm',
            timeFormat: '(HH:mm)'
        });

        $(document).on('click', '#dayview', function() {
            $('.calendar').fullCalendar('option', 'height', 'auto');
            $('.calendar').fullCalendar('changeView', 'agendaDay')
        });

        $('#weekview').on('click', function() {
            $('.calendar').fullCalendar('option', 'height', 'auto');
            $('.calendar').fullCalendar('changeView', 'agendaWeek')
        });

        $('#monthview').on('click', function() {
            $('.calendar').fullCalendar('option', 'height', '450');
            $('.calendar').fullCalendar('changeView', 'month')
        });
    });
</script>
@endpush