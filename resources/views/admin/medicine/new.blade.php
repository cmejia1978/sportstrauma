<div class="remodal" data-remodal-id="add-medicine"
        data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h4><strong>Nuevo medicamento</strong></h4>
    <form id="add-medicine-form" role="form">
        {!! csrf_field() !!}
        <div class="form-group name-group">
            <label class="control-label" for="input-name">Medicamento <span class="required">*</span></label>
            <input type="text" id="input-name" name="name" class="form-control" value="">
            <span style="display: none;" class="help-block message-name"></span>
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

