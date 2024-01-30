<div class="remodal" data-remodal-id="remove-patient" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>

    <form id="remove-patient-form" role="form">
        <h4><strong>Eliminar paciente</strong></h4>
        <input type="hidden" value="" name="pid" id="remove-pid">
        <h5>¿Confirma que desea eliminar este paciente?</h5>
        <div class="line"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Aceptar</button>
            </div>
        </div>
    </form>
    <div class="loader-backdrop dt-loader" style="display: none;">
        <div data-loader="circle-side"></div>
    </div>
</div>
