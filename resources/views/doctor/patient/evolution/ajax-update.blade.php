<h4><strong>Editar evolución</strong></h4>
<input type="hidden" value="{{ $evolution->id }}" name="eid">
<div class="form-group description-group">
    <label class="control-label" for="input-description">Descripción <span class="required">*</span>
    </label>
    <textarea id="input-description" name="description" class="form-control" cols="30" rows="5">{{ $evolution->description }}</textarea>
    <span style="display: none;" class="help-block message-description"></span>
</div>
<div class="line"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>