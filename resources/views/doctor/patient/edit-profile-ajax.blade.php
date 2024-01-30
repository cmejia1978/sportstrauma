<h4><strong>Editar información perfil</strong></h4>
<div class="form-group email-group">
    <label class="control-label" for="input-email">Correo <span class="required">*</span></label>
    <input type="text" id="input-email" name="email" class="form-control" value="{{ $patient->email }}">
    <span style="display: none;" class="help-block message-email"></span>
</div>
<div class="form-group mailing-address-group">
    <label class="control-label" for="input-mailing-address">Dirección de envío <span class="required">*</span></label>
    <input type="text" id="input-mailing-address" name="mailing_address" class="form-control" value="{{ $patient->mailing_address }}">
    <span style="display: none;" class="help-block message-mailing-address"></span>
</div>
<div class="form-group pref-phone-num-group">
    <label class="control-label" for="input-pref-phone-num">Número de telefono principal <span class="required">*</span></label>
    <input type="text" id="input-pref-phone-num" name="pref_phone_num" class="form-control" value="{{ $patient->pref_phone_num }}">
    <span style="display: none;" class="help-block message-pref-phone-num"></span>
</div>

<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>