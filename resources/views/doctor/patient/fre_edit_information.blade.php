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
            <div class="form-group occupation-group">
                <label class="control-label" for="input-update-occupation">Ocupación</label>
                <input type="text" id="input-update-occupation" name="occupation" class="form-control"
                       value="{{ $patient->occupation }}">
                <span style="display: none;" class="help-block message-occupation"></span>
            </div>
            <div class="form-group birth-location-group">
                <label class="control-label" for="input-update-birth-location">Lugar de nacimiento</label>
                <input type="text" id="input-update-birth-location" name="birth_location" class="form-control"
                       value="{{ $patient->birth_location }}">
                <span style="display: none;" class="help-block message-birth-location"></span>
            </div>
            <div class="form-group religion-group">
                <label class="control-label" for="input-update-religion">Religión</label>
                <input type="text" id="input-update-religion" name="religion" class="form-control"
                       value="{{ $patient->religion }}">
                <span style="display: none;" class="help-block message-religion"></span>
            </div>
            <div class="form-group referred-by-group">
                <label class="control-label" for="input-update-referred-by">Referido por</label>
                <input type="text" id="input-update-referred-by" name="referred_by" class="form-control"
                       value="{{ $patient->referred_by }}">
                <span style="display: none;" class="help-block message-referred-by"></span>
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
            <div class="form-group employer-group">
                <label class="control-label" for="input-update-employer">Empresa</label>
                <input type="text" id="input-update-employer" name="employer" class="form-control"
                       value="{{ $patient->employer }}">
                <span style="display: none;" class="help-block message-employer"></span>
            </div>
            <div class="form-group seen-other-provider-group">
                <label for="input-update-seen-other-provider-1" class="control-label">¿Ha sido visto por otro médico por
                    éste problema?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="seen-other-provider" name="seen_other_provider"
                               id="input-update-seen-other-provider-1"
                               value="Y" {{ $patient->seen_other_provider == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="seen-other-provider" name="seen_other_provider"
                               id="input-update-seen-other-provider-2"
                               value="N" {{ $patient->seen_other_provider == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-seen-other-provider"></span>
            </div>
            <div class="form-group other-provider-country-group">
                <label class="control-label" for="input-update-other-provider-country">País</label>
                <input type="text" id="input-update-other-provider-country" name="other_provider_country"
                       class="form-control" value="{{ $patient->other_provider_country }}">
                <span style="display: none;" class="help-block message-other-provider-country"></span>
            </div>
            <div class="form-group x-rays-group">
                <label for="input-update-x-rays-1" class="control-label">¿Tiene estudios de Rayos X o Resonancia?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="x-rays" name="x_rays" id="input-update-x-rays-1"
                               value="Y" {{ $patient->x_rays == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="x-rays" name="x_rays" id="input-update-x-rays-2"
                               value="N" {{ $patient->x_rays == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-x-rays"></span>
            </div>
            <div class="form-group x-ray-date-group">
                <label for="input-update-x-ray-date" class="control-label">Fecha</label>
                <input type="text" id="input-update-x-ray-date" readonly="" name="x_ray_date" class="form-control"
                       value="{{ $patient->x_ray_date }}">
                <span style="display: none;" class="help-block message-x-ray-date"></span>
            </div>
            <div class="form-group operated-group">
                <label for="input-update-operated-1" class="control-label">¿Ha sido operado?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="operated" name="operated" id="input-update-operated" value="Y"
                               checked="checked" {{ $patient->operated == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="operated" name="operated" id="input-update-operated-2"
                               value="N" {{ $patient->operated == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-operated"></span>
            </div>
            <div class="form-group operated-info-group">
                <label for="input-update-operated-info" class="control-label">¿De qué?</label>
                <input type="text" id="input-update-operated-info" name="operated_info" class="form-control"
                       value="{{ $patient->operated_info }}">
                <span style="display: none;" class="help-block message-operated-info"></span>
            </div>

            <br>
            <h5 class="text-info text-center text-bold">HISTORIAL CLÍNICO</h5>
            <div class="line bg-info"></div>
            <br>

            <div class="form-group medical-inquiry-reason-group">
                <label for="input-update-medical-inquiry-reason" class="control-label">¿Cuál es la razón de su consulta?
                   </label>
                <input type="text" id="input-update-medical-inquiry-reason" name="medical_inquiry_reason"
                       class="form-control" value="{{ $patient->medical_inquiry_reason }}">
                <span style="display: none;" class="help-block message-medical-inquiry-reason"></span>
            </div>

            <div class="form-group medical-problem-time-group">
                <label for="input-update-medical-problem-time" class="control-label">¿Tiempo de tener el problema?</label>
                <input type="text" id="input-update-medical-problem-time" name="medical_problem_time"
                       class="form-control" value="{{ $patient->medical_problem_time }}">
                <span style="display: none;" class="help-block message-medical-problem-time"></span>
            </div>
            <div class="form-group medical-problem-coup-group">
                <label for="input-update-medical-problem-coup-1" class="control-label">¿El problema empezó por un golpe?
                   </label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="medical-problem-coup" name="medical_problem_coup"
                               id="input-update-medical-problem-coup"
                               value="Y" {{ $patient->medical_problem_coup == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="medical-problem-coup" name="medical_problem_coup"
                               id="input-update-medical-problem-coup-2"
                               value="N" {{ $patient->medical_problem_coup == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-medical-problem-coup"></span>
            </div>
            <div class="form-group medical-problem-coup-info-group">
                <label for="input-update-medical-problem-coup-info" class="control-label">¿Comó fué el golpe?</label>
                <input type="text" id="input-update-medical-problem-coup-info" name="medical_problem_coup_info"
                       class="form-control" value="{{ $patient->medical_problem_coup_info }}">
                <span style="display: none;" class="help-block message-medical-problem-coup-info"></span>
            </div>
            <div class="form-group sport-practice-group">
                <label for="input-update-sport-practice-1" class="control-label">¿Practica algún deporte?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="sport-practice" name="sport_practice"
                               id="input-update-sport-practice"
                               value="Y" {{ $patient->sport_practice == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="sport-practice" name="sport_practice"
                               id="input-update-sport-practice-2"
                               value="N" {{ $patient->sport_practice == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-sport-practice"></span>
            </div>
            <div class="form-group sport-practice-info-group">
                <label for="input-update-sport-practice-info" class="control-label">¿Cuál?</label>
                <input type="text" id="input-update-sport-practice-info" name="sport_practice_info" class="form-control"
                       value="{{ $patient->sport_practice_info }}">
                <span style="display: none;" class="help-block message-sport-practice-info"></span>
            </div>
            <div class="form-group diseases-group">
                <label for="input-update-diseases-1" class="control-label">Marque si tiene o ha tenido alguna de éstas
                    enfermedades</label>
                @if ($patient->checkbox_diseases)
                    @foreach ($patient->checkbox_diseases as $index => $disease)
                        <div class="checkbox">
                            <label class="checkbox-custom">
                                <input type="checkbox" data-update="disease" name="diseases[]"
                                       id="input-update-disease-{{ $index }}"
                                       value="{{ $disease->id }}" {{ $disease->checked == 'yes' ? 'checked="checked"' : '' }}>
                                <i class="fa fa-fw fa-square-o"></i>
                                {{ $disease->name}}
                            </label>
                        </div>
                    @endforeach
                @else
                    @foreach ($diseases as $index => $disease)
                        <div class="checkbox">
                            <label class="checkbox-custom">
                                <input type="checkbox" data-update="disease" name="diseases[]"
                                       id="input-update-disease-{{ $index }}" value="{{ $disease->id }}">
                                <i class="fa fa-fw fa-square-o"></i>
                                {{ $disease->name }}
                            </label>
                        </div>
                    @endforeach
                @endif
                <span style="display: none;" class="help-block message-diseases"></span>
            </div>
            <div class="form-group exercise-group">
                <label for="input-update-exercise-1" class="control-label">¿Hace ejercicio?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="exercise" name="exercise" id="input-update-exercise"
                               value="Y" {{ $patient->exercise == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="exercise" name="exercise" id="input-update-exercise-2"
                               value="N" {{ $patient->exercise == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-exercise"></span>
            </div>
            <div class="form-group exercise-info-group">
                <label for="input-update-exercise-info-1" class="control-label">¿Cual?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="exercise-info" name="exercise_info"
                               id="input-update-exercise-info"
                               value="Sedentario(no ejercicio)" {{ $patient->exercise_info == 'Sedentario(no ejercicio)' ? 'checked="checked"' : $patient->exercise == '' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        Sedentario(no ejercicio)
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="exercise-info" name="exercise_info"
                               id="input-update-exercise-info"
                               value="Ejercicio leve(subir gradas, caminar 3 cuadras, golf)" {{ $patient->exercise_info == 'Ejercicio leve(subir gradas, caminar 3 cuadras, golf)' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        Ejercicio leve(subir gradas, caminar 3 cuadras, golf)
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="exercise-info" name="exercise_info"
                               id="input-update-exercise-info"
                               value="Ejercicio moderado(caminar rápido, bailar, trabajos de casa)" {{ $patient->exercise_info == 'Ejercicio moderado(caminar rápido, bailar, trabajos de casa)' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        Ejercicio moderado(caminar rápido, bailar, trabajos de casa)
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="exercise-info" name="exercise_info"
                               id="input-update-exercise-info"
                               value="Ocasional vigoroso(menos de 4x/semana x 30 minutos)" {{ $patient->exercise_info == 'Ocasional vigoroso(menos de 4x/semana x 30 minutos)' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        Ocasional vigoroso(menos de 4x/semana x 30 minutos)
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="exercise-info" name="exercise_info"
                               id="input-update-exercise-info"
                               value="Regular vigoroso(más de 4 x/semana x 30 minutos)" {{ $patient->exercise_info == 'Regular vigoroso(más de 4 x/semana x 30 minutos)' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        Regular vigoroso(más de 4 x/semana x 30 minutos)
                    </label>
                </div>
                <span style="display: none;" class="help-block message-exercise-info"></span>
            </div>
            <div class="form-group alcohol-group">
                <label for="input-update-alcohol-1" class="control-label">¿Consume alcohol?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="alcohol" name="alcohol" id="input-update-alcohol"
                               value="Y" {{ $patient->alcohol == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="alcohol" name="alcohol" id="input-update-alcohol-2"
                               value="N" {{ $patient->alcohol == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-alcohol"></span>
            </div>
            <div class="form-group alcohol-usage-group">
                <label for="input-update-alcohol-usage-1" class="control-label">¿Cuando?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="alcohol-usage" name="alcohol_usage"
                               id="input-update-alcohol-usage"
                               value="Diario" {{ $patient->alcohol_usage == 'Diario' ? 'checked="checked"' : $patient->alcohol == '' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        Diario
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="alcohol-usage" name="alcohol_usage"
                               id="input-update-alcohol-usage"
                               value="1-2 x semana" {{ $patient->alcohol_usage == '1-2 x semana' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        1-2 x semana
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="alcohol-usage" name="alcohol_usage"
                               id="input-update-alcohol-usage"
                               value="1-2 x mes" {{ $patient->alcohol_usage == '1-2 x mes' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        1-2 x mes
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="alcohol-usage" name="alcohol_usage"
                               id="input-update-alcohol-usage"
                               value="1-2 x año" {{ $patient->alcohol_usage == '1-2 x año' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-fw fa-circle-o"></i>
                        1-2 x año
                    </label>
                </div>
                <span style="display: none;" class="help-block message-alcohol-usage"></span>
            </div>
            <div class="form-group smokes-group">
                <label for="input-update-smokes-1" class="control-label">¿Fuma?</label>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="smokes" name="smokes" id="input-update-smokes"
                               value="Y" {{ $patient->smokes == 'Y' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        Sí
                    </label>
                </div>
                <div class="radio">
                    <label class="radio-custom">
                        <input type="radio" data-update="smokes" name="smokes" id="input-update-smokes-2"
                               value="N" {{ $patient->smokes == 'N' ? 'checked="checked"' : '' }}>
                        <i class="fa fa-circle-o"></i>
                        No
                    </label>
                </div>
                <span style="display: none;" class="help-block message-smokes"></span>
            </div>
            <div class="form-group smokes-per-day-group">
                <label for="input-update-smokes-per-day" class="control-label">¿Cuántos cigarrillos al día?</label>
                <input type="text" id="input-update-smokes-per-day" name="smokes_per_day" class="form-control"
                       value="{{ $patient->smokes_per_day }}">
                <span style="display: none;" class="help-block message-smokes-per-day"></span>
            </div>
            <div class="form-group smokes-years-group">
                <label for="input-update-smokes-years" class="control-label">¿Cuántos años de fumar?</label>
                <input type="text" id="input-update-smokes-years" name="smokes_years" class="form-control"
                       value="{{ $patient->smokes_years }}">
                <span style="display: none;" class="help-block message-smokes-years"></span>
            </div>
            <br>
            <h5 class="text-info text-center text-bold">MEDICAMENTOS</h5>
            <div class="line bg-info"></div>
            <br>
            <div class="form-group field-group">
                <label for="input-update-field" class="control-label">Escriba los medicamentos que está utilizando
                    actualmente</label>
                <table class="table">
                    <thead>
                    <tr>
                        <th width="50%">Nombre</th>
                        <th width="50%">Dosis/Frecuencia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($patient->medicines_fields as $index => $field)
                        <tr>
                            <td>
                                <div class="form-group medicine-{{ $index + 1 }}-name-group">
                                    <input class="form-control" name="medicine[{{ $index + 1 }}][name]" type="text"
                                           value="{{ $field->name }}">
                                    <span style="display: none;"
                                          class="help-block message-medicine-{{ $index + 1 }}-name"></span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group medicine-{{ $index + 1 }}-dose-frequency-group">
                                    <input class="form-control" name="medicine[{{ $index + 1 }}][dose_frequency]"
                                           type="text" value="{{ $field->dose_frequency }}">
                                    <span style="display: none;"
                                          class="help-block message-medicine-{{ $index + 1 }}-dose-frequency"></span>
                                </div>
                                <input type="hidden" name="medicine[{{ $index + 1 }}][id]" value="{{ $field->id }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            <h5 class="text-info text-center text-bold">ALERGIAS</h5>
            <div class="line bg-info"></div>
            <br>
            <div class="form-group allergies-group">
                <label for="input-update-allergies" class="control-label">Escriba alergias de medicamentos, alimentarias
                    o de otro tipo que haya tenido </label>
                <textarea id="input-update-allergies" name="allergies"
                          class="form-control">{{ $patient->allergies }}</textarea>
                <span style="display: none;" class="help-block message-allergies"></span>
            </div>
            <div class="form-group allergies-cause-group">
                <label for="input-update-allergies-cause" class="control-label">¿Qué le causo alergia?</label>
                <input type="text" id="input-update-allergies-cause" name="allergies_cause" class="form-control"
                       value="{{ $patient->allergies_cause }}">
                <span style="display: none;" class="help-block message-allergies-cause"></span>
            </div>
            <div class="form-group allergies-reaction-group">
                <label for="input-update-allergies-reaction" class="control-label">¿Qué reacción tuvo?</label>
                <input type="text" id="input-update-allergies-reaction" name="allergies_reaction" class="form-control"
                       value="{{ $patient->allergies_reaction }}">
                <span style="display: none;" class="help-block message-allergies-reaction"></span>
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
            $('#update-patient-form .message-email').hide();
            $('#update-patient-form .message-religion').hide();
            $('#update-patient-form .message-birth-date').hide();
            $('#update-patient-form .message-birth-location').hide();
            $('#update-patient-form .message-address').hide();
            $('#update-patient-form .message-pref-phone-num').hide();
            $('#update-patient-form .message-alt-phone-num').hide();
            $('#update-patient-form .message-occupation').hide();
            $('#update-patient-form .message-employer').hide();
            $('#update-patient-form .message-other-provider').hide();
            $('#update-patient-form .message-other-provider-country').hide();
            $('#update-patient-form .message-x-rays').hide();
            $('#update-patient-form .message-x-ray-date').hide();
            $('#update-patient-form .message-operated_info').hide();
            $('#update-patient-form .message-medical-inquiry-reason').hide();
            $('#update-patient-form .message-medical-problem-time').hide();
            $('#update-patient-form .message-medical-problem-coup-info').hide();
            $('#update-patient-form .message-sport-practice-info').hide();
            $('#update-patient-form .message-exercise-info').hide();
            $('#update-patient-form .message-alcohol-usage').hide();
            $('#update-patient-form .message-smokes-per-day').hide();
            $('#update-patient-form .message-smokes-years').hide();
            $('#update-patient-form .message-allergies-cause').hide();
            $('#update-patient-form .message-allergies-reaction').hide();
            $('#update-patient-form .message-medicine-1-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-1-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-2-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-2-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-3-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-3-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-4-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-4-dose-frequency').removeClass('has-error');
            $('#update-patient-form .message-medicine-5-name').removeClass('has-error');
            $('#update-patient-form .message-medicine-5-dose-frequency').removeClass('has-error');

            $('#update-patient-form .full-name-group').removeClass('has-error');
            $('#update-patient-form .medical-insurance-group').removeClass('has-error');
            $('#update-patient-form .medical-insurance-name-group').removeClass('has-error');
            $('#update-patient-form .email-group').removeClass('has-error');
            $('#update-patient-form .religion-group').removeClass('has-error');
            $('#update-patient-form .birth-date-group').removeClass('has-error');
            $('#update-patient-form .birth-location-group').removeClass('has-error');
            $('#update-patient-form .address-group').removeClass('has-error');
            $('#update-patient-form .pref-phone-num-group').removeClass('has-error');
            $('#update-patient-form .alt-phone-num-group').removeClass('has-error');
            $('#update-patient-form .occupation-group').removeClass('has-error');
            $('#update-patient-form .employer-group').removeClass('has-error');
            $('#update-patient-form .other-provider-country-group').removeClass('has-error');
            $('#update-patient-form .x-ray-date-group').removeClass('has-error');
            $('#update-patient-form .operated-info-group').removeClass('has-error');
            $('#update-patient-form .medical-inquiry-reason-group').removeClass('has-error');
            $('#update-patient-form .medical-problem-time-group').removeClass('has-error');
            $('#update-patient-form .medical-problem-coup-info-group').removeClass('has-error');
            $('#update-patient-form .sport-practice-info-group').removeClass('has-error');
            $('#update-patient-form .exercise-info-group').removeClass('has-error');
            $('#update-patient-form .alcohol-usage-group').removeClass('has-error');
            $('#update-patient-form .smokes-per-day-group').removeClass('has-error');
            $('#update-patient-form .smokes-year-group').removeClass('has-error');
            $('#update-patient-form .allergies-cause-group').removeClass('has-error');
            $('#update-patient-form .allergies-reaction-group').removeClass('has-error');
            $('#update-patient-form .medicine-1-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-1-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-2-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-2-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-3-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-3-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-4-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-4-dose-frequency-group').removeClass('has-error');
            $('#update-patient-form .medicine-5-name-group').removeClass('has-error');
            $('#update-patient-form .medicine-5-dose-frequency-group').removeClass('has-error');


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
                    
                        if (res.error.religion) {
                            $('#update-patient-form .religion-group').addClass('has-error');
                            $('#update-patient-form .message-religion').html(res.error.religion).fadeIn();
                        }

                        if (res.error.email) {
                            $('#update-patient-form .email-group').addClass('has-error');
                            $('#update-patient-form .message-email').html(res.error.email).fadeIn();
                        }

                        if (res.error.birth_date) {
                            $('#update-patient-form .birth-date-group').addClass('has-error');
                            $('#update-patient-form .message-birth-date').html(res.error.birth_date).fadeIn();
                        }

                        if (res.error.birth_location) {
                            $('#update-patient-form .birth-location-group').addClass('has-error');
                            $('#update-patient-form .message-birth-location').html(res.error.birth_location).fadeIn();
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

                        if (res.error.occupation) {
                            $('#update-patient-form .occupation-group').addClass('has-error');
                            $('#update-patient-form .message-occupation').html(res.error.occupation).fadeIn();
                        }

                        if (res.error.other_provider_country) {
                            $('#update-patient-form .other-provider-country-group').addClass('has-error');
                            $('#update-patient-form .message-other-provider-country').html(res.error.other_provider_country).fadeIn();
                        }

                        if (res.error.x_ray_date) {
                            $('#update-patient-form .x-ray-date-group').addClass('has-error');
                            $('#update-patient-form .message-x-ray-date').html(res.error.x_ray_date).fadeIn();
                        }

                        if (res.error.operated_info) {
                            $('#update-patient-form .operated-info-group').addClass('has-error');
                            $('#update-patient-form .message-operated-info').html(res.error.operated_info).fadeIn();
                        }

                        if (res.error.medical_inquiry_reason) {
                            $('#update-patient-form .medical-inquiry-reason-group').addClass('has-error');
                            $('#update-patient-form .message-medical-inquiry-reason').html(res.error.medical_inquiry_reason).fadeIn();
                        }

                        if (res.error.employer) {
                            $('#update-patient-form .employer-group').addClass('has-error');
                            $('#update-patient-form .message-employer').html(res.error.employer).fadeIn();
                        }

                        if (res.error.medical_problem_time) {
                            $('#update-patient-form .medical-problem-time-group').addClass('has-error');
                            $('#update-patient-form .message-medical-problem-time').html(res.error.medical_problem_time).fadeIn();
                        }

                        if (res.error.medical_problem_coup_info) {
                            $('#update-patient-form .medical-problem-coup-info-group').addClass('has-error');
                            $('#update-patient-form .message-medical-problem-coup-info').html(res.error.medical_problem_coup_info).fadeIn();
                        }

                        if (res.error.sport_practice_info) {
                            $('#update-patient-form .sport-practice-info-group').addClass('has-error');
                            $('#update-patient-form .message-sport-practice-info').html(res.error.sport_practice_info).fadeIn();
                        }

                        if (res.error.smokes_per_day) {
                            $('#update-patient-form .smokes-per-day-group').addClass('has-error');
                            $('#update-patient-form .message-smokes-per-day').html(res.error.smokes_per_day).fadeIn();
                        }

                        if (res.error.smokes_years) {
                            $('#update-patient-form .smokes-year-group').addClass('has-error');
                            $('#update-patient-form .message-smokes-years').html(res.error.smokes_years).fadeIn();
                        }

                        if (res.error['medicine.1.name']) {
                            $('#update-patient-form .medicine-1-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-1-name').html(res.error['medicine.1.name']).fadeIn();
                        }

                        if (res.error['medicine.1.dose_frequency']) {
                            $('#update-patient-form .medicine-1-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-1-dose-frequency').html(res.error['medicine.1.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.2.name']) {
                            $('#update-patient-form .medicine-2-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-2-name').html(res.error['medicine.2.name']).fadeIn();
                        }

                        if (res.error['medicine.2.dose_frequency']) {
                            $('#update-patient-form .medicine-2-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-2-dose-frequency').html(res.error['medicine.2.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.3.name']) {
                            $('#update-patient-form .medicine-3-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-3-name').html(res.error['medicine.3.name']).fadeIn();
                        }

                        if (res.error['medicine.3.dose_frequency']) {
                            $('#update-patient-form .medicine-3-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-3-dose-frequency').html(res.error['medicine.3.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.4.name']) {
                            $('#update-patient-form .medicine-4-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-4-name').html(res.error['medicine.4.name']).fadeIn();
                        }

                        if (res.error['medicine.4.dose_frequency']) {
                            $('#update-patient-form .medicine-4-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-4-dose-frequency').html(res.error['medicine.4.dose_frequency']).fadeIn();
                        }

                        if (res.error['medicine.5.name']) {
                            $('#update-patient-form .medicine-5-name-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-5-name').html(res.error['medicine.5.name']).fadeIn();
                        }

                        if (res.error['medicine.5.dose_frequency']) {
                            $('#update-patient-form .medicine-5-dose-frequency-group').addClass('has-error');
                            $('#update-patient-form .message-medicine-5-dose-frequency').html(res.error['medicine.5.dose_frequency']).fadeIn();
                        }

                        if (res.error.allergies_cause) {
                            $('#update-patient-form .allergies-cause-group').addClass('has-error');
                            $('#update-patient-form .message-allergies-cause').html(res.error.allergies_cause).fadeIn();
                        }

                        if (res.error.allergies_reaction) {
                            $('#update-patient-form .allergies-reaction-group').addClass('has-error');
                            $('#update-patient-form .message-allergies-reaction').html(res.error.allergies_reaction).fadeIn();
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
            maxDate: moment().format('01/01/YYYY')
        });

        $XR_DATE.daterangepicker({
            singleDatePicker: true,
            locale: spanishCL,
            showDropdowns: true,
            startDate: '{{ $patient->x_ray_date == '0000-00-00' ? date('Y-m-d') : $patient->x_ray_date }}',
            minDate: '01/01/1920',
            maxDate: moment().format('DD/MM/YYYY')
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
