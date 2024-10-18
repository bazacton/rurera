@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($glossary) ?trans('/admin/main.edit'): trans('admin/main.new') }} Glossary</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active"><a href="/admin/glossary">Glossary</a>
                </div>
                <div class="breadcrumb-item">{{!empty($glossary) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="/admin/glossary/{{ !empty($glossary) ? $glossary->id.'/store' : 'store' }}"
                                  method="Post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>{{ trans('/admin/main.category') }}</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror ajax-category-courses" name="category_id" data-course_id="{{isset( $glossary->subject_id )? $glossary->subject_id : 0}}">
                                        <option {{ !empty($trend) ? '' : 'selected' }} disabled>{{ trans('admin/main.choose_category')  }}</option>

                                        @foreach($categories as $category)
                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                                <optgroup label="{{  $category->title }}">
                                                    @foreach($category->subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @if(!empty($glossary) and $glossary->category_id == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @else
                                                <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($glossary) and $glossary->category_id == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
								
								<div class="form-group">
                                    <label>Subjects</label>
                                    <select data-return_type="option"
                                            data-default_id="{{isset( $glossary->subject_id)? $glossary->subject_id : 0}}" data-chapter_id="{{isset( $glossary->chapter_id )? $glossary->chapter_id : 0}}"
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
								
								<div class="form-group">
									<label class="input-label">Topic</label>
									<select data-sub_chapter_id="{{isset( $glossary->sub_chapter_id ) ? $glossary->sub_chapter_id : 0}}" id="chapter_id"
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
								
								
								
								<div class="form-group">
									<label class="input-label">Type</label>
									<select id="chapter_id"
										class="form-control populate"
										name="glossary_type">
									<option value="Glossary" {{(isset( $glossary->glossary_type) && $glossary->glossary_type == 'Glossary')? 'selected' : '' }}>Glossary</option>
									<option value="Vocabulary" {{(isset( $glossary->glossary_type) && $glossary->glossary_type == 'Vocabulary')? 'selected' : '' }}>Vocabulary</option>
								</select>
								@error('glossary_type')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
								

								</div>


                                <div class="form-group">
                                    <label>Glossary Title</label>
                                    <input type="text" name="title"
                                           class="form-control  @error('title') is-invalid @enderror"
                                           value="{{ !empty($glossary) ? $glossary->title : old('title') }}"
                                           placeholder="{{ trans('admin/main.choose_title') }}"/>

                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="input-label">Description</label>
                                    <textarea class="note-codable summernote" id="description" name="description" aria-multiline="true">{{ !empty($glossary) ? $glossary->description : old('description') }}</textarea>
                                </div>

                                <div class="text-right mt-4">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
    <script src="/assets/default/js/admin/filters.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>

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
