@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
	<style type="text/css">.lms-hide{display:none;}</style>
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add Sub Chapters / Quiz</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="/admin/questions_bank/store_sub_chapters_auto"
                                  method="Post">
                                {{ csrf_field() }}

								<div class="form-group">
                                    <label>Subject</label>
                                    <select class="form-control @error('webinar_id') is-invalid @enderror webinar_id" name="webinar_id">
                                        <option {{ !empty($trend) ? '' : 'selected' }} disabled>Select a Subject</option>

                                        @foreach($webinars as $webinar)
										@php $webinar_categories = $webinar->categories();@endphp
                                        <option value="{{ $webinar->id }}" class="font-weight-bold" >{{ $webinar->title }} / @foreach( $webinar_categories as $category){{$category->title}} @endforeach</option>
                                        @endforeach
                                    </select>
                                    @error('webinar_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Section</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror section_id"  name="category_id">
                                        <option {{ !empty($trend) ? '' : 'selected' }} disabled>Select a Section</option>

                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id }}" class="lms-hide webinar_options font-weight-bold webinar_id_{{$lesson->webinar_id}}" >{{ $lesson->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label class="input-label">List Each per line</label>
									<div class="col-12 col-md-12 col-lg-12">
                                    <textarea class="note-codable" style="width:100%;" rows="20" id="quiz_list" name="quiz_list" aria-multiline="true"></textarea>
									</div>
                                </div>
								@if($success == 'yes')
								<div class="text-left mt-4">
                                    Created Successfully
                                </div>
								@endif
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
		$(document).on('change', '.webinar_id', function (e) {
			var webinar_id = $(this).val();
			console.log(webinar_id);
			$(".webinar_options").addClass('lms-hide');
			$(".webinar_id_"+webinar_id).removeClass('lms-hide');
		});
	</script>
@endpush
