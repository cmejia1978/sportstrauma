<header class="bg-doctor dk header navbar navbar-fixed-top-xs" id="nav-head">
    <div class="navbar-header aside-md">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
            <i class="fa fa-bars"></i>
        </a>
        <a href="{{ url('/') }}" class="navbar-brand" data-toggle="fullscreen"><img src="{{ asset('assets/images/logo-white.png') }}" class="m-r-sm"></a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
            <i class="fa fa-cog"></i>
        </a>
    </div>

    <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="thumb-sm avatar pull-left">
                  <img id="c-nav-profile-pic" src="{{ Auth::user()->photo }}">
                </span>
                <span id="user-info-name">{{ auth()->user()->name }} </span><b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInRight">
                <span class="arrow top"></span>
                @role ('doctor')
                <li>
                    <a href="#" class="dt-doctor-edit" data-remodal-target="update-doctor">Editar información</a>
                </li>
                <li>
                    <a href="#" class="dt-doctor-avatar" data-remodal-target="edit-doctor-profile-picture">Cambiar foto perfil</a>
                </li>
                @endrole
                @role ('patient')
                @if (Auth::user()->patient['associated'] == 'Y' && Session::get('selected_doctor', '0') != '0')
                @foreach ($app_doctors as $doctor)
                    <li>
                        <a href="#" data-did="{{ Hashids::connection('doctor')->encode($doctor->id) }}" class="dt-doctor-change">{{ $doctor->name }}</a>
                    </li>
                @endforeach
                @endif
                @endrole
                <li>
                    <a href="{{ url('/logout') }}">Cerrar sesión</a>
                </li>
            </ul>
        </li>
    </ul>
</header>