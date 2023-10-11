@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<style>
    .users-list li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .users-list li a.parent-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }
</style>
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new') }} Assign</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/assignments">Assignments</a>
            </div>
            <div class="breadcrumb-item">{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/assigned_assignments/store"
                              method="Post">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-6 col-md-6 col-lg-6">

                                    <div class="form-group">
                                        <label class="input-label">No of Attempts</label>
                                        <input type="number"
                                               name="no_of_attempts"
                                               value="1"
                                               class="js-ajax-no_of_attempts form-control "
                                               placeholder=""/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="input-label">Assignment Deadline</label>
                                        <input type="text"
                                               name="assignment_deadline"
                                               value="{{ !empty($assignment) ? $assignment->title : old('title') }}"
                                               class="js-ajax-deadline singleDatePicker form-control "
                                               placeholder=""/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <input type="hidden" name="assignment_id" value="{{isset( $assignment->id )? $assignment->id : 0}}">
                                    <div class="form-group">
                                        <label>Year</label>
                                        <select data-default_id="{{isset( $user->id)? $user->year_id : 0}}"
                                                class="form-control year_class_ajax_select @error('year_id') is-invalid @enderror"
                                                name="year_id">
                                            <option {{ !empty($trend) ?
                                            '' : 'selected' }} disabled>Select Year</option>

                                            @foreach($categories as $category)
                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                            <optgroup label="{{  $category->title }}">
                                                @foreach($category->subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}" @if(!empty($user) and $user->
                                                    year_id
                                                    ==
                                                    $subCategory->id) selected="selected" @endif>{{ $subCategory->title
                                                    }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                            @else
                                            <option value="{{ $category->id }}" class="font-weight-bold">{{
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

                                    <div class="form-group">
                                        <label>Student Class</label>
                                        <select data-return_type="list"
                                                data-default_id="{{isset( $user->id)? $user->class_id : 0}}"
                                                class="class_users_ajax_select class_section_ajax_select student_section form-control select2 @error('class_id') is-invalid @enderror"
                                                id="class_id" name="class_id">
                                            <option disabled selected>Class</option>
                                        </select>
                                        @error('class_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Class Section</label>
                                        <select data-return_type="list"
                                                data-default_id="{{isset( $user->id)? $user->section_id : 0}}"
                                                class="section_users_ajax_select section_ajax_select student_section form-control select2 @error('section_id') is-invalid @enderror"
                                                id="section_id" name="section_id">
                                            <option disabled selected>Section</option>
                                        </select>
                                        @error('section_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Students</label>
                                        <ul class="users_ajax_select users_list selectable-lis"
                                            data-target_ul="users-list">
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <ul class="users-list">
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-20 mb-20">
                                <button type="submit" class="js-submit-quiz-form btn btn-sm btn-primary">{{
                                    !empty($assignment) ?
                                    trans('public.save_change') : trans('public.create') }}
                                </button>
                            </div>

                        </form>
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
        $('body').on('click', '.year-group-selectsssssss', function (e) {
            var thisObj = $('.populated-content-area');
            var year_id = $(this).attr('data-year_id');
            $(".year_id_field").val(year_id);
            rurera_loader(thisObj, 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/assignments/subjects_by_year',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"year_id": year_id},
                success: function (return_data) {
                    $(".populated-data").addClass('rurera-hide');
                    rurera_remove_loader(thisObj, 'button');
                    if (return_data != '') {
                        $(".populated-content-area").append(return_data);
                        subjects_callback();
                    }
                }
            });
        });
        $(".users-list").sortable();
    });

</script>
@endpush
