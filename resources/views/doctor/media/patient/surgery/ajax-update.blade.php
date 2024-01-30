<h4><strong>Editar información archivo</strong></h4>
<input type="hidden" value="{{ $file->id }}" name="fid">
<input type="hidden" value="{{ $file->patient_id }}" name="pid">
<div class="form-group description-group">
    <label class="control-label" for="input-surgery-file-description">Descripción <span class="required">*</span>
    </label>
    <input type="text" id="input-surgery-file-description" name="description" class="form-control" value="{{ $file->description }}">
    <span style="display: none;" class="help-block message-description"></span>
</div>
<div class="form-group category-group">
    <label for="input-surgery-file-category" class="control-label">Categoría</label>
    <select name="category" id="input-surgery-file-category" class="form-control">
        <option value="1" {{ $file->file_category == 'Artroscopia de Hombro' ? 'selected="selected"' : '' }}>Artroscopia de Hombro</option>
        <option value="2" {{ $file->file_category == 'Artroscopia de Codo' ? 'selected="selected"' : '' }}>Artroscopia de Codo</option>
        <option value="3" {{ $file->file_category == 'Artroscopia de Rodilla' ? 'selected="selected"' : '' }}>Artroscopia de Rodilla</option>
        <option value="4" {{ $file->file_category == 'Artroscopia de Tobillo' ? 'selected="selected"' : '' }}>Artroscopia de Tobillo</option>
        <option value="5" {{ $file->file_category == 'Corrección quirúrgica' ? 'selected="selected"' : '' }}>Corrección quirúrgica</option>
        <option value="6" {{ $file->file_category == 'Reparación quirúrgica' ? 'selected="selected"' : '' }}>Reparación quirúrgica</option>
        <option value="7" {{ $file->file_category == 'Osteosíntesis' ? 'selected="selected"' : '' }}>Osteosíntesis</option>
        <option value="8" {{ $file->file_category == 'Artroplastia de Hombro' ? 'selected="selected"' : '' }}>Artroplastia de Hombro</option>
        <option value="9" {{ $file->file_category == 'Artroplastia de Rodilla' ? 'selected="selected"' : '' }}>Artroplastia de Rodilla</option>
        <option value="10" {{ $file->file_category == 'Otros' ? 'selected="selected"' : '' }}>Otros</option>
    </select>
    <span style="display: none;" class="help-block message-category"></span>
</div>
<div class="line"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>