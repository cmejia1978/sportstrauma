@extends('layouts.frontend')

@section('title', 'Registro paciente')

@push('styles')
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
@endpush

@section('content')

    <section id="content" class="m-t-lg animated fadeInUp">
        <div class="container aside-register">
            <a class="navbar-brand auth-brand block" href="/"><img class="logo-auth" src="{{ asset('assets/images/logo-color.png') }}" alt="Sportrauma Center"></a>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <section class="panel panel-default bg-white m-t-xl">
                <header class="panel-heading text-center">
                    <strong>Registro nuevo paciente</strong>
                </header>

                <form id="add-patient-form" action="{{ url('register-patient') }}" role="form" class="panel-body wrapper-lg">
                    <div class="form-group">
                        <label class="control-label" for="input-doctor">¿Quién lo atenderá?<span class="required">*</span></label>
                        @foreach ($doctors as $index => $doctor)
                            @if ($doctor->name == 'Doctor prueba')
                                <div class="radio" style="display: none;">
                                    <label class="radio-custom">
                                        <input type="radio" name="doctor" id="input-doctor-{{ $index }}" value="{{ $doctor->id }}" {{ $index == 0 ? 'checked="checked"' : ''}}>
                                        <i class="fa fa-circle-o"></i>
                                        {{ $doctor->name }}
                                    </label>
                                </div>
                            @else
                                <div class="radio">
                                    <label class="radio-custom">
                                        <input type="radio" name="doctor" id="input-doctor-{{ $index }}" value="{{ $doctor->id }}" {{ $index == 0 ? 'checked="checked"' : ''}}>
                                        <i class="fa fa-circle-o"></i>
                                        {{ $doctor->name. ($doctor->id == 2 ? '/Traumatólogo y Ortopedista' : ($doctor->id == 3 ? '/Psicóloga Clínica y Deportiva' : '') ) }}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    </div>
    
                    <div class="form-group full-name-group">
                        <label class="control-label" for="input-full-name">Nombre completo <span class="required">*</span></label>
                        <input type="text" id="input-full-name" name="full_name" class="form-control" value="">
                        <span style="display: none;" class="help-block message-full-name"></span>
                    </div>
                    <div class="form-group medical-insurance-group">
                        <label for="input-medical-insurance-1" class="control-label">¿Tiene seguro médico?</label>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio"  name="medical_insurance"
                                       id="input-medical-insurance-1"
                                       value="Y" checked="checked">
                                <i class="fa fa-circle-o"></i>
                                Sí
                            </label>
                        </div>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio"  name="medical_insurance"
                                       id="input-seen-other-provider-2"
                                       value="N">
                                <i class="fa fa-circle-o"></i>
                                No
                            </label>
                        </div>
                        <span style="display: none;" class="help-block message-medical-insurance"></span>
                    </div>
                     <div class="form-group medical-insurance-name-group">
                        <label class="control-label" for="input-surgery-name">Nombre del seguro médico</label>
                        <input type="text" id="input-medical-insurance-name" name="medical_insurance_name" class="form-control"
                               value="">
                        <span style="display: none;" class="help-block message-medical-insurance-name"></span>
                    </div>
                    <div class="form-group email-group">
                        <label class="control-label" for="input-email">Correo <span class="required">*</span></label>
                        <input type="text" id="input-email" name="email" class="form-control" value="">
                        <span style="display: none;" class="help-block message-email"></span>
                    </div>
                    <div class="form-group marital-status-group">
                        <label class="control-label">Estado Civil <span class="required">*</span></label>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="marital_status" id="input-mt-1" value="Soltero" checked="checked">
                                <i class="fa fa-circle-o"></i>
                                Soltero/a
                            </label>
                        </div>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="marital_status" id="input-mt-2" value="Unión Libre">
                                <i class="fa fa-circle-o"></i>
                                Unión Libre
                            </label>
                        </div>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="marital_status" id="input-mt-3" value="Casado">
                                <i class="fa fa-circle-o"></i>
                                Casado/a
                            </label>
                        </div>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="marital_status" id="input-mt-4" value="Divorciado">
                                <i class="fa fa-circle-o"></i>
                                Divorciado/a
                            </label>
                        </div>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="marital_status" id="input-mt-5" value="Separado">
                                <i class="fa fa-circle-o"></i>
                                Separado/a
                            </label>
                        </div>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="marital_status" id="input-mt-6" value="Viudo">
                                <i class="fa fa-circle-o"></i>
                                Viudo/a
                            </label>
                        </div>
                        <span style="display: none;" class="help-block message-marital-status"></span>
                    </div>
                    <div class="form-group birth-date-group">
                        <label class="control-label" for="input-birth-date">Fecha de Nacimiento <span class="required">*</span></label>
                        <input type="text" id="input-birth-date" name="birth_date" readonly="" class="form-control" value="{{ date('d/m/Y') }}">
                        <span style="display: none;" class="help-block message-birth-date"></span>
                    </div>
                    <div class="form-group sex-group">
                        <label class="control-label" for="input-sex">Sexo <span class="required">*</span></label>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="sex" id="input-sex-1" value="Masculino" checked="checked">
                                <i class="fa fa-circle-o"></i>
                                Masculino
                            </label>
                        </div>
                        <div class="radio">
                            <label class="radio-custom">
                                <input type="radio" name="sex" id="input-sex-2" value="Femenino">
                                <i class="fa fa-circle-o"></i>
                                Femenino
                            </label>
                        </div>
                        <span style="display: none;" class="help-block message-sex"></span>
                    </div>
                    <div class="form-group address-group">
                        <label class="control-label" for="input-address">Dirección<span class="required">*</span></label>
                        <input type="text" id="input-address" name="address" class="form-control" value="">
                        <span style="display: none;" class="help-block message-address"></span>
                    </div>
                    <div class="form-group pref-phone-num-group">
                        <label class="control-label" for="input-pref-phone-num">Teléfono casa <span class="required">*</span></label>
                        <input type="text" id="input-pref-phone-num" name="pref_phone_num" class="form-control" value="">
                        <span style="display: none;" class="help-block message-pref-phone-num"></span>
                    </div>
                    <div class="form-group alt-phone-num-group">
                        <label class="control-label" for="input-alt-phone-num">Teléfono celular</label>
                        <input type="text" id="input-alt-phone-num" name="alt_phone_num" class="form-control" value="">
                        <span style="display: none;" class="help-block message-alt-phone-num"></span>
                    </div>
                    <div class="ln_solid"></div>
                    <div style="display: none;" class="alert text-center" id="message-registration"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-success">Registrar información</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </section>
    <div class="loader-backdrop dt-loader" style="display: none;">
        <div data-loader="circle-side"></div>
    </div>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder">
            <p>
                <small>Todos los derechos reservados. Sportrauma Center &copy; {{ date('Y') }} </small>
            </p>
        </div>
    </footer>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/daterangepicker.js') }}"></script>
<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('.radio-custom > input[type=radio]').each(function () {var $this = $(this);if ($this.data('radio')) return; $this.radio($this.data());});


        var addPatientForm     = $('#add-patient-form'),
            loader             = $('.dt-loader');

        addPatientForm.on('submit', function(e) {
            e.preventDefault();

            $('#add-patient-form .message-full-name').hide();
            $('#add-patient-form .message-medical-insurance').hide();
            $('#add-patient-form .message-medical-insurance-name').hide();
            $('#add-patient-form .message-email').hide();
            $('#add-patient-form .message-social-sec-num').hide();
            $('#add-patient-form .message-birth-date').hide();
            $('#add-patient-form .message-age').hide();
            $('#add-patient-form .message-mailing-address').hide();
            $('#add-patient-form .message-city').hide();
            $('#add-patient-form .message-state').hide();
            $('#add-patient-form .message-zip').hide();
            $('#add-patient-form .message-pref-phone-num').hide();
            $('#add-patient-form .message-alt-phone-num').hide();
            $('#add-patient-form .message-occupation').hide();
            $('#add-patient-form .message-employer').hide();
            $('#add-patient-form .message-employment-status').hide();
            $('#add-patient-form .message-spouse-partner').hide();
            $('#add-patient-form .message-spouse-partner-phone-num').hide();
            $('#add-patient-form .message-seen-other-provider').hide();
            $('#add-patient-form .message-other-provider').hide();
            $('#add-patient-form .message-x-rays').hide();
            $('#add-patient-form .message-x-ray-date').hide();

            $('#add-patient-form .full-name-group').removeClass('has-error');
            $('#add-patient-form .medical-insurance-group').removeClass('has-error');
            $('#add-patient-form .medical-insurance-name-group').removeClass('has-error');
            $('#add-patient-form .email-group').removeClass('has-error');
            $('#add-patient-form .social-sec-num-group').removeClass('has-error');
            $('#add-patient-form .birth-date-group').removeClass('has-error');
            $('#add-patient-form .age-group').removeClass('has-error');
            $('#add-patient-form .mailing-address-group').removeClass('has-error');
            $('#add-patient-form .city-group').removeClass('has-error');
            $('#add-patient-form .state-group').removeClass('has-error');
            $('#add-patient-form .zip-group').removeClass('has-error');
            $('#add-patient-form .pref-phone-num-group').removeClass('has-error');
            $('#add-patient-form .alt-phone-num-group').removeClass('has-error');
            $('#add-patient-form .occupation-group').removeClass('has-error');
            $('#add-patient-form .employer-group').removeClass('has-error');
            $('#add-patient-form .employer-phone-num-group').removeClass('has-error');
            $('#add-patient-form .spouse-partner-phone-num-group').removeClass('has-error');
            $('#add-patient-form .other-provider-group').removeClass('has-error');
            $('#add-patient-form .x-ray-date-group').removeClass('has-error');

            $('#message-registration').hide().removeClass('alert-succes');

            loader.show();

            $.ajax({
                url: '{!! url('register-patient') !!}',
                method: 'POST',
                data: addPatientForm.serialize(),
                success: function(res) {
                    if (res.success) {
                        loader.fadeOut();
                        addPatientForm[0].reset();
                        window.location.href = '{{ url('thank-you') }}';
                    } else {

                        if (res.error.full_name) {
                            $('#add-patient-form .full-name-group').addClass('has-error');
                            $('#add-patient-form .message-full-name').html(res.error.full_name).fadeIn();
                        }

                        if (res.error.medical_insurance) {
                            $('#add-patient-form .medical-insurance-group').addClass('has-error');
                            $('#add-patient-form .message-medical-insurance').html(res.error.medical_insurance).fadeIn();
                        }
                        
                        if (res.error.medical_insurance_name) {
                            $('#add-patient-form .medical-insurance-name-group').addClass('has-error');
                            $('#add-patient-form .message-medical-insurance-name').html(res.error.medical_insurance_name).fadeIn();
                        }

                        if (res.error.email) {
                            $('#add-patient-form .email-group').addClass('has-error');
                            $('#add-patient-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.social_sec_num) {
                            $('#add-patient-form .social-sec-num-group').addClass('has-error');
                            $('#add-patient-form .message-social-sec-num').html(res.error.social_sec_num).fadeIn();
                        }

                        if (res.error.birth_date) {
                            $('#add-patient-form .birth-date-group').addClass('has-error');
                            $('#add-patient-form .message-birth-date').html(res.error.birth_date).fadeIn();
                        }

                        if (res.error.age) {
                            $('#add-patient-form .age-group').addClass('has-error');
                            $('#add-patient-form .message-age').html(res.error.age).fadeIn();
                        }

                        if (res.error.mailing_address) {
                            $('#add-patient-form .mailing-address-group').addClass('has-error');
                            $('#add-patient-form .message-mailing-address').html(res.error.mailing_address).fadeIn();
                        }

                        if (res.error.city) {
                            $('#add-patient-form .city-group').addClass('has-error');
                            $('#add-patient-form .message-city').html(res.error.city).fadeIn();
                        }

                        if (res.error.state) {
                            $('#add-patient-form .state-group').addClass('has-error');
                            $('#add-patient-form .message-state').html(res.error.state).fadeIn();
                        }

                        if (res.error.zip) {
                            $('#add-patient-form .zip-group').addClass('has-error');
                            $('#add-patient-form .message-zip   ').html(res.error.zip).fadeIn();
                        }

                        if (res.error.pref_phone_num) {
                            $('#add-patient-form .pref-phone-num-group').addClass('has-error');
                            $('#add-patient-form .message-pref-phone-num').html(res.error.pref_phone_num).fadeIn();
                        }

                        if (res.error.alt_phone_num) {
                            $('#add-patient-form .alt-phone-num-group').addClass('has-error');
                            $('#add-patient-form .message-alt-phone-num').html(res.error.alt_phone_num).fadeIn();
                        }

                        if (res.error.occupation) {
                            $('#add-patient-form .occupation-group').addClass('has-error');
                            $('#add-patient-form .message-occupation').html(res.error.occupation).fadeIn();
                        }

                        if (res.error.employer_phone_num) {
                            $('#add-patient-form .employer-phone-num-group').addClass('has-error');
                            $('#add-patient-form .message-employer-phone-num').html(res.error.employer_phone_num).fadeIn();
                        }

                        if (res.error.spouse_partner_phone_num) {
                            $('#add-patient-form .spouse-partner-phone-num-group').addClass('has-error');
                            $('#add-patient-form .message-spouse-partner-phone-num').html(res.error.spouse_partner_phone_num).fadeIn();
                        }

                        if (res.error.other_provider) {
                            $('#add-patient-form .other-provider-group').addClass('has-error');
                            $('#add-patient-form .message-other-provider').html(res.error.other_provider).fadeIn();
                        }

                        if (res.error.x_ray_date) {
                            $('#add-patient-form .x-ray-date-group').addClass('has-error');
                            $('#add-patient-form .message-x-ray-date').html(res.error.x_ray_date).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });

        $('#input-birth-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: spanishCL,
            startDate: '01/01/2015',
            minDate: '01/01/1920',
            maxDate: moment().format('12/01/YYYY')
        });
    });
</script>
@endpush
