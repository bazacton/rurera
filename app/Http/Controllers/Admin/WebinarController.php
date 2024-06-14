<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WebinarsExport;
use App\Http\Controllers\Admin\traits\WebinarChangeCreator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\WebinarStatisticController;
use App\Mail\SendNotifications;
use App\Models\BundleWebinar;
use App\Models\Category;
use App\Models\Faq;
use App\Models\File;
use App\Models\Gift;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Notification;
use App\Models\Prerequisite;
use App\Models\Quiz;
use App\Models\QuizzesQuestion;
use App\Models\QuizzesQuestionsList;

use App\Models\SubChapters;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\Sale;
use App\Models\Session;
use App\Models\SpecialOffer;
use App\Models\Tag;
use App\Models\TextLesson;
use App\Models\Ticket;
use App\Models\Translation\WebinarTranslation;
use App\Models\WebinarChapter;
use App\Models\WebinarChapterItem;
use App\Models\WebinarExtraDescription;
use App\Models\WebinarFilterOption;
use App\Models\WebinarPartnerTeacher;
use App\User;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class WebinarController extends Controller
{
    use WebinarChangeCreator;


    public function index(Request $request)
    {
        $this->authorize('admin_webinars_list');

        removeContentLocale();

        $type = $request->get('type' , 'webinar');
        $query = Webinar::where('webinars.type' , $type);

        /*Slug Starts*/
        /*$quiz_list = Quiz::get();


        if( !empty( $quiz_list) ){

            foreach( $quiz_list as $quizObj){
                $quizRow = Quiz::find($quizObj->id);
                $quiz_slug = Quiz::makeSlug($quizObj->getTitleAttribute());
                pre($quiz_slug, false);
                $quizRow->update(['quiz_slug' => strtolower($quiz_slug)]);
            }

        }
        pre('done');*/
        //WebinarChapter::makeSlug($data['title']);

        /*Slug Ends*/

        /*Slug Starts*/
        /*$sub_chapters_list = SubChapters::where('sub_chapter_slug', null)->get();


        if( !empty( $sub_chapters_list) ){

            foreach( $sub_chapters_list as $chapterObj){
                $chapterRow = SubChapters::find($chapterObj->id);
                $chapter_slug = SubChapters::makeSlug($chapterObj->sub_chapter_title);
                pre($chapter_slug, false);
                $chapterRow->update(['chapter_slug' => strtolower($chapter_slug)]);
            }

        }
        pre($chapters_list);*/
        //WebinarChapter::makeSlug($data['title']);

        /*Slug Ends*/


        /*Slug Starts*/
        /*$chapters_list = WebinarChapter::where('chapter_slug', null)->get();

        if( !empty( $chapters_list) ){

            foreach( $chapters_list as $chapterObj){
                $chapterRow = WebinarChapter::find($chapterObj->id);
                $chapter_slug = WebinarChapter::makeSlug($chapterObj->getTitleAttribute());
                pre($chapter_slug, false);
                $chapterRow->update(['chapter_slug' => strtolower($chapter_slug)]);
            }

        }
        pre($chapters_list);*/
        //WebinarChapter::makeSlug($data['title']);

        /*Slug Ends*/

        $totalWebinars = $query->count();
        $totalPendingWebinars = deepClone($query)->where('webinars.status' , 'pending')->count();
        $totalDurations = deepClone($query)->sum('duration');
        $totalSales = deepClone($query)->join('sales' , 'webinars.id' , '=' , 'sales.webinar_id')
            ->select(DB::raw('count(sales.webinar_id) as sales_count'))
            ->whereNotNull('sales.webinar_id')
            ->whereNull('sales.refund_at')
            ->first();

        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();

        $inProgressWebinars = 0;
        if ($type == 'webinar') {
            $inProgressWebinars = $this->getInProgressWebinarsCount();
        }

        $query = $this->filterWebinar($query , $request)
            ->with([
                'category' ,
                'teacher' => function ($qu) {
                    $qu->select('id' , 'full_name');
                } ,
                'sales'   => function ($query) {
                    $query->whereNull('refund_at');
                }
            ]);

        $webinars = $query->paginate(200);

        if ($request->get('status' , null) == 'active_finished') {
            foreach ($webinars as $key => $webinar) {
                if ($webinar->last_date > time()) { // is in progress
                    unset($webinars[$key]);
                }
            }
        }

        foreach ($webinars as $webinar) {
            $giftsIds = Gift::query()->where('webinar_id' , $webinar->id)
                ->where('status' , 'active')
                ->where(function ($query) {
                    $query->whereNull('date');
                    $query->orWhere('date' , '<' , time());
                })
                ->whereHas('sale')
                ->pluck('id')
                ->toArray();

            $sales = Sale::query()
                ->where(function ($query) use ($webinar , $giftsIds) {
                    $query->where('webinar_id' , $webinar->id);
                    $query->orWhereIn('gift_id' , $giftsIds);
                })
                ->whereNull('refund_at')
                ->get();

            $webinar->sales = $sales;
        }


        $data = [
            'pageTitle'            => trans('admin/pages/webinars.webinars_list_page_title') ,
            'webinars'             => $webinars ,
            'totalWebinars'        => $totalWebinars ,
            'totalPendingWebinars' => $totalPendingWebinars ,
            'totalDurations'       => $totalDurations ,
            'totalSales'           => !empty($totalSales) ? $totalSales->sales_count : 0 ,
            'categories'           => $categories ,
            'inProgressWebinars'   => $inProgressWebinars ,
            'classesType'          => $type ,
        ];

        $teacher_ids = $request->get('teacher_ids' , null);
        if (!empty($teacher_ids)) {
            $data['teachers'] = User::select('id' , 'full_name')->whereIn('id' , $teacher_ids)->get();
        }

        return view('admin.webinars.lists' , $data);
    }

    public function store_quiz_selection(Request $request , $chapter_item_id = 0)
    {
        $user = auth()->user();
        $webinar_id = $request->get('webinar_id');
        $quiz_id = $request->get('quiz_id');
        $sub_chapter_id = $request->get('sub_chapter_id');
        $subChapterObj = SubChapters::find($sub_chapter_id);
		
		$quiz_questions_list = QuizzesQuestionsList::where('quiz_id', $quiz_id)->where('status','active')->pluck('question_id')->toArray();
		$subchapter_questions_list = $subChapterObj->questions_list->pluck('id')->toArray();
		
		$removed_questions = array_diff($quiz_questions_list, $subchapter_questions_list);
		$new_questions = array_diff($subchapter_questions_list, $quiz_questions_list);
		
		if( !empty( $removed_questions ) ){
			QuizzesQuestionsList::where('quiz_id', $quiz_id)->whereIn('question_id', $removed_questions)->where('status','active')->update(['status' => 'inactive']);
		}
		
		if (!empty($new_questions)) {
            foreach ($new_questions as $sort_order => $question_id) {
                QuizzesQuestionsList::create([
                    'quiz_id'     => $quiz_id,
                    'question_id' => $question_id,
                    'status'      => 'active',
                    'sort_order'  => $sort_order,
                    'created_by'  => $user->id,
                    'created_at'  => time()
                ]);
            }
        }
		
		
        if ($chapter_item_id == 0) {
            $WebinarChapterItem = WebinarChapterItem::create([
                'user_id'    => $user->id ,
                'chapter_id' => $subChapterObj->chapter_id ,
                'item_id'    => $quiz_id ,
                'type'       => 'quiz' ,
                'order'      => 1 ,
                'created_at' => time() ,
                'parent_id'  => $sub_chapter_id ,
            ]);
        } else {
            $WebinarChapterItem = WebinarChapterItem::find($chapter_item_id);
            $WebinarChapterItem->update([
                'chapter_id' => $subChapterObj->chapter_id ,
                'item_id'    => $quiz_id ,
                'parent_id'  => $sub_chapter_id ,
            ]);
        }

        $redirectUrl = '/admin/webinars/' . $webinar_id . '/edit';

        return response()->json([
            'code'         => 200 ,
            'redirect_url' => $redirectUrl
        ]);
    }


    public function search_sub_chapter(Request $request)
    {
        $term = $request->get('term');
        //$option = $request->get('option');


        $sub_chapters = DB::table('webinar_sub_chapters')
            ->select('id' , 'sub_chapter_title as name')
            ->where('sub_chapter_title' , 'like' , '%' . $term . '%');

        //pre($sub_chapters);

        return response()->json($sub_chapters->get() , 200);
    }

    private function filterWebinar($query , $request)
    {
        $from = $request->get('from' , null);
        $to = $request->get('to' , null);
        $title = $request->get('title' , null);
        $teacher_ids = $request->get('teacher_ids' , null);
        $category_id = $request->get('category_id' , null);
        $status = $request->get('status' , null);
        $sort = $request->get('sort' , null);

        $query = fromAndToDateFilter($from , $to , $query , 'created_at');

        if (!empty($title)) {
            $query->whereTranslationLike('title' , '%' . $title . '%');
        }

        if (!empty($teacher_ids) and count($teacher_ids)) {
            $query->whereIn('teacher_id' , $teacher_ids);
        }

        if (!empty($category_id)) {
            $query->where('category_id' , $category_id);
        }

        if (!empty($status)) {
            $time = time();

            switch ($status) {
                case 'active_not_conducted':
                    $query->where('webinars.status' , 'active')
                        ->where('start_date' , '>' , $time);
                    break;
                case 'active_in_progress':
                    $query->where('webinars.status' , 'active')
                        ->where('start_date' , '<=' , $time)
                        ->join('sessions' , 'webinars.id' , '=' , 'sessions.webinar_id')
                        ->select('webinars.*' , 'sessions.date' , DB::raw('max(`date`) as last_date'))
                        ->groupBy('sessions.webinar_id')
                        ->where('sessions.date' , '>' , $time);
                    break;
                case 'active_finished':
                    $query->where('webinars.status' , 'active')
                        ->where('start_date' , '<=' , $time)
                        ->join('sessions' , 'webinars.id' , '=' , 'sessions.webinar_id')
                        ->select('webinars.*' , 'sessions.date' , DB::raw('max(`date`) as last_date'))
                        ->groupBy('sessions.webinar_id');
                    break;
                default:
                    $query->where('webinars.status' , $status);
                    break;
            }
        }

        if (!empty($sort)) {
            switch ($sort) {
                case 'has_discount':
                    $now = time();
                    $webinarIdsHasDiscount = [];

                    $tickets = Ticket::where('start_date' , '<' , $now)
                        ->where('end_date' , '>' , $now)
                        ->get();

                    foreach ($tickets as $ticket) {
                        if ($ticket->isValid()) {
                            $webinarIdsHasDiscount[] = $ticket->webinar_id;
                        }
                    }

                    $specialOffersWebinarIds = SpecialOffer::where('status' , 'active')
                        ->where('from_date' , '<' , $now)
                        ->where('to_date' , '>' , $now)
                        ->pluck('webinar_id')
                        ->toArray();

                    $webinarIdsHasDiscount = array_merge($specialOffersWebinarIds , $webinarIdsHasDiscount);

                    $query->whereIn('id' , $webinarIdsHasDiscount)
                        ->orderBy('created_at' , 'desc');
                    break;
                case 'sales_asc':
                    $query->join('sales' , 'webinars.id' , '=' , 'sales.webinar_id')
                        ->select('webinars.*' , 'sales.webinar_id' , 'sales.refund_at' , DB::raw('count(sales.webinar_id) as sales_count'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('sales_count' , 'asc');
                    break;
                case 'sales_desc':
                    $query->join('sales' , 'webinars.id' , '=' , 'sales.webinar_id')
                        ->select('webinars.*' , 'sales.webinar_id' , 'sales.refund_at' , DB::raw('count(sales.webinar_id) as sales_count'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('sales_count' , 'desc');
                    break;

                case 'price_asc':
                    $query->orderBy('price' , 'asc');
                    break;

                case 'price_desc':
                    $query->orderBy('price' , 'desc');
                    break;

                case 'income_asc':
                    $query->join('sales' , 'webinars.id' , '=' , 'sales.webinar_id')
                        ->select('webinars.*' , 'sales.webinar_id' , 'sales.total_amount' , 'sales.refund_at' , DB::raw('(sum(sales.total_amount) - (sum(sales.tax) + sum(sales.commission))) as amounts'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('amounts' , 'asc');
                    break;

                case 'income_desc':
                    $query->join('sales' , 'webinars.id' , '=' , 'sales.webinar_id')
                        ->select('webinars.*' , 'sales.webinar_id' , 'sales.total_amount' , 'sales.refund_at' , DB::raw('(sum(sales.total_amount) - (sum(sales.tax) + sum(sales.commission))) as amounts'))
                        ->whereNotNull('sales.webinar_id')
                        ->whereNull('sales.refund_at')
                        ->groupBy('sales.webinar_id')
                        ->orderBy('amounts' , 'desc');
                    break;

                case 'created_at_asc':
                    $query->orderBy('created_at' , 'asc');
                    break;

                case 'created_at_desc':
                    $query->orderBy('created_at' , 'desc');
                    break;

                case 'updated_at_asc':
                    $query->orderBy('updated_at' , 'asc');
                    break;

                case 'updated_at_desc':
                    $query->orderBy('updated_at' , 'desc');
                    break;

                case 'public_courses':
                    $query->where('private' , false);
                    $query->orderBy('created_at' , 'desc');
                    break;

                case 'courses_private':
                    $query->where('private' , true);
                    $query->orderBy('created_at' , 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at' , 'desc');
        }


        return $query;
    }

    private function getInProgressWebinarsCount()
    {
        $count = 0;
        $webinars = Webinar::where('type' , 'webinar')
            ->where('status' , 'active')
            ->where('start_date' , '<=' , time())
            ->whereHas('sessions')
            ->get();

        foreach ($webinars as $webinar) {
            if ($webinar->isProgressing()) {
                $count += 1;
            }
        }

        return $count;
    }

    public function create()
    {
        $this->authorize('admin_webinars_create');

        removeContentLocale();

        $teachers = User::where('role_name' , Role::$teacher)->get();


        $categories = Category::where('parent_id' , null)->get();

        $data = [
            'pageTitle'  => trans('admin/main.webinar_new_page_title') ,
            'teachers'   => $teachers ,
            'categories' => $categories
        ];

        return view('admin.webinars.create' , $data);
    }


    public function store_sub_chapter(Request $request)
    {
        $this->authorize('admin_quizzes_create');

        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());

        $rules = [
            'title'      => 'required|max:255' ,
            'webinar_id' => 'required|exists:webinars,id' ,
            //'pass_mark' => 'required',
        ];

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data , $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422 ,
                    'errors' => $validate->errors()
                ] , 422);
            }
        } else {
            $this->validate($request , $rules);
        }

        $webinar = Webinar::where('id' , $data['webinar_id'])
            ->first();

        if (!empty($webinar)) {
            $chapter = null;

            if (!empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id' , $data['chapter_id'])
                    ->where('webinar_id' , $webinar->id)
                    ->first();
            }

            $chapter_settings = array(
                'Below'     => array(
                    'questions' => isset($data['Below']) ? $data['Below'] : '' ,
                    'points'    => isset($data['Below_points']) ? $data['Below_points'] : '' ,
                ) ,
                'Emerging'  => array(
                    'questions' => isset($data['Emerging']) ? $data['Emerging'] : '' ,
                    'points'    => isset($data['Emerging_points']) ? $data['Emerging_points'] : '' ,
                ) ,
                'Expected'  => array(
                    'questions' => isset($data['Expected']) ? $data['Expected'] : '' ,
                    'points'    => isset($data['Expected_points']) ? $data['Expected_points'] : '' ,
                ) ,
                'Exceeding' => array(
                    'questions' => isset($data['Exceeding']) ? $data['Exceeding'] : '' ,
                    'points'    => isset($data['Exceeding_points']) ? $data['Exceeding_points'] : '' ,
                ) ,
                'Challenge' => array(
                    'questions' => isset($data['Challenge']) ? $data['Challenge'] : '' ,
                    'points'    => isset($data['Challenge_points']) ? $data['Challenge_points'] : '' ,
                )
            );

            $sub_chapter_slug = (isset($data['sub_chapter_slug']) && $data['sub_chapter_slug'] != '') ? $data['sub_chapter_slug'] : SubChapters::makeSlug($data['title']);

            $sub_chapter = SubChapters::create([
                'webinar_id'        => $webinar->id ,
                'chapter_id'        => !empty($chapter) ? $chapter->id : null ,
                'sub_chapter_title' => isset($data['title']) ? $data['title'] : '' ,
                'quiz_type'         => isset($data['quiz_type']) ? $data['quiz_type'] : '' ,
                'chapter_settings'  => json_encode($chapter_settings) ,
                'status'            => 'active' ,
                'created_at'        => time() ,
                'sub_chapter_slug'        => $sub_chapter_slug,
                'sub_chapter_image'         => isset($data['sub_chapter_image']) ? $data['sub_chapter_image'] : '' ,
            ]);


            if (!empty($sub_chapter->webinar_id)) {
                WebinarChapterItem::makeItem($webinar->creator_id , $sub_chapter->chapter_id , $sub_chapter->id , 'sub_chapter');
            }

            if ($request->ajax()) {

                $redirectUrl = '';

                $redirectUrl = '/admin/webinars/' . $data['webinar_id'] . '/edit';

                return response()->json([
                    'code'         => 200 ,
                    'redirect_url' => $redirectUrl
                ]);
            } else {
                return redirect()->route('adminEditQuiz' , ['id' => $quiz->id]);
            }
        } else {
            return back()->withErrors([
                'webinar_id' => trans('validation.exists' , ['attribute' => trans('admin/main.course')])
            ]);
        }
    }


    public function update_sub_chapter(Request $request , $id)
    {
        $this->authorize('admin_quizzes_create');

        $subChapter = SubChapters::find($id);

        $data = $request->all();
        $locale = $request->get('locale' , getDefaultLocale());

        $rules = [
            'title'      => 'required|max:255' ,
            'webinar_id' => 'required|exists:webinars,id' ,
            //'pass_mark' => 'required',
        ];

        if ($request->ajax()) {
            $data = $request->get('ajax');

            $validate = Validator::make($data , $rules);

            if ($validate->fails()) {
                return response()->json([
                    'code'   => 422 ,
                    'errors' => $validate->errors()
                ] , 422);
            }
        } else {
            $this->validate($request , $rules);
        }

        $webinar = Webinar::where('id' , $data['webinar_id'])
            ->first();

        if (!empty($webinar)) {
            $chapter = null;

            if (!empty($data['chapter_id'])) {
                $chapter = WebinarChapter::where('id' , $data['chapter_id'])
                    ->where('webinar_id' , $webinar->id)
                    ->first();
            }

            $chapter_settings = array(
                'Below'     => array(
                    'questions' => isset($data['Below']) ? $data['Below'] : '' ,
                    'points'    => isset($data['Below_points']) ? $data['Below_points'] : '' ,
                ) ,
                'Emerging'  => array(
                    'questions' => isset($data['Emerging']) ? $data['Emerging'] : '' ,
                    'points'    => isset($data['Emerging_points']) ? $data['Emerging_points'] : '' ,
                ) ,
                'Expected'  => array(
                    'questions' => isset($data['Expected']) ? $data['Expected'] : '' ,
                    'points'    => isset($data['Expected_points']) ? $data['Expected_points'] : '' ,
                ) ,
                'Exceeding' => array(
                    'questions' => isset($data['Exceeding']) ? $data['Exceeding'] : '' ,
                    'points'    => isset($data['Exceeding_points']) ? $data['Exceeding_points'] : '' ,
                ) ,
                'Challenge' => array(
                    'questions' => isset($data['Challenge']) ? $data['Challenge'] : '' ,
                    'points'    => isset($data['Challenge_points']) ? $data['Challenge_points'] : '' ,
                )
            );

            $sub_chapter_slug = (isset($data['sub_chapter_slug']) && $data['sub_chapter_slug'] != '') ? $data['sub_chapter_slug'] : SubChapters::makeSlug($data['title']);


            $sub_chapter = $subChapter->update([
                'webinar_id'        => $webinar->id ,
                'chapter_id'        => !empty($chapter) ? $chapter->id : null ,
                'sub_chapter_title' => isset($data['title']) ? $data['title'] : '' ,
                'quiz_type'         => isset($data['quiz_type']) ? $data['quiz_type'] : '' ,
                'chapter_settings'  => json_encode($chapter_settings) ,
                'status'            => 'active' ,
                'sub_chapter_slug' => $sub_chapter_slug,
                'sub_chapter_image'         => isset($data['sub_chapter_image']) ? $data['sub_chapter_image'] : '' ,
                //'created_at' => time(),
            ]);


            if (!empty($sub_chapter->webinar_id)) {
                //WebinarChapterItem::makeItem($webinar->creator_id, $sub_chapter->chapter_id, $sub_chapter->id, 'sub_chapter');
            }

            if ($request->ajax()) {

                $redirectUrl = '';

                $redirectUrl = '/admin/webinars/' . $data['webinar_id'] . '/edit';

                return response()->json([
                    'code'         => 200 ,
                    'redirect_url' => $redirectUrl
                ]);
            } else {
                return redirect()->route('adminEditQuiz' , ['id' => $quiz->id]);
            }
        } else {
            return back()->withErrors([
                'webinar_id' => trans('validation.exists' , ['attribute' => trans('admin/main.course')])
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->authorize('admin_webinars_create');

        $this->validate($request , [
            'type'        => 'required|in:webinar,course,text_lesson' ,
            'title'       => 'required|max:255' ,
            //'slug'        => 'max:255|unique:webinars,slug' ,
            'slug'        => 'max:255',
            'thumbnail'   => 'required' ,
            'image_cover' => 'required' ,
            'description' => 'required' ,
            'teacher_id'  => 'required|exists:users,id' ,
            'duration'    => 'required|numeric' ,
            'start_date'  => 'required_if:type,webinar' ,
            'capacity'    => 'required_if:type,webinar' ,
        ]);
		

        $data = $request->all();

        if ($data['type'] != Webinar::$webinar) {
            $data['start_date'] = null;
        }

        if (!empty($data['start_date']) and $data['type'] == Webinar::$webinar) {
            if (empty($data['timezone']) or !getFeaturesSettings('timezone_in_create_webinar')) {
                $data['timezone'] = getTimezone();
            }

            $startDate = convertTimeToUTCzone($data['start_date'] , $data['timezone']);

            $data['start_date'] = $startDate->getTimestamp();
        }

        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        if (empty($data['video_demo'])) {
            $data['video_demo_source'] = null;
        }

        if (!empty($data['video_demo_source']) and !in_array($data['video_demo_source'] , ['upload' , 'youtube' , 'vimeo' , 'external_link'])) {
            $data['video_demo_source'] = 'upload';
        }

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;
        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;

        $webinar = Webinar::create([
            'type'                 => $data['type'] ,
            'slug'                 => $data['slug'] ,
            'teacher_id'           => $data['teacher_id'] ,
            'creator_id'           => $data['teacher_id'] ,
            'thumbnail'            => $data['thumbnail'] ,
            'image_cover'          => $data['image_cover'] ,
            'video_demo'           => $data['video_demo'] ,
            'video_demo_source'    => $data['video_demo'] ? $data['video_demo_source'] : null ,
            'capacity'             => $data['capacity'] ?? null ,
            'start_date'           => (!empty($data['start_date'])) ? $data['start_date'] : null ,
            'timezone'             => $data['timezone'] ?? null ,
            'duration'             => $data['duration'] ?? null ,
            'support'              => !empty($data['support']) ? true : false ,
            'certificate'          => !empty($data['certificate']) ? true : false ,
            'downloadable'         => !empty($data['downloadable']) ? true : false ,
            'partner_instructor'   => !empty($data['partner_instructor']) ? true : false ,
            'subscribe'            => !empty($data['subscribe']) ? true : false ,
            'private'              => !empty($data['private']) ? true : false ,
            'forum'                => !empty($data['forum']) ? true : false ,
            'enable_waitlist'      => (!empty($data['enable_waitlist'])) ,
            'access_days'          => $data['access_days'] ?? null ,
            'price'                => $data['price'] ,
            'organization_price'   => $data['organization_price'] ?? null ,
            'points'               => $data['points'] ?? null ,
            'category_id'          => $data['category_id'] ,
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null ,
            'status'               => Webinar::$pending ,
            'created_at'           => time() ,
            'updated_at'           => time() ,
            'background_color'     => isset($data['background_color']) ? $data['background_color'] : '' ,
            'icon_code'            => isset($data['icon_code']) ? $data['icon_code'] : '' ,
            'webinar_type'            => isset($data['webinar_type']) ? $data['webinar_type'] : 'Course' ,
            'country_location'         => isset($data['country_location']) ? json_encode($data['country_location']) : 'uk' ,
            'seo_title'         => isset($data['seo_title']) ? $data['seo_title'] : '' ,
            'seo_robot_access'         => isset($data['seo_robot_access']) ? $data['seo_robot_access'] : 0 ,
            'include_xml'         => isset($data['include_xml']) ? $data['include_xml'] : 0 ,
            'custom_url'         => isset($data['custom_url']) ? $data['custom_url'] : '' ,
            'subject_type'         => isset($data['subject_type']) ? $data['subject_type'] : 'Course' ,
            'learn_background_color'     => isset($data['learn_background_color']) ? $data['learn_background_color'] : '' ,
            'learn_icon'     => isset($data['learn_icon']) ? $data['learn_icon'] : '' ,


        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id ,
                'locale'     => mb_strtolower($data['locale']) ,
            ] , [
                'title'           => $data['title'] ,
                'description'     => $data['description'] ,
                'seo_description' => $data['seo_description'] ,
            ]);
        }

        $filters = $request->get('filters' , null);
        if (!empty($filters) and is_array($filters)) {
            WebinarFilterOption::where('webinar_id' , $webinar->id)->delete();
            foreach ($filters as $filter) {
                WebinarFilterOption::create([
                    'webinar_id'       => $webinar->id ,
                    'filter_option_id' => $filter
                ]);
            }
        }

        if (!empty($request->get('tags'))) {
            $tags = explode(',' , $request->get('tags'));
            Tag::where('webinar_id' , $webinar->id)->delete();

            foreach ($tags as $tag) {
                Tag::create([
                    'webinar_id' => $webinar->id ,
                    'title'      => $tag ,
                ]);
            }
        }

        if (!empty($request->get('partner_instructor')) and !empty($request->get('partners'))) {
            WebinarPartnerTeacher::where('webinar_id' , $webinar->id)->delete();

            foreach ($request->get('partners') as $partnerId) {
                WebinarPartnerTeacher::create([
                    'webinar_id' => $webinar->id ,
                    'teacher_id' => $partnerId ,
                ]);
            }
        }


        return redirect(getAdminPanelUrl() . '/webinars/' . $webinar->id . '/edit?locale=' . $data['locale']);
    }

    public function edit(Request $request , $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::where('id' , $id)
            ->with([

                'webinar_sub_chapters'  => function ($query) {
                    $query->select('id' , 'sub_chapter_title');
                } ,
                'chapters'              => function ($query) {
                    $query->orderBy('order' , 'asc');
                } ,
            ])
            ->first();

        //pre($webinar);
        if (empty($webinar)) {
            abort(404);
        }

        $locale = $request->get('locale' , app()->getLocale());
        storeContentLocale($locale , $webinar->getTable() , $webinar->id);

        $categories = Category::where('parent_id' , null)
            ->with('subCategories')
            ->get();



        $tags = $webinar->tags->pluck('title')->toArray();
        $teachers = User::where('role_name' , Role::$teacher)->get();

        $sub_chapter_items_list = sub_chapter_items_list($id);

        $sub_chapter_questions = $sub_chapter_lessions = array();
        if (!empty($sub_chapter_items_list)) {
            foreach ($sub_chapter_items_list as $sub_chapter_id => $subChapterData) {
                $chapters = isset($subChapterData['chapters']) ? $subChapterData['chapters'] : array();
                if (!empty($chapters)) {
                    foreach ($chapters as $item_id => $chapterData) {
                        $type = isset($chapterData['type']) ? $chapterData['type'] : '';
                        if ($type == 'quiz') {
                            $sub_chapter_questions[$sub_chapter_id][$chapterData['item_id']] = Quiz::find($item_id);
                        }
                        if ($type == 'lesson') {
                            $sub_chapter_lessions[$sub_chapter_id][] = TextLesson::find($item_id);
                        }
                    }
                }
            }
        }

        $data = [
            'pageTitle'              => trans('admin/main.edit') . ' | ' . $webinar->title ,
            'categories'             => $categories ,
            'webinar'                => $webinar ,
            'webinarCategoryFilters' => !empty($webinar->category) ? $webinar->category->filters : null ,
            'webinarFilterOptions'   => $webinar->filterOptions->pluck('filter_option_id')->toArray() ,
            'tickets'                => array() ,
            'sub_chapter_questions'  => $sub_chapter_questions ,
            'sub_chapter_lessions'   => $sub_chapter_lessions ,
            'chapters'               => array() ,
            'sessions'               => array() ,
            'files'                  => array() ,
            'textLessons'            => $webinar->textLessons ,
            'faqs'                   => array() ,
            'assignments'            => array() ,
            'teachers'               => $teachers ,
            'teacherQuizzes'         => array() ,
            'prerequisites'          => array() ,
            'webinarQuizzes'         => array() ,
            'webinarPartnerTeacher'  => array() ,
            'webinarTags'            => $tags ,
            'defaultLocale'          => getDefaultLocale() ,
        ];

        return view('admin.webinars.create' , $data);
    }

    public function update(Request $request , $id)
    {
        $this->authorize('admin_webinars_edit');
        $data = $request->all();

        $webinar = Webinar::find($id);
        $isDraft = (!empty($data['draft']) and $data['draft'] == 1);
        $reject = (!empty($data['draft']) and $data['draft'] == 'reject');
        $publish = (!empty($data['draft']) and $data['draft'] == 'publish');

        $rules = [
            'type'        => 'required|in:webinar,course,text_lesson' ,
            'title'       => 'required|max:255' ,
            //'slug'        => 'max:255|unique:webinars,slug,' . $webinar->id ,
            'slug'        => 'max:255',
            'thumbnail'   => 'required' ,
            'image_cover' => 'required' ,
            'description' => 'required' ,
            'teacher_id'  => 'required|exists:users,id' ,
            'category_id' => 'required' ,
        ];

        if ($webinar->isWebinar()) {
            $rules['start_date'] = 'required|date';
            $rules['duration'] = 'required';
            $rules['capacity'] = 'required|integer';
        }

        $this->validate($request , $rules);

        if (!empty($data['teacher_id'])) {
            $teacher = User::find($data['teacher_id']);
            $creator = $webinar->creator;

            if (empty($teacher) or ($creator->isOrganization() and ($teacher->organ_id != $creator->id and $teacher->id != $creator->id))) {
                $toastData = [
                    'title'  => trans('public.request_failed') ,
                    'msg'    => trans('admin/main.is_not_the_teacher_of_this_organization') ,
                    'status' => 'error'
                ];
                return back()->with(['toast' => $toastData]);
            }
        }


        if (empty($data['slug'])) {
            $data['slug'] = Webinar::makeSlug($data['title']);
        }

        $data['status'] = $publish ? Webinar::$active : ($reject ? Webinar::$inactive : ($isDraft ? Webinar::$isDraft : Webinar::$pending));
        $data['updated_at'] = time();

        if (!empty($data['start_date']) and $webinar->type == 'webinar') {
            if (empty($data['timezone']) or !getFeaturesSettings('timezone_in_create_webinar')) {
                $data['timezone'] = getTimezone();
            }

            $startDate = convertTimeToUTCzone($data['start_date'] , $data['timezone']);

            $data['start_date'] = $startDate->getTimestamp();
        } else {
            $data['start_date'] = null;
        }


        $data['support'] = !empty($data['support']) ? true : false;
        $data['certificate'] = !empty($data['certificate']) ? true : false;
        $data['downloadable'] = !empty($data['downloadable']) ? true : false;
        $data['partner_instructor'] = !empty($data['partner_instructor']) ? true : false;
        $data['subscribe'] = !empty($data['subscribe']) ? true : false;
        $data['forum'] = !empty($data['forum']) ? true : false;
        $data['private'] = !empty($data['private']) ? true : false;
        $data['enable_waitlist'] = (!empty($data['enable_waitlist']));

        if (empty($data['partner_instructor'])) {
            WebinarPartnerTeacher::where('webinar_id' , $webinar->id)->delete();
            unset($data['partners']);
        }

        if ($data['category_id'] !== $webinar->category_id) {
            WebinarFilterOption::where('webinar_id' , $webinar->id)->delete();
        }

        $filters = $request->get('filters' , null);
        if (!empty($filters) and is_array($filters)) {
            WebinarFilterOption::where('webinar_id' , $webinar->id)->delete();
            foreach ($filters as $filter) {
                WebinarFilterOption::create([
                    'webinar_id'       => $webinar->id ,
                    'filter_option_id' => $filter
                ]);
            }
        }

        if (!empty($request->get('tags'))) {
            $tags = explode(',' , $request->get('tags'));
            Tag::where('webinar_id' , $webinar->id)->delete();

            foreach ($tags as $tag) {
                Tag::create([
                    'webinar_id' => $webinar->id ,
                    'title'      => $tag ,
                ]);
            }
        }

        if (!empty($request->get('partner_instructor')) and !empty($request->get('partners'))) {
            WebinarPartnerTeacher::where('webinar_id' , $webinar->id)->delete();

            foreach ($request->get('partners') as $partnerId) {
                WebinarPartnerTeacher::create([
                    'webinar_id' => $webinar->id ,
                    'teacher_id' => $partnerId ,
                ]);
            }
        }
        unset($data['_token'] ,
            $data['current_step'] ,
            $data['draft'] ,
            $data['get_next'] ,
            $data['partners'] ,
            $data['tags'] ,
            $data['filters'] ,
            $data['ajax']
        );

        if (empty($data['video_demo'])) {
            $data['video_demo_source'] = null;
        }

        if (!empty($data['video_demo_source']) and !in_array($data['video_demo_source'] , ['upload' , 'youtube' , 'vimeo' , 'external_link'])) {
            $data['video_demo_source'] = 'upload';
        }

        $newCreatorId = !empty($data['organ_id']) ? $data['organ_id'] : $data['teacher_id'];
        $changedCreator = ($webinar->creator_id != $newCreatorId);

        $data['price'] = !empty($data['price']) ? convertPriceToDefaultCurrency($data['price']) : null;
        $data['organization_price'] = !empty($data['organization_price']) ? convertPriceToDefaultCurrency($data['organization_price']) : null;
		
		

        $webinar->update([
            'slug'                 => $data['slug'] ,
            'creator_id'           => $newCreatorId ,
            'teacher_id'           => $data['teacher_id'] ,
            'type'                 => $data['type'] ,
            'thumbnail'            => $data['thumbnail'] ,
            'image_cover'          => $data['image_cover'] ,
            'video_demo'           => $data['video_demo'] ,
            'video_demo_source'    => $data['video_demo'] ? $data['video_demo_source'] : null ,
            'capacity'             => $data['capacity'] ?? null ,
            'start_date'           => $data['start_date'] ,
            'timezone'             => $data['timezone'] ?? null ,
            'duration'             => $data['duration'] ?? null ,
            'support'              => $data['support'] ,
            'certificate'          => $data['certificate'] ,
            'private'              => $data['private'] ,
            'enable_waitlist'      => $data['enable_waitlist'] ,
            'downloadable'         => $data['downloadable'] ,
            'partner_instructor'   => $data['partner_instructor'] ,
            'subscribe'            => $data['subscribe'] ,
            'forum'                => $data['forum'] ,
            'access_days'          => $data['access_days'] ?? null ,
            'price'                => $data['price'] ,
            'organization_price'   => $data['organization_price'] ?? null ,
            'category_id'          => is_array($data['category_id'])? json_encode($data['category_id']): $data['category_id'] ,
            'points'               => $data['points'] ?? null ,
            'message_for_reviewer' => $data['message_for_reviewer'] ?? null ,
            'status'               => $data['status'] ,
            'updated_at'           => time() ,
            'background_color'     => isset($data['background_color']) ? $data['background_color'] : '' ,
            'icon_code'            => isset($data['icon_code']) ? $data['icon_code'] : '' ,
            'webinar_type'         => isset($data['webinar_type']) ? $data['webinar_type'] : 'Course' ,
            'country_location'         => isset($data['country_location']) ? json_encode($data['country_location']) : 'uk' ,
            'seo_title'         => isset($data['seo_title']) ? $data['seo_title'] : '' ,
            'seo_robot_access'         => isset($data['seo_robot_access']) ? $data['seo_robot_access'] : 0 ,
            'include_xml'         => isset($data['include_xml']) ? $data['include_xml'] : 0 ,
            'custom_url'         => isset($data['custom_url']) ? $data['custom_url'] : '' ,
            'subject_type'         => isset($data['subject_type']) ? $data['subject_type'] : 'Course' ,
            'learn_background_color'     => isset($data['learn_background_color']) ? $data['learn_background_color'] : '' ,
            'learn_icon'     => isset($data['learn_icon']) ? $data['learn_icon'] : '' ,


        ]);

        if ($webinar) {
            WebinarTranslation::updateOrCreate([
                'webinar_id' => $webinar->id ,
                'locale'     => mb_strtolower($data['locale']) ,
            ] , [
                'title'           => $data['title'] ,
                'description'     => $data['description'] ,
                'seo_description' => $data['seo_description'] ,
            ]);
        }

        if ($publish) {
            sendNotification('course_approve' , ['[c.title]' => $webinar->title] , $webinar->teacher_id);

            $createClassesReward = RewardAccounting::calculateScore(Reward::CREATE_CLASSES);
            RewardAccounting::makeRewardAccounting(
                $webinar->creator_id ,
                $createClassesReward ,
                Reward::CREATE_CLASSES ,
                $webinar->id ,
                true
            );

        } elseif ($reject) {
            sendNotification('course_reject' , ['[c.title]' => $webinar->title] , $webinar->teacher_id);
        }

        if ($changedCreator) {
            $this->webinarChangedCreator($webinar);
        }

        removeContentLocale();

        return back();
    }

    public function destroy(Request $request , $id)
    {
        $this->authorize('admin_webinars_delete');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->delete();

        return redirect(getAdminPanelUrl() . '/webinars');
    }

    public function approve(Request $request , $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$active
        ]);

        $toastData = [
            'title'  => trans('public.request_success') ,
            'msg'    => trans('update.course_status_changes_to_approved') ,
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function reject(Request $request , $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$inactive
        ]);

        $toastData = [
            'title'  => trans('public.request_success') ,
            'msg'    => trans('update.course_status_changes_to_rejected') ,
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function unpublish(Request $request , $id)
    {
        $this->authorize('admin_webinars_edit');

        $webinar = Webinar::query()->findOrFail($id);

        $webinar->update([
            'status' => Webinar::$pending
        ]);

        $toastData = [
            'title'  => trans('public.request_success') ,
            'msg'    => trans('update.course_status_changes_to_unpublished') ,
            'status' => 'success'
        ];

        return redirect(getAdminPanelUrl() . '/webinars')->with(['toast' => $toastData]);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $option = $request->get('option' , null);

        $query = Webinar::select('id')
            ->whereTranslationLike('title' , "%$term%");

        if (!empty($option) and $option == 'just_webinar') {
            $query->where('type' , Webinar::$webinar);
            $query->where('status' , Webinar::$active);
        }

        $webinar = $query->get();

        return response()->json($webinar , 200);
    }

    public function courses_by_categories(Request $request)
    {
        $category_ids = $request->get('category_id');
        $course_id = $request->get('course_id');
        //$courses = Webinar::where('category_id',$category_id)->get();
		
		$category_ids = is_array( $category_ids )? $category_ids : $category_id;
		
		
        $query = Webinar::query();
        $courses = $query->join('webinar_translations' , 'webinar_translations.webinar_id' , '=' , 'webinars.id')->select('webinars.id as webinar_id' , 'webinar_translations.title as webinar_title');
            
		foreach( $category_ids as $category_id){
			$courses = $courses->orWhereJsonContains('webinars.category_id' , (string) $category_id);
		}
			
		$courses = $courses->paginate(100);

        $response = '<option value="">Select Course</option>';
        if (!empty($courses)) {
            foreach ($courses as $courseData) {
                $webinar_id = isset($courseData['webinar_id']) ? $courseData['webinar_id'] : '';
                $webinar_title = isset($courseData['webinar_title']) ? $courseData['webinar_title'] : '';
                $selected = ($course_id == $webinar_id)? 'selected' : '';
                $response .= '<option value="' . $webinar_id . '" '. $selected .'>' . $webinar_title . '</option>';
            }
        }

        echo $response;
        exit;

    }

    public function chapters_by_course_bk(Request $request)
    {
        $course_id = $request->get('course_id');
        $selected_chapter_id = $request->get('chapter_id');

        $chapters_list = get_chapters_list(false , $course_id);
        //pre($chapters_list);

        $response = '<option value="">Select Chapter</option>';
        if (!empty($chapters_list)) {
            foreach ($chapters_list as $chapter_id => $chapterData) {
                if (!empty($chapterData['chapters']) and count($chapterData['chapters'])) {
                    $response .= '<optgroup label="' . $chapterData['title'] . '">';
                    if (isset($chapterData['chapters']) && !empty($chapterData['chapters'])) {
                        foreach ($chapterData['chapters'] as $sub_chapter_id => $sub_chapter_title) {
                            $selected = ($selected_chapter_id == $sub_chapter_id)? 'selected' : '';
                            $response .= '<option value="' . $sub_chapter_id . '" '. $selected .'>' . $sub_chapter_title . '</option>';
                        }
                    }
                    $response .= '</optgroup>';
                } else {
                    $response .= '<option value="' . $chapter_id . '">' . $chapterData['title'] . '</option>';
                }
            }
        }

        echo $response;
        exit;

    }

    public function chapters_by_course(Request $request)
        {
            $course_id = $request->get('course_id');
            $selected_chapter_id = $request->get('chapter_id');

            $chapters_list = get_chapters_list(false , $course_id);
            $WebinarChapter = WebinarChapter::where('webinar_id', $course_id)->with('subChapters')->get();
            //pre($chapters_list);

            $response = '<option value="">Select Chapter</option>';
            if (!empty($WebinarChapter)) {
                foreach ($WebinarChapter as $WebinarChapter) {
                        $selected = ($selected_chapter_id == $WebinarChapter->id)? 'selected' : '';
                        $response .= '<option value="' . $WebinarChapter->id . '" '.$selected.'>' . $WebinarChapter->getTitleAttribute() . '</option>';
                }
            }

            echo $response;
            exit;

        }

    public function sub_chapters_by_chapter(Request $request)
    {
        $chapter_id = $request->get('chapter_id');
        $selected_sub_chapter_id = $request->get('sub_chapter_id');

        $WebinarSubChapter = SubChapters::where('chapter_id', $chapter_id)->get();

        $response = '<option value="">Select Sub Chapter</option>';
        if (!empty($WebinarSubChapter)) {
            foreach ($WebinarSubChapter as $WebinarSubChapterObj) {
                    $selected = ($selected_sub_chapter_id == $WebinarSubChapterObj->id)? 'selected' : '';
                    $response .= '<option value="' . $WebinarSubChapterObj->id . '" '.$selected.'>' . $WebinarSubChapterObj->sub_chapter_title . '</option>';
            }
        }

        echo $response;
        exit;

    }




    public function exportExcel(Request $request)
    {
        $this->authorize('admin_webinars_export_excel');

        $query = Webinar::query();

        $query = $this->filterWebinar($query , $request)
            ->with([
                'teacher' => function ($qu) {
                    $qu->select('id' , 'full_name');
                } , 'sales'
            ]);

        $webinars = $query->get();

        $webinarExport = new WebinarsExport($webinars);

        return Excel::download($webinarExport , 'webinars.xlsx');
    }

    public function studentsLists(Request $request , $id)
    {
        $this->authorize('admin_webinar_students_lists');

        $webinar = Webinar::where('id' , $id)
            ->with([
                'teacher'     => function ($qu) {
                    $qu->select('id' , 'full_name');
                } ,
                'chapters'    => function ($query) {
                    $query->where('status' , 'active');
                } ,
                'sessions'    => function ($query) {
                    $query->where('status' , 'active');
                } ,
                'assignments' => function ($query) {
                    $query->where('status' , 'active');
                } ,
                'quizzes'     => function ($query) {
                    $query->where('status' , 'active');
                } ,
                'files'       => function ($query) {
                    $query->where('status' , 'active');
                } ,
            ])
            ->first();


        if (!empty($webinar)) {
            $giftsIds = Gift::query()->where('webinar_id' , $webinar->id)
                ->where('status' , 'active')
                ->where(function ($query) {
                    $query->whereNull('date');
                    $query->orWhere('date' , '<' , time());
                })
                ->whereHas('sale')
                ->pluck('id')
                ->toArray();

            $query = User::join('sales' , 'sales.buyer_id' , 'users.id')
                ->leftJoin('webinar_reviews' , function ($query) use ($webinar) {
                    $query->on('webinar_reviews.creator_id' , 'users.id')
                        ->where('webinar_reviews.webinar_id' , $webinar->id);
                })
                ->select('users.*' , 'webinar_reviews.rates' , 'sales.access_to_purchased_item' , 'sales.id as sale_id' , 'sales.gift_id' , DB::raw('sales.created_at as purchase_date'))
                ->where(function ($query) use ($webinar , $giftsIds) {
                    $query->where('sales.webinar_id' , $webinar->id);
                    $query->orWhereIn('sales.gift_id' , $giftsIds);
                })
                ->whereNull('sales.refund_at');

            $students = $this->studentsListsFilters($webinar , $query , $request)
                ->orderBy('sales.created_at' , 'desc')
                ->paginate(10);

            $userGroups = Group::where('status' , 'active')
                ->orderBy('created_at' , 'desc')
                ->get();

            $totalExpireStudents = 0;
            if (!empty($webinar->access_days)) {
                $accessTimestamp = $webinar->access_days * 24 * 60 * 60;

                $totalExpireStudents = User::join('sales' , 'sales.buyer_id' , 'users.id')
                    ->select('users.*' , DB::raw('sales.created_at as purchase_date'))
                    ->where(function ($query) use ($webinar , $giftsIds) {
                        $query->where('sales.webinar_id' , $webinar->id);
                        $query->orWhereIn('sales.gift_id' , $giftsIds);
                    })
                    ->whereRaw('sales.created_at + ? < ?' , [$accessTimestamp , time()])
                    ->whereNull('sales.refund_at')
                    ->count();
            }

            $webinarStatisticController = new WebinarStatisticController();

            $allStudentsIds = User::join('sales' , 'sales.buyer_id' , 'users.id')
                ->select('users.*' , DB::raw('sales.created_at as purchase_date'))
                ->where(function ($query) use ($webinar , $giftsIds) {
                    $query->where('sales.webinar_id' , $webinar->id);
                    $query->orWhereIn('sales.gift_id' , $giftsIds);
                })
                ->whereNull('sales.refund_at')
                ->pluck('id')
                ->toArray();

            $learningPercents = [];
            foreach ($allStudentsIds as $studentsId) {
                $learningPercents[$studentsId] = $webinarStatisticController->getCourseProgressForStudent($webinar , $studentsId);
            }

            foreach ($students as $key => $student) {
                if (!empty($student->gift_id)) {
                    $gift = Gift::query()->where('id' , $student->gift_id)->first();

                    if (!empty($gift)) {
                        $receipt = $gift->receipt;

                        if (!empty($receipt)) {
                            $receipt->rates = $student->rates;
                            $receipt->access_to_purchased_item = $student->access_to_purchased_item;
                            $receipt->sale_id = $student->sale_id;
                            $receipt->purchase_date = $student->purchase_date;
                            $receipt->learning = $webinarStatisticController->getCourseProgressForStudent($webinar , $receipt->id);

                            $learningPercents[$student->id] = $receipt->learning;

                            $students[$key] = $receipt;
                        } else { /* Gift recipient who has not registered yet */
                            $newUser = new User();
                            $newUser->full_name = $gift->name;
                            $newUser->email = $gift->email;
                            $newUser->rates = 0;
                            $newUser->access_to_purchased_item = $student->access_to_purchased_item;
                            $newUser->sale_id = $student->sale_id;
                            $newUser->purchase_date = $student->purchase_date;
                            $newUser->learning = 0;

                            $students[$key] = $newUser;
                        }
                    }
                } else {
                    $student->learning = !empty($learningPercents[$student->id]) ? $learningPercents[$student->id] : 0;
                }
            }

            $roles = Role::all();

            $data = [
                'pageTitle'           => trans('admin/main.students') ,
                'webinar'             => $webinar ,
                'students'            => $students ,
                'userGroups'          => $userGroups ,
                'roles'               => $roles ,
                'totalStudents'       => $students->total() ,
                'totalActiveStudents' => $students->total() - $totalExpireStudents ,
                'totalExpireStudents' => $totalExpireStudents ,
                'averageLearning'     => count($learningPercents) ? round(array_sum($learningPercents) / count($learningPercents) , 2) : 0 ,
            ];

            return view('admin.webinars.students' , $data);
        }

        abort(404);
    }

    private function studentsListsFilters($webinar , $query , $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $full_name = $request->get('full_name');
        $sort = $request->get('sort');
        $group_id = $request->get('group_id');
        $role_id = $request->get('role_id');
        $status = $request->get('status');

        $query = fromAndToDateFilter($from , $to , $query , 'sales.created_at');

        if (!empty($full_name)) {
            $query->where('users.full_name' , 'like' , "%$full_name%");
        }

        if (!empty($sort)) {
            if ($sort == 'rate_asc') {
                $query->orderBy('webinar_reviews.rates' , 'asc');
            }

            if ($sort == 'rate_desc') {
                $query->orderBy('webinar_reviews.rates' , 'desc');
            }
        }

        if (!empty($group_id)) {
            $userIds = GroupUser::where('group_id' , $group_id)->pluck('user_id')->toArray();

            $query->whereIn('users.id' , $userIds);
        }

        if (!empty($role_id)) {
            $query->where('users.role_id' , $role_id);
        }

        if (!empty($status)) {
            if ($status == 'expire' and !empty($webinar->access_days)) {
                $accessTimestamp = $webinar->access_days * 24 * 60 * 60;

                $query->whereRaw('sales.created_at + ? < ?' , [$accessTimestamp , time()]);
            }
        }

        return $query;
    }

    public function notificationToStudents($id)
    {
        $this->authorize('admin_webinar_notification_to_students');

        $webinar = Webinar::findOrFail($id);

        $data = [
            'pageTitle' => trans('notification.send_notification') ,
            'webinar'   => $webinar
        ];

        return view('admin.webinars.send-notification-to-course-students' , $data);
    }


    public function sendNotificationToStudents(Request $request , $id)
    {
        $this->authorize('admin_webinar_notification_to_students');

        $this->validate($request , [
            'title'   => 'required|string' ,
            'message' => 'required|string' ,
        ]);

        $data = $request->all();

        $webinar = Webinar::where('id' , $id)
            ->with([
                'sales' => function ($query) {
                    $query->whereNull('refund_at');
                    $query->with([
                        'buyer'
                    ]);
                }
            ])
            ->first();

        if (!empty($webinar)) {
            foreach ($webinar->sales as $sale) {
                if (!empty($sale->buyer)) {
                    $user = $sale->buyer;

                    Notification::create([
                        'user_id'    => $user->id ,
                        'group_id'   => null ,
                        'sender_id'  => auth()->id() ,
                        'title'      => $data['title'] ,
                        'message'    => $data['message'] ,
                        'sender'     => Notification::$AdminSender ,
                        'type'       => 'single' ,
                        'created_at' => time()
                    ]);

                    if (!empty($user->email) and env('APP_ENV') == 'production') {
                        \Mail::to($user->email)->send(new SendNotifications(['title' => $data['title'] , 'message' => $data['message']]));
                    }
                }
            }

            $toastData = [
                'title'  => trans('public.request_success') ,
                'msg'    => trans('update.the_notification_was_successfully_sent_to_n_students' , ['count' => count($webinar->sales)]) ,
                'status' => 'success'
            ];

            return redirect(getAdminPanelUrl("/webinars/{$webinar->id}/students"))->with(['toast' => $toastData]);
        }

        abort(404);
    }

    public function orderItems(Request $request)
    {
        $this->authorize('admin_webinars_edit');
        $data = $request->all();

        $validator = Validator::make($data , [
            'items' => 'required' ,
            'table' => 'required' ,
        ]);

        if ($validator->fails()) {
            return response([
                'code'   => 422 ,
                'errors' => $validator->errors() ,
            ] , 422);
        }

        $tableName = $data['table'];
        $itemIds = explode(',' , $data['items']);

        if (!is_array($itemIds) and !empty($itemIds)) {
            $itemIds = [$itemIds];
        }

        if (!empty($itemIds) and is_array($itemIds) and count($itemIds)) {
            switch ($tableName) {
                case 'tickets':
                    foreach ($itemIds as $order => $id) {
                        Ticket::where('id' , $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'sessions':
                    foreach ($itemIds as $order => $id) {
                        Session::where('id' , $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'files':
                    foreach ($itemIds as $order => $id) {
                        File::where('id' , $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'text_lessons':
                    foreach ($itemIds as $order => $id) {
                        TextLesson::where('id' , $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapters':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapter::where('id' , $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
                case 'webinar_chapter_items':
                    foreach ($itemIds as $order => $id) {
                        WebinarChapterItem::where('id' , $id)
                            ->update(['order' => ($order + 1)]);
                    }
                case 'bundle_webinars':
                    foreach ($itemIds as $order => $id) {
                        BundleWebinar::where('id' , $id)
                            ->update(['order' => ($order + 1)]);
                    }
                    break;
            }
        }

        return response()->json([
            'title' => trans('public.request_success') ,
            'msg'   => trans('update.items_sorted_successful')
        ]);
    }


    public function getContentItemByLocale(Request $request , $id)
    {
        $this->authorize('admin_webinars_edit');

        $data = $request->all();

        $validator = Validator::make($data , [
            'item_id'  => 'required' ,
            'locale'   => 'required' ,
            'relation' => 'required' ,
        ]);

        if ($validator->fails()) {
            return response([
                'code'   => 422 ,
                'errors' => $validator->errors() ,
            ] , 422);
        }

        $webinar = Webinar::where('id' , $id)->first();

        if (!empty($webinar)) {

            $itemId = $data['item_id'];
            $locale = $data['locale'];
            $relation = $data['relation'];

            if (!empty($webinar->$relation)) {
                $item = $webinar->$relation->where('id' , $itemId)->first();

                if (!empty($item)) {
                    foreach ($item->translatedAttributes as $attribute) {
                        try {
                            $item->$attribute = $item->translate(mb_strtolower($locale))->$attribute;
                        } catch (\Exception $e) {
                            $item->$attribute = null;
                        }
                    }

                    return response()->json([
                        'item' => $item
                    ] , 200);
                }
            }
        }

        abort(403);
    }
}
