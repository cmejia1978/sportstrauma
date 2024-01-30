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
            <input type="radio" name="marital_status" id="input-mt-2" value="Unión Libre" {{ $patient->marital_status == 'Unión Libre' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i> Unión Libre </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-3"
                   value="Casado" {{ $patient->marital_status == 'Casado' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Casado/a
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-4"
                   value="Divorciado" {{ $patient->marital_status == 'Divorciado' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Divorciado/a
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-5"
                   value="Separado" {{ $patient->marital_status == 'Separado' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Separado/a
        </label>
    </div>
    <div class="radio">
        <label class="radio-custom">
            <input type="radio" name="marital_status" id="input-update-mt-6"
                   value="Viudo" {{ $patient->marital_status == 'Viudo' ? 'checked="checked"' : '' }}>
            <i class="fa fa-circle-o"></i>
            Viudo/a
        </label>
    </div>
    <span style="display: none;" class="help-block message-marital-status"></span>
</div>
<div class="form-group children-info-group">
    <label class="control-label" for="input-update-children-info">¿Tiene hijos, edades?</label>
    <input type="text" id="input-update-children-info" name="children_info" class="form-control"
            value="{{ $patient->children_info }}">
    <span style="display: none;" class="help-block message-children-info"></span>
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
<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>