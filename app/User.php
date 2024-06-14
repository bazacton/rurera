<?php

namespace App;

use App\Bitwise\UserLevelOfTraining;
use App\Models\Accounting;
use App\Models\Badge;
use App\Models\BundleWebinar;
use App\Models\ForumTopic;
use App\Models\ForumTopicLike;
use App\Models\ForumTopicPost;
use App\Models\Meeting;
use App\Models\Noticeboard;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\ProductOrder;
use App\Models\QuizzAttempts;
use App\Models\QuizzesResult;
use App\Models\QuizzResultQuestions;
use App\Models\Region;
use App\Models\ReserveMeeting;
use App\Models\RewardAccounting;
use App\Models\UserAssignedTopics;
use App\Models\UserSubscriptions;
use App\Models\Role;
use App\Models\Follow;
use App\Models\Sale;
use App\Models\Section;
use App\Models\Webinar;
use App\Models\DailyQuests;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable; 
    use Billable;

    static $active = 'active';
    static $pending = 'pending';
    static $inactive = 'inactive';
    static $timeZones = array(
        [
            "label" => "Africa/Abidjan",
            "value" => "Africa/Abidjan"
        ],
        [
            "label" => "Africa/Accra",
            "value" => "Africa/Accra"
        ],
        [
            "label" => "Africa/Addis_Ababa",
            "value" => "Africa/Addis_Ababa"
        ],
        [
            "label" => "Africa/Algiers",
            "value" => "Africa/Algiers"
        ],
        [
            "label" => "Africa/Asmara",
            "value" => "Africa/Asmara"
        ],
        [
            "label" => "Africa/Asmera",
            "value" => "Africa/Asmera"
        ],
        [
            "label" => "Africa/Bamako",
            "value" => "Africa/Bamako"
        ],
        [
            "label" => "Africa/Bangui",
            "value" => "Africa/Bangui"
        ],
        [
            "label" => "Africa/Banjul",
            "value" => "Africa/Banjul"
        ],
        [
            "label" => "Africa/Bissau",
            "value" => "Africa/Bissau"
        ],
        [
            "label" => "Africa/Blantyre",
            "value" => "Africa/Blantyre"
        ],
        [
            "label" => "Africa/Brazzaville",
            "value" => "Africa/Brazzaville"
        ],
        [
            "label" => "Africa/Bujumbura",
            "value" => "Africa/Bujumbura"
        ],
        [
            "label" => "Africa/Cairo",
            "value" => "Africa/Cairo"
        ],
        [
            "label" => "Africa/Casablanca",
            "value" => "Africa/Casablanca"
        ],
        [
            "label" => "Africa/Ceuta",
            "value" => "Africa/Ceuta"
        ],
        [
            "label" => "Africa/Conakry",
            "value" => "Africa/Conakry"
        ],
        [
            "label" => "Africa/Dakar",
            "value" => "Africa/Dakar"
        ],
        [
            "label" => "Africa/Dar_es_Salaam",
            "value" => "Africa/Dar_es_Salaam"
        ],
        [
            "label" => "Africa/Djibouti",
            "value" => "Africa/Djibouti"
        ],
        [
            "label" => "Africa/Douala",
            "value" => "Africa/Douala"
        ],
        [
            "label" => "Africa/El_Aaiun",
            "value" => "Africa/El_Aaiun"
        ],
        [
            "label" => "Africa/Freetown",
            "value" => "Africa/Freetown"
        ],
        [
            "label" => "Africa/Gaborone",
            "value" => "Africa/Gaborone"
        ],
        [
            "label" => "Africa/Harare",
            "value" => "Africa/Harare"
        ],
        [
            "label" => "Africa/Johannesburg",
            "value" => "Africa/Johannesburg"
        ],
        [
            "label" => "Africa/Juba",
            "value" => "Africa/Juba"
        ],
        [
            "label" => "Africa/Kampala",
            "value" => "Africa/Kampala"
        ],
        [
            "label" => "Africa/Khartoum",
            "value" => "Africa/Khartoum"
        ],
        [
            "label" => "Africa/Kigali",
            "value" => "Africa/Kigali"
        ],
        [
            "label" => "Africa/Kinshasa",
            "value" => "Africa/Kinshasa"
        ],
        [
            "label" => "Africa/Lagos",
            "value" => "Africa/Lagos"
        ],
        [
            "label" => "Africa/Libreville",
            "value" => "Africa/Libreville"
        ],
        [
            "label" => "Africa/Lome",
            "value" => "Africa/Lome"
        ],
        [
            "label" => "Africa/Luanda",
            "value" => "Africa/Luanda"
        ],
        [
            "label" => "Africa/Lubumbashi",
            "value" => "Africa/Lubumbashi"
        ],
        [
            "label" => "Africa/Lusaka",
            "value" => "Africa/Lusaka"
        ],
        [
            "label" => "Africa/Malabo",
            "value" => "Africa/Malabo"
        ],
        [
            "label" => "Africa/Maputo",
            "value" => "Africa/Maputo"
        ],
        [
            "label" => "Africa/Maseru",
            "value" => "Africa/Maseru"
        ],
        [
            "label" => "Africa/Mbabane",
            "value" => "Africa/Mbabane"
        ],
        [
            "label" => "Africa/Mogadishu",
            "value" => "Africa/Mogadishu"
        ],
        [
            "label" => "Africa/Monrovia",
            "value" => "Africa/Monrovia"
        ],
        [
            "label" => "Africa/Nairobi",
            "value" => "Africa/Nairobi"
        ],
        [
            "label" => "Africa/Ndjamena",
            "value" => "Africa/Ndjamena"
        ],
        [
            "label" => "Africa/Niamey",
            "value" => "Africa/Niamey"
        ],
        [
            "label" => "Africa/Nouakchott",
            "value" => "Africa/Nouakchott"
        ],
        [
            "label" => "Africa/Ouagadougou",
            "value" => "Africa/Ouagadougou"
        ],
        [
            "label" => "Africa/Porto-Novo",
            "value" => "Africa/Porto-Novo"
        ],
        [
            "label" => "Africa/Sao_Tome",
            "value" => "Africa/Sao_Tome"
        ],
        [
            "label" => "Africa/Timbuktu",
            "value" => "Africa/Timbuktu"
        ],
        [
            "label" => "Africa/Tripoli",
            "value" => "Africa/Tripoli"
        ],
        [
            "label" => "Africa/Tunis",
            "value" => "Africa/Tunis"
        ],
        [
            "label" => "Africa/Windhoek",
            "value" => "Africa/Windhoek"
        ],
        [
            "label" => "America/Adak",
            "value" => "America/Adak"
        ],
        [
            "label" => "America/Anchorage",
            "value" => "America/Anchorage"
        ],
        [
            "label" => "America/Anguilla",
            "value" => "America/Anguilla"
        ],
        [
            "label" => "America/Antigua",
            "value" => "America/Antigua"
        ],
        [
            "label" => "America/Araguaina",
            "value" => "America/Araguaina"
        ],
        [
            "label" => "America/Argentina/Buenos_Aires",
            "value" => "America/Argentina/Buenos_Aires"
        ],
        [
            "label" => "America/Argentina/Catamarca",
            "value" => "America/Argentina/Catamarca"
        ],
        [
            "label" => "America/Argentina/ComodRivadavia",
            "value" => "America/Argentina/ComodRivadavia"
        ],
        [
            "label" => "America/Argentina/Cordoba",
            "value" => "America/Argentina/Cordoba"
        ],
        [
            "label" => "America/Argentina/Jujuy",
            "value" => "America/Argentina/Jujuy"
        ],
        [
            "label" => "America/Argentina/La_Rioja",
            "value" => "America/Argentina/La_Rioja"
        ],
        [
            "label" => "America/Argentina/Mendoza",
            "value" => "America/Argentina/Mendoza"
        ],
        [
            "label" => "America/Argentina/Rio_Gallegos",
            "value" => "America/Argentina/Rio_Gallegos"
        ],
        [
            "label" => "America/Argentina/Salta",
            "value" => "America/Argentina/Salta"
        ],
        [
            "label" => "America/Argentina/San_Juan",
            "value" => "America/Argentina/San_Juan"
        ],
        [
            "label" => "America/Argentina/San_Luis",
            "value" => "America/Argentina/San_Luis"
        ],
        [
            "label" => "America/Argentina/Tucuman",
            "value" => "America/Argentina/Tucuman"
        ],
        [
            "label" => "America/Argentina/Ushuaia",
            "value" => "America/Argentina/Ushuaia"
        ],
        [
            "label" => "America/Aruba",
            "value" => "America/Aruba"
        ],
        [
            "label" => "America/Asuncion",
            "value" => "America/Asuncion"
        ],
        [
            "label" => "America/Atikokan",
            "value" => "America/Atikokan"
        ],
        [
            "label" => "America/Atka",
            "value" => "America/Atka"
        ],
        [
            "label" => "America/Bahia",
            "value" => "America/Bahia"
        ],
        [
            "label" => "America/Bahia_Banderas",
            "value" => "America/Bahia_Banderas"
        ],
        [
            "label" => "America/Barbados",
            "value" => "America/Barbados"
        ],
        [
            "label" => "America/Belem",
            "value" => "America/Belem"
        ],
        [
            "label" => "America/Belize",
            "value" => "America/Belize"
        ],
        [
            "label" => "America/Blanc-Sablon",
            "value" => "America/Blanc-Sablon"
        ],
        [
            "label" => "America/Boa_Vista",
            "value" => "America/Boa_Vista"
        ],
        [
            "label" => "America/Bogota",
            "value" => "America/Bogota"
        ],
        [
            "label" => "America/Boise",
            "value" => "America/Boise"
        ],
        [
            "label" => "America/Buenos_Aires",
            "value" => "America/Buenos_Aires"
        ],
        [
            "label" => "America/Cambridge_Bay",
            "value" => "America/Cambridge_Bay"
        ],
        [
            "label" => "America/Campo_Grande",
            "value" => "America/Campo_Grande"
        ],
        [
            "label" => "America/Cancun",
            "value" => "America/Cancun"
        ],
        [
            "label" => "America/Caracas",
            "value" => "America/Caracas"
        ],
        [
            "label" => "America/Catamarca",
            "value" => "America/Catamarca"
        ],
        [
            "label" => "America/Cayenne",
            "value" => "America/Cayenne"
        ],
        [
            "label" => "America/Cayman",
            "value" => "America/Cayman"
        ],
        [
            "label" => "America/Chicago",
            "value" => "America/Chicago"
        ],
        [
            "label" => "America/Chihuahua",
            "value" => "America/Chihuahua"
        ],
        [
            "label" => "America/Coral_Harbour",
            "value" => "America/Coral_Harbour"
        ],
        [
            "label" => "America/Cordoba",
            "value" => "America/Cordoba"
        ],
        [
            "label" => "America/Costa_Rica",
            "value" => "America/Costa_Rica"
        ],
        [
            "label" => "America/Creston",
            "value" => "America/Creston"
        ],
        [
            "label" => "America/Cuiaba",
            "value" => "America/Cuiaba"
        ],
        [
            "label" => "America/Curacao",
            "value" => "America/Curacao"
        ],
        [
            "label" => "America/Danmarkshavn",
            "value" => "America/Danmarkshavn"
        ],
        [
            "label" => "America/Dawson",
            "value" => "America/Dawson"
        ],
        [
            "label" => "America/Dawson_Creek",
            "value" => "America/Dawson_Creek"
        ],
        [
            "label" => "America/Denver",
            "value" => "America/Denver"
        ],
        [
            "label" => "America/Detroit",
            "value" => "America/Detroit"
        ],
        [
            "label" => "America/Dominica",
            "value" => "America/Dominica"
        ],
        [
            "label" => "America/Edmonton",
            "value" => "America/Edmonton"
        ],
        [
            "label" => "America/Eirunepe",
            "value" => "America/Eirunepe"
        ],
        [
            "label" => "America/El_Salvador",
            "value" => "America/El_Salvador"
        ],
        [
            "label" => "America/Ensenada",
            "value" => "America/Ensenada"
        ],
        [
            "label" => "America/Fort_Nelson",
            "value" => "America/Fort_Nelson"
        ],
        [
            "label" => "America/Fort_Wayne",
            "value" => "America/Fort_Wayne"
        ],
        [
            "label" => "America/Fortaleza",
            "value" => "America/Fortaleza"
        ],
        [
            "label" => "America/Glace_Bay",
            "value" => "America/Glace_Bay"
        ],
        [
            "label" => "America/Godthab",
            "value" => "America/Godthab"
        ],
        [
            "label" => "America/Goose_Bay",
            "value" => "America/Goose_Bay"
        ],
        [
            "label" => "America/Grand_Turk",
            "value" => "America/Grand_Turk"
        ],
        [
            "label" => "America/Grenada",
            "value" => "America/Grenada"
        ],
        [
            "label" => "America/Guadeloupe",
            "value" => "America/Guadeloupe"
        ],
        [
            "label" => "America/Guatemala",
            "value" => "America/Guatemala"
        ],
        [
            "label" => "America/Guayaquil",
            "value" => "America/Guayaquil"
        ],
        [
            "label" => "America/Guyana",
            "value" => "America/Guyana"
        ],
        [
            "label" => "America/Halifax",
            "value" => "America/Halifax"
        ],
        [
            "label" => "America/Havana",
            "value" => "America/Havana"
        ],
        [
            "label" => "America/Hermosillo",
            "value" => "America/Hermosillo"
        ],
        [
            "label" => "America/Indiana/Indianapolis",
            "value" => "America/Indiana/Indianapolis"
        ],
        [
            "label" => "America/Indiana/Knox",
            "value" => "America/Indiana/Knox"
        ],
        [
            "label" => "America/Indiana/Marengo",
            "value" => "America/Indiana/Marengo"
        ],
        [
            "label" => "America/Indiana/Petersburg",
            "value" => "America/Indiana/Petersburg"
        ],
        [
            "label" => "America/Indiana/Tell_City",
            "value" => "America/Indiana/Tell_City"
        ],
        [
            "label" => "America/Indiana/Vevay",
            "value" => "America/Indiana/Vevay"
        ],
        [
            "label" => "America/Indiana/Vincennes",
            "value" => "America/Indiana/Vincennes"
        ],
        [
            "label" => "America/Indiana/Winamac",
            "value" => "America/Indiana/Winamac"
        ],
        [
            "label" => "America/Indianapolis",
            "value" => "America/Indianapolis"
        ],
        [
            "label" => "America/Inuvik",
            "value" => "America/Inuvik"
        ],
        [
            "label" => "America/Iqaluit",
            "value" => "America/Iqaluit"
        ],
        [
            "label" => "America/Jamaica",
            "value" => "America/Jamaica"
        ],
        [
            "label" => "America/Jujuy",
            "value" => "America/Jujuy"
        ],
        [
            "label" => "America/Juneau",
            "value" => "America/Juneau"
        ],
        [
            "label" => "America/Kentucky/Louisville",
            "value" => "America/Kentucky/Louisville"
        ],
        [
            "label" => "America/Kentucky/Monticello",
            "value" => "America/Kentucky/Monticello"
        ],
        [
            "label" => "America/Knox_IN",
            "value" => "America/Knox_IN"
        ],
        [
            "label" => "America/Kralendijk",
            "value" => "America/Kralendijk"
        ],
        [
            "label" => "America/La_Paz",
            "value" => "America/La_Paz"
        ],
        [
            "label" => "America/Lima",
            "value" => "America/Lima"
        ],
        [
            "label" => "America/Los_Angeles",
            "value" => "America/Los_Angeles"
        ],
        [
            "label" => "America/Louisville",
            "value" => "America/Louisville"
        ],
        [
            "label" => "America/Lower_Princes",
            "value" => "America/Lower_Princes"
        ],
        [
            "label" => "America/Maceio",
            "value" => "America/Maceio"
        ],
        [
            "label" => "America/Managua",
            "value" => "America/Managua"
        ],
        [
            "label" => "America/Manaus",
            "value" => "America/Manaus"
        ],
        [
            "label" => "America/Marigot",
            "value" => "America/Marigot"
        ],
        [
            "label" => "America/Martinique",
            "value" => "America/Martinique"
        ],
        [
            "label" => "America/Matamoros",
            "value" => "America/Matamoros"
        ],
        [
            "label" => "America/Mazatlan",
            "value" => "America/Mazatlan"
        ],
        [
            "label" => "America/Mendoza",
            "value" => "America/Mendoza"
        ],
        [
            "label" => "America/Menominee",
            "value" => "America/Menominee"
        ],
        [
            "label" => "America/Merida",
            "value" => "America/Merida"
        ],
        [
            "label" => "America/Metlakatla",
            "value" => "America/Metlakatla"
        ],
        [
            "label" => "America/Mexico_City",
            "value" => "America/Mexico_City"
        ],
        [
            "label" => "America/Miquelon",
            "value" => "America/Miquelon"
        ],
        [
            "label" => "America/Moncton",
            "value" => "America/Moncton"
        ],
        [
            "label" => "America/Monterrey",
            "value" => "America/Monterrey"
        ],
        [
            "label" => "America/Montevideo",
            "value" => "America/Montevideo"
        ],
        [
            "label" => "America/Montreal",
            "value" => "America/Montreal"
        ],
        [
            "label" => "America/Montserrat",
            "value" => "America/Montserrat"
        ],
        [
            "label" => "America/Nassau",
            "value" => "America/Nassau"
        ],
        [
            "label" => "America/New_York",
            "value" => "America/New_York"
        ],
        [
            "label" => "America/Nipigon",
            "value" => "America/Nipigon"
        ],
        [
            "label" => "America/Nome",
            "value" => "America/Nome"
        ],
        [
            "label" => "America/Noronha",
            "value" => "America/Noronha"
        ],
        [
            "label" => "America/North_Dakota/Beulah",
            "value" => "America/North_Dakota/Beulah"
        ],
        [
            "label" => "America/North_Dakota/Center",
            "value" => "America/North_Dakota/Center"
        ],
        [
            "label" => "America/North_Dakota/New_Salem",
            "value" => "America/North_Dakota/New_Salem"
        ],
        [
            "label" => "America/Nuuk",
            "value" => "America/Nuuk"
        ],
        [
            "label" => "America/Ojinaga",
            "value" => "America/Ojinaga"
        ],
        [
            "label" => "America/Panama",
            "value" => "America/Panama"
        ],
        [
            "label" => "America/Pangnirtung",
            "value" => "America/Pangnirtung"
        ],
        [
            "label" => "America/Paramaribo",
            "value" => "America/Paramaribo"
        ],
        [
            "label" => "America/Phoenix",
            "value" => "America/Phoenix"
        ],
        [
            "label" => "America/Port-au-Prince",
            "value" => "America/Port-au-Prince"
        ],
        [
            "label" => "America/Port_of_Spain",
            "value" => "America/Port_of_Spain"
        ],
        [
            "label" => "America/Porto_Acre",
            "value" => "America/Porto_Acre"
        ],
        [
            "label" => "America/Porto_Velho",
            "value" => "America/Porto_Velho"
        ],
        [
            "label" => "America/Puerto_Rico",
            "value" => "America/Puerto_Rico"
        ],
        [
            "label" => "America/Punta_Arenas",
            "value" => "America/Punta_Arenas"
        ],
        [
            "label" => "America/Rainy_River",
            "value" => "America/Rainy_River"
        ],
        [
            "label" => "America/Rankin_Inlet",
            "value" => "America/Rankin_Inlet"
        ],
        [
            "label" => "America/Recife",
            "value" => "America/Recife"
        ],
        [
            "label" => "America/Regina",
            "value" => "America/Regina"
        ],
        [
            "label" => "America/Resolute",
            "value" => "America/Resolute"
        ],
        [
            "label" => "America/Rio_Branco",
            "value" => "America/Rio_Branco"
        ],
        [
            "label" => "America/Rosario",
            "value" => "America/Rosario"
        ],
        [
            "label" => "America/Santa_Isabel",
            "value" => "America/Santa_Isabel"
        ],
        [
            "label" => "America/Santarem",
            "value" => "America/Santarem"
        ],
        [
            "label" => "America/Santiago",
            "value" => "America/Santiago"
        ],
        [
            "label" => "America/Santo_Domingo",
            "value" => "America/Santo_Domingo"
        ],
        [
            "label" => "America/Sao_Paulo",
            "value" => "America/Sao_Paulo"
        ],
        [
            "label" => "America/Scoresbysund",
            "value" => "America/Scoresbysund"
        ],
        [
            "label" => "America/Shiprock",
            "value" => "America/Shiprock"
        ],
        [
            "label" => "America/Sitka",
            "value" => "America/Sitka"
        ],
        [
            "label" => "America/St_Barthelemy",
            "value" => "America/St_Barthelemy"
        ],
        [
            "label" => "America/St_Johns",
            "value" => "America/St_Johns"
        ],
        [
            "label" => "America/St_Kitts",
            "value" => "America/St_Kitts"
        ],
        [
            "label" => "America/St_Lucia",
            "value" => "America/St_Lucia"
        ],
        [
            "label" => "America/St_Thomas",
            "value" => "America/St_Thomas"
        ],
        [
            "label" => "America/St_Vincent",
            "value" => "America/St_Vincent"
        ],
        [
            "label" => "America/Swift_Current",
            "value" => "America/Swift_Current"
        ],
        [
            "label" => "America/Tegucigalpa",
            "value" => "America/Tegucigalpa"
        ],
        [
            "label" => "America/Thule",
            "value" => "America/Thule"
        ],
        [
            "label" => "America/Thunder_Bay",
            "value" => "America/Thunder_Bay"
        ],
        [
            "label" => "America/Tijuana",
            "value" => "America/Tijuana"
        ],
        [
            "label" => "America/Toronto",
            "value" => "America/Toronto"
        ],
        [
            "label" => "America/Tortola",
            "value" => "America/Tortola"
        ],
        [
            "label" => "America/Vancouver",
            "value" => "America/Vancouver"
        ],
        [
            "label" => "America/Virgin",
            "value" => "America/Virgin"
        ],
        [
            "label" => "America/Whitehorse",
            "value" => "America/Whitehorse"
        ],
        [
            "label" => "America/Winnipeg",
            "value" => "America/Winnipeg"
        ],
        [
            "label" => "America/Yakutat",
            "value" => "America/Yakutat"
        ],
        [
            "label" => "America/Yellowknife",
            "value" => "America/Yellowknife"
        ],
        [
            "label" => "Antarctica/Casey",
            "value" => "Antarctica/Casey"
        ],
        [
            "label" => "Antarctica/Davis",
            "value" => "Antarctica/Davis"
        ],
        [
            "label" => "Antarctica/DumontDUrville",
            "value" => "Antarctica/DumontDUrville"
        ],
        [
            "label" => "Antarctica/Macquarie",
            "value" => "Antarctica/Macquarie"
        ],
        [
            "label" => "Antarctica/Mawson",
            "value" => "Antarctica/Mawson"
        ],
        [
            "label" => "Antarctica/McMurdo",
            "value" => "Antarctica/McMurdo"
        ],
        [
            "label" => "Antarctica/Palmer",
            "value" => "Antarctica/Palmer"
        ],
        [
            "label" => "Antarctica/Rothera",
            "value" => "Antarctica/Rothera"
        ],
        [
            "label" => "Antarctica/South_Pole",
            "value" => "Antarctica/South_Pole"
        ],
        [
            "label" => "Antarctica/Syowa",
            "value" => "Antarctica/Syowa"
        ],
        [
            "label" => "Antarctica/Troll",
            "value" => "Antarctica/Troll"
        ],
        [
            "label" => "Antarctica/Vostok",
            "value" => "Antarctica/Vostok"
        ],
        [
            "label" => "Arctic/Longyearbyen",
            "value" => "Arctic/Longyearbyen"
        ],
        [
            "label" => "Asia/Aden",
            "value" => "Asia/Aden"
        ],
        [
            "label" => "Asia/Almaty",
            "value" => "Asia/Almaty"
        ],
        [
            "label" => "Asia/Amman",
            "value" => "Asia/Amman"
        ],
        [
            "label" => "Asia/Anadyr",
            "value" => "Asia/Anadyr"
        ],
        [
            "label" => "Asia/Aqtau",
            "value" => "Asia/Aqtau"
        ],
        [
            "label" => "Asia/Aqtobe",
            "value" => "Asia/Aqtobe"
        ],
        [
            "label" => "Asia/Ashgabat",
            "value" => "Asia/Ashgabat"
        ],
        [
            "label" => "Asia/Ashkhabad",
            "value" => "Asia/Ashkhabad"
        ],
        [
            "label" => "Asia/Atyrau",
            "value" => "Asia/Atyrau"
        ],
        [
            "label" => "Asia/Baghdad",
            "value" => "Asia/Baghdad"
        ],
        [
            "label" => "Asia/Bahrain",
            "value" => "Asia/Bahrain"
        ],
        [
            "label" => "Asia/Baku",
            "value" => "Asia/Baku"
        ],
        [
            "label" => "Asia/Bangkok",
            "value" => "Asia/Bangkok"
        ],
        [
            "label" => "Asia/Barnaul",
            "value" => "Asia/Barnaul"
        ],
        [
            "label" => "Asia/Beirut",
            "value" => "Asia/Beirut"
        ],
        [
            "label" => "Asia/Bishkek",
            "value" => "Asia/Bishkek"
        ],
        [
            "label" => "Asia/Brunei",
            "value" => "Asia/Brunei"
        ],
        [
            "label" => "Asia/Calcutta",
            "value" => "Asia/Calcutta"
        ],
        [
            "label" => "Asia/Chita",
            "value" => "Asia/Chita"
        ],
        [
            "label" => "Asia/Choibalsan",
            "value" => "Asia/Choibalsan"
        ],
        [
            "label" => "Asia/Chongqing",
            "value" => "Asia/Chongqing"
        ],
        [
            "label" => "Asia/Chungking",
            "value" => "Asia/Chungking"
        ],
        [
            "label" => "Asia/Colombo",
            "value" => "Asia/Colombo"
        ],
        [
            "label" => "Asia/Dacca",
            "value" => "Asia/Dacca"
        ],
        [
            "label" => "Asia/Damascus",
            "value" => "Asia/Damascus"
        ],
        [
            "label" => "Asia/Dhaka",
            "value" => "Asia/Dhaka"
        ],
        [
            "label" => "Asia/Dili",
            "value" => "Asia/Dili"
        ],
        [
            "label" => "Asia/Dubai",
            "value" => "Asia/Dubai"
        ],
        [
            "label" => "Asia/Dushanbe",
            "value" => "Asia/Dushanbe"
        ],
        [
            "label" => "Asia/Famagusta",
            "value" => "Asia/Famagusta"
        ],
        [
            "label" => "Asia/Gaza",
            "value" => "Asia/Gaza"
        ],
        [
            "label" => "Asia/Harbin",
            "value" => "Asia/Harbin"
        ],
        [
            "label" => "Asia/Hebron",
            "value" => "Asia/Hebron"
        ],
        [
            "label" => "Asia/Ho_Chi_Minh",
            "value" => "Asia/Ho_Chi_Minh"
        ],
        [
            "label" => "Asia/Hong_Kong",
            "value" => "Asia/Hong_Kong"
        ],
        [
            "label" => "Asia/Hovd",
            "value" => "Asia/Hovd"
        ],
        [
            "label" => "Asia/Irkutsk",
            "value" => "Asia/Irkutsk"
        ],
        [
            "label" => "Asia/Istanbul",
            "value" => "Asia/Istanbul"
        ],
        [
            "label" => "Asia/Jakarta",
            "value" => "Asia/Jakarta"
        ],
        [
            "label" => "Asia/Jayapura",
            "value" => "Asia/Jayapura"
        ],
        [
            "label" => "Asia/Jerusalem",
            "value" => "Asia/Jerusalem"
        ],
        [
            "label" => "Asia/Kabul",
            "value" => "Asia/Kabul"
        ],
        [
            "label" => "Asia/Kamchatka",
            "value" => "Asia/Kamchatka"
        ],
        [
            "label" => "Asia/Karachi",
            "value" => "Asia/Karachi"
        ],
        [
            "label" => "Asia/Kashgar",
            "value" => "Asia/Kashgar"
        ],
        [
            "label" => "Asia/Kathmandu",
            "value" => "Asia/Kathmandu"
        ],
        [
            "label" => "Asia/Katmandu",
            "value" => "Asia/Katmandu"
        ],
        [
            "label" => "Asia/Khandyga",
            "value" => "Asia/Khandyga"
        ],
        [
            "label" => "Asia/Kolkata",
            "value" => "Asia/Kolkata"
        ],
        [
            "label" => "Asia/Krasnoyarsk",
            "value" => "Asia/Krasnoyarsk"
        ],
        [
            "label" => "Asia/Kuala_Lumpur",
            "value" => "Asia/Kuala_Lumpur"
        ],
        [
            "label" => "Asia/Kuching",
            "value" => "Asia/Kuching"
        ],
        [
            "label" => "Asia/Kuwait",
            "value" => "Asia/Kuwait"
        ],
        [
            "label" => "Asia/Macao",
            "value" => "Asia/Macao"
        ],
        [
            "label" => "Asia/Macau",
            "value" => "Asia/Macau"
        ],
        [
            "label" => "Asia/Magadan",
            "value" => "Asia/Magadan"
        ],
        [
            "label" => "Asia/Makassar",
            "value" => "Asia/Makassar"
        ],
        [
            "label" => "Asia/Manila",
            "value" => "Asia/Manila"
        ],
        [
            "label" => "Asia/Muscat",
            "value" => "Asia/Muscat"
        ],
        [
            "label" => "Asia/Nicosia",
            "value" => "Asia/Nicosia"
        ],
        [
            "label" => "Asia/Novokuznetsk",
            "value" => "Asia/Novokuznetsk"
        ],
        [
            "label" => "Asia/Novosibirsk",
            "value" => "Asia/Novosibirsk"
        ],
        [
            "label" => "Asia/Omsk",
            "value" => "Asia/Omsk"
        ],
        [
            "label" => "Asia/Oral",
            "value" => "Asia/Oral"
        ],
        [
            "label" => "Asia/Phnom_Penh",
            "value" => "Asia/Phnom_Penh"
        ],
        [
            "label" => "Asia/Pontianak",
            "value" => "Asia/Pontianak"
        ],
        [
            "label" => "Asia/Pyongyang",
            "value" => "Asia/Pyongyang"
        ],
        [
            "label" => "Asia/Qatar",
            "value" => "Asia/Qatar"
        ],
        [
            "label" => "Asia/Qostanay",
            "value" => "Asia/Qostanay"
        ],
        [
            "label" => "Asia/Qyzylorda",
            "value" => "Asia/Qyzylorda"
        ],
        [
            "label" => "Asia/Rangoon",
            "value" => "Asia/Rangoon"
        ],
        [
            "label" => "Asia/Riyadh",
            "value" => "Asia/Riyadh"
        ],
        [
            "label" => "Asia/Saigon",
            "value" => "Asia/Saigon"
        ],
        [
            "label" => "Asia/Sakhalin",
            "value" => "Asia/Sakhalin"
        ],
        [
            "label" => "Asia/Samarkand",
            "value" => "Asia/Samarkand"
        ],
        [
            "label" => "Asia/Seoul",
            "value" => "Asia/Seoul"
        ],
        [
            "label" => "Asia/Shanghai",
            "value" => "Asia/Shanghai"
        ],
        [
            "label" => "Asia/Singapore",
            "value" => "Asia/Singapore"
        ],
        [
            "label" => "Asia/Srednekolymsk",
            "value" => "Asia/Srednekolymsk"
        ],
        [
            "label" => "Asia/Taipei",
            "value" => "Asia/Taipei"
        ],
        [
            "label" => "Asia/Tashkent",
            "value" => "Asia/Tashkent"
        ],
        [
            "label" => "Asia/Tbilisi",
            "value" => "Asia/Tbilisi"
        ],
        [
            "label" => "Asia/Tehran",
            "value" => "Asia/Tehran"
        ],
        [
            "label" => "Asia/Tel_Aviv",
            "value" => "Asia/Tel_Aviv"
        ],
        [
            "label" => "Asia/Thimbu",
            "value" => "Asia/Thimbu"
        ],
        [
            "label" => "Asia/Thimphu",
            "value" => "Asia/Thimphu"
        ],
        [
            "label" => "Asia/Tokyo",
            "value" => "Asia/Tokyo"
        ],
        [
            "label" => "Asia/Tomsk",
            "value" => "Asia/Tomsk"
        ],
        [
            "label" => "Asia/Ujung_Pandang",
            "value" => "Asia/Ujung_Pandang"
        ],
        [
            "label" => "Asia/Ulaanbaatar",
            "value" => "Asia/Ulaanbaatar"
        ],
        [
            "label" => "Asia/Ulan_Bator",
            "value" => "Asia/Ulan_Bator"
        ],
        [
            "label" => "Asia/Urumqi",
            "value" => "Asia/Urumqi"
        ],
        [
            "label" => "Asia/Ust-Nera",
            "value" => "Asia/Ust-Nera"
        ],
        [
            "label" => "Asia/Vientiane",
            "value" => "Asia/Vientiane"
        ],
        [
            "label" => "Asia/Vladivostok",
            "value" => "Asia/Vladivostok"
        ],
        [
            "label" => "Asia/Yakutsk",
            "value" => "Asia/Yakutsk"
        ],
        [
            "label" => "Asia/Yangon",
            "value" => "Asia/Yangon"
        ],
        [
            "label" => "Asia/Yekaterinburg",
            "value" => "Asia/Yekaterinburg"
        ],
        [
            "label" => "Asia/Yerevan",
            "value" => "Asia/Yerevan"
        ],
        [
            "label" => "Atlantic/Azores",
            "value" => "Atlantic/Azores"
        ],
        [
            "label" => "Atlantic/Bermuda",
            "value" => "Atlantic/Bermuda"
        ],
        [
            "label" => "Atlantic/Canary",
            "value" => "Atlantic/Canary"
        ],
        [
            "label" => "Atlantic/Cape_Verde",
            "value" => "Atlantic/Cape_Verde"
        ],
        [
            "label" => "Atlantic/Faeroe",
            "value" => "Atlantic/Faeroe"
        ],
        [
            "label" => "Atlantic/Faroe",
            "value" => "Atlantic/Faroe"
        ],
        [
            "label" => "Atlantic/Jan_Mayen",
            "value" => "Atlantic/Jan_Mayen"
        ],
        [
            "label" => "Atlantic/Madeira",
            "value" => "Atlantic/Madeira"
        ],
        [
            "label" => "Atlantic/Reykjavik",
            "value" => "Atlantic/Reykjavik"
        ],
        [
            "label" => "Atlantic/South_Georgia",
            "value" => "Atlantic/South_Georgia"
        ],
        [
            "label" => "Atlantic/St_Helena",
            "value" => "Atlantic/St_Helena"
        ],
        [
            "label" => "Atlantic/Stanley",
            "value" => "Atlantic/Stanley"
        ],
        [
            "label" => "Australia/ACT",
            "value" => "Australia/ACT"
        ],
        [
            "label" => "Australia/Adelaide",
            "value" => "Australia/Adelaide"
        ],
        [
            "label" => "Australia/Brisbane",
            "value" => "Australia/Brisbane"
        ],
        [
            "label" => "Australia/Broken_Hill",
            "value" => "Australia/Broken_Hill"
        ],
        [
            "label" => "Australia/Canberra",
            "value" => "Australia/Canberra"
        ],
        [
            "label" => "Australia/Currie",
            "value" => "Australia/Currie"
        ],
        [
            "label" => "Australia/Darwin",
            "value" => "Australia/Darwin"
        ],
        [
            "label" => "Australia/Eucla",
            "value" => "Australia/Eucla"
        ],
        [
            "label" => "Australia/Hobart",
            "value" => "Australia/Hobart"
        ],
        [
            "label" => "Australia/LHI",
            "value" => "Australia/LHI"
        ],
        [
            "label" => "Australia/Lindeman",
            "value" => "Australia/Lindeman"
        ],
        [
            "label" => "Australia/Lord_Howe",
            "value" => "Australia/Lord_Howe"
        ],
        [
            "label" => "Australia/Melbourne",
            "value" => "Australia/Melbourne"
        ],
        [
            "label" => "Australia/NSW",
            "value" => "Australia/NSW"
        ],
        [
            "label" => "Australia/North",
            "value" => "Australia/North"
        ],
        [
            "label" => "Australia/Perth",
            "value" => "Australia/Perth"
        ],
        [
            "label" => "Australia/Queensland",
            "value" => "Australia/Queensland"
        ],
        [
            "label" => "Australia/South",
            "value" => "Australia/South"
        ],
        [
            "label" => "Australia/Sydney",
            "value" => "Australia/Sydney"
        ],
        [
            "label" => "Australia/Tasmania",
            "value" => "Australia/Tasmania"
        ],
        [
            "label" => "Australia/Victoria",
            "value" => "Australia/Victoria"
        ],
        [
            "label" => "Australia/West",
            "value" => "Australia/West"
        ],
        [
            "label" => "Australia/Yancowinna",
            "value" => "Australia/Yancowinna"
        ],
        [
            "label" => "Brazil/Acre",
            "value" => "Brazil/Acre"
        ],
        [
            "label" => "Brazil/DeNoronha",
            "value" => "Brazil/DeNoronha"
        ],
        [
            "label" => "Brazil/East",
            "value" => "Brazil/East"
        ],
        [
            "label" => "Brazil/West",
            "value" => "Brazil/West"
        ],
        [
            "label" => "CET",
            "value" => "CET"
        ],
        [
            "label" => "CST6CDT",
            "value" => "CST6CDT"
        ],
        [
            "label" => "Canada/Atlantic",
            "value" => "Canada/Atlantic"
        ],
        [
            "label" => "Canada/Central",
            "value" => "Canada/Central"
        ],
        [
            "label" => "Canada/Eastern",
            "value" => "Canada/Eastern"
        ],
        [
            "label" => "Canada/Mountain",
            "value" => "Canada/Mountain"
        ],
        [
            "label" => "Canada/Newfoundland",
            "value" => "Canada/Newfoundland"
        ],
        [
            "label" => "Canada/Pacific",
            "value" => "Canada/Pacific"
        ],
        [
            "label" => "Canada/Saskatchewan",
            "value" => "Canada/Saskatchewan"
        ],
        [
            "label" => "Canada/Yukon",
            "value" => "Canada/Yukon"
        ],
        [
            "label" => "Chile/Continental",
            "value" => "Chile/Continental"
        ],
        [
            "label" => "Chile/EasterIsland",
            "value" => "Chile/EasterIsland"
        ],
        [
            "label" => "Cuba",
            "value" => "Cuba"
        ],
        [
            "label" => "EET",
            "value" => "EET"
        ],
        [
            "label" => "EST",
            "value" => "EST"
        ],
        [
            "label" => "EST5EDT",
            "value" => "EST5EDT"
        ],
        [
            "label" => "Egypt",
            "value" => "Egypt"
        ],
        [
            "label" => "Eire",
            "value" => "Eire"
        ],
        [
            "label" => "Etc/GMT",
            "value" => "Etc/GMT"
        ],
        [
            "label" => "Etc/GMT+0",
            "value" => "Etc/GMT+0"
        ],
        [
            "label" => "Etc/GMT+1",
            "value" => "Etc/GMT+1"
        ],
        [
            "label" => "Etc/GMT+10",
            "value" => "Etc/GMT+10"
        ],
        [
            "label" => "Etc/GMT+11",
            "value" => "Etc/GMT+11"
        ],
        [
            "label" => "Etc/GMT+12",
            "value" => "Etc/GMT+12"
        ],
        [
            "label" => "Etc/GMT+2",
            "value" => "Etc/GMT+2"
        ],
        [
            "label" => "Etc/GMT+3",
            "value" => "Etc/GMT+3"
        ],
        [
            "label" => "Etc/GMT+4",
            "value" => "Etc/GMT+4"
        ],
        [
            "label" => "Etc/GMT+5",
            "value" => "Etc/GMT+5"
        ],
        [
            "label" => "Etc/GMT+6",
            "value" => "Etc/GMT+6"
        ],
        [
            "label" => "Etc/GMT+7",
            "value" => "Etc/GMT+7"
        ],
        [
            "label" => "Etc/GMT+8",
            "value" => "Etc/GMT+8"
        ],
        [
            "label" => "Etc/GMT+9",
            "value" => "Etc/GMT+9"
        ],
        [
            "label" => "Etc/GMT-0",
            "value" => "Etc/GMT-0"
        ],
        [
            "label" => "Etc/GMT-1",
            "value" => "Etc/GMT-1"
        ],
        [
            "label" => "Etc/GMT-10",
            "value" => "Etc/GMT-10"
        ],
        [
            "label" => "Etc/GMT-11",
            "value" => "Etc/GMT-11"
        ],
        [
            "label" => "Etc/GMT-12",
            "value" => "Etc/GMT-12"
        ],
        [
            "label" => "Etc/GMT-13",
            "value" => "Etc/GMT-13"
        ],
        [
            "label" => "Etc/GMT-14",
            "value" => "Etc/GMT-14"
        ],
        [
            "label" => "Etc/GMT-2",
            "value" => "Etc/GMT-2"
        ],
        [
            "label" => "Etc/GMT-3",
            "value" => "Etc/GMT-3"
        ],
        [
            "label" => "Etc/GMT-4",
            "value" => "Etc/GMT-4"
        ],
        [
            "label" => "Etc/GMT-5",
            "value" => "Etc/GMT-5"
        ],
        [
            "label" => "Etc/GMT-6",
            "value" => "Etc/GMT-6"
        ],
        [
            "label" => "Etc/GMT-7",
            "value" => "Etc/GMT-7"
        ],
        [
            "label" => "Etc/GMT-8",
            "value" => "Etc/GMT-8"
        ],
        [
            "label" => "Etc/GMT-9",
            "value" => "Etc/GMT-9"
        ],
        [
            "label" => "Etc/GMT0",
            "value" => "Etc/GMT0"
        ],
        [
            "label" => "Etc/Greenwich",
            "value" => "Etc/Greenwich"
        ],
        [
            "label" => "Etc/UCT",
            "value" => "Etc/UCT"
        ],
        [
            "label" => "Etc/UTC",
            "value" => "Etc/UTC"
        ],
        [
            "label" => "Etc/Universal",
            "value" => "Etc/Universal"
        ],
        [
            "label" => "Etc/Zulu",
            "value" => "Etc/Zulu"
        ],
        [
            "label" => "Europe/Amsterdam",
            "value" => "Europe/Amsterdam"
        ],
        [
            "label" => "Europe/Andorra",
            "value" => "Europe/Andorra"
        ],
        [
            "label" => "Europe/Astrakhan",
            "value" => "Europe/Astrakhan"
        ],
        [
            "label" => "Europe/Athens",
            "value" => "Europe/Athens"
        ],
        [
            "label" => "Europe/Belfast",
            "value" => "Europe/Belfast"
        ],
        [
            "label" => "Europe/Belgrade",
            "value" => "Europe/Belgrade"
        ],
        [
            "label" => "Europe/Berlin",
            "value" => "Europe/Berlin"
        ],
        [
            "label" => "Europe/Bratislava",
            "value" => "Europe/Bratislava"
        ],
        [
            "label" => "Europe/Brussels",
            "value" => "Europe/Brussels"
        ],
        [
            "label" => "Europe/Bucharest",
            "value" => "Europe/Bucharest"
        ],
        [
            "label" => "Europe/Budapest",
            "value" => "Europe/Budapest"
        ],
        [
            "label" => "Europe/Busingen",
            "value" => "Europe/Busingen"
        ],
        [
            "label" => "Europe/Chisinau",
            "value" => "Europe/Chisinau"
        ],
        [
            "label" => "Europe/Copenhagen",
            "value" => "Europe/Copenhagen"
        ],
        [
            "label" => "Europe/Dublin",
            "value" => "Europe/Dublin"
        ],
        [
            "label" => "Europe/Gibraltar",
            "value" => "Europe/Gibraltar"
        ],
        [
            "label" => "Europe/Guernsey",
            "value" => "Europe/Guernsey"
        ],
        [
            "label" => "Europe/Helsinki",
            "value" => "Europe/Helsinki"
        ],
        [
            "label" => "Europe/Isle_of_Man",
            "value" => "Europe/Isle_of_Man"
        ],
        [
            "label" => "Europe/Istanbul",
            "value" => "Europe/Istanbul"
        ],
        [
            "label" => "Europe/Jersey",
            "value" => "Europe/Jersey"
        ],
        [
            "label" => "Europe/Kaliningrad",
            "value" => "Europe/Kaliningrad"
        ],
        [
            "label" => "Europe/Kiev",
            "value" => "Europe/Kiev"
        ],
        [
            "label" => "Europe/Kirov",
            "value" => "Europe/Kirov"
        ],
        [
            "label" => "Europe/Lisbon",
            "value" => "Europe/Lisbon"
        ],
        [
            "label" => "Europe/Ljubljana",
            "value" => "Europe/Ljubljana"
        ],
        [
            "label" => "Europe/London",
            "value" => "Europe/London"
        ],
        [
            "label" => "Europe/Luxembourg",
            "value" => "Europe/Luxembourg"
        ],
        [
            "label" => "Europe/Madrid",
            "value" => "Europe/Madrid"
        ],
        [
            "label" => "Europe/Malta",
            "value" => "Europe/Malta"
        ],
        [
            "label" => "Europe/Mariehamn",
            "value" => "Europe/Mariehamn"
        ],
        [
            "label" => "Europe/Minsk",
            "value" => "Europe/Minsk"
        ],
        [
            "label" => "Europe/Monaco",
            "value" => "Europe/Monaco"
        ],
        [
            "label" => "Europe/Moscow",
            "value" => "Europe/Moscow"
        ],
        [
            "label" => "Europe/Nicosia",
            "value" => "Europe/Nicosia"
        ],
        [
            "label" => "Europe/Oslo",
            "value" => "Europe/Oslo"
        ],
        [
            "label" => "Europe/Paris",
            "value" => "Europe/Paris"
        ],
        [
            "label" => "Europe/Podgorica",
            "value" => "Europe/Podgorica"
        ],
        [
            "label" => "Europe/Prague",
            "value" => "Europe/Prague"
        ],
        [
            "label" => "Europe/Riga",
            "value" => "Europe/Riga"
        ],
        [
            "label" => "Europe/Rome",
            "value" => "Europe/Rome"
        ],
        [
            "label" => "Europe/Samara",
            "value" => "Europe/Samara"
        ],
        [
            "label" => "Europe/San_Marino",
            "value" => "Europe/San_Marino"
        ],
        [
            "label" => "Europe/Sarajevo",
            "value" => "Europe/Sarajevo"
        ],
        [
            "label" => "Europe/Saratov",
            "value" => "Europe/Saratov"
        ],
        [
            "label" => "Europe/Simferopol",
            "value" => "Europe/Simferopol"
        ],
        [
            "label" => "Europe/Skopje",
            "value" => "Europe/Skopje"
        ],
        [
            "label" => "Europe/Sofia",
            "value" => "Europe/Sofia"
        ],
        [
            "label" => "Europe/Stockholm",
            "value" => "Europe/Stockholm"
        ],
        [
            "label" => "Europe/Tallinn",
            "value" => "Europe/Tallinn"
        ],
        [
            "label" => "Europe/Tirane",
            "value" => "Europe/Tirane"
        ],
        [
            "label" => "Europe/Tiraspol",
            "value" => "Europe/Tiraspol"
        ],
        [
            "label" => "Europe/Ulyanovsk",
            "value" => "Europe/Ulyanovsk"
        ],
        [
            "label" => "Europe/Uzhgorod",
            "value" => "Europe/Uzhgorod"
        ],
        [
            "label" => "Europe/Vaduz",
            "value" => "Europe/Vaduz"
        ],
        [
            "label" => "Europe/Vatican",
            "value" => "Europe/Vatican"
        ],
        [
            "label" => "Europe/Vienna",
            "value" => "Europe/Vienna"
        ],
        [
            "label" => "Europe/Vilnius",
            "value" => "Europe/Vilnius"
        ],
        [
            "label" => "Europe/Volgograd",
            "value" => "Europe/Volgograd"
        ],
        [
            "label" => "Europe/Warsaw",
            "value" => "Europe/Warsaw"
        ],
        [
            "label" => "Europe/Zagreb",
            "value" => "Europe/Zagreb"
        ],
        [
            "label" => "Europe/Zaporozhye",
            "value" => "Europe/Zaporozhye"
        ],
        [
            "label" => "Europe/Zurich",
            "value" => "Europe/Zurich"
        ],
        [
            "label" => "GB",
            "value" => "GB"
        ],
        [
            "label" => "GB-Eire",
            "value" => "GB-Eire"
        ],
        [
            "label" => "GMT",
            "value" => "GMT"
        ],
        [
            "label" => "GMT+0",
            "value" => "GMT+0"
        ],
        [
            "label" => "GMT-0",
            "value" => "GMT-0"
        ],
        [
            "label" => "GMT0",
            "value" => "GMT0"
        ],
        [
            "label" => "Greenwich",
            "value" => "Greenwich"
        ],
        [
            "label" => "HST",
            "value" => "HST"
        ],
        [
            "label" => "Hongkong",
            "value" => "Hongkong"
        ],
        [
            "label" => "Iceland",
            "value" => "Iceland"
        ],
        [
            "label" => "Indian/Antananarivo",
            "value" => "Indian/Antananarivo"
        ],
        [
            "label" => "Indian/Chagos",
            "value" => "Indian/Chagos"
        ],
        [
            "label" => "Indian/Christmas",
            "value" => "Indian/Christmas"
        ],
        [
            "label" => "Indian/Cocos",
            "value" => "Indian/Cocos"
        ],
        [
            "label" => "Indian/Comoro",
            "value" => "Indian/Comoro"
        ],
        [
            "label" => "Indian/Kerguelen",
            "value" => "Indian/Kerguelen"
        ],
        [
            "label" => "Indian/Mahe",
            "value" => "Indian/Mahe"
        ],
        [
            "label" => "Indian/Maldives",
            "value" => "Indian/Maldives"
        ],
        [
            "label" => "Indian/Mauritius",
            "value" => "Indian/Mauritius"
        ],
        [
            "label" => "Indian/Mayotte",
            "value" => "Indian/Mayotte"
        ],
        [
            "label" => "Indian/Reunion",
            "value" => "Indian/Reunion"
        ],
        [
            "label" => "Iran",
            "value" => "Iran"
        ],
        [
            "label" => "Israel",
            "value" => "Israel"
        ],
        [
            "label" => "Jamaica",
            "value" => "Jamaica"
        ],
        [
            "label" => "Japan",
            "value" => "Japan"
        ],
        [
            "label" => "Kwajalein",
            "value" => "Kwajalein"
        ],
        [
            "label" => "Libya",
            "value" => "Libya"
        ],
        [
            "label" => "MET",
            "value" => "MET"
        ],
        [
            "label" => "MST",
            "value" => "MST"
        ],
        [
            "label" => "MST7MDT",
            "value" => "MST7MDT"
        ],
        [
            "label" => "Mexico/BajaNorte",
            "value" => "Mexico/BajaNorte"
        ],
        [
            "label" => "Mexico/BajaSur",
            "value" => "Mexico/BajaSur"
        ],
        [
            "label" => "Mexico/General",
            "value" => "Mexico/General"
        ],
        [
            "label" => "NZ",
            "value" => "NZ"
        ],
        [
            "label" => "NZ-CHAT",
            "value" => "NZ-CHAT"
        ],
        [
            "label" => "Navajo",
            "value" => "Navajo"
        ],
        [
            "label" => "PRC",
            "value" => "PRC"
        ],
        [
            "label" => "PST8PDT",
            "value" => "PST8PDT"
        ],
        [
            "label" => "Pacific/Apia",
            "value" => "Pacific/Apia"
        ],
        [
            "label" => "Pacific/Auckland",
            "value" => "Pacific/Auckland"
        ],
        [
            "label" => "Pacific/Bougainville",
            "value" => "Pacific/Bougainville"
        ],
        [
            "label" => "Pacific/Chatham",
            "value" => "Pacific/Chatham"
        ],
        [
            "label" => "Pacific/Chuuk",
            "value" => "Pacific/Chuuk"
        ],
        [
            "label" => "Pacific/Easter",
            "value" => "Pacific/Easter"
        ],
        [
            "label" => "Pacific/Efate",
            "value" => "Pacific/Efate"
        ],
        [
            "label" => "Pacific/Enderbury",
            "value" => "Pacific/Enderbury"
        ],
        [
            "label" => "Pacific/Fakaofo",
            "value" => "Pacific/Fakaofo"
        ],
        [
            "label" => "Pacific/Fiji",
            "value" => "Pacific/Fiji"
        ],
        [
            "label" => "Pacific/Funafuti",
            "value" => "Pacific/Funafuti"
        ],
        [
            "label" => "Pacific/Galapagos",
            "value" => "Pacific/Galapagos"
        ],
        [
            "label" => "Pacific/Gambier",
            "value" => "Pacific/Gambier"
        ],
        [
            "label" => "Pacific/Guadalcanal",
            "value" => "Pacific/Guadalcanal"
        ],
        [
            "label" => "Pacific/Guam",
            "value" => "Pacific/Guam"
        ],
        [
            "label" => "Pacific/Honolulu",
            "value" => "Pacific/Honolulu"
        ],
        [
            "label" => "Pacific/Johnston",
            "value" => "Pacific/Johnston"
        ],
        [
            "label" => "Pacific/Kanton",
            "value" => "Pacific/Kanton"
        ],
        [
            "label" => "Pacific/Kiritimati",
            "value" => "Pacific/Kiritimati"
        ],
        [
            "label" => "Pacific/Kosrae",
            "value" => "Pacific/Kosrae"
        ],
        [
            "label" => "Pacific/Kwajalein",
            "value" => "Pacific/Kwajalein"
        ],
        [
            "label" => "Pacific/Majuro",
            "value" => "Pacific/Majuro"
        ],
        [
            "label" => "Pacific/Marquesas",
            "value" => "Pacific/Marquesas"
        ],
        [
            "label" => "Pacific/Midway",
            "value" => "Pacific/Midway"
        ],
        [
            "label" => "Pacific/Nauru",
            "value" => "Pacific/Nauru"
        ],
        [
            "label" => "Pacific/Niue",
            "value" => "Pacific/Niue"
        ],
        [
            "label" => "Pacific/Norfolk",
            "value" => "Pacific/Norfolk"
        ],
        [
            "label" => "Pacific/Noumea",
            "value" => "Pacific/Noumea"
        ],
        [
            "label" => "Pacific/Pago_Pago",
            "value" => "Pacific/Pago_Pago"
        ],
        [
            "label" => "Pacific/Palau",
            "value" => "Pacific/Palau"
        ],
        [
            "label" => "Pacific/Pitcairn",
            "value" => "Pacific/Pitcairn"
        ],
        [
            "label" => "Pacific/Pohnpei",
            "value" => "Pacific/Pohnpei"
        ],
        [
            "label" => "Pacific/Ponape",
            "value" => "Pacific/Ponape"
        ],
        [
            "label" => "Pacific/Port_Moresby",
            "value" => "Pacific/Port_Moresby"
        ],
        [
            "label" => "Pacific/Rarotonga",
            "value" => "Pacific/Rarotonga"
        ],
        [
            "label" => "Pacific/Saipan",
            "value" => "Pacific/Saipan"
        ],
        [
            "label" => "Pacific/Samoa",
            "value" => "Pacific/Samoa"
        ],
        [
            "label" => "Pacific/Tahiti",
            "value" => "Pacific/Tahiti"
        ],
        [
            "label" => "Pacific/Tarawa",
            "value" => "Pacific/Tarawa"
        ],
        [
            "label" => "Pacific/Tongatapu",
            "value" => "Pacific/Tongatapu"
        ],
        [
            "label" => "Pacific/Truk",
            "value" => "Pacific/Truk"
        ],
        [
            "label" => "Pacific/Wake",
            "value" => "Pacific/Wake"
        ],
        [
            "label" => "Pacific/Wallis",
            "value" => "Pacific/Wallis"
        ],
        [
            "label" => "Pacific/Yap",
            "value" => "Pacific/Yap"
        ],
        [
            "label" => "Poland",
            "value" => "Poland"
        ],
        [
            "label" => "Portugal",
            "value" => "Portugal"
        ],
        [
            "label" => "ROC",
            "value" => "ROC"
        ],
        [
            "label" => "ROK",
            "value" => "ROK"
        ],
        [
            "label" => "Singapore",
            "value" => "Singapore"
        ],
        [
            "label" => "Turkey",
            "value" => "Turkey"
        ],
        [
            "label" => "UCT",
            "value" => "UCT"
        ],
        [
            "label" => "US/Alaska",
            "value" => "US/Alaska"
        ],
        [
            "label" => "US/Aleutian",
            "value" => "US/Aleutian"
        ],
        [
            "label" => "US/Arizona",
            "value" => "US/Arizona"
        ],
        [
            "label" => "US/Central",
            "value" => "US/Central"
        ],
        [
            "label" => "US/East-Indiana",
            "value" => "US/East-Indiana"
        ],
        [
            "label" => "US/Eastern",
            "value" => "US/Eastern"
        ],
        [
            "label" => "US/Hawaii",
            "value" => "US/Hawaii"
        ],
        [
            "label" => "US/Indiana-Starke",
            "value" => "US/Indiana-Starke"
        ],
        [
            "label" => "US/Michigan",
            "value" => "US/Michigan"
        ],
        [
            "label" => "US/Mountain",
            "value" => "US/Mountain"
        ],
        [
            "label" => "US/Pacific",
            "value" => "US/Pacific"
        ],
        [
            "label" => "US/Samoa",
            "value" => "US/Samoa"
        ],
        [
            "label" => "UTC",
            "value" => "UTC"
        ],
        [
            "label" => "Universal",
            "value" => "Universal"
        ],
        [
            "label" => "W-SU",
            "value" => "W-SU"
        ],
        [
            "label" => "WET",
            "value" => "WET"
        ],
        [
            "label" => "Zulu",
            "value" => "Zulu"
        ],
    );

    static $countriesList = array(
        [
            "label" => "Åland Islands",
            "value" => "AX"
        ],
        [
            "label" => "Algeria",
            "value" => "DZ"
        ],
        [
            "label" => "American Samoa",
            "value" => "AS"
        ],
        [
            "label" => "Andorra",
            "value" => "AD"
        ],
        [
            "label" => "Angola",
            "value" => "AO"
        ],
        [
            "label" => "Anguilla",
            "value" => "AI"
        ],
        [
            "label" => "Antarctica",
            "value" => "AQ"
        ],
        [
            "label" => "Antigua and Barbuda",
            "value" => "AG"
        ],
        [
            "label" => "Argentina",
            "value" => "AR"
        ],
        [
            "label" => "Armenia",
            "value" => "AM"
        ],
        [
            "label" => "Aruba",
            "value" => "AW"
        ],
        [
            "label" => "Australia",
            "value" => "AU"
        ],
        [
            "label" => "Austria",
            "value" => "AT"
        ],
        [
            "label" => "Azerbaijan",
            "value" => "AZ"
        ],
        [
            "label" => "Bahamas (the)",
            "value" => "BS"
        ],
        [
            "label" => "Bahrain",
            "value" => "BH"
        ],
        [
            "label" => "Bangladesh",
            "value" => "BD"
        ],
        [
            "label" => "Barbados",
            "value" => "BB"
        ],
        [
            "label" => "Belarus",
            "value" => "BY"
        ],
        [
            "label" => "Belgium",
            "value" => "BE"
        ],
        [
            "label" => "Belize",
            "value" => "BZ"
        ],
        [
            "label" => "Benin",
            "value" => "BJ"
        ],
        [
            "label" => "Bermuda",
            "value" => "BM"
        ],
        [
            "label" => "Bhutan",
            "value" => "BT"
        ],
        [
            "label" => "Bolivia (Plurinational State of)",
            "value" => "BO"
        ],
        [
            "label" => "Bonaire, Sint Eustatius and Saba",
            "value" => "BQ"
        ],
        [
            "label" => "Bosnia and Herzegovina",
            "value" => "BA"
        ],
        [
            "label" => "Botswana",
            "value" => "BW"
        ],
        [
            "label" => "Bouvet Island",
            "value" => "BV"
        ],
        [
            "label" => "Brazil",
            "value" => "BR"
        ],
        [
            "label" => "British Indian Ocean Territory (the)",
            "value" => "IO"
        ],
        [
            "label" => "Brunei Darussalam",
            "value" => "BN"
        ],
        [
            "label" => "Bulgaria",
            "value" => "BG"
        ],
        [
            "label" => "Burkina Faso",
            "value" => "BF"
        ],
        [
            "label" => "Burundi",
            "value" => "BI"
        ],
        [
            "label" => "Cabo Verde",
            "value" => "CV"
        ],
        [
            "label" => "Cambodia",
            "value" => "KH"
        ],
        [
            "label" => "Cameroon",
            "value" => "CM"
        ],
        [
            "label" => "Canada",
            "value" => "CA"
        ],
        [
            "label" => "Cayman Islands (the)",
            "value" => "KY"
        ],
        [
            "label" => "Central African Republic (the)",
            "value" => "CF"
        ],
        [
            "label" => "Chad",
            "value" => "TD"
        ],
        [
            "label" => "Chile",
            "value" => "CL"
        ],
        [
            "label" => "China",
            "value" => "CN"
        ],
        [
            "label" => "Christmas Island",
            "value" => "CX"
        ],
        [
            "label" => "Cocos (Keeling) Islands (the)",
            "value" => "CC"
        ],
        [
            "label" => "Colombia",
            "value" => "CO"
        ],
        [
            "label" => "Comoros (the)",
            "value" => "KM"
        ],
        [
            "label" => "Congo (the Democratic Republic of the)",
            "value" => "CD"
        ],
        [
            "label" => "Congo (the)",
            "value" => "CG"
        ],
        [
            "label" => "Cook Islands (the)",
            "value" => "CK"
        ],
        [
            "label" => "Costa Rica",
            "value" => "CR"
        ],
        [
            "label" => "Croatia",
            "value" => "HR"
        ],
        [
            "label" => "Cuba",
            "value" => "CU"
        ],
        [
            "label" => "Curaçao",
            "value" => "CW"
        ],
        [
            "label" => "Cyprus",
            "value" => "CY"
        ],
        [
            "label" => "Czechia",
            "value" => "CZ"
        ],
        [
            "label" => "Côte d'Ivoire",
            "value" => "CI"
        ],
        [
            "label" => "Denmark",
            "value" => "DK"
        ],
        [
            "label" => "Djibouti",
            "value" => "DJ"
        ],
        [
            "label" => "Dominica",
            "value" => "DM"
        ],
        [
            "label" => "Dominican Republic (the)",
            "value" => "DO"
        ],
        [
            "label" => "Ecuador",
            "value" => "EC"
        ],
        [
            "label" => "Egypt",
            "value" => "EG"
        ],
        [
            "label" => "El Salvador",
            "value" => "SV"
        ],
        [
            "label" => "Equatorial Guinea",
            "value" => "GQ"
        ],
        [
            "label" => "Eritrea",
            "value" => "ER"
        ],
        [
            "label" => "Estonia",
            "value" => "EE"
        ],
        [
            "label" => "Eswatini",
            "value" => "SZ"
        ],
        [
            "label" => "Ethiopia",
            "value" => "ET"
        ],
        [
            "label" => "Falkland Islands (the) [Malvinas]",
            "value" => "FK"
        ],
        [
            "label" => "Faroe Islands (the)",
            "value" => "FO"
        ],
        [
            "label" => "Fiji",
            "value" => "FJ"
        ],
        [
            "label" => "Finland",
            "value" => "FI"
        ],
        [
            "label" => "France",
            "value" => "FR"
        ],
        [
            "label" => "French Guiana",
            "value" => "GF"
        ],
        [
            "label" => "French Polynesia",
            "value" => "PF"
        ],
        [
            "label" => "French Southern Territories (the)",
            "value" => "TF"
        ],
        [
            "label" => "Gabon",
            "value" => "GA"
        ],
        [
            "label" => "Gambia (the)",
            "value" => "GM"
        ],
        [
            "label" => "Georgia",
            "value" => "GE"
        ],
        [
            "label" => "Germany",
            "value" => "DE"
        ],
        [
            "label" => "Ghana",
            "value" => "GH"
        ],
        [
            "label" => "Gibraltar",
            "value" => "GI"
        ],
        [
            "label" => "Greece",
            "value" => "GR"
        ],
        [
            "label" => "Greenland",
            "value" => "GL"
        ],
        [
            "label" => "Grenada",
            "value" => "GD"
        ],
        [
            "label" => "Guadeloupe",
            "value" => "GP"
        ],
        [
            "label" => "Guam",
            "value" => "GU"
        ],
        [
            "label" => "Guatemala",
            "value" => "GT"
        ],
        [
            "label" => "Guernsey",
            "value" => "GG"
        ],
        [
            "label" => "Guinea",
            "value" => "GN"
        ],
        [
            "label" => "Guinea-Bissau",
            "value" => "GW"
        ],
        [
            "label" => "Guyana",
            "value" => "GY"
        ],
        [
            "label" => "Haiti",
            "value" => "HT"
        ],
        [
            "label" => "Heard Island and McDonald Islands",
            "value" => "HM"
        ],
        [
            "label" => "Holy See (the)",
            "value" => "VA"
        ],
        [
            "label" => "Honduras",
            "value" => "HN"
        ],
        [
            "label" => "Hong Kong",
            "value" => "HK"
        ],
        [
            "label" => "Hungary",
            "value" => "HU"
        ],
        [
            "label" => "Iceland",
            "value" => "IS"
        ],
        [
            "label" => "India",
            "value" => "IN"
        ],
        [
            "label" => "Indonesia",
            "value" => "ID"
        ],
        [
            "label" => "Iran (Islamic Republic of)",
            "value" => "IR"
        ],
        [
            "label" => "Iraq",
            "value" => "IQ"
        ],
        [
            "label" => "Ireland",
            "value" => "IE"
        ],
        [
            "label" => "Isle of Man",
            "value" => "IM"
        ],
        [
            "label" => "Israel",
            "value" => "IL"
        ],
        [
            "label" => "Italy",
            "value" => "IT"
        ],
        [
            "label" => "Jamaica",
            "value" => "JM"
        ],
        [
            "label" => "Japan",
            "value" => "JP"
        ],
        [
            "label" => "Jersey",
            "value" => "JE"
        ],
        [
            "label" => "Jordan",
            "value" => "JO"
        ],
        [
            "label" => "Kazakhstan",
            "value" => "KZ"
        ],
        [
            "label" => "Kenya",
            "value" => "KE"
        ],
        [
            "label" => "Kiribati",
            "value" => "KI"
        ],
        [
            "label" => "Korea (the Democratic People's Republic of)",
            "value" => "KP"
        ],
        [
            "label" => "Korea (the Republic of)",
            "value" => "KR"
        ],
        [
            "label" => "Kuwait",
            "value" => "KW"
        ],
        [
            "label" => "Kyrgyzstan",
            "value" => "KG"
        ],
        [
            "label" => "Lao People's Democratic Republic (the)",
            "value" => "LA"
        ],
        [
            "label" => "Latvia",
            "value" => "LV"
        ],
        [
            "label" => "Lebanon",
            "value" => "LB"
        ],
        [
            "label" => "Lesotho",
            "value" => "LS"
        ],
        [
            "label" => "Liberia",
            "value" => "LR"
        ],
        [
            "label" => "Libya",
            "value" => "LY"
        ],
        [
            "label" => "Liechtenstein",
            "value" => "LI"
        ],
        [
            "label" => "Lithuania",
            "value" => "LT"
        ],
        [
            "label" => "Luxembourg",
            "value" => "LU"
        ],
        [
            "label" => "Macao",
            "value" => "MO"
        ],
        [
            "label" => "Madagascar",
            "value" => "MG"
        ],
        [
            "label" => "Malawi",
            "value" => "MW"
        ],
        [
            "label" => "Malaysia",
            "value" => "MY"
        ],
        [
            "label" => "Maldives",
            "value" => "MV"
        ],
        [
            "label" => "Mali",
            "value" => "ML"
        ],
        [
            "label" => "Malta",
            "value" => "MT"
        ],
        [
            "label" => "Marshall Islands (the)",
            "value" => "MH"
        ],
        [
            "label" => "Martinique",
            "value" => "MQ"
        ],
        [
            "label" => "Mauritania",
            "value" => "MR"
        ],
        [
            "label" => "Mauritius",
            "value" => "MU"
        ],
        [
            "label" => "Mayotte",
            "value" => "YT"
        ],
        [
            "label" => "Mexico",
            "value" => "MX"
        ],
        [
            "label" => "Micronesia (Federated States of)",
            "value" => "FM"
        ],
        [
            "label" => "Moldova (the Republic of)",
            "value" => "MD"
        ],
        [
            "label" => "Monaco",
            "value" => "MC"
        ],
        [
            "label" => "Mongolia",
            "value" => "MN"
        ],
        [
            "label" => "Montenegro",
            "value" => "ME"
        ],
        [
            "label" => "Montserrat",
            "value" => "MS"
        ],
        [
            "label" => "Morocco",
            "value" => "MA"
        ],
        [
            "label" => "Mozambique",
            "value" => "MZ"
        ],
        [
            "label" => "Myanmar",
            "value" => "MM"
        ],
        [
            "label" => "Namibia",
            "value" => "NA"
        ],
        [
            "label" => "Nauru",
            "value" => "NR"
        ],
        [
            "label" => "Nepal",
            "value" => "NP"
        ],
        [
            "label" => "Netherlands (the)",
            "value" => "NL"
        ],
        [
            "label" => "New Caledonia",
            "value" => "NC"
        ],
        [
            "label" => "New Zealand",
            "value" => "NZ"
        ],
        [
            "label" => "Nicaragua",
            "value" => "NI"
        ],
        [
            "label" => "Niger (the)",
            "value" => "NE"
        ],
        [
            "label" => "Nigeria",
            "value" => "NG"
        ],
        [
            "label" => "Niue",
            "value" => "NU"
        ],
        [
            "label" => "Norfolk Island",
            "value" => "NF"
        ],
        [
            "label" => "Northern Mariana Islands (the)",
            "value" => "MP"
        ],
        [
            "label" => "Norway",
            "value" => "NO"
        ],
        [
            "label" => "Oman",
            "value" => "OM"
        ],
        [
            "label" => "Pakistan",
            "value" => "PK"
        ],
        [
            "label" => "Palau",
            "value" => "PW"
        ],
        [
            "label" => "Palestine, State of",
            "value" => "PS"
        ],
        [
            "label" => "Panama",
            "value" => "PA"
        ],
        [
            "label" => "Papua New Guinea",
            "value" => "PG"
        ],
        [
            "label" => "Paraguay",
            "value" => "PY"
        ],
        [
            "label" => "Peru",
            "value" => "PE"
        ],
        [
            "label" => "Philippines (the)",
            "value" => "PH"
        ],
        [
            "label" => "Pitcairn",
            "value" => "PN"
        ],
        [
            "label" => "Poland",
            "value" => "PL"
        ],
        [
            "label" => "Portugal",
            "value" => "PT"
        ],
        [
            "label" => "Puerto Rico",
            "value" => "PR"
        ],
        [
            "label" => "Qatar",
            "value" => "QA"
        ],
        [
            "label" => "Republic of North Macedonia",
            "value" => "MK"
        ],
        [
            "label" => "Romania",
            "value" => "RO"
        ],
        [
            "label" => "Russian Federation (the)",
            "value" => "RU"
        ],
        [
            "label" => "Rwanda",
            "value" => "RW"
        ],
        [
            "label" => "Réunion",
            "value" => "RE"
        ],
        [
            "label" => "Saint Barthélemy",
            "value" => "BL"
        ],
        [
            "label" => "Saint Helena, Ascension and Tristan da Cunha",
            "value" => "SH"
        ],
        [
            "label" => "Saint Kitts and Nevis",
            "value" => "KN"
        ],
        [
            "label" => "Saint Lucia",
            "value" => "LC"
        ],
        [
            "label" => "Saint Martin (French part)",
            "value" => "MF"
        ],
        [
            "label" => "Saint Pierre and Miquelon",
            "value" => "PM"
        ],
        [
            "label" => "Saint Vincent and the Grenadines",
            "value" => "VC"
        ],
        [
            "label" => "Samoa",
            "value" => "WS"
        ],
        [
            "label" => "San Marino",
            "value" => "SM"
        ],
        [
            "label" => "Sao Tome and Principe",
            "value" => "ST"
        ],
        [
            "label" => "Saudi Arabia",
            "value" => "SA"
        ],
        [
            "label" => "Senegal",
            "value" => "SN"
        ],
        [
            "label" => "Serbia",
            "value" => "RS"
        ],
        [
            "label" => "Seychelles",
            "value" => "SC"
        ],
        [
            "label" => "Sierra Leone",
            "value" => "SL"
        ],
        [
            "label" => "Singapore",
            "value" => "SG"
        ],
        [
            "label" => "Sint Maarten (Dutch part)",
            "value" => "SX"
        ],
        [
            "label" => "Slovakia",
            "value" => "SK"
        ],
        [
            "label" => "Slovenia",
            "value" => "SI"
        ],
        [
            "label" => "Solomon Islands",
            "value" => "SB"
        ],
        [
            "label" => "Somalia",
            "value" => "SO"
        ],
        [
            "label" => "South Africa",
            "value" => "ZA"
        ],
        [
            "label" => "South Georgia and the South Sandwich Islands",
            "value" => "GS"
        ],
        [
            "label" => "South Sudan",
            "value" => "SS"
        ],
        [
            "label" => "Spain",
            "value" => "ES"
        ],
        [
            "label" => "Sri Lanka",
            "value" => "LK"
        ],
        [
            "label" => "Sudan (the)",
            "value" => "SD"
        ],
        [
            "label" => "Suriname",
            "value" => "SR"
        ],
        [
            "label" => "Svalbard and Jan Mayen",
            "value" => "SJ"
        ],
        [
            "label" => "Sweden",
            "value" => "SE"
        ],
        [
            "label" => "Switzerland",
            "value" => "CH"
        ],
        [
            "label" => "Syrian Arab Republic",
            "value" => "SY"
        ],
        [
            "label" => "Taiwan (Province of China)",
            "value" => "TW"
        ],
        [
            "label" => "Tajikistan",
            "value" => "TJ"
        ],
        [
            "label" => "Tanzania, United Republic of",
            "value" => "TZ"
        ],
        [
            "label" => "Thailand",
            "value" => "TH"
        ],
        [
            "label" => "Timor-Leste",
            "value" => "TL"
        ],
        [
            "label" => "Togo",
            "value" => "TG"
        ],
        [
            "label" => "Tokelau",
            "value" => "TK"
        ],
        [
            "label" => "Tonga",
            "value" => "TO"
        ],
        [
            "label" => "Trinidad and Tobago",
            "value" => "TT"
        ],
        [
            "label" => "Tunisia",
            "value" => "TN"
        ],
        [
            "label" => "Turkey",
            "value" => "TR"
        ],
        [
            "label" => "Turkmenistan",
            "value" => "TM"
        ],
        [
            "label" => "Turks and Caicos Islands (the)",
            "value" => "TC"
        ],
        [
            "label" => "Tuvalu",
            "value" => "TV"
        ],
        [
            "label" => "Uganda",
            "value" => "UG"
        ],
        [
            "label" => "Ukraine",
            "value" => "UA"
        ],
        [
            "label" => "United Arab Emirates (the)",
            "value" => "AE"
        ],
        [
            "label" => "United Kingdom of Great Britain and Northern Ireland (the)",
            "value" => "GB"
        ],
        [
            "label" => "United States Minor Outlying Islands (the)",
            "value" => "UM"
        ],
        [
            "label" => "United States of America (the)",
            "value" => "US"
        ],
        [
            "label" => "Uruguay",
            "value" => "UY"
        ],
        [
            "label" => "Uzbekistan",
            "value" => "UZ"
        ],
        [
            "label" => "Vanuatu",
            "value" => "VU"
        ],
        [
            "label" => "Venezuela (Bolivarian Republic of)",
            "value" => "VE"
        ],
        [
            "label" => "Viet Nam",
            "value" => "VN"
        ],
        [
            "label" => "Virgin Islands (British)",
            "value" => "VG"
        ],
        [
            "label" => "Virgin Islands (U.S.)",
            "value" => "VI"
        ],
        [
            "label" => "Wallis and Futuna",
            "value" => "WF"
        ],
        [
            "label" => "Western Sahara",
            "value" => "EH"
        ],
        [
            "label" => "Yemen",
            "value" => "YE"
        ],
        [
            "label" => "Zambia",
            "value" => "ZM"
        ],
        [
            "label" => "Zimbabwe",
            "value" => "ZW"
        ]
    );

    static $country_location = [
        'uk' => 'UK',
        'us' => 'US',
    ];


    protected $dateFormat = 'U';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
        'facebook_id',
        'role_id'
    ];

    static $statuses = [
        'active',
        'pending',
        'inactive'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'level_of_training' => 'integer',
    ];
    private $permissions;
    private $user_group;
    private $userInfo;


    static function getAdmin()
    {
        $role = Role::where('name', Role::$admin)->first();

        $admin = self::where('role_name', $role->name)
            ->where('role_id', $role->id)
            ->first();

        return $admin;
    }

    public function isAdmin()
    {
        return $this->role->is_admin;
    }

    public function isAdminRole()
    {
        return $this->role_name === Role::$admin;
    }

    public function isUser()
    {
        return $this->role_name === Role::$user;
    }

    public function isTeacher()
    {
        return $this->role_name === Role::$teacher;
    }

    public function isAdminTeacher()
    {
        return $this->role_name === Role::$adminTeacher;
    }

    public function isOrganization()
    {
        return $this->role_name === Role::$organization;
    }

    public function isAuthor()
    {
        return $this->role_name === Role::$author;
    }

    public function isReviewer()
    {
        return $this->role_name === Role::$reviewer;
    }

    public function isParent()
    {
        return $this->role_name === Role::$parent;
    }

    public function isTutor()
    {
        return $this->role_name === Role::$tutor;
    }

    public function hasPermission($section_name)
    {
        if (self::isAdmin()) {
            if (!isset($this->permissions)) {
                $sections_id = Permission::where('role_id', '=', $this->role_id)->where('allow', true)->pluck('section_id')->toArray();
                $this->permissions = Section::whereIn('id', $sections_id)->pluck('name')->toArray();
            }
            return in_array($section_name, $this->permissions);
        }
        return false;
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function getAvatar($size = 40)
    {
        if (!empty($this->avatar)) {
            $avatarUrl = $this->avatar;
        } else {
            $settings = getOthersPersonalizationSettings();

            if (!empty($settings) and !empty($settings['user_avatar_style']) and $settings['user_avatar_style'] == "ui_avatar") {
                $avatarUrl = "/getDefaultAvatar?item={$this->id}&name={$this->get_full_name()}&size=$size";
            } else {
                if (!empty($settings) and !empty($settings['default_user_avatar'])) {
                    $avatarUrl = $settings['default_user_avatar'];
                } else {
                    $avatarUrl = "/assets/default/img/default/avatar-1.png";
                }
            }
        }

        return $avatarUrl;
    }

    public function get_full_name()
    {
       $full_name = $this->full_name;
       $display_name = $this->display_name;
       if (auth()->check() && auth()->user()->isParent()) {
           $full_name = $this->full_name_parent;
       }else{
		   $full_name = ($display_name != '')? $display_name : $this->full_name;
	   }
       $full_name = ($full_name != '')? $full_name : $this->full_name;
       return $full_name;
    }

    public function get_first_name()
    {
       $first_name = $this->first_name;
       if (auth()->check() && auth()->user()->isParent()) {
           $first_name = $this->first_name_parent;
       }
       $first_name = ($first_name != '')? $first_name : $this->first_name;
       return $first_name;
    }

    public function get_last_name()
    {
       $last_name = $this->last_name;
       if (auth()->check() && auth()->user()->isParent()) {
           $last_name = $this->last_name_parent;
       }
        $last_name = ($last_name != '')? $last_name : $this->last_name;
       return $last_name;
    }

    public function getCover()
    {
        if (!empty($this->cover_img)) {
            $path = str_replace('/storage', '', $this->cover_img);

            $imgUrl = url($path);
        } else {
            $imgUrl = getPageBackgroundSettings('user_cover');
        }

        return $imgUrl;
    }

    public function getProfileUrl()
    {
        return '/users/' . $this->id . '/profile';
    }

    public function getLevelOfTrainingAttribute()
    {
        $levels = null;
        $bit = $this->attributes['level_of_training'];

        if (!empty($bit) and is_string($bit)) { // in host with mariaDB
            try {
                $tmp = (int)bin2hex($bit);

                if (is_numeric($tmp) and $tmp > 0 and $tmp <= 7) {
                    $bit = $tmp;
                }
            } catch (\Exception $exception) {

            }
        }

        if (!empty($bit) and is_numeric($bit)) {
            $levels = (new UserLevelOfTraining())->getName($bit);

            if (!empty($levels) and !is_array($levels)) {
                $levels = [$levels];
            }
        }

        return $levels;
    }

    public function getUserGroup()
    {
        if (empty($this->user_group)) {
            if (!empty($this->userGroup) and !empty($this->userGroup->group) and $this->userGroup->group->status == 'active') {
                $this->user_group = $this->userGroup->group;
            }
        }

        return $this->user_group;
    }


    public static function generatePassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function accounting()
    {
        return $this->hasMany(Accounting::class, 'user_id', 'id');
    }

    public function meeting()
    {
        return $this->hasOne('App\Models\Meeting', 'creator_id', 'id');
    }

    public function hasMeeting()
    {
        return Meeting::where('disabled', false)
            ->where('creator_id', $this->id)
            ->first();
    }

    public function ReserveMeetings()
    {
        return $this->hasMany('App\Models\ReserveMeeting', 'user_id', 'id');
    }

    public function affiliateCode()
    {
        return $this->hasOne('App\Models\AffiliateCode', 'user_id', 'id');
    }

    public function affiliates()
    {
        return $this->hasOne('App\Models\Affiliate', 'affiliate_user_id', 'id');
    }

    public function followers()
    {
        return Follow::where('user_id', $this->id)->where('status', Follow::$accepted)->get();
    }

    public function following()
    {
        return Follow::where('follower', $this->id)->where('status', Follow::$accepted)->get();
    }

    public function webinars()
    {
        return $this->hasMany('App\Models\Webinar', 'creator_id', 'id')
            ->orWhere('teacher_id', $this->id);
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'creator_id', 'id');
    }

    public function productOrdersAsBuyer()
    {
        return $this->hasMany('App\Models\ProductOrder', 'buyer_id', 'id');
    }

    public function productOrdersAsSeller()
    {
        return $this->hasMany('App\Models\ProductOrder', 'seller_id', 'id');
    }

    public function forumTopics()
    {
        return $this->hasMany('App\Models\ForumTopic', 'creator_id', 'id');
    }

    public function forumTopicPosts()
    {
        return $this->hasMany('App\Models\ForumTopicPost', 'user_id', 'id');
    }

    public function blog()
    {
        return $this->hasMany('App\Models\Blog', 'author_id', 'id');
    }

    public function selectedBank()
    {
        return $this->hasOne('App\Models\UserSelectedBank', 'user_id', 'id');
    }

    public function installmentOrders()
    {
        return $this->hasMany('App\Models\InstallmentOrder', 'user_id', 'id');
    }

    public function getActiveWebinars($just_count = false)
    {
        $webinars = Webinar::where('status', 'active')
            ->where(function ($query) {
                $query->where('creator_id', $this->id)
                    ->orWhere('teacher_id', $this->id);
            })
            ->orderBy('created_at', 'desc');

        if ($just_count) {
            return $webinars->count();
        }

        return $webinars->get();
    }

    public function userMetas()
    {
        return $this->hasMany('App\Models\UserMeta');
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart', 'creator_id', 'id');
    }

    public function userGroup()
    {
        return $this->belongsTo('App\Models\GroupUser', 'id', 'user_id');
    }

    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate', 'student_id', 'id');
    }

    public function customBadges()
    {
        return $this->hasMany('App\Models\UserBadge', 'user_id', 'id');
    }

    public function supports()
    {
        return $this->hasMany('App\Models\Support', 'user_id', 'id');
    }

    public function occupations()
    {
        return $this->hasMany('App\Models\UserOccupation', 'user_id', 'id');
    }

    public function userRegistrationPackage()
    {
        return $this->hasOne('App\Models\UserRegistrationPackage', 'user_id', 'id');
    }

    public function userSubscriptions()
    {
        return $this->hasOne('App\Models\UserSubscriptions', 'user_id', 'id')->where('status', 'active')->orderBy('id', 'DESC');
    }


    public function subscription($slug)
    {

        if( $this->gold_member == 1){
            return true;
        }
        $subscription_package = '';
        switch ($slug) {
            case "courses":
                $subscription_package = 'is_courses';
                break;
            case "timestables":
                $subscription_package = 'is_timestables';
                break;
            case "bookshelf":
                $subscription_package = 'is_bookshelf';
                break;
            case "sats":
                $subscription_package = 'is_sats';
                break;
            case "11plus":
                $subscription_package = 'is_elevenplus';
                break;
            case "vocabulary":
                $subscription_package = 'is_vocabulary';
                break;

        }
        $is_subscribed = UserSubscriptions::where('user_id', $this->id)->where('status', 'active')->where($subscription_package, 1)->count();

		//$is_subscribed = 1;
        $is_subscribed = ($is_subscribed > 0) ? true : false;
        return $is_subscribed;
    }

    public function assignment($topic_type, $topic_id)
    {
        $is_assigned = UserAssignedTopics::where('assigned_to_id', $this->id)
            ->where('status', 'active')
            ->where('topic_type', $topic_type)
            ->where('topic_id', $topic_id)->count();
        $is_assigned = ($is_assigned > 0) ? true : false;
        return $is_assigned;

    }

    public function userYear()
    {
        return $this->hasOne('App\Models\Category', 'id', 'year_id');
    }
	

    public function userSchool()
    {
        return $this->hasOne('App\Models\Schools', 'id', 'school_id');
    }

    public function userSchoolPreffernce1()
    {
        return $this->hasOne('App\Models\Schools', 'id', 'school_preference_1');
    }

    public function userSchoolPreffernce2()
    {
        return $this->hasOne('App\Models\Schools', 'id', 'school_preference_2');
    }

    public function userSchoolPreffernce3()
    {
        return $this->hasOne('App\Models\Schools', 'id', 'school_preference_3');
    }

    public function userClass()
    {
        return $this->hasOne('App\Models\Classes', 'id', 'class_id');
    }

    public function userSection()
    {
        return $this->hasOne('App\Models\Classes', 'id', 'section_id');
    }

    public function organization()
    {
        return $this->hasOne($this, 'id', 'organ_id');
    }

    public function users_achieved_levels()
    {
        return $this->hasOne('App\Models\UsersAchievedLevels', 'user_id', 'id');
    }


    public function getOrganizationTeachers()
    {
        return $this->hasMany($this, 'organ_id', 'id')->where('role_name', Role::$teacher);
    }

    public function getOrganizationStudents()
    {
        return $this->hasMany($this, 'organ_id', 'id')->where('role_name', Role::$user);
    }

    public function zoomApi()
    {
        return $this->hasOne('App\Models\UserZoomApi', 'user_id', 'id');
    }

    public function parentChilds()
    {
        return $this->hasMany('App\Models\UserParentLink', 'parent_id', 'id')->where('parent_type', 'parent');
    }
	
	public function childLinkedParents()
    {
        return $this->hasMany('App\Models\UserParentLink', 'user_id', 'id');
    }


    public function rates()
    {
        $webinars = $this->webinars()
            ->where('status', 'active')
            ->get();

        $rate = 0;

        if (!empty($webinars)) {
            $rates = 0;
            $count = 0;

            foreach ($webinars as $webinar) {
                $webinarRate = $webinar->getRate();

                if (!empty($webinarRate) and $webinarRate > 0) {
                    $count += 1;
                    $rates += $webinarRate;
                }
            }

            if ($rates > 0) {
                if ($count < 1) {
                    $count = 1;
                }

                $rate = number_format($rates / $count, 2);
            }
        }

        return $rate;
    }

    public function reviewsCount()
    {
        $webinars = $this->webinars;
        $count = 0;

        if (!empty($webinars)) {
            foreach ($webinars as $webinar) {
                $count += $webinar->reviews->count();
            }
        }

        return $count;
    }

    public function getBadges($customs = true, $getNext = false)
    {
        return Badge::getUserBadges($this, $customs, $getNext);
    }

    public function getCommission()
    {
        $commission = 0;
        $financialSettings = getFinancialSettings();

        if (!empty($financialSettings) and !empty($financialSettings['commission'])) {
            $commission = (int)$financialSettings['commission'];
        }

        $getUserGroup = $this->getUserGroup();
        if (!empty($getUserGroup) and isset($getUserGroup->commission)) {
            $commission = $getUserGroup->commission;
        }

        if (!empty($this->commission)) {
            $commission = $this->commission;
        }

        return $commission;
    }

    public function getIncome()
    {
        $totalIncome = Accounting::where('user_id', $this->id)
            ->where('type_account', Accounting::$income)
            ->where('type', Accounting::$addiction)
            ->where('system', false)
            ->where('tax', false)
            ->sum('amount');

        return $totalIncome;
    }

    public function getLastActivity()
    {
        $lastActivity = QuizzAttempts::where('user_id', $this->id)
            ->orderBy('id', 'DESC')
            ->first();

        return isset( $lastActivity->created_at )? $lastActivity->created_at : '';
    }

    public function getPayout()
    {
        $credit = Accounting::where('user_id', $this->id)
            ->where('type_account', Accounting::$income)
            ->where('type', Accounting::$addiction)
            ->where('system', false)
            ->where('tax', false)
            ->sum('amount');

        $debit = Accounting::where('user_id', $this->id)
            ->where('type_account', Accounting::$income)
            ->where('type', Accounting::$deduction)
            ->where('system', false)
            ->where('tax', false)
            ->sum('amount');

        return $credit - $debit;
    }

    public function getAccountingCharge()
    {
        $query = Accounting::where('user_id', $this->id)
            ->where('type_account', Accounting::$asset)
            ->where('system', false)
            ->where('tax', false);

        $additions = deepClone($query)->where('type', Accounting::$addiction)
            ->sum('amount');

        $deductions = deepClone($query)->where('type', Accounting::$deduction)
            ->sum('amount');

        $charge = $additions - $deductions;
        return $charge > 0 ? $charge : 0;
    }

    public function getAccountingBalance()
    {
        $additions = Accounting::where('user_id', $this->id)
            ->where('type', Accounting::$addiction)
            ->where('system', false)
            ->where('tax', false)
            ->sum('amount');

        $deductions = Accounting::where('user_id', $this->id)
            ->where('type', Accounting::$deduction)
            ->where('system', false)
            ->where('tax', false)
            ->sum('amount');

        $balance = $additions - $deductions;
        return $balance > 0 ? $balance : 0;
    }

    public function getPurchaseAmounts()
    {
        return Sale::where('buyer_id', $this->id)
            ->sum('amount');
    }

    public function getSaleAmounts()
    {
        return Sale::where('seller_id', $this->id)
            ->whereNull('refund_at')
            ->sum('amount');
    }

    public function sales()
    {
        $webinarIds = Webinar::where('creator_id', $this->id)->pluck('id')->toArray();

        return Sale::whereIn('webinar_id', $webinarIds)->sum('amount');
    }

    public function salesCount()
    {
        return Sale::where('seller_id', $this->id)
            ->whereNotNull('webinar_id')
            ->where('type', 'webinar')
            ->whereNull('refund_at')
            ->count();
    }

    public function productsSalesCount()
    {
        return Sale::where('seller_id', $this->id)
            ->whereNotNull('product_order_id')
            ->where('type', 'product')
            ->whereNull('refund_at')
            ->count();
    }

    public function getUnReadNotifications()
    {
        $user = $this;

        $notifications = Notification::where(function ($query) {
            $query->where(function ($query) {
                $query->where('user_id', $this->id)
                    ->where('type', 'single');
            })->orWhere(function ($query) {
                if (!$this->isAdmin()) {
                    $query->whereNull('user_id')
                        ->whereNull('group_id')
                        ->where('type', 'all_users');
                }
            });
        })->doesntHave('notificationStatus')
            ->orderBy('created_at', 'desc')
            ->get();

        $userGroup = $this->userGroup()->first();
        if (!empty($userGroup)) {
            $groupNotifications = Notification::where('group_id', $userGroup->group_id)
                ->where('type', 'group')
                ->doesntHave('notificationStatus')
                ->orderBy('created_at', 'desc')
                ->get();

            if (!empty($groupNotifications) and !$groupNotifications->isEmpty()) {
                $notifications = $notifications->merge($groupNotifications);
            }
        }

        if ($this->isUser()) {
            $studentsNotifications = Notification::whereNull('user_id')
                ->whereNull('group_id')
                ->where('type', 'students')
                ->doesntHave('notificationStatus')
                ->orderBy('created_at', 'desc')
                ->get();
            if (!empty($studentsNotifications) and !$studentsNotifications->isEmpty()) {
                $notifications = $notifications->merge($studentsNotifications);
            }
        }

        if ($this->isTeacher()) {
            $instructorNotifications = Notification::whereNull('user_id')
                ->whereNull('group_id')
                ->where('type', 'instructors')
                ->doesntHave('notificationStatus')
                ->orderBy('created_at', 'desc')
                ->get();
            if (!empty($instructorNotifications) and !$instructorNotifications->isEmpty()) {
                $notifications = $notifications->merge($instructorNotifications);
            }
        }

        if ($this->isOrganization()) {
            $organNotifications = Notification::whereNull('user_id')
                ->whereNull('group_id')
                ->where('type', 'organizations')
                ->doesntHave('notificationStatus')
                ->orderBy('created_at', 'desc')
                ->get();
            if (!empty($organNotifications) and !$organNotifications->isEmpty()) {
                $notifications = $notifications->merge($organNotifications);
            }
        }

        /* Get Course Students Notifications */
        $userBoughtWebinarsIds = $this->getAllPurchasedWebinarsIds();

        if (!empty($userBoughtWebinarsIds)) {
            $courseStudentsNotifications = Notification::whereIn('webinar_id', $userBoughtWebinarsIds)
                ->where('type', 'course_students')
                ->whereDoesntHave('notificationStatus', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            if (!empty($courseStudentsNotifications) and !$courseStudentsNotifications->isEmpty()) {
                $notifications = $notifications->merge($courseStudentsNotifications);
            }
        }

        return $notifications->sortByDesc('created_at');
    }

    public function getAllPurchasedWebinarsIds()
    {
        $userBoughtWebinarsIds = [];
        $userBoughtWebinars = Sale::query()->where('buyer_id', $this->id)
            ->whereNotNull('webinar_id')
            ->whereNull('refund_at')
            ->get();

        foreach ($userBoughtWebinars as $sale) {
            if (!empty($sale->webinar) and $sale->webinar->checkUserHasBought($this)) {
                $userBoughtWebinarsIds[] = $sale->webinar->id;
            }
        }

        return $userBoughtWebinarsIds;
    }

    public function getUnreadNoticeboards()
    {
        $purchasedCoursesIds = $this->getPurchasedCoursesIds();
        $purchasedCoursesInstructorsIds = Webinar::whereIn('id', $purchasedCoursesIds)
            ->pluck('teacher_id')
            ->toArray();

        $noticeboards = Noticeboard::where(function ($query) {
            $query->whereNotNull('organ_id')
                ->where('organ_id', $this->organ_id)
                ->where(function ($query) {
                    if ($this->isOrganization()) {
                        $query->where('type', 'organizations');
                    } else {
                        $type = 'students';

                        if ($this->isTeacher()) {
                            $type = 'instructors';
                        }

                        $query->whereIn('type', [
                            'students_and_instructors',
                            $type
                        ]);
                    }
                });
        })->orWhere(function ($query) {
            $type = ['all'];

            if ($this->isUser()) {
                $type = array_merge($type, [
                    'students',
                    'students_and_instructors'
                ]);
            } elseif ($this->isTeacher()) {
                $type = array_merge($type, [
                    'instructors',
                    'students_and_instructors'
                ]);
            } elseif ($this->isOrganization()) {
                $type = array_merge($type, ['organizations']);
            }

            $query->whereNull('organ_id')
                ->whereNull('instructor_id')
                ->whereIn('type', $type);
        })->orWhere(function ($query) use ($purchasedCoursesInstructorsIds) {
            $query->whereNull('webinar_id')
                ->whereIn('instructor_id', $purchasedCoursesInstructorsIds);
        })->orWhere(function ($query) use ($purchasedCoursesIds) {
            $query->whereIn('webinar_id', $purchasedCoursesIds);
        })
            ->orderBy('created_at', 'desc')
            ->get();


        /*
        ->whereDoesntHave('noticeboardStatus', function ($qu) {
            $qu->where('user_id', $this->id);
        })
        */

        return $noticeboards;
    }

    public function getUserQuests(){

        $user = $this;
        $user_id = $user->id;
        $class_id = $user->section_id;
        $today_date = strtotime(date('Y-m-d'));
        $query = DailyQuests::query()
            ->where('status', '!=', 'inactive')
            ->whereJsonContains('quest_dates', $today_date)
            ->where(function($query) use ($user_id, $class_id) {
                $query->where(function($q) use ($user_id) {
                    $q->where('quest_assign_type', 'Individual')
                        ->whereJsonContains('quest_users', $user_id);
                })->orWhere(function($q) use ($class_id) {
                    $q->where('quest_assign_type', 'Class')
                        ->whereJsonContains('class_ids', $class_id);
                })->orWhere('quest_assign_type', 'All');
            });

        $query->whereJsonContains('quest_dates', $today_date);
        $quests = $query->get();
        return $quests;
    }

    public function getPurchasedCoursesIds()
    {
        $webinarIds = [];
        $bundleIds = [];

        $sales = Sale::where('buyer_id', $this->id)
            ->where(function ($query) {
                $query->whereNotNull('webinar_id');
                $query->orWhereNotNull('bundle_id');
            })
            ->whereNull('refund_at')
            ->get();

        foreach ($sales as $sale) {
            if ($sale->payment_method == Sale::$subscribe) {
                $subscribe = $sale->getUsedSubscribe($sale->buyer_id, $sale->webinar_id);

                if (!empty($subscribe)) {
                    $subscribeSale = Sale::where('buyer_id', $this->id)
                        ->where('type', Sale::$subscribe)
                        ->where('subscribe_id', $subscribe->id)
                        ->whereNull('refund_at')
                        ->latest('created_at')
                        ->first();

                    if (!empty($subscribeSale)) {
                        $usedDays = (int)diffTimestampDay(time(), $subscribeSale->created_at);

                        if ($usedDays <= $subscribe->days) {
                            if (!empty($sale->webinar_id)) {
                                $webinarIds[] = $sale->webinar_id;
                            }

                            if (!empty($sale->bundle_id)) {
                                $bundleIds[] = $sale->bundle_id;
                            }
                        }
                    }
                }
            } else {
                if (!empty($sale->webinar_id)) {
                    $webinarIds[] = $sale->webinar_id;
                }

                if (!empty($sale->bundle_id)) {
                    $bundleIds[] = $sale->bundle_id;
                }
            }
        }

        if (!empty($bundleIds)) {
            $bundleWebinarIds = BundleWebinar::query()->whereIn('bundle_id', $bundleIds)
                ->pluck('webinar_id')
                ->toArray();

            $webinarIds = array_merge($webinarIds, $bundleWebinarIds);
        }

        return array_unique($webinarIds);
    }

    public function getActiveQuizzesResults($group_by_quiz = false, $status = null)
    {
        $query = QuizzesResult::where('user_id', $this->id);

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if ($group_by_quiz) {
            $query->groupBy('quiz_id');
        }

        return $query->get();
    }

    public function getTotalHoursTutoring()
    {
        $seconds = 0;

        if (!empty($this->meeting)) {
            $meetingId = $this->meeting->id;

            $reserves = ReserveMeeting::where('meeting_id', $meetingId)
                ->where('status', 'finished')
                ->get();

            if (!empty($reserves)) {

                foreach ($reserves as $reserve) {
                    $meetingTime = $reserve->meetingTime;

                    if ($meetingTime) {
                        $time = explode('-', $meetingTime->time);

                        $start = strtotime($time[0]);
                        $end = strtotime($time[1]);

                        $seconds = $end - $start;
                    }
                }
            }
        }

        $hours = $seconds ? $seconds / (60 * 60) : 0;

        return round($hours, 0, PHP_ROUND_HALF_UP);
    }

    public function getRewardPoints()
    {
        $credit = RewardAccounting::where('user_id', $this->id)
            ->where('status', RewardAccounting::ADDICTION)
            ->sum('score');

        $debit = RewardAccounting::where('user_id', $this->id)
            ->where('status', RewardAccounting::DEDUCTION)
            ->sum('score');

        return $credit - $debit;
    }
    
    public function getTodayPoints()
    {
        $todayStartTimestamp = Carbon::now()->startOfDay()->timestamp;
        $todayEndTimestamp = Carbon::now()->endOfDay()->timestamp;
        $credit = RewardAccounting::where('user_id', $this->id)
            ->where('status', RewardAccounting::ADDICTION)
            ->whereBetween('created_at', [
                $todayStartTimestamp,
                $todayEndTimestamp
            ])
            ->sum('score');

        return $credit;
    }

    public function getRewardPointsByType($parent_type, $parent_id = 0)
    {
        $credit = RewardAccounting::where('user_id', $this->id)
            ->where('parent_type', $parent_type)
            ->where('status', RewardAccounting::ADDICTION);
        if ($parent_id > 0) {
            $credit->where('parent_id', $parent_id);
        }
        $credit = $credit->sum('score');

        $debit = RewardAccounting::where('user_id', $this->id)
            ->where('parent_type', $parent_type)
            ->where('status', RewardAccounting::DEDUCTION);
        if ($parent_id > 0) {
            $debit->where('parent_id', $parent_id);
        }

        $debit = $debit->sum('score');

        return $credit - $debit;
    }

    public function getConductedAssessments($parent_type = '')
    {
        $resultObj = QuizzesResult::where('user_id', $this->id);
        if ($parent_type != '') {
            $resultObj->where('quiz_result_type', $parent_type);
            $resultObj->groupBy('parent_type_id');
        }
        $resultObj = $resultObj->get();
        $resultCount = $resultObj->count();
        return $resultCount;
    }
    
    public function assesstmentTotalTimeAllowed($parent_type = '')
    {
        $resultObj = QuizzResultQuestions::where('user_id', $this->id);
        if ($parent_type != '') {
            $resultObj->where('quiz_result_type', $parent_type);
            $resultObj->where('status', '!=', 'waiting');
        }
        $resultObj = $resultObj->get();
        $average_time = $resultObj->sum('average_time');
        $time_consumed = ($resultObj->sum('time_consumed') > 0)? round($resultObj->sum('time_consumed') / 60, 2) : 0;
        return array(
            'average_time' => $average_time,
            'time_consumed' => $time_consumed,
        );
    }

    public function getAddress($full = false)
    {
        $address = null;

        if ($full) {
            $regionIds = [
                $this->country_id,
                $this->province_id,
                $this->city_id,
                $this->district_id
            ];

            $regions = Region::whereIn('id', $regionIds)->get();

            foreach ($regions as $region) {
                if ($region->id == $this->country_id) {
                    $address .= $region->title;
                } elseif ($region->id == $this->province_id) {
                    $address .= ', ' . $region->title;
                } elseif ($region->id == $this->city_id) {
                    $address .= ', ' . $region->title;
                } elseif ($region->id == $this->district_id) {
                    $address .= ', ' . $region->title;
                }
            }
        }

        if (!empty($address)) {
            $address .= ', ';
        }

        $address .= $this->address;

        return $address;
    }

    public function getWaitingDeliveryProductOrdersCount()
    {
        return ProductOrder::where('seller_id', $this->id)
            ->where('status', ProductOrder::$waitingDelivery)
            ->count();
    }

    public function checkCanAccessToStore()
    {
        $result = (!empty(getStoreSettings('status')) and getStoreSettings('status'));

        if (!$result) {
            $result = $this->can_create_store;
        }

        return $result;
    }

    public function getTopicsPostsCount()
    {
        $topics = ForumTopic::where('creator_id', $this->id)->count();
        $posts = ForumTopicPost::where('user_id', $this->id)->count();

        return $topics + $posts;
    }

    public function getTopicsPostsLikesCount()
    {
        $topicsIds = ForumTopic::where('creator_id', $this->id)->pluck('id')->toArray();
        $postsIds = ForumTopicPost::where('user_id', $this->id)->pluck('id')->toArray();

        $topicsLikes = ForumTopicLike::whereIn('topic_id', $topicsIds)->count();
        $postsLikes = ForumTopicLike::whereIn('topic_post_id', $postsIds)->count();

        return $topicsLikes + $postsLikes;
    }

    public function getCountryAndState()
    {
        $address = null;

        if (!empty($this->country_id)) {
            $country = Region::where('id', $this->country_id)->first();

            if (!empty($country)) {
                $address .= $country->title;
            }
        }

        if (!empty($this->province_id)) {
            $province = Region::where('id', $this->province_id)->first();

            if (!empty($province)) {

                if (!empty($address)) {
                    $address .= '/';
                }

                $address .= $province->title;
            }
        }

        return $address;
    }

    public function getRegionByTypeId($typeId, $justTitle = true)
    {
        $region = !empty($typeId) ? Region::where('id', $typeId)->first() : null;

        if (!empty($region)) {
            return $justTitle ? $region->title : $region;
        }

        return '';
    }
}
