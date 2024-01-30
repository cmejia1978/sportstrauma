<div class="remodal" data-remodal-id="add-med-history"
        data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h4><strong>Nuevo historial médico</strong></h4>
    <form id="add-history-form" role="form">
        {!! csrf_field() !!}
        <input type="hidden" value="{{ $patient->id }}" name="patient_id">
        <div class="form-group description-group">
            <label class="control-label" for="input-description">Descripción <span class="required">*</span>
            </label>
            <textarea id="input-description" name="description" class="form-control" cols="30" rows="5"></textarea>
            <span style="display: none;" class="help-block message-description"></span>
        </div>
        <div class="line"></div>
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