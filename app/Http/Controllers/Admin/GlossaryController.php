<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Glossary;
use App\Models\Category;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class GlossaryController extends Controller {

    public function index(Request $request) {
        $user = auth()->user();
        $this->authorize('admin_glossary');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = Glossary::query();

        if ($user->role_name == 'teachers') {
            $query->where('glossary.status', 'draft');
            $query->where('glossary.created_by', $user->id);
        }

        $totalGlossary = deepClone($query)->count();

        $query = $this->filters($query, $request);




        $glossary = $query->with('user')->join('category_translations', 'category_translations.category_id', '=', 'glossary.category_id')
                ->where('category_translations.locale', 'en')
                ->select('glossary.*', 'category_translations.title as category_title')
                ->paginate(50);



        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();

        //DB::enableQueryLog();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


		$users_list = User::where('status' , 'active')->get();
        $data = [
            'pageTitle' => 'Glossary',
            'glossary' => $glossary,
            'totalGlossary' => $totalGlossary,
            'categories' => $categories,
            'users_list' => $users_list,
            'user' => $user,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();



        return view('admin.glossary.lists', $data);
    }

    /*
     * Create Glossary
     */

    public function create() {
        $this->authorize('admin_glossary_create');
        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
        $data = [
            'pageTitle' => 'Glossary',
            'categories' => $categories,
        ];

        return view('admin.glossary.create', $data);
    }

    public function edit(Request $request, $id) {
        $this->authorize('admin_glossary_edit');
        $user = auth()->user();

        $glossary = Glossary::findOrFail($id);

        /*if( $glossary->created_by != $user->id || $glossary->status != 'draft'){
            $toastData = [
                'title' => 'Request not completed',
                'msg' => 'You dont have permissions to perform this action.',
                'status' => 'error'
            ];
            return redirect()->back()->with(['toast' => $toastData]);
        }*/

        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
            $data = [
            'pageTitle' => 'Edit Glossary',
            'categories' => $categories,
            'glossary' => $glossary,
        ];

        return view('admin.glossary.create', $data);
    }

    private function filters($query, $request) {
        $title = get_filter_request('title', 'glossary_search'); 
        $status = get_filter_request('status', 'glossary_search');
		$glossary_type = get_filter_request('glossary_type', 'glossary_search');
		
		$category_id = get_filter_request('category_id', 'glossary_search');
        $subject_id = get_filter_request('subject_id', 'glossary_search'); 
        $chapter_id = get_filter_request('chapter_id', 'glossary_search'); 
        $sub_chapter_id = get_filter_request('sub_chapter_id', 'glossary_search');
        $user_id = get_filter_request('user_id', 'glossary_search'); 


        if (!empty($title)) {
            $query->where('glossary.title', 'LIKE', "%{$title}%");
        }
        if ($glossary_type != '') {
            $query->where('glossary.glossary_type', $glossary_type);
        }

        if ($category_id != '') {
            $query->where('glossary.category_id', $category_id);
        }

        if ($subject_id != '') {
            $query->where('glossary.subject_id', $subject_id);
        }

        if ($chapter_id != '') {
            $query->where('glossary.chapter_id', $chapter_id);
        }

        if ($sub_chapter_id != '') {
            $query->where('glossary.sub_chapter_id', $sub_chapter_id);
        }

        if ($user_id != '') {
            $query->where('glossary.created_by', $user_id);
        }


        if (!empty($status) and $status !== 'all') {
            $query->where('glossary.status', strtolower($status));
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

        if ($id != '' && $id > 0) {
            $this->authorize('admin_glossary_edit');
            $glossary = Glossary::findOrFail($id);
            $glossary->update([
                'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
                'title' => isset($data['title']) ? $data['title'] : '',
                'description' => isset($data['description']) ? $data['description'] : '',
                'created_at' => time(),
                'subject_id' => isset($data['subject_id']) ? $data['subject_id'] : 0,
                'chapter_id' => isset($data['chapter_id']) ? $data['chapter_id'] : 0,
                'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
				'glossary_type' => isset($data['glossary_type']) ? $data['glossary_type'] : 'glossary',
				
            ]);
        } else {
            $this->authorize('admin_glossary_create');

            $glossary = Glossary::create([
                'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
                'title' => isset($data['title']) ? $data['title'] : '',
                'description' => isset($data['description']) ? $data['description'] : '',
                'status' => 'active',
                'created_at' => time(),
                'created_by' => $user->id,
                'subject_id' => isset($data['subject_id']) ? $data['subject_id'] : 0,
                'chapter_id' => isset($data['chapter_id']) ? $data['chapter_id'] : 0,
                'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
				'glossary_type' => isset($data['glossary_type']) ? $data['glossary_type'] : 'glossary',
            ]);
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/glossary/' . $glossary->id . '/edit';
            return response()->json([
                        'code' => 200,
                        'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditGlossary', ['id' => $glossary->id]);
        }
    }

    public function store_question_glossary(Request $request, $id = '') {
        $user = auth()->user();
        $this->authorize('admin_glossary');

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

        $glossary = Glossary::create([
            'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
            'title' => isset($data['title']) ? $data['title'] : '',
            'description' => isset($data['description']) ? $data['description'] : '',
            'status' => 'draft',
            'created_at' => time(),
            'created_by' => $user->id,
            'subject_id' => isset($data['subject_id']) ? $data['subject_id'] : 0,
        ]);

        if ($request->ajax()) {

            $response = '<input type="hidden" name="new_glossaries[]" class="new_glossaries" value="'.$glossary->id.'">';
            $option_response = '<option value="'.$glossary->id.'" selected="selected">'.$glossary->title.'</option>';
            return response()->json([
                'code' => 200,
                'response' => $response,
                'option_response' => $option_response,
                'redirect_url' => ''
            ]);


        }
    }

    public function destroy(Request $request, $id) {

        $this->authorize('admin_glossary_delete');

        Glossary::find($id)->delete();

        removeContentLocale();

        return redirect('/admin/glossary');
    }

}
