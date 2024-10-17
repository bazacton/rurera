@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($TopicParts) ? $TopicParts->title : trans('admin/main.new').' Topic Parts' }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active"><a href="/admin/topics_parts">Topic Parts</a>
                </div>
                <div class="breadcrumb-item">{{!empty($TopicParts) ? $TopicParts->title : trans('admin/main.new') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="topic-parts-form" action="/admin/topics_parts/{{ !empty($TopicParts) ? $TopicParts->id.'/store' : 'store' }}"
                                  method="Post">
                                {{ csrf_field() }}
								
								
								<div class="row">

								<div class="col-6 col-md-6 col-lg-6">
								
								<div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title"
                                           class="form-control  @error('title') is-invalid @enderror"
                                           value="{{ !empty($TopicParts) ? $TopicParts->title : old('title') }}"
                                           placeholder="{{ trans('admin/main.choose_title') }}"/>

                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
								
								@if(!isset($TopicParts->id) )
                                <div class="form-group">
                                    <label>{{ trans('/admin/main.category')  }}</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror ajax-category-courses" name="category_id" data-course_id="{{isset( $TopicParts->subject_id )? $TopicParts->subject_id : 0}}">
                                        <option {{ !empty($trend) ? '' : 'selected' }} disabled>{{ trans('admin/main.choose_category')  }}</option>

                                        @foreach($categories as $category)
                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                                <optgroup label="{{  $category->title }}">
                                                    @foreach($category->subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @if(!empty($TopicParts) and $TopicParts->category_id == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @else
                                                <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($TopicParts) and $TopicParts->category_id == $category->id) selected="selected" @endif>{{ $category->title }}</option>
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
                                            data-default_id="{{isset( $TopicParts->subject_id)? $TopicParts->subject_id : 0}}" data-chapter_id="{{isset( $TopicParts->chapter_id )? $TopicParts->chapter_id : 0}}"
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
									<select data-sub_chapter_id="{{isset( $TopicParts->sub_chapter_id ) ? $TopicParts->sub_chapter_id : 0}}" id="chapter_id"
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
								@endif
								
								</div>

								<div class="col-6 col-md-6 col-lg-6">

								
								</div>
								</div>

								<div class="text-left">
									<button class="btn btn-primary">Save Title</button>
								</div>
                                <div class="text-right mt-4">
										<a href="javascript:;" class="btn btn-primary add-part-modal">Add New Part</a>
                                    
                                </div>	
								
								
								<div class="table-responsive">
									<table class="table table-striped font-14">
										<tbody>
											<tr>
												<th class="text-left">Unique ID</th>
												<th class="text-left">Text Part</th>
												<th class="text-left">No of Questions</th>
												<th>Actions</th>
											</tr>
											
											
											@php $topic_part_data = isset( $TopicParts->topic_part_data )? json_decode($TopicParts->topic_part_data) :array(); @endphp
											@if( !empty( $topic_part_data ))
												@foreach( $topic_part_data as $unique_id => $part_data)
													@php $part_questions_count = isset( $unique_ids_counts[$unique_id] )? $unique_ids_counts[$unique_id] : 0; @endphp
													<tr data-unique_id="{{$unique_id}}">
														<td><span>{{$unique_id}}</span></td>
														<td class="text-left part_text">{{$part_data}}<input type="hidden" name="topic_part[{{$unique_id}}]" value="{{$part_data}}" ></td>
														<td class="text-left">{{ $part_questions_count}}</td>
														<td>
															@if( $part_questions_count == 0)
															<a href="javascript:;" class="btn-transparent btn-sm text-primary edit-part-modal" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
															<button class="btn-transparent text-primary btn-sm trigger--fire-modal-1 remove-row-tr" type="button"  ><i class="fa fa-times" aria-hidden="true"></i></button>
															@endif
														</td>
													</tr>
												@endforeach
											@endif
											
										</tbody>
									</table>
								</div>


								<div id="edit-part-modal-box" class="modal fade" role="dialog" data-backdrop="static">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-body">
												<div class="form-group">
													<label>Paragraph</label>
													<textarea data-id="0" class="form-control part-paragraph" rows="10" placeholder="Enter the paragraph here..."></textarea>
												</div>
											</div>
											<div class="modal-footer">
												<div class="text-right">
													<button type="button" class="part-edit-submit btn btn-primary">{{ trans('admin/main.submit') }}</button>
												</div>
												<button type="button" class="btn btn-default close-modal-box" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>



								<div id="add-part-modal-box" class="question_edit_part_modal modal fade question_status_action_modal" role="dialog" >
									<div class="modal-fullscreen">
										<div class="modal-content">
											<div class="modal-body">

												<div class="row">

													<div class="col-6 col-md-6 col-lg-6">

														@if(isset($TopicParts->id) )
															<div class="form-group">
																<label>Paragraph</label>
																<textarea class="form-control @error('paragraph') is-invalid @enderror" rows="10" name="paragraph" id="inputText" placeholder="Enter the paragraph here...">{{isset( $TopicParts->paragraph ) ? $TopicParts->paragraph : old('paragraph')}}</textarea>
															</div>

															<button class="btn btn-primary" id="splitTextBtn" type="button">Split Text into Parts</button>
															<button class="btn btn-success" id="addMoreBtn" type="button">Add More</button>
														@endif

													</div>
													<div class="col-6 col-md-6 col-lg-6">
														@if(isset($TopicParts->id) )
															<table id="outputTable">
																<thead>
																<tr>
																	<th>Unique ID</th>
																	<th>Text Part</th>
																	<th>Action</th>
																</tr>
																</thead>
																<tbody id="sortableTableBody">

																</tbody>
															</table>
														@endif
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<div class="text-right">
													<button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
												</div>
												<button type="button" class="btn btn-default close-modal-box" data-dismiss="modal">Close</button>
											</div>
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
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
    <script src="/assets/default/js/admin/filters.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
	
	
<script>

	$("body").on("click", ".add-part-modal", function (t) {
		$("#inputText").val('');
		$("#sortableTableBody").html('');
        $("#add-part-modal-box").modal('show');
    });

	$("body").on("click", ".edit-part-modal", function (t) {
		var part_paragraph = $(this).closest('tr').find('.part_text input').val();
		var unique_id  = $(this).closest('tr').attr('data-unique_id');
		$(".part-paragraph").attr('data-id', unique_id);
		$(".part-paragraph").val(part_paragraph);
		$("#edit-part-modal-box").modal('show');
	});


	$("body").on("click", ".part-edit-submit", function (t) {
		var part_paragraph = $(".part-paragraph").val();
		var unique_id  = $(".part-paragraph").attr('data-id');
		$('input[name="topic_part['+unique_id+']"]').val(part_paragraph);
		$(".topic-parts-form").submit();
	});


	$("body").on("click", ".close-modal-box", function (t) {
		$(this).closest('.modal').modal('hide');
	});




	$("body").on("click", ".remove-row-tr", function (t) {
        $(this).closest('tr').remove();
		$(".topic-parts-form").submit();
    });
	
	
	
	

    // Function to generate a random alphanumeric ID (6 characters: mix of letters and numbers)
    function generateUniqueID() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < 6; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    // Function to add a new row to the table
    function addNewRow(part = '') {
        const uniqueID = generateUniqueID();
        const tableBody = document.getElementById('sortableTableBody');
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>${uniqueID}</td>
            <td><textarea name="topic_part[${uniqueID}]">${part}</textarea></td>
            <td><button class="remove-btn" onclick="removeRow(this)">Remove</button></td>
        `;
        tableBody.appendChild(row);
    }

    // Function to remove a row
    function removeRow(button) {
        const row = button.parentElement.parentElement;
        row.remove();
    }

    // Event listener to split the input text into parts
    document.getElementById('splitTextBtn').addEventListener('click', function() {
        const inputText = document.getElementById('inputText').value;
        
        // Split the text into sentences using basic sentence boundary detection
        const parts = inputText.split(/(?<=[.?!])\s+/);
        
        const outputTableBody = document.getElementById('sortableTableBody');
        outputTableBody.innerHTML = '';  // Clear previous output
        
        // Loop through each part and add it as a new row
        parts.forEach(part => {
            addNewRow(part);
        });
    });

    // Event listener to add more parts dynamically
    document.getElementById('addMoreBtn').addEventListener('click', function() {
        addNewRow(); // Add an empty new row
    });

   
</script>
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
