@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-title">
            <div class="title_left">
                <h3>Nuevo usuario</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Datos <small>Usuario</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="add-user-form" class="form-horizontal form-label-left" action="{{ url('admin/users/add') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->user->first('name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-name">Nombre <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-name" name="name" class="form-control col-md-7 col-xs-12" value="{{ old('name') }}">
                                    @if ($errors->user->first('name'))
                                        <span class="help-block">{{ $errors->user->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Correo <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('password') ? ' has-error' : '' }}">
                                <label for="input-password" class="control-label col-md-3 col-sm-3 col-xs-12">Contraseña <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="input-password" class="form-control col-md-7 col-xs-12" type="password" name="password">
                                    @if ($errors->user->first('password'))
                                        <span class="help-block">{{ $errors->user->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <label for="input-role" class="control-label col-md-3 col-sm-3 col-xs-12">Rol</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="role" id="input-role" class="form-control col-md-7 col-xs-12">
                                        @foreach ($roles as $role)
                                            @if ($role->slug === 'admin')
                                                <option value="{{ $role->id }}" selected="selected">{{ $role->description }}</option>
                                            @else
                                                <option value="{{ $role->id }}">{{ $role->description }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="{{ URL::previous() }}" class="btn btn-primary">Cancelar</a>
                                    <button type="submit" class="btn btn-success">Agregar</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
