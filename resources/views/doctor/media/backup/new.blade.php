<div class="remodal" data-remodal-id="add-file"
        data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h4><strong>Agregar archivo(s)</strong></h4>
    <form action="{{ url('media/upload') }}" role="form" id="mediaUploadDZ" class="dropzone" style="border: 1px solid #e5e5e5; height: 300px; overflow-x: hidden; overflow-y: auto; ">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="dz-message">Arrastre archivos para agregarlos o haga click para seleccionar archivos</div>
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
        <div class="dropzone-previews" id="dropzonePreview"></div>
    </form>
    <br>
    <div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <a data-remodal-action="cancel" class="btn btn-primary">Cerrar</a>
        </div>
    </div>
    <div class="loader-backdrop dt-loader" style="display: none;">
        <div data-loader="circle-side"></div>
    </div>
</div>
