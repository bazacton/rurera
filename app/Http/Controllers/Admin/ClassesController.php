<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Category;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ClassesController extends Controller {

    public function index(Request $request) {
        $user = auth()->user();
        $this->authorize('admin_classes');
        removeContentLocale();
        $query = Classes::query();

        $totalClasses = deepClone($query)->count();

        $query = $this->filters($query, $request);


        $classes = $query->with('user', 'sections')->where('parent_id', 0)->paginate(50);


        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();

        //DB::enableQueryLog();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        $data = [
            'pageTitle' => 'Classes',
            'classes' => $classes,
            'totalClasses' => $totalClasses,
            'categories' => $categories,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();



        return view('admin.classes.lists', $data);
    }

    /*
     * Create Glossary
     */

    public function create() {
        $this->authorize('admin_classes_create');
        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
        $data = [
            'pageTitle' => 'Class',
            'categories' => $categories,
        ];

        return view('admin.classes.create', $data);
    }

    public function edit(Request $request, $id) {
        $this->authorize('admin_classes_edit');
        $user = auth()->user();

        $classObj = Classes::findOrFail($id);

        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
            $data = [
            'pageTitle' => 'Edit Class',
            'categories' => $categories,
            'class' => $classObj,
        ];

        return view('admin.classes.create', $data);
    }

    private function filters($query, $request) {
        $title = $request->get('title', null);
        $status = $request->get('status', null);
        $category_id = $request->get('category_id', '');


        if (!empty($title)) {
            $query->where('classes.title', 'LIKE', "%{$title}%");
        }

        if ($category_id != '') {
            $query->where('classes.category_id', $category_id);
        }


        if (!empty($status) and $status !== 'all') {
            $query->where('classes.status', strtolower($status));
        }


        return $query;
    }

    public function store(Request $request, $id = '') {
        $user = auth()->user();


        $data = $request->all();
        $locale = $request->get('locale', getDefaultLocale());

        $rules = [
            'title' => 'required|max:255',
        ];

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data, $rules);

            if ($validate->fails()) {
                return response()->json([
                            'code' => 422,
                            'errors' => $validate->errors()
                                ], 422);
            }
        } else {
            $this->validate($request, $rules);
        }

        $sections = isset( $data['sections'] )? $data['sections'] : array();



        if ($id != '' && $id > 0) {
            $this->authorize('admin_classes_edit');
            $classObj = Classes::findOrFail($id);
            $classObj->update([
                'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
                'title' => isset($data['title']) ? $data['title'] : '',
            ]);
        } else {
            $this->authorize('admin_classes_create');
            $classObj = Classes::create([
                'parent_id' => 0,
                'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
                'title' => isset($data['title']) ? $data['title'] : '',
                'status' => 'active',
                'created_by' => $user->id,
                'created_at' => time(),
            ]);
        }

        if( !empty( $sections ) ){
            foreach( $sections as $section_id => $sectionData){
                $sectionObj = Classes::find($section_id);
                if( isset( $sectionObj->id ) ){
                    $sectionObj->update([
                        'title' => isset($sectionData['title']) ? $sectionData['title'] : '',
                    ]);
                }else{
                    $sectionObj = Classes::create([
                        'parent_id' => $classObj->id,
                        'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
                        'title' => isset($sectionData['title']) ? $sectionData['title'] : '',
                        'status' => 'active',
                        'created_by' => $user->id,
                        'created_at' => time(),
                    ]);
                }
            }
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/classes/' . $classObj->id . '/edit';
            return response()->json([
                        'code' => 200,
                        'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditClass', ['id' => $classObj->id]);
        }
    }

    public function destroy(Request $request, $id) {
        $this->authorize('admin_classes_delete');
        $classObj = Classes::findOrFail($id);

        $redirectUrl = (isset($classObj->parent_id) && $classObj->parent_id > 0)? '/admin/classes/'.$classObj->parent_id.'/edit' : '/admin/classes';

        $classObj->delete();

        removeContentLocale();

        return redirect($redirectUrl);
    }

}
