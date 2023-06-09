<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Translation\TestimonialTranslation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TestimonialsController extends Controller
{
    public function index()
    {
        $this->authorize('admin_testimonials_list');
        
        
        $int= mt_rand(1672531200,1685577600);
        $testimonials = Testimonial::where('status', 'active')->orderBy('testimonial_date', 'asc')->get();
        
        foreach( $testimonials as $testimonialObj){
            $testimonial_date = mt_rand(1672531200,1685577600);
            
            $testimonialObj->update([
                'testimonial_date'  => $testimonial_date ,
            ]);
            TestimonialTranslation::updateOrCreate([
                'testimonial_id' => $testimonialObj->id ,
            ] , [
                'testimonial_date'  => $testimonial_date ,
            ]);
        }
        pre('done');


        //$import = new TestimonialsImportController('assets/testimonials.csv');
        //Excel::import($import, 'assets/testimonials.csv');
        //exit;


        removeContentLocale();

        $testimonials = Testimonial::query()->paginate(200);

        $data = [
            'pageTitle'    => trans('admin/pages/comments.testimonials') ,
            'testimonials' => $testimonials
        ];

        return view('admin.testimonials.lists' , $data);
    }

    public function create()
    {
        $this->authorize('admin_testimonials_create');
        $contries_list = Testimonial::$contries_list;

        removeContentLocale();

        $data = [
            'pageTitle'     => trans('admin/pages/comments.new_testimonial') ,
            'contries_list' => $contries_list ,
        ];

        return view('admin.testimonials.create' , $data);
    }

    public function store(Request $request)
    {
        $this->authorize('admin_testimonials_create');

        $this->validate($request , [
            'user_avatar' => 'nullable|string' ,
            'user_name'   => 'required|string' ,
            'user_bio'    => 'required|string' ,
            //'rate'        => 'required|integer|between:0,5' ,
            'comment'     => 'required|string' ,
        ]);

        $data = $request->all();

        if (empty($data['user_avatar'])) {
            $data['user_avatar'] = getPageBackgroundSettings('user_avatar');
        }

        $testimonial = Testimonial::create([
            'user_avatar' => $data['user_avatar'] ,
            'rate'        => 5 ,//$data['rate'] ,
            'status'      => $data['status'] ,
            'created_at'  => time() ,
            'testimonial_date'  => isset($data['testimonial_date']) ? strtotime($data['testimonial_date']) : 0 ,
        ]);

        if (!empty($testimonial)) {
            TestimonialTranslation::updateOrCreate([
                'testimonial_id' => $testimonial->id ,
                'locale'         => mb_strtolower($data['locale']) ,
            ] , [
                'user_name'         => $data['user_name'] ,
                'user_bio'          => $data['user_bio'] ,
                'comment'           => $data['comment'] ,
                'testimonial_by'    => isset($data['testimonial_by']) ? $data['testimonial_by'] : '' ,
                'country'           => isset($data['country']) ? $data['country'] : '' ,
                'city'              => isset($data['city']) ? $data['city'] : '' ,
                'testimonial_type'  => isset($data['testimonial_type']) ? $data['testimonial_type'] : 'text' ,
                'testimonial_image' => isset($data['testimonial_image']) ? $data['testimonial_image'] : '' ,
                'testimonial_video' => isset($data['testimonial_video']) ? $data['testimonial_video'] : '' ,
                'testimonial_date'  => isset($data['testimonial_date']) ? strtotime($data['testimonial_date']) : '' ,
            ]);
        }

        return redirect(getAdminPanelUrl() . '/testimonials');
    }


    public function edit(Request $request , $id)
    {
        $this->authorize('admin_testimonials_edit');
        $contries_list = Testimonial::$contries_list;

        $testimonial = Testimonial::findOrFail($id);

        $locale = $request->get('locale' , app()->getLocale());
        storeContentLocale($locale , $testimonial->getTable() , $testimonial->id);

        $data = [
            'pageTitle'     => trans('admin/pages/comments.edit_testimonial') ,
            'testimonial'   => $testimonial ,
            'contries_list' => $contries_list ,
        ];

        return view('admin.testimonials.create' , $data);
    }

    public function update(Request $request , $id)
    {
        $this->authorize('admin_testimonials_edit');

        $this->validate($request , [
            'user_avatar' => 'nullable|string' ,
            'user_name'   => 'required|string' ,
            'user_bio'    => 'required|string' ,
            //'rate'        => 'required|integer|between:0,5' ,
            'comment'     => 'required|string' ,
        ]);

        $testimonial = Testimonial::findOrFail($id);

        $data = $request->all();

        if (empty($data['user_avatar'])) {
            $data['user_avatar'] = getPageBackgroundSettings('user_avatar');
        }


        $testimonial->update([
            'user_avatar' => $data['user_avatar'] ,
            'rate'        => 5 ,//$data['rate'] ,
            'status'      => $data['status'] ,
            'testimonial_date'  => isset($data['testimonial_date']) ? strtotime($data['testimonial_date']) : 0 ,
        ]);

        TestimonialTranslation::updateOrCreate([
            'testimonial_id' => $testimonial->id ,
            'locale'         => mb_strtolower($data['locale']) ,
        ] , [
            'user_name'         => $data['user_name'] ,
            'user_bio'          => $data['user_bio'] ,
            'comment'           => $data['comment'] ,
            'testimonial_by'    => isset($data['testimonial_by']) ? $data['testimonial_by'] : '' ,
            'country'           => isset($data['country']) ? $data['country'] : '' ,
            'city'              => isset($data['city']) ? $data['city'] : '' ,
            'testimonial_type'  => isset($data['testimonial_type']) ? $data['testimonial_type'] : 'text' ,
            'testimonial_image' => isset($data['testimonial_image']) ? $data['testimonial_image'] : '' ,
            'testimonial_video' => isset($data['testimonial_video']) ? $data['testimonial_video'] : '' ,
            'testimonial_date'  => isset($data['testimonial_date']) ? strtotime($data['testimonial_date']) : '' ,
        ]);

        removeContentLocale();

        return redirect(getAdminPanelUrl() . '/testimonials');
    }

    public function delete($id)
    {
        $this->authorize('admin_testimonials_delete');

        $testimonial = Testimonial::findOrFail($id);

        $testimonial->delete();

        return redirect(getAdminPanelUrl() . '/testimonials');
    }
}
