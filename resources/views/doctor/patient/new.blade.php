<div class="remodal" data-remodal-id="add-patient"
        data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <form id="add-patient-form" role="form">
        <h4><strong>Nuevo paciente</strong></h4>
        <br>
        <h5 class="text-info text-center text-bold">INFORMACIÓN</h5>
        <div class="line bg-info"></div>
        <br>
        <div class="form-group full-name-group">
            <label class="control-label" for="input-full-name">Nombre completo <span
                        class="required">*</span></label>
            <input type="text" id="input-full-name" name="full_name" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-full-name"></span>
        </div>
        <div class="form-group surgery-name-group">
            <label class="control-label" for="input-surgery-name">Nombre Cirugía <span</label>
            <input type="text" id="input-surgery-name" name="surgery_name" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-surgery-name"></span>
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
        <div class="form-group sex-group">
            <label class="control-label" for="input-sex">Sexo <span class="required">*</span></label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="sex" id="input-sex-1"
                           value="Masculino" checked="checked">
                    <i class="fa fa-circle-o"></i>
                    Masculino
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="sex" id="input-sex-2"
                           value="Femenino">
                    <i class="fa fa-circle-o"></i>
                    Femenino
                </label>
            </div>
            <span style="display: none;" class="help-block message-sex"></span>
        </div>
        <div class="form-group birth-date-group">
            <label class="control-label" for="input-birth-date">Fecha de Nacimiento <span
                        class="required">*</span></label>
            <input type="text" id="input-birth-date" name="birth_date" readonly="" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-birth-date"></span>
        </div>
        <div class="form-group marital-status-group">
            <label class="control-label">Estado Civil <span class="required">*</span></label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="marital_status" id="input-mt-1"
                           value="Soltero" checked="">
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
                    <input type="radio" name="marital_status" id="input-mt-3"
                           value="Casado">
                    <i class="fa fa-circle-o"></i>
                    Casado/a
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="marital_status" id="input-mt-4"
                           value="Divorciado">
                    <i class="fa fa-circle-o"></i>
                    Divorciado/a
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="marital_status" id="input-mt-5"
                           value="Separado">
                    <i class="fa fa-circle-o"></i>
                    Separado/a
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="marital_status" id="input-mt-6"
                           value="Viudo">
                    <i class="fa fa-circle-o"></i>
                    Viudo/a
                </label>
            </div>
            <span style="display: none;" class="help-block message-marital-status"></span>
        </div>
        <div class="form-group occupation-group">
            <label class="control-label" for="input-occupation">Ocupación</label>
            <input type="text" id="input-occupation" name="occupation" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-occupation"></span>
        </div>
        <div class="form-group birth-location-group">
            <label class="control-label" for="input-birth-location">Lugar de nacimiento</label>
            <input type="text" id="input-birth-location" name="birth_location" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-birth-location"></span>
        </div>
        <div class="form-group religion-group">
            <label class="control-label" for="input-religion">Religión</label>
            <input type="text" id="input-religion" name="religion" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-religion"></span>
        </div>
        <div class="form-group referred-by-group">
            <label class="control-label" for="input-referred-by">Referido por </label>
            <input type="text" id="input-referred-by" name="referred_by" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-referred-by"></span>
        </div>
        <div class="form-group email-group">
            <label class="control-label" for="input-email">Correo <span class="required">*</span></label>
            <input type="text" id="input-email" name="email" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-email"></span>
        </div>
        <div class="form-group address-group">
            <label class="control-label" for="input-address">Dirección casa <span
                        class="required">*</span></label>
            <input type="text" id="input-address" name="address" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-address"></span>
        </div>
        <div class="form-group pref-phone-num-group">
            <label class="control-label" for="input-pref-phone-num">Teléfono casa <span
                        class="required">*</span></label>
            <input type="text" id="input-pref-phone-num" name="pref_phone_num" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-pref-phone-num"></span>
        </div>
        <div class="form-group alt-phone-num-group">
            <label class="control-label" for="input-alt-phone-num">Teléfono celular</label>
            <input type="text" id="input-alt-phone-num" name="alt_phone_num" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-alt-phone-num"></span>
        </div>
        <div class="form-group employer-group">
            <label class="control-label" for="input-employer">Empresa</label>
            <input type="text" id="input-employer" name="employer" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-employer"></span>
        </div>
        <div class="form-group seen-other-provider-group">
            <label for="input-seen-other-provider-1" class="control-label">¿Ha sido visto por otro médico por
                éste problema?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="seen_other_provider"
                           id="input-seen-other-provider-1"
                           value="Y" checked="checked">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="seen_other_provider"
                           id="input-seen-other-provider-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-seen-other-provider"></span>
        </div>
        <div class="form-group other-provider-country-group">
            <label class="control-label" for="input-other-provider-country">País</label>
            <input type="text" id="input-other-provider-country" name="other_provider_country"
                   class="form-control" value="">
            <span style="display: none;" class="help-block message-other-provider-country"></span>
        </div>
        <div class="form-group x-rays-group">
            <label for="input-x-rays-1" class="control-label">¿Tiene estudios de Rayos X o Resonancia?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="x_rays" data-add="x-rays" id="input-x-rays-1"
                           value="Y" checked="">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio" name="x_rays" data-add="x-rays" id="input-x-rays-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-x-rays"></span>
        </div>
        <div class="form-group x-ray-date-group">
            <label for="input-x-ray-date" class="control-label">Fecha</label>
            <input type="text" id="input-x-ray-date" readonly="" name="x_ray_date" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-x-ray-date"></span>
        </div>
        <div class="form-group operated-group">
            <label for="input-operated-1" class="control-label">¿Ha sido operado?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="operated" id="input-operated" value="Y"
                           checked="checked" checked="">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="operated" id="input-operated-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-operated"></span>
        </div>
        <div class="form-group operated-info-group">
            <label for="input-operated-info" class="control-label">¿De qué?</label>
            <input type="text" id="input-operated-info" name="operated_info" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-operated-info"></span>
        </div>

        <br>
        <h5 class="text-info text-center text-bold">HISTORIAL CLÍNICO</h5>
        <div class="line bg-info"></div>
        <br>

        <div class="form-group medical-inquiry-reason-group">
            <label for="input-medical-inquiry-reason" class="control-label">¿Cuál es la razón de su consulta?
               </label>
            <input type="text" id="input-medical-inquiry-reason" name="medical_inquiry_reason"
                   class="form-control" value="">
            <span style="display: none;" class="help-block message-medical-inquiry-reason"></span>
        </div>

        <div class="form-group medical-problem-time-group">
            <label for="input-medical-problem-time" class="control-label">¿Tiempo de tener el problema?</label>
            <input type="text" id="input-medical-problem-time" name="medical_problem_time"
                   class="form-control" value="">
            <span style="display: none;" class="help-block message-medical-problem-time"></span>
        </div>
        <div class="form-group medical-problem-coup-group">
            <label for="input-medical-problem-coup-1" class="control-label">¿El problema empezó por un golpe?
               </label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="medical_problem_coup"
                           id="input-medical-problem-coup"
                           value="Y" checked="">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="medical_problem_coup"
                           id="input-medical-problem-coup-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-medical-problem-coup"></span>
        </div>
        <div class="form-group medical-problem-coup-info-group">
            <label for="input-medical-problem-coup-info" class="control-label">¿Comó fué el golpe?</label>
            <input type="text" id="input-medical-problem-coup-info" name="medical_problem_coup_info"
                   class="form-control" value="">
            <span style="display: none;" class="help-block message-medical-problem-coup-info"></span>
        </div>
        <div class="form-group sport-practice-group">
            <label for="input-sport-practice-1" class="control-label">¿Practica algún deporte?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="sport_practice"
                           id="input-sport-practice"
                           value="Y" checked="">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="sport_practice"
                           id="input-sport-practice-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-sport-practice"></span>
        </div>
        <div class="form-group sport-practice-info-group">
            <label for="input-sport-practice-info" class="control-label">¿Cuál?</label>
            <input type="text" id="input-sport-practice-info" name="sport_practice_info" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-sport-practice-info"></span>
        </div>
        <div class="form-group diseases-group">
            <label for="input-diseases-1" class="control-label">Marque si tiene o ha tenido alguna de éstas
                enfermedades</label>
            @foreach ($diseases as $index => $disease)
                <div class="checkbox">
                    <label class="checkbox-custom">
                        <input type="checkbox"  name="diseases[]"
                               id="input-disease-{{ $index }}" value="{{ $disease->id }}">
                        <i class="fa fa-fw fa-square-o"></i>
                        {{ $disease->name }}
                    </label>
                </div>
            @endforeach
            <span style="display: none;" class="help-block message-diseases"></span>
        </div>
        <h5 class="text-info text-center text-bold">SALUD Y HÁBITOS</h5>
        <div class="line bg-info"></div>
        <div class="form-group exercise-group">
            <label for="input-exercise-1" class="control-label">¿Hace ejercicio?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="exercise" id="input-exercise"
                           value="Y" checked="">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="exercise" id="input-exercise-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-exercise"></span>
        </div>
        <div class="form-group exercise-info-group">
            <label for="input-exercise-info-1" class="control-label">¿Cual?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="exercise_info"
                           id="input-exercise-info"
                           value="Sedentario(no ejercicio)" checked="">
                    <i class="fa fa-fw fa-circle-o"></i>
                    Sedentario(no ejercicio)
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="exercise_info"
                           id="input-exercise-info"
                           value="Ejercicio leve(subir gradas, caminar 3 cuadras, golf)">
                    <i class="fa fa-fw fa-circle-o"></i>
                    Ejercicio leve(subir gradas, caminar 3 cuadras, golf)
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="exercise_info"
                           id="input-exercise-info"
                           value="Ejercicio moderado(caminar rápido, bailar, trabajos de casa)">
                    <i class="fa fa-fw fa-circle-o"></i>
                    Ejercicio moderado(caminar rápido, bailar, trabajos de casa)
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="exercise_info"
                           id="input-exercise-info"
                           value="Ocasional vigoroso(menos de 4x/semana x 30 minutos)">
                    <i class="fa fa-fw fa-circle-o"></i>
                    Ocasional vigoroso(menos de 4x/semana x 30 minutos)
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="exercise_info"
                           id="input-exercise-info"
                           value="Regular vigoroso(más de 4 x/semana x 30 minutos)">
                    <i class="fa fa-fw fa-circle-o"></i>
                    Regular vigoroso(más de 4 x/semana x 30 minutos)
                </label>
            </div>
            <span style="display: none;" class="help-block message-exercise-info"></span>
        </div>
        <div class="form-group alcohol-group">
            <label for="input-alcohol-1" class="control-label">¿Consume alcohol?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="alcohol" id="input-alcohol"
                           value="Y" checked="">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="alcohol" id="input-alcohol-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-alcohol"></span>
        </div>
        <div class="form-group alcohol-usage-group">
            <label for="input-alcohol-usage-1" class="control-label">¿Cuando?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="alcohol_usage"
                           id="input-alcohol-usage"
                           value="Diario" checked="">
                    <i class="fa fa-fw fa-circle-o"></i>
                    Diario
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="alcohol_usage"
                           id="input-alcohol-usage"
                           value="1-2 x semana">
                    <i class="fa fa-fw fa-circle-o"></i>
                    1-2 x semana
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="alcohol_usage"
                           id="input-alcohol-usage"
                           value="1-2 x mes">
                    <i class="fa fa-fw fa-circle-o"></i>
                    1-2 x mes
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="alcohol_usage"
                           id="input-alcohol-usage"
                           value="1-2 x año">
                    <i class="fa fa-fw fa-circle-o"></i>
                    1-2 x año
                </label>
            </div>
            <span style="display: none;" class="help-block message-alcohol-usage"></span>
        </div>
        <div class="form-group smokes-group">
            <label for="input-smokes-1" class="control-label">¿Fuma?</label>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="smokes" id="input-smokes"
                           value="Y" checked="">
                    <i class="fa fa-circle-o"></i>
                    Sí
                </label>
            </div>
            <div class="radio">
                <label class="radio-custom">
                    <input type="radio"  name="smokes" id="input-smokes-2"
                           value="N">
                    <i class="fa fa-circle-o"></i>
                    No
                </label>
            </div>
            <span style="display: none;" class="help-block message-smokes"></span>
        </div>
        <div class="form-group smokes-per-day-group">
            <label for="input-smokes-per-day" class="control-label">¿Cuántos cigarrillos al día?</label>
            <input type="text" id="input-smokes-per-day" name="smokes_per_day" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-smokes-per-day"></span>
        </div>
        <div class="form-group smokes-years-group">
            <label for="input-smokes-years" class="control-label">¿Cuántos años de fumar?</label>
            <input type="text" id="input-smokes-years" name="smokes_years" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-smokes-years"></span>
        </div>
        <br>
        <h5 class="text-info text-center text-bold">MEDICAMENTOS</h5>
        <div class="line bg-info"></div>
        <br>
        <div class="form-group field-group">
            <label for="input-field" class="control-label">Escriba los medicamentos que está utilizando
                actualmente</label>
            <table class="table">
                <thead>
                <tr>
                    <th width="50%">Nombre</th>
                    <th width="50%">Dosis/Frecuencia</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td>
                            <div class="form-group medicine-{{ $i + 1 }}-name-group">
                                <input class="form-control" name="medicine[{{ $i + 1 }}][name]" type="text"
                                       value="">
                                <span style="display: none;"
                                      class="help-block message-medicine-{{ $i + 1 }}-name"></span>
                            </div>
                        </td>
                        <td>
                            <div class="form-group medicine-{{ $i + 1 }}-dose-frequency-group">
                                <input class="form-control" name="medicine[{{ $i + 1 }}][dose_frequency]"
                                       type="text" value="">
                                <span style="display: none;"
                                      class="help-block message-medicine-{{ $i + 1 }}-dose-frequency"></span>
                            </div>
                            <input type="hidden" name="medicine[{{ $i + 1 }}][id]" value="0">
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
        <br>
        <h5 class="text-info text-center text-bold">ALERGIAS</h5>
        <div class="line bg-info"></div>
        <br>
        <div class="form-group allergies-group">
            <label for="input-allergies" class="control-label">Escriba alergias de medicamentos, alimentarias
                o de otro tipo que haya tenido </label>
            <textarea id="input-allergies" name="allergies"
                      class="form-control"></textarea>
            <span style="display: none;" class="help-block message-allergies"></span>
        </div>
        <div class="form-group allergies-cause-group">
            <label for="input-allergies-cause" class="control-label">¿Qué le causo alergia?</label>
            <input type="text" id="input-allergies-cause" name="allergies_cause" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-allergies-cause"></span>
        </div>
        <div class="form-group allergies-reaction-group">
            <label for="input-allergies-reaction" class="control-label">¿Qué reacción tuvo?</label>
            <input type="text" id="input-allergies-reaction" name="allergies_reaction" class="form-control"
                   value="">
            <span style="display: none;" class="help-block message-allergies-reaction"></span>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </div>

    </form>
    <div class="loader-backdrop dt-loader" style="display: none;">
        <div data-loader="circle-side"></div>
    </div>
</div>
