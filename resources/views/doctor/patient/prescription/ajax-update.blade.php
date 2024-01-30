<h4><strong>Editar receta</strong></h4>
<input type="hidden" value="{{ $prescription->id }}" name="psid">
<div class="form-group medicine-group">
    <label class="control-label" for="input-update-medicine">Medicamento</label>
    <select id="input-update-medicine" name="medicine" style="width: 100%;">
        @foreach ($medicines as $medicine)
            @if ($medicine->id == $prescription->medicine_id)
                <option value="{{ $medicine->id }}" selected="selected">{{ $medicine->name }}</option>
            @else
                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
            @endif
        @endforeach
    </select>
    <span style="display: none;" class="help-block message-medicine"></span>
</div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <a data-remodal-action="cancel" class="btn btn-primary">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</div>