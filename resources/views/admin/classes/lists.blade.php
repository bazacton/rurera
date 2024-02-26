@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Classes</h1>
        @can('admin_classes_create')
            <div class="text-left">
                <a href="/admin/classes/create" class="btn btn-primary">New Class</a>
            </div>
        @endcan
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Classes

            </div>
        </div>
    </div>


    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="/admin/classes" method="get" class="row mb-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.search') }}</label>
                            <input type="text" class="form-control" name="title" value="{{ request()->get('title') }}">
                        </div>
                    </div>

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
                            <label class="input-label">{{ trans('admin/main.status') }}</label>
                            <select name="statue" data-plugin-selectTwo class="form-control populate">
                                <option value="">{{ trans('admin/main.all_status') }}</option>
                                <option value="active" @if(request()->get('status') == 'active') selected @endif>{{ trans('admin/main.active') }}</option>
                                <option value="inactive" @if(request()->get('status') == 'inactive') selected @endif>{{ trans('admin/main.inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}</button>
                    </div>
                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-12">
                <ul class="col-10 col-md-10 col-lg-10 admin-rurera-tabs nav nav-pills" id="assignment_tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="topics-tab" href="/admin/classes">
                            <span class="tab-title">Classes</span>
                            <span class="tab-detail">Classes List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="topics-tab" href="/admin/sections" >
                            <span class="tab-title">Sections</span>
                            <span class="tab-detail">Sections List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="topics-tab" href="/admin/sections/joining-requests" >
                            <span class="tab-title">Joining Requests</span>
                            <span class="tab-detail">Pending Joining Requests</span>
                        </a>
                    </li>
                </ul>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">{{ trans('admin/main.title') }}</th>
                                    <th class="text-left">Curriculum</th>
                                    <th class="text-left">Sections</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($classes as $classData)
                                <tr>
                                    <td>
                                        <span>{{ $classData->title }}</span>
                                    </td>
                                    <td class="text-left">{{ $classData->category->getTitleAttribute() }}</td>
                                    <td class="text-left">
                                        @if( !empty( $classData->sections ) )
                                            @foreach($classData->sections as $sectionData)
                                                <a href="/admin/sections/users?section={{$sectionData->id}}">{{$sectionData->title}}</a><br>
                                            @endforeach
                                        @endif

                                    </td>
                                    <td>
                                        @can('admin_classes_edit')
                                        <a href="/admin/classes/{{$classData->id}}/edit" class="btn-transparent btn-sm text-primary edit-class-btn1" data-class_id="{{$classData->id}}" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('admin_classes_delete')
                                        @include('admin.includes.delete_button',['url' => '/admin/classes/'.$classData->id.'/delete' , 'btnClass' => 'btn-sm'])
                                        @endcan
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $classes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="class-edit-modal" class="class-edit-modal modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body class-edit-content">

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')

<script>
    $(document).on('click', '.edit-class-btn', function (e) {
        //rurera_loader($("#userSettingForm"), 'div');
        var class_id = $(this).attr('data-class_id');
        jQuery.ajax({
           type: "GET",
           url: '/admin/classes/edit_modal',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {'class_id':class_id},
           success: function (return_data) {
               $(".class-edit-content").html(return_data);
               $("#class-edit-modal").modal('show');
               console.log(return_data);
           }
       });

    });
</script>


@endpush
