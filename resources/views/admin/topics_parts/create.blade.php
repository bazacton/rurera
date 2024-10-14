@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($TopicParts) ?trans('/admin/main.edit'): trans('admin/main.new') }} Topic Parts</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active"><a href="/admin/topics_parts">Topic Parts</a>
                </div>
                <div class="breadcrumb-item">{{!empty($TopicParts) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="/admin/topics_parts/{{ !empty($TopicParts) ? $TopicParts->id.'/store' : 'store' }}"
                                  method="Post">
                                {{ csrf_field() }}

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
											class="form-control populate ajax-chapter-dropdown"
											name="chapter_id">
										<option value="">Please select year, subject</option>
									</select>

								</div>
								
								<div class="form-group">
									<label class="input-label">Sub Topic</label>
									<select id="chapter_id"
										class="form-control populate ajax-subchapter-dropdown"
										name="sub_chapter_id">
									<option value="">Please select year, subject, Topic</option>
								</select>

								</div>


                                <div class="form-group">
                                    <label>Paragraph</label>
                                    <textarea class="form-control" rows="10" name="paragraph" id="inputText" placeholder="Enter the paragraph here...">{{isset( $TopicParts->paragraph ) ? $TopicParts->paragraph : 0}}</textarea>
                                </div>
								
								<button id="splitTextBtn" type="button">Split Text into Parts</button>
								<button id="addMoreBtn" type="button">Add More</button>

								<table id="outputTable">
									<thead>
										<tr>
											<th>Unique ID</th>
											<th>Text Part</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="sortableTableBody">
										@php $topic_part_data = isset( $TopicParts->topic_part_data )? json_decode($TopicParts->topic_part_data) :array(); @endphp
										@if( !empty( $topic_part_data ))
											@foreach( $topic_part_data as $unique_id => $part_data)
												<tr>
													<td>{{$unique_id}}</td>
													<td><textarea name="topic_part[{{$unique_id}}]">{{$part_data}}</textarea></td>
													<td><button class="remove-btn" onclick="removeRow(this)">Remove</button></td>
												</tr>
											@endforeach
										@endif
										
									</tbody>
								</table>

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
	
	
<script>
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

    // Initialize sortable functionality on the table body
    new Sortable(document.getElementById('sortableTableBody'), {
        animation: 150,
        handle: 'td', // Make the table row (td) the handle for sorting
        ghostClass: 'sortable-ghost'
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
