<!DOCTYPE html>
<html lang="es" class="app">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="{{ asset('/') }}"/>

    <title>Sistema de pacientes Sportrauma Center | @yield('title')</title>

    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font.css') }}" rel="stylesheet">
    <link href="http://vjs.zencdn.net/5.10.7/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/5.10.7/video.js"></script>
    <script src="{{ asset('assets/js/audiojs/audio.js') }}"></script>
    <link href="{{ asset('assets/js/audiojs/audio-js.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/audiojs/skins/hu.css') }}" rel="stylesheet">
    @stack('styles')
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/remodal/remodal.css') }}" rel="stylesheet">
    @role ('admin|doctor')
    <link href="{{ asset('assets/js/cropic/croppic.css') }}" rel="stylesheet">
    @endrole

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
<section class="vbox">

    @include('includes.header')


    <section>
        <section class="hbox stretch">
            @include('includes.sidebar')
            <section id="content">
                <section class="vbox">
                    <section class="@yield('content-classes')">
                        @yield('content')
                    </section>
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>
            <aside class="bg-light lter b-l aside-md hide" id="notes">
                <div class="wrapper">Notification</div>
            </aside>
        </section>
    </section>
    @role ('doctor')
    @include('doctor.update');
    @include('doctor.edit-picture');
    @endrole
</section>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/app.plugin.js') }}"></script>
<script src="{{ asset('assets/js/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/remodal/remodal.min.js') }}"></script>
@role ('patient')
@if (Auth::user()->patient['associated'] == 'Y')
<script>
    $(function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        $('.dt-doctor-change').on('click', function(e) {
            e.preventDefault();
            var did = $(this).data('did');

            $.post('{{ url('patient/select-doctor') }}', {doctor: did}, function(res) {
                if (res.success) {
                    window.location.reload();
                } else {
                    alert(res.error);
                }
            });
        });
    });
</script>
@endif
@endrole
@role ('admin|doctor')
<script src="{{ asset('assets/js/cropic/croppic.min.js') }}"></script>
<script>
    $(function () {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

        var doctorEditLink   = $('.dt-doctor-edit'),
            doctorAvatarLink = $('.dt-doctor-avatar'),
            doctorEditForm   = $('#update-doctor-form'),
            doctorEditModal  = $('[data-remodal-id=update-doctor]').remodal(),
            dLoader          = $('.dt-loader'),
            eyeCandy         = $('#cropContainerEyecandy'),
            croppedOptions   = {
                imgEyecandy: false,
                imgEyecandyOpacity: 0.2,
                doubleZoomControls: false,
                rotateControls: false,
                loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>',
                onAfterImgCrop: function (res) {
                    $('#c-profile-pic').attr('src', res.url + '?timestamp=' + new Date().getTime());
                    $('#c-nav-profile-pic').attr('src', res.url + '?timestamp=' + new Date().getTime());
                },
                uploadUrl: '{{ url('profile/upload') }}',
                cropUrl: '{{ url('profile/crop') }}',
                cropData: { 'width': eyeCandy.width(), 'height': eyeCandy.height() }
            },
            cropperBox       = new Croppic('cropContainerEyecandy', croppedOptions);

        doctorEditLink.on('click', function (e) {
            dLoader.show();
            $.get('{{ url('profile/edit') }}', function (res) {
                $('#update-doctor-form').html(res);
                dLoader.fadeOut();
            });
        });

        doctorEditForm.on('submit', function (e) {
            e.preventDefault();

            $('#update-doctor-form .name-group').removeClass('has-error');
            $('#update-doctor-form .message-name').empty().hide();

            $('#update-doctor-form .password-group').removeClass('has-error');
            $('#update-doctor-form .message-password').empty().hide();

            $('#update-doctor-form .notify-email-group').removeClass('has-error');
            $('#update-doctor-form .message-notify-email').empty().hide();

            dLoader.show();

            $.post('{{ url('profile/edit') }}', doctorEditForm.serialize(), function (res) {
                if (res.success) {
                    $('#user-info-name').html(res.doctor_name);
                    doctorEditModal.close();
                } else {
                    if (res.error.name) {
                        $('#update-doctor-form .name-group').addClass('has-error');
                        $('#update-doctor-form .message-name').html(res.error.name).fadeIn();
                    }

                    if (res.error.password) {
                        var msg = '';
                        if (res.error.password.length > 1) {
                            msg = res.error.password[0] + ' <br>' + res.error.password[1];
                        } else {
                            msg = res.error.password;
                        }

                        $('#update-doctor-form .password-group').addClass('has-error');
                        $('#update-doctor-form .message-password').html(msg).fadeIn();
                    }

                    if (res.error.notify_email) {
                        $('#update-doctor-form .notify-email-group').addClass('has-error');
                        $('#update-doctor-form .message-notify-email').html(res.error.notify_email).fadeIn();
                    }
                }

                dLoader.fadeOut();
            });
        });

    });
</script>
@endrole
@stack('scripts')
</html>
