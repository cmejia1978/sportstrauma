<h4><strong>Editar medicamento</strong></h4>
<input type="hidden" value="{{ $medicine->id }}" name="mid">
<div class="form-group name-group">
    <label class="control-label" for="input-name">Medicamento <span class="required">*</span></label>
    <input type="text" id="input-name" name="name" class="form-control" value="{{ $medicine->name }}">
    <span style="display: none;" class="help-block message-name"></span>
</div>
<div class="line"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>