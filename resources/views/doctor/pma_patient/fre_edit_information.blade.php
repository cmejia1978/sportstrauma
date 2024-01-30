@extends('layouts.app')

@section('title', 'Editar información')

@push('styles')
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
@endpush

@section('content-classes', 'scrollable')

@section('content')

    <section class="panel panel-default" style="margin-bottom: 0;">
        <form id="update-patient-form" action="{{ url('patient/profile/update') }}" role="form"
              class="panel-body wrapper-lg">
            <br>
            <h5 class="text-info text-center text-bold">INFORMACIÓN</h5>
            <div class="line bg-info"></div>
            <br>
            <div class="form-group medical-insurance-group">
                <label for="input-medical-insurance-1" class="control-label">¿Tiene seguro médico?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio"  name="medical_insurance"
                               id="input-medical-insurance-1"
                               value="Y" {{ $patient->medical_insurance == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio"  name="medical_insurance"
                               id="input-seen-other-provider-2"
                               value="N" {{ $patient->medical_insurance == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-medical-insurance"></span>
            </div>
             <div class="form-group medical-insurance-name-group">
                <label class="control-label" for="input-surgery-name">Nombre del seguro médico <span
                            class="required">*</span></label>
                <input type="text" id="input-medical-insurance-name" name="medical_insurance_name" class="form-control"
                       value="{{ $patient->medical_insurance_name }}">
                <span style="display: none;" class="help-block message-medical-insurance-name"></span>
            </div>
            <div class="form-group tutor-name-group">
                <label class="control-label" for="input-update-tutor-name">Nombre del padre/tutor (si es menor de 18 años)</label>
                <input type="text" id="input-update-tutor-name" name="tutor_name" class="form-control"
                        value="{{ $patient->tutor_name }}">
                <span style="display: none;" class="help-block message-tutor-name"></span>
            </div>
            <div class="form-group referred-by-group">
                <label class="control-label" for="input-update-referred-by">Referido por</label>
                <input type="text" id="input-update-referred-by" name="referred_by" class="form-control"
                       value="{{ $patient->referred_by }}">
                <span style="display: none;" class="help-block message-referred-by"></span>
            </div>
            <div class="form-group children-info-group">
                <label class="control-label" for="input-update-children-info">¿Tiene hijos, edades?</label>
                <input type="text" id="input-update-children-info" name="children_info" class="form-control"
                        value="{{ $patient->children_info }}">
                <span style="display: none;" class="help-block message-children-info"></span>
            </div>
            <div class="form-group address-group">
                <label class="control-label" for="input-update-address">Dirección casa <span
                            class="required">*</span></label>
                <input type="text" id="input-update-address" name="address" class="form-control"
                       value="{{ $patient->address }}">
                <span style="display: none;" class="help-block message-address"></span>
            </div>
            <div class="form-group pref-phone-num-group">
                <label class="control-label" for="input-update-pref-phone-num">Teléfono casa <span
                            class="required">*</span></label>
                <input type="text" id="input-update-pref-phone-num" name="pref_phone_num" class="form-control"
                       value="{{ $patient->pref_phone_num }}">
                <span style="display: none;" class="help-block message-pref-phone-num"></span>
            </div>
            <div class="form-group alt-phone-num-group">
                <label class="control-label" for="input-update-alt-phone-num">Teléfono celular</label>
                <input type="text" id="input-update-alt-phone-num" name="alt_phone_num" class="form-control"
                       value="{{ $patient->alt_phone_num }}">
                <span style="display: none;" class="help-block message-alt-phone-num"></span>
            </div>
            <div class="form-group mental-services-group">
                <label class="control-label" for="input-update-mental-services">¿Ha recibido cualquier tipo de servicio de salud mental (servicios psicológicos, psiquiátricos etc.)?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" name="mental_services" id="input-update-mental-services-1"
                                value="Y" {{ $patient->mental_services == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" name="mental_services" id="input-update-mental-services-2"
                                value="N" {{ $patient->mental_services == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-mental-services"></span>
            </div>
            <div class="form-group mental-services-info-group">
                <label class="control-label" for="input-update-mental-services-info">¿De qué tipo?</label>
                <input type="text" id="input-update-mental-services-info" name="mental_services_info" class="form-control"
                        value="{{ $patient->mental_services_info }}">
                <span style="display: none;" class="help-block message-mental-services-info"></span>
            </div>
            <div class="form-group medicines-usage-group">
                <label class="control-label" for="input-update-medicines-usage">¿Actualmente está tomando algún tipo de medicamento?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" name="medicines_usage" id="input-update-medicines-usage-1"
                                value="Y" {{ $patient->medicines_usage == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" name="medicines_usage" id="input-update-medicines-usage-2"
                                value="N" {{ $patient->medicines_usage == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-medicines-usage"></span>
            </div>
            <div class="form-group medicines-usage-info-group">
                <label class="control-label" for="input-update-medicines-usage-info">¿Cuales, durante cuánto tiempo?</label>
                <input type="text" id="input-update-medicines-usage-info" name="medicines_usage_info" class="form-control"
                        value="{{ $patient->medicines_usage_info }}">
                <span style="display: none;" class="help-block message-medicines-usage-info"></span>
            </div>
            <div class="line-separator"></div>
            <div style="display: none;" class="alert text-center" id="message-update-info"></div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <a href="{{ url('patient/profile') }}" class="btn btn-info">Cancelar</a>
                    <button type="submit" class="btn btn-success">Actualizar información</button>
                </div>
            </div>

        </form>
    </section>
    <div class="loader-backdrop dt-loader" style="display: none; position: fixed;">
        <div data-loader="circle-side"></div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script src="{{ asset('assets/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/parsley/parsley.min.js') }}"></script>
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('.radio-custom > input[type=radio]').each(function () {
            var $this = $(this);
            if ($this.data('radio')) return;
            $this.radio($this.data());
        });


        var updatePatientForm = $('#update-patient-form'),
                loader = $('.dt-loader');


        updatePatientForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-patient-form .message-full-name').hide();
            $('#update-patient-form .message-medical-insurance').hide();
            $('#update-patient-form .message-medical-insurance-name').hide();
            $('#update-patient-form .message-tutor-name').hide();
            $('#update-patient-form .message-email').hide();
            $('#update-patient-form .message-birth-date').hide();
            $('#update-patient-form .message-address').hide();
            $('#update-patient-form .message-pref-phone-num').hide();
            $('#update-patient-form .message-alt-phone-num').hide();
            $('#update-patient-form .message-mental-services-info');
            $('#update-patient-form .message-medicines-usage-info');

            $('#update-patient-form .full-name-group').removeClass('has-error');
            $('#update-patient-form .medical-insurance-group').removeClass('has-error');
            $('#update-patient-form .medical-insurance-name-group').removeClass('has-error');
            $('#update-patient-form .tutor-name-group').removeClass('has-error');
            $('#update-patient-form .email-group').removeClass('has-error');
            $('#update-patient-form .birth-date-group').removeClass('has-error');
            $('#update-patient-form .address-group').removeClass('has-error');
            $('#update-patient-form .pref-phone-num-group').removeClass('has-error');
            $('#update-patient-form .alt-phone-num-group').removeClass('has-error');
            $('#update-patient-form .mental-services-info-group').removeClass('has-error');
            $('#update-patient-form .medicines-usage-info-group').removeClass('has-error');


            $('#message-registration').hide().removeClass('alert-succes');

            loader.show();

            $.ajax({
                url: '{{ url('patient/profile/update') }}',
                method: 'POST',
                data: updatePatientForm.serialize(),
                success: function (res) {
                    if (res.success) {
                        loader.fadeOut();
                        updatePatientForm[0].reset();
                        window.location.href = '{{ url('patient/profile') }}';
                    } else {

                        if (res.error.full_name) {
                            $('#update-patient-form .full-name-group').addClass('has-error');
                            $('#update-patient-form .message-full-name').html(res.error.full_name).fadeIn();
                        }

                        if (res.error.medical_insurance) {
                            $('#update-patient-form .medical-insurance-group').addClass('has-error');
                            $('#update-patient-form .message-medical-insurance').html(res.error.medical_insurance).fadeIn();
                        }
                        
                        if (res.error.medical_insurance_name) {
                            $('#update-patient-form .medical-insurance-name-group').addClass('has-error');
                            $('#update-patient-form .message-medical-insurance-name').html(res.error.medical_insurance_name).fadeIn();
                        }
                        
                        if (res.error.tutor_name) {
                            $('#update-patient-form .tutor-name-group').addClass('has-error');
                            $('#update-patient-form .message-tutor-name').html(res.error.tutor_name).fadeIn();
                        }

                        if (res.error.email) {
                            $('#update-patient-form .email-group').addClass('has-error');
                            $('#update-patient-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.birth_date) {
                            $('#update-patient-form .birth-date-group').addClass('has-error');
                            $('#update-patient-form .message-birth-date').html(res.error.birth_date).fadeIn();
                        }

                        if (res.error.address) {
                            $('#update-patient-form .address-group').addClass('has-error');
                            $('#update-patient-form .message-address').html(res.error.address).fadeIn();
                        }

                        if (res.error.pref_phone_num) {
                            $('#update-patient-form .pref-phone-num-group').addClass('has-error');
                            $('#update-patient-form .message-pref-phone-num').html(res.error.pref_phone_num).fadeIn();
                        }

                        if (res.error.alt_phone_num) {
                            $('#update-patient-form .alt-phone-num-group').addClass('has-error');
                            $('#update-patient-form .message-alt-phone-num').html(res.error.alt_phone_num).fadeIn();
                        }

                        if (res.error.mental_services_info) {
                            $('#update-patient-form .mental-services-info-group').addClass('has-error');
                            $('#update-patient-form .message-mental-services-info').html(res.error.mental_services_info).fadeIn();
                        }

                        if (res.error.medicines_usage_info) {
                            $('#update-patient-form .medicines-usage-info-group').addClass('has-error');
                            $('#update-patient-form .message-mental-services-info').html(res.error.medicines_usage_info).fadeIn();
                        }
                    }

                    loader.fadeOut();
                }
            });
        });


        var $SOT = $('#input-update-other-provider'),
                $R_SOT = $('input[type=radio][name=seen_other_provider]'),
                $R_SOT_VAL = $('input[type=radio][name=seen_other_provider]:checked').val(),
                $XR_DATE = $('#input-update-x-ray-date'),
                $R_XR = $('input[type=radio][name=x_rays]'),
                $R_XR_VAL = $('input[type=radio][name=x_rays]:checked').val();

        $('#input-update-birth-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: spanishCL,
            startDate: '{{ $patient->birth_date }}',
            minDate: '01/01/1920',
            maxDate: moment().format('12/01/YYYY')
        });

        $XR_DATE.daterangepicker({
            singleDatePicker: true,
            locale: spanishCL,
            showDropdowns: true,
            startDate: '{{ $patient->x_ray_date == '0000-00-00' ? date('Y-m-d') : $patient->x_ray_date }}',
            minDate: '01/01/1920',
            maxDate: moment().format('12/01/YYYY')
        });

        $XR_DATE.daterangepicker({
            singleDatePicker: true,
            locale: spanishCL,
            showDropdowns: true,
            startDate: '{{ $patient->x_ray_date == '0000-00-00' ? date('Y-m-d') : $patient->x_ray_date }}',
            minDate: '01/01/1920',
            maxDate: moment().format('12/01/YYYY')
        });

        /*if ($R_XR_VAL == 'Y') {
         $XR_DATE .daterangepicker({
         singleDatePicker: true,
         locale: spanishCL,
         drops: "up"
         });
         } else {
         $XR_DATE.data('daterangepicker').container.remove();
         }*/


        changeInputState($R_SOT_VAL, $SOT, 'N/A', true);
        //changeInputState($R_XR_VAL, $XR_DATE, '00/00/0000', true);

        $R_SOT.change(function () {
            changeInputState(this.value, $SOT, 'N/A', true);
        });

        $R_XR.change(function () {
            changeInputState(this.value, $XR_DATE, '00/00/0000', true);
        });

        function changeInputState(value, el, inval, disen) {
            if (value == 'Y') {
                if (disen) {
                    el.prop('disabled', false);
                }

                if (inval == '00/00/0000') {
                    el.val(moment().format('DD/MM/YYYY'));
                } else {
                    el.val('');
                }
            } else {
                if (disen) {
                    el.prop('disabled', true);
                }
                el.val(inval);
            }
        }
    });
</script>
@endpush
