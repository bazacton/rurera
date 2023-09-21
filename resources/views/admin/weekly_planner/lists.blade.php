@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>National Curriculum</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">National Curriculum</div>
        </div>
    </div>


    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="/admin/national_curriculum" method="get" class="row mb-0">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">Year</label>
                            <select name="key_stage" data-plugin-selectTwo
                                    class="category-id-field form-control populate ajax-category-courses">
                                <option value="">{{trans('admin/main.all_categories')}}</option>
                                @foreach($categories as $category)
                                @if(!empty($category->subCategories) and count($category->subCategories))
                                <optgroup label="{{  $category->title }}">
                                    @foreach($category->subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @if(request()->get('key_stage') ==
                                        $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}
                                    </option>
                                    @endforeach
                                </optgroup>
                                @else
                                <option value="{{ $category->id }}" @if(request()->get('key_stage') == $category->id)
                                    selected="selected" @endif>{{ $category->title }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="category_subjects_list">

                        </div>
                    </div>



                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>


        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="text-right">
                            <a href="/admin/national_curriculum/create" class="btn btn-primary">New Curriculum</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">ID</th>
                                    <th class="text-left">Year</th>
                                    <th class="text-left">Subject</th>
                                    <th class="text-left">Added Date</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($weeklyPlanners as $weeklyPlanner)
                                <tr>
                                    <td>
                                        <span>{{ $weeklyPlanner->id }}</span>
                                    </td>
                                    <td class="text-left">{{
                                        $weeklyPlanner->WeeklyPlannerKeyStage->getTitleAttribute() }}
                                    </td>
                                    <td class="text-left">{{
                                        $weeklyPlanner->WeeklyPlannerKeySubject->getTitleAttribute() }}
                                    </td>
                                    <td class="text-left">{{ dateTimeFormat($weeklyPlanner->created_at, 'j M y
                                        | H:i') }}
                                    </td>
                                    <td>
                                        <a href="/admin/weekly_planner/{{ $weeklyPlanner->id }}/edit"
                                           class="btn-transparent btn-sm text-primary" data-toggle="tooltip"
                                           data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        @include('admin.includes.delete_button',['url' =>
                                        '/admin/national_curriculum/'.$weeklyPlanner->id.'/delete' , 'btnClass'
                                        => 'btn-sm'])
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $weeklyPlanners->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
<script type="text/javascript">
    $('body').on('change', '.category-id-field', function (e) {
        var category_id = $(this).val();
        var subject_id = $(this).attr('data-subject_id');
        $.ajax({
            type: "GET",
            url: '/admin/national_curriculum/subjects_by_category',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'category_id': category_id, 'subject_id': subject_id},
            success: function (response) {
                $(".category_subjects_list").html(response);
            }
        });

    });
</script>
@endpush
