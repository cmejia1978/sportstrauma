<div class="remodal remodal-lg" data-remodal-id="add-general-file"
        data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h4><strong>Agregar archivo(s)</strong></h4>
    <form id="general-file-upload" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="fileupload-buttonbar">
            <div class="btn-group">
                <span class="btn btn-success fileinput-button">
                    <i class="fa fa-plus"></i>
                    <span>Agregar archivo</span>
                    <input type="file" name="file[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="fa fa-upload"></i>
                    <span>Subir archivo(s)</span>
                </button>
                <button type="reset" class="btn btn-danger cancel">
                    <i class="fa fa-ban"></i>
                    <span>Limpiar</span>
                </button>
                <br>
                <span class="fileupload-process"></span>
            </div>
            <br>
            <br>
            <div class="fileupload-progress fade">
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
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
