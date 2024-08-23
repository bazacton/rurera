@extends('admin.layouts.app')
@php $rand_id = rand(0,9999); @endphp
@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/admin/css/draw-editor.css?ver={{$rand_id}}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">

<style type="text/css">
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
	
	.field-data svg{height:auto;}
	
	
	.editor-controls {
		position: absolute;
		top: 0;
		right: -300px;
		width: 300px;
	}
	ul.editor-objects {
		float: left;
	}

	ul.editor-objects li {
		float: left;
		margin: 10px;
		border: 1px solid #efefef;
	}
	a.control-tool-item {
		padding: 12px;
	}
	a.control-tool-item.active {
		background: #bbb5b5;
	}
	.editor-objects-block {
		position: absolute;
		top: 0;
		right: -500px;
		width: 170px;
	}
	.editor-objects-list li {
		padding: 5px;
		background: #efefef;
		margin: 0 0 3px 0;
	}
	
	.editor-zone .field-options {
		right: -1000px;
	}
</style>
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($glossary) ?trans('/admin/main.edit'): trans('admin/main.new') }} Learning Journey</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/learning_journey">Learning Journey</a>
            </div>
            <div class="breadcrumb-item">{{!empty($glossary) ?trans('/admin/main.edit'): trans('admin/main.new') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/learning_journey/{{ !empty($LearningJourneyObj) ? $LearningJourneyObj->id.'/store' : 'store' }}" class="learning-journey-form"
                              method="Post">
                            {{ csrf_field() }}
							<input type="hidden" name="posted_data" class="posted-data">

                            <div class="form-group">
                                <label>{{ trans('/admin/main.category') }}</label>
                                <select data-subject_id="{{ !empty($LearningJourneyObj)? $LearningJourneyObj->subject_id : 0}}"
                                        class="form-control category-id-field @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                    <option {{ !empty($trend) ?
                                    '' : 'selected' }} disabled>{{ trans('admin/main.choose_category') }}</option>

                                    @foreach($categories as $category)
                                    @if(!empty($category->subCategories) and count($category->subCategories))
                                    <optgroup label="{{  $category->title }}">
                                        @foreach($category->subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}" @if(!empty($LearningJourneyObj) and
                                                $LearningJourneyObj->
                                            year_id == $subCategory->id) selected="selected" @endif>{{
                                            $subCategory->title }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @else
                                    <option value="{{ $category->id }}" class="font-weight-bold"
                                            @if(!empty($LearningJourneyObj)
                                            and $LearningJourneyObj->year_id == $category->id) selected="selected"
                                        @endif>{{
                                        $category->title }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="category_subjects_list">

                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary add_learning_journey_set" type="button">Add Set</button>
                            </div>

                            <div class="learning_journey_sets">

                                @if( !empty( $LearningJourneyObj->learningJourneyLevels ))
                                @foreach( $LearningJourneyObj->learningJourneyLevels as $itemObj)
							
							
							
							
								<div class="accordion-content-wrapper mt-15" id="chapterAccordion" role="tablist"
								 aria-multiselectable="true">
								<ul class="draggable-content-lists  curriculum-set-ul">

									<li data-id="{{$itemObj->id}}" data-chapter-order=""
										class="accordion-row bg-white rounded-sm mt-20 py-15 py-lg-30 px-10 px-lg-20">
										<div class="d-flex align-items-center justify-content-between " role="tab"
											 id="chapter_{{$itemObj->id}}">
											<div class="d-flex align-items-center collapsed"
												 href="#collapseItems{{$itemObj->id}}"
												 aria-controls="collapseItems{{$itemObj->id}}"
												 data-parent="#chapterAccordion" role="button"
												 data-toggle="collapse" aria-expanded="false">
													<span class="chapter-icon mr-10">
														<svg xmlns="http://www.w3.org/2000/svg"
															 width="24" height="24"
															 viewBox="0 0 24 24"
															 fill="none" stroke="currentColor"
															 stroke-width="2"
															 stroke-linecap="round"
															 stroke-linejoin="round"
															 class="feather feather-grid"><rect
																	x="3"
																	y="3"
																	width="7"
																	height="7"></rect><rect
																	x="14" y="3" width="7"
																	height="7"></rect><rect
																	x="14"
																	y="14"
																	width="7"
																	height="7"></rect><rect
																	x="3" y="14" width="7"
																	height="7"></rect></svg>
													</span>
												<div class="">
													<span class="font-weight-bold text-dark-blue d-block cursor-pointer"><input
																name="learning_journey_level[{{$itemObj->id}}]" type="text" size="50"
																value="{{$itemObj->level_title}}"
																class="no-border"></span>
												</div>
											</div>

											<div class="d-flex align-items-center">

												<button type="button" data-data_id="{{$itemObj->id}}"
														class="add-course-content-btn  add-curriculum-item mr-10"
														aria-expanded="false">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
														 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
														 stroke-linejoin="round" class="feather feather-plus">
														<line x1="12" y1="5" x2="12" y2="19"></line>
														<line x1="5" y1="12" x2="19" y2="12"></line>
													</svg>
												</button>
												
												<button type="button" data-data_id="{{$itemObj->id}}"
														class="add-course-content-btn  add-treasure-item mr-10"
														aria-expanded="false">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
														 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
														 stroke-linejoin="round" class="feather feather-plus">
														<line x1="12" y1="5" x2="12" y2="19"></line>
														<line x1="5" y1="12" x2="19" y2="12"></line>
													</svg> Box
												</button>

												<a href="javascript:;"
												   class="delete-parent-li btn btn-sm btn-transparent text-gray">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
														 viewBox="0 0 24 24" fill="none" stroke="currentColor"
														 stroke-width="2" stroke-linecap="round"
														 stroke-linejoin="round"
														 class="feather feather-trash-2 mr-10 cursor-pointer">
														<polyline points="3 6 5 6 21 6"></polyline>
														<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
														<line x1="10" y1="11" x2="10" y2="17"></line>
														<line x1="14" y1="11" x2="14" y2="17"></line>
													</svg>
												</a>

												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
													 viewBox="0 0 24 24" fill="none" stroke="currentColor"
													 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
													 class="feather feather-move move-icon mr-10 cursor-pointer text-gray ui-sortable-handle">
													<polyline points="5 9 2 12 5 15"></polyline>
													<polyline points="9 5 12 2 15 5"></polyline>
													<polyline points="15 19 12 22 9 19"></polyline>
													<polyline points="19 9 22 12 19 15"></polyline>
													<line x1="2" y1="12" x2="22" y2="12"></line>
													<line x1="12" y1="2" x2="12" y2="22"></line>
												</svg>

												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="20"
													 viewBox="0 0 24 24" fill="none" stroke="currentColor"
													 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
													 class="feather feather-chevron-down collapse-chevron-icon feather-chevron-up text-gray collapsed"
													 href="#collapseItems{{$itemObj->id}}"
													 aria-controls="collapseItems{{$itemObj->id}}"
													 data-parent="#chapterAccordion" role="button"
													 data-toggle="collapse" aria-expanded="false">
													<polyline points="6 9 12 15 18 9"></polyline>
												</svg>
											</div>
										</div>
										
										<div id="collapseItems{{$itemObj->id}}" aria-labelledby="chapter_{{$itemObj->id}}"
											 class="curriculum-item-data collapse " role="tabpanel">
											<div class="panel-collapse text-gray">

												<div class="accordion-content-wrapper mt-15"
													 id="chapterContentAccordion{{$itemObj->id}}" role="tablist"
													 aria-multiselectable="true">
													<ul class="curriculum-item-data-ul draggable-content-lists draggable-lists-chapter-{{$itemObj->id}} ui-sortable"
														data-drag-class="draggable-lists-chapter-{{$itemObj->id}}"
														data-order-table="webinar_chapter_items">

														
														@if( !empty( $itemObj->learningJourneyItems ))
															@foreach( $itemObj->learningJourneyItems as $learningJourneyItemObj)
																@if( $learningJourneyItemObj->item_type == 'topic')
																	{{$thisObj->learning_journey_topic_layout($request, $learningJourneyItemObj->id, $LearningJourneyObj->subject_id, $learningJourneyItemObj->item_value)}}
																@endif
																@if( $learningJourneyItemObj->item_type == 'treasure')
																	{{$thisObj->learning_journey_treasure_layout($request, $learningJourneyItemObj->id, $learningJourneyItemObj->item_value)}}
																@endif
															@endforeach
														@endif

													</ul>
												</div>

											</div>
										</div>
									</li>
								</ul>
							</div>

                                @endforeach
                                @endif


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
 <script src="https://www.jqueryscript.net/demo/CSS3-Rotatable-jQuery-UI/jquery.ui.rotatable.js"></script>
<script src="/assets/default/js/admin/filters.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script src="/assets/admin/js/journey-editor.js?ver={{$rand_id}}"></script>
<script type="text/javascript">
    $(document).ready(function () {

		$(".editor-objects-list").sortable();

        $('body').on('click', '.delete-parent-li', function (e) {

            $(this).closest('li').remove();
        });

        $('body').on('change', '.category-id-field', function (e) {
            var category_id = $(this).val();
            var subject_id = $(this).attr('data-subject_id');
            var learning_journey_id = '{{isset( $LearningJourneyObj->id )? $LearningJourneyObj->id : 0}}';
            $.ajax({
                type: "GET",
                url: '/national-curriculum/subjects_by_category',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'category_id': category_id, 'subject_id': subject_id, 'learning_journey': 'yes', 'learning_journey_id': learning_journey_id},
                success: function (response) {
                    $(".category_subjects_list").html(response);
                }
            });

        });
		
		$("category-id-field").change();
        $('body').on('click', '.add_learning_journey_set', function (e) {
            //$(".learning_journey_sets").html('');
            $.ajax({
                type: "GET",
                url: '/admin/learning_journey/learning_journey_set_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                success: function (response) {
                    $(".learning_journey_sets").append(response);
                    $(".curriculum-set-ul").sortable();
                    $(".curriculum-item-data-ul").sortable();
                    $(".curriculum-chapter-data-ul").sortable();
                    $(".curriculum-topics-ul").sortable();
                    handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);
                }
            });
        });

        $('body').on('click', '.add-curriculum-item', function (e) {
            //$(".learning_journey_sets").html('');
            var thisObj = $(this);
            var data_id = $(this).attr('data-data_id');
			var subject_id = $('.choose-curriculum-subject').val();
            $.ajax({
                type: "GET",
                url: '/admin/learning_journey/learning_journey_topic_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'data_id': data_id, 'subject_id': subject_id},
                success: function (response) {
                    thisObj.closest('li').find('.curriculum-item-data').find('ul.curriculum-item-data-ul').append(response);

                }
            });
        });
		
		
		$('body').on('click', '.add-treasure-item', function (e) {
            //$(".learning_journey_sets").html('');
            var thisObj = $(this);
            var data_id = $(this).attr('data-data_id');
            $.ajax({
                type: "GET",
                url: '/admin/learning_journey/learning_journey_treasure_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'data_id': data_id},
                success: function (response) {
                    thisObj.closest('li').find('.curriculum-item-data').find('ul.curriculum-item-data-ul').append(response);
                }
            });
        });

        $('body').on('click', '.add-curriculum-chapter', function (e) {
            //$(".learning_journey_sets").html('');
            var thisObj = $(this);
            var data_id = $(this).attr('data-data_id');
            var item_id = $(this).attr('data-item_id');
            $.ajax({
                type: "GET",
                url: '/admin/national_curriculum/curriculum_item_chapter_layout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'data_id': data_id, 'item_id': item_id},
                success: function (response) {
                    thisObj.closest('li').find('ul.curriculum-chapter-data-ul').append(response);
                    $(".curriculum-chapter-data-ul").sortable();
                    $(".curriculum-topics-ul").sortable();
                    handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);
                }
            });
        });

        $(".learning_journey_sets").sortable();
        $(".curriculum-item-data-ul").sortable();
        $(".curriculum-chapter-data-ul").sortable();
        $(".curriculum-topics-ul").sortable();
        $(".category-id-field").change();
        handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);

    });
	
	
	$('body').on('submit', '.learning-journey-form', function (e) {
		console.log('submitted_form');
		var posted_data = generate_stage_area();
		$(".posted-data").val(JSON.stringify(posted_data));
		console.log(posted_data);
		//return false;
		
	});
	
	
	 

</script>

@endpush
