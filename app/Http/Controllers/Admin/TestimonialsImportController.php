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

                $testimonial = Testimonial::create([
                    'user_avatar' => isset($r[0]) ? $r[0] : '' ,
                    'rate'        => 5 ,
                    'status'      => 'active' ,
                    'created_at'  => time() ,
                ]);

                if (!empty($testimonial)) {
                    TestimonialTranslation::updateOrCreate([
                        'testimonial_id' => $testimonial->id ,
                        'locale'         => 'en' ,
                    ] , [
                        'user_name'         => isset($r[2]) ? $r[2] : '' ,
                        'user_bio'          => isset($r[3]) ? $r[3] : '' ,
                        'comment'           => isset($r[7]) ? $r[7] : '' ,
                        'testimonial_by'    => isset($r[1]) ? $r[1] : '' ,
                        'country'           => isset($r[4]) ? $r[4] : '' ,
                        'city'              => isset($r[5]) ? $r[5] : '' ,
                        'testimonial_type'  => isset($r[6]) ? $r[6] : '' ,
                        'testimonial_image' => '',
                        'testimonial_video' => '',
                        'testimonial_date'  => 1684281600,
                    ]);
                }


            }
            $count++;
        }
    }
}
