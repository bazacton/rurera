@extends('admin.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/admin/css/book-editor.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
<link rel="stylesheet" href="/assets/admin/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.css">
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">

<style type="text/css">

:root {
  --bg-color: #fff;
  --line-color-1: #366;
  --line-color-2: #a9a9a9;
}

*, *::before, *::after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

	.field_settings .ui-rotatable-handle, .field_settings .ui-resizable-handle, .field_settings .remove{
		display:none !important;
	}
	
	.field_settings.active {
		opacity: 0.8;
	}
	
	.field_settings.active .ui-rotatable-handle, .field_settings.active .ui-resizable-handle, .field_settings.active .remove{
		display:block !important;
	}
	.editor-objects-list li.active{
		background: #cbcbcb;
	}

    .no-border {
        border: none;
    }
	.ui-rotatable-handle {
            width: 20px;
            height: 20px;
            position: absolute;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            cursor: pointer;
        }
        .ui-rotatable-handle::before {
            content: '\f111'; /* Font Awesome rotate icon */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .ui-rotatable-handle.ui-rotatable-handle-nw {
            top: -10px;
            left: -10px;
        }
        .ui-rotatable-handle.ui-rotatable-handle-se {
            bottom: -10px;
            right: -10px;
        }
	
	.field-data svg{height:auto; width: 100%;}
	
	
	/* .editor-controls {
		position: absolute;
		top: 0;
		right: -300px;
		width: 300px;
	} */
    .editor-objects {
        background-color: #e9e9e9;
        padding: 15px;
    }
	ul.editor-objects li {
		display: inline-block;
        vertical-align: top;
        padding: 5px 5px;
        width: 32%;
	}
	a.control-tool-item {
		padding: 10px;
        border: 1px solid #ccc;
        display: block;
        text-align: center;
        border-radius: 3px;
        background-color: #f5f5f5;
	}
	a.control-tool-item.active {
		background: #fff;
	}
    .control-tool-item img {
        height: 35px;
        object-fit: contain;
        width: 35px !important;
    }
	/* .editor-objects-block {
		position: absolute;
		top: 0;
		right: -500px;
		width: 170px;
	} */
	.editor-objects-list li {
		padding: 5px 10px;
		background: #efefef;
		margin: 0 0 3px 0;
	}
    .editor-controls-holder {
        position: absolute;
        right: 0;
        top: 0;
        min-width: 340px;
        max-width: 340px;
        height: calc(100% - 30px);
        background-color: #f2f2f2;
        padding: 30px 30px;
        border-radius: 5px;
    }
    .editor-parent-nav {
        margin: 0 0 25px;
    }
    .editor-parent-nav .nav-link {
        padding: 8px 30px;
        border: 0;
        background-color: #c3c3c3;
        font-size: 16px;
        font-weight: 600;
        outline: none;
        border-radius: 3px;
        color: #666;
        text-shadow: 0 1px 1px #fff;
    }
    .editor-parent-nav .nav-link.active {
        background-color: var(--primary);
        color: #fff;
        text-shadow: none;
    }
    .editor-parent-nav ul {
        gap: 8px 15px;
    }
    .editor-controls-holder .fade:not(.show) {
        visibility: hidden;
        height: 0;
    }
    .editor-controls .nav .nav-item .nav-link {
        padding: 0 10px;
        font-weight: 600;
        color: #afafaf;
        opacity: 1;
    }
    .editor-controls .nav .nav-item .nav-link.active {
        background-color: inherit;
        box-shadow: none;
        color: var(--primary);
    }
    .editor-zone:has(.editor-controls-holder) {
        padding: 0 369px 0 369px;
        overflow: hidden;
        width: 100% !important;
    }
    /* .editor-zone:has(.field-options.hide) {
        padding-left: 0;
    } */
    .editor-objects-list li i {
        display: inline-flex;
        float: right;
        padding: 6px 10px 6px;
        color: #000;
        font-size: 15px;
        cursor: pointer;
    }
	
	
	.graph-background {
		background-color: var(--bg-color);
		background-image: linear-gradient(var(--line-color-1) 1.5px, transparent 1.5px), linear-gradient(90deg, var(--line-color-1) 1.5px, transparent 1.5px), linear-gradient(var(--line-color-2) 1px, transparent 1px), linear-gradient(90deg, var(--line-color-2) 1px, transparent 1px) !important;
		background-position: -1.5px -1.5px, -1.5px -1.5px, -1px -1px, -1px -1px !important;
		background-size: 100px 100px, 100px 100px, 20px 20px, 20px 20px !important;
	}

</style>
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($book) ? $book->book_title: trans('admin/main.new') }} Book</h1>
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

                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="basic-settings" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pages-settings" data-toggle="tab" href="#pages" role="tab" aria-controls="pages" aria-selected="true">Pages</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="editor-settings" data-toggle="tab" href="#editor" role="tab" aria-controls="editor" aria-selected="true">Editor</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane mt-3 fade active show" id="basic" role="tabpanel" aria-labelledby="basic-settings">

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
                                                <label>Book Slug</label>
                                                <input type="text" name="book_slug"
                                                       class="form-control  @error('book_slug') is-invalid @enderror"
                                                       value="{{ !empty($book) ? $book->book_slug : old('book_slug') }}"
                                                       placeholder="{{ trans('admin/main.choose_title') }}"/>

                                                @error('book_slug')
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
                                                    <option value="{{$book_category_value}}" {{ (!empty($book) and $book->book_category == $book_category_value) ? 'selected' : '' }}>{{$book_category_label}}</option>
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
                                                @php $book_interest_area = explode(',', $book->interest_area); @endphp
                                                <select name="interest_area[]" class="form-control select2" data-placeholder="Select Interest Area" multiple="multiple">
                                                    <option value="">Select Interest Area</option>
                                                    @foreach($interest_area as $interest_area_value => $interest_area_label)
                                                    <option value="{{$interest_area_value}}" {{ (!empty($book) and in_array($interest_area_value, $book_interest_area)) ?
                                                    'selected' : ''
                                                    }}>{{$interest_area_label}}
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
										
							<div class="col-6 col-md-6 col-lg-6">
								
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="book_type" class="form-control book_type_selection" data-placeholder="Select Type">
											@php $selected = (isset( $book->book_type ) && ($book->book_type == 'Book' || $book->book_type == ''))? 'selected' : ''; @endphp
                                            <option value="Book" {{$selected}}>Book</option>
											@php $selected = (isset( $book->book_type ) && $book->book_type == 'PDF')? 'selected' : ''; @endphp
											<option value="PDF" {{$selected}}>PDF</option>
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

                                            <div class="form-group mt-15 ">
                                                <label class="input-label d-block">Final Quiz</label>
                                                <select id="questions_ids" data-search-option="questions_ids" class="form-control book-search-questions-select2" data-placeholder="Search
                                                Question"></select>
                                            </div>


                                            <div class="questions-list">
                                                <ul>
                                                    @if( !empty( $book->bookFinalQuiz))
                                                    @foreach( $book->bookFinalQuiz as $questionObj)
                                                    @if( !empty( $questionObj->QuestionData))
                                                    @foreach( $questionObj->QuestionData as $questionDataObj)
                                                    <li data-id="{{$questionDataObj->id}}">{{$questionDataObj->getTitleAttribute()}} <input type="hidden" name="question_list_ids[]"
                                                                                                                                            value="{{$questionDataObj->id}}">
                                                        <a href="javascript:;" class="parent-remove"><span class="fas fa-trash"></span></a>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                    @endforeach
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="text-right mt-4">
                                        <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                    </div>


                                </div>
								
								<div class="tab-pane mt-3 fade" id="pages" role="tabpanel" aria-labelledby="pages-settings">

                                    <div class="row">
										


                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="pages-list">
                                                <ul>
                                                    @foreach( $book->bookPages as $bookPage)
                                                    @php $infoLinkArray = array(); @endphp

                                                    @if(!empty($bookPage->PageInfoLinks))
                                                    @foreach( $bookPage->PageInfoLinks as $pageInfoLink)
                                                    @php
                                                    if( !in_array( $pageInfoLink->info_type, array('text','highlighter'))){
                                                    $infoLinkArray[$pageInfoLink->info_type] = $pageInfoLink->info_type;
                                                    }
                                                    @endphp
                                                    @endforeach
                                                    @endif

                                                    <li data-id="{{$bookPage->id}}">
                                                        <img src="/{{$bookPage->page_path}}" height="200" width="auto">
                                                        <input type="text" name="book_pages_titles[]" value="{{$bookPage->page_title}}">
                                                        <input type="hidden" name="book_pages[]" value="{{$bookPage->id}}">
                                                        <a href="javascript:;" class="parent-remove"><span class="fas fa-trash"></span></a>
                                                        @if( !empty( $infoLinkArray ))
                                                        @foreach( $infoLinkArray as $infoLinkData)
                                                        <img src="/assets/default/img/book-icons/{{$infoLinkData}}.png">
                                                        @endforeach
                                                        @endif

                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="text-right mt-4">
                                        <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                    </div>


                                </div>

								
                                <div class="tab-pane mt-3 fade" id="editor" role="tabpanel" aria-labelledby="editor-settings">
								
									<div class="book-pages-navs">
										<a href="javascript:;" class="next-page">
											<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
												<path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/>
											</svg>
										</a>
										
										<a href="javascript:;" class="prev-page">
											<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
												<path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/>
											</svg>
										</a>
										<div class="generate"><a class="btn btn-primary" href="javascript:;">Save Page</a></div>
									</div>
								
                                    <div class="editor-zone book-editor-zone" style="position:relative;width: fit-content;">
										<div class="field-options"></div>
                                        @if( !empty($book->bookPages ) )
                                        @php $i = 1; @endphp
                                        @foreach( $book->bookPages as $bookPage)
                                        <div class="book-dropzone page_settings {{ ($i > 1)? 'hide' : 'active'}}" data-trigger_class="page-settings-fields"
                                             style="background:url('/{{$bookPage->page_path}}');"
                                             data-page_id="{{$bookPage->id}}" data-page_background="/{{$bookPage->page_path}}">
                                            <img src="/{{$bookPage->page_path}}" style="visibility: hidden;" />
											
											
											@php
											if($i == 1){
												$bookPageObj = $bookPage;
											}
											
												if( !empty( $bookPage->pageObjects->where('status', 'active') )){
													foreach( $bookPage->pageObjects->where('status', 'active') as $bookPageItemObj){
														
														$item_type = isset( $bookPageItemObj->item_type ) ?  $bookPageItemObj->item_type : '';
														$item_path_folder = '';
														$item_path_folder = ($item_type == 'infolink' )? 'infolinks' : $item_path_folder;
														$item_path_folder = ($item_type == 'stage_objects' )? 'objects' : $item_path_folder;
														$item_path_folder = ($item_type == 'misc' )? 'misc' : $item_path_folder;
														$item_path_folder = ($item_type == 'topic' )? 'topics' : $item_path_folder;
														
														$data_attributes_array = isset( $bookPageItemObj->data_values )? json_decode($bookPageItemObj->data_values ) : array();
														
														$data_attributes = '';
														
														if( !empty( $data_attributes_array ) ){
															foreach( $data_attributes_array as $data_attribute_key => $data_attribute_value){
																$data_attributes .= 'data-'.$data_attribute_key.'="'.$data_attribute_value.'" ';
															}
														}

														
														
														$item_path = isset( $bookPageItemObj->item_path ) ?  $bookPageItemObj->item_path : '';
														$item_path = 'assets/books-editor/'.$item_path_folder.'/'.$item_path;
														$svgCode = getFileContent($item_path);
														echo '<div style="'.$bookPageItemObj->field_style.'" data-is_new="no" data-item_title="'.$bookPageItemObj->item_title.'" data-unique_id="'.$bookPageItemObj->id.'" class="saved-item-class drop-item form-group draggablecl field_settings draggable_field_rand_'.$bookPageItemObj->id.'" data-id="rand_'.$bookPageItemObj->id.'" data-item_path="'.$bookPageItemObj->item_path.'" data-field_type="'.$bookPageItemObj->item_type.'" data-trigger_class="infobox-'.$bookPageItemObj->item_slug.'-fields" data-item_type="'.$bookPageItemObj->item_slug.'" data-paragraph_value="Test text here..." '.$data_attributes.'><div class="field-data">'.$svgCode.'</div><a href="javascript:;" class="remove"><span class="fas fa-trash"></span></a></div>';
														
													}
												}
											
											@endphp


                                        </div>
                                        @php $i++; @endphp
                                        @endforeach
                                        @include('admin.books.includes.editor_controls', ['bookPage' => $bookPageObj, 'subChapters' => $subChapters, 'chapters_response' => $chapters_response, 'data_id' => $book->id])

                                        <br>
                                        <br>
										
										
										
                                        
                                        @endif
                                    </div>
                                </div>
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
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
 <script src="https://www.jqueryscript.net/demo/CSS3-Rotatable-jQuery-UI/jquery.ui.rotatable.js"></script>
<script src="/assets/default/js/admin/filters.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script src="/assets/admin/js/book-editor.js?ver={{$rand_id}}"></script>
<script src="/assets/admin/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
<script>


$(document).ready(function () {
		
		$(".editor-objects-list").sortable();
		//$('.saved-item-class').click();
		
		$(".editor-objects-list").sortable({
			update: function(event, ui) {
				sorting_render(); // Call your function here
			}
		});
		
        $('body').on('click', '.delete-parent-li', function (e) {
            $(this).closest('li').remove();
        });
    });

$('body').on('change', '.book_type_selection', function (e) {
	var book_type = $(this).val();
	$(".pdf-fields").addClass('rurera-hide');
	if(book_type == 'PDF'){
		$(".pdf-fields").removeClass('rurera-hide');
	}
});
$(".book_type_selection").change();
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
<script type="text/javascript">
    $(document).ready(function () {
        handleMultiSelect2('book-search-questions-select2', '/admin/questions_bank/search', ['class', 'course', 'subject', 'title']);

        $(document).on('change', '.quiz-type', function (e) {
            var quiz_type = $(this).val();
            $(".conditional-fields").addClass('hide-class');
            $('.' + quiz_type + "-fields").removeClass('hide-class');
        });

        $(document).on('change', '.book-search-questions-select2', function (e) {
            var field_value = $(this).val();
            var field_label = $(this).text();
            $(".questions-list ul").append('<li data-id="' + field_value + '">' + field_label + '  <input type="hidden" name="question_list_ids[]" ' +
                'value="' + field_value + '"><a href="javascript:;"' +
                ' ' +
                'class="parent-remove"><span class="fas ' +
                'fa-trash"></span></a></li>');
            $(".questions-list ul").sortable();
            $(this).html('');
        });

        $(".questions-list ul").sortable();


    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".pages-list ul").sortable();


    });
</script>
@endpush
