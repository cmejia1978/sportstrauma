<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="generator" content="Sportrauma center" />

    <meta name="keywords" content="core, meta, keywords, here" />

    <meta name="description" content="Page description here." />

    <meta name="robots" content="index,follow" />

    <base href="{{ url('/') }}">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/css/pdf_print.css') }}" />

    <title>Sportrauma center - Recetas Cita No.</title>

</head>

<body>

<div class="content">
    <div style="font-size: 12px; color: #241E2E;">
        <ol>
            @foreach ($prescriptions as $index => $prescription)
                <li>
                    <span style="float: left; display: inline-block; width: 35px; vertical-align: top; margin-top: -4px;">{{ $index + 1 }}.)</span>
                    <div style="float: left; display: inline-block;">
                        <strong>{{ $prescription->medicine->rec_name }}</strong><br>
                        <span style="font-size: 12px; font-family: Helvetica, sans-serif;">{{ $prescription->medicine->rec_indication }}</span>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</div>

</body>

</html>