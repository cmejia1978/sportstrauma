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
        <aside class="aside-lg b-l">
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
        </aside>
        <!-- /.aside -->
    </section>

    <!--<section class="panel panel-default">
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
    <aside class="aside-lg b-l">
        <div class="padder">
            <h5>Dragable events</h5>
            <div class="line"></div>
            <div class="pillbox clearfix m-b no-border no-padder" id="myEvents">
                <ul>

                    <li class="label bg-success ui-draggable" style="position: relative; z-index: auto; left: 0px; top: 0px;">Item Two</li>
                    <li class="label bg-warning ui-draggable" style="position: relative;">Item Three</li>
                    <li class="label bg-danger ui-draggable" style="position: relative;">Item Four</li>
                    <li class="label bg-info ui-draggable" style="position: relative;">Item Five</li>
                    <li class="label bg-primary ui-draggable" style="position: relative;">Item Six</li>
                    <li class="label bg-dark ui-draggable" style="position: relative;">asdads</li><input type="text" placeholder="add an event">
                </ul>
            </div>
            <div class="line"></div>
            <div class="checkbox">
                <label class="checkbox-custom"><input type="checkbox" id="drop-remove"><i class="fa fa-square-o"></i> remove after drop</label>
            </div>
        </div>
    </aside>-->
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
                /*left: 'prev,next today',
                 center: 'title',
                 right: 'agendaWeek,agendaDay'//,month',*/
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            aspectRatio: 1.2,
            selectable: false,
            selectHelper: true,
            selectConstraint:{
                start: '8:00',
                end: '17:00'
            },
            eventConstraint: {
                /*start: '8:00',
                 end: '17:00'*/
                start: date,
                end: '2100-01-01' // hard coded goodness unfortunately
            },
            businessHours: {
                start: moment().format('HH:mm'), /* Current Hour/Minute 24H format */
                end: '17:00', // 5pm? set to whatever
                dow: [0,1,2,3,4,5,6] // Day of week. If you don't set it, Sat/Sun are gray too
            },
            //disableDragging: true,
            minTime: '08:00:00',
            maxTime: '17:00:00',
            eventOverlap: false,
            editable: true,
            disableResizing: true,
            defaultView: 'agendaWeek',
            //hiddenDays: [0],
            //allDaySlot: false,
            //defaultEventMinutes: 30,
            defaultTimedEventDuration: '00:30:00',
            eventDurationEditable: false,
            allDaySlot: false,
            height: 'auto',
            //contentHeight: 466,
            selectOverlap: false,
            //eventStartEditable: false,
            //snapDuration: '00:30:00',
            eventResizeStart: function( event, jsEvent, ui, view ) {
                console.log(event);
            },
            eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {
                console.log(event);
                /*var title = prompt('Event Title:', calEvent.title, { buttons: { Ok: true, Cancel: false} });

                 if (title){
                 calEvent.title = title;
                 calendar.fullCalendar('updateEvent',calEvent);
                 }*/
            },
            /*select: (function() {
             var humanSelection = true;
             return function(start, end, jsEvent, view) {
             if(humanSelection) {
             humanSelection = false;
             $('#calendar').fullCalendar('select', start);
             humanSelection = true;
             }
             };
             })(),*/
            /*select:(function() {
             var humanSelection = true;
             var selectedOne = false;
             return function(start, end, jsEvent, view) {
             var check = start._d.toJSON().slice(0,10);
             var today = new Date().toJSON().slice(0,10);
             if(check < today)
             {
             // Previous Day. show message if you want otherwise do nothing.
             // So it will be unselectable
             calendar.fullCalendar('unselect');
             }
             else
             {
             if(humanSelection && !selectedOne) {
             humanSelection = false;
             calendar.fullCalendar('renderEvent', {
             title: 'Test',
             start: start,
             //end: end,
             allDay: false,
             editable: true
             });
             selectedOne = true;
             humanSelection = true;

             //calendar.fullCalendar('renderEvent', {
             //title: 'Test',
             //start: start,
             //end: end,
             //allDay: false,
             //editable: true
             //},
             //true make the event "stick"
             //);
             //calendar.fullCalendar('select', start);
             ////$('#title').val('');
             //calendar.fullCalendar('unselect');
             } else {
             calendar.fullCalendar('unselect');
             }
             }
             };
             })(),*/
            //function(start, end, allDay) {
            /*console.log( 'Events :' + getEventsByTime( start, end ).length );
             var ev = getEventsByTime( start, end );
             console.log( ev );
             var itms = {};

             ev.forEach(function(entry){

             var begin = moment(entry.start);
             var final = moment(entry.end);


             while( begin.diff(final) < 0 ) {
             itms[begin] =  ( itms[begin] || 0) + 1;
             if( itms[begin] >= maxEventsInInterval ) {
             console.log(' __ WARNING __ , max events exceeded! ');
             }

             begin = moment(begin).add('seconds', 900);
             }

             });
             console.log( itms );*/
            /*$('#fc_create').click();

             started = start;
             ended = end;

             $(".antosubmit").on("click", function() {
             var title = $("#title").val();
             if (end) {
             ended = end
             }
             categoryClass = $("#event_type").val();

             if (title) {
             calendar.fullCalendar('renderEvent', {
             title: title,
             start: started,
             end: end,
             allDay: allDay
             },
             true // make the event "stick"
             );
             }
             $('#title').val('');
             calendar.fullCalendar('unselect');

             $('.antoclose').click();

             return false;
             });*/
            //},
            // eventClick: function(calEvent, jsEvent, view) {
            //alert(calEvent.title, jsEvent, view);

            /*$('#fc_edit').click();
             $('#title2').val('Test');
             categoryClass = $("#event_type").val();

             $(".antosubmit2").on("click", function() {
             calEvent.title = 'Test';//$("#title2").val();

             calendar.fullCalendar('updateEvent', calEvent);
             $('.antoclose2').click();
             });
             calendar.fullCalendar('unselect');*/
            //},
            //
            events: [/*, {
             title: 'Long Event',
             start: new Date(y, m, d - 5),
             end: new Date(y, m, d - 2)
             },*/ {
                id: 1,
                title: 'Cita: Mario Gonzalez',
                start: new Date(y, m, d, 10, 30),
                end: new Date(y, m, d, 11, 0),
                allDay: false,
                url: '{{ url('patients/view/1') }}',
                editable: true
            }, {
                id: 2,
                title: 'Cita: Luis Grajeda',
                start: new Date(y, m, d, 11, 0),
                end: new Date(y, m, d, 11, 30),
                allDay: false,
                url: '{{ url('patients/view/2') }}'
                //editable: false
            },{
                id: 3,
                title: 'Cita: Rudy Moreno',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 12, 30),
                allDay: false,
                url: '{{ url('patients/view/3') }}'
                //editable: false
            },{
                id: 4,
                title: 'Cita: Jorge Marroquin',
                start: new Date(y, m, d, 15, 0),
                end: new Date(y, m, d, 15, 30),
                allDay: false,
                url: '{{ url('patients/view/4') }}'
                //editable: false
            }],
            /*, {
             title: 'Lunch',
             start: new Date(y, m, d + 14, 12, 0),
             end: new Date(y, m, d, 14, 0),
             allDay: false
             }, {
             title: 'Birthday Party',
             start: new Date(y, m, d + 1, 19, 0),
             end: new Date(y, m, d + 1, 22, 30),
             allDay: false
             }, {
             title: 'Click for Google',
             start: new Date(y, m, 28),
             end: new Date(y, m, 29),
             url: 'http://google.com/'
             }],*/
            timeFormat: '(H:mm)'
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