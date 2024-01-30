<h4 class="text-left">Archivo: {{ $file->original_filename }}</h4>
<div class="line"></div>
<h4 class="text-left">Descripción: {{ $file->description }}</h4>
<?php $rstr = str_random(60); ?>

<div class="line"></div>
@if (strpos($file->mime, 'image') !== false)
    <a href="{{ url('media/lab/download/' . $file->filename) }}"><img class="img-thumbnail img-responsive" src="{{ asset('previews/' . $file->filename) }}" alt="{{ $file->orginal_filename }}"></a>
@elseif (strpos($file->mime, 'video') !== false)
    <div class="wrapper">
        <div class="videocontent">
            <video id="video-plyr-{{ $rstr }}" class="video-js vjs-default-skin vjs-16-9 vjs-big-play-centered" controls preload="auto" width="1130" height="600">
                <source src="{{ asset('previews/' . $file->filename) }}" type='{{ $file->mime }}'>
                <p class="vjs-no-js">
                    Para ver este video por favor active Javascript y consideré actualizarse a un navegador que
                    <a href="http://videojs.com/html5-video-support/" target="_blank">soporte video en HTML5</a>
                </p>
            </video>
        </div>
    </div>

    <a href="{{ url('media/general/download/' . $file->filename) }}" class="btn btn-info btn-block m-t-sm">Descargar <i class="fa fa-download"></i></a>
    <script>
        videojs("video-plyr-{{ $rstr }}", {}, function(){});
    </script>
@elseif (strpos($file->mime, 'audio') !== false)
    <div class="audio-js-box hu-css">
        <audio class="audio-js" controls preload>
            <source src="{{ asset('previews/' . $file->filename) }}">
        </audio>
    </div>
    <a href="{{ url('media/lab/download/' . $file->filename) }}" class="btn btn-info btn-block m-t-sm">Descargar <i class="fa fa-download"></i></a>
    <script>
        AudioJS.setup();
    </script>
@else
    <div class="embed-wrapper">
        <div class="h_iframe">
            <img class="ratio" src="{{ asset('previews/16x9.png') }}"/>
            <iframe src="{{ asset('previews/' . $file->filename) }}" id="dr-media-player" frameborder="0" width="100%" allowfullscreen webkitallowfullscreen></iframe>
        </div>
    </div>

    <a href="{{ url('media/lab/download/' . $file->filename) }}" class="btn btn-info btn-block m-t-sm">Descargar <i class="fa fa-download"></i></a>
@endif