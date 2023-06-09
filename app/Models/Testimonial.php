<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Testimonial extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'testimonials';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    static $contries_list = [
        'Afghanistan' ,
        'Albania' ,
        'Algeria' ,
        'Andorra' ,
        'Angola' ,
        'Antigua and Barbuda' ,
        'Argentina' ,
        'Armenia' ,
        'Australia' ,
        'Austria' ,
        'Azerbaijan' ,
        'Bahamas' ,
        'Bahrain' ,
        'Bangladesh' ,
        'Barbados' ,
        'Belarus' ,
        'Belgium' ,
        'Belize' ,
        'Benin' ,
        'Bhutan' ,
        'Bolivia' ,
        'Bosnia and Herzegovina' ,
        'Botswana' ,
        'Brazil' ,
        'Brunei' ,
        'Bulgaria' ,
        'Burkina Faso' ,
        'Burundi' ,
        'Cabo Verde' ,
        'Cambodia' ,
        'Cameroon' ,
        'Canada' ,
        'Central African Republic' ,
        'Chad' ,
        'Chile' ,
        'China' ,
        'Colombia' ,
        'Comoros' ,
        'Congo (Congo-Brazzaville)' ,
        'Costa Rica' ,
        'Croatia' ,
        'Cuba' ,
        'Cyprus' ,
        'Czechia (Czech Republic)' ,
        'Democratic Republic of the Congo' ,
        'Denmark' ,
        'Djibouti' ,
        'Dominica' ,
        'Dominican Republic' ,
        'Ecuador' ,
        'Egypt' ,
        'El Salvador' ,
        'Equatorial Guinea' ,
        'Eritrea' ,
        'Estonia' ,
        'Eswatini (fmr. "Swaziland")' ,
        'Ethiopia' ,
        'Fiji' ,
        'Finland' ,
        'France' ,
        'Gabon' ,
        'Gambia' ,
        'Georgia' ,
        'Germany' ,
        'Ghana' ,
        'Greece' ,
        'Grenada' ,
        'Guatemala' ,
        'Guinea' ,
        'Guinea-Bissau' ,
        'Guyana' ,
        'Haiti' ,
        'Holy See' ,
        'Honduras' ,
        'Hungary' ,
        'Iceland' ,
        'India' ,
        'Indonesia' ,
        'Iran' ,
        'Iraq' ,
        'Ireland' ,
        'Israel' ,
        'Italy' ,
        'Jamaica' ,
        'Japan' ,
        'Jordan' ,
        'Kazakhstan' ,
        'Kenya' ,
        'Kiribati' ,
        'Kuwait' ,
        'Kyrgyzstan' ,
        'Laos' ,
        'Latvia' ,
        'Lebanon' ,
        'Lesotho' ,
        'Liberia' ,
        'Libya' ,
        'Liechtenstein' ,
        'Lithuania' ,
        'Luxembourg' ,
        'Madagascar' ,
        'Malawi' ,
        'Malaysia' ,
        'Maldives' ,
        'Mali' ,
        'Malta' ,
        'Marshall Islands' ,
        'Mauritania' ,
        'Mauritius' ,
        'Mexico' ,
        'Micronesia' ,
        'Moldova' ,
        'Monaco' ,
        'Mongolia' ,
        'Montenegro' ,
        'Morocco' ,
        'Mozambique' ,
        'Myanmar (formerly Burma)' ,
        'Namibia' ,
        'Nauru' ,
        'Nepal' ,
        'Netherlands' ,
        'new Zealand' ,
        'Nicaragua' ,
        'Niger' ,
        'Nigeria' ,
        'North Korea' ,
        'North Macedonia' ,
        'Norway' ,
        'Oman' ,
        'Pakistan' ,
        'Palau' ,
        'Palestine State' ,
        'Panama' ,
        'Papua new Guinea' ,
        'Paraguay' ,
        'Peru' ,
        'Philippines' ,
        'Poland' ,
        'Portugal' ,
        'Qatar' ,
        'Romania' ,
        'Russia' ,
        'Rwanda' ,
        'Saint Kitts and Nevis' ,
        'Saint Lucia' ,
        'Saint Vincent and the Grenadines' ,
        'Samoa' ,
        'San Marino' ,
        'Sao Tome and Principe' ,
        'Saudi Arabia' ,
        'Senegal' ,
        'Serbia' ,
        'Seychelles' ,
        'Sierra Leone' ,
        'Singapore' ,
        'Slovakia' ,
        'Slovenia' ,
        'Solomon Islands' ,
        'Somalia' ,
        'South Africa' ,
        'South Korea' ,
        'South Sudan' ,
        'Spain' ,
        'Sri Lanka' ,
        'Sudan' ,
        'Suriname' ,
        'Sweden' ,
        'Switzerland' ,
        'Syria' ,
        'Tajikistan' ,
        'Tanzania' ,
        'Thailand' ,
        'Timor-Leste' ,
        'Togo' ,
        'Tonga' ,
        'Trinidad and Tobago' ,
        'Tunisia' ,
        'Turkey' ,
        'Turkmenistan' ,
        'Tuvalu' ,
        'Uganda' ,
        'Ukraine' ,
        'United Arab Emirates' ,
        'United Kingdom' ,
        'United States of America' ,
        'Uruguay' ,
        'Uzbekistan' ,
        'Vanuatu' ,
        'Venezuela' ,
        'Vietnam' ,
        'Yemen' ,
        'Zambia' ,
        'Zimbabwe'
    ];

    public $translatedAttributes = ['user_name' , 'user_bio' , 'comment', 'testimonial_by', 'country', 'city','testimonial_type','testimonial_image','testimonial_video', 'testimonial_date'];

    public function getUserNameAttribute()
    {
        return getTranslateAttributeValue($this , 'user_name');
    }

    public function getUserBioAttribute()
    {
        return getTranslateAttributeValue($this , 'user_bio');
    }

    public function getCommentAttribute()
    {
        return getTranslateAttributeValue($this , 'comment');
    }
}
