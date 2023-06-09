<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Translation\TestimonialTranslation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class TestimonialsImportController implements ToCollection
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function collection(Collection $row)
    {
        $count = 1;
        foreach ($row as $r) {
            if ($count > 1) {
                
                $testimonial_date = isset( $r[2] )? strtotime($r[2]) : 0;
                
                if( isset($r[1]) && $r[1] != ''){

                    $testimonial = Testimonial::create([
                        'user_avatar' => '' ,
                        'rate'        => 5 ,
                        'status'      => 'active' ,
                        'created_at'  => time() ,
                        'testimonial_date'  => $testimonial_date,
                    ]);


                    if (!empty($testimonial)) {



                        TestimonialTranslation::updateOrCreate([
                            'testimonial_id' => $testimonial->id ,
                            'locale'         => 'en',
                            'user_name'         => isset($r[1]) ? $r[1] : '' ,
                            'user_bio'          => isset($r[3]) ? $r[3] : '' ,
                            'comment'           => isset($r[7]) ? $r[7] : '' ,
                            'testimonial_by'    => isset($r[0]) ? $r[0] : '' ,
                            'country'           => 'United Kingdom',
                            'city'              => isset($r[5]) ? $r[5] : '' ,
                            'testimonial_type'  => 'text' ,
                            'testimonial_image' => '',
                            'testimonial_video' => '',
                            'testimonial_date'  => $testimonial_date,
                        ]);
                    }
                }


            }
            $count++;
        }
    }
}
