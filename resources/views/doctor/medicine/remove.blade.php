@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-title">
            <div class="title_left">
                <h3></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h5>¿Confirma que dese eliminar al usuario <strong>{{ $user->name }}</strong>?</h5>
                        <form action="{{ url('admin/users/remove') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="form-group pull-right">
                                <a class="btn btn-primary" href="{{ url('admin/users') }}">Cancelar</a>
                                <button class="btn btn-success" type="submit">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
