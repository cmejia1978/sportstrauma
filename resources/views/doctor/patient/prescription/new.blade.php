<div class="remodal" data-remodal-id="add-prescription"
        data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <h4><strong>Nueva receta</strong></h4>
    <form id="add-prescription-form" role="form">
        <input type="hidden" value="{{ $appointment->patient->id }}" name="pid">
        <input type="hidden" value="{{ $appointment->id }}" name="aid">
        <div class="form-group medicine-group">
            <label class="control-label" for="input-medicine">Medicamento</label>
            <select id="input-medicine" name="medicine" style="width: 100%;">
                @foreach ($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                @endforeach
            </select>
            <span style="display: none;" class="help-block message-medicine"></span>
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