<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="generator" content="Sportrauma center" />

    <meta name="keywords" content="core, meta, keywords, here" />

    <meta name="description" content="Page description here." />

    <meta name="robots" content="index,follow" />

    <base href="{{ url('/') }}">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/css/pdf.css') }}" />

    <title>Sportrauma center - Recetas Cita No.</title>

</head>

<body>

<div class="page-header">
    <table class="page-header-content">
        <tr>
            <td class="page-header-logo" valign="top">
                <img class="logo" src="{{ asset('assets/images/logo-pdf.png') }}" alt="Sportrauma Center"><br>
                <div class="text-center" style="font-size: 10px; line-height: 1; color: #3CA2B8;">
                    <span>Cirugía Atroscópica y Traumatología Deportiva</span><br>
                    <span>Recontstrucción de Hombro, Codo y Rodilla</span>
                </div>
            </td>
            <td class="page-header-text" style="font-size: 16px;">
                <strong>Dr. Luis Pedro Carranza Sánchez</strong><br>
                <div style="font-size: 13px;">
                    <span>Traumatólogo y Ortopedista</span><br>
                    <span>Fellowshlp en Traumatología Deportiva, Reconstrucción</span><br>
                    <span>de Hombro, Codo y Rodilla, Universidad de Montreal, Canadá</span>
                </div>
            </td>
        </tr>
    </table>
    <div class="line-separator"></div>
</div>

<div class="page-footer">
    <div class="line-separator"></div>
    <div class="text-center" style="line-height: 0.85; margin-top: 5px;">
        6 Av. 7-39 zona 10, Edificio las Brisas, Oficina 203, Guatemala, Guatemala. TelFax: 2360-0113/14<br>
        E-mail: lpcsMD@gmail,com
    </div>
</div>

<div class="content">
    <div style="font-size: 20px; color: #241E2E;">
        <ol>
            @foreach ($prescriptions as $index => $prescription)
                <li>
                    <span style="float: left; display: inline-block; width: 35px; vertical-align: top; margin-top: -4px;">{{ $index + 1 }}.)</span>
                    <div style="float: left; display: inline-block;">
                        <strong>{{ $prescription->medicine->rec_name }}</strong><br>
                        <span style="font-size: 18px; font-family: Helvetica, sans-serif;">{{ $prescription->medicine->rec_indication }}</span>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</div>

</body>

</html>