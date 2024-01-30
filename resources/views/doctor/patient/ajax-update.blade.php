<h4><strong>Editar paciente</strong></h4>
<br>
<h5 class="text-info text-center text-bold">INFORMACIÓN</h5>
<div class="line bg-info"></div>
<br>

<input type="hidden" name="customer_id" value="{{ $patient->customer_id }}">
<input type="hidden" name="patient_id" value="{{ $patient->id }}">
<div class="form-group full-name-group">
    <label class="control-label" for="input-update-full-name">Nombre completo <span
                class="required">*</span></label>
    <input type="text" id="input-update-full-name" name="full_name" class="form-control"
           value="{{ $patient->full_name }}">
    <span style="display: none;" class="help-block message-full-name"></span>
</div>
<div class="form-group surgery-name-group">
    <label class="control-label" for="input-surgery-name">Nombre Cirugía <span
                class="required">*</span></label>
    <input type="text" id="input-surgery-name" name="surgery_name" class="form-control"
           value="{{ $patient->surgery_name }}">
    <span style="display: none;" class="help-block message-surgery-name"></span>
</div>
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
<div class="form-group sex-group">
    <label class="control-label" for="input-update-sex">Sexo <span class="required">*</span></label>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="sex" id="input-update-sex-1"
                   value="Masculino" {{ $patient->sex == 'Masculino' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Masculino
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="sex" id="input-update-sex-2"
                   value="Femenino" {{ $patient->sex == 'Femenino' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Femenino
        </label>
    </div>
    <span style="display: none;" class="help-block message-sex"></span>
</div>
<div class="form-group birth-date-group">
    <label class="control-label" for="input-update-birth-date">Fecha de Nacimiento <span
                class="required">*</span></label>
    <input type="text" id="input-update-birth-date" name="birth_date" readonly="" class="form-control"
           value="{{ $patient->birth_date }}">
    <span style="display: none;" class="help-block message-birth-date"></span>
</div>
<div class="form-group marital-status-group">
    <label class="control-label">Estado Civil <span class="required">*</span></label>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-1"
                   value="Soltero" {{ $patient->marital_status == 'Soltero' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Soltero/a
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-2"
                   value="Casado" {{ $patient->marital_status == 'Casado' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Casado/a
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-3"
                   value="Divorciado" {{ $patient->marital_status == 'Divorciado' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Divorciado/a
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-4"
                   value="Separado" {{ $patient->marital_status == 'Separado' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Separado/a
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-5"
                   value="Viudo" {{ $patient->marital_status == 'Viudo' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Viudo/a
        </label>
    </div>
    <span style="display: none;" class="help-block message-marital-status"></span>
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
<div class="form-group email-group">
    <label class="control-label" for="input-update-email">Correo <span class="required">*</span></label>
    <input type="text" id="input-update-email" name="email" class="form-control"
           value="{{ $patient->email }}">
    <span style="display: none;" class="help-block message-email"></span>
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
<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>