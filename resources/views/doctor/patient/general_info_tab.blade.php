<div class="padder">
    <h6><strong>Nombre completo: </strong>{{ $patient->first_name . ' ' . $patient->middle_name . ' ' . $patient->last_name }}</h6>
    <div class="line"></div>
    <h6><strong>Correo electrónico: </strong>{{ $patient->email }}</h6>
    <div class="line"></div>
    <h6><strong>Estado civil: </strong>{{ $patient->marital_status }}</h6>
    <div class="line"></div>
    <h6><strong>Número seguro social: </strong>{{ $patient->social_sec_num }}</h6>
    <div class="line"></div>
    <h6><strong>Fecha nacimiento: </strong>{{ $patient->birth_date }}</h6>
    <div class="line"></div>
    <h6><strong>Edad: </strong>{{ $patient->age }}</h6>
    <div class="line"></div>
    <h6><strong>Sexo: </strong>{{ $patient->sex == 'M' ? 'Masculino' : 'Femenino' }}</h6>
    <div class="line"></div>
    <h6><strong>Dirección envío: </strong>{{ $patient->mailing_address }}</h6>
    <div class="line"></div>
    <h6><strong>Ciudad: </strong>{{ $patient->city }}</h6>
    <div class="line"></div>
    <h6><strong>Estado: </strong>{{ $patient->state }}</h6>
    <div class="line"></div>
    <h6><strong>Código postal: </strong>{{ $patient->zip }}</h6>
    <div class="line"></div>
    <h6><strong>Número de teléfono: </strong>{{ $patient->pref_phone_num }}</h6>
    <div class="line"></div>
    <h6><strong>Número de teléfono alternativo: </strong>{{ $patient->alt_phone_num }}</h6>
    <div class="line"></div>
    <h6><strong>Ocupación: </strong>{{ $patient->occupation }}</h6>
    <div class="line"></div>
    <h6><strong>Empresa: </strong>{{ $patient->employer }}</h6>
    <div class="line"></div>
    <h6><strong>Número teléfono</strong>{{ $patient->employer_phone_num }}</h6>
    <div class="line"></div>
    <h6><strong>Situación laboral: </strong>{{ $patient->employment_status }}</h6>
    <div class="line"></div>
    <h6><strong>Cónyuge / pareja: </strong>{{ $patient->spouse_partner }}</h6>
    <div class="line"></div>
    <h6><strong>Número de teléfono - Cónyuge / pareja: </strong>{{ $patient->spouse_partner_phone_num }}</h6>
    <div class="line"></div>
    <h6><strong>Visto por otro doctor: </strong>{{ $patient->seen_other_provider == 'Y' ? 'Sí' : 'No' }}</h6>
    <div class="line"></div>
    <h6><strong>Nombre Doctor: </strong>{{ $patient->other_provider }}</h6>
    <div class="line"></div>
    <h6><strong>Tiene radiografías: </strong>{{ $patient->x_rays == 'Y' ? 'Sí' : 'No' }}
    </h6>
    <div class="line"></div>
    <h6><strong>Fecha radiografías: </strong>{{ $patient->x_rays == 'Y' ? $patient->x_rays_date : 'N/A' }}</h6>
    <div class="line"></div>
</div>