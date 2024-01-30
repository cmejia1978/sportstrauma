<h4><strong>Editar información archivo</strong></h4>
<input type="hidden" value="{{ $file->id }}" name="fid">
<input type="hidden" value="{{ $file->patient_id }}" name="pid">
<div class="form-group description-group">
    <label class="control-label" for="input-lab-file-description">Descripción <span class="required">*</span>
    </label>
    <input type="text" id="input-lab-file-description" name="description" class="form-control" value="{{ $file->description }}">
    <span style="display: none;" class="help-block message-description"></span>
</div>
<div class="line"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>