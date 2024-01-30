@extends('layouts.auth_login')

@section('content')

    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xxl">
            <a class="navbar-brand auth-brand block" href="/"><img class="logo-auth" src="{{ asset('assets/images/logo-color.png') }}" alt="Sportrauma Center"></a>
            <div class="text-center text-dark">
                <h4>Gracias por registrarse, su información esta siendo procesada.</h4>
            </div>
        </div>
    </section>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder">
            <p>
                <small>Todos los derechos reservados. Sportrauma<br>&copy; {{ date('Y') }} </small>
            </p>
        </div>
    </footer>
@endsection
