@extends('admin.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
@endpush

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Author Permissions</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Author Permissions</div>
        </div>
    </div>


    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="input-label">{{trans('admin/main.category')}}</label>
                                        <select name="category_id" data-plugin-selectTwo class="form-control populate ajax-category-courses">
                                            <option value="">{{trans('admin/main.all_categories')}}</option>
                                            @foreach($categories as $category)
                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                            <optgroup label="{{  $category->title }}">
                                                @foreach($category->subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}" @if(request()->get('category_id') == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                                @endforeach
                                            </optgroup>
                                            @else
                                            <option value="{{ $category->id }}" @if(request()->get('category_id') == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="input-label">Course</label>
                                        <select name="course_id" data-plugin-selectTwo class="form-control populate ajax-courses-dropdown-permissions">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="lms-chapter-ul">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="authors-permissions-extra"></div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>

<script type="text/javascript">
$(document).on('click', '.add-author-permissions', function () {
    var sub_chapter_id = $(this).attr('data-sub_chapter_id');
    var chapter_id = $(this).attr('data-chapter_id');

    $.ajax({
        type: "POST",
        url: '/admin/author_permissions/get_sub_chapter_authors',
        data: {'sub_chapter_id': sub_chapter_id, 'chapter_id': chapter_id},
        success: function (return_data) {
            $(".authors-permissions-extra").html(return_data);
            $('.authors_select').select2();
            $("#author-permissions-modal").modal({backdrop: "static"});
        }
    });
});

$(document).on('click', '.author_permissions_submit_btn', function () {
    var formData = new FormData($(this).closest('.author-permissions-modal').find('form')[0]);

    $.ajax({
        type: "POST",
        url: '/admin/author_permissions/sub_chapter_authors_update',
        data: formData,
        processData: false,
        contentType: false,
        success: function (return_data) {
            if (return_data.code == 200) {
                var sub_chapter_id = return_data.sub_chapter_id;
                var sub_chapter_authors_response = return_data.sub_chapter_authors_response;
                $(".authors-list-" + sub_chapter_id).html(sub_chapter_authors_response);
                $("#author-permissions-modal").modal('hide');
                $(".ajax-courses-dropdown-permissions").change();
                Swal.fire({
                    html: '<h3 class="font-20 text-center text-dark-blue">Updated Successfully</h3>',
                    showConfirmButton: false,
                    icon: 'success',
                });
            }
        }
    });
});

$(document).on('change', '.ajax-courses-dropdown-permissions', function () {
    var course_id = $(this).val();
    $.ajax({
        type: "POST",
        url: '/admin/author_permissions/get_sub_chapters_list',
        data: {'course_id': course_id},
        success: function (return_data) {
            $(".lms-chapter-ul").html(return_data.response_html);
        }
    });
});


</script>
@endpush
