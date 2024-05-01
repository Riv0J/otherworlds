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
                'name' => 'Afghanistan'
            ],
            'en' => [
                'name' => 'Afghanistán'
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
                'name' => 'Algeria'
            ],
            'en' => [
                'name' => 'Argelia'
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
        ],
        [
            'es' => [
                'name' => 'Azerbaiyán'
            ],
            'en' => [
                'name' => 'Azerbaijan'
            ],
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
        ],[
            'en' => [
                'name' => 'Barbados'
            ],
        ],
        [
            'es' => [
                'name' => 'Bielorrusia'
            ],
            'en' => [
                'name' => 'Belarus'
            ],
        ],
        [
            'es' => [
                'name' => 'Bélgica'
            ],
            'en' => [
                'name' => 'Belgium'
            ],
        ],
        [
            'es' => [
                'name' => 'Belice'
            ],
            'en' => [
                'name' => 'Belize'
            ],
        ],
        [
            'es' => [
                'name' => 'Benín'
            ],
            'en' => [
                'name' => 'Benin'
            ],
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
        ],
        [
            'es' => [
                'name' => 'Botsuana'
            ],
            'en' => [
                'name' => 'Botswana'
            ],
        ],
        [
            'es' => [
                'name' => 'Brasil'
            ],
            'en' => [
                'name' => 'Brazil'
            ],
        ],[
            'es' => [
                'name' => 'Brunéi'
            ],
            'en' => [
                'name' => 'Brunei'
            ],
        ],
        [
            'en' => [
                'name' => 'Bulgaria'
            ],
        ],
        [
            'en' => [
                'name' => 'Burkina Faso'
            ],
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
        ],
        [
            'en' => [
                'name' => 'Dominica'
            ],
        ],
        [
            'es' => [
                'name' => 'República Dominicana'
            ],
            'en' => [
                'name' => 'Dominican Republic'
            ],

        ],
        [
            'en' => [
                'name' => 'Ecuador'
            ],
        ],
        [
            'es' => [
                'name' => 'Egipto'
            ],
            'en' => [
                'name' => 'Egypt'
            ],
        ],
        [
            'en' => [
                'name' => 'El Salvador'
            ],
        ],
        [
            'es' => [
                'name' => 'Guinea Ecuatorial'
            ],
            'en' => [
                'name' => 'Equatorial Guinea'
            ],
        ],
        [
            'en' => [
                'name' => 'Eritrea'
            ],
        ],
        [
            'en' => [
                'name' => 'Estonia'
            ],
        ],
        [
            'en' => [
                'name' => 'Eswatini'
            ],
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
        ],
        [
            'es' => [
                'name' => 'Finlandia'
            ],
            'en' => [
                'name' => 'Finland'
            ],
        ],
        [
            'es' => [
                'name' => 'Francia'
            ],
            'en' => [
                'name' => 'France'
            ],
        ],
        [
            'es' => [
                'name' => 'Gabón'
            ],
            'en' => [
                'name' => 'Gabon'
            ],
        ],
        [
            'en' => [
                'name' => 'Gambia'
            ],
        ],
        [
            'en' => [
                'name' => 'Georgia'
            ],
        ],
        [
            'es' => [
                'name' => 'Alemania'
            ],
            'en' => [
                'name' => 'Germany'
            ],
        ],
        [
            'en' => [
                'name' => 'Ghana'
            ],
        ],
        [
            'es' => [
                'name' => 'Grecia'
            ],
            'en' => [
                'name' => 'Greece'
            ],
        ],
        [
            'es' => [
                'name' => 'Granada'
            ],
            'en' => [
                'name' => 'Grenada'
            ],
        ],
        [
            'en' => [
                'name' => 'Guatemala'
            ],
        ],
        [
            'en' => [
                'name' => 'Guinea'
            ],
        ],
        [
            'es' => [
                'name' => 'Guinea-Bisáu'
            ],
            'en' => [
                'name' => 'Guinea-Bissau'
            ],
        ],
        [
            'en' => [
                'name' => 'Guyana'
            ],
        ],
        [
            'es' => [
                'name' => 'Haití'
            ],
            'en' => [
                'name' => 'Haiti'
            ],
        ],
        [
            'en' => [
                'name' => 'Honduras'
            ],
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
        ],
        [
            'en' => [
                'name' => 'India'
            ],
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
        ],
        [
            'es' => [
                'name' => 'Irak'
            ],
            'en' => [
                'name' => 'Iraq'
            ],
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
        ],[
            'es' => [
                'name' => 'Italia'
            ],
            'en' => [
                'name' => 'Italy'
            ],
        ],
        [
            'en' => [
                'name' => 'Jamaica'
            ],
        ],
        [
            'es' => [
                'name' => 'Japón'
            ],
            'en' => [
                'name' => 'Japan'
            ],
        ],
        [
            'es' => [
                'name' => 'Jordania'
            ],
            'en' => [
                'name' => 'Jordan'
            ],
        ],
        [
            'es' => [
                'name' => 'Kazajistán'
            ],
            'en' => [
                'name' => 'Kazakhstan'
            ],
        ],
        [
            'es' => [
                'name' => 'Kenia'
            ],
            'en' => [
                'name' => 'Kenya'
            ],
        ],
        [
            'en' => [
                'name' => 'Kiribati'
            ],
        ],
        [
            'en' => [
                'name' => 'Kuwait'
            ],
        ],
        [
            'es' => [
                'name' => 'Kirguistán'
            ],
            'en' => [
                'name' => 'Kyrgyzstan'
            ],
        ],
        [
            'en' => [
                'name' => 'Laos'
            ],
        ],
        [
            'es' => [
                'name' => 'Letonia'
            ],
            'en' => [
                'name' => 'Latvia'
            ],
        ],
        [
            'es' => [
                'name' => 'Líbano'
            ],
            'en' => [
                'name' => 'Lebanon'
            ],
        ],
        [
            'es' => [
                'name' => 'Lesoto'
            ],
            'en' => [
                'name' => 'Lesotho'
            ],
        ],
        [
            'en' => [
                'name' => 'Liberia'
            ],
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
        ],
        [
            'es' => [
                'name' => 'Polonia'
            ],
            'en' => [
                'name' => 'Poland'
            ],
        ],
        [
            'en' => [
                'name' => 'Portugal'
            ],
        ],
        [
            'es' => [
                'name' => 'Catar'
            ],
            'en' => [
                'name' => 'Qatar'
            ],
        ],
        [
            'es' => [
                'name' => 'Rumania'
            ],
            'en' => [
                'name' => 'Romania'
            ],
        ],
        [
            'es' => [
                'name' => 'Rusia'
            ],
            'en' => [
                'name' => 'Russia'
            ],
        ],
        [
            'es' => [
                'name' => 'Ruanda'
            ],
            'en' => [
                'name' => 'Rwanda'
            ],
        ],
        [
            'es' => [
                'name' => 'San Cristóbal y Nieves'
            ],
            'en' => [
                'name' => 'Saint Kitts and Nevis'
            ],
        ],
        [
            'es' => [
                'name' => 'Santa Lucía'
            ],
            'en' => [
                'name' => 'Saint Lucia'
            ],
        ],
        [
            'es' => [
                'name' => 'San Vicente y las Granadinas'
            ],
            'en' => [
                'name' => 'Saint Vincent and the Grenadines'
            ],
        ],
        [
            'en' => [
                'name' => 'Samoa'
            ],
        ],
        [
            'es' => [
                'name' => 'San Marino'
            ],
            'en' => [
                'name' => 'San Marino'
            ],
        ],
        [
            'es' => [
                'name' => 'Santo Tomé y Príncipe'
            ],
            'en' => [
                'name' => 'Sao Tome and Principe'
            ],
        ],
        [
            'es' => [
                'name' => 'Arabia Saudita'
            ],
            'en' => [
                'name' => 'Saudi Arabia'
            ],
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
        ],
        [
            'es' => [
                'name' => 'Zimbabue'
            ],
            'en' => [
                'name' => 'Zimbabwe'
            ],
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
