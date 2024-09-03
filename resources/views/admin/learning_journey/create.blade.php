@extends('admin.layouts.app')
@php $rand_id = rand(0,9999); @endphp
@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/admin/css/draw-editor.css?ver={{$rand_id}}">
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
									{{$thisObj->learning_journey_set_layout($request, $itemObj->id, false, true, $itemObj)}}
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
<script src="/assets/admin/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">
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
					$(".category_subjects_list select").change();
					
					
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
                    //$(".curriculum-set-ul").sortable();
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

        //$(".learning_journey_sets").sortable();
        //$(".curriculum-item-data-ul").sortable();
        //$(".curriculum-chapter-data-ul").sortable();
        //$(".curriculum-topics-ul").sortable();
        $(".category-id-field").change();
        handleTopicsMultiSelect2('search-topics-select2', '/admin/chapters/search', ['class', 'course', 'subject', 'title']);

    });
	
	
	$('body').on('submit', '.learning-journey-form', function (e) {
		console.log('submitted_form');
		var posted_data = generate_stage_area();
		console.log(posted_data);
		$(".posted-data").val(JSON.stringify(posted_data));
		//return false;
		
	});
	
	
	
	
	
	 

</script>

@endpush
