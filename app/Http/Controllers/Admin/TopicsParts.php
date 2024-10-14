<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\TopicParts;
use App\Models\Category;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class TopicsParts extends Controller {

    public function index(Request $request) {
        $user = auth()->user();
        $this->authorize('admin_glossary');

        removeContentLocale();
        //DB::enableQueryLog();

        $query = TopicParts::query();

        $TotalTopicParts = deepClone($query)->count();

        $query = $this->filters($query, $request);




        $TopicParts = $query->paginate(50);



        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();

        //DB::enableQueryLog();
        //pre(DB::getQueryLog());
        //DB::disableQueryLog();


        $data = [
            'pageTitle' => 'Topics Parts',
            'TopicParts' => $TopicParts,
            'TotalTopicParts' => $TotalTopicParts,
            'categories' => $categories,
        ];

        //pre(DB::getQueryLog());
        //DB::disableQueryLog();



        return view('admin.topics_parts.lists', $data);
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
            'pageTitle' => 'Topics Parts',
            'categories' => $categories,
        ];

        return view('admin.topics_parts.create', $data);
    }

    public function edit(Request $request, $id) {
        $this->authorize('admin_glossary_edit');
        $user = auth()->user();

        $TopicParts = TopicParts::findOrFail($id);
        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
            $data = [
            'pageTitle' => 'Edit Topic Parts',
            'categories' => $categories,
            'TopicParts' => $TopicParts,
        ];

        return view('admin.topics_parts.create', $data);
    }

    private function filters($query, $request) {
        $category_id = $request->get('category_id', '');


        if ($category_id != '') {
            $query->where('topic_parts.category_id', $category_id);
        }

        return $query;
    }

    public function store(Request $request, $id = '') {
        $user = auth()->user();


        $data = $request->all();
        $locale = $request->get('locale', getDefaultLocale());

        $rules = [
            //'paragraph' => 'required|max:255',
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
            $TopicParts = TopicParts::findOrFail($id);
            $TopicParts->update([
                'category_id' => isset($data['category_id']) ? $data['category_id'] : 0,
                'subject_id' => isset($data['subject_id']) ? $data['subject_id'] : 0,
                'chapter_id' => isset($data['chapter_id']) ? $data['chapter_id'] : 0,
                'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
                'paragraph' => isset($data['paragraph']) ? $data['paragraph'] : '',
                'topic_part_data' => isset($data['topic_part']) ? json_encode($data['topic_part']) : '',
                'created_by' => $user->id,
                'created_at' => time(),
            ]);
        } else {
            $this->authorize('admin_glossary_create');

            $TopicParts = TopicParts::create([
                'category_id' => isset($data['category_id']) ? $data['category_id'] : 0,
                'subject_id' => isset($data['subject_id']) ? $data['subject_id'] : 0,
                'chapter_id' => isset($data['chapter_id']) ? $data['chapter_id'] : 0,
                'sub_chapter_id' => isset($data['sub_chapter_id']) ? $data['sub_chapter_id'] : 0,
                'paragraph' => isset($data['paragraph']) ? $data['paragraph'] : '',
                'topic_part_data' => isset($data['topic_part']) ? json_encode($data['topic_part']) : '',
                'created_by' => $user->id,
                'created_at' => time(),
            ]);
        }


        if ($request->ajax()) {
            $redirectUrl = '';
            $redirectUrl = '/admin/topics_parts/' . $TopicParts->id . '/edit';
            return response()->json([
                        'code' => 200,
                        'redirect_url' => $redirectUrl
            ]);
        } else {
            return redirect()->route('adminEditTopicPart', ['id' => $TopicParts->id]);
        }
    }

    public function destroy(Request $request, $id) {

        $this->authorize('admin_glossary_delete');

        TopicParts::find($id)->delete();

        removeContentLocale();

        return redirect('/admin/topics_parts');
    }

}
