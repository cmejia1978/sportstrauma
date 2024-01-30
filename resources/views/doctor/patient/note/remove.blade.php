<div class="remodal" data-remodal-id="remove-note" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>

    <form id="remove-note-form" role="form">
        <h4><strong>Eliminar nota</strong></h4>
        <input type="hidden" name="nid" id="remove-note-nid">
        <h5>¿Confirma que desea eliminar este elemento de las notas?</h5>
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