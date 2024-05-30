<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

    $countries = [
        [
            'es' => [
                'name' => 'Desconocido'
            ],
            'en' => [
                'name' => 'Unknown'
            ],
            'code' => 'xxx',
        ],
        [
            'es' => [
                'name' => 'Afghanistán'
            ],
            'en' => [
                'name' => 'Afghanistan'
            ],
            'code' => 'afg',
        ],
        [
            'en' => [
                'name' => 'Albania'
            ],
            'code' => 'alb',
        ],
        [
            'es' => [
                'name' => 'Argelia'
            ],
            'en' => [
                'name' => 'Algeria'
            ],
            'code' => 'dza',
        ],
        [
            'en' => [
                'name' => 'Andorra'
            ],
            'code' => 'and',
        ],
        [
            'en' => [
                'name' => 'Angola'
            ],
        ],
        [
            'es' => [
                'name' => 'Antigua y Barbuda'
            ],
            'en' => [
                'name' => 'Antigua and Barbuda'
            ],
        ],
        [
            'en' => [
                'name' => 'Argentina'
            ],
            'code' => 'arg',
        ],
        [
            'en' => [
                'name' => 'Armenia'
            ],
            'code' => 'arm'
        ],
        [
            'en' => [
                'name' => 'Australia'
            ],
            'code' => 'aus',
        ],
        [
            'en' => [
                'name' => 'Austria'
            ],
            'code' => 'aut',
        ],
        [
            'es' => [
                'name' => 'Azerbaiyán'
            ],
            'en' => [
                'name' => 'Azerbaijan'
            ],
            'code' => 'aze'
        ],
        [
            'en' => [
                'name' => 'Bahamas'
            ],
        ],
        [
            'es' => [
                'name' => 'Baréin'
            ],
            'en' => [
                'name' => 'Bahrain'
            ],
        ],
        [
            'en' => [
                'name' => 'Bangladesh'
            ],
            'code' => 'bgd'
        ],[
            'en' => [
                'name' => 'Barbados'
            ],
            'code' => 'brb'
        ],
        [
            'es' => [
                'name' => 'Bielorrusia'
            ],
            'en' => [
                'name' => 'Belarus'
            ],
            'code' => 'blr'
        ],
        [
            'es' => [
                'name' => 'Bélgica'
            ],
            'en' => [
                'name' => 'Belgium'
            ],
            'code' => 'bel'
        ],
        [
            'es' => [
                'name' => 'Belice'
            ],
            'en' => [
                'name' => 'Belize'
            ],
            'code' => 'blz'
        ],
        [
            'es' => [
                'name' => 'Benín'
            ],
            'en' => [
                'name' => 'Benin'
            ],
            'code' => 'ben'
        ],[
            'es' => [
                'name' => 'Bután'
            ],
            'en' => [
                'name' => 'Bhutan'
            ],
        ],
        [
            'en' => [
                'name' => 'Bolivia'
            ],
            'code' => 'bol'
        ],
        [
            'es' => [
                'name' => 'Bosnia y Herzegovina'
            ],
            'en' => [
                'name' => 'Bosnia and Herzegovina'
            ],
            'code' => 'bih'
        ],
        [
            'es' => [
                'name' => 'Botsuana'
            ],
            'en' => [
                'name' => 'Botswana'
            ],
            'code' => 'bwa'
        ],
        [
            'es' => [
                'name' => 'Brasil'
            ],
            'en' => [
                'name' => 'Brazil'
            ],
            'code' => 'bra'
        ],[
            'es' => [
                'name' => 'Brunéi'
            ],
            'en' => [
                'name' => 'Brunei'
            ],
            'code' => 'brn'
        ],
        [
            'en' => [
                'name' => 'Bulgaria'
            ],
            'code' => 'bgr'
        ],
        [
            'en' => [
                'name' => 'Burkina Faso'
            ],
            'code' => 'bfa'
        ],
        [
            'en' => [
                'name' => 'Burundi'
            ],
        ],
        [
            'es' => [
                'name' => 'Cabo Verde'
            ],
            'en' => [
                'name' => 'Cape Verde'
            ],
        ],[
            'es' => [
                'name' => 'Camboya'
            ],
            'en' => [
                'name' => 'Cambodia'
            ],
        ],
        [
            'es' => [
                'name' => 'Camerún'
            ],
            'en' => [
                'name' => 'Cameroon'
            ],
        ],
        [
            'es' => [
                'name' => 'Canadá'
            ],
            'en' => [
                'name' => 'Canada'
            ],
            'code' => 'can'
        ],
        [
            'es' => [
                'name' => 'República Centroafricana'
            ],
            'en' => [
                'name' => 'Central African Republic'
            ],
        ],
        [
            'en' => [
                'name' => 'Chad'
            ],
        ],[
            'en' => [
                'name' => 'Chile'
            ],
            'code' => 'chl'
        ],
        [
            'en' => [
                'name' => 'China'
            ],
            'code' => 'chn',
        ],
        [
            'en' => [
                'name' => 'Colombia'
            ],
            'code' => 'col'
        ],
        [
            'es' => [
                'name' => 'Comoras'
            ],
            'en' => [
                'name' => 'Comoros'
            ],
        ],
        [
            'en' => [
                'name' => 'Congo'
            ],
        ],[
            'en' => [
                'name' => 'Costa Rica'
            ],
        ],
        [
            'en' => [
                'name' => 'Croatia'
            ],
            'code' => 'hrv'
        ],
        [
            'en' => [
                'name' => 'Cuba'
            ],
        ],
        [
            'en' => [
                'name' => 'Cyprus'
            ],
        ],
        [
            'en' => [
                'name' => 'Czechia'
            ],
        ],
        [
            'en' => [
                'name' => 'Denmark'
            ],
            'es' => [
                'name' => 'Dinamarca'
            ],
        ],
        [
            'en' => [
                'name' => 'Djibouti'
            ],
            'es' => [
                'name' => 'Yibuti'
            ],
            'code' => 'dji'
        ],
        [
            'en' => [
                'name' => 'Dominica'
            ],
            'code' => 'dma'
        ],
        [
            'es' => [
                'name' => 'República Dominicana'
            ],
            'en' => [
                'name' => 'Dominican Republic'
            ],
            'code' => 'dom'
        ],
        [
            'en' => [
                'name' => 'Ecuador'
            ],
            'code' => 'ecu'
        ],
        [
            'es' => [
                'name' => 'Egipto'
            ],
            'en' => [
                'name' => 'Egypt'
            ],
            'code' => 'egy'
        ],
        [
            'en' => [
                'name' => 'El Salvador'
            ],
            'code' => 'slv'
        ],
        [
            'es' => [
                'name' => 'Guinea Ecuatorial'
            ],
            'en' => [
                'name' => 'Equatorial Guinea'
            ],
            'code' => 'gnq'
        ],
        [
            'en' => [
                'name' => 'Eritrea'
            ],
            'code' => 'eri'
        ],
        [
            'en' => [
                'name' => 'Estonia'
            ],
            'code' => 'est'
        ],
        [
            'en' => [
                'name' => 'Eswatini'
            ],
            'code' => 'swz'
        ],
        [
            'es' => [
                'name' => 'Etiopía'
            ],
            'en' => [
                'name' => 'Ethiopia'
            ],
            'code' => 'eth'
        ],
        [
            'es' => [
                'name' => 'Fiyi'
            ],
            'en' => [
                'name' => 'Fiji'
            ],
            'code' => 'fji'
        ],
        [
            'es' => [
                'name' => 'Finlandia'
            ],
            'en' => [
                'name' => 'Finland'
            ],
            'code' => 'fin'
        ],
        [
            'es' => [
                'name' => 'Francia'
            ],
            'en' => [
                'name' => 'France'
            ],
            'code' => 'fra'
        ],
        [
            'es' => [
                'name' => 'Gabón'
            ],
            'en' => [
                'name' => 'Gabon'
            ],
            'code' => 'gab'
        ],
        [
            'en' => [
                'name' => 'Gambia'
            ],
            'code' => 'gmb'
        ],
        [
            'en' => [
                'name' => 'Georgia'
            ],
            'code' => 'geo'
        ],
        [
            'es' => [
                'name' => 'Alemania'
            ],
            'en' => [
                'name' => 'Germany'
            ],
            'code' => 'deu'
        ],
        [
            'en' => [
                'name' => 'Ghana'
            ],
            'code' => 'gha'
        ],
        [
            'es' => [
                'name' => 'Grecia'
            ],
            'en' => [
                'name' => 'Greece'
            ],
            'code' => 'grc'
        ],
        [
            'es' => [
                'name' => 'Granada'
            ],
            'en' => [
                'name' => 'Grenada'
            ],
            'code' => 'grd'
        ],
        [
            'en' => [
                'name' => 'Guatemala'
            ],
            'code' => 'gtm'
        ],
        [
            'en' => [
                'name' => 'Guinea'
            ],
            'code' => 'gin'
        ],
        [
            'es' => [
                'name' => 'Guinea-Bisáu'
            ],
            'en' => [
                'name' => 'Guinea-Bissau'
            ],
            'code' => 'gnb'
        ],
        [
            'en' => [
                'name' => 'Guyana'
            ],
            'code' => 'guy'
        ],
        [
            'es' => [
                'name' => 'Haití'
            ],
            'en' => [
                'name' => 'Haiti'
            ],
            'code' => 'hti'
        ],
        [
            'en' => [
                'name' => 'Honduras'
            ],
            'code' => 'hnd'
        ],
        [
            'es' => [
                'name' => 'Hungría'
            ],
            'en' => [
                'name' => 'Hungary'
            ],
        ],
        [
            'es' => [
                'name' => 'Islandia'
            ],
            'en' => [
                'name' => 'Iceland'
            ],
            'code' => 'isl'
        ],
        [
            'en' => [
                'name' => 'India'
            ],
            'code' => 'ind'
        ],
        [
            'en' => [
                'name' => 'Indonesia'
            ],
            'code' => 'idn'
        ],
        [
            'es' => [
                'name' => 'Irán'
            ],
            'en' => [
                'name' => 'Iran'
            ],
            'code' => 'irn'
        ],
        [
            'es' => [
                'name' => 'Irak'
            ],
            'en' => [
                'name' => 'Iraq'
            ],
            'code' => 'irq'
        ],
        [
            'es' => [
                'name' => 'Irlanda'
            ],
            'en' => [
                'name' => 'Ireland'
            ],
            'code' => 'irl'
        ],
        [
            'en' => [
                'name' => 'Israel'
            ],
            'code' => 'isr'
        ],[
            'es' => [
                'name' => 'Italia'
            ],
            'en' => [
                'name' => 'Italy'
            ],
            'code' => 'ita'
        ],
        [
            'en' => [
                'name' => 'Jamaica'
            ],
            'code' => 'jam'
        ],
        [
            'es' => [
                'name' => 'Japón'
            ],
            'en' => [
                'name' => 'Japan'
            ],
            'code' => 'jpn'
        ],
        [
            'es' => [
                'name' => 'Jordania'
            ],
            'en' => [
                'name' => 'Jordan'
            ],
            'code' => 'jor'
        ],
        [
            'es' => [
                'name' => 'Kazajistán'
            ],
            'en' => [
                'name' => 'Kazakhstan'
            ],
            'code' => 'kaz'
        ],
        [
            'es' => [
                'name' => 'Kenia'
            ],
            'en' => [
                'name' => 'Kenya'
            ],
            'code' => 'ken'
        ],
        [
            'en' => [
                'name' => 'Kiribati'
            ],
            'code' => 'kir'
        ],
        [
            'en' => [
                'name' => 'Kuwait'
            ],
            'code' => 'kwt'
        ],
        [
            'es' => [
                'name' => 'Kirguistán'
            ],
            'en' => [
                'name' => 'Kyrgyzstan'
            ],
            'code' => 'kgz'
        ],
        [
            'en' => [
                'name' => 'Laos'
            ],
            'code' => 'lao'
        ],
        [
            'es' => [
                'name' => 'Letonia'
            ],
            'en' => [
                'name' => 'Latvia'
            ],
            'code' => 'lva'
        ],
        [
            'es' => [
                'name' => 'Líbano'
            ],
            'en' => [
                'name' => 'Lebanon'
            ],
            'code' => 'lbn'
        ],
        [
            'es' => [
                'name' => 'Lesoto'
            ],
            'en' => [
                'name' => 'Lesotho'
            ],
            'code' => 'lso'
        ],
        [
            'en' => [
                'name' => 'Liberia'
            ],
            'code' => 'lbr'
        ],
        [
            'es' => [
                'name' => 'Libia'
            ],
            'en' => [
                'name' => 'Libya'
            ],
        ],
        [
            'en' => [
                'name' => 'Liechtenstein'
            ],
        ],
        [
            'es' => [
                'name' => 'Lituania'
            ],
            'en' => [
                'name' => 'Lithuania'
            ],
            'code' => 'ltu'
        ],
        [
            'es' => [
                'name' => 'Luxemburgo'
            ],
            'en' => [
                'name' => 'Luxembourg'
            ],
        ],
        [
            'en' => [
                'name' => 'Madagascar'
            ],
            'code' => 'mdg'
        ],
        [
            'es' => [
                'name' => 'Malaui'
            ],
            'en' => [
                'name' => 'Malawi'
            ],
        ],
        [
            'es' => [
                'name' => 'Malasia'
            ],
            'en' => [
                'name' => 'Malaysia'
            ],
        ],
        [
            'es' => [
                'name' => 'Maldivas'
            ],
            'en' => [
                'name' => 'Maldives'
            ],
        ],
        [
            'es' => [
                'name' => 'Malí'
            ],
            'en' => [
                'name' => 'Mali'
            ],
        ],
        [
            'en' => [
                'name' => 'Malta'
            ],
        ],
        [
            'es' => [
                'name' => 'Islas Marshall'
            ],
            'en' => [
                'name' => 'Marshall Islands'
            ],
        ],
        [
            'en' => [
                'name' => 'Mauritania'
            ],
        ],
        [
            'es' => [
                'name' => 'Mauricio'
            ],
            'en' => [
                'name' => 'Mauritius'
            ],
        ],
        [
            'es' => [
                'name' => 'México'
            ],
            'en' => [
                'name' => 'Mexico'
            ],
            'code' => 'mex'
        ],
        [
            'en' => [
                'name' => 'Micronesia'
            ],
        ],
        [
            'es' => [
                'name' => 'Moldavia'
            ],
            'en' => [
                'name' => 'Moldova'
            ],
        ],
        [
            'es' => [
                'name' => 'Mónaco'
            ],
            'en' => [
                'name' => 'Monaco'
            ],
        ],
        [
            'en' => [
                'name' => 'Mongolia'
            ],
        ],
        [
            'en' => [
                'name' => 'Montenegro'
            ],
        ],
        [
            'es' => [
                'name' => 'Marruecos'
            ],
            'en' => [
                'name' => 'Morocco'
            ],
        ],
        [
            'en' => [
                'name' => 'Mozambique'
            ],
        ],
        [
            'en' => [
                'name' => 'Myanmar'
            ],
        ],
        [
            'en' => [
                'name' => 'Namibia'
            ],
        ],
        [
            'en' => [
                'name' => 'Nauru'
            ],
        ],
        [
            'en' => [
                'name' => 'Nepal'
            ],
            'code' => 'npl'
        ],
        [
            'es' => [
                'name' => 'Países Bajos'
            ],
            'en' => [
                'name' => 'Netherlands'
            ],
        ],
        [
            'es' => [
                'name' => 'Nueva Zelanda'
            ],
            'en' => [
                'name' => 'New Zealand'
            ],
            'code' => 'nzl'
        ],
        [
            'en' => [
                'name' => 'Nicaragua'
            ],
            'code' => 'nic',
        ],
        [
            'es' => [
                'name' => 'Níger'
            ],
            'en' => [
                'name' => 'Niger'
            ],
        ],
        [
            'en' => [
                'name' => 'Nigeria'
            ],
        ],
        [
            'es' => [
                'name' => 'Corea del Norte'
            ],
            'en' => [
                'name' => 'North Korea'
            ],
        ],
        [
            'es' => [
                'name' => 'Macedonia del Norte'
            ],
            'en' => [
                'name' => 'North Macedonia'
            ],
        ],
        [
            'es' => [
                'name' => 'Noruega'
            ],
            'en' => [
                'name' => 'Norway'
            ],
            'code' => 'nor'
        ],
        [
            'es' => [
                'name' => 'Omán'
            ],
            'en' => [
                'name' => 'Oman'
            ],
        ],
        [
            'es' => [
                'name' => 'Pakistán'
            ],
            'en' => [
                'name' => 'Pakistan'
            ],
        ],
        [
            'es' => [
                'name' => 'Palaos'
            ],
            'en' => [
                'name' => 'Palau'
            ],
        ],
        [
            'es' => [
                'name' => 'Palestina'
            ],
            'en' => [
                'name' => 'Palestine'
            ],
        ],
        [
            'es' => [
                'name' => 'Panamá'
            ],
            'en' => [
                'name' => 'Panama'
            ],
        ],
        [
            'es' => [
                'name' => 'Papúa Nueva Guinea'
            ],
            'en' => [
                'name' => 'Papua New Guinea'
            ],
        ],
        [
            'en' => [
                'name' => 'Paraguay'
            ],
        ],
        [
            'es' => [
                'name' => 'Perú'
            ],
            'en' => [
                'name' => 'Peru'
            ],
            'code' => 'per',
        ],
        [
            'es' => [
                'name' => 'Filipinas'
            ],
            'en' => [
                'name' => 'Philippines'
            ],
            'code' => 'phl'
        ],
        [
            'es' => [
                'name' => 'Polonia'
            ],
            'en' => [
                'name' => 'Poland'
            ],
            'code' => 'pol'
        ],
        [
            'en' => [
                'name' => 'Portugal'
            ],
            'code' => 'prt'
        ],
        [
            'es' => [
                'name' => 'Catar'
            ],
            'en' => [
                'name' => 'Qatar'
            ],
            'code' => 'qat'
        ],
        [
            'es' => [
                'name' => 'Rumania'
            ],
            'en' => [
                'name' => 'Romania'
            ],
            'code' => 'rou'
        ],
        [
            'es' => [
                'name' => 'Rusia'
            ],
            'en' => [
                'name' => 'Russia'
            ],
            'code'=> 'rus'
        ],
        [
            'es' => [
                'name' => 'Ruanda'
            ],
            'en' => [
                'name' => 'Rwanda'
            ],
            'code' => 'rwa'
        ],
        [
            'es' => [
                'name' => 'San Cristóbal y Nieves'
            ],
            'en' => [
                'name' => 'Saint Kitts and Nevis'
            ],
            'code' => 'kna'
        ],
        [
            'es' => [
                'name' => 'Santa Lucía'
            ],
            'en' => [
                'name' => 'Saint Lucia'
            ],
            'code' => 'lca'
        ],
        [
            'es' => [
                'name' => 'San Vicente y las Granadinas'
            ],
            'en' => [
                'name' => 'Saint Vincent and the Grenadines'
            ],
            'code' => 'vct'
        ],
        [
            'en' => [
                'name' => 'Samoa'
            ],
            'code' => 'wsm'
        ],
        [
            'es' => [
                'name' => 'San Marino'
            ],
            'en' => [
                'name' => 'San Marino'
            ],
            'code' => 'smr'
        ],
        [
            'es' => [
                'name' => 'Santo Tomé y Príncipe'
            ],
            'en' => [
                'name' => 'Sao Tome and Principe'
            ],
            'code' => 'stp'
        ],
        [
            'es' => [
                'name' => 'Arabia Saudita'
            ],
            'en' => [
                'name' => 'Saudi Arabia'
            ],
            'code' => 'sau'
        ],
        [
            'es' => [
                'name' => 'Escocia'
            ],
            'en' => [
                'name' => 'Scotland'
            ],
            'code' => 'sco',
        ],
        [
            'en' => [
                'name' => 'Senegal'
            ],
        ],
        [
            'en' => [
                'name' => 'Serbia'
            ],
        ],
        [
            'en' => [
                'name' => 'Seychelles'
            ],
            'code' => 'syc'
        ],
        [
            'es' => [
                'name' => 'Sierra Leona'
            ],
            'en' => [
                'name' => 'Sierra Leone'
            ],
        ],
        [
            'es' => [
                'name' => 'Singapur'
            ],
            'en' => [
                'name' => 'Singapore'
            ],
            'code' => 'sgp'
        ],
        [
            'es' => [
                'name' => 'Eslovaquia'
            ],
            'en' => [
                'name' => 'Slovakia'
            ],
        ],
        [
            'es' => [
                'name' => 'Eslovenia'
            ],
            'en' => [
                'name' => 'Slovenia'
            ],
        ],
        [
            'es' => [
                'name' => 'Islas Salomón'
            ],
            'en' => [
                'name' => 'Solomon Islands'
            ],
        ],
        [
            'en' => [
                'name' => 'Somalia'
            ],
        ],
        [
            'es' => [
                'name' => 'Sudáfrica'
            ],
            'en' => [
                'name' => 'South Africa'
            ],
        ],
        [
            'es' => [
                'name' => 'Corea del Sur'
            ],
            'en' => [
                'name' => 'South Korea'
            ],
        ],
        [
            'es' => [
                'name' => 'Sudán del Sur'
            ],
            'en' => [
                'name' => 'South Sudan'
            ],
        ],
        [
            'es' => [
                'name' => 'España'
            ],
            'en' => [
                'name' => 'Spain'
            ],
            'code' => 'esp',
        ],
        [
            'en' => [
                'name' => 'Sri Lanka'
            ],
        ],
        [
            'es' => [
                'name' => 'Sudán'
            ],
            'en' => [
                'name' => 'Sudan'
            ],
        ],
        [
            'es' => [
                'name' => 'Surinam'
            ],
            'en' => [
                'name' => 'Suriname'
            ],
        ],
        [
            'es' => [
                'name' => 'Suecia'
            ],
            'en' => [
                'name' => 'Sweden'
            ],
        ],
        [
            'es' => [
                'name' => 'Suiza'
            ],
            'en' => [
                'name' => 'Switzerland'
            ],
        ],
        [
            'es' => [
                'name' => 'Siria'
            ],
            'en' => [
                'name' => 'Syria'
            ],
        ],
        [
            'es' => [
                'name' => 'Tayikistán'
            ],
            'en' => [
                'name' => 'Tajikistan'
            ],
        ],
        [
            'es' => [
                'name' => 'Tanzania'
            ],
            'en' => [
                'name' => 'Tanzania'
            ],
        ],
        [
            'es' => [
                'name' => 'Tailandia'
            ],
            'en' => [
                'name' => 'Thailand'
            ],
        ],
        [
            'es' => [
                'name' => 'Timor Oriental'
            ],
            'en' => [
                'name' => 'Timor-Leste'
            ],
        ],
        [
            'en' => [
                'name' => 'Togo'
            ],
        ],
        [
            'en' => [
                'name' => 'Tonga'
            ],
        ],
        [
            'es' => [
                'name' => 'Trinidad y Tobago'
            ],
            'en' => [
                'name' => 'Trinidad and Tobago'
            ],
        ],
        [
            'es' => [
                'name' => 'Túnez'
            ],
            'en' => [
                'name' => 'Tunisia'
            ],
        ],
        [
            'es' => [
                'name' => 'Turquía'
            ],
            'en' => [
                'name' => 'Turkey'
            ],
            'code' => 'tur'
        ],
        [
            'es' => [
                'name' => 'Turkmenistán'
            ],
            'en' => [
                'name' => 'Turkmenistan'
            ],
        ],
        [
            'en' => [
                'name' => 'Tuvalu'
            ],
        ],
        [
            'en' => [
                'name' => 'Uganda'
            ],
            'code' => 'uga'
        ],
        [
            'es' => [
                'name' => 'Ucrania'
            ],
            'en' => [
                'name' => 'Ukraine'
            ],
        ],
        [
            'es' => [
                'name' => 'Emiratos Árabes Unidos'
            ],
            'en' => [
                'name' => 'United Arab Emirates'
            ],
        ],
        [
            'es' => [
                'name' => 'Reino Unido'
            ],
            'en' => [
                'name' => 'United Kingdom'
            ],
            'code' => 'gbr'
        ],
        [
            'es' => [
                'name' => 'Estados Unidos'
            ],
            'en' => [
                'name' => 'United States'
            ],
            'code' => 'usa',
        ],
        [
            'en' => [
                'name' => 'Uruguay'
            ],
        ],
        [
            'es' => [
                'name' => 'Uzbekistán'
            ],
            'en' => [
                'name' => 'Uzbekistan'
            ],
        ],
        [
            'en' => [
                'name' => 'Vanuatu'
            ],
        ],
        [
            'es' => [
                'name' => 'Ciudad del Vaticano'
            ],
            'en' => [
                'name' => 'Vatican City'
            ],
        ],
        [
            'en' => [
                'name' => 'Venezuela'
            ],
            'code' => 'ven'
        ],
        [
            'en' => [
                'name' => 'Vietnam'
            ],
            'code' => 'vnm'
        ],
        [
            'en' => [
                'name' => 'Yemen'
            ],
            'code' => 'yem',
        ],
        [
            'en' => [
                'name' => 'Zambia'
            ],
            'code' => 'zmb'
        ],
        [
            'es' => [
                'name' => 'Zimbabue'
            ],
            'en' => [
                'name' => 'Zimbabwe'
            ],
            'code' => 'zwe'
        ],

        ];

        // create the countries using translations
        foreach ($countries as $country_entry) {

            $country_data = [
                'es' => $country_entry['es'] ?? $country_entry['en'],
                'en' => $country_entry['en'],
                'code' => $country_entry['code'] ?? 'xxx',
            ];

            $new_country = Country::create($country_data);
        }

    }
}
