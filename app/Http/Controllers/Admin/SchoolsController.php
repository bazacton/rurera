<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\Glossary;
use App\Models\Schools;
use App\Models\Category;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SchoolsController extends Controller {

    public function index(Request $request) {
        $user = auth()->user();
        $this->authorize('admin_glossary');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = Schools::query();
        $query = $this->filters($query, $request);

        $schools = $query->paginate(50);

        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();

        $data = [
            'pageTitle' => 'Schools',
            'schools' => $schools,
            'categories' => $categories,
        ];
        return view('admin.schools.lists', $data);
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
            'pageTitle' => 'School',
            'categories' => $categories,
        ];

        return view('admin.schools.create', $data);
    }

    public function edit(Request $request, $id) {
        $this->authorize('admin_glossary_edit');
        $user = auth()->user();

        $school = Schools::findOrFail($id);

        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
            $data = [
            'pageTitle' => 'Edit School',
            'categories' => $categories,
            'school' => $school,
        ];

        return view('admin.schools.create', $data);
    }

    private function filters($query, $request) {
        $title = $request->get('title', null);
        $status = $request->get('status', null);


        if (!empty($title)) {
            $query->where('schools.title', 'LIKE', "%{$title}%");
        }

        if (!empty($status) and $status !== 'all') {
            $query->where('schools.status', strtolower($status));
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
            $school = Schools::findOrFail($id);
            $school->update([
                'title' => isset($data['title']) ? $data['title'] : '',
            ]);
        } else {
            $this->authorize('admin_glossary_create');

            $school = Schools::create([
                'title' => isset($data['title']) ? $data['title'] : '',
                'status' => 'active',
                'created_at' => time(),
                'created_by' => $user->id,
            ]);
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/schools/' . $school->id . '/edit';
            return response()->json([
                'code' => 200,
                'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditGlossary', ['id' => $school->id]);
        }
    }

    public function destroy(Request $request, $id) {

        $this->authorize('admin_glossary_delete');

        Glossary::find($id)->delete();

        removeContentLocale();

        return redirect('/admin/schools');
    }

}
