<aside class="bg-doctor lter aside-md hidden-print" id="nav">
    <section class="vbox">
        <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                <nav class="nav-primary hidden-xs">
                    <ul class="nav">
                        @role ('admin|doctor')
                        <li >
                            <a href="{{ url('patients') }}" >
                                @if ($app_patients->count() > 0)
                                <b class="badge bg-danger pull-right">{{ $app_patients->count() }}</b>
                                @endif
                                <i class="fa fa-user-md icon"><b class="bg-danger"></b></i>
                                <span>Pacientes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('media') }}">
                                <i class="fa fa-file icon"><b class="bg-warning"></b></i>
                                <span>Medios</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('calendar') }}">
                                <i class="fa fa-calendar-o icon"><b class="bg-success"></b></i>
                                <span>Calendario</span>
                            </a>
                        </li>
                        @if (Auth::user()->id != 3)
                            <li>
                                <a href="{{ url('medicines') }}">
                                    <i class="fa fa-medkit icon"><b class="bg-primary"></b></i>
                                    <span>Medicamentos</span>
                                </a>
                            </li>
                        @endif
                        @endrole
                        @role ('admin')
                        <li>
                            <a href="{{ url('admin/users') }}">
                                <i class="fa fa-users"><b class="bg-primary"></b></i>
                                <span>Usuarios</span>
                            </a>
                        </li>
                        @endrole

                        @role ('patient')
                        <li>
                            <a href="{{ url('patient/profile') }}">
                                <i class="fa fa-user"><b class="bg-primary"></b></i>
                                <span>Mi perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://toptrauma.com/instrucciones-pre-operatorias" target="_blank">
                                <span class="text-sm">Instrucciones Pre-Operatorias</span>
                            </a>
                        </li>
                        @endrole

                    </ul>
                </nav>
            </div>
        </section>
        <footer class="footer lt hidden-xs b-t b-doctor">
            <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-doctor btn-icon"> <i class="fa fa-angle-left text"></i> <i class="fa fa-angle-right text-active"></i> </a>
            <div class="btn-group hidden-nav-xs">
                <a href="{{ url('/logout') }}" class="btn btn-icon btn-sm btn-doctor" title="Cerrar sesión" type="button"><i class="fa fa-power-off"></i></a>
            </div>
        </footer>
    </section>
</aside>