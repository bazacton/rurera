<?php

use App\Mixins\Financial\MultiCurrency;
use App\Models\UserAssignedTopics;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use App\Models\Quiz;
use App\Models\QuizAttemptLogs;
use App\Models\QuizzAttempts;
use App\Models\QuizzesResult;
use App\Models\BooksPagesInfoLinks;
use App\Models\SubChapters;
use App\Models\WebinarChapterItem;
use Illuminate\Support\Facades\File;

function getTemplate()
{
    /*$template = cache()->remember('view.template', 7 * 24 * 60 * 60, function () {
        return \App\Models\ViewTemplate::where('status', true)->first();
    });*/
    if (!empty($template) and $template->count() > 0) {
        return 'web.' . $template->folder;
    }
    return 'web.default';
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

/**
 * @param        $timestamp
 * @param string $format
 * // Use this format everywhere : j:day , M:month, Y:year, H:hour, i:minute => {j M Y} or {j M Y H:i}
 * */
function dateTimeFormat($timestamp, $format = 'H:i', $useAdminSetting = true, $applyTimezone = true, $timezone = "UTC")
{
    if ($applyTimezone) {
        $timezone = getTimezone();
    }

    if ($useAdminSetting) {
        $format = handleDateAndTimeFormat($format);
    }

    if (empty($timezone)) {
        $timezone = "UTC";
    }

    $carbon = (new Carbon())
        ->setTimezone($timezone)
        ->setTimestamp($timestamp);

    return $useAdminSetting ? $carbon->translatedFormat($format) : $carbon->format($format);
}

function dateTimeFormatForHumans($timestamp, $applyTimezone = true, $timezone = "UTC", $parts = 3)
{
    if ($applyTimezone) {
        $timezone = getTimezone();
    }

    if (empty($timezone)) {
        $timezone = "UTC";
    }

    $carbon = (new Carbon())
        ->setTimezone($timezone)
        ->setTimestamp($timestamp);

    return $carbon->diffForHumans(null, null, false, $parts);
}

function getTimezone()
{
    $timezone = getGeneralSettings('default_time_zone');

    if (auth()->check()) {
        $user = auth()->user();

        if (!empty($user) and !empty($user->timezone)) {
            $timezone = $user->timezone;
        }
    }

    return $timezone;
}

function handleDateAndTimeFormat($format)
{
    $dateFormat = getGeneralSettings('date_format') ?? 'textual';
    $timeFormat = getGeneralSettings('time_format') ?? '24_hours';

    if ($dateFormat == 'numerical') {
        $format = str_replace('M', 'm', $format);
        $format = str_replace('j ', 'j/', $format);
        $format = str_replace('m ', 'm/', $format);
    } else {
        $format = str_replace('m', 'M', $format);
    }

    if ($timeFormat == '12_hours') {
        $format = str_replace('H', 'h', $format);

        if (strpos($format, 'h')) {
            $format .= ' a';
        }
    } else {
        $format = str_replace('h', 'H', $format);
        $format = str_replace('a', '', $format);
    }

    return $format;
}

function diffTimestampDay($firstTime, $lastTime)
{
    return ($firstTime - $lastTime) / (24 * 60 * 60);
}

function convertMinutesToHourAndMinute($minutes)
{
    return intdiv($minutes, 60) . ':' . (str_pad($minutes % 60, 2, 0, STR_PAD_LEFT));
}

function getListOfTimezones()
{
    return DateTimeZone::listIdentifiers();
}

function toGmtOffset($timezone): string
{
    $userTimeZone = new DateTimeZone($timezone);
    $offset = $userTimeZone->getOffset(new DateTime("now", new DateTimeZone('GMT'))); // Offset in seconds
    $seconds = abs($offset);
    $sign = $offset > 0 ? '+' : '-';
    $hours = floor($seconds / 3600);
    $mins = floor($seconds / 60 % 60);
    $secs = floor($seconds % 60);
    return sprintf("GMT $sign%02d:%02d", $hours, $mins, $secs);
}

//this function convert string to UTC time zone
function convertTimeToUTCzone($str, $userTimezone, $format = false)
{
    if (empty($userTimezone)) {
        $userTimezone = getTimezone();
    }

    $new_str = new DateTime($str, new DateTimeZone($userTimezone));

    $new_str->setTimeZone(new DateTimeZone('UTC'));

    if ($format) {
        return $new_str->format("Y-m-d H:i");
    }

    return $new_str;
}

function x_week_range()
{
    $start = strtotime(date('Y-m-d', strtotime("last Saturday")));
    return array(
        $start,
        strtotime(date('Y-m-d', strtotime('next Friday', $start)))
    );
}

function getTimeByDay($title)
{
    $start = date('Y-m-d', strtotime("last Saturday"));
    $time = 0;
    switch ($title) {
        case "saturday":
            $time = strtotime(date('Y-m-d', strtotime($start)));
            break;
        case "sunday":
            $time = strtotime(date('Y-m-d', strtotime($start . "+1 days")));
            break;
        case "monday":
            $time = strtotime(date('Y-m-d', strtotime($start . "+2 days")));
            break;
        case "tuesday":
            $time = strtotime(date('Y-m-d', strtotime($start . "+3 days")));
            break;
        case "wednesday":
            $time = strtotime(date('Y-m-d', strtotime($start . "+4 days")));
            break;
        case "thursday":
            $time = strtotime(date('Y-m-d', strtotime($start . "+5 days")));
            break;
        case "friday":
            $time = strtotime(date('Y-m-d', strtotime($start . "+6 days")));
            break;
    }
    return $time;
}

function convertDayToNumber($times)
{
    $numbers = [
        'sunday'    => 1,
        'monday'    => 2,
        'tuesday'   => 3,
        'wednesday' => 4,
        'thursday'  => 5,
        'friday'    => 6,
        'saturday'  => 7
    ];

    $numberDay = [];

    foreach ($times as $day => $time) {
        $numberDay[] = $numbers[$day];
    }

    return $numberDay;
}

function getBindedSQL($query)
{
    $fullQuery = $query->toSql();
    $replaces = $query->getBindings();
    foreach ($replaces as $replace) {
        $fullQuery = Str::replaceFirst('?', $replace, $fullQuery);
    }

    return $fullQuery;
}

function getUserLanguagesLists()
{
    $generalSettings = getGeneralSettings();
    $userLanguages = ($generalSettings and !empty($generalSettings['user_languages'])) ? $generalSettings['user_languages'] : null;

    if (!empty($userLanguages) and is_array($userLanguages)) {
        $userLanguages = getLanguages($userLanguages);
    } else {
        $userLanguages = [];
    }

    if (count($userLanguages) > 0) {
        foreach ($userLanguages as $locale => $language) {
            if (mb_strtolower($locale) == mb_strtolower(app()->getLocale())) {
                $firstKey = array_key_first($userLanguages);

                if ($firstKey != $locale) {
                    $firstValue = $userLanguages[$firstKey];

                    unset($userLanguages[$locale]);
                    unset($userLanguages[$firstKey]);

                    $userLanguages = array_merge([
                        $locale   => $language,
                        $firstKey => $firstValue
                    ], $userLanguages);
                }
            }
        }
    }

    return $userLanguages;
}

function getLanguages($lang = null)
{
    $languages = [
        "AA" => 'Afar',
        "AF" => 'Afrikanns',
        "SQ" => 'Albanian',
        "AM" => 'Amharic',
        "AR" => 'Arabic',
        "HY" => 'Armenian',
        "AY" => 'Aymara',
        "AZ" => 'Azerbaijani',
        "EU" => 'Basque',
        "DZ" => 'Bhutani',
        "BH" => 'Bihari',
        "BI" => 'Bislama',
        "BR" => 'Breton',
        "BG" => 'Bulgarian',
        "MY" => 'Burmese',
        "BE" => 'Byelorussian',
        "BN" => 'Bangla',
        "KM" => 'Cambodian',
        "CA" => 'Catalan',
        "ZH" => 'Chinese',
        "HR" => 'Croation',
        "CS" => 'Czech',
        "DA" => 'Danish',
        "NL" => 'Dutch',
        "EN" => 'English',
        "ET" => 'Estonian',
        "FO" => 'Faeroese',
        "FJ" => 'Fiji',
        "FI" => 'Finnish',
        "FR" => 'French',
        "KA" => 'Georgian',
        "DE" => 'German',
        "EL" => 'Greek',
        "KL" => 'Greenlandic',
        "GN" => 'Guarani',
        "HI" => 'Hindi',
        "HU" => 'Hungarian',
        "IS" => 'Icelandic',
        "ID" => 'Indonesian',
        "IT" => 'Italian',
        "JA" => 'Japanese',
        "KK" => 'Kazakh',
        "RW" => 'Kinyarwanda',
        "KY" => 'Kirghiz',
        "KO" => 'Korean',
        "KU" => 'Kurdish',
        "LO" => 'Laothian',
        "LA" => 'Latin',
        "LV" => 'Latvian',
        "LT" => 'Lithuanian',
        "MK" => 'Macedonian',
        "MG" => 'Malagasy',
        "MS" => 'Malay',
        "MT" => 'Maltese',
        "MI" => 'Maori',
        "MN" => 'Mongolian',
        "NA" => 'Nauru',
        "NE" => 'Nepali',
        "NO" => 'Norwegian',
        "OM" => 'Oromo',
        "PS" => 'Pashto',
        "FA" => 'Persian',
        "PL" => 'Polish',
        "PT" => 'Portuguese',
        "QU" => 'Quechua',
        "RM" => 'Rhaeto',
        "RO" => 'Romanian',
        "RU" => 'Russian',
        "SM" => 'Samoan',
        "SG" => 'Sangro',
        "SR" => 'Serbian',
        "TN" => 'Setswana',
        "SN" => 'Shona',
        "SI" => 'Singhalese',
        "SS" => 'Siswati',
        "SK" => 'Slovak',
        "SL" => 'Slovenian',
        "SO" => 'Somali',
        "ES" => 'Spanish',
        "SV" => 'Swedish',
        "TL" => 'Tagalog',
        "TG" => 'Tajik',
        "TA" => 'Tamil',
        "TH" => 'Thai',
        "TI" => 'Tigrinya',
        "TR" => 'Turkish',
        "TK" => 'Turkmen',
        "TW" => 'Twi',
        "UK" => 'Ukranian',
        "UR" => 'Urdu',
        "UZ" => 'Uzbek',
        "VI" => 'Vietnamese',
        "XH" => 'Xhosa',
    ];

    if (!empty($lang) and is_array($lang)) {
        return array_flip(array_intersect(array_flip($languages), $lang));
    } elseif (!empty($lang)) {
        return $languages[$lang];
    }

    return $languages;
}

function localeToCountryCode($code, $revers = false)
{
    $languages = [
        "AA" => 'DJ',
        // language code => country code
        "AF" => 'ZA',
        "SQ" => 'AL',
        "AM" => 'ET',
        "AR" => 'IQ',
        "HY" => 'AM',
        "AY" => 'BO',
        "AZ" => 'AZ',
        "EU" => 'ES',
        "BN" => 'BD',
        "DZ" => 'BT',
        "BI" => 'VU',
        "BG" => 'BG',
        "MY" => 'MM',
        "BE" => 'BY',
        "KM" => 'KH',
        "CA" => 'ES',
        "ZH" => 'CN',
        "HR" => 'HR',
        "CS" => 'CZ',
        "DA" => 'DK',
        "NL" => 'NL',
        "EN" => 'US',
        "ET" => 'EE',
        "FO" => 'FO',
        "FJ" => 'FJ',
        "FI" => 'FI',
        "FR" => 'FR',
        "KA" => 'GE',
        "DE" => 'DE',
        "EL" => 'GR',
        "KL" => 'GL',
        "GN" => 'GN',
        "HI" => 'IN',
        "HU" => 'HU',
        "IS" => 'IS',
        "ID" => 'ID',
        "IT" => 'IT',
        "JA" => 'JP',
        "KK" => 'KZ',
        "RW" => 'RW',
        "KY" => 'KG',
        "KO" => 'KR',
        "LO" => 'LA',
        "LA" => 'RS',
        "LV" => 'LV',
        "LT" => 'LT',
        "MK" => 'MK',
        "MG" => 'MG',
        "MS" => 'MS',
        "MT" => 'MT',
        "MI" => 'NZ',
        "MN" => 'MN',
        "NA" => 'NR',
        "NE" => 'NP',
        "NO" => 'NO',
        "OM" => 'ET',
        "PS" => 'AF',
        "FA" => 'IR',
        "PL" => 'PL',
        "PT" => 'PT',
        "QU" => 'BO',
        "RM" => 'CH',
        "RO" => 'RO',
        "RU" => 'RU',
        "SM" => 'WS',
        "SG" => 'CG',
        "SR" => 'SR',
        "TN" => 'BW',
        "SN" => 'ZW',
        "SI" => 'LK',
        "SS" => 'SZ',
        "SK" => 'SK',
        "SL" => 'SI',
        "SO" => 'SO',
        "ES" => 'ES',
        "SV" => 'SE',
        "TL" => 'PH',
        "TG" => 'TJ',
        "TA" => 'LK',
        "TH" => 'TH',
        "TI" => 'ER',
        "TR" => 'TR',
        "TK" => 'TM',
        "TW" => 'TW',
        "UK" => 'UA',
        "UR" => 'PK',
        "UZ" => 'UZ',
        "VI" => 'VN',
        "XH" => 'ZA',
    ];

    if ($revers) {
        $languages = array_flip($languages);
        return !empty($languages[$code]) ? $languages[$code] : '';
    }

    return !empty($languages[$code]) ? $languages[$code] : '';
}

function getMoneyUnits($unit = null)
{
    $units = [
        "USD" => 'United States Dollar',
        "EUR" => 'Euro Member Countries',
        "AUD" => 'Australia Dollar',
        "AED" => 'United Arab Emirates dirham',
        "KAD" => 'KAD',
        "JPY" => 'Japan Yen',
        "CNY" => 'China Yuan Renminbi',
        "SAR" => 'Saudi Arabia Riyal',
        "KRW" => 'Korea (South) Won',
        "INR" => 'India Rupee',
        "RUB" => 'Russia Ruble',
        "Lek" => 'Albania Lek',
        "AFN" => 'Afghanistan Afghani',
        "ARS" => 'Argentina Peso',
        "AWG" => 'Aruba Guilder',
        "AZN" => 'Azerbaijan Manat',
        "BDT" => 'Bangladeshi taka',
        "BSD" => 'Bahamas Dollar',
        "BBD" => 'Barbados Dollar',
        "BYN" => 'Belarus Ruble',
        "BZD" => 'Belize Dollar',
        "BMD" => 'Bermuda Dollar',
        "BOB" => 'Bolivia Bolíviano',
        "BAM" => 'Bosnia and Herzegovina Convertible Mark',
        "BWP" => 'Botswana Pula',
        "BGN" => 'Bulgaria Lev',
        "BRL" => 'Brazil Real',
        "BND" => 'Brunei Darussalam Dollar',
        "KHR" => 'Cambodia Riel',
        "CAD" => 'Canada Dollar',
        "KYD" => 'Cayman Islands Dollar',
        "CLP" => 'Chile Peso',
        "COP" => 'Colombia Peso',
        "CRC" => 'Costa Rica Colon',
        "HRK" => 'Croatia Kuna',
        "CUP" => 'Cuba Peso',
        "CZK" => 'Czech Republic Koruna',
        "DKK" => 'Denmark Krone',
        "DZD" => 'Algerian Dinar',
        "DOP" => 'Dominican Republic Peso',
        "XCD" => 'East Caribbean Dollar',
        "EGP" => 'Egypt Pound',
        "GTQ" => 'Guatemala Quetzal',
        "GHS" => 'Ghanaian cedi',
        "HKD" => 'Hong Kong Dollar',
        "HUF" => 'Hungary Forint',
        "IDR" => 'Indonesia Rupiah',
        "IRR" => 'Iran Rial',
        "ILS" => 'Israel Shekel',
        "LBP" => 'Lebanon Pound',
        "MAD" => 'Moroccan dirham',
        "MYR" => 'Malaysia Ringgit',
        "NGN" => 'Nigeria Naira',
        "NPR" => 'Nepalese Rupee',
        "NOK" => 'Norway Krone',
        "OMR" => 'Oman Rial',
        "PKR" => 'Pakistan Rupee',
        "PHP" => 'Philippines Peso',
        "PLN" => 'Poland Zloty',
        "RON" => 'Romania Leu',
        "ZAR" => 'South Africa Rand',
        "LKR" => 'Sri Lanka Rupee',
        "SEK" => 'Sweden Krona',
        "CHF" => 'Switzerland Franc',
        "THB" => 'Thailand Baht',
        "TRY" => 'Turkey Lira',
        "UAH" => 'Ukraine Hryvnia',
        "GBP" => 'United Kingdom Pound',
        "TWD" => 'Taiwan New Dollar',
        "VND" => 'Viet Nam Dong',
        "UZS" => 'Uzbekistan Som',
        "KZT" => 'Kazakhstani Tenge',
    ];

    if (!empty($unit)) {
        return $units[$unit];
    }

    return $units;
}

function currenciesLists($sing = null)
{
    $lists = [
        "USD" => 'United States Dollar',
        "EUR" => 'Euro Member Countries',
        "AUD" => 'Australia Dollar',
        "AED" => 'United Arab Emirates dirham',
        "KAD" => 'KAD',
        "JPY" => 'Japan Yen',
        "CNY" => 'China Yuan Renminbi',
        "SAR" => 'Saudi Arabia Riyal',
        "KRW" => 'Korea (South) Won',
        "INR" => 'India Rupee',
        "RUB" => 'Russia Ruble',
        "Lek" => 'Albania Lek',
        "AFN" => 'Afghanistan Afghani',
        "ARS" => 'Argentina Peso',
        "AWG" => 'Aruba Guilder',
        "AZN" => 'Azerbaijan Manat',
        "BSD" => 'Bahamas Dollar',
        "BBD" => 'Barbados Dollar',
        "BDT" => 'Bangladeshi taka',
        "BYN" => 'Belarus Ruble',
        "BZD" => 'Belize Dollar',
        "BMD" => 'Bermuda Dollar',
        "BOB" => 'Bolivia Bolíviano',
        "BAM" => 'Bosnia and Herzegovina Convertible Mark',
        "BWP" => 'Botswana Pula',
        "BGN" => 'Bulgaria Lev',
        "BRL" => 'Brazil Real',
        "BND" => 'Brunei Darussalam Dollar',
        "KHR" => 'Cambodia Riel',
        "CAD" => 'Canada Dollar',
        "KYD" => 'Cayman Islands Dollar',
        "CLP" => 'Chile Peso',
        "COP" => 'Colombia Peso',
        "CRC" => 'Costa Rica Colon',
        "HRK" => 'Croatia Kuna',
        "CUP" => 'Cuba Peso',
        "CZK" => 'Czech Republic Koruna',
        "DKK" => 'Denmark Krone',
        "DZD" => 'Algerian Dinar',
        "DOP" => 'Dominican Republic Peso',
        "XCD" => 'East Caribbean Dollar',
        "EGP" => 'Egypt Pound',
        "GTQ" => 'Guatemala Quetzal',
        "GHS" => 'Ghanaian cedi',
        "HKD" => 'Hong Kong Dollar',
        "HUF" => 'Hungary Forint',
        "IDR" => 'Indonesia Rupiah',
        "IRR" => 'Iran Rial',
        "ILS" => 'Israel Shekel',
        "LBP" => 'Lebanon Pound',
        "MAD" => 'Moroccan dirham',
        "MYR" => 'Malaysia Ringgit',
        "NGN" => 'Nigeria Naira',
        "NPR" => 'Nepalese Rupee',
        "NOK" => 'Norway Krone',
        "OMR" => 'Oman Rial',
        "PKR" => 'Pakistan Rupee',
        "PHP" => 'Philippines Peso',
        "PLN" => 'Poland Zloty',
        "RON" => 'Romania Leu',
        "ZAR" => 'South Africa Rand',
        "LKR" => 'Sri Lanka Rupee',
        "SEK" => 'Sweden Krona',
        "CHF" => 'Switzerland Franc',
        "THB" => 'Thailand Baht',
        "TRY" => 'Turkey Lira',
        "UAH" => 'Ukraine Hryvnia',
        "GBP" => 'United Kingdom Pound',
        "TWD" => 'Taiwan New Dollar',
        "VND" => 'Viet Nam Dong',
        "UZS" => 'Uzbekistan Som',
        "KZT" => 'Kazakhstani Tenge',

    ];

    if (!empty($sing)) {
        return $lists[$sing];
    }

    return $lists;
}


function currency($user = null)
{
    if (empty($user)) {
        $user = auth()->user();
    }

    if (!empty($user) and !empty($user->currency)) {
        return $user->currency;
    } else if (empty($user)) {
        $checkCookie = Cookie::get('user_currency');

        if (!empty($checkCookie)) {
            return $checkCookie;
        }
    }

    return getDefaultCurrency();
}

function getDefaultCurrency()
{
    return getFinancialCurrencySettings('currency') ?? 'USD';
}

function currencySign($currency = null)
{
    if (empty($currency)) {
        $currency = currency();
    }

    switch ($currency) {
        case 'USD':
            return '$';
            break;
        case 'EUR':
            return '€';
            break;
        case 'JPY':
        case 'CNY':
            return '¥';
            break;
        case 'AED':
            return 'د.إ';
            break;
        case 'SAR':
            return 'ر.س';
            break;
        case 'KRW':
            return '₩';
            break;
        case 'INR':
            return '₹';
            break;
        case 'RUB':
            return '₽';
            break;
        case 'Lek':
            return 'Lek';
            break;
        case 'AFN':
            return '؋';
            break;
        case 'ARS':
            return '$';
            break;
        case 'AWG':
            return 'ƒ';
            break;
        case 'AUD':
            return '$';
            break;
        case 'AZN':
            return '₼';
            break;
        case 'BSD':
            return '$';
            break;
        case 'BBD':
            return '$';
            break;
        case 'BDT':
            return '৳';
            break;
        case 'BYN':
            return 'Br';
            break;
        case 'BZD':
            return 'BZ$';
            break;
        case 'BMD':
            return '$';
            break;
        case 'BOB':
            return '$b';
            break;
        case 'BAM':
            return 'KM';
            break;
        case 'BWP':
            return 'P';
            break;
        case 'BGN':
            return 'лв';
            break;
        case 'BRL':
            return 'R$';
            break;
        case 'BND':
            return '$';
            break;
        case 'COP':
            return '$';
            break;
        case 'CRC':
            return '₡';
            break;
        case 'CZK':
            return 'K�?';
            break;
        case 'CUP':
            return '₱';
            break;
        case 'DKK':
            return 'kr';
            break;
        case 'DZD':
            return 'دج';
            break;
        case 'DOP':
            return 'RD$';
            break;
        case 'XCD':
            return '$';
            break;
        case 'EGP':
            return '£';
            break;
        case 'GTQ':
            return 'Q';
            break;
        case 'HKD':
            return '$';
            break;
        case 'HUF':
            return 'Ft';
            break;
        case 'IDR':
            return 'Rp';
            break;
        case 'IRR':
            return '﷼';
            break;
        case 'ILS':
            return '₪';
            break;
        case 'LBP':
            return '£';
            break;
        case 'MAD':
            return 'DH';
            break;
        case 'MYR':
            return 'RM';
            break;
        case 'NGN':
            return '₦';
            break;
        case 'NPR':
            return 'रू';
            break;
        case 'NOK':
            return 'kr';
            break;
        case 'OMR':
            return '﷼';
            break;
        case 'PKR':
            return '₨';
            break;
        case 'PHP':
            return '₱';
            break;
        case 'PLN':
            return 'zł';
            break;
        case 'RON':
            return 'lei';
            break;
        case 'ZAR':
            return 'R';
            break;
        case 'LKR':
            return '₨';
            break;
        case 'SEK':
            return 'kr';
            break;
        case 'CHF':
            return 'CHF';
            break;
        case 'THB':
            return '฿';
            break;
        case 'TRY':
            return '₺';
            break;
        case 'UAH':
            return '₴';
            break;
        case 'GBP':
            return '£';
            break;
        case 'GHS':
            return 'GH₵';
            break;
        case 'VND':
            return '₫';
            break;
        case 'TWD':
            return 'NT$';
            break;
        case 'UZS':
            return 'лв';
            break;
        case 'KZT':
            return '₸';
            break;
        default:
            return '$';
    }

    return '$';
}

function getCountriesMobileCode()
{
    return [
        'USA (+1)'                           => '+1',
        'UK (+44)'                           => '+44',
        'Algeria (+213)'                     => '+213',
        'Andorra (+376)'                     => '+376',
        'Angola (+244)'                      => '+244',
        'Anguilla (+1264)'                   => '+1264',
        'Antigua &amp; Barbuda (+1268)'      => '+1268',
        'Argentina (+54)'                    => '+54',
        'Armenia (+374)'                     => '+374',
        'Aruba (+297)'                       => '+297',
        'Australia (+61)'                    => '+61',
        'Austria (+43)'                      => '+43',
        'Azerbaijan (+994)'                  => '+994',
        'Bahamas (+1242)'                    => '+1242',
        'Bahrain (+973)'                     => '+973',
        'Bangladesh (+880)'                  => '+880',
        'Barbados (+1246)'                   => '+1246',
        'Belarus (+375)'                     => '+375',
        'Belgium (+32)'                      => '+32',
        'Belize (+501)'                      => '+501',
        'Benin (+229)'                       => '+229',
        'Bermuda (+1441)'                    => '+1441',
        'Bhutan (+975)'                      => '+975',
        'Bolivia (+591)'                     => '+591',
        'Bosnia Herzegovina (+387)'          => '+387',
        'Botswana (+267)'                    => '+267',
        'Brazil (+55)'                       => '+55',
        'Brunei (+673)'                      => '+673',
        'Bulgaria (+359)'                    => '+359',
        'Burkina Faso (+226)'                => '+226',
        'Burundi (+257)'                     => '+257',
        'Cambodia (+855)'                    => '+855',
        'Cameroon (+237)'                    => '+237',
        'Canada (+1)'                        => '+1',
        'Cape Verde Islands (+238)'          => '+238',
        'Cayman Islands (+1345)'             => '+1345',
        'Central African Republic (+236)'    => '+236',
        'Chile (+56)'                        => '+56',
        'China (+86)'                        => '+86',
        'Colombia (+57)'                     => '+57',
        'Comoros (+269)'                     => '+269',
        'Congo (+242)'                       => '+242',
        'Cook Islands (+682)'                => '+682',
        'Costa Rica (+506)'                  => '+506',
        'Croatia (+385)'                     => '+385',
        'Cuba (+53)'                         => '+53',
        'Cyprus - North (+90)'               => '+90',
        'Cyprus - South (+357)'              => '+357',
        'Czech Republic (+420)'              => '+420',
        'Denmark (+45)'                      => '+45',
        'Djibouti (+253)'                    => '+253',
        'Dominica (+1809)'                   => '+1809',
        'Dominican Republic (+1809)'         => '+1809',
        'Ecuador (+593)'                     => '+593',
        'Egypt (+20)'                        => '+20',
        'El Salvador (+503)'                 => '+503',
        'Equatorial Guinea (+240)'           => '+240',
        'Eritrea (+291)'                     => '+291',
        'Estonia (+372)'                     => '+372',
        'Ethiopia (+251)'                    => '+251',
        'Falkland Islands (+500)'            => '+500',
        'Faroe Islands (+298)'               => '+298',
        'Fiji (+679)'                        => '+679',
        'Finland (+358)'                     => '+358',
        'France (+33)'                       => '+33',
        'French Guiana (+594)'               => '+594',
        'French Polynesia (+689)'            => '+689',
        'Gabon (+241)'                       => '+241',
        'Gambia (+220)'                      => '+220',
        'Georgia (+7880)'                    => '+7880',
        'Germany (+49)'                      => '+49',
        'Ghana (+233)'                       => '+233',
        'Gibraltar (+350)'                   => '+350',
        'Greece (+30)'                       => '+30',
        'Greenland (+299)'                   => '+299',
        'Grenada (+1473)'                    => '+1473',
        'Guadeloupe (+590)'                  => '+590',
        'Guam (+671)'                        => '+671',
        'Guatemala (+502)'                   => '+502',
        'Guinea (+224)'                      => '+224',
        'Guinea - Bissau (+245)'             => '+245',
        'Guyana (+592)'                      => '+592',
        'Haiti (+509)'                       => '+509',
        'Honduras (+504)'                    => '+504',
        'Hong Kong (+852)'                   => '+852',
        'Hungary (+36)'                      => '+36',
        'Iceland (+354)'                     => '+354',
        'India (+91)'                        => '+91',
        'Indonesia (+62)'                    => '+62',
        'Iraq (+964)'                        => '+964',
        'Iran (+98)'                         => '+98',
        'Ireland (+353)'                     => '+353',
        'Israel (+972)'                      => '+972',
        'Italy (+39)'                        => '+39',
        'Jamaica (+1876)'                    => '+1876',
        'Japan (+81)'                        => '+81',
        'Jordan (+962)'                      => '+962',
        'Kazakhstan (+7)'                    => '+7',
        'Kenya (+254)'                       => '+254',
        'Kiribati (+686)'                    => '+686',
        'Korea - North (+850)'               => '+850',
        'Korea - South (+82)'                => '+82',
        'Kuwait (+965)'                      => '+965',
        'Kyrgyzstan (+996)'                  => '+996',
        'Laos (+856)'                        => '+856',
        'Latvia (+371)'                      => '+371',
        'Lebanon (+961)'                     => '+961',
        'Lesotho (+266)'                     => '+266',
        'Liberia (+231)'                     => '+231',
        'Libya (+218)'                       => '+218',
        'Liechtenstein (+417)'               => '+417',
        'Lithuania (+370)'                   => '+370',
        'Luxembourg (+352)'                  => '+352',
        'Macao (+853)'                       => '+853',
        'Macedonia (+389)'                   => '+389',
        'Madagascar (+261)'                  => '+261',
        'Malawi (+265)'                      => '+265',
        'Malaysia (+60)'                     => '+60',
        'Maldives (+960)'                    => '+960',
        'Mali (+223)'                        => '+223',
        'Malta (+356)'                       => '+356',
        'Marshall Islands (+692)'            => '+692',
        'Martinique (+596)'                  => '+596',
        'Mauritania (+222)'                  => '+222',
        'Mayotte (+269)'                     => '+269',
        'Mexico (+52)'                       => '+52',
        'Micronesia (+691)'                  => '+691',
        'Moldova (+373)'                     => '+373',
        'Monaco (+377)'                      => '+377',
        'Mongolia (+976)'                    => '+976',
        'Montserrat (+1664)'                 => '+1664',
        'Morocco (+212)'                     => '+212',
        'Mozambique (+258)'                  => '+258',
        'Myanmar (+95)'                      => '+95',
        'Namibia (+264)'                     => '+264',
        'Nauru (+674)'                       => '+674',
        'Nepal (+977)'                       => '+977',
        'Netherlands (+31)'                  => '+31',
        'New Caledonia (+687)'               => '+687',
        'New Zealand (+64)'                  => '+64',
        'Nicaragua (+505)'                   => '+505',
        'Niger (+227)'                       => '+227',
        'Nigeria (+234)'                     => '+234',
        'Niue (+683)'                        => '+683',
        'Norfolk Islands (+672)'             => '+672',
        'Northern Marianas (+670)'           => '+670',
        'Norway (+47)'                       => '+47',
        'Oman (+968)'                        => '+968',
        'Pakistan (+92)'                     => '+92',
        'Palau (+680)'                       => '+680',
        'Panama (+507)'                      => '+507',
        'Papua New Guinea (+675)'            => '+675',
        'Paraguay (+595)'                    => '+595',
        'Peru (+51)'                         => '+51',
        'Philippines (+63)'                  => '+63',
        'Poland (+48)'                       => '+48',
        'Portugal (+351)'                    => '+351',
        'Puerto Rico (+1787)'                => '+1787',
        'Qatar (+974)'                       => '+974',
        'Reunion (+262)'                     => '+262',
        'Romania (+40)'                      => '+40',
        'Russia (+7)'                        => '+7',
        'Rwanda (+250)'                      => '+250',
        'San Marino (+378)'                  => '+378',
        'Sao Tome &amp; Principe (+239)'     => '+239',
        'Saudi Arabia (+966)'                => '+966',
        'Senegal (+221)'                     => '+221',
        'Serbia (+381)'                      => '+381',
        'Seychelles (+248)'                  => '+248',
        'Sierra Leone (+232)'                => '+232',
        'Singapore (+65)'                    => '+65',
        'Slovak Republic (+421)'             => '+421',
        'Slovenia (+386)'                    => '+386',
        'Solomon Islands (+677)'             => '+677',
        'Somalia (+252)'                     => '+252',
        'South Africa (+27)'                 => '+27',
        'Spain (+34)'                        => '+34',
        'Sri Lanka (+94)'                    => '+94',
        'St. Helena (+290)'                  => '+290',
        'St. Kitts (+1869)'                  => '+1869',
        'St. Lucia (+1758)'                  => '+1758',
        'Suriname (+597)'                    => '+597',
        'Sudan (+249)'                       => '+249',
        'Swaziland (+268)'                   => '+268',
        'Sweden (+46)'                       => '+46',
        'Switzerland (+41)'                  => '+41',
        'Syria (+963)'                       => '+963',
        'Taiwan (+886)'                      => '+886',
        'Tajikistan (+992)'                  => '+992',
        'Thailand (+66)'                     => '+66',
        'Togo (+228)'                        => '+228',
        'Tonga (+676)'                       => '+676',
        'Trinidad &amp; Tobago (+1868)'      => '+1868',
        'Tunisia (+216)'                     => '+216',
        'Turkey (+90)'                       => '+90',
        'Turkmenistan (+993)'                => '+993',
        'Turks &amp; Caicos Islands (+1649)' => '+1649',
        'Tuvalu (+688)'                      => '+688',
        'Uganda (+256)'                      => '+256',
        'Ukraine (+380)'                     => '+380',
        'United Arab Emirates (+971)'        => '+971',
        'Uruguay (+598)'                     => '+598',
        'Uzbekistan (+998)'                  => '+998',
        'Vanuatu (+678)'                     => '+678',
        'Vatican City (+379)'                => '+379',
        'Venezuela (+58)'                    => '+58',
        'Vietnam (+84)'                      => '+84',
        'Virgin Islands - British (+1)'      => '+1',
        'Virgin Islands - US (+1)'           => '+1',
        'Wallis &amp; Futuna (+681)'         => '+681',
        'Yemen (North)(+969)'                => '+969',
        'Yemen (South)(+967)'                => '+967',
        'Zambia (+260)'                      => '+260',
        'Zimbabwe (+263)'                    => '+263',
    ];
}

// Truncate a string only at a whitespace
function truncate($text, $length, $withTail = true)
{
    $length = abs((int)$length);
    if (strlen($text) > $length) {
        $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", ($withTail ? '\\1 ...' : '\\1'), $text);
    }

    return ($text);
}


/**
 * @param null $page => Setting::$pagesSeoMetas
 *
 * @return array [title, description]
 */
function getSeoMetas($page = null)
{
    return App\Models\Setting::getSeoMetas($page);
}

/**
 * @return array [title, image, link]
 */
function getSocials()
{
    return App\Models\Setting::getSocials();
}

/**
 * @return array [title, items => [title, link]]
 */
function getFooterColumns()
{
    return App\Models\Setting::getFooterColumns();
}


/*
 * @return array [site_name, site_email, site_phone, site_language, register_method, user_languages, rtl_languages, fav_icon, locale, logo, footer_logo, rtl_layout, home hero1 is active, home hero2 is active, content_translate, default_time_zone, date_format, time_format]
 */
function getGeneralSettings($key = null)
{
    return App\Models\Setting::getGeneralSettings($key);
}

/**
 * @param null $key
 * $key => "agora_resolution" | "agora_max_bitrate" | "agora_min_bitrate" | "agora_frame_rate" | "agora_live_streaming" | "agora_chat" | "agora_cloud_rec" | "agora_in_free_courses"
 * "new_interactive_file" | "timezone_in_register" | "timezone_in_create_webinar"
 * "sequence_content_status" | "webinar_assignment_status" | "webinar_private_content_status" | "disable_view_content_after_user_register"
 * "direct_classes_payment_button_status" | "mobile_app_status" | "cookie_settings_status" | "show_other_register_method" | "show_certificate_additional_in_register"
 *
 * @return
 * */
function getFeaturesSettings($key = null)
{
    return App\Models\Setting::getFeaturesSettings($key);
}

/**
 * @param null $key
 * $key => cookie_settings_modal_message | cookie_settings_modal_items
 *
 * @return
 * */
function getCookieSettings($key = null)
{
    return App\Models\Setting::getCookieSettings($key);
}


/**
 * @param $key
 *
 * @return array|[commission, tax, minimum_payout, currency, currency_position, price_display]
 */
function getFinancialSettings($key = null)
{
    return App\Models\Setting::getFinancialSettings($key);
}

function getFinancialCurrencySettings($key = null)
{
    return App\Models\Setting::getFinancialCurrencySettings($key);
}


/**
 * @param string $section => 2 for hero section 2
 *
 * @return array|[title, description, hero_background]
 */
function getHomeHeroSettings($section = '1')
{
    return App\Models\Setting::getHomeHeroSettings($section);
}

/**
 * @return array|[title, description, background]
 */
function getHomeVideoOrImageBoxSettings()
{
    return App\Models\Setting::getHomeVideoOrImageBoxSettings();
}


/**
 * @param null $page => admin_login, admin_dashboard, login, register, remember_pass, search, categories,
 * become_instructor, certificate_validation, blog, instructors
 * ,dashboard, panel_sidebar, user_avatar, user_cover, instructor_finder_wizard, products_lists
 *
 * @return string|array => [all pages]
 */
function getPageBackgroundSettings($page = null)
{
    return App\Models\Setting::getPageBackgroundSettings($page);
}


/**
 * @param null $key => css, js
 *
 * @return string|array => {css, js}
 */
function getCustomCssAndJs($key = null)
{
    return App\Models\Setting::getCustomCssAndJs($key);
}

/**
 * @return array
 */
function getOfflineBankSettings($key = null)
{
    return App\Models\Setting::getOfflineBankSettings($key);
}

/**
 * @return array [status, users_affiliate_status, affiliate_user_commission, affiliate_user_amount, referred_user_amount, referral_description]
 */
function getReferralSettings()
{
    $settings = App\Models\Setting::getReferralSettings();

    if (empty($settings['status'])) {
        $settings['status'] = false;
    } else {
        $settings['status'] = true;
    }

    if (empty($settings['users_affiliate_status'])) {
        $settings['users_affiliate_status'] = false;
    } else {
        $settings['users_affiliate_status'] = true;
    }

    if (empty($settings['affiliate_user_commission'])) {
        $settings['affiliate_user_commission'] = 0;
    }

    if (empty($settings['affiliate_user_amount'])) {
        $settings['affiliate_user_amount'] = 0;
    }

    if (empty($settings['referred_user_amount'])) {
        $settings['referred_user_amount'] = 0;
    }

    if (empty($settings['referral_description'])) {
        $settings['referral_description'] = '';
    }

    return $settings;
}

/**
 * @return array
 */
function getOfflineBanksTitle()
{
    $titles = [];

    $banks = getOfflineBankSettings();

    if (!empty($banks) and count($banks)) {
        foreach ($banks as $bank) {
            $titles[] = $bank['title'];
        }
    }

    return $titles;
}

/**
 * @return array
 */
function getReportReasons()
{
    return App\Models\Setting::getReportReasons();
}

/**
 * @param $template {String|nullable}
 *
 * @return array
 */
function getNotificationTemplates($template = null)
{
    return App\Models\Setting::getNotificationTemplates($template);
}

/**
 * @param $key
 *
 * @return array
 */
function getContactPageSettings($key = null)
{
    return App\Models\Setting::getContactPageSettings($key);
}

/**
 * @param $key
 *
 * @return array
 */
function get404ErrorPageSettings($key = null)
{
    return App\Models\Setting::get404ErrorPageSettings($key);
}

/**
 * @param $key
 *
 * @return array
 */
function getHomeSectionsSettings($key = null)
{
    return App\Models\Setting::getHomeSectionsSettings($key);
}

/**
 * @param $key
 *
 * @return array
 */
function getNavbarLinks()
{
    $links = App\Models\Setting::getNavbarLinksSettings();

    if (!empty($links)) {
        usort($links, function ($item1, $item2) {
            return $item1['order'] <=> $item2['order'];
        });
    }

    return $links;
}

/**
 * @return array
 */
function getPanelSidebarSettings()
{
    return App\Models\Setting::getPanelSidebarSettings();
}


/**
 * @return array
 */
function getFindInstructorsSettings()
{
    return App\Models\Setting::getFindInstructorsSettings();
}

/**
 * @return array
 */
function getRewardProgramSettings()
{
    return App\Models\Setting::getRewardProgramSettings();
}

/**
 * @return array
 */
function getRewardsSettings()
{
    return App\Models\Setting::getRewardsSettings();
}

/**
 * @param $kay => [status, virtual_product_commission, physical_product_commission, store_tax,
 *                 possibility_create_virtual_product, possibility_create_physical_product,
 *                 shipping_tracking_url, activate_comments
 *              ]
 */
function getStoreSettings($key = null)
{
    return App\Models\Setting::getStoreSettings($key);
}

function getBecomeInstructorSectionSettings()
{
    return App\Models\Setting::getBecomeInstructorSectionSettings();
}

function getForumSectionSettings()
{
    return App\Models\Setting::getForumSectionSettings();
}

function getRegistrationPackagesGeneralSettings($key = null)
{
    return App\Models\Setting::getRegistrationPackagesGeneralSettings($key);
}

function getRegistrationPackagesInstructorsSettings($key = null)
{
    return App\Models\Setting::getRegistrationPackagesInstructorsSettings($key);
}

function getRegistrationPackagesOrganizationsSettings($key = null)
{
    return App\Models\Setting::getRegistrationPackagesOrganizationsSettings($key);
}

function getMobileAppSettings($key = null)
{
    return App\Models\Setting::getMobileAppSettings($key);
}

function getMaintenanceSettings($key = null)
{
    return App\Models\Setting::getMaintenanceSettings($key);
}

function getGeneralOptionsSettings($key = null)
{
    return App\Models\Setting::getGeneralOptionsSettings($key);
}

function getGiftsGeneralSettings($key = null)
{
    return App\Models\Setting::getGiftsGeneralSettings($key);
}

function getRemindersSettings($key = null)
{
    return App\Models\Setting::getRemindersSettings($key);
}

function getGeneralSecuritySettings($key = null)
{
    return App\Models\Setting::getGeneralSecuritySettings($key);
}


function getAdminPanelUrlPrefix()
{
    $prefix = getGeneralSecuritySettings('admin_panel_url');
    return !empty($prefix) ? $prefix : 'admin';
}

function getAdminPanelUrl($url = null, $withFirstSlash = true)
{
    return ($withFirstSlash ? '/' : '') . getAdminPanelUrlPrefix() . ($url ?? '');
}

function getAdvertisingModalSettings()
{
    $cookieKey = 'show_advertise_modal';
    $settings = App\Models\Setting::getAdvertisingModalSettings();

    $show = false;

    if (!empty($settings) and !empty($settings['status']) and $settings['status'] == 1) {
        $checkCookie = Cookie::get($cookieKey);

        if (empty($checkCookie)) {
            $show = true;

            Cookie::queue($cookieKey, 1, 30 * 24 * 60);
        }
    }

    return $show ? $settings : null;
}

function getOthersPersonalizationSettings($key = null)
{
    return \App\Models\Setting::getOthersPersonalizationSettings($key);
}

function getInstallmentsSettings($key = null)
{
    return \App\Models\Setting::getInstallmentsSettings($key);
}

function getInstallmentsTermsSettings($key = null)
{
    return \App\Models\Setting::getInstallmentsTermsSettings($key);
}

function getRegistrationBonusSettings($key = null)
{
    return \App\Models\Setting::getRegistrationBonusSettings($key);
}

function getRegistrationBonusTermsSettings($key = null)
{
    return \App\Models\Setting::getRegistrationBonusTermsSettings($key);
}

function getStatisticsSettings($key = null)
{
    return \App\Models\Setting::getStatisticsSettings($key);
}

/**
 * @return string ("primary_color"|"secondary_color") || null
 * */
function getThemeColorsSettings($admin = false)
{
    $settings = App\Models\Setting::getThemeColorsSettings();

    $result = '';

    if (!empty($settings) and count($settings)) {
        $result = ":root{" . PHP_EOL;

        if ($admin) {
            foreach (\App\Models\Setting::$rootAdminColors as $color) {
                if (!empty($settings['admin_' . $color])) {
                    $result .= "--$color:" . $settings['admin_' . $color] . ';' . PHP_EOL;
                }
            }
        } else {
            foreach (\App\Models\Setting::$rootColors as $color) {
                if (!empty($settings[$color])) {
                    $result .= "--$color:" . $settings[$color] . ';' . PHP_EOL;
                }
            }
        }

        $result .= "}" . PHP_EOL;
    }

    return $result;
}


/**
 * @return string ("primary_color"|"secondary_color") || null
 * */
function getThemeFontsSettings()
{
    $settings = App\Models\Setting::getThemeFontsSettings();

    $result = '';

    if (!empty($settings) and count($settings)) {

        foreach ($settings as $type => $setting) {

            if (!empty($settings[$type]['regular'])) {
                $result .= "@font-face {
                      font-family: '$type-font-family';
                      font-style: normal;
                      font-weight: 400;
                      font-display: swap;
                      src: url({$settings[$type]['regular']}) format('woff2');
                    }";
            }

            if (!empty($settings[$type]['bold'])) {
                $result .= "@font-face {
                      font-family: '$type-font-family';
                      font-style: normal;
                      font-weight: bold;
                      font-display: swap;
                      src: url({$settings[$type]['bold']}) format('woff2');
                    }";
            }

            if (!empty($settings[$type]['medium'])) {
                $result .= "@font-face {
                      font-family: '$type-font-family';
                      font-style: normal;
                      font-weight: 500;
                      font-display: swap;
                      src: url({$settings[$type]['medium']}) format('woff2');
                    }";
            }

        }
    }

    return $result;
}

/**
 * @param $page => home, search, classes, categories, login, register, contact, blog, certificate_validation, 'instructors', 'organizations'
 *
 * @return string
 * */
function getPageRobot($page)
{
    $seoSettings = getSeoMetas($page);

    return (empty($seoSettings['robot']) or $seoSettings['robot'] != 'noindex') ? 'index, follow, all' : 'NOODP, nofollow, noindex';
}

function getPageRobotNoIndex()
{
    return 'NOODP, nofollow, noindex';
}

function getDefaultLocale()
{
    $key = 'site_language';
    $name = \App\Models\Setting::$generalName;

    /// I did not use the helper method because the Setting model uses translation and may get stuck in the loop.

    $setting = cache()->remember('settings.getDefaultLocale', 24 * 60 * 60, function () use ($name) {
        $setting = \Illuminate\Support\Facades\DB::table('settings')
            ->where('page', $name)
            ->where('name', $name)
            ->join('setting_translations', 'settings.id', '=', 'setting_translations.setting_id')
            ->select('settings.*', 'setting_translations.value')
            ->first();

        $value = [];

        if (!empty($setting) and !empty($setting->value) and isset($setting->value)) {
            $value = json_decode($setting->value, true);
        }

        return $value;
    });

    $siteLanguage = 'EN';

    if (!empty($setting)) {
        if (!empty($setting[$key])) {
            $siteLanguage = $setting[$key];
        }
    }

    return $siteLanguage;
}

function deepClone($object)
{
    $cloned = clone($object);
    foreach ($cloned as $key => $val) {
        if (is_object($val) || (is_array($val))) {
            $cloned->{$key} = unserialize(serialize($val));
        }
    }

    return $cloned;
}

function sendNotification($template, $options, $user_id = null, $group_id = null, $sender = 'system', $type = 'single')
{
    $templateId = getNotificationTemplates($template);
    $notificationTemplate = \App\Models\NotificationTemplate::where('id', $templateId)->first();

    if (!empty($notificationTemplate)) {
        $title = str_replace(array_keys($options), array_values($options), $notificationTemplate->title);
        $message = str_replace(array_keys($options), array_values($options), $notificationTemplate->template);

        $check = \App\Models\Notification::where('user_id', $user_id)
            ->where('group_id', $group_id)
            ->where('title', $title)
            ->where('message', $message)
            ->where('sender', $sender)
            ->where('type', $type)
            ->first();

        $ignoreDuplicateTemplates = [
            'new_badge',
            'registration_package_expired'
        ];

        if (empty($check) or !in_array($template, $ignoreDuplicateTemplates)) {
            \App\Models\Notification::create([
                'user_id'    => $user_id,
                'group_id'   => $group_id,
                'title'      => $title,
                'message'    => $message,
                'sender'     => $sender,
                'type'       => $type,
                'created_at' => time()
            ]);

            if (env('APP_ENV') == 'production') {
                $user = \App\User::where('id', $user_id)->first();
                if (!empty($user) and !empty($user->email)) {
                    try {
                        \Mail::to($user->email)->send(new \App\Mail\SendNotifications([
                            'title'   => $title,
                            'message' => $message
                        ]));
                    } catch (Exception $exception) {
                        // dd($exception)
                    }
                }
            }
        }

        return true;
    }

    return false;
}

function sendNotificationToEmail($template, $options, $email)
{
    $templateId = getNotificationTemplates($template);
    $notificationTemplate = \App\Models\NotificationTemplate::where('id', $templateId)->first();

    if (!empty($notificationTemplate)) {
        $title = str_replace(array_keys($options), array_values($options), $notificationTemplate->title);
        $message = str_replace(array_keys($options), array_values($options), $notificationTemplate->template);


        if (env('APP_ENV') == 'production') {
            try {
                \Mail::to($email)->send(new \App\Mail\SendNotifications([
                    'title'   => $title,
                    'message' => $message
                ]));
            } catch (Exception $exception) {
                // dd($exception)
            }
        }

        return true;
    }

    return false;
}

function time2string($time)
{
    $_d = 0;
    $_h = 0;
    $_m = 0;
    $_s = 1;

    if ($time > 0) {
        $d = floor($time / 86400);
        $_d = ($d < 10 ? '0' : '') . $d;

        $h = floor(($time - $d * 86400) / 3600);
        $_h = ($h < 10 ? '0' : '') . $h;

        $m = floor(($time - ($d * 86400 + $h * 3600)) / 60);
        $_m = ($m < 10 ? '0' : '') . $m;

        $s = $time - ($d * 86400 + $h * 3600 + $m * 60);
        $_s = ($s < 10 ? '0' : '') . $s;
    }

    return [
        'day'    => $_d,
        'hour'   => $_h,
        'minute' => $_m,
        'second' => $_s
    ];
}

$months = [
    1  => 'Jan.',
    2  => 'Feb.',
    3  => 'Mar.',
    4  => 'Apr.',
    5  => 'May',
    6  => 'Jun.',
    7  => 'Jul.',
    8  => 'Aug.',
    9  => 'Sep.',
    10 => 'Oct.',
    11 => 'Nov.',
    12 => 'Dec.'
];

function fromAndToDateFilter($from, $to, $query, $column = 'created_at', $strToTime = true)
{
    if (!empty($from) and !empty($to)) {
        $from = $strToTime ? strtotime($from) : $from;
        $to = $strToTime ? strtotime($to) : $to;

        $query->whereBetween($column, [
            $from,
            $to
        ]);
    } else {
        if (!empty($from)) {
            $from = $strToTime ? strtotime($from) : $from;

            $query->where($column, '>=', $from);
        }

        if (!empty($to)) {
            $to = $strToTime ? strtotime($to) : $to;

            $query->where($column, '<', $to);
        }
    }

    return $query;
}

function random_str($length, $includeNumeric = true, $includeChar = true)
{
    $keyspace = ($includeNumeric ? '0123456789' : '') . ($includeChar ? 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' : '');
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;

    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[rand(0, $max)];
    }

    return ($includeNumeric and !$includeChar) ? (int)$str : $str;
}

function checkCourseForSale($course, $user)
{
    if (!$course->canSale()) {
        $toastData = [
            'title'  => trans('public.request_failed'),
            'msg'    => trans('cart.course_not_capacity'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    if ($course->checkUserHasBought($user)) {
        $toastData = [
            'title'  => trans('cart.fail_purchase'),
            'msg'    => trans('site.you_bought_webinar'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    if ($course->creator_id == $user->id or $course->teacher_id == $user->id) {
        $toastData = [
            'title'  => trans('public.request_failed'),
            'msg'    => trans('cart.cant_purchase_your_course'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    $isRequiredPrerequisite = false;
    if (!empty($course->prerequisites)) {
        $prerequisites = $course->prerequisites;
        if (count($prerequisites)) {
            foreach ($prerequisites as $prerequisite) {
                $prerequisiteWebinar = $prerequisite->prerequisiteWebinar;

                if ($prerequisite->required and !empty($prerequisiteWebinar) and !$prerequisiteWebinar->checkUserHasBought()) {
                    $isRequiredPrerequisite = true;
                }
            }
        }
    }

    if ($isRequiredPrerequisite) {
        $toastData = [
            'title'  => trans('public.request_failed'),
            'msg'    => trans('cart.this_course_has_required_prerequisite'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    return 'ok';
}

function checkProductForSale($product, $user)
{
    if ($product->getAvailability() < 1) {
        $toastData = [
            'title'  => trans('public.request_failed'),
            'msg'    => trans('update.product_not_availability'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    if ($product->creator_id == $user->id) {
        $toastData = [
            'title'  => trans('public.request_failed'),
            'msg'    => trans('update.cant_purchase_your_product'),
            'status' => 'error'
        ];
        return back()->with(['toast' => $toastData]);
    }

    return 'ok';
}

function isAdminUrl($url = null)
{
    if (empty($url)) {
        $url = request()->getPathInfo();
    }
    return (1 === strpos($url, 'admin'));
}

function getTranslateAttributeValue($model, $key, $loca = null)
{
    $isAdminUrl = isAdminUrl();

    $locale = app()->getLocale();
    $contentLocale = $isAdminUrl ? getContentLocale() : null; // for admin edit contents

    $isEditModel = ($isAdminUrl and !empty($contentLocale) and is_array($contentLocale) and $contentLocale['table'] == $model->getTable() and $contentLocale['item_id'] == $model->id);

    if ($isAdminUrl and
        !empty($contentLocale) and
        is_array($contentLocale) and
        (
            ($contentLocale['table'] == $model->getTable() and $contentLocale['item_id'] == $model->id) or
            (
                (!empty($model->parent_id) and $contentLocale['item_id'] == $model->parent_id) or // for category edit page
                (!empty($model->filter_id) and $contentLocale['item_id'] == $model->filter_id) // for filter edit page
            )
        )
    ) {
        $locale = $contentLocale['locale']; // for admin edit contents
    }

    try {
        $locale = !empty($loca) ? $loca : $locale;

        if ($model->getTable() === 'settings' and in_array($model->name, \App\Models\Setting::getSettingsWithDefaultLocal())) {
            $locale = \App\Models\Setting::$defaultSettingsLocale;
        }

        $model->locale = $locale;

        return $model->translate(mb_strtolower($locale))->{$key};
    } catch (\Exception $e) {
        // this conditions get client side

        if (empty($contentLocale) and empty($loca)) { //  first get translate by site default language
            $defaultLocale = getDefaultLocale();

            return getTranslateAttributeValue($model, $key, $defaultLocale);
        } elseif ((!empty($loca) or !$isEditModel) and $loca != 'en' and !empty($model->translations) and count($model->translations)) { // if not translate by site default language get translate by English language
            return getTranslateAttributeValue($model, $key, 'en');
        } else if ((!empty($loca) or !$isEditModel) and !empty($model->translations) and count($model->translations)) { // if not default and English get translate by first locale
            $translations = $model->translations->first();

            return getTranslateAttributeValue($model, $key, $translations->locale);
        }

        return '';
    }
}

function getContentLocale()
{
    return session()->get('edit_content_locale', null);
}

function storeContentLocale($locale, $table, $item_id)
{
    removeContentLocale();

    $data = [
        'locale'  => $locale,
        'table'   => $table,
        'item_id' => $item_id
    ];

    session()->put('edit_content_locale', $data);
}

function removeContentLocale()
{
    session()->remove('edit_content_locale');
}

function getAgoraResolutions(): array
{
    return [
        '160_120',
        '120_120',
        '320_180',
        '180_180',
        '240_180',
        '320_240',
        '240_240',
        '424_240',
        '640_360',
        '360_360',
        '640_360',
        '360_360',
        '480_360',
        '480_360',
        '640_480',
        '480_480',
        '640_480',
        '480_480',
        '848_480',
        '848_480',
        '640_480',
        '1280_720',
        '1280_720',
        '960_720',
        '960_720',
        '1920_1080',
        '1920_1080',
        '1920_1080'
    ];
}


function getUserCurrencyItem($user = null)
{
    $multiCurrency = new MultiCurrency();
    $currencies = $multiCurrency->getCurrencies();
    $userCurrency = currency($user);

    foreach ($currencies as $currencyItem) {
        if ($currencyItem->currency == $userCurrency) {
            return $currencyItem;
        }
    }

    return $multiCurrency->getDefaultCurrency();
}

function curformat($amount)
{
    // (A1) SPLIT WHOLE & DECIMALS
    $amount = explode(".", $amount);
    $whole = $amount[0];
    $decimal = isset($amount[1]) ? $amount[1] : "";

    // (A2) ADD THOUSAND SEPARATORS
    if (strlen($whole) > 3) {
        $temp = "";
        $j = 0;
        for ($i = strlen($whole) - 1; $i >= 0; $i--) {
            $temp = $whole[$i] . $temp;
            $j++;
            if ($j % 3 == 0 && $i != 0) {
                $temp = "," . $temp;
            }
        }
        $whole = $temp;
    }

    // (A3) RESULT
    return "\$$whole.$decimal";
}

function handlePriceFormat($price, $decimals = 0, $decimal_separator = '.', $thousands_separator = ''): string
{
    if ($price and $price > 0) {
        $format = number_format($price, $decimals, $decimal_separator, $thousands_separator);

        $str = "{$decimal_separator}";
        $i = 0;
        while ($i < $decimals) {
            $i += 1;
            $str .= "0";
        }

        return str_replace($str, "", $format);
    }

    $price = is_null($price)? 0 : $price;
    return $price;
}

function handlePrice($price, $showCurrency = true, $format = true, $coursePagePrice = false, $user = null, $showTaxInPrice = false)
{
    $userCurrencyItem = getUserCurrencyItem($user);
    $priceDisplay = getFinancialSettings('price_display') ?? 'only_price';

    $decimal = $userCurrencyItem->currency_decimal ?? 1;
    $decimalSeparator = $userCurrencyItem->currency_separator == "dot" ? '.' : ',';
    $thousandsSeparator = $userCurrencyItem->currency_separator == "dot" ? "," : ".";

    $price = convertPriceToUserCurrency($price, $userCurrencyItem);

    if ($priceDisplay != 'only_price') {
        $tax = getFinancialSettings('tax') ?? 0;
        $tax = convertPriceToUserCurrency($tax, $userCurrencyItem);

        if ($tax > 0) {
            $taxPrice = $price * $tax / 100;

            if ($priceDisplay == 'total_price') {
                $price = $price + $taxPrice;

                if ($format) {
                    $price = handlePriceFormat($price, $decimal, $decimalSeparator, $thousandsSeparator);
                }
            } elseif ($priceDisplay == 'price_and_tax') {
                if ($coursePagePrice) {
                    return [
                        'price' => $price,
                        'tax'   => $taxPrice
                    ];
                }

                if ($format) {
                    $price = handlePriceFormat($price, $decimal, $decimalSeparator, $thousandsSeparator);
                    $taxPrice = handlePriceFormat($taxPrice, $decimal, $decimalSeparator, $thousandsSeparator);
                }

                if ($showCurrency) {
                    $price = addCurrencyToPrice($price, $userCurrencyItem);
                    $taxPrice = addCurrencyToPrice($taxPrice, $userCurrencyItem);
                }

                $price = $price . ($showTaxInPrice ? ('+' . $taxPrice . ' ' . trans('cart.tax')) : '');
            }
        }
    } elseif ($format) {
        $price = handlePriceFormat($price, $decimal, $decimalSeparator, $thousandsSeparator);
    }

    if ($coursePagePrice) {
        return [
            'price' => $price,
            'tax'   => 0
        ];
    }

    if ($showCurrency and $priceDisplay != 'price_and_tax') {
        $price = addCurrencyToPrice($price, $userCurrencyItem);
    }

    return $price;
}

function convertPriceToUserCurrency($price, $userCurrencyItem = null)
{
    if (empty($userCurrencyItem)) {
        $userCurrencyItem = getUserCurrencyItem();
    }

    $exchangeRate = (!empty($userCurrencyItem) and $userCurrencyItem->exchange_rate) ? $userCurrencyItem->exchange_rate : 0;

    if ($exchangeRate > 0) {
        return $price * $exchangeRate;
    }

    return $price;
}

function convertPriceToDefaultCurrency($price, $userCurrencyItem = null)
{
    if (empty($userCurrencyItem)) {
        $userCurrencyItem = getUserCurrencyItem();
    }

    $exchangeRate = (!empty($userCurrencyItem) and $userCurrencyItem->exchange_rate) ? $userCurrencyItem->exchange_rate : 0;

    if ($exchangeRate > 0) {
        return $price / $exchangeRate;
    }

    return $price;
}

function addCurrencyToPrice($price, $userCurrencyItem = null, $currecty_type = '')
{
    if (empty($userCurrencyItem)) {
        $userCurrencyItem = getUserCurrencyItem();
    }


    if (!empty($price)) {
        $currency = currencySign($userCurrencyItem->currency);
        $currencyPosition = $userCurrencyItem->currency_position;

        if( $currecty_type  == 'currency_small'){
            $currency  = '<small>'.$currency.'</small>';
        }

        switch ($currencyPosition) {
            case 'left':
                $price = $currency . $price;
                break;

            case 'left_with_space':
                $price = $currency . ' ' . $price;
                break;

            case 'right':
                $price = $price . $currency;
                break;

            case 'right_with_space':
                $price = $price . ' ' . $currency;
                break;

            default:
                $price = $currency . $price;
        }
    }

    return $price;
}

/**
 * This text is for the course details page only and should not be used elsewhere. Use the "handlePrice" method for other places.
 * */
function handleCoursePagePrice($price)
{
    $result = handlePrice($price, true, true, true);

    $price = addCurrencyToPrice($result['price']);

    $tax = !empty($result['tax']) ? addCurrencyToPrice($result['tax']) : 0;

    return [
        'price' => $price,
        'tax'   => $tax,
    ];
}


function checkShowCookieSecurityDialog()
{
    $show = false;

    if (getFeaturesSettings('cookie_settings_status')) {

        if (auth()->check()) {
            $checkDB = \App\Models\UserCookieSecurity::where('user_id', auth()->id())
                ->first();

            $show = empty($checkDB);
        } else {
            $checkCookie = Cookie::get('cookie-security');

            $show = empty($checkCookie);
        }
    }

    return $show;
}

function getNavbarButton($roleId = null, $forGuest = false)
{
    return \App\Models\NavbarButton::where('role_id', $roleId)
        ->where('for_guest', $forGuest)
        ->first();
}


function esc_html($data)
{
    return $data;
}

function esc_html__($data)
{
    return $data;
}


function toolbar_tools()
{
    $toolbar_tools = array(
        'columns'            => array(
            'title'   => esc_html__('Column layout', 'leform'),
            'icon'    => 'fas fa-columns',
            'options' => array(
                '1' => esc_html__('1 column', 'leform'),
                '2' => esc_html__('2 columns', 'leform'),
                '3' => esc_html__('3 columns', 'leform'),
                '4' => esc_html__('4 columns', 'leform'),
                '6' => esc_html__('6 columns', 'leform')
            ),
            'type'    => 'other'
        ),
        'question_templates' => array(
            'title'   => esc_html__('Questions Templates', 'leform'),
            'icon'    => 'fas fa-layer-group',
            'options' => array(
                'multichoice_template' => esc_html__('<img src="/store/1/tool-images/d1.png" alt=""> Multiple Choice', 'leform'),
                'multiresponse_template' => esc_html__('<img src="/store/1/tool-images/d2.png" alt=""> Multiple Response', 'leform'),
                '3' => esc_html__('<img src="/store/1/tool-images/d3.png" alt=""> True/False', 'leform'),
                '4' => esc_html__('<img src="/store/1/tool-images/d4.png" alt=""> Short Answer', 'leform'),
                '5' => esc_html__('<img src="/store/1/tool-images/d5.png" alt=""> Numeric', 'leform'),
                '6' => esc_html__('<img src="/store/1/tool-images/d6.png" alt=""> Sequence', 'leform'),
                '7' => esc_html__('<img src="/store/1/tool-images/d7.png" alt=""> Matching', 'leform'),
                '8' => esc_html__('<img src="/store/1/tool-images/d8.png" alt=""> Fill in the Blanks', 'leform'),
                '9' => esc_html__('<img src="/store/1/tool-images/d9.png" alt=""> Select from Lists', 'leform'),
                '10' => esc_html__('<img src="/store/1/tool-images/d10.png" alt=""> Drag the Words', 'leform'),
                '11' => esc_html__('<img src="/store/1/tool-images/d11.png" alt=""> Hotspot', 'leform'),
                '12' => esc_html__('<img src="/store/1/tool-images/d12.png" alt=""> Drag and Drop', 'leform'),
                '13' => esc_html__('<img src="/store/1/tool-images/d13.png" alt=""> Likert Scale', 'leform'),
                '14' => esc_html__('<img src="/store/1/tool-images/d14.png" alt=""> Essay', 'leform'),
            ),
            'type'    => 'other'
        ),
        'html'               => array(
            'title' => esc_html__('HTML', 'leform'),
            'icon'  => 'fas fa-code',
            'type'  => 'other'
        ),
        'multichoice_template'  => array(
            'title' => esc_html__('SUM Q', 'leform'),
            'icon'  => 'fa fa-plus',
            'classes' => 'rurera-hide',
            'type'  => 'other'
        ),
        'multiresponse_template'  => array(
            'title' => esc_html__('SUM Q', 'leform'),
            'icon'  => 'fa fa-plus',
            'classes' => 'rurera-hide',
            'type'  => 'other'
        ),
        'sum_quiz'           => array(
            'title' => esc_html__('SUM Q', 'leform'),
            'icon'  => 'fa fa-plus',
            'type'  => 'other'
        ),
        'sqroot_quiz'        => array(
            'title' => esc_html__('Sqroot', 'leform'),
            'icon'  => 'fas fa-square-root-alt',
            'type'  => 'other'
        ),
        'image_quiz_draggable'         => array(
            'title' => esc_html__('Draggable Image', 'leform'),
            'icon'  => 'fas fa-image',
            'type'  => 'other'
        ),
        'image_quiz'         => array(
            'title' => esc_html__('Image', 'leform'),
            'icon'  => 'fas fa-image',
            'type'  => 'other'
        ),
        'heading_quiz'     => array(
            'title' => esc_html__('Text', 'leform'),
            'icon'  => 'fas fa-heading',
            'type'  => 'other'
        ),
        'paragraph_quiz'     => array(
            'title' => esc_html__('Text', 'leform'),
            'icon'  => 'fas fa-paragraph',
            'type'  => 'other'
        ),
        'textareafield_quiz'     => array(
            'title' => esc_html__('Textarea Field', 'leform'),
            'icon'  => 'fas fa-edit',
            'type'  => 'other'
        ),
        'textfield_quiz'     => array(
            'title' => esc_html__('Text Input Field', 'leform'),
            'icon'  => 'fas fa-i-cursor',
            'type'  => 'other'
        ),
        'truefalse_quiz'     => array(
            'title' => esc_html__('True/False Field', 'leform'),
            'icon'  => 'fas fa-i-cursor',
            'type'  => 'other'
        ),
        'attachment_quiz'     => array(
            'title' => esc_html__('Attachment', 'leform'),
            'icon'  => 'fas fa-paperclip',
            'type'  => 'other'
        ),
        'checkbox'           => array(
            'title' => esc_html__('Checkbox', 'leform'),
            'icon'  => 'far fa-check-square',
            'type'  => 'input'
        ),
        'radio'              => array(
            'title' => esc_html__('Radio Button', 'leform'),
            'icon'  => 'far fa-dot-circle',
            'type'  => 'input'
        ),
        'sortable_quiz'      => array(
            'title' => esc_html__('Sortable Quiz', 'leform'),
            'icon'  => 'fas fa-arrows-alt-v',
            'type'  => 'input'
        ),
        'question_label'     => array(
            'title' => esc_html__('Question label', 'leform'),
            'icon'  => 'fas fa-marker',
            'type'  => 'other'
        ),
        'example_question'     => array(
            'title' => esc_html__('Example Question', 'leform'),
            'icon'  => 'fas fa-question',
            'type'  => 'other'
        ),
        'questions_group'     => array(
            'title' => esc_html__('Questions Group', 'leform'),
            'icon'  => 'fas fa-object-group',
            'type'  => 'other'
        ),
        'seperator'          => array(
            'title' => esc_html__('Seperator', 'leform'),
            'icon'  => 'fas fa-cut',
            'type'  => 'other'
        ),
        /*'question_no'        => array(
            'title' => esc_html__('Seperator' , 'leform') ,
            'icon'  => 'fas fa-question-circle' ,
            'type'  => 'other'
        ) ,*/

        'matrix_quiz' => array(
            'title' => esc_html__('Matrix Quiz', 'leform'),
            'icon'  => 'fas fa-table',
            'type'  => 'input'
        ),
        'draggable_quiz' => array(
            'title' => esc_html__('Draggable Quiz', 'leform'),
            'icon'  => 'fas fa-microphone',
            'type'  => 'input'
        ),

        'marking_quiz' => array(
            'title' => esc_html__('Marking Quiz', 'leform'),
            'icon'  => 'fas fa-microphone',
            'type'  => 'input'
        ),

        'insert_into_sentense' => array(
            'title' => esc_html__('Insert into Sentense', 'leform'),
            'icon'  => 'fas fa-question-circle',
            'type'  => 'other'
        ),

        'match_quiz' => array(
            'title' => esc_html__('Match Quiz', 'leform'),
            'icon'  => 'fas fa-arrows-alt-h',
            'type'  => 'input'
        ),
        'audio_file'     => array(
            'title' => esc_html__('Audio', 'leform'),
            'icon'  => 'fas fa-volume-up',
            'type'  => 'other'
        ),
        'audio_recording'     => array(
            'title' => esc_html__('Audio Recording', 'leform'),
            'icon'  => 'fas fa-microphone',
            'type'  => 'other'
        ),



        /*'spreadsheet_area' => array(
            'title' => esc_html__('Spread Sheet Area' , 'leform') ,
            'icon'  => 'fas fa-arrows-alt-v' ,
            'type'  => 'other'
        ) ,*/

        /*'imageselect' => array(
                'title' => esc_html__('Image Select', 'leform'),
                'icon' => 'far fa-images',
                'type' => 'input'
            ),*/

    );
    return $toolbar_tools;
}

function autocomplete_options()
{
    $autocomplete_options = array(
        'off'             => esc_html__('None', 'leform'),
        'name'            => esc_html__('Full Name', 'leform') . ' (name)',
        'given-name'      => esc_html__('First Name', 'leform') . ' (given-name)',
        'additional-name' => esc_html__('Middle Name', 'leform') . ' (additional-name)',
        'family-name'     => esc_html__('Last Name', 'leform') . ' (family-name)',
        'email'           => esc_html__('Email', 'leform') . ' (email)',
        'tel'             => esc_html__('Phone', 'leform') . ' (tel)',
        'street-address'  => esc_html__('Single Address Line', 'leform') . ' (street-address)',
        'address-line1'   => esc_html__('Address Line 1', 'leform') . ' (address-line1)',
        'address-line2'   => esc_html__('Address Line 2', 'leform') . ' (address-line2)',
        'address-level1'  => esc_html__('State or Province', 'leform') . ' (address-level1)',
        'address-level2'  => esc_html__('City', 'leform') . ' (address-level2)',
        'postal-code'     => esc_html__('ZIP Code', 'leform') . ' (postal-code)',
        'country'         => esc_html__('Country', 'leform') . ' (country)',
        'cc-name'         => esc_html__('Name on Card', 'leform') . ' (cc-name)',
        'cc-number'       => esc_html__('Card Number', 'leform') . ' (cc-number)',
        'cc-csc'          => esc_html__('CVC', 'leform') . ' (cc-csc)',
        'cc-exp-month'    => esc_html__('Expiry (month)', 'leform') . ' (cc-exp-month)',
        'cc-exp-year'     => esc_html__('Expiry (year)', 'leform') . ' (cc-exp-year)',
        'cc-exp'          => esc_html__('Expiry', 'leform') . ' (cc-exp)',
        'cc-type'         => esc_html__('Card Type', 'leform') . ' (cc-type)'
    );
    return $autocomplete_options;
}

function element_properties_meta($chapters)
{
    $element_properties_meta = array(
        'settings' => array(
            'general-tab'                       => array(
                'type'  => 'tab',
                'value' => 'general',
                'label' => esc_html__('General', 'leform')
            ),
            'name'                              => array(
                'value'   => esc_html__('Untitled', 'leform'),
                'label'   => esc_html__('Name', 'leform'),
                'tooltip' => esc_html__('The name helps to identify the form.', 'leform'),
                'type'    => 'text'
            ),
            'active'                            => array(
                'value'   => 'on',
                'label'   => esc_html__('Active', 'leform'),
                'tooltip' => esc_html__('Inactive forms will not appear on the site.', 'leform'),
                'type'    => 'checkbox'
            ),
            'key-fields'                        => array(
                'value'       => array(
                    'primary'   => '',
                    'secondary' => ''
                ),
                'caption'     => array(
                    'primary'   => esc_html__('Primary field', 'leform'),
                    'secondary' => esc_html__('Secondary field', 'leform')
                ),
                'placeholder' => array(
                    'primary'   => esc_html__('Select primary field', 'leform'),
                    'secondary' => esc_html__('Select secondary field', 'leform')
                ),
                'label'       => esc_html__('Key fields', 'leform'),
                'tooltip'     => esc_html__('The values of these fields are displayed on Log page in relevant columns.', 'leform'),
                'type'        => 'key-fields'
            ),
            'datetime-args'                     => array(
                'value'               => array(
                    'date-format' => 'yyyy-mm-dd',
                    'time-format' => 'hh:ii',
                    'locale'      => 'en'
                ),
                'label'               => esc_html__('Date and time parameters', 'leform'),
                'tooltip'             => esc_html__('Choose the date and time formats and language for datetimepicker. It is used for "date" and "time" fields.', 'leform'),
                'type'                => 'datetime-args',
                'date-format-options' => array(
                    'yyyy-mm-dd' => 'YYYY-MM-DD',
                    'mm/dd/yyyy' => 'MM/DD/YYYY',
                    'dd/mm/yyyy' => 'DD/MM/YYYY',
                    'dd.mm.yyyy' => 'DD.MM.YYYY'
                ),
                'date-format-label'   => esc_html__('Date format', 'leform'),
                'time-format-options' => array(
                    'hh:ii aa' => '12 hours',
                    'hh:ii'    => '24 hours'
                ),
                'time-format-label'   => esc_html__('Time format', 'leform'),
                'locale-options'      => array(
                    'en',
                    'cs',
                    'da',
                    'de',
                    'es',
                    'fi',
                    'fr',
                    'hu',
                    'it',
                    'nl',
                    'pl',
                    'pt',
                    'ro',
                    'ru',
                    'sk',
                    'tr',
                    'zh'
                ),
                'locale-label'        => esc_html__('Language', 'leform')
            ),
            'cross-domain'                      => array(
                'value'   => 'off',
                'label'   => esc_html__('Cross-domain calls', 'leform'),
                'tooltip' => esc_html__('Enable this option if you want to use cross-domain embedding, i.e. plugin installed on domain1, and form is used on domain2. Due to security reasons this feature is automatically disabled if the form has Signature field.', 'leform'),
                'type'    => 'checkbox'
            ),
            'session-enable'                    => array(
                'value'   => 'off',
                'label'   => esc_html__('Enable sessions', 'leform'),
                'tooltip' => esc_html__('Activate this option if you want to enable sessions for the form. Session allows to keep non-completed form data, so user can continue form filling when come back.', 'leform'),
                'type'    => 'checkbox'
            ),
            'session-length'                    => array(
                'value'   => '48',
                'label'   => esc_html__('Session length', 'leform'),
                'tooltip' => esc_html__('Specify how many hours non-completed data are kept.', 'leform'),
                'unit'    => 'hrs',
                'type'    => 'units',
                'visible' => array('session-enable' => array('on'))
            ),
            'style-tab'                         => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'style'                             => array(
                'caption' => array('style' => esc_html__('Load theme.', 'leform')),
                'label'   => esc_html__('Theme', 'leform'),
                'tooltip' => esc_html__('Load existing theme or save current one. All parameters on "Style" tab will be overwritten once you load a theme.', 'leform'),
                'type'    => 'style'
            ),
            'style-sections'                    => array(
                'type'     => 'sections',
                'sections' => array(
                    'global'   => array(
                        'label' => esc_html__('Global', 'leform'),
                        'icon'  => 'fas fa-globe'
                    ),
                    'labels'   => array(
                        'label' => esc_html__('Labels', 'leform'),
                        'icon'  => 'fas fa-font'
                    ),
                    'inputs'   => array(
                        'label' => esc_html__('Inputs', 'leform'),
                        'icon'  => 'fas fa-pencil-alt'
                    ),
                    'buttons'  => array(
                        'label' => esc_html__('Buttons', 'leform'),
                        'icon'  => 'far fa-paper-plane'
                    ),
                    'errors'   => array(
                        'label' => esc_html__('Errors', 'leform'),
                        'icon'  => 'far fa-hand-paper'
                    ),
                    'progress' => array(
                        'label' => esc_html__('Progress Bar', 'leform'),
                        'icon'  => 'fas fa-sliders-h'
                    )
                )
            ),
            'start-global'                      => array(
                'type'    => 'section-start',
                'section' => 'global'
            ),
            'text-style'                        => array(
                'value'   => array(
                    'family'    => 'arial',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Text style', 'leform'),
                'tooltip' => esc_html__('Adjust the text style.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'hr-1'                              => array('type' => 'hr'),
            'wrapper-style-sections'            => array(
                'type'     => 'sections',
                'sections' => array(
                    'wrapper-inline' => array(
                        'label' => esc_html__('Inline Mode', 'leform'),
                        'icon'  => 'fab fa-wpforms'
                    ),
                    'wrapper-popup'  => array(
                        'label' => esc_html__('Popup Mode', 'leform'),
                        'icon'  => 'far fa-window-maximize'
                    ),
                )
            ),
            'start-wrapper-inline'              => array(
                'type'    => 'section-start',
                'section' => 'wrapper-inline'
            ),
            'inline-background-style'           => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Wrapper background', 'leform'),
                'tooltip' => esc_html__('Adjust the background style for inline view of the form.', 'leform'),
                'type'    => 'background-style',
                'group'   => 'style'
            ),
            'inline-border-style'               => array(
                'value'   => array(
                    'width'  => '0',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '',
                    'top'    => 'off',
                    'right'  => 'off',
                    'bottom' => 'off',
                    'left'   => 'off'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Wrapper border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style for inline view of the form.', 'leform'),
                'type'    => 'border-style',
                'group'   => 'style'
            ),
            'inline-shadow'                     => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Wrapper shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow for inline view of the form.', 'leform'),
                'type'    => 'shadow',
                'group'   => 'style'
            ),
            'inline-padding'                    => array(
                'value'   => array(
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20'
                ),
                'caption' => array(
                    'top'    => esc_html__('Top', 'leform'),
                    'right'  => esc_html__('Right', 'leform'),
                    'bottom' => esc_html__('Bottom', 'leform'),
                    'left'   => esc_html__('Left', 'leform')
                ),
                'label'   => esc_html__('Padding', 'leform'),
                'tooltip' => esc_html__('Adjust the padding for inline view of the form.', 'leform'),
                'type'    => 'padding'
            ),
            'end-wrapper-inline'                => array('type' => 'section-end'),
            'start-wrapper-popup'               => array(
                'type'    => 'section-start',
                'section' => 'wrapper-popup'
            ),
            'popup-background-style'            => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#ffffff',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Popup background', 'leform'),
                'tooltip' => esc_html__('Adjust the background style for popup view of the form.', 'leform'),
                'type'    => 'background-style',
                'group'   => 'style'
            ),
            'popup-border-style'                => array(
                'value'   => array(
                    'width'  => '0',
                    'style'  => 'solid',
                    'radius' => '5',
                    'color'  => '',
                    'top'    => 'off',
                    'right'  => 'off',
                    'bottom' => 'off',
                    'left'   => 'off'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Popup border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style for popup view of the form.', 'leform'),
                'type'    => 'border-style',
                'group'   => 'style'
            ),
            'popup-shadow'                      => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => 'huge',
                    'color' => '#000'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Popup shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow for popup view of the form.', 'leform'),
                'type'    => 'shadow',
                'group'   => 'style'
            ),
            'popup-padding'                     => array(
                'value'   => array(
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20'
                ),
                'caption' => array(
                    'top'    => esc_html__('Top', 'leform'),
                    'right'  => esc_html__('Right', 'leform'),
                    'bottom' => esc_html__('Bottom', 'leform'),
                    'left'   => esc_html__('Left', 'leform')
                ),
                'label'   => esc_html__('Padding', 'leform'),
                'tooltip' => esc_html__('Adjust the padding for popup view of the form.', 'leform'),
                'type'    => 'padding'
            ),
            'popup-overlay-color'               => array(
                'value'   => 'rgba(255,255,255,0.7)',
                'label'   => esc_html__('Overlay color', 'leform'),
                'tooltip' => esc_html__('Adjust the overlay color.', 'leform'),
                'type'    => 'color',
                'group'   => 'style'
            ),
            'popup-overlay-click'               => array(
                'value'   => 'on',
                'label'   => esc_html__('Active overlay', 'leform'),
                'tooltip' => esc_html__('If enabled, the popup will be closed when user click overlay.', 'leform'),
                'type'    => 'checkbox'
            ),
            'popup-close-color'                 => array(
                'value'   => array(
                    'color1' => '#FF9800',
                    'color2' => '#FFC107'
                ),
                'label'   => esc_html__('Close icon colors', 'leform'),
                'tooltip' => esc_html__('Adjust the color of the close icon.', 'leform'),
                'caption' => array(
                    'color1' => esc_html__('Color', 'leform'),
                    'color2' => esc_html__('Hover color', 'leform')
                ),
                'type'    => 'two-colors',
                'group'   => 'style'
            ),
            'popup-spinner-color'               => array(
                'value'   => array(
                    'color1' => '#FF5722',
                    'color2' => '#FF9800',
                    'color3' => '#FFC107'
                ),
                'label'   => esc_html__('Spinner colors', 'leform'),
                'tooltip' => esc_html__('Adjust the color of the spinner.', 'leform'),
                'caption' => array(
                    'color1' => esc_html__('Small circle', 'leform'),
                    'color2' => esc_html__('Middle circle', 'leform'),
                    'color3' => esc_html__('Large circle', 'leform')
                ),
                'type'    => 'three-colors',
                'group'   => 'style'
            ),
            'end-wrapper-popup'                 => array('type' => 'section-end'),
            'hr-9'                              => array('type' => 'hr'),
            'tooltip-anchor'                    => array(
                'value'   => 'none',
                'label'   => esc_html__('Tooltip anchor', 'leform'),
                'tooltip' => esc_html__('Select the anchor for tooltips.', 'leform'),
                'type'    => 'select',
                'options' => array(
                    'none'        => esc_html__('Disable tooltips', 'leform'),
                    'label'       => esc_html__('Label', 'leform'),
                    'description' => esc_html__('Description', 'leform'),
                    'input'       => esc_html__('Input field', 'leform')
                ),
                'group'   => 'style'
            ),
            'tooltip-theme'                     => array(
                'value'   => 'dark',
                'label'   => esc_html__('Tooltip theme', 'leform'),
                'tooltip' => esc_html__('Select the theme of tooltips.', 'leform'),
                'type'    => 'select',
                'options' => array(
                    'dark'  => esc_html__('Dark', 'leform'),
                    'light' => esc_html__('Light', 'leform')
                ),
                'group'   => 'style'
            ),
            'hr-2'                              => array('type' => 'hr'),
            'max-width'                         => array(
                'value'   => array(
                    'value'    => '720',
                    'unit'     => 'px',
                    'position' => 'center'
                ),
                'label'   => esc_html__('Form width', 'leform'),
                'tooltip' => esc_html__('Specify the maximum form width and its alignment. Leave this field empty to set maximum form width as 100%.', 'leform'),
                'caption' => array(
                    'value'    => esc_html__('Width', 'leform'),
                    'unit'     => esc_html__('Units', 'leform'),
                    'position' => esc_html__('Position', 'leform')
                ),
                'type'    => 'block-width'
            ),
            'element-spacing'                   => array(
                'value'   => '20',
                'label'   => esc_html__('Element spacing', 'leform'),
                'tooltip' => esc_html__('Specify the spacing between form elements.', 'leform'),
                'unit'    => 'px',
                'type'    => 'units'
            ),
            'responsiveness'                    => array(
                'value'   => array(
                    'size'   => '480',
                    'custom' => '480'
                ),
                'caption' => array(
                    'size'   => esc_html__('Width', 'leform'),
                    'custom' => esc_html__('Custom', 'leform')
                ),
                'label'   => esc_html__('Responsiveness', 'leform'),
                'tooltip' => esc_html__('At what form width should column layouts be stacked.', 'leform'),
                'type'    => 'select-size',
                'options' => array(
                    '480'    => esc_html__('Phone portrait (480px)', 'leform'),
                    '768'    => esc_html__('Phone landscape (768px)', 'leform'),
                    '1024'   => esc_html__('Tablet (1024px)', 'leform'),
                    'custom' => esc_html__('Custom', 'leform')
                )
            ),
            'end-global'                        => array('type' => 'section-end'),
            'start-labels'                      => array(
                'type'    => 'section-start',
                'section' => 'labels'
            ),
            'label-text-style'                  => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '16',
                    'color'     => '#444',
                    'bold'      => 'on',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Label text style', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of labels.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'label-style'                       => array(
                'value'   => array(
                    'position' => 'top',
                    'width'    => '3'
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'width'    => esc_html__('Width', 'leform')
                ),
                'label'   => esc_html__('Label position', 'leform'),
                'tooltip' => esc_html__('Choose where to display the label relative to the field.', 'leform'),
                'type'    => 'label-position'
            ),
            'description-text-style'            => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '14',
                    'color'     => '#888',
                    'bold'      => 'off',
                    'italic'    => 'on',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Description text style', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of descriptions.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'description-style'                 => array(
                'value'   => array('position' => 'bottom'),
                'caption' => array('position' => esc_html__('Position', 'leform')),
                'label'   => esc_html__('Description position', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field.', 'leform'),
                'type'    => 'description-position'
            ),
            'required-position'                 => array(
                'value'   => 'none',
                'label'   => esc_html__('"Required" symbol position', 'leform'),
                'tooltip' => esc_html__('Select the position of "required" symbol/text. The symbol/text is displayed for fields that are configured as "Required".', 'leform'),
                'type'    => 'select',
                'options' => array(
                    'none'              => esc_html__('Do not display', 'leform'),
                    'label-left'        => esc_html__('To the left of the label', 'leform'),
                    'label-right'       => esc_html__('To the right of the label', 'leform'),
                    'description-left'  => esc_html__('To the left of the description', 'leform'),
                    'description-right' => esc_html__('To the right of the description', 'leform')
                ),
                'group'   => 'style'
            ),
            'required-text'                     => array(
                'value'   => '*',
                'label'   => esc_html__('"Required" symbol/text', 'leform'),
                'tooltip' => esc_html__('The symbol/text is displayed for fields that are configured as "Required".', 'leform'),
                'type'    => 'text',
                'visible' => array(
                    'required-position' => array(
                        'label-left',
                        'label-right',
                        'description-left',
                        'description-right'
                    )
                ),
                'group'   => 'style'
            ),
            'required-text-style'               => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '',
                    'color'     => '#d9534f',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('"Required" symbol/text style', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of "required" symbol/text.', 'leform'),
                'type'    => 'text-style',
                'visible' => array(
                    'required-position' => array(
                        'label-left',
                        'label-right',
                        'description-left',
                        'description-right'
                    )
                ),
                'group'   => 'style'
            ),
            'end-labels'                        => array('type' => 'section-end'),
            'start-inputs'                      => array(
                'type'    => 'section-start',
                'section' => 'inputs'
            ),
            'input-size'                        => array(
                'value'   => 'medium',
                'label'   => esc_html__('Input size', 'leform'),
                'tooltip' => esc_html__('Choose the size of input fields.', 'leform'),
                'type'    => 'select',
                'options' => array(
                    'tiny'   => esc_html__('Tiny', 'leform'),
                    'small'  => esc_html__('Small', 'leform'),
                    'medium' => esc_html__('Medium', 'leform'),
                    'large'  => esc_html__('Large', 'leform'),
                    'huge'   => esc_html__('Huge', 'leform')
                ),
                'group'   => 'style'
            ),
            'input-icon'                        => array(
                'value'   => array(
                    'position'   => 'inside',
                    'size'       => '20',
                    'color'      => '#444',
                    'background' => '',
                    'border'     => ''
                ),
                'caption' => array(
                    'position'   => esc_html__('Position', 'leform'),
                    'size'       => esc_html__('Size', 'leform'),
                    'color'      => esc_html__('Color', 'leform'),
                    'background' => esc_html__('Background', 'leform'),
                    'border'     => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Icon style', 'leform'),
                'tooltip' => esc_html__('Adjust the style of input field icons.', 'leform'),
                'type'    => 'icon-style',
                'group'   => 'style'
            ),
            'textarea-height'                   => array(
                'value'   => '160',
                'label'   => esc_html__('Textarea height', 'leform'),
                'tooltip' => esc_html__('Set the height of textarea fields.', 'leform'),
                'unit'    => 'px',
                'type'    => 'units'
            ),
            'input-style-sections'              => array(
                'type'     => 'sections',
                'sections' => array(
                    'inputs-default' => array(
                        'label' => esc_html__('Default', 'leform'),
                        'icon'  => 'fas fa-globe',
                        'group' => 'style'
                    ),
                    'inputs-hover'   => array(
                        'label' => esc_html__('Hover', 'leform'),
                        'icon'  => 'far fa-hand-pointer',
                        'group' => 'style'
                    ),
                    'inputs-focus'   => array(
                        'label' => esc_html__('Focus', 'leform'),
                        'icon'  => 'fas fa-i-cursor',
                        'group' => 'style'
                    )
                )
            ),
            'start-inputs-default'              => array(
                'type'    => 'section-start',
                'section' => 'inputs-default'
            ),
            'input-text-style'                  => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Input text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of input fields.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'input-background-style'            => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#fff',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Input background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of input fields.', 'leform'),
                'type'    => 'background-style',
                'group'   => 'style'
            ),
            'input-border-style'                => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#ccc',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Input border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of input fields.', 'leform'),
                'type'    => 'border-style',
                'group'   => 'style'
            ),
            'input-shadow'                      => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Input shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of input fields.', 'leform'),
                'type'    => 'shadow',
                'group'   => 'style'
            ),
            'end-inputs-default'                => array('type' => 'section-end'),
            'start-inputs-hover'                => array(
                'type'    => 'section-start',
                'section' => 'inputs-hover'
            ),
            'input-hover-inherit'               => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'input-hover-text-style'            => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Input text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of hovered input fields.', 'leform'),
                'type'    => 'text-style',
                'visible' => array('input-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'input-hover-background-style'      => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#fff',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Input background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of hovered input fields.', 'leform'),
                'type'    => 'background-style',
                'visible' => array('input-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'input-hover-border-style'          => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#ccc',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Input border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of hovered input fields.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('input-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'input-hover-shadow'                => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Input shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of hovered input fields.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('input-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'end-inputs-hover'                  => array('type' => 'section-end'),
            'start-inputs-focus'                => array(
                'type'    => 'section-start',
                'section' => 'inputs-focus'
            ),
            'input-focus-inherit'               => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'input-focus-text-style'            => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Input text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of focused input fields.', 'leform'),
                'type'    => 'text-style',
                'visible' => array('input-focus-inherit' => array('off')),
                'group'   => 'style'
            ),
            'input-focus-background-style'      => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#fff',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Input background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of focused input fields.', 'leform'),
                'type'    => 'background-style',
                'visible' => array('input-focus-inherit' => array('off')),
                'group'   => 'style'
            ),
            'input-focus-border-style'          => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#ccc',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Input border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of focused input fields.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('input-focus-inherit' => array('off')),
                'group'   => 'style'
            ),
            'input-focus-shadow'                => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Input shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of focused input fields.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('input-focus-inherit' => array('off')),
                'group'   => 'style'
            ),
            'end-inputs-focus'                  => array('type' => 'section-end'),
            'hr-5'                              => array('type' => 'hr'),
            'checkbox-radio-style'              => array(
                'value'   => array(
                    'position' => 'left',
                    'size'     => 'medium',
                    'align'    => 'left',
                    'layout'   => '1'
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'size'     => esc_html__('Size', 'leform'),
                    'align'    => esc_html__('Alignment', 'leform'),
                    'layout'   => esc_html__('Layout', 'leform')
                ),
                'label'   => esc_html__('Checkbox and radio style', 'leform'),
                'tooltip' => esc_html__('Choose how to display checkbox and radio button fields and their captions.', 'leform'),
                'type'    => 'checkbox-radio-style',
                'group'   => 'style'
            ),
            'checkbox-view'                     => array(
                'value'   => 'classic',
                'options' => array(
                    'classic',
                    'fa-check',
                    'square',
                    'tgl'
                ),
                'label'   => esc_html__('Checkbox view', 'leform'),
                'tooltip' => esc_html__('Choose the checkbox style.', 'leform'),
                'type'    => 'checkbox-view',
                'group'   => 'style'
            ),
            'radio-view'                        => array(
                'value'   => 'classic',
                'options' => array(
                    'classic',
                    'fa-check',
                    'dot'
                ),
                'label'   => esc_html__('Radio button view', 'leform'),
                'tooltip' => esc_html__('Choose the radio button style.', 'leform'),
                'type'    => 'radio-view',
                'group'   => 'style'
            ),
            'checkbox-radio-sections'           => array(
                'type'     => 'sections',
                'sections' => array(
                    'checkbox-radio-unchecked' => array(
                        'label' => esc_html__('Unchecked', 'leform'),
                        'icon'  => 'far fa-square'
                    ),
                    'checkbox-radio-checked'   => array(
                        'label' => esc_html__('Checked', 'leform'),
                        'icon'  => 'far fa-check-square'
                    )
                )
            ),
            'start-checkbox-radio-unchecked'    => array(
                'type'    => 'section-start',
                'section' => 'checkbox-radio-unchecked'
            ),
            'checkbox-radio-unchecked-color'    => array(
                'value'   => array(
                    'color1' => '#ccc',
                    'color2' => '#fff',
                    'color3' => '#444'
                ),
                'label'   => esc_html__('Checkbox and radio colors', 'leform'),
                'tooltip' => esc_html__('Adjust colors of checkboxes and radio buttons.', 'leform'),
                'caption' => array(
                    'color1' => 'Border',
                    'color2' => 'Background',
                    'color3' => 'Mark'
                ),
                'type'    => 'three-colors',
                'group'   => 'style'
            ),
            'end-checkbox-radio-unchecked'      => array('type' => 'section-end'),
            'start-checkbox-radio-checked'      => array(
                'type'    => 'section-start',
                'section' => 'checkbox-radio-checked'
            ),
            'checkbox-radio-checked-inherit'    => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit colors', 'leform'),
                'tooltip' => esc_html__('Use the same colors as for unchecked state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'checkbox-radio-checked-color'      => array(
                'value'   => array(
                    'color1' => '#ccc',
                    'color2' => '#fff',
                    'color3' => '#444'
                ),
                'label'   => esc_html__('Checkbox and radio colors', 'leform'),
                'tooltip' => esc_html__('Adjust colors of checkboxes and radio buttons.', 'leform'),
                'caption' => array(
                    'color1' => 'Border',
                    'color2' => 'Background',
                    'color3' => 'Mark'
                ),
                'type'    => 'three-colors',
                'visible' => array('checkbox-radio-checked-inherit' => array('off')),
                'group'   => 'style'
            ),
            'end-checkbox-radio-checked'        => array('type' => 'section-end'),
            'hr-6'                              => array('type' => 'hr'),
            'imageselect-style'                 => array(
                'value'   => array(
                    'align'  => 'left',
                    'effect' => 'none'
                ),
                'caption' => array(
                    'align'  => esc_html__('Alignment', 'leform'),
                    'effect' => esc_html__('Effect', 'leform')
                ),
                'label'   => esc_html__('Image Select style', 'leform'),
                'tooltip' => esc_html__('Adjust image alignment and effect.', 'leform'),
                'type'    => 'imageselect-style',
                'options' => array(
                    'none'      => esc_html__('None', 'leform'),
                    'grayscale' => esc_html__('Grayscale', 'leform')
                ),
                'group'   => 'style'
            ),
            'imageselect-text-style'            => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Image label text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of image label.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'imageselects-style-sections'       => array(
                'type'     => 'sections',
                'sections' => array(
                    'imageselects-default'  => array(
                        'label' => esc_html__('Default', 'leform'),
                        'icon'  => 'fas fa-globe'
                    ),
                    'imageselects-hover'    => array(
                        'label' => esc_html__('Hover', 'leform'),
                        'icon'  => 'far fa-hand-pointer'
                    ),
                    'imageselects-selected' => array(
                        'label' => esc_html__('Selected', 'leform'),
                        'icon'  => 'far fa-check-square'
                    )
                )
            ),
            'start-imageselects-default'        => array(
                'type'    => 'section-start',
                'section' => 'imageselects-default'
            ),
            'imageselect-border-style'          => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#ccc',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Image border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of images.', 'leform'),
                'type'    => 'border-style',
                'group'   => 'style'
            ),
            'imageselect-shadow'                => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Image shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of images.', 'leform'),
                'type'    => 'shadow',
                'group'   => 'style'
            ),
            'end-imageselects-default'          => array('type' => 'section-end'),
            'start-imageselects-hover'          => array(
                'type'    => 'section-start',
                'section' => 'imageselects-hover'
            ),
            'imageselect-hover-inherit'         => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'imageselect-hover-border-style'    => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#ccc',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Image border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of hovered images.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('imageselect-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'imageselect-hover-shadow'          => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Image shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of hovered images.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('imageselect-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'end-imageselects-hover'            => array('type' => 'section-end'),
            'start-imageselects-selected'       => array(
                'type'    => 'section-start',
                'section' => 'imageselects-selected'
            ),
            'imageselect-selected-inherit'      => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'imageselect-selected-border-style' => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#ccc',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Image border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of selected images.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('imageselect-selected-inherit' => array('off')),
                'group'   => 'style'
            ),
            'imageselect-selected-shadow'       => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Image shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of selected images.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('imageselect-selected-inherit' => array('off')),
                'group'   => 'style'
            ),
            'imageselect-selected-scale'        => array(
                'value'   => 'on',
                'label'   => esc_html__('Zoom selected image', 'leform'),
                'tooltip' => esc_html__('Zoom selected image.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'end-imageselects-selected'         => array('type' => 'section-end'),
            'hr-7'                              => array('type' => 'hr'),
            'multiselect-style'                 => array(
                'value'   => array(
                    'align'               => 'left',
                    'height'              => '120',
                    'hover-background'    => '#26B99A',
                    'hover-color'         => '#ffffff',
                    'selected-background' => '#169F85',
                    'selected-color'      => '#ffffff'
                ),
                'caption' => array(
                    'align'          => esc_html__('Alignment', 'leform'),
                    'height'         => esc_html__('Height', 'leform'),
                    'hover-color'    => esc_html__('Hover colors', 'leform'),
                    'selected-color' => esc_html__('Selected colors', 'leform')
                ),
                'label'   => esc_html__('Multiselect style', 'leform'),
                'tooltip' => esc_html__('Choose how to display multiselect options.', 'leform'),
                'type'    => 'multiselect-style',
                'group'   => 'style'
            ),
            'hr-8'                              => array('type' => 'hr'),
            'tile-style'                        => array(
                'value'   => array(
                    'size'     => 'medium',
                    'width'    => 'default',
                    'position' => 'left',
                    'layout'   => 'inline'
                ),
                'caption' => array(
                    'size'     => esc_html__('Size', 'leform'),
                    'width'    => esc_html__('Width', 'leform'),
                    'position' => esc_html__('Position', 'leform'),
                    'layout'   => esc_html__('Layout', 'leform')
                ),
                'label'   => esc_html__('Tile style', 'leform'),
                'tooltip' => esc_html__('Adjust the tile style.', 'leform'),
                'type'    => 'global-tile-style',
                'group'   => 'style'
            ),
            'tile-style-sections'               => array(
                'type'     => 'sections',
                'sections' => array(
                    'tiles-default' => array(
                        'label' => esc_html__('Default', 'leform'),
                        'icon'  => 'fas fa-globe'
                    ),
                    'tiles-hover'   => array(
                        'label' => esc_html__('Hover', 'leform'),
                        'icon'  => 'far fa-hand-pointer'
                    ),
                    'tiles-active'  => array(
                        'label' => esc_html__('Selected', 'leform'),
                        'icon'  => 'far fa-check-square'
                    )
                )
            ),
            'start-tiles-default'               => array(
                'type'    => 'section-start',
                'section' => 'tiles-default'
            ),
            'tile-text-style'                   => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'center'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Tile text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of tiles.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'tile-background-style'             => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#ffffff',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Vertical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Tile background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of tiles.', 'leform'),
                'type'    => 'background-style',
                'group'   => 'style'
            ),
            'tile-border-style'                 => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#ccc',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Tile border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of tiles.', 'leform'),
                'type'    => 'border-style',
                'group'   => 'style'
            ),
            'tile-shadow'                       => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Tile shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of tile.', 'leform'),
                'type'    => 'shadow',
                'group'   => 'style'
            ),
            'end-tiles-default'                 => array('type' => 'section-end'),
            'start-tiles-hover'                 => array(
                'type'    => 'section-start',
                'section' => 'tiles-hover'
            ),
            'tile-hover-inherit'                => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'tile-hover-text-style'             => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'center'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Tile text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of hovered tiles.', 'leform'),
                'type'    => 'text-style',
                'visible' => array('tile-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'tile-hover-background-style'       => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#ffffff',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Tile background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of hovered tiles.', 'leform'),
                'type'    => 'background-style',
                'visible' => array('tile-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'tile-hover-border-style'           => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#169F85',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Tile border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of hovered tiles.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('tile-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'tile-hover-shadow'                 => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Tile shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of hovered tiles.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('tile-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'end-tiles-hover'                   => array('type' => 'section-end'),
            'start-tiles-active'                => array(
                'type'    => 'section-start',
                'section' => 'tiles-active'
            ),
            'tile-selected-inherit'             => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'tile-selected-text-style'          => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#444',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'center'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Tile text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of selected tiles.', 'leform'),
                'type'    => 'text-style',
                'visible' => array('tile-selected-inherit' => array('off')),
                'group'   => 'style'
            ),
            'tile-selected-background-style'    => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#ffffff',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Tile background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of selected tiles.', 'leform'),
                'type'    => 'background-style',
                'visible' => array('tile-selected-inherit' => array('off')),
                'group'   => 'style'
            ),
            'tile-selected-border-style'        => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#169F85',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Tile border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of selected tiles.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('tile-selected-inherit' => array('off')),
                'group'   => 'style'
            ),
            'tile-selected-shadow'              => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Tile shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of selected tiles.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('tile-selected-inherit' => array('off')),
                'group'   => 'style'
            ),
            'tile-selected-transform'           => array(
                'value'   => 'zoom-in',
                'label'   => esc_html__('Transform', 'leform'),
                'tooltip' => esc_html__('Adjust the transform of selected tiles.', 'leform'),
                'type'    => 'radio-bar',
                'options' => array(
                    'none'       => esc_html__('None', 'leform'),
                    'zoom-in'    => esc_html__('Zoom In', 'leform'),
                    'zoom-out'   => esc_html__('Zoom Out', 'leform'),
                    'shift-down' => esc_html__('Shift Down', 'leform')
                ),
                'group'   => 'style'
            ),
            'end-tiles-active'                  => array('type' => 'section-end'),
            'hr-10'                             => array('type' => 'hr'),
            'rangeslider-skin'                  => array(
                'value'   => 'flat',
                'label'   => esc_html__('Range slider skin', 'leform'),
                'tooltip' => esc_html__('Select the skin of range slider.', 'leform'),
                'type'    => 'select',
                'options' => array(
                    'flat'  => esc_html__('Flat', 'leform'),
                    'sharp' => esc_html__('Sharp', 'leform'),
                    'round' => esc_html__('Round', 'leform')
                ),
                'group'   => 'style'
            ),
            'rangeslider-color'                 => array(
                'value'   => array(
                    'color1' => '#e8e8e8',
                    'color2' => '#888888',
                    'color3' => '#26B99A',
                    'color4' => '#169F85',
                    'color5' => '#ffffff'
                ),
                'label'   => esc_html__('Range slider colors', 'leform'),
                'tooltip' => esc_html__('Adjust colors of range slider.', 'leform'),
                'caption' => array(
                    'color1' => 'Main',
                    'color2' => 'Min/max text',
                    'color3' => 'Selected',
                    'color4' => 'Handle',
                    'color5' => 'Tooltip text'
                ),
                'type'    => 'five-colors',
                'group'   => 'style'
            ),
            'end-inputs'                        => array('type' => 'section-end'),
            'start-buttons'                     => array(
                'type'    => 'section-start',
                'section' => 'buttons'
            ),
            'button-style'                      => array(
                'value'   => array(
                    'size'     => 'medium',
                    'width'    => 'default',
                    'position' => 'center'
                ),
                'caption' => array(
                    'size'     => esc_html__('Size', 'leform'),
                    'width'    => esc_html__('Width', 'leform'),
                    'position' => esc_html__('Position', 'leform')
                ),
                'label'   => esc_html__('Button style', 'leform'),
                'tooltip' => esc_html__('Adjust the button size and position.', 'leform'),
                'type'    => 'global-button-style',
                'group'   => 'style'
            ),
            'button-style-sections'             => array(
                'type'     => 'sections',
                'sections' => array(
                    'buttons-default' => array(
                        'label' => esc_html__('Default', 'leform'),
                        'icon'  => 'fas fa-globe'
                    ),
                    'buttons-hover'   => array(
                        'label' => esc_html__('Hover', 'leform'),
                        'icon'  => 'far fa-hand-pointer'
                    ),
                    'buttons-active'  => array(
                        'label' => esc_html__('Active', 'leform'),
                        'icon'  => 'far fa-paper-plane'
                    )
                )
            ),
            'start-buttons-default'             => array(
                'type'    => 'section-start',
                'section' => 'buttons-default'
            ),
            'button-text-style'                 => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#fff',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'center'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Button text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of buttons.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'button-background-style'           => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#26B99A',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Button background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of buttons.', 'leform'),
                'type'    => 'background-style',
                'group'   => 'style'
            ),
            'button-border-style'               => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#169F85',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Button border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of buttons.', 'leform'),
                'type'    => 'border-style',
                'group'   => 'style'
            ),
            'button-shadow'                     => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Button shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of button.', 'leform'),
                'type'    => 'shadow',
                'group'   => 'style'
            ),
            'end-buttons-default'               => array('type' => 'section-end'),
            'start-buttons-hover'               => array(
                'type'    => 'section-start',
                'section' => 'buttons-hover'
            ),
            'button-hover-inherit'              => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'button-hover-text-style'           => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#fff',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'center'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Button text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of hovered buttons.', 'leform'),
                'type'    => 'text-style',
                'visible' => array('button-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'button-hover-background-style'     => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#169F85',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Button background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of hovered buttons.', 'leform'),
                'type'    => 'background-style',
                'visible' => array('button-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'button-hover-border-style'         => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#169F85',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Button border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of hovered buttons.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('button-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'button-hover-shadow'               => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Button shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of hovered buttons.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('button-hover-inherit' => array('off')),
                'group'   => 'style'
            ),
            'end-buttons-hover'                 => array('type' => 'section-end'),
            'start-buttons-active'              => array(
                'type'    => 'section-start',
                'section' => 'buttons-active'
            ),
            'button-active-inherit'             => array(
                'value'   => 'on',
                'label'   => esc_html__('Inherit default style', 'leform'),
                'tooltip' => esc_html__('Use the same style as for default state.', 'leform'),
                'type'    => 'checkbox',
                'group'   => 'style'
            ),
            'button-active-text-style'          => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#fff',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'center'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Button text', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of clicked buttons.', 'leform'),
                'type'    => 'text-style',
                'visible' => array('button-active-inherit' => array('off')),
                'group'   => 'style'
            ),
            'button-active-background-style'    => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#169F85',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Button background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of clicked buttons.', 'leform'),
                'type'    => 'background-style',
                'visible' => array('button-active-inherit' => array('off')),
                'group'   => 'style'
            ),
            'button-active-border-style'        => array(
                'value'   => array(
                    'width'  => '1',
                    'style'  => 'solid',
                    'radius' => '0',
                    'color'  => '#169F85',
                    'top'    => 'on',
                    'right'  => 'on',
                    'bottom' => 'on',
                    'left'   => 'on'
                ),
                'caption' => array(
                    'width'  => esc_html__('Width', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'radius' => esc_html__('Radius', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'border' => esc_html__('Border', 'leform')
                ),
                'label'   => esc_html__('Button border', 'leform'),
                'tooltip' => esc_html__('Adjust the border style of clicked buttons.', 'leform'),
                'type'    => 'border-style',
                'visible' => array('button-active-inherit' => array('off')),
                'group'   => 'style'
            ),
            'button-active-shadow'              => array(
                'value'   => array(
                    'style' => 'regular',
                    'size'  => '',
                    'color' => '#444'
                ),
                'caption' => array(
                    'style' => esc_html__('Style', 'leform'),
                    'size'  => esc_html__('Size', 'leform'),
                    'color' => esc_html__('Color', 'leform')
                ),
                'label'   => esc_html__('Button shadow', 'leform'),
                'tooltip' => esc_html__('Adjust the shadow of clicked buttons.', 'leform'),
                'type'    => 'shadow',
                'visible' => array('button-active-inherit' => array('off')),
                'group'   => 'style'
            ),
            'button-active-transform'           => array(
                'value'   => 'zoom-out',
                'label'   => esc_html__('Transform', 'leform'),
                'tooltip' => esc_html__('Adjust the transform of clicked buttons.', 'leform'),
                'type'    => 'radio-bar',
                'options' => array(
                    'zoom-in'    => esc_html__('Zoom In', 'leform'),
                    'zoom-out'   => esc_html__('Zoom Out', 'leform'),
                    'shift-down' => esc_html__('Shift Down', 'leform')
                ),
                'group'   => 'style'
            ),
            'end-buttons-active'                => array('type' => 'section-end'),
            'end-buttons'                       => array('type' => 'section-end'),
            'start-errors'                      => array(
                'type'    => 'section-start',
                'section' => 'errors'
            ),
            'error-background-style'            => array(
                'value'   => array(
                    'image'               => '',
                    'size'                => 'auto',
                    'horizontal-position' => 'left',
                    'vertical-position'   => 'top',
                    'repeat'              => 'repeat',
                    'color'               => '#d9534f',
                    'color2'              => '',
                    'gradient'            => 'no'
                ),
                'caption' => array(
                    'image'               => esc_html__('Image URL', 'leform'),
                    'size'                => esc_html__('Size', 'leform'),
                    'horizontal-position' => esc_html__('Horizontal position', 'leform'),
                    'vertical-position'   => esc_html__('Verical position', 'leform'),
                    'repeat'              => esc_html__('Repeat', 'leform'),
                    'color'               => esc_html__('Color', 'leform'),
                    'color2'              => esc_html__('Second color', 'leform'),
                    'gradient'            => esc_html__('Gradient', 'leform')
                ),
                'label'   => esc_html__('Bubble background', 'leform'),
                'tooltip' => esc_html__('Adjust the background of error bubbles.', 'leform'),
                'type'    => 'background-style',
                'group'   => 'style'
            ),
            'error-text-style'                  => array(
                'value'   => array(
                    'family'    => '',
                    'size'      => '15',
                    'color'     => '#fff',
                    'bold'      => 'off',
                    'italic'    => 'off',
                    'underline' => 'off',
                    'align'     => 'left'
                ),
                'caption' => array(
                    'family' => esc_html__('Font family', 'leform'),
                    'size'   => esc_html__('Size', 'leform'),
                    'color'  => esc_html__('Color', 'leform'),
                    'style'  => esc_html__('Style', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Error text style', 'leform'),
                'tooltip' => esc_html__('Adjust the text style of errors.', 'leform'),
                'type'    => 'text-style',
                'group'   => 'style'
            ),
            'end-errors'                        => array('type' => 'section-end'),
            'start-progress'                    => array(
                'type'    => 'section-start',
                'section' => 'progress'
            ),
            'progress-enable'                   => array(
                'value'   => 'off',
                'label'   => esc_html__('Enable progress bar', 'leform'),
                'tooltip' => esc_html__('If your form the form has several pages/steps, it is recommended to display progress bar for better user experience.', 'leform'),
                'type'    => 'checkbox'
            ),
            'progress-type'                     => array(
                'value'   => 'progress-1',
                'label'   => esc_html__('Progress style', 'leform'),
                'tooltip' => esc_html__('Select the general view of progress bar.', 'leform'),
                'type'    => 'select-image',
                'options' => array(
                    'progress-1' => '/images/progress-1.png',
                    'progress-2' => '/images/progress-2.png'
                ),
                'width'   => 350,
                'height'  => 90,
                'visible' => array('progress-enable' => array('on')),
                'group'   => 'style'
            ),
            'progress-color'                    => array(
                'value'   => array(
                    'color1' => '#e0e0e0',
                    'color2' => '#26B99A',
                    'color3' => '#FFFFFF',
                    'color4' => '#444'
                ),
                'label'   => esc_html__('Colors', 'leform'),
                'tooltip' => esc_html__('Adjust colors of progress bar.', 'leform'),
                'caption' => array(
                    'color1' => 'Passive background',
                    'color2' => 'Active background',
                    'color3' => 'Page number (or %)',
                    'color4' => 'Page name'
                ),
                'type'    => 'four-colors',
                'visible' => array('progress-enable' => array('on')),
                'group'   => 'style'
            ),
            'progress-striped'                  => array(
                'value'   => 'off',
                'label'   => esc_html__('Double-tone stripes', 'leform'),
                'tooltip' => esc_html__('Add double-tone diagonal stripes to progress bar.', 'leform'),
                'type'    => 'checkbox',
                'visible' => array('progress-enable' => array('on')),
                'group'   => 'style'
            ),
            'progress-label-enable'             => array(
                'value'   => 'off',
                'label'   => esc_html__('Show page name', 'leform'),
                'tooltip' => esc_html__('Show page label.', 'leform'),
                'type'    => 'checkbox',
                'visible' => array('progress-enable' => array('on')),
                'group'   => 'style'
            ),
            'progress-confirmation-enable'      => array(
                'value'   => 'on',
                'label'   => esc_html__('Include confirmation page', 'leform'),
                'tooltip' => esc_html__('Consider Confirmation page as part of total pages and include it into progress bar.', 'leform'),
                'type'    => 'checkbox',
                'visible' => array('progress-enable' => array('on'))
            ),
            'progress-position'                 => array(
                'value'   => 'inside',
                'label'   => esc_html__('Position', 'leform'),
                'tooltip' => esc_html__('Select the position of progress bar. It can be inside or outside of main form wrapper.', 'leform'),
                'type'    => 'select',
                'options' => array(
                    'inside'  => esc_html__('Inside', 'leform'),
                    'outside' => esc_html__('Outside', 'leform')
                ),
                'visible' => array('progress-enable' => array('on')),
                'group'   => 'style'
            ),
            'end-progress'                      => array('type' => 'section-end'),
            'confirmation-tab'                  => array(
                'type'  => 'tab',
                'value' => 'confirmation',
                'label' => esc_html__('Confirmations', 'leform')
            ),
            'confirmations'                     => array(
                'type'    => 'confirmations',
                'values'  => array(),
                'label'   => esc_html__('Confirmations', 'leform'),
                'message' => esc_html__('By default after successfull form submission the Confirmation Page is displayed. You can customize confirmation and use conditional logic. If several confirmations match form conditions, the first one (higher priority) will be applied. Sort confirmations (drag and drop) to set priority.', 'leform')
            ),
            'double-tab'                        => array(
                'type'  => 'tab',
                'value' => 'double',
                'label' => esc_html__('Double Opt-In', 'leform')
            ),
            'double-enable'                     => array(
                'value'   => 'off',
                'label'   => esc_html__('Enable', 'leform'),
                'tooltip' => esc_html__('Activate it if you want users to confirm submitted data. If enabled, the plugin sends email message with confirmation link to certain email address (submitted by user). When confirmation link clicked, relevant record is marked as "confirmed". Moreover, if enabled, all notifications and integrations are executed only when data confirmed by user. Important! Double opt-in is disabled if user is requested to pay via existing Payment Gateway.', 'leform'),
                'type'    => 'checkbox'
            ),
            'double-email-recipient'            => array(
                'value'   => '',
                'label'   => esc_html__('Recipient', 'leform'),
                'tooltip' => esc_html__('Set email address to which confirmation link will be sent to.', 'leform'),
                'type'    => 'text-shortcodes'
            ),
            'double-email-subject'              => array(
                'value'   => esc_html__('Please confirm your email address', 'leform'),
                'label'   => esc_html__('Subject', 'leform'),
                'tooltip' => esc_html__('The subject of the email message.', 'leform'),
                'type'    => 'text-shortcodes'
            ),
            'double-email-message'              => array(
                'value'   => esc_html__('Dear visitor!', 'leform') . '<br /><br />' . esc_html__('Please confirm your email address by clicking the following link:', 'leform') . '<br /><a href="{{confirmation-url}}">{{confirmation-url}}</a><br /><br />' . esc_html__('Thanks.', 'leform'),
                'label'   => esc_html__('Message', 'leform'),
                'tooltip' => sprintf(esc_html__('The content of the email message. It is mandatory to include %s{{confirmation-url}}%s shortcode.', 'leform'), '<code>', '</code>'),
                'type'    => 'html'
            ),
            'double-from'                       => array(
                'value'   => array(
                    'email' => '{{global-from-email}}',
                    'name'  => '{{global-from-name}}'
                ),
                'label'   => esc_html__('From', 'leform'),
                'tooltip' => esc_html__('Sets the "From" address and name. The email address and name set here will be shown as the sender of the email.', 'leform'),
                'type'    => 'from'
            ),
            'double-message'                    => array(
                'value'   => '<h4 style="text-align: center;">Thank you!</h4><p style="text-align: center;">Your email address successfully confirmed.</p>',
                'label'   => esc_html__('Thanksgiving message', 'leform'),
                'tooltip' => esc_html__('This message is displayed when users successfully confirmed their e-mail addresses.', 'leform'),
                'type'    => 'html'
            ),
            'double-url'                        => array(
                'value'   => '',
                'label'   => esc_html__('Thanksgiving URL', 'leform'),
                'tooltip' => esc_html__('This is alternate way of thanksgiving message. After confirmation users are redirected to this URL.', 'leform'),
                'type'    => 'text'
            ),
            'notification-tab'                  => array(
                'type'  => 'tab',
                'value' => 'notification',
                'label' => esc_html__('Notifications', 'leform')
            ),
            'notifications'                     => array(
                'type'    => 'notifications',
                'values'  => array(),
                'label'   => esc_html__('Notifications', 'leform'),
                'message' => esc_html__('After successful form submission the notification, welcome, thanksgiving or whatever email can be sent. You can customize these emails and use conditional logic.', 'leform')
            ),
            'integration-tab'                   => array(
                'type'  => 'tab',
                'value' => 'integration',
                'label' => esc_html__('Integrations', 'leform')
            ),
            'integrations'                      => array(
                'type'    => 'integrations',
                'values'  => array(),
                'label'   => esc_html__('Integrations', 'leform'),
                'message' => esc_html__('After successful form submission its data can be sent to 3rd party services (such as MailChimp, AWeber, GetResponse, etc.). You can configure integrations and use conditional logic. If you do not see your marketing/CRM provider, make sure that you enabled appropriate integration module on Advanced Settings page.', 'leform')
            ),
            'advanced-tab'                      => array(
                'type'  => 'tab',
                'value' => 'advanced',
                'label' => esc_html__('Advanced', 'leform')
            ),
            'advanced-sections'                 => array(
                'type'     => 'sections',
                'sections' => array(
                    'math'             => array(
                        'label' => esc_html__('Math Expressions', 'leform'),
                        'icon'  => 'fas fa-plus'
                    ),
                    'payment-gateways' => array(
                        'label' => esc_html__('Payment Gateways', 'leform'),
                        'icon'  => 'fas fa-dollar-sign'
                    ),
                    'misc'             => array(
                        'label' => esc_html__('Miscellaneous', 'leform'),
                        'icon'  => 'fas fa-project-diagram'
                    )
                )
            ),
            'start-math'                        => array(
                'type'    => 'section-start',
                'section' => 'math'
            ),
            'math-expressions'                  => array(
                'type'    => 'math-expressions',
                'values'  => array(),
                'label'   => esc_html__('Math expressions', 'leform'),
                'tooltip' => esc_html__('Create math expressions and use them along the form.', 'leform')
            ),
            'end-math'                          => array('type' => 'section-end'),
            'start-payment-gateways'            => array(
                'type'    => 'section-start',
                'section' => 'payment-gateways'
            ),
            'payment-gateways'                  => array(
                'type'    => 'payment-gateways',
                'values'  => array(),
                'label'   => esc_html__('Payment gateways', 'leform'),
                'message' => esc_html__('After successful form submission user can be requested to pay some amount via certain payment gateway. Customize payment gateways here. Then go to "Confirmations" tab and create confirmation of one of the following types: "Display Confirmation page and request payment", "Display Message and request payment" or "Request payment".', 'leform')
            ),
            'end-payment-gateways'              => array('type' => 'section-end'),
            'start-misc'                        => array(
                'type'    => 'section-start',
                'section' => 'misc'
            ),
            'misc-save-ip'                      => array(
                'value'   => 'on',
                'label'   => esc_html__('Save IP-address', 'leform'),
                'tooltip' => esc_html__('Save user\'s IP-address in local database.', 'leform'),
                'type'    => 'checkbox'
            ),
            'misc-save-user-agent'              => array(
                'value'   => 'on',
                'label'   => esc_html__('Save User-Agent', 'leform'),
                'tooltip' => esc_html__('Save user\'s User-Agent in local database.', 'leform'),
                'type'    => 'checkbox'
            ),
            'misc-email-tech-info'              => array(
                'value'   => 'on',
                'label'   => esc_html__('Send Technical Info by email', 'leform'),
                'tooltip' => esc_html__('Include Technical Info into "{{form-data}}" shortcode sent by email.', 'leform'),
                'type'    => 'checkbox'
            ),
            'misc-record-tech-info'             => array(
                'value'   => 'on',
                'label'   => esc_html__('Show Technical Info on log record details', 'leform'),
                'tooltip' => esc_html__('Show Technical Info on log record details.', 'leform'),
                'type'    => 'checkbox'
            ),
            'personal-keys'                     => array(
                'values'  => array(),
                'label'   => esc_html__('Personal data key fields', 'leform'),
                'tooltip' => esc_html__('Select fields which contains personal data keys. Usually it is an email field. WordPress uses this key to extract and handle personal data.', 'leform'),
                'type'    => 'personal-keys'
            ),
            'hr-11'                             => array('type' => 'hr'),
            'antibot-enable'                    => array(
                'value'   => 'on',
                'label'   => esc_html__('Antibot protection', 'leform'),
                'tooltip' => esc_html__('Enable protection against of repeated submissions.', 'leform'),
                'type'    => 'checkbox'
            ),
            'antibot-delay'                     => array(
                'value'   => '10',
                'label'   => esc_html__('Repeated submission delay', 'leform'),
                'tooltip' => esc_html__('Specify the delay (seconds) when the same user can submit data through the form.', 'leform'),
                'unit'    => 'seconds',
                'type'    => 'units',
                'visible' => array('antibot-enable' => array('on'))
            ),
            'antibot-check-form'                => array(
                'value'   => 'on',
                'label'   => esc_html__('Check form data', 'leform'),
                'tooltip' => esc_html__('Enable this feature to prohibit submission of the same data through the form.', 'leform'),
                'type'    => 'checkbox',
                'visible' => array('antibot-enable' => array('on'))
            ),
            'antibot-check-ip'                  => array(
                'value'   => 'on',
                'label'   => esc_html__('Check IP-address', 'leform'),
                'tooltip' => esc_html__('Enable this feature to prohibit submission from the same IP-address.', 'leform'),
                'type'    => 'checkbox',
                'visible' => array('antibot-enable' => array('on'))
            ),
            'antibot-error'                     => array(
                'value'   => esc_html__('Thank you. We have already got your request.', 'leform'),
                'label'   => esc_html__('Error message', 'leform'),
                'type'    => 'error',
                'visible' => array('antibot-enable' => array('on'))
            ),
            'end-misc'                          => array('type' => 'section-end'),
        ),


        'imageselect' => array(
            'basic'              => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'name'               => array(
                'value'   => esc_html__('Image select', 'leform'),
                'label'   => esc_html__('Name', 'leform'),
                'tooltip' => esc_html__('The name will be shown in place of the label throughout the plugin, in the notification email and when viewing submitted form entries.', 'leform'),
                'type'    => 'text'
            ),
            'score'              => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'           => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'              => array(
                'value'   => esc_html__('Mark one answer', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'mode'               => array(
                'value'   => 'radio',
                'label'   => esc_html__('Mode', 'leform'),
                'tooltip' => esc_html__('Select the mode of the Image Select.', 'leform'),
                'type'    => 'imageselect-mode'
            ),
            'submit-on-select'   => array(
                'value'   => 'off',
                'label'   => esc_html__('Submit on select', 'leform'),
                'tooltip' => esc_html__('If enabled, the form is submitted when user do selection.', 'leform'),
                'caption' => esc_html__('Submit on select', 'leform'),
                'type'    => 'checkbox',
                'visible' => array('mode' => array('radio'))
            ),
            'options'            => array(
                'multi-select' => 'off',
                'values'       => array(
                    array(
                        'value' => 'Option 1',
                        'label' => 'Option 1',
                        'image' => '/assets/default/img/quiz/placeholder-image.png'
                    ),
                    array(
                        'value' => 'Option 2',
                        'label' => 'Option 2',
                        'image' => '/assets/default/img/quiz/placeholder-image.png'
                    ),
                    array(
                        'value' => 'Option 3',
                        'label' => 'Option 3',
                        'image' => '/assets/default/img/quiz/placeholder-image.png'
                    )
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'image-options'

            ),
            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'style'              => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'image_size'    => array(
                'value'   => '',
                'label'   => esc_html__('Image Size', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image_small' => esc_html__('Small', 'leform'),
                        'image_medium' => esc_html__('Medium', 'leform'),
                        'image_large' => esc_html__('Large', 'leform'),
                    )
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),
            'template_alignment' => array(
                'value'   => 'image-right',
                'label'   => esc_html__('Image Alignment (Optional)', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-right' => esc_html__('Right', 'leform'),
                        'image-top'   => esc_html__('Top', 'leform'),
                    )
            ),
            'description-style'  => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'elements_data'      => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),


        ),
        'tile'        => array(
            'basic'             => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'name'              => array(
                'value'   => esc_html__('Tile', 'leform'),
                'label'   => esc_html__('Name', 'leform'),
                'tooltip' => esc_html__('The name will be shown in place of the label throughout the plugin, in the notification email and when viewing submitted form entries.', 'leform'),
                'type'    => 'text'
            ),
            'label'             => array(
                'value'   => esc_html__('Options', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'mode'              => array(
                'value'   => 'radio',
                'label'   => esc_html__('Mode', 'leform'),
                'tooltip' => esc_html__('Select the mode of the Tiles.', 'leform'),
                'type'    => 'tile-mode'
            ),
            'submit-on-select'  => array(
                'value'   => 'off',
                'label'   => esc_html__('Submit on select', 'leform'),
                'tooltip' => esc_html__('If enabled, the form is submitted when user do selection.', 'leform'),
                'caption' => esc_html__('Submit on select', 'leform'),
                'type'    => 'checkbox',
                'visible' => array('mode' => array('radio'))
            ),
            'options'           => array(
                'multi-select' => 'off',
                'values'       => array(
                    array(
                        'value' => 'Option 1',
                        'label' => 'Option 1'
                    ),
                    array(
                        'value' => 'Option 2',
                        'label' => 'Option 2'
                    ),
                    array(
                        'value' => 'Option 3',
                        'label' => 'Option 3'
                    )
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'options'
            ),
            'description'       => array(
                'value'   => 'Select options.',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'tooltip'           => array(
                'value'   => '',
                'label'   => esc_html__('Tooltip', 'leform'),
                'tooltip' => esc_html__('The tooltip appears when user click/hover tooltip anchor. The location of tooltip anchor is configured on Form Settings (tab "Style").', 'leform'),
                'type'    => 'text'
            ),
            'required'          => array(
                'value'   => 'off',
                'label'   => esc_html__('Required', 'leform'),
                'tooltip' => esc_html__('If enabled, the user must select at least one option.', 'leform'),
                'caption' => esc_html__('The field is required', 'leform'),
                'type'    => 'checkbox'
            ),
            'required-error'    => array(
                'value'   => esc_html__('This field is required.', 'leform'),
                'label'   => esc_html__('Error message', 'leform'),
                'type'    => 'error',
                'visible' => array('required' => array('on'))
            ),
            'style'             => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'label-style'       => array(
                'value'   => array(
                    'position' => '',
                    'width'    => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'width'    => esc_html__('Width', 'leform'),
                    'align'    => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Label style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the label relative to the field and its alignment.', 'leform'),
                'type'    => 'label-style'
            ),
            'tile-style'        => array(
                'value'   => array(
                    'size'     => '',
                    'width'    => '',
                    'position' => '',
                    'layout'   => ''
                ),
                'caption' => array(
                    'size'     => esc_html__('Size', 'leform'),
                    'width'    => esc_html__('Width', 'leform'),
                    'position' => esc_html__('Position', 'leform'),
                    'layout'   => esc_html__('Layout', 'leform')
                ),
                'label'   => esc_html__('Tile style', 'leform'),
                'tooltip' => esc_html__('Adjust the tile style.', 'leform'),
                'type'    => 'local-tile-style'
            ),
            'description-style' => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'data'              => array(
                'type'  => 'tab',
                'value' => 'data',
                'label' => esc_html__('Data', 'leform')
            ),
            'dynamic-default'   => array(
                'value'   => 'off',
                'label'   => esc_html__('Dynamic default value', 'leform'),
                'tooltip' => esc_html__('Allows the default value of the field to be set dynamically via a URL parameter.', 'leform'),
                'type'    => 'checkbox'
            ),
            'dynamic-parameter' => array(
                'value'   => '',
                'label'   => esc_html__('Parameter name', 'leform'),
                'tooltip' => esc_html__('This is the name of the parameter that you will use to set the default value.', 'leform'),
                'type'    => 'text',
                'visible' => array('dynamic-default' => array('on'))
            ),
            'save'              => array(
                'value'   => 'on',
                'label'   => esc_html__('Save to database', 'leform'),
                'tooltip' => esc_html__('If enabled, the submitted element data will be saved to the database and shown when viewing an entry.', 'leform'),
                'type'    => 'checkbox'
            ),
            'logic-tab'         => array(
                'type'  => 'tab',
                'value' => 'logic',
                'label' => esc_html__('Logic', 'leform')
            ),
            'logic-enable'      => array(
                'value'   => 'off',
                'label'   => esc_html__('Enable conditional logic', 'leform'),
                'tooltip' => esc_html__('If enabled, you can create rules to show or hide this element depending on the values of other fields.', 'leform'),
                'type'    => 'checkbox'
            ),
            'logic'             => array(
                'values'    => array(
                    'action'   => 'show',
                    'operator' => 'and',
                    'rules'    => array()
                ),
                'actions'   => array(
                    'show' => esc_html__('Show this field', 'leform'),
                    'hide' => esc_html__('Hide this field', 'leform')
                ),
                'operators' => array(
                    'and' => esc_html__('if all of these rules match', 'leform'),
                    'or'  => esc_html__('if any of these rules match', 'leform')
                ),
                'label'     => esc_html__('Logic rules', 'leform'),
                'tooltip'   => esc_html__('Create rules to show or hide this element depending on the values of other fields.', 'leform'),
                'type'      => 'logic-rules',
                'visible'   => array('logic-enable' => array('on'))
            ),
            'advanced'          => array(
                'type'  => 'tab',
                'value' => 'advanced',
                'label' => esc_html__('Advanced', 'leform')
            ),
            'element-id'        => array(
                'value'   => '',
                'label'   => esc_html__('ID', 'leform'),
                'tooltip' => esc_html__('The unique ID of the input field.', 'leform'),
                'type'    => 'id'
            ),
            'validators'        => array(
                'values'         => array(),
                'allowed-values' => array(
                    'in-array',
                    'prevent-duplicates'
                ),
                'label'          => esc_html__('Validators', 'leform'),
                'tooltip'        => esc_html__('Validators checks whether the data entered by the user is valid.', 'leform'),
                'type'           => 'validators'
            )
        ),
        'multiselect' => array(
            'basic'             => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'label'             => array(
                'value'   => esc_html__('Options', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options'           => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => 'Option 1',
                        'label' => 'Option 1'
                    ),
                    array(
                        'value' => 'Option 2',
                        'label' => 'Option 2'
                    ),
                    array(
                        'value' => 'Option 3',
                        'label' => 'Option 3'
                    )
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'options'
            ),
            'description'       => array(
                'value'   => 'Select options.',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'tooltip'           => array(
                'value'   => '',
                'label'   => esc_html__('Tooltip', 'leform'),
                'tooltip' => esc_html__('The tooltip appears when user click/hover tooltip anchor. The location of tooltip anchor is configured on Form Settings (tab "Style").', 'leform'),
                'type'    => 'text'
            ),
            'required'          => array(
                'value'   => 'off',
                'label'   => esc_html__('Required', 'leform'),
                'tooltip' => esc_html__('If enabled, the user must fill out the field.', 'leform'),
                'caption' => esc_html__('The field is required', 'leform'),
                'type'    => 'checkbox'
            ),
            'required-error'    => array(
                'value'   => esc_html__('This field is required.', 'leform'),
                'label'   => esc_html__('Error message', 'leform'),
                'type'    => 'error',
                'visible' => array('required' => array('on'))
            ),
            'style'             => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'label-style'       => array(
                'value'   => array(
                    'position' => '',
                    'width'    => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'width'    => esc_html__('Width', 'leform'),
                    'align'    => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Label style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the label relative to the field and its alignment.', 'leform'),
                'type'    => 'label-style'
            ),
            'multiselect-style' => array(
                'value'   => array(
                    'height' => '',
                    'align'  => ''
                ),
                'caption' => array(
                    'height' => esc_html__('Height', 'leform'),
                    'align'  => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Multiselect style', 'leform'),
                'tooltip' => esc_html__('Adjust the multiselect field style (size and text alignment).', 'leform'),
                'type'    => 'local-multiselect-style'
            ),
            'description-style' => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'data'              => array(
                'type'  => 'tab',
                'value' => 'data',
                'label' => esc_html__('Data', 'leform')
            ),
            'max-allowed'       => array(
                'value'   => '0',
                'label'   => esc_html__('Maximum selected options', 'leform'),
                'tooltip' => esc_html__('Enter how many options can be selected. Set 0 for unlimited number.', 'leform'),
                'type'    => 'integer'
            ),
            'dynamic-default'   => array(
                'value'   => 'off',
                'label'   => esc_html__('Dynamic default value', 'leform'),
                'tooltip' => esc_html__('Allows the default value of the field to be set dynamically via a URL parameter.', 'leform'),
                'type'    => 'checkbox'
            ),
            'dynamic-parameter' => array(
                'value'   => '',
                'label'   => esc_html__('Parameter name', 'leform'),
                'tooltip' => esc_html__('This is the name of the parameter that you will use to set the default value.', 'leform'),
                'type'    => 'text',
                'visible' => array('dynamic-default' => array('on'))
            ),
            'save'              => array(
                'value'   => 'on',
                'label'   => esc_html__('Save to database', 'leform'),
                'tooltip' => esc_html__('If enabled, the submitted element data will be saved to the database and shown when viewing an entry.', 'leform'),
                'type'    => 'checkbox'
            ),
            'logic-tab'         => array(
                'type'  => 'tab',
                'value' => 'logic',
                'label' => esc_html__('Logic', 'leform')
            ),
            'logic-enable'      => array(
                'value'   => 'off',
                'label'   => esc_html__('Enable conditional logic', 'leform'),
                'tooltip' => esc_html__('If enabled, you can create rules to show or hide this element depending on the values of other fields.', 'leform'),
                'type'    => 'checkbox'
            ),
            'logic'             => array(
                'values'    => array(
                    'action'   => 'show',
                    'operator' => 'and',
                    'rules'    => array()
                ),
                'actions'   => array(
                    'show' => esc_html__('Show this field', 'leform'),
                    'hide' => esc_html__('Hide this field', 'leform')
                ),
                'operators' => array(
                    'and' => esc_html__('if all of these rules match', 'leform'),
                    'or'  => esc_html__('if any of these rules match', 'leform')
                ),
                'label'     => esc_html__('Logic rules', 'leform'),
                'tooltip'   => esc_html__('Create rules to show or hide this element depending on the values of other fields.', 'leform'),
                'type'      => 'logic-rules',
                'visible'   => array('logic-enable' => array('on'))
            ),
            'advanced'          => array(
                'type'  => 'tab',
                'value' => 'advanced',
                'label' => esc_html__('Advanced', 'leform')
            ),
            'element-id'        => array(
                'value'   => '',
                'label'   => esc_html__('ID', 'leform'),
                'tooltip' => esc_html__('The unique ID of the input field.', 'leform'),
                'type'    => 'id'
            ),
            'validators'        => array(
                'values'         => array(),
                'allowed-values' => array(
                    'in-array',
                    'prevent-duplicates'
                ),
                'label'          => esc_html__('Validators', 'leform'),
                'tooltip'        => esc_html__('Validators checks whether the data entered by the user is valid.', 'leform'),
                'type'           => 'validators'
            )
        ),

        'checkbox' => array(
            'basic'   => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'   => array(
                'value'   => esc_html__('Mark one answer', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options' => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => 'Option 1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 3',
                        'label' => 'Option 3',
                        'image' => ''
                    )
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'image-options'
            ),

            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'style'              => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'image_size'    => array(
                'value'   => '',
                'label'   => esc_html__('Image Size', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image_small' => esc_html__('Small', 'leform'),
                        'image_medium' => esc_html__('Medium', 'leform'),
                        'image_large' => esc_html__('Large', 'leform'),
                    )
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),

            'template_alignment' => array(
                'value'   => 'image-right',
                'label'   => esc_html__('Image Alignment (Optional)', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-right' => esc_html__('Right', 'leform'),
                        'image-top'   => esc_html__('Top', 'leform'),
                    )
            ),
            'list_style'         => array(
                'value'   => 'none',
                'label'   => esc_html__('Bullet list Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        ''                    => esc_html__('None', 'leform'),
                        'alphabet-list-style' => esc_html__('English Alphabet', 'leform'),
                        'numeric-list-style'  => esc_html__('Numbers', 'leform'),
                    )
            ),


            'description-style' => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),


        ),
        'radio'    => array(
            'basic'              => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'              => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'label'              => array(
                'value'   => esc_html__('Mark one answer', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options'            => array(
                'multi-select' => 'off',
                'values'       => array(
                    array(
                        'value' => 'Option 1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 3',
                        'label' => 'Option 3',
                        'image' => ''
                    )
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'image-options'
            ),
            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),
            'list_style'         => array(
                'value'   => 'none',
                'label'   => esc_html__('Bullet list Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        ''                    => esc_html__('None', 'leform'),
                        'alphabet-list-style' => esc_html__('English Alphabet', 'leform'),
                        'numeric-list-style'  => esc_html__('Numbers', 'leform'),
                    )
            ),
            'elements_data'      => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),



        ),

        'sortable_quiz' => array(
            'basic'   => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'   => array(
                'value'   => esc_html__('Arrange', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options' => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => '1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => '2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => '3',
                        'label' => 'Option 3',
                        'image' => ''
                    ),
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'sortable-options'
            ),

            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'style'              => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'image_size'    => array(
                'value'   => '',
                'label'   => esc_html__('Image Size', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image_small' => esc_html__('Small', 'leform'),
                        'image_medium' => esc_html__('Medium', 'leform'),
                        'image_large' => esc_html__('Large', 'leform'),
                    )
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),

            'template_alignment' => array(
                'value'   => 'image-right',
                'label'   => esc_html__('Image Alignment (Optional)', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-right' => esc_html__('Right', 'leform'),
                        'image-top'   => esc_html__('Top', 'leform'),
                    )
            ),
            'list_style'         => array(
                'value'   => 'none',
                'label'   => esc_html__('Bullet list Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        ''                    => esc_html__('None', 'leform'),
                        'alphabet-list-style' => esc_html__('English Alphabet', 'leform'),
                        'numeric-list-style'  => esc_html__('Numbers', 'leform'),
                    )
            ),

            'label-style'       => array(
                'value'   => array(
                    'position' => '',
                    'width'    => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'width'    => esc_html__('Width', 'leform'),
                    'align'    => esc_html__('Alignment', 'leform')
                ),
                'label'   => esc_html__('Label style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the label relative to the field and its alignment.', 'leform'),
                'type'    => 'label-style'
            ),
            'checkbox-style'    => array(
                'value'   => array(
                    'position' => '',
                    'align'    => '',
                    'layout'   => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Alignment', 'leform'),
                    'layout'   => esc_html__('Layout', 'leform')
                ),
                'label'   => esc_html__('Checkbox style', 'leform'),
                'tooltip' => esc_html__('Choose how to display checkbox fields and their captions.', 'leform'),
                'type'    => 'local-checkbox-style'
            ),
            'description-style' => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),


        ),

        'matrix_quiz' => array(
            'basic'    => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'    => array(
                'value'   => esc_html__('Arrange', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options'  => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => '1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => '2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => '3',
                        'label' => 'Option 3',
                        'image' => ''
                    ),
                ),
                'label'        => esc_html__('Columns', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'matrix-columns-options'
            ),
            'options2' => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => '1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => '2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => '3',
                        'label' => 'Option 3',
                        'image' => ''
                    ),
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'matrix-columns-labels'
            ),

            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'style'              => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'image_size'    => array(
                'value'   => '',
                'label'   => esc_html__('Image Size', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image_small' => esc_html__('Small', 'leform'),
                        'image_medium' => esc_html__('Medium', 'leform'),
                        'image_large' => esc_html__('Large', 'leform'),
                    )
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),

            'template_alignment' => array(
                'value'   => 'image-right',
                'label'   => esc_html__('Image Alignment (Optional)', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-right' => esc_html__('Right', 'leform'),
                        'image-top'   => esc_html__('Top', 'leform'),
                    )
            ),
            'list_style'         => array(
                'value'   => 'none',
                'label'   => esc_html__('Bullet list Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        ''                    => esc_html__('None', 'leform'),
                        'alphabet-list-style' => esc_html__('English Alphabet', 'leform'),
                        'numeric-list-style'  => esc_html__('Numbers', 'leform'),
                    )
            ),
            'description-style' => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),



        ),

        'draggable_quiz' => array(
            'basic'    => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'    => array(
                'value'   => esc_html__('Arrange', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options'  => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => '1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => '2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => '3',
                        'label' => 'Option 3',
                        'image' => ''
                    ),
                ),
                'label'        => esc_html__('Columns', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'options_label'
            ),
            'content'       => array(
                'value'   => '',
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html_toolbar_draggable'
            ),

            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),



        ),

        'marking_quiz' => array(
            'basic'    => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'    => array(
                'value'   => esc_html__('Arrange', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'markings_options'  => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => 'Simple',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Selectable',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Simple',
                        'label' => 'Option 3',
                        'image' => ''
                    ),
                ),
                'label'        => esc_html__('Columns', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'options_marking'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),



        ),

        'match_quiz' => array(
            'basic'    => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'    => array(
                'value'   => esc_html__('Match', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options'  => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => '1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => '2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => '3',
                        'label' => 'Option 3',
                        'image' => ''
                    ),
                ),
                'label'        => esc_html__('Columns', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'matrix-columns-options'
            ),
            'options2' => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => '1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => '2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => '3',
                        'label' => 'Option 3',
                        'image' => ''
                    ),
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'matrix-columns-labels'
            ),

            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'style'              => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'image_size'    => array(
                'value'   => '',
                'label'   => esc_html__('Image Size', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image_small' => esc_html__('Small', 'leform'),
                        'image_medium' => esc_html__('Medium', 'leform'),
                        'image_large' => esc_html__('Large', 'leform'),
                    )
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),

            'template_alignment' => array(
                'value'   => 'image-right',
                'label'   => esc_html__('Image Alignment (Optional)', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-right' => esc_html__('Right', 'leform'),
                        'image-top'   => esc_html__('Top', 'leform'),
                    )
            ),
            'list_style'         => array(
                'value'   => 'none',
                'label'   => esc_html__('Bullet list Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        ''                    => esc_html__('None', 'leform'),
                        'alphabet-list-style' => esc_html__('English Alphabet', 'leform'),
                        'numeric-list-style'  => esc_html__('Numbers', 'leform'),
                    )
            ),


            'description-style' => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),


        /*'imageselect' => array(
                'basic' => array('type' => 'tab', 'value' => 'basic', 'label' => esc_html__('Basic', 'leform')),
                'name' => array('value' => esc_html__('Image select', 'leform'), 'label' => esc_html__('Name', 'leform'), 'tooltip' => esc_html__('The name will be shown in place of the label throughout the plugin, in the notification email and when viewing submitted form entries.', 'leform'), 'type' => 'text'),
                'label' => array('value' => esc_html__('Options', 'leform'), 'label' => esc_html__('Label', 'leform'), 'tooltip' => esc_html__('This is the label of the field.', 'leform'), 'type' => 'text'),
                'mode' => array('value' => 'radio', 'label' => esc_html__('Mode', 'leform'), 'tooltip' => esc_html__('Select the mode of the Image Select.', 'leform'), 'type' => 'imageselect-mode'),
                'submit-on-select' => array('value' => 'off', 'label' => esc_html__('Submit on select', 'leform'), 'tooltip' => esc_html__('If enabled, the form is submitted when user do selection.', 'leform'), 'caption' => esc_html__('Submit on select', 'leform'), 'type' => 'checkbox', 'visible' => array('mode' => array('radio'))),
                'options' => array('multi-select' => 'off', 'values' => array(array('value' => 'Option 1', 'label' => 'Option 1', 'image' => '/assets/default/img/quiz/placeholder-image.png'), array('value' => 'Option 2', 'label' => 'Option 2', 'image' => '/assets/default/img/quiz/placeholder-image.png'), array('value' => 'Option 3', 'label' => 'Option 3', 'image' => '/assets/default/img/quiz/placeholder-image.png')), 'label' => esc_html__('Options', 'leform'), 'tooltip' => esc_html__('These are the choices that the user will be able to choose from.', 'leform'), 'type' => 'image-options'),
                'description' => array('value' => 'Select options.', 'label' => esc_html__('Description', 'leform'), 'tooltip' => esc_html__('This description appears below the field.', 'leform'), 'type' => 'text'),
                'tooltip' => array('value' => '', 'label' => esc_html__('Tooltip', 'leform'), 'tooltip' => esc_html__('The tooltip appears when user click/hover tooltip anchor. The location of tooltip anchor is configured on Form Settings (tab "Style").', 'leform'), 'type' => 'text'),
                'required' => array('value' => 'off', 'label' => esc_html__('Required', 'leform'), 'tooltip' => esc_html__('If enabled, the user must fill out the field.', 'leform'), 'caption' => esc_html__('The field is required', 'leform'), 'type' => 'checkbox'),
                'required-error' => array('value' => esc_html__('This field is required.', 'leform'), 'label' => esc_html__('Error message', 'leform'), 'type' => 'error', 'visible' => array('required' => array('on'))),
                'style' => array('type' => 'tab', 'value' => 'style', 'label' => esc_html__('Style', 'leform')),
                'label-style' => array('value' => array('position' => '', 'width' => '', 'align' => ''), 'caption' => array('position' => esc_html__('Position', 'leform'), 'width' => esc_html__('Width', 'leform'), 'align' => esc_html__('Alignment', 'leform')), 'label' => esc_html__('Label style', 'leform'), 'tooltip' => esc_html__('Choose where to display the label relative to the field and its alignment.', 'leform'), 'type' => 'label-style'),
                'image-style' => array('value' => array('width' => "120", 'height' => "160", 'size' => 'contain'), 'caption' => array('width' => esc_html__('Width', 'leform'), 'height' => esc_html__('Height', 'leform'), 'size' => esc_html__('Size', 'leform')), 'label' => esc_html__('Image style', 'leform'), 'tooltip' => esc_html__('Choose how to display images.', 'leform'), 'type' => 'local-imageselect-style'),
                'label-enable' => array('value' => 'off', 'label' => esc_html__('Enable label', 'leform'), 'tooltip' => esc_html__('If enabled, the label will be displayed below the image.', 'leform'), 'caption' => esc_html__('Label enabled', 'leform'), 'type' => 'checkbox'),
                'label-height' => array('value' => '60', 'label' => esc_html__('Label height', 'leform'), 'tooltip' => esc_html__('Set the height of label area.', 'leform'), 'unit' => 'px', 'type' => 'units', 'visible' => array('label-enable' => array('on'))),
                'description-style' => array('value' => array('position' => '', 'align' => ''), 'caption' => array('position' => esc_html__('Position', 'leform'), 'align' => esc_html__('Align', 'leform')), 'label' => esc_html__('Description style', 'leform'), 'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'), 'type' => 'description-style'),
                'css' => array('type' => 'css', 'values' => array(), 'label' => esc_html__('CSS styles', 'leform'), 'tooltip' => esc_html__('Once you have added a style, enter the CSS styles.', 'leform'), 'selectors' => array(
                        'wrapper' => array(
                            'label' => esc_html__('Wrapper', 'leform'),
                            'admin-class' => '.leform-element-{element-id}',
                            'front-class' => '.leform-form-{form-id} .leform-element-{element-id}'
                        ),
                        'label' => array(
                            'label' => esc_html__('Label', 'leform'),
                            'admin-class' => '.leform-element-{element-id} .leform-column-label .leform-label',
                            'front-class' => '.leform-form-{form-id} .leform-element-{element-id} .leform-column-label .leform-label'
                        ),
                        'description' => array(
                            'label' => esc_html__('Description', 'leform'),
                            'admin-class' => '.leform-element-{element-id} .leform-column-input .leform-description',
                            'front-class' => '.leform-form-{form-id} .leform-element-{element-id} .leform-column-input .leform-description'
                        )
                    )
                ),
                'elements_data' => array('value' => '', 'label' => '', 'tooltip' => '', 'type' => 'elements_data'),
                'quiz-settings' => array('type' => 'tab', 'value' => 'settings', 'label' => esc_html__('Settings', 'leform')),
                'score' => array('value' => '', 'label' => esc_html__('Score', 'leform'), 'type' => 'number'),
                'attempt_time' => array('value' => '', 'label' => esc_html__('Attempt Time', 'leform'), 'type' => 'number'),
                'difficulty_level' => array('value' => 'none', 'label' => esc_html__('Difficulty Level', 'leform'), '', 'type' => 'select', 'options' =>
                    array(
                        'Below' => esc_html__('Below', 'leform'),
                        'Emerging' => esc_html__('Emerging', 'leform'),
                        'Expected' => esc_html__('Expected', 'leform'),
                        'Exceeding' => esc_html__('Exceeding', 'leform'),
                        'Challenge' => esc_html__('Challenge', 'leform'),
                        )
                ),
            ),
			*/


        'page'               => array(
            'general' => array(
                'type'  => 'tab',
                'value' => 'general',
                'label' => esc_html__('General', 'leform')
            ),
            'name'    => array(
                'value'   => esc_html__('Page', 'leform'),
                'label'   => esc_html__('Name', 'leform'),
                'tooltip' => esc_html__('The name helps to identify the page.', 'leform'),
                'type'    => 'text'
            ),
        ),
        'page-confirmation'  => array(
            'general' => array(
                'type'  => 'tab',
                'value' => 'general',
                'label' => esc_html__('General', 'leform')
            ),
            'name'    => array(
                'value'   => esc_html__('Confirmation', 'leform'),
                'label'   => esc_html__('Name', 'leform'),
                'tooltip' => esc_html__('The name helps to identify the confirmation page.', 'leform'),
                'type'    => 'text'
            )
        ),
        'columns'            => array(
            'basic'  => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'name'   => array(
                'value'   => esc_html__('Untitled', 'leform'),
                'label'   => esc_html__('Name', 'leform'),
                'tooltip' => esc_html__('The name will be shown throughout the plugin.', 'leform'),
                'type'    => 'text'
            ),
            'widths' => array(
                'value'   => '',
                'label'   => esc_html__('Column width', 'leform'),
                'tooltip' => esc_html__('Specify the width of each column. The row is divided into 12 equal pieces. You can decide how many pieces related to each columns. If you want all columns to be in one row, make sure that sum of widths is equal to 12.', 'leform'),
                'type'    => 'column-width'
            ),
        ),
        'question_templates' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'content'       => array(
                'value'   => '222 + 222&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; =&nbsp;<span class="input-holder"><input type="text" data-field_type="text" size="3" readonly="readonly" class="editor-field field_small" data-id="37851" id="field-37851" correct_answere="4"></span>',
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
        ),
        'html_bk'            => array(
            'basic'        => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'name'         => array(
                'value' => esc_html__('HTML Content', 'leform'),
                'label' => esc_html__('Name', 'leform'),
                'type'  => 'text'
            ),
            'content'      => array(
                'value'   => esc_html__('Default HTML Content.', 'leform') . '',
                'label'   => esc_html__('HTML', 'leform'),
                'tooltip' => esc_html__('This is the content of HTML.', 'leform'),
                'type'    => 'html'
            ),
            'style'        => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'css'          => array(
                'type'      => 'css',
                'values'    => array(),
                'label'     => esc_html__('CSS styles', 'leform'),
                'tooltip'   => esc_html__('Once you have added a style, enter the CSS styles.', 'leform'),
                'selectors' => array(
                    'wrapper' => array(
                        'label'       => esc_html__('Wrapper', 'leform'),
                        'admin-class' => '.leform-element-{element-id}',
                        'front-class' => '.leform-form-{form-id} .leform-element-{element-id}'
                    )
                )
            ),
            'logic-tab'    => array(
                'type'  => 'tab',
                'value' => 'logic',
                'label' => esc_html__('Logic', 'leform')
            ),
            'logic-enable' => array(
                'value'   => 'off',
                'label'   => esc_html__('Enable conditional logic', 'leform'),
                'tooltip' => esc_html__('If enabled, you can create rules to show or hide this element depending on the values of other fields.', 'leform'),
                'type'    => 'checkbox'
            ),
            'logic'        => array(
                'values'    => array(
                    'action'   => 'show',
                    'operator' => 'and',
                    'rules'    => array()
                ),
                'actions'   => array(
                    'show' => esc_html__('Show this element', 'leform'),
                    'hide' => esc_html__('Hide this element', 'leform')
                ),
                'operators' => array(
                    'and' => esc_html__('if all of these rules match', 'leform'),
                    'or'  => esc_html__('if any of these rules match', 'leform')
                ),
                'label'     => esc_html__('Logic rules', 'leform'),
                'tooltip'   => esc_html__('Create rules to show or hide this element depending on the values of other fields.', 'leform'),
                'type'      => 'logic-rules',
                'visible'   => array('logic-enable' => array('on'))
            ),
        ),
        'html'               => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'content'       => array(
                'value'   => esc_html__('Default HTML Content.', 'leform') . '',
                'label'   => esc_html__('HTML', 'leform'),
                'tooltip' => esc_html__('This is the content of HTML.', 'leform'),
                'type'    => 'html_toolbar'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),


        ),
        'spreadsheet_area'   => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'score'         => array(
               'value' => '',
               'label' => esc_html__('Score', 'leform'),
               'type'  => 'number'
           ),
            'content'       => array(
                'value'   => esc_html__('', 'leform') . '',
                'label'
                          => esc_html__('HTML', 'leform'),
                'tooltip' => esc_html__('This is the spreadshee.', 'leform'),
                'type'    =>
                    'html'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),
        'sum_quiz'           => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'content'       => array(
                'value'   => '222 + 222&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; =&nbsp;<span class="input-holder"><input type="text" data-field_type="text" size="3" readonly="readonly" class="editor-field field_small" data-id="37851" id="field-37851" correct_answere="4"></span>',
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),
        'multichoice_template'           => array(
            'basic'              => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'              => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'label'              => array(
                'value'   => esc_html__('Mark one answer', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options'            => array(
                'multi-select' => 'off',
                'values'       => array(
                    array(
                        'value' => 'Option 1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 3',
                        'label' => 'Option 3',
                        'image' => ''
                    )
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'image-options'
            ),
            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'style'              => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),

            'template_alignment' => array(
                'value'   => 'image-right',
                'label'   => esc_html__('Image Alignment (Optional)', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-right' => esc_html__('Right', 'leform'),
                        'image-top'   => esc_html__('Top', 'leform'),
                    )
            ),
            'list_style'         => array(
                'value'   => 'none',
                'label'   => esc_html__('Bullet list Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        ''                    => esc_html__('None', 'leform'),
                        'alphabet-list-style' => esc_html__('English Alphabet', 'leform'),
                        'numeric-list-style'  => esc_html__('Numbers', 'leform'),
                    )
            ),

            'description-style'  => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'elements_data'      => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),

        'multiresponse_template'           => array(
            'basic'   => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
            'label'   => array(
                'value'   => esc_html__('Mark one answer', 'leform'),
                'label'   => esc_html__('Label', 'leform'),
                'tooltip' => esc_html__('This is the label of the field.', 'leform'),
                'type'    => 'text'
            ),
            'options' => array(
                'multi-select' => 'on',
                'values'       => array(
                    array(
                        'value' => 'Option 1',
                        'label' => 'Option 1',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 2',
                        'label' => 'Option 2',
                        'image' => ''
                    ),
                    array(
                        'value' => 'Option 3',
                        'label' => 'Option 3',
                        'image' => ''
                    )
                ),
                'label'        => esc_html__('Options', 'leform'),
                'tooltip'      => esc_html__('These are the choices that the user will be able to choose from.', 'leform'),
                'type'         => 'image-options'
            ),

            'description'        => array(
                'value'   => '',
                'label'   => esc_html__('Description', 'leform'),
                'tooltip' => esc_html__('This description appears below the field.', 'leform'),
                'type'    => 'text'
            ),
            'style'              => array(
                'type'  => 'tab',
                'value' => 'style',
                'label' => esc_html__('Style', 'leform')
            ),
            'template_style'     => array(
                'value'   => 'rurera-in-row',
                'label'   => esc_html__('Template Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'rurera-in-row' => esc_html__('Row', 'leform'),
                        'rurera-in-cols' => esc_html__('Columns', 'leform'),
                    )
            ),

            'template_alignment' => array(
                'value'   => 'image-right',
                'label'   => esc_html__('Image Alignment (Optional)', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-right' => esc_html__('Right', 'leform'),
                        'image-top'   => esc_html__('Top', 'leform'),
                    )
            ),
            'list_style'         => array(
                'value'   => 'none',
                'label'   => esc_html__('Bullet list Style', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        ''                    => esc_html__('None', 'leform'),
                        'alphabet-list-style' => esc_html__('English Alphabet', 'leform'),
                        'numeric-list-style'  => esc_html__('Numbers', 'leform'),
                    )
            ),


            'description-style' => array(
                'value'   => array(
                    'position' => '',
                    'align'    => ''
                ),
                'caption' => array(
                    'position' => esc_html__('Position', 'leform'),
                    'align'    => esc_html__('Align', 'leform')
                ),
                'label'   => esc_html__('Description style', 'leform'),
                'tooltip' => esc_html__('Choose where to display the description relative to the field and its alignment.', 'leform'),
                'type'    => 'description-style'
            ),

            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),


        'image_quiz_draggable'     => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            /*'content'       => array(
                'value'   => '<span class="block-holder image-field"><img data-field_type="image" data-id="23119" id="field-23119" class="editor-field" src="/assets/default/img/quiz/placeholder-image.png" heigh="50" width="50"></span>',
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html'
            ),*/
            'content'       => array(
                'value' => '/assets/default/img/quiz/placeholder-image.png',
                'label' => esc_html__('Image', 'leform'),
                'type'  => 'image'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),

        'image_quiz'     => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            /*'content'       => array(
                'value'   => '<span class="block-holder image-field"><img data-field_type="image" data-id="23119" id="field-23119" class="editor-field" src="/assets/default/img/quiz/placeholder-image.png" heigh="50" width="50"></span>',
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html'
            ),*/
            'content'       => array(
                'value' => '/assets/default/img/quiz/placeholder-image.png',
                'label' => esc_html__('Image', 'leform'),
                'type'  => 'image'
            ),
            'image_size'     => array(
                'value'   => 'image-small',
                'label'   => esc_html__('Image Size', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-small' => esc_html__('Small', 'leform'),
                        'image-medium' => esc_html__('Medium', 'leform'),
                        'image-large' => esc_html__('Large', 'leform'),
                        'image-full' => esc_html__('Full Size', 'leform'),
                    )
            ),
            'image_position'     => array(
                'value'   => 'image-left',
                'label'   => esc_html__('Image Position', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'image-left' => esc_html__('Left', 'leform'),
                        'image-center' => esc_html__('Center', 'leform'),
                        'image-right' => esc_html__('Right', 'leform'),
                    )
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),
        'heading_quiz' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'content'       => array(
                'value'   => '<h2>Example Heading</h2>',
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),
        'paragraph_quiz' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'content'       => array(
                'value'   => "<p><b>Lorem Ipsum</b> is simply <u>dummy text</u> of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the <font color='#ffff00''' style='background-color: rgb(156, 156, 148);'''>1500s</font>, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                <ol><li>List item # 1</li>
                <li>List item # 2</li>
                <li>List item # 3</li>
                <li>List item # 4</li></ol><p>It was popularised in the <a href='https://rurera.com' target='_blank'>1960s</a> with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>",
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),

        ),
        'textareafield_quiz' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'placeholder'   => array(
               'value' => '',
               'label' => esc_html__('Placeholder', 'leform'),
               'type'  => 'text'
           ),
           'field_size'    => array(
                'value'   => '',
                'label'   => esc_html__('Field Size', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'field_small' => esc_html__('Small', 'leform'),
                        'field_medium' => esc_html__('Medium', 'leform'),
                        'field_large' => esc_html__('Large', 'leform'),
                    )
            ),
            'style_format'    => array(
                'value'   => '',
                'label'   => esc_html__('Style Format', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'textarea_plain' => esc_html__('plain', 'leform'),
                        'textarea_lines' => esc_html__('Dotted Line', 'leform'),
                    )
            ),
            'maxlength'         => array(
               'value' => '',
               'label' => esc_html__('Maximum Length', 'leform'),
               'type'  => 'number'
           ),
            'rows'   => array(
               'value' => '3',
               'label' => esc_html__('Rows', 'leform'),
               'type'  => 'number'
           ),
            'correct_answer'    => array(
               'value' => '',
               'label' => esc_html__('Correct Answer', 'leform'),
               'type'  => 'text'
           ),
            'score'         => array(
               'value' => '',
               'label' => esc_html__('Score', 'leform'),
               'type'  => 'number'
           ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
        ),
        'textfield_quiz' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'placeholder'   => array(
               'value' => '',
               'label' => esc_html__('Placeholder', 'leform'),
               'type'  => 'text'
           ),
            'label_before'   => array(
               'value' => '',
               'label' => esc_html__('Label Before', 'leform'),
               'type'  => 'text'
           ),
           'label_after'   => array(
               'value' => '',
               'label' => esc_html__('Label After', 'leform'),
               'type'  => 'text'
           ),
            'style_format'    => array(
                'value'   => '',
                'label'   => esc_html__('Style Format', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'input_box' => esc_html__('Box', 'leform'),
                        'input_line' => esc_html__('Underline', 'leform'),
                    )
            ),
            'text_format'    => array(
                'value'   => '',
                'label'   => esc_html__('Text Format', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'text' => esc_html__('Alpha Numeric', 'leform'),
                        'numbers' => esc_html__('Numbers', 'leform'),
                    )
            ),
            'maxlength'         => array(
               'value' => '',
               'label' => esc_html__('Maximum Length', 'leform'),
               'type'  => 'number'
           ),
            'correct_answer'    => array(
               'value' => '',
               'label' => esc_html__('Correct Answer', 'leform'),
               'type'  => 'text'
           ),

            'score'         => array(
               'value' => '',
               'label' => esc_html__('Score', 'leform'),
               'type'  => 'number'
           ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
            'field_id'      => array(
                'value' => '',
                'label' => esc_html__('Field_id', 'leform'),
                'type'  => 'hidden'
            ),
        ),
        'truefalse_quiz' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
        'correct_answer'    => array(
            'value'   => '',
            'label'   => esc_html__('Correct Answer', 'leform'),
            '',
            'type'    => 'select',
            'options' =>
                array(
                    'True' => esc_html__('True', 'leform'),
                    'False' => esc_html__('False', 'leform'),
                )
        ),

        'score'         => array(
           'value' => '',
           'label' => esc_html__('Score', 'leform'),
           'type'  => 'number'
       ),
        'elements_data' => array(
            'value'   => '',
            'label'   => '',
            'tooltip' => '',
            'type'    => 'elements_data'
        ),
        'field_id'      => array(
            'value' => '',
            'label' => esc_html__('Field_id', 'leform'),
            'type'  => 'hidden'
        ),
        ),

        'attachment_quiz' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'content'         => array(
               'value' => 'Attachment',
               'label' => esc_html__('Label', 'leform'),
               'type'  => 'text'
           ),
            'score'         => array(
               'value' => '',
               'label' => esc_html__('Score', 'leform'),
               'type'  => 'number'
           ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
        ),

        'sqroot_quiz'    => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),

            'score'         => array(
                'value' => '',
                'label' => esc_html__('Score', 'leform'),
                'type'  => 'number'
            ),
            'content'       => array(
                'value'   => '<span class="block-holder" data-id="87714" data-field_type="select" id="field-87714"><span class="lms-root-block">&nbsp;<span class="lms-scaled"><span class="lms-sqrt-prefix lms-scaled" contenteditable="false">&radic;</span><span class="lms-sqrt-stem lms-non-leaf lms-empty" contenteditable="true">X</span></span></span></span>&nbsp;',
                'label'   => esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),


        ),
        'question_label' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'content'       => array(
                'value' => esc_html__('Question Label', 'leform'),
                'label' => esc_html__('Name', 'leform'),
                'type'  => 'html'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
        ),
        'example_question' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'question_id'    => array(
                'value'   => '',
                'label'   => esc_html__('Question', 'leform'),
                'class' => 'search-question-select2',
                'type'    => 'ajax_select_new',
                'options' =>
                    array(
                        '0' => esc_html__('Select Question', 'leform'),
                    )
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
        ),
        'questions_group' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'no_of_display_questions'         => array(
                'value' => '1',
                'label' => esc_html__('No of Displaying Questions', 'leform'),
                'type'  => 'number'
            ),
            'question_ids'    => array(
                'value'   => '',
                'label'   => esc_html__('Questions', 'leform'),
                'class' => 'search-question-select2',
                'type'    => 'ajax_multi_select_new',
                'multi-select' => 'on',
                'options' =>
                    array(
                        '0' => esc_html__('Select Questions', 'leform'),
                    )
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
        ),


        'audio_file' => array(
            'basic'         => array(
                'type'  => 'tab',
                'value' => 'basic',
                'label' => esc_html__('Basic', 'leform')
            ),
            'audio_text'       => array(
                'value' => esc_html__('', 'leform'),
                'label' => esc_html__('Word', 'leform'),
                'after' => '<a href="javascript:;" class="rurera-generate-audio">Generate</a>',
                'type'  => 'text'
            ),
            'audio_sentense'       => array(
                'value' => esc_html__('', 'leform'),
                'label' => esc_html__('Sentence', 'leform'),
                'type'  => 'text'
            ),
            'audio_defination'       => array(
                'value' => esc_html__('', 'leform'),
                'label' => esc_html__('Defination', 'leform'),
                'type'  => 'text'
            ),
            'word_audio'       => array(
                'value' => esc_html__('', 'leform'),
                'label' => esc_html__('Audio File Word Upload', 'leform'),
                'type'  => 'file'
            ),
            'content'       => array(
                'value' => esc_html__('', 'leform'),
                'label' => esc_html__('Audio File with Sentense Upload', 'leform'),
                'type'  => 'file'
            ),
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
        ),
        'audio_recording' => array(
                'basic'         => array(
                    'type'  => 'tab',
                    'value' => 'basic',
                    'label' => esc_html__('Basic', 'leform')
                ),
                'content'       => array(
                    'value' => esc_html__('30', 'leform'),
                    'label' => esc_html__('Time Limit (seconds)', 'leform'),
                    'type'  => 'number'
                ),
                'elements_data' => array(
                    'value'   => '',
                    'label'   => '',
                    'tooltip' => '',
                    'type'    => 'elements_data'
                ),
            ),



        'seperator'   => array(
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
            'content'       => array(
                'value'   => "<span class='question-seperator'><hr></span>",
                'label'   => '',
                'tooltip' => '',
                'type'    => 'hidden'
            ),
        ),
        'question_no' => array(
            'elements_data' => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
            'content'       => array(
                'value'   => "1",
                'label'   => esc_html__('Question No', 'leform'),
                'tooltip' => '',
                'type'    => 'text'
            ),
        ),

        'insert_into_sentense_bk' => array(
            'elements_data'     => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
            'insert_symbols'    => array(
                'value'   => '',
                'label'   => esc_html__('Insert Symbols', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        '-' => esc_html__('hyphen', 'leform'),
                        '-' => esc_html__('hyphen', 'leform'),
                        'both' => esc_html__('Both', 'leform'),
                    )
            ),
            'insert_into_type'  => array(
                'value'   => '',
                'label'   => esc_html__('Insert Into', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'words'      => esc_html__('Words', 'leform'),
                        'characters' => esc_html__('Characters', 'leform'),
                    )
            ),
            'question_sentense' => array(
                'classes' => "elements_fetchable",
                'value'   => "",
                'label'   => esc_html__('Question Sentense', 'leform'),
                'tooltip' => '',
                'type'    => 'textarea'
            ),
            'correct_sentense'  => array(
                'classes' => "elements_fetchable",
                'value'   => "",
                'label'   => esc_html__('Correct Sentense', 'leform'),
                'tooltip' => '',
                'type'    => 'textarea'
            ),
            'elements_fetcher'  => array(
                'value'   => "",
                'label'   => esc_html__('Correct Sentense', 'leform'),
                'tooltip' => '',
                'type'    => 'elements_fetcher'
            ),
        ),

        'insert_into_sentense' => array(
            'elements_data'    => array(
                'value'   => '',
                'label'   => '',
                'tooltip' => '',
                'type'    => 'elements_data'
            ),
            'insert_symbols'   => array(
                'value'   => '',
                'label'   => esc_html__('Insert Symbols', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        '-' => esc_html__('hyphen', 'leform'),
                        ',' => esc_html__('Comma', 'leform'),
                        'both' => esc_html__('Both', 'leform'),
                    )
            ),
            'insert_into_type' => array(
                'value'   => '',
                'label'   => esc_html__('Insert Into', 'leform'),
                '',
                'type'    => 'select',
                'options' =>
                    array(
                        'words'      => esc_html__('Words', 'leform'),
                        'characters' => esc_html__('Characters', 'leform'),
                    )
            ),
            'content'          => array(
                'classes' => "note-editable",
                'value'   => '<p data-field_type="insert_into_sentense" type="paragraph" class="editor-field given" data-id="37851" id="field-37851" correct_answere="4">test text goes h</p>',
                'label'   =>
                    esc_html__('Content', 'leform'),
                'tooltip' => '',
                'type'    => 'html_notool_editor'
            ),
            'elements_fetcher' => array(
                'value'   => "",
                'label'   => esc_html__('Correct Sentense', 'leform'),
                'tooltip' => '',
                'type'    => 'elements_fetcher'
            ),
        ),


    );
    return $element_properties_meta;
}

function tabs_options()
{
    $tabs_options = '{"general-tab": "general", "name": "Form Test", "active": "on", "key-fields-primary": "", "key-fields-secondary": "", "datetime-args-date-format": "yyyy-mm-dd", "datetime-args-time-format": "hh:ii", "datetime-args-locale": "en", "cross-domain": "off", "session-enable": "off", "session-length": "48", "style-tab": "style", "text-style-family": "arial", "text-style-size": "15", "text-style-color": "#444", "text-style-bold": "off", "text-style-italic": "off", "text-style-underline": "off", "text-style-align": "left", "inline-background-style-image": "", "inline-background-style-size": "auto", "inline-background-style-horizontal-position": "left", "inline-background-style-vertical-position": "top", "inline-background-style-repeat": "repeat", "inline-background-style-color": "", "inline-background-style-color2": "", "inline-background-style-gradient": "no", "inline-border-style-width": "0", "inline-border-style-style": "solid", "inline-border-style-radius": "0", "inline-border-style-color": "", "inline-border-style-top": "off", "inline-border-style-right": "off", "inline-border-style-bottom": "off", "inline-border-style-left": "off", "inline-shadow-style": "regular", "inline-shadow-size": "", "inline-shadow-color": "#444", "inline-padding-top": "20", "inline-padding-right": "20", "inline-padding-bottom": "20", "inline-padding-left": "20", "popup-background-style-image": "", "popup-background-style-size": "auto", "popup-background-style-horizontal-position": "left", "popup-background-style-vertical-position": "top", "popup-background-style-repeat": "repeat", "popup-background-style-color": "#ffffff", "popup-background-style-color2": "", "popup-background-style-gradient": "no", "popup-border-style-width": "0", "popup-border-style-style": "solid", "popup-border-style-radius": "5", "popup-border-style-color": "", "popup-border-style-top": "off", "popup-border-style-right": "off", "popup-border-style-bottom": "off", "popup-border-style-left": "off", "popup-shadow-style": "regular", "popup-shadow-size": "huge", "popup-shadow-color": "#000", "popup-padding-top": "20", "popup-padding-right": "20", "popup-padding-bottom": "20", "popup-padding-left": "20", "popup-overlay-color": "rgba(255,255,255,0.7)", "popup-overlay-click": "on", "popup-close-color-color1": "#FF9800", "popup-close-color-color2": "#FFC107", "popup-spinner-color-color1": "#FF5722", "popup-spinner-color-color2": "#FF9800", "popup-spinner-color-color3": "#FFC107", "tooltip-anchor": "none", "max-width-value": "720", "max-width-unit": "px", "max-width-position": "center", "element-spacing": "20", "responsiveness-size": "480", "responsiveness-custom": "480", "label-text-style-family": "", "label-text-style-size": "16", "label-text-style-color": "#444", "label-text-style-bold": "on", "label-text-style-italic": "off", "label-text-style-underline": "off", "label-text-style-align": "left", "label-style-position": "top", "label-style-width": "3", "description-text-style-family": "", "description-text-style-size": "14", "description-text-style-color": "#888", "description-text-style-bold": "off", "description-text-style-italic": "on", "description-text-style-underline": "off", "description-text-style-align": "left", "description-style-position": "bottom", "required-position": "none", "required-text": "*", "required-text-style-family": "", "required-text-style-size": "", "required-text-style-color": "#d9534f", "required-text-style-bold": "off", "required-text-style-italic": "off", "required-text-style-underline": "off", "required-text-style-align": "left", "input-size": "medium", "input-icon-position": "inside", "input-icon-size": "20", "input-icon-color": "#444", "input-icon-background": "", "input-icon-border": "", "textarea-height": "160", "input-text-style-family": "", "input-text-style-size": "15", "input-text-style-color": "#444", "input-text-style-bold": "off", "input-text-style-italic": "off", "input-text-style-underline": "off", "input-text-style-align": "left", "input-background-style-image": "", "input-background-style-size": "auto", "input-background-style-horizontal-position": "left", "input-background-style-vertical-position": "top", "input-background-style-repeat": "repeat", "input-background-style-color": "#fff", "input-background-style-color2": "", "input-background-style-gradient": "no", "input-border-style-width": "1", "input-border-style-style": "solid", "input-border-style-radius": "0", "input-border-style-color": "#ccc", "input-border-style-top": "on", "input-border-style-right": "on", "input-border-style-bottom": "on", "input-border-style-left": "on", "input-shadow-style": "regular", "input-shadow-size": "", "input-shadow-color": "#444", "input-hover-inherit": "on", "input-hover-text-style-family": "", "input-hover-text-style-size": "15", "input-hover-text-style-color": "#444", "input-hover-text-style-bold": "off", "input-hover-text-style-italic": "off", "input-hover-text-style-underline": "off", "input-hover-text-style-align": "left", "input-hover-background-style-image": "", "input-hover-background-style-size": "auto", "input-hover-background-style-horizontal-position": "left", "input-hover-background-style-vertical-position": "top", "input-hover-background-style-repeat": "repeat", "input-hover-background-style-color": "#fff", "input-hover-background-style-color2": "", "input-hover-background-style-gradient": "no", "input-hover-border-style-width": "1", "input-hover-border-style-style": "solid", "input-hover-border-style-radius": "0", "input-hover-border-style-color": "#ccc", "input-hover-border-style-top": "on", "input-hover-border-style-right": "on", "input-hover-border-style-bottom": "on", "input-hover-border-style-left": "on", "input-hover-shadow-style": "regular", "input-hover-shadow-size": "", "input-hover-shadow-color": "#444", "input-focus-inherit": "on", "input-focus-text-style-family": "", "input-focus-text-style-size": "15", "input-focus-text-style-color": "#444", "input-focus-text-style-bold": "off", "input-focus-text-style-italic": "off", "input-focus-text-style-underline": "off", "input-focus-text-style-align": "left", "input-focus-background-style-image": "", "input-focus-background-style-size": "auto", "input-focus-background-style-horizontal-position": "left", "input-focus-background-style-vertical-position": "top", "input-focus-background-style-repeat": "repeat", "input-focus-background-style-color": "#fff", "input-focus-background-style-color2": "", "input-focus-background-style-gradient": "no", "input-focus-border-style-width": "1", "input-focus-border-style-style": "solid", "input-focus-border-style-radius": "0", "input-focus-border-style-color": "#ccc", "input-focus-border-style-top": "on", "input-focus-border-style-right": "on", "input-focus-border-style-bottom": "on", "input-focus-border-style-left": "on", "input-focus-shadow-style": "regular", "input-focus-shadow-size": "", "input-focus-shadow-color": "#444", "checkbox-radio-style-position": "left", "checkbox-radio-style-size": "medium", "checkbox-radio-style-align": "left", "checkbox-radio-style-layout": "1", "checkbox-view": "classic", "radio-view": "classic", "checkbox-radio-unchecked-color-color1": "#ccc", "checkbox-radio-unchecked-color-color2": "#fff", "checkbox-radio-unchecked-color-color3": "#444", "checkbox-radio-checked-inherit": "on", "checkbox-radio-checked-color-color1": "#ccc", "checkbox-radio-checked-color-color2": "#fff", "checkbox-radio-checked-color-color3": "#444", "imageselect-style-align": "left", "imageselect-style-effect": "none", "imageselect-text-style-family": "", "imageselect-text-style-size": "15", "imageselect-text-style-color": "#444", "imageselect-text-style-bold": "off", "imageselect-text-style-italic": "off", "imageselect-text-style-underline": "off", "imageselect-text-style-align": "left", "imageselect-border-style-width": "1", "imageselect-border-style-style": "solid", "imageselect-border-style-radius": "0", "imageselect-border-style-color": "#ccc", "imageselect-border-style-top": "on", "imageselect-border-style-right": "on", "imageselect-border-style-bottom": "on", "imageselect-border-style-left": "on", "imageselect-shadow-style": "regular", "imageselect-shadow-size": "", "imageselect-shadow-color": "#444", "imageselect-hover-inherit": "on", "imageselect-hover-border-style-width": "1", "imageselect-hover-border-style-style": "solid", "imageselect-hover-border-style-radius": "0", "imageselect-hover-border-style-color": "#ccc", "imageselect-hover-border-style-top": "on", "imageselect-hover-border-style-right": "on", "imageselect-hover-border-style-bottom": "on", "imageselect-hover-border-style-left": "on", "imageselect-hover-shadow-style": "regular", "imageselect-hover-shadow-size": "", "imageselect-hover-shadow-color": "#444", "imageselect-selected-inherit": "on", "imageselect-selected-border-style-width": "1", "imageselect-selected-border-style-style": "solid", "imageselect-selected-border-style-radius": "0", "imageselect-selected-border-style-color": "#ccc", "imageselect-selected-border-style-top": "on", "imageselect-selected-border-style-right": "on", "imageselect-selected-border-style-bottom": "on", "imageselect-selected-border-style-left": "on", "imageselect-selected-shadow-style": "regular", "imageselect-selected-shadow-size": "", "imageselect-selected-shadow-color": "#444", "imageselect-selected-scale": "on", "multiselect-style-align": "left", "multiselect-style-height": "120", "multiselect-style-hover-background": "#26B99A", "multiselect-style-hover-color": "#ffffff", "multiselect-style-selected-background": "#169F85", "multiselect-style-selected-color": "#ffffff", "tile-style-size": "medium", "tile-style-width": "default", "tile-style-position": "left", "tile-style-layout": "inline", "tile-text-style-family": "", "tile-text-style-size": "15", "tile-text-style-color": "#444", "tile-text-style-bold": "off", "tile-text-style-italic": "off", "tile-text-style-underline": "off", "tile-text-style-align": "center", "tile-background-style-image": "", "tile-background-style-size": "auto", "tile-background-style-horizontal-position": "left", "tile-background-style-vertical-position": "top", "tile-background-style-repeat": "repeat", "tile-background-style-color": "#ffffff", "tile-background-style-color2": "", "tile-background-style-gradient": "no", "tile-border-style-width": "1", "tile-border-style-style": "solid", "tile-border-style-radius": "0", "tile-border-style-color": "#ccc", "tile-border-style-top": "on", "tile-border-style-right": "on", "tile-border-style-bottom": "on", "tile-border-style-left": "on", "tile-shadow-style": "regular", "tile-shadow-size": "", "tile-shadow-color": "#444", "tile-hover-inherit": "on", "tile-hover-text-style-family": "", "tile-hover-text-style-size": "15", "tile-hover-text-style-color": "#444", "tile-hover-text-style-bold": "off", "tile-hover-text-style-italic": "off", "tile-hover-text-style-underline": "off", "tile-hover-text-style-align": "center", "tile-hover-background-style-image": "", "tile-hover-background-style-size": "auto", "tile-hover-background-style-horizontal-position": "left", "tile-hover-background-style-vertical-position": "top", "tile-hover-background-style-repeat": "repeat", "tile-hover-background-style-color": "#ffffff", "tile-hover-background-style-color2": "", "tile-hover-background-style-gradient": "no", "tile-hover-border-style-width": "1", "tile-hover-border-style-style": "solid", "tile-hover-border-style-radius": "0", "tile-hover-border-style-color": "#169F85", "tile-hover-border-style-top": "on", "tile-hover-border-style-right": "on", "tile-hover-border-style-bottom": "on", "tile-hover-border-style-left": "on", "tile-hover-shadow-style": "regular", "tile-hover-shadow-size": "", "tile-hover-shadow-color": "#444", "tile-selected-inherit": "on", "tile-selected-text-style-family": "", "tile-selected-text-style-size": "15", "tile-selected-text-style-color": "#444", "tile-selected-text-style-bold": "off", "tile-selected-text-style-italic": "off", "tile-selected-text-style-underline": "off", "tile-selected-text-style-align": "center", "tile-selected-background-style-image": "", "tile-selected-background-style-size": "auto", "tile-selected-background-style-horizontal-position": "left", "tile-selected-background-style-vertical-position": "top", "tile-selected-background-style-repeat": "repeat", "tile-selected-background-style-color": "#ffffff", "tile-selected-background-style-color2": "", "tile-selected-background-style-gradient": "no", "tile-selected-border-style-width": "1", "tile-selected-border-style-style": "solid", "tile-selected-border-style-radius": "0", "tile-selected-border-style-color": "#169F85", "tile-selected-border-style-top": "on", "tile-selected-border-style-right": "on", "tile-selected-border-style-bottom": "on", "tile-selected-border-style-left": "on", "tile-selected-shadow-style": "regular", "tile-selected-shadow-size": "", "tile-selected-shadow-color": "#444", "tile-selected-transform": "zoom-in", "button-style-size": "medium", "button-style-width": "default", "button-style-position": "center", "button-text-style-family": "", "button-text-style-size": "15", "button-text-style-color": "#fff", "button-text-style-bold": "off", "button-text-style-italic": "off", "button-text-style-underline": "off", "button-text-style-align": "center", "button-background-style-image": "", "button-background-style-size": "auto", "button-background-style-horizontal-position": "left", "button-background-style-vertical-position": "top", "button-background-style-repeat": "repeat", "button-background-style-color": "#26B99A", "button-background-style-color2": "", "button-background-style-gradient": "no", "button-border-style-width": "1", "button-border-style-style": "solid", "button-border-style-radius": "0", "button-border-style-color": "#169F85", "button-border-style-top": "on", "button-border-style-right": "on", "button-border-style-bottom": "on", "button-border-style-left": "on", "button-shadow-style": "regular", "button-shadow-size": "", "button-shadow-color": "#444", "button-hover-inherit": "on", "button-hover-text-style-family": "", "button-hover-text-style-size": "15", "button-hover-text-style-color": "#fff", "button-hover-text-style-bold": "off", "button-hover-text-style-italic": "off", "button-hover-text-style-underline": "off", "button-hover-text-style-align": "center", "button-hover-background-style-image": "", "button-hover-background-style-size": "auto", "button-hover-background-style-horizontal-position": "left", "button-hover-background-style-vertical-position": "top", "button-hover-background-style-repeat": "repeat", "button-hover-background-style-color": "#169F85", "button-hover-background-style-color2": "", "button-hover-background-style-gradient": "no", "button-hover-border-style-width": "1", "button-hover-border-style-style": "solid", "button-hover-border-style-radius": "0", "button-hover-border-style-color": "#169F85", "button-hover-border-style-top": "on", "button-hover-border-style-right": "on", "button-hover-border-style-bottom": "on", "button-hover-border-style-left": "on", "button-hover-shadow-style": "regular", "button-hover-shadow-size": "", "button-hover-shadow-color": "#444", "button-active-inherit": "on", "button-active-text-style-family": "", "button-active-text-style-size": "15", "button-active-text-style-color": "#fff", "button-active-text-style-bold": "off", "button-active-text-style-italic": "off", "button-active-text-style-underline": "off", "button-active-text-style-align": "center", "button-active-background-style-image": "", "button-active-background-style-size": "auto", "button-active-background-style-horizontal-position": "left", "button-active-background-style-vertical-position": "top", "button-active-background-style-repeat": "repeat", "button-active-background-style-color": "#169F85", "button-active-background-style-color2": "", "button-active-background-style-gradient": "no", "button-active-border-style-width": "1", "button-active-border-style-style": "solid", "button-active-border-style-radius": "0", "button-active-border-style-color": "#169F85", "button-active-border-style-top": "on", "button-active-border-style-right": "on", "button-active-border-style-bottom": "on", "button-active-border-style-left": "on", "button-active-shadow-style": "regular", "button-active-shadow-size": "", "button-active-shadow-color": "#444", "button-active-transform": "zoom-out", "error-background-style-image": "", "error-background-style-size": "auto", "error-background-style-horizontal-position": "left", "error-background-style-vertical-position": "top", "error-background-style-repeat": "repeat", "error-background-style-color": "#d9534f", "error-background-style-color2": "", "error-background-style-gradient": "no", "error-text-style-family": "", "error-text-style-size": "15", "error-text-style-color": "#fff", "error-text-style-bold": "off", "error-text-style-italic": "off", "error-text-style-underline": "off", "error-text-style-align": "left", "progress-enable": "off", "progress-type": "progress-1", "progress-color-color1": "#e0e0e0", "progress-color-color2": "#26B99A", "progress-color-color3": "#FFFFFF", "progress-color-color4": "#444", "progress-striped": "off", "progress-label-enable": "off", "progress-confirmation-enable": "on", "progress-position": "inside", "confirmation-tab": "confirmation", "confirmations": [], "double-tab": "double", "double-enable": "off", "double-email-recipient": "", "double-email-subject": "Please confirm your email address", "double-email-message": "Dear visitor!<br \/><br \/>Please confirm your email address by clicking the following link:<br \/><a href=\"{{confirmation-url}}\">{{confirmation-url}}<\/a><br \/><br \/>Thanks.", "double-from-email": "{{global-from-email}}", "double-from-name": "{{global-from-name}}", "double-message": "<h4 style=\"text-align: center;\">Thank you!<\/h4><p style=\"text-align: center;\">Your email address successfully confirmed.<\/p>", "double-url": "", "notification-tab": "notification", "notifications": [], "integration-tab": "integration", "integrations": [], "advanced-tab": "advanced", "math-expressions": [], "payment-gateways": [], "misc-save-ip": "on", "misc-save-user-agent": "on", "misc-email-tech-info": "on", "misc-record-tech-info": "on", "antibot-enable": "on", "antibot-delay": "10", "antibot-check-form": "on", "antibot-check-ip": "on", "antibot-error": "Thank you. We have already got your request."}';
    return $tabs_options;
}


if (!function_exists('pre')) {
    function pre($data, $is_exit = true)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($is_exit == true) {
            exit;
        }
    }
}


function default_form_options($_type = 'settings', $chapters = array())
{
    $element_properties_meta = element_properties_meta($chapters);
    $form_options = array();
    if (!array_key_exists($_type, $element_properties_meta))
        return array();
    foreach ($element_properties_meta[$_type] as $key => $value) {
        if (array_key_exists('value', $value)) {
            if (is_array($value['value'])) {
                foreach ($value['value'] as $option_key => $option_value) {
                    $form_options[$key . '-' . $option_key] = $option_value;
                }
            } else
                $form_options[$key] = $value['value'];
        } else if (array_key_exists('values', $value))
            $form_options[$key] = $value['values'];
    }
    return $form_options;
}


function lmsParseTag($content, $class_name)
{
    $dom = new DOMDocument;
    $dom->loadHTML($content);

    $xpath = new DOMXpath($dom);
    $elements = $xpath->query('//*[contains(@class, "' . $class_name . '")]');
    $element_data = array();
    foreach ($elements as $tag) {
        $attr = array();
        foreach ($tag->attributes as $attribName => $attribNodeVal) {
            $attr[$attribName] = $tag->getAttribute($attribName);
        }
        $element_data[] = $attr;
    }
    return $element_data;
}


/*
* Get Sub Chapter Title
*/
function getSubChapterTitle($sub_chapter_id)
{
    $data = \Illuminate\Support\Facades\DB::table('webinar_sub_chapters')
        ->where('id', $sub_chapter_id)
        ->select('sub_chapter_title')
        ->first();

    return isset($data->sub_chapter_title) ? $data->sub_chapter_title : '';
}

function get_chapters_list($include_lessions = true, $webinar_id = 0)
{
    $user = auth()->user();
    $lession_chapters = array();
    if ($include_lessions == true) {
        $lessions = \Illuminate\Support\Facades\DB::table('webinars')
            ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
            ->join('webinar_sub_chapters', 'webinar_sub_chapters.webinar_id', '=', 'webinars.id')
            ->join('text_lessons', 'text_lessons.sub_chapter_id', '=', 'webinar_sub_chapters.id')
            ->join('text_lesson_translations', 'text_lesson_translations.text_lesson_id', '=', 'text_lessons.id')
            ->select('webinars.id', 'webinar_sub_chapters.id as sub_chapter_id', 'webinar_sub_chapters.sub_chapter_title as title', 'text_lessons.id as chapter_id', 'text_lesson_translations.title as chapter_title');
        if ($webinar_id > 0) {
            $lessions->where('webinars.id', $webinar_id);
        }
        $lessions = $lessions->get();


        if (!empty($lessions)) {
            foreach ($lessions as $lessionData) {
                $lession_title = isset($lessionData->title) ? $lessionData->title : '';
                $sub_chapter_id = isset($lessionData->sub_chapter_id) ? $lessionData->sub_chapter_id : '';
                $chapter_id = isset($lessionData->chapter_id) ? $lessionData->chapter_id : '';
                $chapter_title = isset($lessionData->chapter_title) ? $lessionData->chapter_title : '';
                $lession_chapters[$sub_chapter_id][$chapter_id] = $chapter_title;
            }
        }
    }
    //DB::enableQueryLog();
    $webinars = \Illuminate\Support\Facades\DB::table('webinars')
        ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
        ->join('webinar_sub_chapters', 'webinar_sub_chapters.webinar_id', '=', 'webinars.id')
        ->join('webinar_chapter_translations', 'webinar_chapter_translations.webinar_chapter_id', '=', 'webinar_sub_chapters.chapter_id')
        //->join('quizzes', 'quizzes.sub_chapter_id', '=', 'webinar_sub_chapters.id')
        //->join('quiz_translations', 'quiz_translations.quiz_id', '=', 'quizzes.id')
        //->select('webinars.id', 'webinar_sub_chapters.id as sub_chapter_id', 'webinar_sub_chapters.sub_chapter_title as title', 'quizzes.id as chapter_id', 'quiz_translations.title as chapter_title');
        ->select('webinars.id', 'webinar_sub_chapters.id as sub_chapter_id', 'webinar_sub_chapters.sub_chapter_title as title', 'webinar_chapter_translations.webinar_chapter_id as chapter_id', 'webinar_chapter_translations.title as chapter_title');


    if ($user->role_name == 'teachers') {
        $webinars = \Illuminate\Support\Facades\DB::table('webinars')
            ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
            ->join('webinar_sub_chapters', 'webinar_sub_chapters.webinar_id', '=', 'webinars.id')
            ->leftJoin('author_permissions', function ($join) use ($user) {
                $join->on('sub_chapter_id', '=', 'webinar_sub_chapters.id');
            })
            ->join('quizzes', 'quizzes.sub_chapter_id', '=', 'webinar_sub_chapters.id')
            ->join('quiz_translations', 'quiz_translations.quiz_id', '=', 'quizzes.id')
            ->select('webinars.id', 'webinar_sub_chapters.id as sub_chapter_id', 'webinar_sub_chapters.sub_chapter_title as title', 'quizzes.id as chapter_id', 'quiz_translations.title as chapter_title');

        $webinars->where('author_permissions.author_id', $user->id);
    }

    if ($webinar_id > 0) {
        $webinars->where('webinars.id', $webinar_id);
    }


    $webinars = $webinars->get();

    //pre(DB::getQueryLog());
    //DB::disableQueryLog();

    $chapters_list = array();
    if (!empty($webinars)) {
        foreach ($webinars as $webinarData) {
            $webinar_title = isset($webinarData->title) ? $webinarData->title : '';
            $sub_chapter_id = isset($webinarData->sub_chapter_id) ? $webinarData->sub_chapter_id : '';
            $chapter_id = isset($webinarData->chapter_id) ? $webinarData->chapter_id : '';
            $chapter_title = isset($webinarData->chapter_title) ? $webinarData->chapter_title : '';

            $lessions_data = isset($lession_chapters[$sub_chapter_id]) ? $lession_chapters[$sub_chapter_id] : array();

            $chapters_list[$chapter_id]['title'] = $chapter_title;
            $chapters_list[$chapter_id]['chapters'][$sub_chapter_id] = $webinar_title;

            if (!empty($lessions_data)) {
                foreach ($lessions_data as $lession_id => $lessionChapter) {
                    $chapters_list[$sub_chapter_id]['chapters'][$lession_id] = $lessionChapter;
                }
            }
        }
    }

    return $chapters_list;
}


function sub_chapter_items_list($id = 0)
{
    $lessionsQuery = \Illuminate\Support\Facades\DB::table('webinars')
        ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
        ->join('webinar_sub_chapters', 'webinar_sub_chapters.webinar_id', '=', 'webinars.id')
        ->join('text_lessons', 'text_lessons.sub_chapter_id', '=', 'webinar_sub_chapters.id')
        ->join('text_lesson_translations', 'text_lesson_translations.text_lesson_id', '=', 'text_lessons.id')
        ->select('webinars.id', 'webinar_sub_chapters.id as sub_chapter_id', 'webinar_sub_chapters.sub_chapter_title as title', 'text_lessons.id as chapter_id', 'text_lesson_translations.title as chapter_title');
    if ($id > 0) {
        $lessionsQuery->where('webinars.id', $id);
    }
    $lessions = $lessionsQuery->get();

    $lession_chapters = array();
    if (!empty($lessions)) {
        foreach ($lessions as $lessionData) {
            $lession_title = isset($lessionData->title) ? $lessionData->title : '';
            $sub_chapter_id = isset($lessionData->sub_chapter_id) ? $lessionData->sub_chapter_id : '';
            $chapter_id = isset($lessionData->chapter_id) ? $lessionData->chapter_id : '';
            $chapter_title = isset($lessionData->chapter_title) ? $lessionData->chapter_title : '';
            $lession_chapters[$sub_chapter_id][$chapter_id]['title'] = $chapter_title;
            $lession_chapters[$sub_chapter_id][$chapter_id]['type'] = 'lesson';
        }
    }

    $webinarsQuery = \Illuminate\Support\Facades\DB::table('webinars')
        ->join('webinar_translations', 'webinar_translations.webinar_id', '=', 'webinars.id')
        ->join('webinar_sub_chapters', 'webinar_sub_chapters.webinar_id', '=', 'webinars.id')
        ->join('webinar_chapter_items', 'webinar_chapter_items.parent_id', '=', 'webinar_sub_chapters.id')
        ->join('quiz_translations', 'quiz_translations.quiz_id', '=', 'webinar_chapter_items.item_id')
        ->select('webinars.id', 'webinar_sub_chapters.id as sub_chapter_id', 'webinar_sub_chapters.sub_chapter_title as title', 'webinar_chapter_items.id as item_id', 'webinar_chapter_items.item_id as chapter_id', 'quiz_translations.title as chapter_title');
    if ($id > 0) {
        $webinarsQuery->where('webinars.id', $id);
    }
    $webinars = $webinarsQuery->get();

    $chapters_list = array();
    if (!empty($webinars)) {
        foreach ($webinars as $webinarData) {
            $webinar_title = isset($webinarData->title) ? $webinarData->title : '';
            $sub_chapter_id = isset($webinarData->sub_chapter_id) ? $webinarData->sub_chapter_id : '';
            $chapter_id = isset($webinarData->chapter_id) ? $webinarData->chapter_id : '';
            $chapter_title = isset($webinarData->chapter_title) ? $webinarData->chapter_title : '';
            $chapter_item_id = isset($webinarData->item_id) ? $webinarData->item_id : 0;

            $lessions_data = isset($lession_chapters[$sub_chapter_id]) ? $lession_chapters[$sub_chapter_id] : array();

            $chapters_list[$sub_chapter_id]['title'] = $webinar_title;
            $chapters_list[$sub_chapter_id]['chapters'][$chapter_id]['title'] = $chapter_title;
            $chapters_list[$sub_chapter_id]['chapters'][$chapter_id]['type'] = 'quiz';
            $chapters_list[$sub_chapter_id]['chapters'][$chapter_id]['item_id'] = $chapter_item_id;

            if (!empty($lessions_data)) {
                foreach ($lessions_data as $lession_id => $lessionChapter) {
                    $chapters_list[$sub_chapter_id]['chapters'][$lession_id] = $lessionChapter;
                }
            }
        }
    }

    return $chapters_list;
}


function get_glossary_items($glossary_items_ids)
{
    $glossary_items_ids = ($glossary_items_ids != '') ? json_decode($glossary_items_ids) : array();
    $items = \Illuminate\Support\Facades\DB::table('glossary')
        ->select('glossary.*')
        ->WhereIn('glossary.id', $glossary_items_ids)
        ->get();
    return $items;
}

function get_subchapter_items($sub_chapter_id)
{
    $items = \Illuminate\Support\Facades\DB::table('quizzes')
        ->where('quizzes.sub_chapter_id', $sub_chapter_id)
        ->get();
    $quiz_count = $items->count();

    $items = \Illuminate\Support\Facades\DB::table('text_lessons')
        ->where('text_lessons.sub_chapter_id', $sub_chapter_id)
        ->get();
    $lesson_count = $items->count();

    return $quiz_count + $lesson_count;
}


/*
* Creating Quiz Attempt log
*/

function createAttemptLog($attempt_id, $log_details, $log_type = 'started', $result_question_id = 0)
{
    $attemptObj = QuizzAttempts::find($attempt_id);
    $resultObj = QuizzesResult::find($attemptObj->quiz_result_id);

    if ($resultObj->status == 'waiting') {
        $QuizAttemptLog = QuizAttemptLogs::create([
            'attempt_id'         => $attempt_id,
            'result_question_id' => $result_question_id,
            'log_detail'         => $log_details,
            'log_type'           => $log_type,
            'created_at'         => time()
        ]);

        if ($log_type == 'attempt') {
            QuizAttemptLogs::where('attempt_id', $attempt_id)->where('result_question_id', $result_question_id)->where('log_type', 'viewed')->delete();
        }
        return $QuizAttemptLog->id;
    }
    return '';
}

/*
 * Get Differences in Times
 */
function TimeDifference($start_time, $end_time, $return_type = 'minutes')
{

    switch ($return_type) {

        case "minutes":
            $response = ($end_time - $start_time) / 60;
            break;

        case "hours":
            $response = ($end_time - $start_time) / 60 / 60;
            break;
    }
    return $response;
}


function rurera_encode($data_array)
{
    $encoded_string = htmlentities(trim(stripslashes(base64_encode(json_encode($data_array)))));
    return $encoded_string;
}

function rurera_decode($encoded_string)
{
    $decoded_string = json_decode(base64_decode(html_entity_decode($encoded_string)));
    return $decoded_string;
}

function array_neighbor($arr, $key)
{
    krsort($arr);
    $keys = array_keys($arr);
    $keyIndexes = array_flip($keys);

    $return = array();
    if (isset($keys[$keyIndexes[$key] - 1]))
        $return['next'] = $keys[$keyIndexes[$key] - 1];
    if (isset($keys[$keyIndexes[$key] + 1]))
        $return['prev'] = $keys[$keyIndexes[$key] + 1];

    return $return;
}

/*
 * Assign topic to user
 */
function user_assign_topic_template($topic_id, $topic_type, $childs, $parent_assigned_list){
    if (auth()->check() && !auth()->user()->isParent() && !auth()->user()->isTeacher()) {
        return;
    }
    $deadline_date = isset( $parent_assigned_list[$topic_id]['deadline_date'])? date("Y-m-d", $parent_assigned_list[$topic_id]['deadline_date']) : date('Y-m-d');$deadline_date = isset( $parent_assigned_list[$topic_id]['deadline_date'])? date("Y-m-d", $parent_assigned_list[$topic_id]['deadline_date']) : date('Y-m-d');

    ?>
    <div class="dropdown user-assign-topics" data-topic_type="<?php echo $topic_type; ?>" data-topic_id="<?php echo $topic_id; ?>">
        <button class="dropdown-toggle" type="button" id="checkbox"
                data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"></button>
        <div class="dropdown-menu" onclick="event.stopPropagation()">
            <?php if( !empty( $childs) ){
            foreach( $childs as $childObj){
            $is_checked = isset( $parent_assigned_list[$topic_id][$childObj->id])? 'checked' : '';
            ?>
            <div class="checkbox-field">
                <input type="checkbox" name="child_ids[]" value="<?php echo $childObj->id; ?>"
                       id="child_<?php echo $topic_id.'_'.$childObj->id; ?>" <?php echo $is_checked; ?> class="child_ids">
                <label for="child_<?php echo $topic_id.'_'.$childObj->id; ?>"><?php echo $childObj->full_name; ?></label>
            </div>
            <?php } } ?>


            <div class="form-group">
                <span class="input-label">Deadline Date</span>
                    <input type="text" name="deadline" id="singledatepicker_<?php echo $topic_id; ?>" class="deadline singledatepicker form-control mt-10">
            </div>



            <div class="checkbox-btn">
                <button type="button" class="assign-topic-btn btn btn-primary btn-sm">Assign
                </button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#singledatepicker_<?php echo $topic_id; ?>').daterangepicker({
                locale: {
                      format: 'YYYY-MM-DD',
                },
                singleDatePicker: true,
                showDropdowns: false,
                autoApply: true,
                startDate: '<?php echo $deadline_date; ?>',
            });
        });
    </script>
    <?php
}

/*
 * Topic Title by ID
 */
function getTopicTitle($topic_id, $topic_type){

    $topic_title = '';
    if( !empty( $topic_type)){
        switch( $topic_type ){

            case "sats":
                $QuizObj = Quiz::find($topic_id);
                $topic_title = $QuizObj->getTitleAttribute();
            break;

            case "11plus":
                $QuizObj = Quiz::find($topic_id);
                $topic_title = isset( $QuizObj->id)? $QuizObj->getTitleAttribute() : '';
            break;

            case "practice":
                $QuizObj = Quiz::find($topic_id);
                $topic_title = $QuizObj->getTitleAttribute();
            break;

            case "timestables":
                $topic_title = 'Times Tables';
            break;

            case "book_page":
               $bookData = BooksPagesInfoLinks::where('id', $topic_id)->with([
                    'BooksInfoLinkPage',
                    'BooksInfoLinkBookData'
                ])->first();
                $book_title = $bookData->BooksInfoLinkBookData->book_title;
                $page_no = $bookData->BooksInfoLinkPage->page_no;

                $topic_title = $book_title .' Page# '. $page_no;
            break;

            case "assessment":
                $checkChapterItem = WebinarChapterItem::where('item_id', $topic_id)->where('type', 'quiz')->first();
                $SubChaptersData = SubChapters::where('id', $checkChapterItem->parent_id)->first();
                $topic_title = $SubChaptersData->sub_chapter_title;
               break;

            case "vocabulary":
               $QuizObj = Quiz::find($topic_id);
               $topic_title = 'Spells: ';
               $topic_title .= isset( $QuizObj->id)? $QuizObj->getTitleAttribute() : '';
           break;

            case "timestables_assignment":
                $UserAssignedTopics = UserAssignedTopics::find($topic_id);
                $topic_title = 'Times Tables - '.$UserAssignedTopics->StudentAssignmentData->title;
            break;

            case "assignment":
                $UserAssignedTopics = UserAssignedTopics::find($topic_id);
                $topic_title = 'Assignment - '.$UserAssignedTopics->StudentAssignmentData->title;
            break;


        }
    }
    return $topic_title;
}

/*
 * Reward Title by ID
 */
function getRewardTitle($rewardObj){

    $reward_title = trans('update.reward_type_'.$rewardObj->type);
    $reward_title = 'Registration Bonus';
    if( isset( $rewardObj->parent_type) && !empty( $rewardObj->parent_type)){
        switch( $rewardObj->parent_type ){

            case "timestables":
                $reward_title = 'Times Tables';
            break;

            case "assignment":
                $resultObj = QuizzesResult::find($rewardObj->result_id);
                $assignmentTitle = isset( $resultObj->assignment->StudentAssignmentData->title )? $resultObj->assignment->StudentAssignmentData->title : '';
                $reward_title = 'Assignment: '. $assignmentTitle;
            break;

            case "timestables_assignment":
                $resultObj = QuizzesResult::find($rewardObj->result_id);
                $assignmentTitle = isset( $resultObj->assignment->StudentAssignmentData->title )? $resultObj->assignment->StudentAssignmentData->title : '';
                $reward_title = 'Timestables Assignment: '. $assignmentTitle;
            break;


        }
    }
    return $reward_title;
}

/*
 * Get Question Layout File according to the type
 */
function get_question_layout_file($resultLogObj){

    $quiz_result_type = isset( $resultLogObj->quiz_result_type )? $resultLogObj->quiz_result_type : '';
    if( $quiz_result_type == 'assignment'){
        $assignmentObj = $resultLogObj->assignment;
        $quiz_result_type = isset( $assignmentObj->StudentAssignmentData->assignment_type )? $assignmentObj->StudentAssignmentData->assignment_type : '';
    }
    $layout_file = 'question_layout';
    $entrance_exams = array('sats', '11plus','independent_exams','iseb','cat4');
    $layout_file = in_array($quiz_result_type, $entrance_exams)? 'enterance_exams_question_layout' : $layout_file;
    return $layout_file;
}

function get_quiz_question_layout_file($quizObj){

    $quiz_type = isset( $quizObj->quiz_type )? $quizObj->quiz_type : '';
    $layout_file = 'question_layout';
    $entrance_exams = array('sats', '11plus','independent_exams','iseb','cat4');
    $layout_file = (in_array($quiz_type, $entrance_exams) && $quizObj->mock_type == 'mock_exam')? 'enterance_exams_question_layout' : $layout_file;
    return $layout_file;
}



function get_quiz_start_layout_file($quizObj){
    $quiz_type = isset( $quizObj->quiz_type )? $quizObj->quiz_type : '';
    $layout_file = 'start';
    $entrance_exams = array('sats', '11plus','independent_exams','iseb','cat4');
    $layout_file = ($quiz_type == 'vocabulary')? 'spell_start' : $layout_file;
    $layout_file = ($quiz_type == 'practice')? 'course_start' : $layout_file;
    $layout_file = (in_array($quiz_type, $entrance_exams) && $quizObj->mock_type == 'mock_exam')? 'enterance_exams_start' : $layout_file;
    return $layout_file;
}

/*
 * Add Link to Sitemap
 */
    function putSitemap($request, $images = array()){
        //Cache::forget('sitemap');
        //pre('test');

        //$aSiteMap = \Cache::get('sitemap', []);
        $aSiteMap = File::get(storage_path('sitemap.html')); $aSiteMap = (array) json_decode($aSiteMap);
        $aSiteMap = array_map(function ($element) {
            return (array)$element;
        }, $aSiteMap);
        $changefreq = 'always';
        if ( !empty( $aSiteMap[$request['fullUrl']]['added'] ) ) {
            $aDateDiff = Carbon::createFromTimestamp( $aSiteMap[$request['fullUrl']]['added'] )->diff( Carbon::now() );
            if ( $aDateDiff->y > 0 ) {
                $changefreq = 'yearly';
            } else if ( $aDateDiff->m > 0) {
                $changefreq = 'monthly';
            } else if ( $aDateDiff->d > 6 ) {
                $changefreq = 'weekly';
            } else if ( $aDateDiff->d > 0 && $aDateDiff->d < 7 ) {
                $changefreq = 'daily';
            } else if ( $aDateDiff->h > 0 ) {
                $changefreq = 'hourly';
            } else {
                $changefreq = 'always';
            }
        }
        $aSiteMap[$request['fullUrl']] = [
            'added' => time(),
            'lastmod' => Carbon::now()->toIso8601String(),
            'priority' => 1 - substr_count($request['getPathInfo'], '/') / 10,
            'changefreq' => $changefreq,
            'images' => $images,
            /*'images' => [
                    [
                        'loc' => 'https://uk.ixl.com/screenshot/c56a199157dcc9f282cfd4577548b6b1911ff70f.png',
                        'title' => 'Word pattern analogies',
                        'caption' => 'caption',
                    ]
            ],*/
        ];
        $filePath = storage_path('sitemap.html');
        File::put($filePath, json_encode($aSiteMap));
        //\Cache::put('sitemap', $aSiteMap);

    }

    function putSitemap_bk($request, $images = array()){
        //Cache::forget('sitemap');

        $aSiteMap = \Cache::get('sitemap', []);

        $changefreq = 'always';
        if ( !empty( $aSiteMap[$request->fullUrl()]['added'] ) ) {
            $aDateDiff = Carbon::createFromTimestamp( $aSiteMap[$request->fullUrl()]['added'] )->diff( Carbon::now() );
            if ( $aDateDiff->y > 0 ) {
                $changefreq = 'yearly';
            } else if ( $aDateDiff->m > 0) {
                $changefreq = 'monthly';
            } else if ( $aDateDiff->d > 6 ) {
                $changefreq = 'weekly';
            } else if ( $aDateDiff->d > 0 && $aDateDiff->d < 7 ) {
                $changefreq = 'daily';
            } else if ( $aDateDiff->h > 0 ) {
                $changefreq = 'hourly';
            } else {
                $changefreq = 'always';
            }
        }
        $aSiteMap[$request->fullUrl()] = [
            'added' => time(),
            'lastmod' => Carbon::now()->toIso8601String(),
            'priority' => 1 - substr_count($request->getPathInfo(), '/') / 10,
            'changefreq' => $changefreq,
            'images' => $images,
            /*'images' => [
                    [
                        'loc' => 'https://uk.ixl.com/screenshot/c56a199157dcc9f282cfd4577548b6b1911ff70f.png',
                        'title' => 'Word pattern analogies',
                        'caption' => 'caption',
                    ]
            ],*/
        ];
        \Cache::put('sitemap', $aSiteMap, 2880);

    }

function countSubItems($array) {
    $count = 0;

    foreach ($array as $item) {
        if (is_array($item)) {
            $count += countSubItems($item);
        }
    }

    return $count;
}

function countSubItemsOnly($array) {
    $count = 0;
    foreach ($array as $item) {
        if (is_array($item)) {
            $count += count($item);
        }
    }

    return $count;
}

function dates_difference($date1, $date2){
    $diff = abs($date2 - $date1);

    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    return (object)array(
        'years' => $years,
        'months' => $months,
        'days' => $days,
    );
}

function sumNestedArrayValues($array) {
    $sum = 0;

    foreach ($array as $value) {
        if (is_array($value)) {
            // If the element is an array, recursively call the function
            $sum += sumNestedArrayValues($value);
        } else {
            // If the element is not an array, add its value to the sum
            $sum += $value;
        }
    }

    return $sum;
}


function svgAvatars_validate_filename( $name ) {
	$file = array(
		'name' => '',
		'type' => ''
	);
	// the file extentions must be exactly png or svg
	if ( ( $name && strrpos( $name, 'png', -3 ) !== false ) || ( $name && strrpos( $name, 'svg', -3 ) !== false ) ) {
		list( $file['name'], $file['type'] ) = explode( '.', $name );

		// file name must start with 'svgA' and following digits only
		if ( preg_match( '/^(svgA)[0-9]+$/', $file['name'] ) !== 1 ) {
			$file['name'] = 'invalid';
			$file['type'] = 'invalid';
		}
	} else {
		$file['name'] = 'invalid';
		$file['type'] = 'invalid';
	}
	return $file;
}

function svgAvatars_sanitize_downloading_name( $name ) {
	//Strip out any % encoded octets
	$sanitized = preg_replace( '|%[a-fA-F0-9][a-fA-F0-9]|', '', $name );
	//Limit to A-Z,a-z,0-9,_,-
	$sanitized = preg_replace( '/[^A-Za-z0-9_-]/', '', $sanitized );
	return $sanitized;
}

function svgAvatars_validate_imagedata( $data, $filetype ) {
	if ( $filetype === 'png' ) {
		if ( ( substr( $data, 0, 22 ) ) !== 'data:image/png;base64,' ) {
			// doesn't contain the expected first 22 characters
			return false;
		}
		$base64 = str_replace('data:image/png;base64,', '', $data);
		if ( ( base64_encode( base64_decode( $base64, true ) ) ) !== $base64) {
			// decoding and re-encoding the data fails
			return false;
		}
		// all is fine
		return $base64;
	} elseif ( $filetype === 'svg' ) {
		// sanitize SVG before saving on disk
		$svg = new svgAvatarsSvgCodeSanitizer();
		$svg->load_svg( $data );
		$svg->sanitize_svg();
		$sanitized_svg = $svg->save_svg();
		return $sanitized_svg;
	} else {
		return false;
	}
}

// whitelisting all the SVG code
class svgAvatarsSvgCodeSanitizer {

	private $document;
	private static $whitelist_elems = array();
	private static $whitelist_attrs = array();

	function __construct() {
		global $svgAvatars_svgcode_whitelist_elems;
		global $svgAvatars_svgcode_whitelist_attrs;

		$this->document = new DOMDocument();
		$this->document->preserveWhiteSpace = false;

		require_once 'svg-whitelist.php';
		self::$whitelist_elems = $svgAvatars_svgcode_whitelist_elems;
		self::$whitelist_attrs = $svgAvatars_svgcode_whitelist_attrs;
	}

	function load_svg( $data ) {
		$this->document->loadXML( stripcslashes( $data ) );
	}

	function sanitize_svg() {
		$elems = $this->document->getElementsByTagName( "*" );
		for( $i = 0; $i < $elems->length; $i++ ) {
			$node = $elems->item($i);
			$tag_name = $node->tagName;
			if( in_array( $tag_name, self::$whitelist_elems ) ) {
				for( $j = 0; $j < $node->attributes->length; $j++ ) {
					$attr_name = $node->attributes->item($j)->name;
					if( ! in_array( $attr_name, self::$whitelist_attrs ) ) {
						$node->removeAttribute( $attr_name );
					}
				}
			} else {
				$node->parentNode->removeChild( $node );
			}
		}
	}

	function save_svg() {
		$this->document->formatOutput = true;
		return $this->document->saveXML();
	}
}

function getTimeWithText($secondsString, $show_empty = true) {
    $h = floor($secondsString / 3600); // Get whole hours
    $secondsString -= $h * 3600;
    $m = floor($secondsString / 60); // Get remaining minutes
    $secondsString -= $m * 60;

    $return_string = '';
    if ($h > 0) {
        $return_string .= $h . "h ";
    }
    if ($m > 0) {
        $return_string .= ($m < 10 ? '0' . $m : $m) . "m ";
    }
    $secondsString  = round($secondsString, 2);

    if( $secondsString > 0 || $show_empty == true) {
        $return_string .= ($secondsString < 10 ? '0' . $secondsString : $secondsString);
        $return_string .= 's';
    }
    return $return_string;
}

function getTime($secondsString) {
    $h = floor($secondsString / 3600); // Get whole hours
    $secondsString -= $h * 3600;
    $m = floor($secondsString / 60); // Get remaining minutes
    $secondsString -= $m * 60;

    $return_string = '';
    if ($h > 0) {
        $return_string .= $h . ":";
    }
    if ($m > 0) {
        $return_string .= ($m < 10 ? '0' . $m : $m) . ":";
    }
    $return_string .= ($secondsString < 10 ? '0' . $secondsString : $secondsString);

    return $return_string;
}

function getTimestablesLimit(){
    return 60;
}

function getGuestLimit($type){
    $limit = 10;
    switch ($type) {
        case "vocabulary":
            $limit = 10;
            break;
        case "sats":
            $limit = 100;
            break;
        case "books":
            $limit = 5;
            break;
    }
    return $limit;
}

function isKeyValueFoundInMultiArray($multiArray, $searchKey, $searchValue) {
    // Flag to indicate if the key and value are found
    $keyValueFound = false;
    $foundArray = array();

    // Loop through each child array
    foreach ($multiArray as $childArray) {
        $childArray = (array) $childArray;
        // Check if the key exists in the child array and if the corresponding value matches
        if (isset($childArray[$searchKey]) && $childArray[$searchKey] == $searchValue) {
            // Key and value found
            $keyValueFound = true;
            $foundArray = $childArray;
            break; // Break out of the loop since we found what we were looking for
        }
    }

    // Return the result
    return array(
            'is_found' => $keyValueFound,
            'foundArray' => $foundArray,
    );
}

function searchNuggetByID($array, $key, $value, $parentLevel = null, $grandparentLevel = null) {
    foreach ($array as $item) {
        if (isset($item[$key]) && $item[$key] === $value) {
            $item['stageData'] = $parentLevel;
            $item['levelData'] = $grandparentLevel;
            return $item;
        }

        if (isset($item['stages']) && is_array($item['stages'])) {
            $result = searchNuggetByID($item['stages'], $key, $value, [
                'id' => $item['id'],
                'title' => $item['title'],
                'time_interval' => isset( $item['time_interval'] )? $item['time_interval'] : 0,
                'life_lines' => isset( $item['life_lines'] )? $item['life_lines'] : 0,
            ], $parentLevel);
            if ($result !== null) {
                return $result;
            }
        }

        if (isset($item['nuggets']) && is_array($item['nuggets'])) {
            $result = searchNuggetByID($item['nuggets'], $key, $value, [
                'id' => $item['id'],
                'title' => $item['title'],
                'time_interval' => isset( $item['time_interval'] )? $item['time_interval'] : 0,
                'life_lines' => isset( $item['life_lines'] )? $item['life_lines'] : 0,
            ], $parentLevel);
            if ($result !== null) {
                return $result;
            }
        }
    }

    return null;
}

function getNextNuggetByCurrentID($array, $key, $value, $parentLevel = null, $grandparentLevel = null, $found = false) {
    foreach ($array as $item) {
        if ($found) {
            $item['stageData'] = $parentLevel;
            $item['levelData'] = $grandparentLevel;
            return $item;
        }

        if (isset($item[$key]) && $item[$key] === $value) {
            $found = true;
        }

        if (isset($item['stages']) && is_array($item['stages'])) {
            $result = getNextNuggetByCurrentID($item['stages'], $key, $value, [
                'id' => $item['id'],
                'title' => $item['title'],
                'time_interval' => isset($item['time_interval']) ? $item['time_interval'] : 0,
                'life_lines' => isset($item['life_lines']) ? $item['life_lines'] : 0,
            ], $parentLevel, $found);
            if ($result !== null) {
                return $result;
            }
        }

        if (isset($item['nuggets']) && is_array($item['nuggets'])) {
            $result = getNextNuggetByCurrentID($item['nuggets'], $key, $value, [
                'id' => $item['id'],
                'title' => $item['title'],
                'time_interval' => isset($item['time_interval']) ? $item['time_interval'] : 0,
                'life_lines' => isset($item['life_lines']) ? $item['life_lines'] : 0,
            ], $parentLevel, $found);
            if ($result !== null) {
                return $result;
            }
        }
    }

    return null;
}
/*
 * Get array lenght
 */
function array_limit_length($array_data, $length_value){

   $arrayList = array_rand($array_data, $length_value);
    $arrayList = is_array($arrayList)? $arrayList : array($arrayList);
    $arrayList = array_intersect_key($array_data, array_flip($arrayList));
    $arrayList = array_values($arrayList);
    return $arrayList;

}

function getQuizTypeTitle($quiz_type){
    $quiz_types_array = array(
        '11plus' => '11Plus',
        'sats' => 'Sats',
        'independent_exams' => 'Independent Exams',
        'iseb' => 'ISEB',
        'cat4' => 'CAT 4',
        'challenge' => 'Challenge',
        'vocabulary' => 'Vocabulary',
    );

    return isset( $quiz_types_array[$quiz_type] )? $quiz_types_array[$quiz_type] : '';
}
function find_array_index_by_value($data, $value_key){
    $return_data = array();
    if( !empty( $data ) ) {
        foreach ($data as $category => $options) {
            foreach ($options as $key => $values) {
                if (is_array($values) && in_array($value_key, $values)) {
                    $index = array_search($value_key, $values);
                    $return_data['main_index'] = $category;
                    $return_data['parent_index'] = $key;
                    $return_data['value_index'] = $index;
                    break 2; // break both loops
                }
            }
        }
    }
    return $return_data;
}

function get_treasure_missions(){
    $treasure_missions = array(
        array(
            'title'  => 'Polaris',
            'description' => '',
            'is_locked' => false,
            'img'  => '/assets/default/svgs/filter-all.svg',
            'id' => 'mission_1',
        ),
        array(
            'title'  => 'Sirius',
            'description' => '',
            'is_locked' => true,
            'img'  => '/assets/default/img/mission-lock.png',
            'id' => 'mission_2',
        ),
        array(
            'title'  => 'Centauri',
            'description' => '',
            'is_locked' => true,
            'img'  => '/assets/default/img/mission-lock.png',
            'id' => 'mission_3',
        ),
        array(
            'title'  => 'Betelgeuse',
            'description' => '',
            'is_locked' => true,
            'img'  => '/assets/default/img/mission-lock.png',
            'id' => 'mission_4',
        ),
        array(
            'title'  => 'Rigel',
            'description' => '',
            'is_locked' => true,
            'img'  => '/assets/default/img/mission-lock.png',
            'id' => 'mission_5',
        ),
        array(
            'title'  => 'Vega',
            'description' => '',
            'is_locked' => true,
            'img'  => '/assets/default/img/mission-lock.png',
            'id' => 'mission_6',
        ),
        array(
            'title'  => 'Pleiades',
            'description' => '',
            'is_locked' => true,
            'img'  => '/assets/default/img/mission-lock.png',
            'id' => 'mission_7',
        ),
        array(
            'title'  => 'Canopus',
            'description' => '',
            'is_locked' => true,
            'img'  => '/assets/default/img/mission-lock.png',
            'id' => 'mission_8',
        ),

    );
    return $treasure_missions;
}
function get_treasure_mission_data(){
    $treasure_mission_data = array(
                array(
                    'title'  => 'Level 1',
                    'description' => 'You’ll start with ten questions on the 10× table; then ten questions on the 2×, 5×, etc. 
                    You’ll have 30 questions and only 5 seconds for each question.',
                    'id' => 'level_1',
                    'mission_id' => 'mission_1',
                    'time_interval' => 5,
                    'per_stage_questions' => 30,
                    'coins' => 1,
                    'life_lines' => 5,
                    'stages' => array(
                        array(
                            'title'   => 'Stage 1',
                            'id' => 'stage_1_1',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_1_1_1','prev_no_questions' => 0, 'previous_tables' => [], 'tables' => [2  => 15,10 => 15]),
                                array('title'  => 'Nugget #2','id' => 'nugget_1_1_2','prev_no_questions' => 10, 'previous_tables' => [2,10], 'tables' => [3 => 20]),
                                array('title'  => 'Nugget #3','id' => 'nugget_1_1_3','prev_no_questions' => 10, 'previous_tables' => [2,10,3], 'tables' => [4 => 20]),
                                array('title'  => 'Nugget #4','id' => 'nugget_1_1_4','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4], 'tables' => [5 => 20]),
                                array('title'  => 'Nugget #5','id' => 'nugget_1_1_5','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 2',
                            'id' => 'stage_1_2',
                            'custom_class' => 'ul-rtl',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_1_2_1','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4,5], 'tables' => [6 => 20]),
                                array('title'  => 'Nugget #2','id' => 'nugget_1_2_2','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4,5,6], 'tables' => [7 => 20]),
                                array('title'  => 'Nugget #3','id' => 'nugget_1_2_3','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4,5,6,7], 'tables' => [8 => 20]),
                                array('title'  => 'Nugget #4','id' => 'nugget_1_2_4','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4,5,6,7,8], 'tables' => [9 => 20]),
                                array('title'  => 'Nugget #5','id' => 'nugget_1_2_5','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 3',
                            'id' => 'stage_1_3',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_1_3_1','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [10 => 20]),
                                array('title'  => 'Nugget #2','id' => 'nugget_1_3_2','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10], 'tables' => [11 => 20]),
                                array('title'  => 'Nugget #3','id' => 'nugget_1_3_3','prev_no_questions' => 10, 'previous_tables' => [2,10,3,4,5,6,7,8,9,11], 'tables' => [12 => 20]),
                                array('title'  => 'Nugget #4','id' => 'nugget_1_3_4','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                                array('title'  => 'Nugget #5','id' => 'nugget_1_3_5','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [], 'treasure_box' => 100),
                            ),
                        ),
                        array(
                           'title'   => 'Stage 4',
                           'id' => 'stage_1_4',
                           'custom_class' => 'ul-rtl',
                           'nuggets' => array(
                               array('title'  => 'Nugget #1','id' => 'nugget_1_4_1','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #2','id' => 'nugget_1_4_2','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #3','id' => 'nugget_1_4_3','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #4','id' => 'nugget_1_4_4','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #5','id' => 'nugget_1_4_5','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [],'is_last_stage' => true),
                           ),
                       ),
                    )
                ),

                array(
                    'title'  => 'Level 2',
                    'description' => 'You’ll start with twenty five questions on the 10× table; then twenty five questions on the 2×, 5×, etc. 
                    You’ll have 50 questions and only 4 seconds for each question.',
                    'id' => 'level_2',
                    'mission_id' => 'mission_1',
                    'time_interval' => 4,
                    'per_stage_questions' => 50,
                    'coins' => 2,
                    'life_lines' => 5,
                    'stages' => array(
                        array(
                            'title'   => 'Stage 1',
                            'id' => 'stage_2_1',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_2_1_1','prev_no_questions' => 0, 'previous_tables' => [], 'tables' => [2  => 25,10 => 25]),
                                array('title'  => 'Nugget #2','id' => 'nugget_2_1_2','prev_no_questions' => 20, 'previous_tables' => [2,10], 'tables' => [3 => 30]),
                                array('title'  => 'Nugget #3','id' => 'nugget_2_1_3','prev_no_questions' => 20, 'previous_tables' => [2,10,3], 'tables' => [4 => 30]),
                                array('title'  => 'Nugget #4','id' => 'nugget_2_1_4','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4], 'tables' => [5 => 30]),
                                array('title'  => 'Nugget #5','id' => 'nugget_2_1_5','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 2',
                            'id' => 'stage_2_2',
                            'custom_class' => 'ul-rtl',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_2_2_1','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4,5], 'tables' => [6 => 30]),
                                array('title'  => 'Nugget #2','id' => 'nugget_2_2_2','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4,5,6], 'tables' => [7 => 30]),
                                array('title'  => 'Nugget #3','id' => 'nugget_2_2_3','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4,5,6,7], 'tables' => [8 => 30]),
                                array('title'  => 'Nugget #4','id' => 'nugget_2_2_4','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4,5,6,7,8], 'tables' => [9 => 30]),
                                array('title'  => 'Nugget #5','id' => 'nugget_2_2_5','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 3',
                            'id' => 'stage_2_3',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_2_3_1','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [10 => 30]),
                                array('title'  => 'Nugget #2','id' => 'nugget_2_3_2','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10], 'tables' => [11 => 30]),
                                array('title'  => 'Nugget #3','id' => 'nugget_2_3_3','prev_no_questions' => 20, 'previous_tables' => [2,10,3,4,5,6,7,8,9,11], 'tables' => [12 => 30]),
                                array('title'  => 'Nugget #4','id' => 'nugget_2_3_4','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                                array('title'  => 'Nugget #5','id' => 'nugget_2_3_5','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [], 'treasure_box' => 100),
                            ),
                        ),
                        array(
                           'title'   => 'Stage 4',
                           'id' => 'stage_2_4',
                           'custom_class' => 'ul-rtl',
                           'nuggets' => array(
                               array('title'  => 'Nugget #1','id' => 'nugget_2_4_1','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #2','id' => 'nugget_2_4_2','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #3','id' => 'nugget_2_4_3','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #4','id' => 'nugget_2_4_4','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #5','id' => 'nugget_2_4_5','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [],'is_last_stage' => true),
                           ),
                       ),
                    )
                ),

                array(
                    'title'  => 'Level 3',
                    'description' => 'You’ll start with fifty questions on the 10× table; then fifty questions on the 2×, 5×, etc. 
                    You’ll have 100 questions and only 3 seconds for each question.',
                    'id' => 'level_3',
                    'mission_id' => 'mission_1',
                    'time_interval' => 3,
                    'per_stage_questions' => 100,
                    'coins' => 3,
                    'life_lines' => 5,
                    'stages' => array(
                        array(
                            'title'   => 'Stage 1',
                            'id' => 'stage_3_1',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_3_1_1','prev_no_questions' => 0, 'previous_tables' => [], 'tables' => [2  => 50,10 => 50]),
                                array('title'  => 'Nugget #2','id' => 'nugget_3_1_2','prev_no_questions' => 30, 'previous_tables' => [2,10], 'tables' => [3 => 70]),
                                array('title'  => 'Nugget #3','id' => 'nugget_3_1_3','prev_no_questions' => 30, 'previous_tables' => [2,10,3], 'tables' => [4 => 70]),
                                array('title'  => 'Nugget #4','id' => 'nugget_3_1_4','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4], 'tables' => [5 => 70]),
                                array('title'  => 'Nugget #5','id' => 'nugget_3_1_5','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 2',
                            'id' => 'stage_3_2',
                            'custom_class' => 'ul-rtl',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_3_2_1','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5], 'tables' => [6 => 70]),
                                array('title'  => 'Nugget #2','id' => 'nugget_3_2_2','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6], 'tables' => [7 => 70]),
                                array('title'  => 'Nugget #3','id' => 'nugget_3_2_3','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7], 'tables' => [8 => 70]),
                                array('title'  => 'Nugget #4','id' => 'nugget_3_2_4','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8], 'tables' => [9 => 70]),
                                array('title'  => 'Nugget #5','id' => 'nugget_3_2_5','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 3',
                            'id' => 'stage_3_3',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_3_3_1','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [10 => 70]),
                                array('title'  => 'Nugget #2','id' => 'nugget_3_3_2','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10], 'tables' => [11 => 70]),
                                array('title'  => 'Nugget #3','id' => 'nugget_3_3_3','prev_no_questions' => 30, 'previous_tables' => [2,10,3,4,5,6,7,8,9,11], 'tables' => [12 => 70]),
                                array('title'  => 'Nugget #4','id' => 'nugget_3_3_4','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                                array('title'  => 'Nugget #5','id' => 'nugget_3_3_5','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [], 'treasure_box' => 100),
                            ),
                        ),
                        array(
                           'title'   => 'Stage 4',
                           'id' => 'stage_3_4',
                           'custom_class' => 'ul-rtl',
                           'nuggets' => array(
                               array('title'  => 'Nugget #1','id' => 'nugget_3_4_1','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #2','id' => 'nugget_3_4_2','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #3','id' => 'nugget_3_4_3','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #4','id' => 'nugget_3_4_4','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #5','id' => 'nugget_3_4_5','prev_no_questions' => 100, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [],'is_last_stage' => true),
                           ),
                       ),
                    )
                ),

                array(
                    'title'  => 'Level 4',
                    'description' => 'You’ll start with seventy five questions on the 10× table; then seventy five questions on the 2×, 5×, etc. 
                    You’ll have 150 questions and only 2 seconds for each question.',
                    'id' => 'level_4',
                    'mission_id' => 'mission_1',
                    'time_interval' => 2,
                    'per_stage_questions' => 150,
                    'coins' => 4,
                    'life_lines' => 5,
                    'stages' => array(
                        array(
                            'title'   => 'Stage 1',
                            'id' => 'stage_4_1',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_4_1_1','prev_no_questions' => 0, 'previous_tables' => [], 'tables' => [2  => 50,10 => 50]),
                                array('title'  => 'Nugget #2','id' => 'nugget_4_1_2','prev_no_questions' => 50, 'previous_tables' => [2,10], 'tables' => [3 => 100]),
                                array('title'  => 'Nugget #3','id' => 'nugget_4_1_3','prev_no_questions' => 50, 'previous_tables' => [2,10,3], 'tables' => [4 => 100]),
                                array('title'  => 'Nugget #4','id' => 'nugget_4_1_4','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4], 'tables' => [5 => 100]),
                                array('title'  => 'Nugget #5','id' => 'nugget_4_1_5','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 2',
                            'id' => 'stage_4_2',
                            'custom_class' => 'ul-rtl',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_4_2_1','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5], 'tables' => [6 => 100]),
                                array('title'  => 'Nugget #2','id' => 'nugget_4_2_2','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6], 'tables' => [7 => 100]),
                                array('title'  => 'Nugget #3','id' => 'nugget_4_2_3','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7], 'tables' => [8 => 100]),
                                array('title'  => 'Nugget #4','id' => 'nugget_4_2_4','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8], 'tables' => [9 => 100]),
                                array('title'  => 'Nugget #5','id' => 'nugget_4_2_5','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 3',
                            'id' => 'stage_4_3',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_4_3_1','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [10 => 100]),
                                array('title'  => 'Nugget #2','id' => 'nugget_4_3_2','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10], 'tables' => [11 => 100]),
                                array('title'  => 'Nugget #3','id' => 'nugget_4_3_3','prev_no_questions' => 50, 'previous_tables' => [2,10,3,4,5,6,7,8,9,11], 'tables' => [12 => 100]),
                                array('title'  => 'Nugget #4','id' => 'nugget_4_3_4','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                                array('title'  => 'Nugget #5','id' => 'nugget_4_3_5','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [], 'treasure_box' => 100),
                            ),
                        ),
                        array(
                           'title'   => 'Stage 4',
                           'id' => 'stage_4_4',
                           'custom_class' => 'ul-rtl',
                           'nuggets' => array(
                               array('title'  => 'Nugget #1','id' => 'nugget_4_4_1','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #2','id' => 'nugget_4_4_2','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #3','id' => 'nugget_4_4_3','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #4','id' => 'nugget_4_4_4','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #5','id' => 'nugget_4_4_5','prev_no_questions' => 150, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [],'is_last_stage' => true),
                           ),
                       ),
                    )
                ),
                
                array(
                    'title'  => 'Level 5',
                    'description' => 'You’ll start with hundred questions on the 10× table; then hundred questions on the 2×, 5×, etc. 
                    You’ll have 200 questions and only 1 second for each question.',
                    'id' => 'level_5',
                    'mission_id' => 'mission_1',
                    'time_interval' => 1,
                    'per_stage_questions' => 200,
                    'coins' => 5,
                    'life_lines' => 5,
                    'stages' => array(
                        array(
                            'title'   => 'Stage 1',
                            'id' => 'stage_5_1',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_5_1_1','prev_no_questions' => 0, 'previous_tables' => [], 'tables' => [2  => 65,10 => 65]),
                                array('title'  => 'Nugget #2','id' => 'nugget_5_1_2','prev_no_questions' => 70, 'previous_tables' => [2,10], 'tables' => [3 => 130]),
                                array('title'  => 'Nugget #3','id' => 'nugget_5_1_3','prev_no_questions' => 70, 'previous_tables' => [2,10,3], 'tables' => [4 => 130]),
                                array('title'  => 'Nugget #4','id' => 'nugget_5_1_4','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4], 'tables' => [5 => 130]),
                                array('title'  => 'Nugget #5','id' => 'nugget_5_1_5','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 2',
                            'id' => 'stage_5_2',
                            'custom_class' => 'ul-rtl',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_5_2_1','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4,5], 'tables' => [6 => 130]),
                                array('title'  => 'Nugget #2','id' => 'nugget_5_2_2','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4,5,6], 'tables' => [7 => 130]),
                                array('title'  => 'Nugget #3','id' => 'nugget_5_2_3','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4,5,6,7], 'tables' => [8 => 130]),
                                array('title'  => 'Nugget #4','id' => 'nugget_5_2_4','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4,5,6,7,8], 'tables' => [9 => 130]),
                                array('title'  => 'Nugget #5','id' => 'nugget_5_2_5','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [], 'treasure_box' => 100),

                            ),
                        ),
                        array(
                            'title'   => 'Stage 3',
                            'id' => 'stage_5_3',
                            'custom_class' => '',
                            'nuggets' => array(
                                array('title'  => 'Nugget #1','id' => 'nugget_5_3_1','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4,5,6,7,8,9], 'tables' => [10 => 130]),
                                array('title'  => 'Nugget #2','id' => 'nugget_5_3_2','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10], 'tables' => [11 => 130]),
                                array('title'  => 'Nugget #3','id' => 'nugget_5_3_3','prev_no_questions' => 70, 'previous_tables' => [2,10,3,4,5,6,7,8,9,11], 'tables' => [12 => 130]),
                                array('title'  => 'Nugget #4','id' => 'nugget_5_3_4','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                                array('title'  => 'Nugget #5','id' => 'nugget_5_3_5','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [], 'treasure_box' => 100),
                            ),
                        ),
                        array(
                           'title'   => 'Stage 4',
                           'id' => 'stage_5_4',
                           'custom_class' => 'ul-rtl',
                           'nuggets' => array(
                               array('title'  => 'Nugget #1','id' => 'nugget_5_4_1','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #2','id' => 'nugget_5_4_2','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #3','id' => 'nugget_5_4_3','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #4','id' => 'nugget_5_4_4','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => []),
                               array('title'  => 'Nugget #5','id' => 'nugget_5_4_5','prev_no_questions' => 200, 'previous_tables' => [2,10,3,4,5,6,7,8,9,10,11,12], 'tables' => [],'is_last_stage' => true),
                           ),
                       ),
                    )
                ),
            );

    return $treasure_mission_data;
}


function emojisList(){

    $emojisList = array(
            'icon1','icon2','icon3','icon4','icon5','icon6','icon7','icon8','icon9','icon10','icon11','icon12','icon13','icon14','icon15','icon16','icon17','icon18','icon19','icon20',
            'icon21','icon22','icon23','icon24','icon25','icon26','icon27','icon28','icon29','icon30','icon31','icon32','icon33','icon34','icon35','icon36','icon37','icon38','icon39','icon40',
            'icon41','icon42','icon43','icon44','icon45','icon46','icon47','icon48','icon49','icon50','icon51','icon52','icon53','icon54','icon55','icon56','icon57','icon58','icon59','icon60',
            'icon61','icon62','icon63','icon64','icon65','icon66','icon67','icon68','icon69','icon70','icon71','icon72','icon73','icon74','icon75','icon76','icon77',
    );

    return $emojisList;

}


function get_trophy_badge($average_questions){
    $trophy_badges = array(
        '0.5' => 'Maestro',
        '0.7' => 'Expert',
        '0.9' => 'Majesty',
        '1' => 'Mastery',
        '1.5' => 'Champion',
        '2' => 'Creative',
        '3' => 'Genius',
        '4' => 'Brainy',
        '5' => 'Smarty',
        '10' => 'Junior',
       '1000' => 'Explorer',
    );
    $return_badge = '';
    foreach ($trophy_badges as $key => $value) {
        if ($average_questions <= $key) {
            $return_badge = $value;
            break;
        }
    }
    return $return_badge;

}

function getAllowedUsers(){
    return array(
        1133,
        1160,
    );
}

function subscriptionCheckLink($subscription_check){
    $response = '';
    if (!auth()->subscription($subscription_check)) {
        $response = 'subscription-required';
    }
    return $response;
}