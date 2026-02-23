<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhoneCodeController extends Controller
{
    /**
     * Liste complète des pays avec indicatifs téléphoniques.
     */
    private static function allCountries(): array
    {
        return [
            // Afrique de l'Ouest
            ['code' => '+229', 'iso' => 'BJ', 'flag' => '🇧🇯', 'name' => 'Bénin'],
            ['code' => '+226', 'iso' => 'BF', 'flag' => '🇧🇫', 'name' => 'Burkina Faso'],
            ['code' => '+238', 'iso' => 'CV', 'flag' => '🇨🇻', 'name' => 'Cap-Vert'],
            ['code' => '+225', 'iso' => 'CI', 'flag' => '🇨🇮', 'name' => "Côte d'Ivoire"],
            ['code' => '+220', 'iso' => 'GM', 'flag' => '🇬🇲', 'name' => 'Gambie'],
            ['code' => '+233', 'iso' => 'GH', 'flag' => '🇬🇭', 'name' => 'Ghana'],
            ['code' => '+224', 'iso' => 'GN', 'flag' => '🇬🇳', 'name' => 'Guinée'],
            ['code' => '+245', 'iso' => 'GW', 'flag' => '🇬🇼', 'name' => 'Guinée-Bissau'],
            ['code' => '+231', 'iso' => 'LR', 'flag' => '🇱🇷', 'name' => 'Libéria'],
            ['code' => '+223', 'iso' => 'ML', 'flag' => '🇲🇱', 'name' => 'Mali'],
            ['code' => '+222', 'iso' => 'MR', 'flag' => '🇲🇷', 'name' => 'Mauritanie'],
            ['code' => '+227', 'iso' => 'NE', 'flag' => '🇳🇪', 'name' => 'Niger'],
            ['code' => '+234', 'iso' => 'NG', 'flag' => '🇳🇬', 'name' => 'Nigéria'],
            ['code' => '+221', 'iso' => 'SN', 'flag' => '🇸🇳', 'name' => 'Sénégal'],
            ['code' => '+232', 'iso' => 'SL', 'flag' => '🇸🇱', 'name' => 'Sierra Leone'],
            ['code' => '+228', 'iso' => 'TG', 'flag' => '🇹🇬', 'name' => 'Togo'],

            // Afrique Centrale
            ['code' => '+237', 'iso' => 'CM', 'flag' => '🇨🇲', 'name' => 'Cameroun'],
            ['code' => '+236', 'iso' => 'CF', 'flag' => '🇨🇫', 'name' => 'Centrafrique'],
            ['code' => '+242', 'iso' => 'CG', 'flag' => '🇨🇬', 'name' => 'Congo'],
            ['code' => '+243', 'iso' => 'CD', 'flag' => '🇨🇩', 'name' => 'RD Congo'],
            ['code' => '+241', 'iso' => 'GA', 'flag' => '🇬🇦', 'name' => 'Gabon'],
            ['code' => '+240', 'iso' => 'GQ', 'flag' => '🇬🇶', 'name' => 'Guinée Équatoriale'],
            ['code' => '+235', 'iso' => 'TD', 'flag' => '🇹🇩', 'name' => 'Tchad'],
            ['code' => '+239', 'iso' => 'ST', 'flag' => '🇸🇹', 'name' => 'São Tomé-et-Príncipe'],

            // Afrique de l'Est
            ['code' => '+257', 'iso' => 'BI', 'flag' => '🇧🇮', 'name' => 'Burundi'],
            ['code' => '+269', 'iso' => 'KM', 'flag' => '🇰🇲', 'name' => 'Comores'],
            ['code' => '+253', 'iso' => 'DJ', 'flag' => '🇩🇯', 'name' => 'Djibouti'],
            ['code' => '+291', 'iso' => 'ER', 'flag' => '🇪🇷', 'name' => 'Érythrée'],
            ['code' => '+251', 'iso' => 'ET', 'flag' => '🇪🇹', 'name' => 'Éthiopie'],
            ['code' => '+254', 'iso' => 'KE', 'flag' => '🇰🇪', 'name' => 'Kenya'],
            ['code' => '+261', 'iso' => 'MG', 'flag' => '🇲🇬', 'name' => 'Madagascar'],
            ['code' => '+230', 'iso' => 'MU', 'flag' => '🇲🇺', 'name' => 'Maurice'],
            ['code' => '+258', 'iso' => 'MZ', 'flag' => '🇲🇿', 'name' => 'Mozambique'],
            ['code' => '+250', 'iso' => 'RW', 'flag' => '🇷🇼', 'name' => 'Rwanda'],
            ['code' => '+248', 'iso' => 'SC', 'flag' => '🇸🇨', 'name' => 'Seychelles'],
            ['code' => '+252', 'iso' => 'SO', 'flag' => '🇸🇴', 'name' => 'Somalie'],
            ['code' => '+211', 'iso' => 'SS', 'flag' => '🇸🇸', 'name' => 'Soudan du Sud'],
            ['code' => '+255', 'iso' => 'TZ', 'flag' => '🇹🇿', 'name' => 'Tanzanie'],
            ['code' => '+256', 'iso' => 'UG', 'flag' => '🇺🇬', 'name' => 'Ouganda'],

            // Afrique du Nord
            ['code' => '+213', 'iso' => 'DZ', 'flag' => '🇩🇿', 'name' => 'Algérie'],
            ['code' => '+20', 'iso' => 'EG', 'flag' => '🇪🇬', 'name' => 'Égypte'],
            ['code' => '+218', 'iso' => 'LY', 'flag' => '🇱🇾', 'name' => 'Libye'],
            ['code' => '+212', 'iso' => 'MA', 'flag' => '🇲🇦', 'name' => 'Maroc'],
            ['code' => '+249', 'iso' => 'SD', 'flag' => '🇸🇩', 'name' => 'Soudan'],
            ['code' => '+216', 'iso' => 'TN', 'flag' => '🇹🇳', 'name' => 'Tunisie'],

            // Afrique Australe
            ['code' => '+244', 'iso' => 'AO', 'flag' => '🇦🇴', 'name' => 'Angola'],
            ['code' => '+267', 'iso' => 'BW', 'flag' => '🇧🇼', 'name' => 'Botswana'],
            ['code' => '+266', 'iso' => 'LS', 'flag' => '🇱🇸', 'name' => 'Lesotho'],
            ['code' => '+265', 'iso' => 'MW', 'flag' => '🇲🇼', 'name' => 'Malawi'],
            ['code' => '+264', 'iso' => 'NA', 'flag' => '🇳🇦', 'name' => 'Namibie'],
            ['code' => '+27', 'iso' => 'ZA', 'flag' => '🇿🇦', 'name' => 'Afrique du Sud'],
            ['code' => '+268', 'iso' => 'SZ', 'flag' => '🇸🇿', 'name' => 'Eswatini'],
            ['code' => '+260', 'iso' => 'ZM', 'flag' => '🇿🇲', 'name' => 'Zambie'],
            ['code' => '+263', 'iso' => 'ZW', 'flag' => '🇿🇼', 'name' => 'Zimbabwe'],

            // Europe
            ['code' => '+355', 'iso' => 'AL', 'flag' => '🇦🇱', 'name' => 'Albanie'],
            ['code' => '+49', 'iso' => 'DE', 'flag' => '🇩🇪', 'name' => 'Allemagne'],
            ['code' => '+376', 'iso' => 'AD', 'flag' => '🇦🇩', 'name' => 'Andorre'],
            ['code' => '+43', 'iso' => 'AT', 'flag' => '🇦🇹', 'name' => 'Autriche'],
            ['code' => '+32', 'iso' => 'BE', 'flag' => '🇧🇪', 'name' => 'Belgique'],
            ['code' => '+375', 'iso' => 'BY', 'flag' => '🇧🇾', 'name' => 'Biélorussie'],
            ['code' => '+387', 'iso' => 'BA', 'flag' => '🇧🇦', 'name' => 'Bosnie-Herzégovine'],
            ['code' => '+359', 'iso' => 'BG', 'flag' => '🇧🇬', 'name' => 'Bulgarie'],
            ['code' => '+385', 'iso' => 'HR', 'flag' => '🇭🇷', 'name' => 'Croatie'],
            ['code' => '+357', 'iso' => 'CY', 'flag' => '🇨🇾', 'name' => 'Chypre'],
            ['code' => '+45', 'iso' => 'DK', 'flag' => '🇩🇰', 'name' => 'Danemark'],
            ['code' => '+34', 'iso' => 'ES', 'flag' => '🇪🇸', 'name' => 'Espagne'],
            ['code' => '+372', 'iso' => 'EE', 'flag' => '🇪🇪', 'name' => 'Estonie'],
            ['code' => '+358', 'iso' => 'FI', 'flag' => '🇫🇮', 'name' => 'Finlande'],
            ['code' => '+33', 'iso' => 'FR', 'flag' => '🇫🇷', 'name' => 'France'],
            ['code' => '+30', 'iso' => 'GR', 'flag' => '🇬🇷', 'name' => 'Grèce'],
            ['code' => '+36', 'iso' => 'HU', 'flag' => '🇭🇺', 'name' => 'Hongrie'],
            ['code' => '+353', 'iso' => 'IE', 'flag' => '🇮🇪', 'name' => 'Irlande'],
            ['code' => '+354', 'iso' => 'IS', 'flag' => '🇮🇸', 'name' => 'Islande'],
            ['code' => '+39', 'iso' => 'IT', 'flag' => '🇮🇹', 'name' => 'Italie'],
            ['code' => '+371', 'iso' => 'LV', 'flag' => '🇱🇻', 'name' => 'Lettonie'],
            ['code' => '+423', 'iso' => 'LI', 'flag' => '🇱🇮', 'name' => 'Liechtenstein'],
            ['code' => '+370', 'iso' => 'LT', 'flag' => '🇱🇹', 'name' => 'Lituanie'],
            ['code' => '+352', 'iso' => 'LU', 'flag' => '🇱🇺', 'name' => 'Luxembourg'],
            ['code' => '+389', 'iso' => 'MK', 'flag' => '🇲🇰', 'name' => 'Macédoine du Nord'],
            ['code' => '+356', 'iso' => 'MT', 'flag' => '🇲🇹', 'name' => 'Malte'],
            ['code' => '+373', 'iso' => 'MD', 'flag' => '🇲🇩', 'name' => 'Moldavie'],
            ['code' => '+377', 'iso' => 'MC', 'flag' => '🇲🇨', 'name' => 'Monaco'],
            ['code' => '+382', 'iso' => 'ME', 'flag' => '🇲🇪', 'name' => 'Monténégro'],
            ['code' => '+47', 'iso' => 'NO', 'flag' => '🇳🇴', 'name' => 'Norvège'],
            ['code' => '+31', 'iso' => 'NL', 'flag' => '🇳🇱', 'name' => 'Pays-Bas'],
            ['code' => '+48', 'iso' => 'PL', 'flag' => '🇵🇱', 'name' => 'Pologne'],
            ['code' => '+351', 'iso' => 'PT', 'flag' => '🇵🇹', 'name' => 'Portugal'],
            ['code' => '+420', 'iso' => 'CZ', 'flag' => '🇨🇿', 'name' => 'Tchéquie'],
            ['code' => '+40', 'iso' => 'RO', 'flag' => '🇷🇴', 'name' => 'Roumanie'],
            ['code' => '+44', 'iso' => 'GB', 'flag' => '🇬🇧', 'name' => 'Royaume-Uni'],
            ['code' => '+7', 'iso' => 'RU', 'flag' => '🇷🇺', 'name' => 'Russie'],
            ['code' => '+378', 'iso' => 'SM', 'flag' => '🇸🇲', 'name' => 'Saint-Marin'],
            ['code' => '+381', 'iso' => 'RS', 'flag' => '🇷🇸', 'name' => 'Serbie'],
            ['code' => '+421', 'iso' => 'SK', 'flag' => '🇸🇰', 'name' => 'Slovaquie'],
            ['code' => '+386', 'iso' => 'SI', 'flag' => '🇸🇮', 'name' => 'Slovénie'],
            ['code' => '+46', 'iso' => 'SE', 'flag' => '🇸🇪', 'name' => 'Suède'],
            ['code' => '+41', 'iso' => 'CH', 'flag' => '🇨🇭', 'name' => 'Suisse'],
            ['code' => '+380', 'iso' => 'UA', 'flag' => '🇺🇦', 'name' => 'Ukraine'],
            ['code' => '+379', 'iso' => 'VA', 'flag' => '🇻🇦', 'name' => 'Vatican'],
            ['code' => '+383', 'iso' => 'XK', 'flag' => '🇽🇰', 'name' => 'Kosovo'],

            // Amérique du Nord
            ['code' => '+1', 'iso' => 'US', 'flag' => '🇺🇸', 'name' => 'États-Unis'],
            ['code' => '+1', 'iso' => 'CA', 'flag' => '🇨🇦', 'name' => 'Canada'],
            ['code' => '+52', 'iso' => 'MX', 'flag' => '🇲🇽', 'name' => 'Mexique'],

            // Amérique Centrale & Caraïbes
            ['code' => '+501', 'iso' => 'BZ', 'flag' => '🇧🇿', 'name' => 'Belize'],
            ['code' => '+506', 'iso' => 'CR', 'flag' => '🇨🇷', 'name' => 'Costa Rica'],
            ['code' => '+53', 'iso' => 'CU', 'flag' => '🇨🇺', 'name' => 'Cuba'],
            ['code' => '+503', 'iso' => 'SV', 'flag' => '🇸🇻', 'name' => 'Salvador'],
            ['code' => '+502', 'iso' => 'GT', 'flag' => '🇬🇹', 'name' => 'Guatemala'],
            ['code' => '+509', 'iso' => 'HT', 'flag' => '🇭🇹', 'name' => 'Haïti'],
            ['code' => '+504', 'iso' => 'HN', 'flag' => '🇭🇳', 'name' => 'Honduras'],
            ['code' => '+876', 'iso' => 'JM', 'flag' => '🇯🇲', 'name' => 'Jamaïque'],
            ['code' => '+505', 'iso' => 'NI', 'flag' => '🇳🇮', 'name' => 'Nicaragua'],
            ['code' => '+507', 'iso' => 'PA', 'flag' => '🇵🇦', 'name' => 'Panama'],
            ['code' => '+809', 'iso' => 'DO', 'flag' => '🇩🇴', 'name' => 'Rép. Dominicaine'],
            ['code' => '+868', 'iso' => 'TT', 'flag' => '🇹🇹', 'name' => 'Trinité-et-Tobago'],

            // Amérique du Sud
            ['code' => '+54', 'iso' => 'AR', 'flag' => '🇦🇷', 'name' => 'Argentine'],
            ['code' => '+591', 'iso' => 'BO', 'flag' => '🇧🇴', 'name' => 'Bolivie'],
            ['code' => '+55', 'iso' => 'BR', 'flag' => '🇧🇷', 'name' => 'Brésil'],
            ['code' => '+56', 'iso' => 'CL', 'flag' => '🇨🇱', 'name' => 'Chili'],
            ['code' => '+57', 'iso' => 'CO', 'flag' => '🇨🇴', 'name' => 'Colombie'],
            ['code' => '+593', 'iso' => 'EC', 'flag' => '🇪🇨', 'name' => 'Équateur'],
            ['code' => '+592', 'iso' => 'GY', 'flag' => '🇬🇾', 'name' => 'Guyana'],
            ['code' => '+595', 'iso' => 'PY', 'flag' => '🇵🇾', 'name' => 'Paraguay'],
            ['code' => '+51', 'iso' => 'PE', 'flag' => '🇵🇪', 'name' => 'Pérou'],
            ['code' => '+597', 'iso' => 'SR', 'flag' => '🇸🇷', 'name' => 'Suriname'],
            ['code' => '+598', 'iso' => 'UY', 'flag' => '🇺🇾', 'name' => 'Uruguay'],
            ['code' => '+58', 'iso' => 'VE', 'flag' => '🇻🇪', 'name' => 'Venezuela'],

            // Asie - Moyen-Orient
            ['code' => '+966', 'iso' => 'SA', 'flag' => '🇸🇦', 'name' => 'Arabie Saoudite'],
            ['code' => '+973', 'iso' => 'BH', 'flag' => '🇧🇭', 'name' => 'Bahreïn'],
            ['code' => '+971', 'iso' => 'AE', 'flag' => '🇦🇪', 'name' => 'Émirats Arabes Unis'],
            ['code' => '+964', 'iso' => 'IQ', 'flag' => '🇮🇶', 'name' => 'Irak'],
            ['code' => '+98', 'iso' => 'IR', 'flag' => '🇮🇷', 'name' => 'Iran'],
            ['code' => '+972', 'iso' => 'IL', 'flag' => '🇮🇱', 'name' => 'Israël'],
            ['code' => '+962', 'iso' => 'JO', 'flag' => '🇯🇴', 'name' => 'Jordanie'],
            ['code' => '+965', 'iso' => 'KW', 'flag' => '🇰🇼', 'name' => 'Koweït'],
            ['code' => '+961', 'iso' => 'LB', 'flag' => '🇱🇧', 'name' => 'Liban'],
            ['code' => '+968', 'iso' => 'OM', 'flag' => '🇴🇲', 'name' => 'Oman'],
            ['code' => '+970', 'iso' => 'PS', 'flag' => '🇵🇸', 'name' => 'Palestine'],
            ['code' => '+974', 'iso' => 'QA', 'flag' => '🇶🇦', 'name' => 'Qatar'],
            ['code' => '+963', 'iso' => 'SY', 'flag' => '🇸🇾', 'name' => 'Syrie'],
            ['code' => '+90', 'iso' => 'TR', 'flag' => '🇹🇷', 'name' => 'Turquie'],
            ['code' => '+967', 'iso' => 'YE', 'flag' => '🇾🇪', 'name' => 'Yémen'],

            // Asie - Reste
            ['code' => '+93', 'iso' => 'AF', 'flag' => '🇦🇫', 'name' => 'Afghanistan'],
            ['code' => '+374', 'iso' => 'AM', 'flag' => '🇦🇲', 'name' => 'Arménie'],
            ['code' => '+994', 'iso' => 'AZ', 'flag' => '🇦🇿', 'name' => 'Azerbaïdjan'],
            ['code' => '+880', 'iso' => 'BD', 'flag' => '🇧🇩', 'name' => 'Bangladesh'],
            ['code' => '+673', 'iso' => 'BN', 'flag' => '🇧🇳', 'name' => 'Brunei'],
            ['code' => '+855', 'iso' => 'KH', 'flag' => '🇰🇭', 'name' => 'Cambodge'],
            ['code' => '+86', 'iso' => 'CN', 'flag' => '🇨🇳', 'name' => 'Chine'],
            ['code' => '+82', 'iso' => 'KR', 'flag' => '🇰🇷', 'name' => 'Corée du Sud'],
            ['code' => '+850', 'iso' => 'KP', 'flag' => '🇰🇵', 'name' => 'Corée du Nord'],
            ['code' => '+995', 'iso' => 'GE', 'flag' => '🇬🇪', 'name' => 'Géorgie'],
            ['code' => '+91', 'iso' => 'IN', 'flag' => '🇮🇳', 'name' => 'Inde'],
            ['code' => '+62', 'iso' => 'ID', 'flag' => '🇮🇩', 'name' => 'Indonésie'],
            ['code' => '+81', 'iso' => 'JP', 'flag' => '🇯🇵', 'name' => 'Japon'],
            ['code' => '+7', 'iso' => 'KZ', 'flag' => '🇰🇿', 'name' => 'Kazakhstan'],
            ['code' => '+996', 'iso' => 'KG', 'flag' => '🇰🇬', 'name' => 'Kirghizistan'],
            ['code' => '+856', 'iso' => 'LA', 'flag' => '🇱🇦', 'name' => 'Laos'],
            ['code' => '+60', 'iso' => 'MY', 'flag' => '🇲🇾', 'name' => 'Malaisie'],
            ['code' => '+960', 'iso' => 'MV', 'flag' => '🇲🇻', 'name' => 'Maldives'],
            ['code' => '+976', 'iso' => 'MN', 'flag' => '🇲🇳', 'name' => 'Mongolie'],
            ['code' => '+95', 'iso' => 'MM', 'flag' => '🇲🇲', 'name' => 'Myanmar'],
            ['code' => '+977', 'iso' => 'NP', 'flag' => '🇳🇵', 'name' => 'Népal'],
            ['code' => '+998', 'iso' => 'UZ', 'flag' => '🇺🇿', 'name' => 'Ouzbékistan'],
            ['code' => '+92', 'iso' => 'PK', 'flag' => '🇵🇰', 'name' => 'Pakistan'],
            ['code' => '+63', 'iso' => 'PH', 'flag' => '🇵🇭', 'name' => 'Philippines'],
            ['code' => '+65', 'iso' => 'SG', 'flag' => '🇸🇬', 'name' => 'Singapour'],
            ['code' => '+94', 'iso' => 'LK', 'flag' => '🇱🇰', 'name' => 'Sri Lanka'],
            ['code' => '+992', 'iso' => 'TJ', 'flag' => '🇹🇯', 'name' => 'Tadjikistan'],
            ['code' => '+886', 'iso' => 'TW', 'flag' => '🇹🇼', 'name' => 'Taïwan'],
            ['code' => '+66', 'iso' => 'TH', 'flag' => '🇹🇭', 'name' => 'Thaïlande'],
            ['code' => '+670', 'iso' => 'TL', 'flag' => '🇹🇱', 'name' => 'Timor oriental'],
            ['code' => '+993', 'iso' => 'TM', 'flag' => '🇹🇲', 'name' => 'Turkménistan'],
            ['code' => '+84', 'iso' => 'VN', 'flag' => '🇻🇳', 'name' => 'Viêt Nam'],

            // Océanie
            ['code' => '+61', 'iso' => 'AU', 'flag' => '🇦🇺', 'name' => 'Australie'],
            ['code' => '+679', 'iso' => 'FJ', 'flag' => '🇫🇯', 'name' => 'Fidji'],
            ['code' => '+64', 'iso' => 'NZ', 'flag' => '🇳🇿', 'name' => 'Nouvelle-Zélande'],
            ['code' => '+675', 'iso' => 'PG', 'flag' => '🇵🇬', 'name' => 'Papouasie-Nouvelle-Guinée'],

            // DOM-TOM
            ['code' => '+590', 'iso' => 'GP', 'flag' => '🇬🇵', 'name' => 'Guadeloupe'],
            ['code' => '+596', 'iso' => 'MQ', 'flag' => '🇲🇶', 'name' => 'Martinique'],
            ['code' => '+594', 'iso' => 'GF', 'flag' => '🇬🇫', 'name' => 'Guyane française'],
            ['code' => '+262', 'iso' => 'RE', 'flag' => '🇷🇪', 'name' => 'La Réunion'],
            ['code' => '+262', 'iso' => 'YT', 'flag' => '🇾🇹', 'name' => 'Mayotte'],
            ['code' => '+687', 'iso' => 'NC', 'flag' => '🇳🇨', 'name' => 'Nouvelle-Calédonie'],
            ['code' => '+689', 'iso' => 'PF', 'flag' => '🇵🇫', 'name' => 'Polynésie française'],
        ];
    }

    /**
     * Supprime les accents d'une chaîne pour la recherche.
     */
    private static function removeAccents(string $str): string
    {
        $transliterator = \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC');
        return $transliterator ? $transliterator->transliterate($str) : $str;
    }

    /**
     * Recherche AJAX des pays par nom, code ou ISO.
     */
    public function search(Request $request)
    {
        $query = mb_strtolower(trim($request->input('q', '')));
        $countries = self::allCountries();

        if ($query === '') {
            return response()->json($countries);
        }

        $queryNorm = self::removeAccents($query);

        $filtered = array_values(array_filter($countries, function ($country) use ($query, $queryNorm) {
            $nameNorm = self::removeAccents(mb_strtolower($country['name']));
            return str_contains($nameNorm, $queryNorm)
                || str_contains(mb_strtolower($country['name']), $query)
                || str_contains($country['code'], $query)
                || str_contains(mb_strtolower($country['iso']), $query);
        }));

        return response()->json($filtered);
    }
}
