@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
<link rel="stylesheet" href="/assets/admin/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.css">
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($book) ?trans('/admin/main.edit'): trans('admin/main.new') }} Book</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/glossary">Book</a>
            </div>
            <div class="breadcrumb-item">{{!empty($book) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/books/{{ !empty($book) ? $book->id.'/store' : 'store' }}"
                              method="Post">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Book SEO Title</label>
                                        <input type="text" name="seo_title"
                                               class="form-control  @error('seo_title') is-invalid @enderror"
                                               value="{{ !empty($book) ? $book->seo_title : old('seo_title') }}"
                                               placeholder="SEO Title"/>

                                        @error('seo_title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Book SEO Description</label>
                                        <textarea name="seo_description" class="form-control  @error('seo_description') is-invalid @enderror" placeholder="SEO Description">{{ !empty($book) ? $book->seo_description : old('seo_description') }}</textarea>
                                        @error('seo_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group custom-switches-stacked">
                                       <label class="input-label">{{ trans('admin/main.robot') }}:</label>
                                       <label class="custom-switch pl-0">
                                           <label class="custom-switch-description mb-0 mr-2">{{ trans('admin/main.no_follow') }}</label>
                                           <input type="hidden" name="seo_robot_access" value="0">
                                           <input type="checkbox" name="seo_robot_access" id="seo_robot_access" value="1" {{ (!empty($book) and $book->seo_robot_access) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                           <span class="custom-switch-indicator"></span>
                                           <label class="custom-switch-description mb-0 cursor-pointer" for="seo_robot_access">{{ trans('admin/main.follow') }}</label>
                                       </label>
                                   </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group custom-switches-stacked">
                                       <label class="input-label">Include In XML:</label>
                                       <label class="custom-switch pl-0">
                                           <label class="custom-switch-description mb-0 mr-2">Not Include</label>
                                           <input type="hidden" name="include_xml" value="0">
                                           <input type="checkbox" name="include_xml" id="include_xml" value="1" {{ (!empty($book) and $book->include_xml) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                           <span class="custom-switch-indicator"></span>
                                           <label class="custom-switch-description mb-0 cursor-pointer" for="include_xml">Include</label>
                                       </label>
                                   </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Book Title</label>
                                        <input type="text" name="book_title"
                                               class="form-control  @error('book_title') is-invalid @enderror"
                                               value="{{ !empty($book) ? $book->book_title : old('book_title') }}"
                                               placeholder="{{ trans('admin/main.choose_title') }}"/>

                                        @error('book_title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Written By</label>
                                        <input type="text" name="written_by"
                                               class="form-control  @error('written_by') is-invalid @enderror"
                                               value="{{ !empty($book) ? $book->written_by : old('written_by') }}"
                                               placeholder=""/>

                                        @error('written_by')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Illustrated By</label>
                                        <input type="text" name="illustrated_by"
                                               class="form-control  @error('illustrated_by') is-invalid @enderror"
                                               value="{{ !empty($book) ? $book->illustrated_by : old('illustrated_by') }}"
                                               placeholder=""/>

                                        @error('illustrated_by')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Publication Date</label>

                                        <input type="text" name="publication_date" class="datepicker form-control" value="{{ !empty($book->publication_date) ? dateTimeFormat
                                                                                                                ($book->publication_date, 'Y-n-d') :'' }}"/>

                                        @error('publication_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Words Bank</label>
                                        <input type="text" name="words_bank" data-role="tagsinput"
                                               class="form-control  @error('words_bank') is-invalid @enderror"
                                               value="{{ !empty($book) ? $book->words_bank : old('words_bank') }}"
                                               placeholder=""/>

                                        @error('words_bank')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Reading Color</label>
                                        <div class="input-group colorpickerinput">
                                            <input type="text" name="reading_color" class="form-control"
                                                   value="{{ !empty($book) ? $book->reading_color : '' }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="fas fa-fill-drip"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Book Category</label>
                                        <select name="book_category" class="form-control" data-placeholder="Select Category">
                                            <option value="">Select Category</option>
                                            @foreach($book_categories as $book_category_value => $book_category_label)
                                            <option value="{{$book_category_value}}">{{$book_category_label}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Reading Level</label>
                                        <select name="reading_level" class="form-control" data-placeholder="Select Reading Level">
                                            <option value="">Select Reading Level</option>
                                            @foreach($reading_level as $reading_level_value => $reading_level_label)
                                            <option value="{{$reading_level_value}}" {{ (!empty($book) and $book->reading_level == $reading_level_value) ? 'selected' : ''
                                                }}>{{$reading_level_label}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Age Group</label>
                                        <select name="age_group" class="form-control" data-placeholder="Select Age Group">
                                            <option value="">Select Age Group</option>
                                            @foreach($age_group as $age_group_value => $age_group_label)
                                            <option value="{{$age_group_value}}" {{ (!empty($book) and $book->age_group == $age_group_value) ? 'selected' : '' }}>{{$age_group_label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Interest Area</label>
                                        <select name="interest_area[]" class="form-control select2" data-placeholder="Select Interest Area" multiple="multiple">
                                            <option value="">Select Interest Area</option>
                                            @foreach($interest_area as $interest_area_value => $interest_area_label)
                                            <option value="{{$interest_area_value}}">{{$interest_area_label}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Skill Set</label>
                                        <select name="skill_set" class="form-control" data-placeholder="Select Skill Set">
                                            <option value="">Select Skill Set</option>
                                            @foreach($skill_set as $skill_set_value => $skill_set_label)
                                            <option value="{{$skill_set_value}}" {{ (!empty($book) and $book->skill_set == $skill_set_value) ? 'selected' : ''
                                                }}>{{$skill_set_label}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>No of Pages</label>
                                        <input type="number" name="no_of_pages"
                                               class="form-control  @error('no_of_pages') is-invalid @enderror"
                                               value="{{ !empty($book) ? $book->no_of_pages : old('no_of_pages') }}"
                                               placeholder=""/>

                                        @error('no_of_pages')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Reading Points</label>
                                        <input type="number" name="reading_points"
                                               class="form-control  @error('reading_points') is-invalid @enderror"
                                               value="{{ !empty($book) ? $book->reading_points : old('reading_points') }}"
                                               placeholder=""/>

                                        @error('reading_points')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
								<div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="book_type" class="form-control book_type_selection" data-placeholder="Select Type">
                                            <option value="Book" selected>Book</option>
											<option value="PDF">PDF</option>
                                        </select>
                                    </div>
                                </div>
								<div class="col-12 col-md-12 col-lg-12 pdf-fields rurera-hide">
									<div class="form-group">
										<label>Year</label>
										<select data-default_id="{{isset( $quiz->id)? $quiz->year_id : 0}}"
												class="form-control year-group-select select2 @error('year_id') is-invalid @enderror"
												name="year_id">
											<option {{ !empty($trend) ?
											'' : 'selected' }} disabled>Select Year</option>

											@foreach($categories as $category)
											@if(!empty($category->subCategories) and
											count($category->subCategories))
											<optgroup label="{{  $category->title }}">
												@foreach($category->subCategories as $subCategory)
												<option value="{{ $subCategory->id }}" @if(!empty($quiz) and $quiz->year_id == $subCategory->id) selected="selected" @endif>
													{{$subCategory->title}}
												</option>
												@endforeach
											</optgroup>
											@else
											<option value="{{ $category->id }}"
													class="font-weight-bold">{{
												$category->title }}
											</option>
											@endif
											@endforeach
										</select>
										@error('year_id')
										<div class="invalid-feedback">
											{{ $message }}
										</div>
										@enderror
									</div>
								
									<div class="practice-quiz-ajax-fields populated-data"></div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">Book Cover Image</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="input-group-text admin-file-manager"
                                                        data-input="cover_image" data-preview="holder">
                                                    <i class="fa fa-chevron-up"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="cover_image"
                                                   id="cover_image"
                                                   value="{{ !empty($book) ? $book->cover_image : old('cover_image') }}"
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label class="input-label">Book PDF</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="input-group-text admin-file-manager"
                                                        data-input="book_pdf" data-preview="holder">
                                                    <i class="fa fa-chevron-up"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="book_pdf"
                                                   id="book_pdf"
                                                   value="{{ !empty($book) ? $book->book_pdf : old('book_pdf') }}"
                                                   class="form-control"/>
                                        </div>
                                    </div>
                                </div>
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
<script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="/assets/admin/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
<script>

$('body').on('change', '.book_type_selection', function (e) {
	var book_type = $(this).val();
	$(".pdf-fields").addClass('rurera-hide');
	if(book_type == 'PDF'){
		$(".pdf-fields").removeClass('rurera-hide');
	}
});
$('body').on('change', '.year-group-select', function (e) {
            var year_id = $(this).val();
            var thisObj = $(this);//$(".quiz-ajax-fields");
            
			rurera_loader(thisObj, 'button');
			jQuery.ajax({
				type: "GET",
				url: '/admin/common/get_mock_subjects_by_year',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {"year_id": year_id, "field_name" : "subject_id"},
				success: function (return_data) {
					$(".practice-quiz-ajax-fields").html(return_data);
					rurera_remove_loader(thisObj, 'button');
				}
			});
        });
</script>
@endpush
