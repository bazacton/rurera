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


        $data = [
            'pageTitle' => 'Glossary',
            'glossary' => $glossary,
            'totalGlossary' => $totalGlossary,
            'categories' => $categories,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();



        return view('admin.glossary.lists', $data);
    }

    /*
     * Create Question
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
        
        if( $glossary->created_by != $user->id || $glossary->status != 'draft'){
            $toastData = [
                'title' => 'Request not completed',
                'msg' => 'You dont have permissions to perform this action.',
                'status' => 'error'
            ];
            return redirect()->back()->with(['toast' => $toastData]);
        }
        
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
        $title = $request->get('title', null);
        $status = $request->get('status', null);
        $category_id = $request->get('category_id', '');


        if (!empty($title)) {
            $query->where('glossary.title', 'LIKE', "%{$title}%");
        }

        if ($category_id != '') {
            $query->where('glossary.category_id', $category_id);
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
