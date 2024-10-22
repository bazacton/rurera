@extends('admin.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
<style>
    .hide {
        display: none;
    }
</style>
@endpush

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ trans('admin/main.questions_bank') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">{{ trans('admin/main.quizzes') }}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>{{ trans('admin/main.total_quizzes') }}</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalQuestions }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Approved</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalApproved }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="card card-statistic-1">

                <div class="card-wrap">
                    <div class="card-header">
                        <h4>In-Review</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalInReview }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
            <div class="card card-statistic-1">

                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Improvement</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalImprovement }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-12 hide">
            <div class="card card-statistic-1">

                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Hold/Reject</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalHoldReject }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="/admin/questions_bank" id="questions_search_form" method="get" class="row mb-0">
				
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">Question ID</label>
                            <input type="text" class="form-control" name="question_id"
                                   value="{{ get_filter_request('question_id', 'questions_search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.search') }}</label>
                            <input type="text" class="form-control" name="title" value="{{ get_filter_request('title', 'questions_search') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="fsdate" class="text-center form-control" name="from"
                                       value="{{ get_filter_request('from', 'questions_search') }}" placeholder="Start Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="lsdate" class="text-center form-control" name="to"
                                       value="{{ get_filter_request('to', 'questions_search') }}" placeholder="End Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{trans('admin/main.category')}}</label>
                            <select name="category_id" data-plugin-selectTwo class="form-control populate ajax-category-courses" data-course_id="{{get_filter_request('subject_id', 'questions_search')}}">
                                <option value="">{{trans('admin/main.all_categories')}}</option>
                                @foreach($categories as $category)
                                @if(!empty($category->subCategories) and count($category->subCategories))
                                <optgroup label="{{  $category->title }}">
                                    @foreach($category->subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @if(get_filter_request('category_id', 'questions_search') == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                    @endforeach
                                </optgroup>
                                @else
                                <option value="{{ $category->id }}" @if(get_filter_request('category_id', 'questions_search') == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
					
					
					
					

					<div class="col-md-3">
					<div class="form-group">
						<label>Subjects</label>
						<select data-return_type="option"
								data-default_id="{{request()->get('subject_id')}}" data-chapter_id="{{get_filter_request('chapter_id', 'questions_search')}}"
								class="ajax-courses-dropdown year_subjects form-control select2 @error('subject_id') is-invalid @enderror"
								id="subject_id" name="subject_id">
							<option disabled selected>Subject</option>
						</select>
						@error('subject_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					</div>
					
					
					<div class="col-md-3">
					<div class="form-group">
						<label class="input-label">Topic</label>
						<select data-sub_chapter_id="{{get_filter_request('sub_chapter_id', 'questions_search')}}" id="chapter_id"
								class="form-control populate ajax-chapter-dropdown @error('chapter_id') is-invalid @enderror"
								name="chapter_id">
							<option value="">Please select year, subject</option>
						</select>
						@error('chapter_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror

					</div>
					</div>
					
					
					<div class="col-md-3">
					<div class="form-group">
						<label class="input-label">Sub Topic</label>
						<select id="chapter_id"
							class="form-control populate ajax-subchapter-dropdown @error('sub_chapter_id') is-invalid @enderror"
							name="sub_chapter_id">
						<option value="">Please select year, subject, Topic</option>
					</select>
					@error('sub_chapter_id')
					<div class="invalid-feedback">
						{{ $message }}
					</div>
					@enderror
					

					</div>
					</div>
					
					
					
					<div class="col-md-3">
						<div class="form-group">	
							<label class="input-label">Author</label>
							<select name="user_id" data-search-option="display_name" class="form-control "
									data-placeholder="Search author">

									<option value="">Select Author</option>
								@if(!empty($users_list) and $users_list->count() > 0)
									@foreach($users_list as $userObj)
										@php $checked = (get_filter_request('user_id', 'questions_search') == $userObj->id)? 'selected' : ''; @endphp
										<option value="{{ $userObj->id }}" {{$checked}}>{{ $userObj->get_full_name() }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="input-label">Difficulty Level</label>
                            <select name="difficulty_level" data-plugin-selectTwo class="form-control populate">
                                <option value="">All Levels</option>
                                <option value="Below" @if(get_filter_request('difficulty_level', 'questions_search') == 'Below') selected
                                    @endif>Below
                                </option>
                                <option value="Emerging" @if(get_filter_request('difficulty_level', 'questions_search') == 'Emerging') selected
                                    @endif>Emerging
                                </option>
                                <option value="Expected" @if(get_filter_request('difficulty_level', 'questions_search') == 'Expected') selected
                                    @endif>Expected
                                </option>
                                <option value="Exceeding" @if(get_filter_request('difficulty_level', 'questions_search') == 'Exceeding')
                                    selected @endif>Exceeding
                                </option>
                                <option value="Challenge" @if(get_filter_request('difficulty_level', 'questions_search') == 'Challenge')
                                    selected @endif>Challenge
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="input-label">Teacher Review</label>
                            <select name="review_required" data-plugin-selectTwo class="form-control populate">
                                <option value="">All</option>
                                <option value="1" @if(get_filter_request('review_required', 'questions_search') == '1') selected
                                    @endif>Yes
                                </option>
                                <option value="0" @if(get_filter_request('review_required', 'questions_search') == '0') selected
                                    @endif>No
                                </option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.status') }}</label>
                            <select name="question_status" data-plugin-selectTwo class="form-control populate">
                                <option value="">{{ trans('admin/main.all_status') }}</option>
                                <option value="Draft" @if(get_filter_request('question_status', 'questions_search') == 'Draft') selected
                                    @endif>Draft
                                </option>
                                <option value="Submit for review" @if(get_filter_request('question_status', 'questions_search') == 'Submit for
                                    review') selected @endif>Submit for review
                                </option>
                                <option value="Hard reject" @if(get_filter_request('question_status', 'questions_search') == 'Hard reject')
                                    selected @endif>Hard reject
                                </option>
                                <option value="Improvement required" @if(get_filter_request('question_status', 'questions_search') ==
                                    'Improvement required') selected @endif>Improvement required
                                </option>
                                <option value="On hold" @if(get_filter_request('question_status', 'questions_search') == 'On hold') selected
                                    @endif>On hold
                                </option>
                                <option value="Accepted" @if(get_filter_request('question_status', 'questions_search') == 'Accepted') selected
                                    @endif>Accepted
                                </option>
                                <option value="Offline" @if(get_filter_request('question_status', 'questions_search') == 'Offline') selected
                                    @endif>Offline
                                </option>
                                <option value="Published" @if(get_filter_request('question_status', 'questions_search') == 'Published') selected
                                    @endif>Published
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}
                        </button>
                    </div>
					<div class="col-12 col-md-12">
						<button type="button" class="btn btn-primary pin-search" data-search_type="questions_search" data-form_id="questions_search_form"><i class="fas fa-save"></i> Pin Search</button>
						<button type="button" class="btn btn-danger unpin-search" data-search_type="questions_search" data-form_id="questions_search_form"><i class="fas fa-save"></i> Unpin Search</button>
					</div>
                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">

                    @can('admin_questions_bank_create')
                    <div class="card-header">
                        <div class="text-right">
                            <a href="/admin/questions_bank/create" class="btn btn-primary">New Question</a>
                        </div>
                    </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">{{ trans('admin/main.title') }}</th>
                                    <th class="text-left">Class / Subject / Chapter</th>
                                    <th class="text-center">Difficulty Level</th>
                                    <th class="text-center">Added by</th>
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">Status</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($questions as $questionData)
                                <tr>
                                    <td>
                                        <span>{{ $questionData->title }}</span>
                                    </td>
                                    <td class="text-left">
                                        <span class="text-primary mt-0 mb-1 font-weight-bold">
                                            {{ isset ($questionData->category->id)?
                                            $questionData->category->getTitleAttribute() : '-'}}
                                            / {{ isset ($questionData->course->id)?
                                            $questionData->course->getTitleAttribute() : '-'}}</span>
                                        <div class="text-small">{{ isset ($questionData->subChapter->id)?
                                            $questionData->subChapter->sub_chapter_title : '' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $questionData->question_difficulty_level }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $questionData->user->get_full_name() }}</span>
                                    </td>
                                    <td>
                                        <span>{{ dateTimeFormat($questionData->created_at, 'j M y | H:i') }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $questionData->question_status }}</span>
                                    </td>
                                    <td>
                                        @if(auth()->user()->isAuthor() || auth()->user()->isReviewer())
                                        <a href="/admin/questions_bank/{{ $questionData->id }}/log"
                                           class="btn-transparent btn-sm text-primary" data-toggle="tooltip"
                                           data-placement="top" title="Question Log">
                                            <i class="fa fa-th-list"></i>
                                        </a>
                                        @endif

                                        @can('admin_questions_bank_create')
                                        <a href="/admin/questions_bank/{{ $questionData->id }}/duplicate"
                                           class="btn-transparent btn-sm text-primary" data-toggle="tooltip"
                                           data-placement="top" title="Duplicate">
                                            <i class="fa fa-clone"></i>
                                        </a>
                                        @endcan
                                        <a href="/panel/questions/{{ $questionData->id }}/start"
                                           class="btn-transparent btn-sm text-primary" data-toggle="tooltip"
                                           data-placement="top" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->can('admin_questions_bank_edit'))
                                        <a href="/admin/questions_bank/{{ $questionData->id }}/edit"
                                           class="btn-transparent btn-sm text-primary" data-toggle="tooltip"
                                           data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endif

                                        @if(auth()->user()->can('admin_questions_bank_delete'))
                                        @include('admin.includes.delete_button',['url' =>
                                        '/admin/questions_bank/'.$questionData->id.'/delete' , 'btnClass' => 'btn-sm'])
                                        @endif

                                        @if($user->role_name == 'reviewer' && ($questionData->question_status ==
                                        'Published' || $questionData->question_status == 'Offline'))
                                        <label class="custom-switch pl-0">
                                            <input type="checkbox" name="publish_question"
                                                   data-question_id="{{$questionData->id}}" id="publish_question"
                                                   value="1" class="custom-switch-input update_question_status"
                                                   @if($questionData->question_status == 'Published') checked="checked"
                                            @endif/>
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                        <div class="text-right">
                            Records found: <b>{{$foundRecords}}</b>
                        </div>
                    </div>


                    <div class="card-footer text-center">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>

<script type="text/javascript">
    $("body").on("change", ".update_question_status", function (t) {
        var question_status = 'Offline';
        if ($(this).is(":checked")) {
            var question_status = 'Published';
        }
        var question_id = $(this).attr('data-question_id');
        jQuery.ajax({
            type: "POST",
            url: '/admin/questions_bank/question_status_update',
            data: {"question_id": question_id, "question_status": question_status},
            success: function (return_data) {
                if (return_data.code == 200) {
                    Swal.fire({
                        html: '<h3 class="font-20 text-center text-dark-blue">Updated Successfully</h3>',
                        showConfirmButton: false,
                        icon: 'success',
                    });
                }
            }
        });
    });


    $(document).on('change', '.ajax-category-courses', function () {
			var category_id = $(this).val();
			var course_id = $(this).attr('data-course_id');
			$.ajax({
				type: "GET",
				url: '/admin/webinars/courses_by_categories',
				data: {'category_id': category_id, 'course_id': course_id},
				success: function (return_data) {
					$(".ajax-courses-dropdown").html(return_data);
					$(".ajax-chapter-dropdown").html('<option value="">Please select year, subject</option>');
					$('.ajax-courses-dropdown').change();
				}
			});
		});

		$(document).on('change', '.ajax-courses-dropdown', function () {
			var course_id = $(this).val();
			var chapter_id = $(this).attr('data-chapter_id');

			$.ajax({
				type: "GET",
				url: '/admin/webinars/chapters_by_course',
				data: {'course_id': course_id, 'chapter_id': chapter_id},
				success: function (return_data) {
					$(".ajax-chapter-dropdown").html(return_data);
					$('.ajax-chapter-dropdown').change();
				}
			});
		});

		$(document).on('change', '.ajax-chapter-dropdown', function () {
			var chapter_id = $(this).val();
			var sub_chapter_id = $(this).attr('data-sub_chapter_id');
			$.ajax({
				type: "GET",
				url: '/admin/webinars/sub_chapters_by_chapter',
				data: {'chapter_id': chapter_id, 'sub_chapter_id': sub_chapter_id},
				success: function (return_data) {
					$(".ajax-subchapter-dropdown").html(return_data);
				}
			});
		});
        $(".ajax-category-courses").change();
</script>

@endpush
