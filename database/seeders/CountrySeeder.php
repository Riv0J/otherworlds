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
        ],
        [
            'es' => [
                'name' => 'Afghanistan'
            ],
            'en' => [
                'name' => 'Afghanistán'
            ],
        ],
        [
            'en' => [
                'name' => 'Albania'
            ],
        ],
        [
            'es' => [
                'name' => 'Algeria'
            ],
            'en' => [
                'name' => 'Argelia'
            ],
        ],
        [
            'en' => [
                'name' => 'Andorra'
            ],
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
        ],
        [
            'en' => [
                'name' => 'Nicaragua'
            ],
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

        ];


        // create the countries using translations
        foreach ($countries as $country_entry) {

            $country_data = [
                'es' => $country_entry['es'] ?? $country_entry['en'],
                'en' => $country_entry['en'],
            ];

            $new_country = Country::create($country_data);
        }

        $countries = [

            ['name' => 'Saint Vincent and the Grenadines'],
            ['name' => 'Samoa'],
            ['name' => 'San Marino'],
            ['name' => 'Sao Tome and Principe'],
            ['name' => 'Saudi Arabia'],
            ['name' => 'Scotland'],
            ['name' => 'Senegal'],
            ['name' => 'Serbia'],
            ['name' => 'Seychelles'],
            ['name' => 'Sierra Leone'],
            ['name' => 'Singapore'],
            ['name' => 'Slovakia'],
            ['name' => 'Slovenia'],
            ['name' => 'Solomon Islands'],
            ['name' => 'Somalia'],
            ['name' => 'South Africa'],
            ['name' => 'South Korea'],
            ['name' => 'South Sudan'],
            ['name' => 'Spain'],
            ['name' => 'Sri Lanka'],
            ['name' => 'Sudan'],
            ['name' => 'Suriname'],
            ['name' => 'Sweden'],
            ['name' => 'Switzerland'],
            ['name' => 'Syria'],
            ['name' => 'Tajikistan'],
            ['name' => 'Tanzania'],
            ['name' => 'Thailand'],
            ['name' => 'Timor-Leste'],
            ['name' => 'Togo'],
            ['name' => 'Tonga'],
            ['name' => 'Trinidad and Tobago'],
            ['name' => 'Tunisia'],
            ['name' => 'Turkey'],
            ['name' => 'Turkmenistan'],
            ['name' => 'Tuvalu'],
            ['name' => 'Uganda'],
            ['name' => 'Ukraine'],
            ['name' => 'United Arab Emirates'],
            ['name' => 'United Kingdom'],
            ['name' => 'United States'],
            ['name' => 'Uruguay'],
            ['name' => 'Uzbekistan'],
            ['name' => 'Vanuatu'],
            ['name' => 'Vatican City'],
            ['name' => 'Venezuela'],
            ['name' => 'Vietnam'],
            ['name' => 'Yemen'],
            ['name' => 'Zambia'],
            ['name' => 'Zimbabwe'],
        ];
    }
}
