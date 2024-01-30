@extends('layouts.auth_login')

@section('title', 'Iniciar sesión')

@section('content')

    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xxl">
            <a class="navbar-brand auth-brand block" href="/"><img class="logo-auth" src="{{ asset('assets/images/logo-color.png') }}" alt="Sportrauma Center"></a>
            <a class="text-center" style="display: block;" href="{{ url('register-patient') }}">Por favor regístrate para agendar una cita</a>
            <div class="text-center" style="margin-top: 15px;">
                <a href="{{ url('register-patient') }}" class="btn btn-info">Registrar una cuenta</a>
            </div>
            <section class="panel panel-default bg-white m-t-lg">
                <header class="panel-heading text-center">
                    <strong>Iniciar sesión</strong>
                </header>
                <form role="form" method="POST" action="{{ url('/login') }}" class="panel-body wrapper-lg">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label">Correo</label>
                        <input type="text" placeholder="Correo" name="email" class="form-control input-lg" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block text-left">
                                    {{ $errors->first('email') }}
                                </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="control-label">Contraseña</label>
                        <input type="password" id="inputPassword" name="password" placeholder="Contraseña" class="form-control input-lg">
                        @if ($errors->has('password'))
                            <span class="help-block text-left">
                                    {{ $errors->first('password') }}
                                </span>
                        @endif
                    </div>
                    <!--<div class="checkbox">
                        <label>
                            <input type="checkbox"> Keep me logged in
                        </label>
                    </div>-->
                    <a href="{{ url('password/reset') }}" class="pull-right m-t-xs"><small>¿Olvidaste tu contraseña?</small></a>
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    <div class="line line-dashed"></div>
                </form>
            </section>
        </div>
    </section>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder">
            <p>
                <small>Todos los derechos reservados. Sportrauma Center &copy; {{ date('Y') }} </small>
                <br>
                <small>Sistema desarrollado por <a href="http://webs.gt/" target="_blank">Webs.gt</a></small>
            </p>
        </div>
    </footer>

    <!--<div class="container">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
            <h1>Iniciar sesión</h1>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="email" placeholder="Correo electrónico" value="{{ old('email') }}"/>
                            @if ($errors->has('email'))
        <span class="help-block text-left">
            {{ $errors->first('email') }}
                </span>
            @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control" name="password" placeholder="Contraseña"/>
                            @if ($errors->has('password'))
        <span class="help-block text-left">
            {{ $errors->first('password') }}
                </span>
            @endif
            </div>
            <div class="form-group">
            </div>
            <div>
                <button type="submit" class="btn btn-default submit">Iniciar sesión</button>
                <a class="reset_pass" href="#">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                    <h1><img src="{{ asset('assets/images/logo-350x103.png') }}" alt=""></h1>

                                <p>©{{ date('Y') }} Todos los derechos reservados. Sportrauma Center</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

            </div>
        </div>
    </div>-->
@endsection
