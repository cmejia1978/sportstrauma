@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-title">
            <div class="title_left">
                <h3>Nuevo paciente</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Informacion del Paciente</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="add-user-form" class="form-horizontal form-label-left" action="{{ url('admin/users/add') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->user->first('name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-name">Primer Nombre <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-name" name="name" class="form-control col-md-7 col-xs-12" value="{{ old('name') }}">
                                    @if ($errors->user->first('name'))
                                        <span class="help-block">{{ $errors->user->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-name">Segundo Nombre <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-name" name="name" class="form-control col-md-7 col-xs-12" value="{{ old('name') }}">
                                    @if ($errors->user->first('name'))
                                        <span class="help-block">{{ $errors->user->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('name') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-name">Apellidos <span class="required">*</span>
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
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Estado Civil <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Soltero/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Casado/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Divorciado/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Separado/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Viudo/a
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Número de Seguro Social <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Fecha de Nacimiento <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Edad <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Sexo <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="patient_sex" id="optionsRadios1" value="option1" checked=""> Masculino
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="patient_sex" id="optionsRadios1" value="option1" checked=""> Femenino
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Dirección de envío <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Ciudad <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Estado <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Código postal <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Número de telefono principal <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Número de telefono secundario <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Ocupación <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Empresa <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Número teléfono de la empresa <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Situación Laboral <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Tiempo completo
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Tiempo parcial
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Auto-Empleado/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Jubilado/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Desempleado/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Militar Activo/a
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""> Discapacitado/a
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Cónyuge / pareja <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="input-email" name="email" class="form-control col-md-7 col-xs-12" value="{{ old('email') }}">
                                    @if ($errors->user->first('email'))
                                        <span class="help-block">{{ $errors->user->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->user->first('email') ? ' has-error' : '' }}">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="input-email">Número de teléfono - Cónyuge / pareja <span class="required">*</span>
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
