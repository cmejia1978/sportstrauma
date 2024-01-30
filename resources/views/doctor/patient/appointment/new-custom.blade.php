<div class="remodal" data-remodal-id="add-custom-appointment" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <form id="add-custom-appointment-form" role="form">
        <h4><strong>Agregar Temporal</strong></h4><br>
        <div class="line bg-info"></div>
        <br>
        <div class="form-group name-group">
            <label class="control-label" for="input-name">Nombre <span class="required">*</span></label>
            <input type="text" id="input-name" name="name" class="form-control" value="">
            <span style="display: none;" class="help-block message-name"></span>
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