@php use App\Models\QuizzesQuestion; @endphp
@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Topics Parts</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Topics Parts</div>
        </div>
    </div>


    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="/admin/topics_parts" id="topic_parts_search_form" method="get" class="row mb-0">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label">{{trans('admin/main.category')}}</label>
                            <select name="category_id" data-plugin-selectTwo class="form-control populate ajax-category-courses" data-course_id="{{get_filter_request('subject_id', 'topics_search')}}">
                                <option value="">{{trans('admin/main.all_categories')}}</option>
                                @foreach($categories as $category)
                                @if(!empty($category->subCategories) and count($category->subCategories))
                                <optgroup label="{{  $category->title }}">
                                    @foreach($category->subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @if(get_filter_request('category_id', 'topics_search') == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                    @endforeach
                                </optgroup>
                                @else
                                <option value="{{ $category->id }}" @if(get_filter_request('category_id', 'topics_search') == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
					
					
					
					

					<div class="col-md-4">
					<div class="form-group">
						<label>Subjects</label>
						<select data-return_type="option"
								data-default_id="{{request()->get('subject_id')}}" data-chapter_id="{{get_filter_request('chapter_id', 'topics_search')}}"
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
					
					
					<div class="col-md-4">
					<div class="form-group">
						<label class="input-label">Topic</label>
						<select data-sub_chapter_id="{{get_filter_request('sub_chapter_id', 'topics_search')}}" id="chapter_id"
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
					
					
					<div class="col-md-4">
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
					
					<div class="col-md-4">
						<div class="form-group">	
							<label class="input-label">Author</label>
							<select name="user_id" data-search-option="display_name" class="form-control "
									data-placeholder="Search author">

									<option value="">Select Author</option>
								@if(!empty($users_list) and $users_list->count() > 0)
									@foreach($users_list as $userObj)
										@php $checked = (get_filter_request('user_id', 'topics_search') == $userObj->id)? 'selected' : ''; @endphp
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
						<button type="button" class="btn btn-primary pin-search" data-search_type="topics_search" data-form_id="topic_parts_search_form"><i class="fas fa-save"></i> Pin Search</button>
						<button type="button" class="btn btn-danger unpin-search" data-search_type="topics_search" data-form_id="topic_parts_search_form"><i class="fas fa-save"></i> Unpin Search</button>
					</div>
                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    @can('admin_topic_parts_create')
                    <div class="card-header">
                        <div class="text-right">
                            <a href="/admin/topics_parts/create" class="btn btn-primary">New Topic Part</a>
                        </div>
                    </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">Title</th>
                                    <th class="text-left">No of Questions</th>
                                    <th class="text-left">Category</th>
                                    <th class="text-left">Added by</th>
                                    <th class="text-left">Added Date</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($TopicParts as $TopicPartsData)
								
								@php $topic_part_data = isset( $TopicPartsData->topic_part_data )? json_decode($TopicPartsData->topic_part_data) :array();
									$unique_ids = $sumClauses = array();
									$unique_ids_counts = [];
										$total_counts = 0;
									if( !empty($topic_part_data)){
										foreach( $topic_part_data as $unique_id => $part_data){
												$unique_ids[] = $unique_id;
											$alias = "`{$unique_id}_count`";
											$sumClauses[] = "SUM(JSON_CONTAINS(topics_parts, '\"$unique_id\"')) AS $alias";
										}
									}
									if( !empty( $sumClauses ) ){
										$sumQuery = implode(', ', $sumClauses);
										
										$query = QuizzesQuestion::selectRaw($sumQuery)
										->where('hide_question', 0)
										->first();
										foreach ($unique_ids as $id) {
											$total_counts += $query->{$id . '_count'};
											$unique_ids_counts[$id] = $query->{$id . '_count'};
										}
									}
									@endphp
                                <tr>
                                    <td>
                                        <span>{{ $TopicPartsData->title }}</span>
                                    </td>
									<td class="text-left">{{ $total_counts }}</td>
                                    <td class="text-left">{{ (isset($TopicPartsData->category->id))? $TopicPartsData->category->getTitleAttribute() : '-' }}
									<br>
										<small>
										{{ (isset($TopicPartsData->subject->id))? $TopicPartsData->subject->getTitleAttribute() : '-' }} / 
										{{ (isset($TopicPartsData->chapter->id))? $TopicPartsData->chapter->getTitleAttribute() : '-' }} / 
										{{ (isset($TopicPartsData->subChapter->id))? $TopicPartsData->subChapter->sub_chapter_title : '-' }}
										</small>
									</td>
                                    <td class="text-left">{{ $TopicPartsData->user->get_full_name() }}</td>
                                    <td class="text-left">{{ dateTimeFormat($TopicPartsData->created_at, 'j M y | H:i') }}</td>
                                    <td>
                                        @can('admin_topic_parts_edit')
                                        <a href="/admin/topics_parts/{{ $TopicPartsData->id }}/edit" class="btn-transparent btn-sm text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('admin_topic_parts_delete')
											@if( $total_counts == 0)
												@include('admin.includes.delete_button',['url' => '/admin/topics_parts/'.$TopicPartsData->id.'/delete' , 'btnClass' => 'btn-sm'])
											@endif
                                        @endcan
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $TopicParts->links() }}
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
