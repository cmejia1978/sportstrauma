@extends('layouts.auth_login')

<!-- Main Content -->
@section('content')

    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xxl">
            <a class="navbar-brand auth-brand block" href="/"><img class="logo-auth" src="{{ asset('assets/images/logo-color.png') }}" alt="Sportrauma Center"></a>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <section class="panel panel-default bg-white m-t-lg">
                <header class="panel-heading text-center">
                    <strong>Enviar reinicio de contraseña</strong>
                </header>
                <form role="form" method="POST" action="{{ url('/password/email') }}" class="panel-body wrapper-lg">
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
                    <a href="{{ url('login') }}" class="pull-right m-t-xs">Regresar al inicio de sesión</a>
                    <button type="submit" class="btn btn-primary">Enviar</button>
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
            </p>
        </div>
    </footer>
@endsection
