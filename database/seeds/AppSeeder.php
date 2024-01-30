<?php

use App\DRDSB\Patient\Disease;
use App\DRDSB\Patient\Patient;
use App\DRDSB\User\User;
use App\DRDSB\Medicine\Medicine;
use Bican\Roles\Models\Role;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $admin = User::create(array(
            'name'     => 'Admin Prueba',
            'email'    => 'adminprueba@mail.com',
            'password' => bcrypt('123')
        ));

        $doctor = User::create(array(
            'name'     => 'Dr. Luis Pedro Carranza',
            'email'    => 'julio@webs.gt',
            'password' => bcrypt('123')
        ));

        $doctor_2 = User::create(array(
            'name'     => 'M.A. Lucía Barranza',
            'email'    => 'earce@webs.gt',
            'password' => bcrypt('123')
        ));

        // Default user roles
        DB::table('roles')->delete();

        $adminRole = Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
            'description' => 'Administrador de la aplicación',
        ]);

        $doctorRole = Role::create([
            'name' => 'Doctor',
            'slug' => 'doctor',
            'description' => 'Doctor',
        ]);

        $patientRole = Role::create([
            'name' => 'Patient',
            'slug' => 'patient',
            'description' => 'Patient',
        ]);

        $admin->attachRole($adminRole);
        $doctor->attachRole($doctorRole);
        $doctor_2->attachRole($doctorRole);

        // diseases

        $diseases = array(
            'Accidente cerebrovascular',
            'Ácido úrico alto',
            'Alzheimer',
            'Artritis degenerativa',
            'Artritis reumatoidea',
            'Anemia',
            'Asma',
            'Cáncer',
            'Colesterol alto',
            'Convulsiones',
            'Depresión/Ansiedad',
            'Diabetes',
            'Esclerosis múltiple',
            'Fibrilación atrial',
            'Fibromialgia',
            'Gota',
            'Hepatitis',
            'Hernia de disco',
            'Hipertensión arterial',
            'Hipertermia maligna',
            'Hipo/Hipetiroidismo',
            'Infarto al miocardio',
            'Insuficiencia cardíaca',
            'Insuficiencia renal',
            'Insuficiencia venosa',
            'Lupus',
            'Migraña',
            'Obesidad',
            'Osteopenia',
            'Osteoporosis',
            'Parkinson',
            'SIDA/VIH',
            'Trombosis venosa',
            'Otras',
        );

        foreach ($diseases as $disease) {
            Disease::create(array(
                'name' => $disease
            ));
        }

        // patients
       /* Patient::create(array(
            'doctor_id'  => $doctor['id'],
            'full_name' => 'Mario Antonio Gonzalez',
            'email' => 'marioantoniog@mail.com',
            'marital_status' => 'Soltero',
            'birth_date' => '1985-08-16',
            'age' => '30',
            'sex' => 'Masculino',
            'address' => 'Dirección prueba',
            'pref_phone_num' => '12345678',
            'alt_phone_num' => '12345678',
            'occupation' => 'Contador',
            'employer' => 'Empresa prueba',
            'seen_other_provider' => 'Y',
            'x_rays' => 'N',
            'x_ray_date' => '0000-00-00'
        ));

        Patient::create(array(
            'doctor_id'  => $doctor['id'],
            'full_name' => 'Luis Estrada Grajeda',
            'email' => 'luisestradg@mail.com',
            'marital_status' => 'Soltero',
            'birth_date' => '1985-08-16',
            'age' => '30',
            'sex' => 'Masculino',
            'address' => 'Dirección prueba',
            'pref_phone_num' => '12345678',
            'alt_phone_num' => '12345678',
            'occupation' => 'Contador',
            'employer' => 'Empresa prueba',
            'seen_other_provider' => 'Y',
            'x_rays' => 'N',
            'x_ray_date' => '0000-00-00'
        ));

        Patient::create(array(
            'doctor_id'  => $doctor_2['id'],
            'full_name' => 'Rudy Gabriel Moreno',
            'email' => 'rudygabrielm@mail.com',
            'marital_status' => 'Soltero',
            'birth_date' => '1945-08-16',
            'age' => '45',
            'sex' => 'Masculino',
            'address' => 'Dirección prueba',
            'pref_phone_num' => '12345678',
            'alt_phone_num' => '12345678',
            'occupation' => 'Contador',
            'employer' => 'Empresa prueba',
            'seen_other_provider' => 'Y',
            'x_rays' => 'N',
            'x_ray_date' => '0000-00-00'
        ));

        Patient::create(array(
            'doctor_id'  => $doctor_2['id'],
            'full_name' => 'Jorge Andres Marroquin',
            'email' => 'jorgeandresm@mail.com',
            'marital_status' => 'Soltero',
            'birth_date' => '1993-08-16',
            'age' => '23',
            'sex' => 'Masculino',
            'address' => 'Dirección prueba',
            'pref_phone_num' => '12345678',
            'alt_phone_num' => '12345678',
            'occupation' => 'Contador',
            'employer' => 'Empresa prueba',
            'seen_other_provider' => 'Y',
            'x_rays' => 'N',
            'x_ray_date' => '0000-00-00'
        ));*/

        // medicines
        $medicines = array(
            'Aclasta(frasco 5mg./100ml.)',
            'Actonel(tab. de 35 mg.)',
            'Actonel(tab. de 150mg.)',
            'Adorlan(tab.)',
            'Aleve(gel)',
            'Arcoxia(tab. de 90 mg.)',
            'Arcoxia(tab. de 120 mg.)',
            'Arket(parches)',
            'Astefor(tab. de 500 mg.)',
            'Astefor(tab. de 750 mg.)',
            'Avelox(tab. de 400 mg.)',
            'Betaduo(jeringa de 2ml.)',
            'Cataflam(tab. de 50 mg.)',
            'Dioxaflex(parches)',
            'Diprospan(ampolla de 2ml.)',
            'DoloVartalon(sobres)',
            'DorixinaRelax(tab.)',
            'Elequine(tab. de 500 mg.)',
            'Elequine(tab. de 750 mg.)',
            'Eliquis(tab. de 2.5mg.)',
            'Enantyum(tab. de 25 mg)',
            'Enantyum(gel)',
            'Gelicart(sobres)',
            'Hielo',
            'Lyrica(tab. de 75 mg.)',
            'Lyrica(tab. de 150mg.)',
            'Martesia(tab. de 75 mg.)',
            'Martesia(tab. de 150mg.)',
            'Mio-Citalgán(tab.)',
            'Muscoril(tab. de 8 mg.)',
            'Neobol(spray)',
            'Nexium(tab. de 20 mg.)',
            'Nexium(tab. de 40 mg.)',
            'RecoveronNC(crema)',
            'SynviscONE(ampolla)',
            'SynolisVA(ampolla)',
            'Tramacet(tab.)',
            'Tylex(tab. de 750 mg.)',
            'Unasyn(tab. de 375 mg.)',
            'VartalonDUO(sobres)',
            'Viartril-S(sobres)',
            'Vimovo(tab. de 500mg./20mg.)',
            'Voltaren(gel)',
            'Xarelto(tab. de 10 mg.)'
        );

        foreach ($medicines as $medicine) {
            Medicine::create(array(
                'doctor_id' => $doctor['id'],
                'name' => $medicine
            ));
        }
    }
}
