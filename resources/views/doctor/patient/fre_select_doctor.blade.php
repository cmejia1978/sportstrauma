@extends('layouts.app')

@push('styles')
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/js/fuelux/fuelux.css') }}" rel="stylesheet">
@endpush

@section('title', 'Seleccionar doctor')

@section('content-classes', 'scrollable')

@section('content')
    <section class="hbox stretch">

        <aside class="bg-white">
            <section class="vbox">
                <div class="row" style="margin-top: 5%;">
                    <div class="col-md-6 col-md-offset-3">
                        <section class="panel panel-default" style="margin-bottom: 0;">
                            <header class="panel-heading font-bold">Seleccione un doctor para continuar</header>
                            <div class="panel-body">
                                <form id="form-select-doctor" role="form" action="{{ url('patient/select-doctor') }}" method="post">
                                    @foreach ($doctors as $index => $doctor)
                                        <div class="radio">
                                            <label class="radio-custom">
                                                <input type="radio" name="doctor" id="input-doctor-{{ $index }}" value="{{ Hashids::connection('doctor')->encode($doctor->id) }}" {{ $index == 0 ? 'checked="checked"' : ''}}>
                                                <i class="fa fa-circle-o"></i>
                                                {{ $doctor->name. ($doctor->id == 2 ? '/Traumatólogo y Ortopedista' : ($doctor->id == 3 ? '/Psicóloga Clínica y Deportiva' : '') ) }}
                                            </label>
                                        </div>
                                    @endforeach
                                        <div class="col-md-6 col-md-offset-4">
                                            <button class="btn btn-sm btn-success" type="submit">Seleccionar doctor</button>
                                        </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </aside>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/fuelux/fuelux.js') }}"></script>
<script>
    $(function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'} });

        $('.radio-custom > input[type=radio]').each(function () {var $this = $(this);if ($this.data('radio')) return; $this.radio($this.data());});

        var selectDoctorForm = $('#form-select-doctor');

        selectDoctorForm.on('submit', function(e) {
            e.preventDefault();

            $.post('{{ url('patient/select-doctor') }}', selectDoctorForm.serialize(), function(res) {
                if (res.success) {
                    window.location.href = res.profile_url;
                } else {
                    alert(res.error);
                }
            });
        });
    });
</script>
@endpush
