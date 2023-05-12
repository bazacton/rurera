<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuizResultsExport;
use App\Exports\QuizzesAdminExport;
use App\Http\Controllers\Controller;
use App\Models\AuthorPermissions;
use App\Models\Category;
use App\User;
use App\Models\Webinar;
use App\Models\WebinarChapter;
use App\Models\SubChapters;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AuthorPermissionsController extends Controller {

    public function index(Request $request) {
        $user = auth()->user();
        $categories = Category::where('parent_id', null)
                ->with('subCategories')
                ->get();
        $data = [
            'pageTitle' => 'Author Permissions',
            'categories' => $categories,
        ];

        return view('admin.author_permissions.lists', $data);
    }
    
    public function authors(Request $request) {
        $user = auth()->user();
        if( $user->role_name != 'reviewer'){
            $toastData = [
                'title' => 'Request not completed',
                'msg' => 'You dont have permissions to perform this action.',
                'status' => 'error'
            ];
            return redirect()->back()->with(['toast' => $toastData]);
        }
        $authors = User::where('role_name', 'teachers')
                ->where('status', 'active')
                ->get();
        $data = [
            'pageTitle' => 'Authors',
            'authors' => $authors,
        ];

        return view('admin.author_permissions.authors', $data);
    }

    public function get_sub_chapters_list(Request $request) {
        $user = auth()->user();
        $course_id = $request->post('course_id');
        $course = Webinar::where('id', $course_id)
                ->with([
                    'webinar_sub_chapters' => function ($query) {
                        $query->orderBy('id', 'asc');
                    },
                    'chapters' => function ($query) use ($user) {
                        $query->where('status', WebinarChapter::$chapterActive);
                        $query->orderBy('order', 'asc');

                        $query->with([
                            'chapterItems' => function ($query) {
                                $query->orderBy('order', 'asc');
                            }
                        ]);
                    },
                            'textLessons' => function ($query) use ($user) {
                        $query->where('status', WebinarChapter::$chapterActive)
                        ->withCount(['attachments'])
                        ->orderBy('order', 'asc')
                        ->with([
                            'learningStatus' => function ($query) use ($user) {
                                $query->where('user_id', !empty($user) ? $user->id : null);
                            }
                        ]);
                    },
                        ])
                        ->where('status', 'active')
                        ->first();


                $webinar_sub_chapters = isset($course->webinar_sub_chapters) ? $course->webinar_sub_chapters : array();
                $sub_chapters = array();
                if (!empty($webinar_sub_chapters)) {
                    foreach ($webinar_sub_chapters as $sub_chapter_item) {


                        $sub_chapter_authors = AuthorPermissions::join('users', 'author_permissions.author_id', '=', 'users.id')
                                        ->where('author_permissions.status', 'active')
                                        ->where('sub_chapter_id', $sub_chapter_item->id)
                                        ->get()->pluck('full_name')->toArray();

                        $sub_chapters[$sub_chapter_item->chapter_id][] = array(
                            'id' => $sub_chapter_item->id,
                            'title' => $sub_chapter_item->sub_chapter_title,
                            'chapter_id' => $sub_chapter_item->chapter_id,
                            'authors_list' => $sub_chapter_authors,
                        );
                    }
                }

                $response_html = '';
                foreach ($course->chapters as $chapter) {
                    if ((!empty($chapter->chapterItems) and count($chapter->chapterItems)) or ( !empty($chapter->quizzes) and count($chapter->quizzes))) {


                        $chapter_authors = AuthorPermissions::join('users', 'author_permissions.author_id', '=', 'users.id')
                                        ->where('author_permissions.status', 'active')
                                        ->where('chapter_id', $chapter->id)->groupBy('chapter_id')
                                        ->get()->pluck('full_name')->toArray();


                        $response_html .= '<li><div class="lms-chapter-title"><strong>' . $chapter->title . '</strong><a href="javascript:;" data-chapter_id="' . $chapter->id . '" class="add-author-permissions"><i class="fas fa-plus"></i></a>
                                    <span class="authors-list text-right authors-list-' . $chapter->id . '">';
                        if (!empty($chapter_authors)) {
                            foreach ($chapter_authors as $author_name) {
                                $response_html .= '<span>' . $author_name . '</span>';
                            }
                        }
                        $response_html .='</span>';
                        $response_html .= '</div>';
                        if (!empty($sub_chapters[$chapter->id]) and count($sub_chapters[$chapter->id])) {
                            $response_html .= '<ul>';
                            foreach ($sub_chapters[$chapter->id] as $sub_chapter) {
                                if (!empty($sub_chapter)) {
                                    $response_html .= '<li><a href="/course/learning/' . $course->slug . '?webinar=' . $chapter->id . '&chapter=' . $sub_chapter['id'] . '">' . $sub_chapter['title'] . '</a>
                                    <span class="authors-list text-right authors-list-' . $sub_chapter['id'] . '">';
                                    if (!empty($sub_chapter['authors_list'])) {
                                        foreach ($sub_chapter['authors_list'] as $author_name) {
                                            $response_html .= '<span>' . $author_name . '</span>';
                                        }
                                    }
                                    $response_html .='</span>
								<a href="javascript:;" data-sub_chapter_id="' . $sub_chapter['id'] . '" class="add-author-permissions"><i class="fas fa-plus"></i></a>
								</li>';
                                }
                            }
                            $response_html .= '</ul>';
                        }
                        $response_html .= '</li><br>';
                    }
                }

                return response()->json([
                            'code' => 200,
                            'response_html' => $response_html,
                ]);
            }

            public function get_sub_chapter_authors(Request $request) {
                $sub_chapter_id = $request->post('sub_chapter_id');
                $chapter_id = $request->post('chapter_id');

                $authors = User::where('status', 'active')
                        ->where('role_name', 'teachers')
                        ->get();

                $query = AuthorPermissions::where('status', 'active');
                if ($chapter_id != '' && $chapter_id > 0) {
                    $query->where('chapter_id', $chapter_id);
                } else {
                    $query->where('sub_chapter_id', $sub_chapter_id);
                }
                $sub_chapter_authors = $query->get()->pluck('author_id')->toArray();
                ?>
                <div id="author-permissions-modal" class="author-permissions-modal modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form name="author_permissions_form" id="author_permissions_form">
                                    <div class="form-group">
                                        <label>Authors</label>
                                        <select class="form-control authors_select" multiple="multiple" name="author_id[]">
                                            <?php
                                            if (!empty($authors)) {
                                                foreach ($authors as $authorObj) {
                                                    $selected = in_array($authorObj->id, $sub_chapter_authors) ? 'selected' : '';
                                                    ?> 
                                                    <option value="<?php echo $authorObj->id; ?>" <?php echo $selected; ?>><?php echo $authorObj->full_name; ?></option> 
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="sub_chapter_id" value="<?php echo $sub_chapter_id; ?>">
                                    <input type="hidden" name="chapter_id" value="<?php echo $chapter_id; ?>">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <div class="text-right">
                                    <a href="javascript:;" class="btn btn-primary author_permissions_submit_btn">Submit</a>
                                </div>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                exit();
            }

            public function sub_chapter_authors_update(Request $request) {
                $user = auth()->user();
                $sub_chapter_id = $request->post('sub_chapter_id');
                $chapter_id = $request->post('chapter_id');
                $author_ids = $request->post('author_id');
                if ($chapter_id != '' && $chapter_id > 0) {
                    AuthorPermissions::where('chapter_id', $chapter_id)->delete();

                    $sub_chapter_ids = SubChapters::where('chapter_id', $chapter_id)
                                    ->where('status', 'active')
                                    ->get()->pluck('id')->toArray();

                    if (!empty($sub_chapter_ids)) {

                        foreach ($sub_chapter_ids as $sub_chapter_id) {
                            if (!empty($author_ids)) {
                                foreach ($author_ids as $author_id) {
                                    AuthorPermissions::create([
                                        'author_id' => $author_id,
                                        'chapter_id' => $chapter_id,
                                        'sub_chapter_id' => $sub_chapter_id,
                                        'status' => 'active',
                                        'created_by' => $user->id,
                                        'created_at' => time()
                                    ]);
                                }
                            }
                        }
                    }
                } else {
                    AuthorPermissions::where('sub_chapter_id', $sub_chapter_id)->delete();

                    if (!empty($author_ids)) {

                        foreach ($author_ids as $author_id) {
                            AuthorPermissions::create([
                                'author_id' => $author_id,
                                'sub_chapter_id' => $sub_chapter_id,
                                'status' => 'active',
                                'created_by' => $user->id,
                                'created_at' => time()
                            ]);
                        }
                    }
                }

                $sub_chapter_authors = AuthorPermissions::join('users', 'author_permissions.author_id', '=', 'users.id')
                                ->where('author_permissions.status', 'active')
                                ->where('sub_chapter_id', $sub_chapter_id)
                                ->get()->pluck('full_name')->toArray();

                $sub_chapter_authors_response = '';
                if (!empty($sub_chapter_authors)) {
                    foreach ($sub_chapter_authors as $author_name) {
                        $sub_chapter_authors_response .= '<span>' . $author_name . '</span>';
                    }
                }

                return response()->json([
                            'code' => 200,
                            'sub_chapter_id' => $sub_chapter_id,
                            'sub_chapter_authors_response' => $sub_chapter_authors_response,
                ]);
            }

        }
        