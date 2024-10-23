@php use App\Models\QuizzesQuestion; @endphp
@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Topics Questions Report</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Topics Questions Report</div>
        </div>
    </div>


    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="/admin/reports/topics_questions" id="topics_questions_report_search_form" method="get" class="row mb-0">

				
					<div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="fsdate" class="text-center form-control" name="from"
                                       value="{{ get_filter_request('from', 'topics_questions_report_search') }}" placeholder="Start Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="lsdate" class="text-center form-control" name="to"
                                       value="{{ get_filter_request('to', 'topics_questions_report_search') }}" placeholder="End Date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{trans('admin/main.category')}}</label>
                            <select name="category_id" data-plugin-selectTwo class="form-control populate ajax-category-courses" data-course_id="{{get_filter_request('subject_id', 'topics_questions_report_search')}}">
                                <option value="">{{trans('admin/main.all_categories')}}</option>
                                @foreach($categories as $category)
                                @if(!empty($category->subCategories) and count($category->subCategories))
                                <optgroup label="{{  $category->title }}">
                                    @foreach($category->subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @if(get_filter_request('category_id', 'topics_questions_report_search') == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                    @endforeach
                                </optgroup>
                                @else
                                <option value="{{ $category->id }}" @if(get_filter_request('category_id', 'topics_questions_report_search') == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
					
					
					
					

					<div class="col-md-3">
					<div class="form-group">
						<label>Subjects</label>
						<select data-return_type="option"
								data-default_id="{{request()->get('subject_id')}}" data-chapter_id="{{get_filter_request('chapter_id', 'topics_questions_report_search')}}"
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
						<select data-sub_chapter_id="{{get_filter_request('sub_chapter_id', 'topics_questions_report_search')}}" id="chapter_id"
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
								@if(!empty($authors_list) and $authors_list->count() > 0)
									@foreach($authors_list as $userObj)
										@php $checked = (get_filter_request('user_id', 'topics_questions_report_search') == $userObj->id)? 'selected' : ''; @endphp
										<option value="{{ $userObj->id }}" {{$checked}}>{{ $userObj->get_full_name() }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>


                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}</button>
						
                    </div>
					<div class="col-12 col-md-12">
						<button type="button" class="btn btn-primary pin-search" data-search_type="topics_questions_report_search" data-form_id="topics_questions_report_search_form"><i class="fas fa-save"></i> Pin Search</button>
						<button type="button" class="btn btn-danger unpin-search" data-search_type="topics_questions_report_search" data-form_id="topics_questions_report_search_form"><i class="fas fa-save"></i> Unpin Search</button>
					</div>
                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
								<tr>
								</tr>
								<tr>
                                    <th class="text-left" colspan="3">&nbsp;</th>
									<th class="text-center bg-whitesmoke" colspan="{{count($questions_types)}}">Question Types</th>
									<th class="text-center bg-whitesmoke" colspan="{{count($difficulty_levels)}}">Difficulty Levels</th>
									<th class="text-center bg-whitesmoke" colspan="{{$authors_list->count()}}">Authors</th>
                                    <th class="text-left" colspan="5">&nbsp;</th>
								</tr>
                                <tr>
                                    <th class="text-left">Topic</th>
                                    <th class="text-left">Sub Topic</th>
									<th class="text-left">Topic Parts</th>
									<th class="text-left">Total Questions</th>
									@if( !empty( $questions_types ) )
										@foreach( $questions_types as $questions_type_slug => $questions_type_title)
												<th class="text-left">{{$questions_type_title}}</th>
										@endforeach
									@endif
									@if( !empty( $difficulty_levels ) )
										@foreach( $difficulty_levels as $difficulty_level_title)
												<th class="text-left">{{$difficulty_level_title}}</th>
										@endforeach
									@endif
									@if( !empty( $authors_list ) )
										
										@foreach ($authors_list as $authorObj)
											@php if( !isset( $authorObj->id)){continue;} @endphp
											<th class="text-left">{{$authorObj->get_full_name()}}</th>
										@endforeach
									@endif
									<th class="text-left">Hidden Questions</th>
									<th class="text-left">Developer Review</th>
									<th class="text-left">Teacher Review</th>
									<th class="text-left">With Media</th>
									<th class="text-left">Without Media</th>
                                </tr>
								
								@if( $report_data->count() > 0)
									@foreach( $report_data as $reportObj)
										<tr>
											<td class="text-left">{{getChapterTitle($reportObj->chapter_id)}}</td>
											<td class="text-left">{{getSubChapterTitle($reportObj->sub_chapter_id)}} - {{$reportObj->sub_chapter_id}}</td>
											<td class="text-left">{{isset( $sub_topic_parts[$reportObj->sub_chapter_id]['topics_parts_count'] )? $sub_topic_parts[$reportObj->sub_chapter_id]['topics_parts_count'] : 0}}</td>
											<td class="text-left">{{$reportObj->total_questions_count}}</td>
											@if( !empty( $questions_types ) )
												@foreach( $questions_types as $questions_type_slug => $questions_type_title)
													<td class="text-left">{{ $reportObj->{$questions_type_slug . '_count'} }}</td>
												@endforeach
											@endif
											@if( !empty( $difficulty_levels ) )
												@foreach( $difficulty_levels as $difficulty_level_title)
													<td class="text-left">{{ $reportObj->{$difficulty_level_title . '_count'} }}</td>
												@endforeach
											@endif
											@if( !empty( $authors_list ) )
												
												@foreach ($authors_list as $authorObj)
													@php if( !isset( $authorObj->id)){continue;} $author_name = $authorObj->get_full_name(); $author_name = str_replace(' ', '', $author_name); @endphp
													<td class="text-left">{{ $reportObj->{$author_name . '_count'} }}</td>
												@endforeach
											
											@endif
											<td class="text-left">{{$reportObj->hide_question_count}}</td>
											<td class="text-left">{{$reportObj->developer_review_required_count}}</td>
											<td class="text-left">{{$reportObj->review_required_count}}</td>
											<td class="text-left">{{$reportObj->with_media_count}}</td>
											<td class="text-left">{{$reportObj->without_media_count}}</td>
										</tr>
									@endforeach
									
								@else

								<tr>
									<td class="text-center" colspan="10">No Records Found</td>
								</tr>
									
								@endif

                                

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts_bottom')


<script type="text/javascript">

    $(document).ready(function () {
		
		
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
		
    });
	
	
</script>

@endpush
