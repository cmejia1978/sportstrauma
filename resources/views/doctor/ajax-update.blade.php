<h4><strong>Editar información</strong></h4>
<div class="form-group name-group">
    <label class="control-label" for="input-update-name">Nombre<span class="required">*</span></label>
    <input type="text" id="input-update-name" name="name" class="form-control" value="{{ $doctor->name }}">
    <span style="display: none;" class="help-block message-name"></span>
</div>
<div class="form-group notify-email-group">
    <label class="control-label" for="input-update-notify-email">Correo adicional para notificaciones<span class="required">*</span></label>
    <input type="text" id="input-update-notify-email" name="notify_email" class="form-control" value="{{ $doctor->notify_email }}">
    <span style="display: none;" class="help-block message-notify-email"></span>
</div>
<div class="form-group password-group">
    <label class="control-label " for="input-update-password">Nueva contraseña <span class="required">*</span></label>
    <input type="password" id="input-update-password" name="password" class="form-control">
    <span style="display: none;" class="help-block message-password"></span>
</div>
<div class="form-group password-confirmation-group">
    <label class="control-label " for="input-update-password-confirmation">Confirmar contraseña <span class="required">*</span></label>
    <input type="password" id="input-update-password-confirmation" name="password_confirmation" class="form-control">
    <span style="display: none;" class="help-block message-password-confirmation"></span>
</div>
<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>