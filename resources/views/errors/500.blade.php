@extends('layouts.error')

@section('content')

    <section id="content">
        <div class="row m-n">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="text-center m-b-lg">
                    <h1 class="h text-white animated fadeInDownBig">404</h1>
                    <div class="h3 text-dark">Página no encontrada</div>
                </div>
                <div class="list-group m-b-sm bg-white m-b-lg">
                    <a class="list-group-item" href="{{ url('/') }}">
                        <i class="fa fa-chevron-right icon-muted"></i>
                        <i class="fa fa-fw fa-home icon-muted"></i> Ir a la página de inicio
                    </a>
                </div>
            </div>
        </div>
    </section>
    <footer id="footer">
        <div class="text-center padder">
            <p>
                <small>Todos los derechos reservados. Sportrauma Center &copy; 2016 </small>
            </p>
        </div>
    </footer>

@endsection