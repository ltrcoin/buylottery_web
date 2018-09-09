<?php

namespace App\Http\Models\Frontend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;
    protected $table = 'customers';
    /*protected $keyType = 'string';
    protected $primaryKey = 'idmsv';*/

    const STATUS_WAIT    = 0;
    const STATUS_ACTIVE  = 1;
    const STATUS_BLOCK   = 2;
    const PAGE_SIZE      = 10;
    const SEX_MALE       = 1;
    const SEX_FEMALE     = 2;
    const SEX_OTHER      = 3;

    static $SEX = [
    	self::SEX_MALE    => 'Male',
        self::SEX_FEMALE  => 'Female',
        self::SEX_OTHER   => 'Other'
    ];

    public function passwordSecurity()
    {
        return $this->hasOne(PasswordSecurity::class);
    }
    
    static $COUNTRY = [
        1 => 'Afghanistan',
        2 => 'Albania',
        3 => 'Algeria',
        4 => 'American Samoa',
        5 => 'Andorra',
        6 => 'Angola',
        7 => 'Anguilla',
        8 => 'Antarctica',
        9 => 'Antigua and Barbuda',
        10 => 'Argentina',
        11 => 'Armenia',
        12 => 'Aruba',
        13 => 'Australia',
        14 => 'Austria',
        15 => 'Azerbaijan',
        16 => 'Bahamas ',
        17 => 'Bahrain',
        18 => 'Bangladesh',
        19 => 'Barbados',
        20 => 'Belarus',
        21 => 'Belgium',
        22 => 'Belize',
        23 => 'Benin',
        24 => 'Bermuda',
        25 => 'Bhutan',
        26 => 'Bolivia',
        27 => 'Bosnia and Herzegovina',
        28 => 'Botswana',
        29 => 'Bouvet Island',
        30 => 'Brazil',
        31 => 'British Indian Ocean Territory',
        32 => 'Brunei',
        33 => 'Bulgaria',
        34 => 'Burkina Faso',
        35 => 'Burundi',
        36 => 'Cambodia',
        37 => 'Cameroon',
        38 => 'Canada',
        39 => 'Canary Islands',
        40 => 'Cape Verde',
        41 => 'Cayman Islands',
        42 => 'Central African Republic',
        43 => 'Chad',
        44 => 'Chile',
        45 => 'China',
        46 => 'Christmas Island',
        47 => 'Cocos (Keeling) Islands',
        48 => 'Colombia',
        49 => 'Comoros',
        50 => 'Congo',
        51 => 'Congo, Democractic Republic of the',
        52 => 'Cook Islands',
        53 => 'Costa Rica',
        54 => 'Cote d\'Ivoire',
        55 => 'Croatia (Hrvatska)',
        56 => 'Cuba',
        57 => 'Cyprus',
        58 => 'Czech Republic',
        59 => 'Denmark',
        60 => 'Djibouti',
        61 => 'Dominica',
        62 => 'Dominican Republic',
        63 => 'East Timor',
        64 => 'Ecuador',
        65 => 'Egypt',
        66 => 'El Salvador',
        67 => 'Equatorial Guinea',
        68 => 'Eritrea',
        69 => 'Estonia',
        70 => 'Ethiopia',
        71 => 'Falkland Islands (Islas Malvinas)',
        72 => 'Faroe Islands',
        73 => 'Fiji Islands',
        74 => 'Finland',
        75 => 'France',
        76 => 'French Guiana',
        77 => 'French Polynesia',
        78 => 'French Southern Territories',
        79 => 'Gabon',
        80 => 'Gambia, The',
        81 => 'Georgia',
        82 => 'Germany',
        83 => 'Ghana',
        84 => 'Gibraltar',
        85 => 'Greece',
        86 => 'Greenland',
        87 => 'Grenada',
        88 => 'Guadeloupe',
        89 => 'Guam',
        90 => 'Guatemala',
        91 => 'Guernsey',
        92 => 'Guinea',
        93 => 'Guinea-Bissau',
        94 => 'Guyana',
        95 => 'Haiti',
        96 => 'Heard and McDonald Islands',
        97 => 'Honduras',
        98 => 'Hong Kong',
        99 => 'Hungary',
        100 => 'Iceland',
        101 => 'India',
        102 => 'Indonesia',
        103 => 'Iran',
        104 => 'Iraq',
        105 => 'Ireland',
        106 => 'Isle of Man',
        107 => 'Israel',
        108 => 'Italy',
        109 => 'Ivory Coast',
        110 => 'Jamaica',
        111 => 'Japan',
        112 => 'Jersey',
        113 => 'Jordan',
        114 => 'Kazakhstan',
        115 => 'Kenya',
        116 => 'Kiribati',
        117 => 'Korea',
        118 => 'Korea, North',
        119 => 'Kosovo',
        120 => 'Kuwait',
        121 => 'Kyrgyzstan',
        122 => 'Laos',
        123 => 'Latvia',
        124 => 'Lebanon',
        125 => 'Lesotho',
        126 => 'Liberia',
        127 => 'Libya',
        128 => 'Liechtenstein',
        129 => 'Lithuania',
        130 => 'Luxembourg',
        131 => 'Macau S.A.R.',
        132 => 'Macedonia',
        133 => 'Madagascar',
        134 => 'Malawi',
        135 => 'Malaysia',
        136 => 'Maldives',
        137 => 'Mali',
        138 => 'Malta',
        139 => 'Marshall Islands',
        140 => 'Martinique',
        141 => 'Mauritania',
        142 => 'Mauritius',
        143 => 'Mayotte Island (Comoros)',
        144 => 'Mexico',
        145 => 'Micronesia',
        146 => 'Moldova',
        147 => 'Monaco',
        148 => 'Mongolia',
        149 => 'Montenegro',
        150 => 'Montserrat',
        151 => 'Morocco',
        152 => 'Mozambique',
        153 => 'Myanmar',
        154 => 'Namibia',
        155 => 'Nauru',
        156 => 'Nepal',
        157 => 'Netherlands',
        158 => 'Netherlands Antilles',
        159 => 'New Caledonia',
        160 => 'New Zealand',
        161 => 'Nicaragua',
        162 => 'Niger',
        163 => 'Nigeria',
        164 => 'Niue',
        165 => 'Norfolk Island',
        166 => 'Northern Mariana Islands',
        167 => 'Norway',
        168 => 'Oman',
        169 => 'Pakistan',
        170 => 'Palau',
        171 => 'Panama',
        172 => 'Papua new Guinea',
        173 => 'Paraguay',
        174 => 'Peru',
        175 => 'Philippines',
        176 => 'Pitcairn Island',
        177 => 'Poland',
        178 => 'Portugal',
        179 => 'Puerto Rico',
        180 => 'Qatar',
        181 => 'Reunion',
        182 => 'Romania',
        183 => 'Russia',
        184 => 'Rwanda',
        185 => 'Saint Helena',
        186 => 'Saint Kitts And Nevis',
        187 => 'Saint Lucia',
        188 => 'Saint Pierre and Miquelon',
        189 => 'Saint Vincent And The Grenadines',
        190 => 'Saipan',
        191 => 'Samoa (American)',
        192 => 'Samoa (Western)',
        193 => 'San Marino',
        194 => 'Sao Tome and Principe',
        195 => 'Saudi Arabia',
        196 => 'Scandinavia',
        197 => 'Senegal',
        198 => 'Serbia',
        199 => 'Seychelles',
        200 => 'Sierra Leone',
        201 => 'Singapore',
        202 => 'Slovakia',
        203 => 'Slovenia',
        204 => 'Solomon Islands',
        205 => 'Somalia',
        206 => 'South Africa',
        207 => 'South Georgia And The South Sandwich Islands',
        208 => 'Spain',
        209 => 'Sri Lanka',
        210 => 'Sudan',
        211 => 'Suriname',
        212 => 'Svalbard And Jan Mayen Islands',
        213 => 'Swaziland',
        214 => 'Sweden',
        215 => 'Switzerland',
        216 => 'Syria',
        217 => 'Taiwan',
        218 => 'Tajikistan',
        219 => 'Tanzania',
        220 => 'Thailand',
        221 => 'Togo',
        222 => 'Tokelau',
        223 => 'Tonga',
        224 => 'Trinidad And Tobago',
        225 => 'Tunisia',
        226 => 'Turkey',
        227 => 'Turkmenistan',
        228 => 'Turks And Caicos Islands',
        229 => 'Tuvalu',
        230 => 'U.K.',
        231 => 'USA',
        232 => 'Uganda',
        233 => 'Ukraine',
        234 => 'United Arab Emirates',
        235 => 'United States Minor Outlying Islands',
        236 => 'Uruguay',
        237 => 'Uzbekistan',
        238 => 'Vanuatu',
        239 => 'Vatican City State (Holy See)',
        240 => 'Venezuela',
        241 => 'Vietnam',
        242 => 'Virgin Islands (British)',
        243 => 'Virgin Islands (US)',
        244 => 'Wallis And Futuna Islands',
        245 => 'Yemen',
        246 => 'Yugoslavia',
        247 => 'Zambia',
        248 => 'Zanaibar',
        249 => 'Zimbabwe'
    ];
}