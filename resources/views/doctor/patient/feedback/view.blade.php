@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
@endpush

@section('content-classes', '')

@section('content')
    <!--<header class="header bg-white b-b b-light">
        <p>{{ 'Información del Paciente ' . $patient->full_name }}</p>
    </header>-->
    <section class="hbox stretch">
        <aside class="aside-xl bg-light lter b-r">
            <section class="vbox">
                <section class="scrollable">
                    <div class="wrapper">
                        <div class="clearfix m-b">
                            <a class="pull-left thumb m-r" href="#">
                                <img class="img-circle" src="{{ asset('assets/images/doctor.png') }}">
                            </a>
                            <div class="clear">
                                <div class="h3 m-t-xs m-b-xs">{{ $patient->short_name }}</div>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> {{ $patient->city . ', ' . $patient->state }}</small>
                            </div>
                        </div>
                        <!--<div class="panel wrapper panel-success">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="#">
                                        <span class="m-b-xs h4 block">245</span>
                                        <small class="text-muted">Followers</small>
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="#">
                                        <span class="m-b-xs h4 block">55</span>
                                        <small class="text-muted">Following</small>
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="#">
                                        <span class="m-b-xs h4 block">2,035</span>
                                        <small class="text-muted">Tweets</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified m-b">
                            <a data-toggle="button" class="btn btn-primary btn-rounded">
                            <span class="text">
                              <i class="fa fa-eye"></i> Follow
                            </span>
                            <span class="text-active">
                              <i class="fa fa-eye-slash"></i> Following
                            </span>
                            </a>
                            <a data-loading-text="Connecting" class="btn btn-dark btn-rounded">
                                <i class="fa fa-comment-o"></i> Chat
                            </a>
                        </div>-->
                        <div>
                            <div class="line"></div>
                            <small class="text-uc text-xs text-muted">Información</small>
                            <ul class="list-unstyled inf-list">
                                <li>
                                    <i class="fa fa-briefcase user-profile-icon"></i> {{ $patient->occupation }}
                                </li>
                                <li>
                                    <i class="fa fa-phone user-profile-icon"></i> <a href="tel:{{ $patient->pref_phone_num }}">{{ $patient->pref_phone_num }}</a>
                                </li>
                                <li>
                                    <i class="fa fa-phone-square user-profile-icon"></i> <a href="tel:{{ $patient->pref_phone_num }}">{{ $patient->pref_phone_num }}</a>
                                </li>
                                <li>
                                    <i class="fa fa-envelope user-profile-icon"></i> <a href="mailto:{{ $patient->email }}">{{ $patient->email }}</a>
                                </li>

                            </ul>
                            <div class="line"></div>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
        <aside class="bg-white">
            <section class="vbox">
                <header class="header bg-grey bg-gradient">
                    <ul class="nav nav-tabs nav-white">
                        <li class="active"><a data-toggle="tab" href="#general-info">Información General</a></li>
                        <li class=""><a data-toggle="tab" href="#events">Historial Médico</a></li>
                        <li class=""><a data-toggle="tab" href="#interaction">Recetas</a></li>
                        <li class=""><a data-toggle="tab" href="#interaction">Medios</a></li>
                    </ul>
                </header>
                <section class="scrollable">
                    <div class="tab-content">
                        <div id="general-info" class="tab-pane active">
                            <div class="padder">
                                <h6><strong>Nombre completo: </strong>{{ $patient->first_name . ' ' . $patient->middle_name . ' ' . $patient->last_name }}</h6>
                                <div class="line"></div>
                                <h6><strong>Correo electrónico: </strong>{{ $patient->email }}</h6>
                                <div class="line"></div>
                                <h6><strong>Estado civil: </strong>{{ $patient->marital_status }}</h6>
                                <div class="line"></div>
                                <h6><strong>Número seguro social: </strong>{{ $patient->social_sec_num }}</h6>
                                <div class="line"></div>
                                <h6><strong>Fecha nacimiento: </strong>{{ $patient->birth_date }}</h6>
                                <div class="line"></div>
                                <h6><strong>Edad: </strong>{{ $patient->age }}</h6>
                                <div class="line"></div>
                                <h6><strong>Sexo: </strong>{{ $patient->sex}}</h6>
                                <div class="line"></div>
                                <h6><strong>Dirección envío: </strong>{{ $patient->mailing_address }}</h6>
                                <div class="line"></div>
                                <h6><strong>Ciudad: </strong>{{ $patient->city }}</h6>
                                <div class="line"></div>
                                <h6><strong>Estado: </strong>{{ $patient->state }}</h6>
                                <div class="line"></div>
                                <h6><strong>Código postal: </strong>{{ $patient->zip }}</h6>
                                <div class="line"></div>
                                <h6><strong>Número de teléfono: </strong>{{ $patient->pref_phone_num }}</h6>
                                <div class="line"></div>
                                <h6><strong>Número de teléfono alternativo: </strong>{{ $patient->alt_phone_num }}</h6>
                                <div class="line"></div>
                                <h6><strong>Ocupación: </strong>{{ $patient->occupation }}</h6>
                                <div class="line"></div>
                                <h6><strong>Empresa: </strong>{{ $patient->employer }}</h6>
                                <div class="line"></div>
                                <h6><strong>Número teléfono</strong>{{ $patient->employer_phone_num }}</h6>
                                <div class="line"></div>
                                <h6><strong>Situación laboral: </strong>{{ $patient->employment_status }}</h6>
                                <div class="line"></div>
                                <h6><strong>Cónyuge / pareja: </strong>{{ $patient->spouse_partner }}</h6>
                                <div class="line"></div>
                                <h6><strong>Número de teléfono - Cónyuge / pareja: </strong>{{ $patient->spouse_partner_phone_num }}</h6>
                                <div class="line"></div>
                                <h6><strong>Visto por otro doctor: </strong>{{ $patient->seen_other_provider == 'Y' ? 'Sí' : 'No' }}</h6>
                                <div class="line"></div>
                                <h6><strong>Nombre Doctor: </strong>{{ $patient->other_provider }}</h6>
                                <div class="line"></div>
                                <h6><strong>Tiene radiografías: </strong>{{ $patient->x_rays == 'Y' ? 'Sí' : 'No' }}</h6>
                                <div class="line"></div>
                                <h6><strong>Fecha radiografías: </strong>{{ $patient->x_rays == 'Y' ? $patient->x_rays_date : 'N/A' }}</h6>
                                <div class="line"></div>
                            </div>
                        </div>
                        <div id="events" class="tab-pane">
                            <div class="text-center wrapper">
                                <i class="fa fa-spinner fa fa-spin fa fa-large"></i>
                            </div>
                        </div>
                        <div id="interaction" class="tab-pane">
                            <div class="text-center wrapper">
                                <i class="fa fa-spinner fa fa-spin fa fa-large"></i>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
        <!--<aside class="col-lg-4 b-l">
            <section class="vbox">
                <section class="scrollable">
                    <div class="wrapper">
                        <section class="panel panel-default">
                            <form>
                                <textarea placeholder="What are you doing..." rows="3" class="form-control no-border"></textarea>
                            </form>
                            <footer class="panel-footer bg-light lter">
                                <button class="btn btn-info pull-right btn-sm">POST</button>
                                <ul class="nav nav-pills nav-sm">
                                    <li><a href="#"><i class="fa fa-camera text-muted"></i></a></li>
                                    <li><a href="#"><i class="fa fa-video-camera text-muted"></i></a></li>
                                </ul>
                            </footer>
                        </section>
                        <section class="panel panel-default">
                            <h4 class="font-thin padder">Latest Tweets</h4>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <p>Wellcome <a class="text-info" href="#">@Drew Wllon</a> and play this web application template, have fun1 </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p>Morbi nec <a class="text-info" href="#">@Jonathan George</a> nunc condimentum ipsum dolor sit amet, consectetur</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 hour ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Josh Long</a> Vestibulum ullamcorper sodales nisi nec adipiscing elit. </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 hours ago</small>
                                </li>
                            </ul>
                        </section>
                        <section class="panel clearfix bg-info lter">
                            <div class="panel-body">
                                <a class="thumb pull-left m-r" href="#">
                                    <img class="img-circle" src="images/avatar.jpg">
                                </a>
                                <div class="clear">
                                    <a class="text-info" href="#">@Mike Mcalidek <i class="fa fa-twitter"></i></a>
                                    <small class="block text-muted">2,415 followers / 225 tweets</small>
                                    <a class="btn btn-xs btn-success m-t-xs" href="#">Follow</a>
                                </div>
                            </div>
                        </section>
                    </div>
                </section>
            </section>
        </aside>-->
    </section>


    <!--<div class="container">
        <div class="page-title">
            <div class="title_left">
                <h3>Información del paciente</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                            <div class="profile_img">

                                <div id="crop-avatar">
                                    <div class="avatar-view" title="Change the avatar">
                                        <img src="{{ asset('assets/images/doctor.png') }}" alt="Avatar">
                                    </div>
                                </div>

                            </div>
                            <h3>{{ $patient->first_name . ' ' .$patient->last_name}}</h3>

                            <ul class="list-unstyled user_data">
                                <li>
                                    <i class="fa fa-map-marker user-profile-icon"></i> {{ $patient->city . ', ' . $patient->state }}
                                </li>
                                <li>
                                    <i class="fa fa-briefcase user-profile-icon"></i> {{ $patient->occupation }}
                                </li>
                                <li>
                                    <i class="fa fa-phone user-profile-icon"></i> {{ $patient->pref_phone_num }}
                                </li>
                                <li>
                                    <i class="fa fa-phone-square user-profile-icon"></i> {{ $patient->pref_phone_num }}
                                </li>
                                <li>
                                    <i class="fa fa-envelope user-profile-icon"></i> {{ $patient->email }}
                                </li>

                            </ul>

                            <a class="btn btn-success"><i class="fa fa-envelope m-right-xs"></i> Enviar notificación al paciente</a>
                            <br />

                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">

                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Información general</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Historial medico</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Recetas</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Medios</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                        <h6><strong>Nombre completo: </strong>{{ $patient->first_name . ' ' . $patient->middle_name . ' ' . $patient->last_name }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Correo electrónico: </strong>{{ $patient->email }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Estado civil: </strong>{{ $patient->marital_status }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Número seguro social: </strong>{{ $patient->social_sec_num }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Fecha nacimiento: </strong>{{ $patient->birth_date }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Edad: </strong>{{ $patient->age }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Sexo: </strong>{{ $patient->sex == 'M' ? 'Masculino' : 'Femenino' }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Dirección envío: </strong>{{ $patient->mailing_address }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Ciudad: </strong>{{ $patient->city }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Estado: </strong>{{ $patient->state }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Código postal: </strong>{{ $patient->zip }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Número de teléfono: </strong>{{ $patient->pref_phone_num }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Número de teléfono alternativo: </strong>{{ $patient->alt_phone_num }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Ocupación: </strong>{{ $patient->occupation }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Empresa: </strong>{{ $patient->employer }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Número teléfono</strong>{{ $patient->employer_phone_num }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Situación laboral: </strong>{{ $patient->employment_status }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Cónyuge / pareja: </strong>{{ $patient->spouse_partner }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Número de teléfono - Cónyuge / pareja: </strong>{{ $patient->spouse_partner_phone_num }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Visto por otro doctor: </strong>{{ $patient->seen_other_provider == 'Y' ? 'Sí' : 'No' }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Nombre Doctor: </strong>{{ $patient->other_provider }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Tiene radiografías: </strong>{{ $patient->x_rays == 'Y' ? 'Sí' : 'No' }}</h6>
                                        <div class="ln_solid_sm"></div>
                                        <h6><strong>Fecha radiografías: </strong>{{ $patient->x_rays == 'Y' ? $patient->x_rays_date : 'N/A' }}</h6>
                                        <div class="ln_solid_sm"></div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">


                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Enfermedad</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Alcoholismo</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Hepatitis</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Abuso de drogas</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Depresión</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Otro</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-default"><i class="fa fa-plus"></i> Agregar al historial</button>

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Medicina</th>
                                                <th>Indicaciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Aclasta(frasco 5mg./100ml.)</td>
                                                <td>Administrar 1 frasco vía intravenosa.</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Actonel(tab. de 35 mg.)</td>
                                                <td>Tomar 1 tableta cada semana x 3 meses.</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Actonel(tab. de 150mg.)</td>
                                                <td>Tomar 1 tableta cada mes x 3 meses.</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Adorlan(tab.)</td>
                                                <td>Tomar 1 tableta cada 8 horas x 10 días.</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Aleve(gel)</td>
                                                <td>Aplicar en área afectada 2 veces al día x 10 días.</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-default"><i class="fa fa-plus"></i> Agregar receta</button>
                                        <button class="btn btn-default"><i class="fa fa-print"></i> Imprimir recetas</button>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                                        <table class="data table table-striped no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre archivo</th>
                                                <th>Tipo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><a>Video cirugía.mp4</a></td>
                                                <td><i class="fa fa-file-video-o" style="font-size: 20px;"></i></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td><a>Video cirugía 2.mp4</a></td>
                                                <td><i class="fa fa-file-video-o" style="font-size: 20px;"></i></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td><a>Video cirugía 3.mp4</a></td>
                                                <td><i class="fa fa-file-video-o" style="font-size: 20px;"></i></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td><a>Imagen final cirugía.jpg</a></td>
                                                <td><i class="fa fa-file-image-o" style="font-size: 20px;"></i></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-default"><i class="fa fa-plus"></i> Agregar archivo(s)</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
@endsection

@push('scripts')

@endpush
