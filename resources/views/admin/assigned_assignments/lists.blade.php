@extends('admin.layouts.app')

@push('libraries_top')

@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>Assignments</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Assigned Assignments</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Assigned Assignments</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalAssignedAssignments }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="{{ getAdminPanelUrl() }}/quizzes" method="get" class="row mb-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.search') }}</label>
                            <input type="text" class="form-control" name="title" value="{{ request()->get('title') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="fsdate" class="text-center form-control" name="from"
                                       value="{{ request()->get('from') }}" placeholder="Start Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="lsdate" class="text-center form-control" name="to"
                                       value="{{ request()->get('to') }}" placeholder="End Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.filters') }}</label>
                            <select name="sort" data-plugin-selectTwo class="form-control populate">
                                <option value="">{{ trans('admin/main.filter_type') }}</option>
                                <option value="have_certificate" @if(request()->get('sort') == 'have_certificate')
                                    selected @endif>{{ trans('admin/main.quizzes_have_certificate') }}
                                </option>
                                <option value="students_count_asc" @if(request()->get('sort') == 'students_count_asc')
                                    selected @endif>{{ trans('admin/main.students_ascending') }}
                                </option>
                                <option value="students_count_desc" @if(request()->get('sort') == 'students_count_desc')
                                    selected @endif>{{ trans('admin/main.students_descending') }}
                                </option>
                                <option value="passed_count_asc" @if(request()->get('sort') == 'passed_count_asc')
                                    selected @endif>{{ trans('admin/main.passed_students_ascending') }}
                                </option>
                                <option value="passed_count_desc" @if(request()->get('sort') == 'passed_count_desc')
                                    selected @endif>{{ trans('admin/main.passes_students_descending') }}
                                </option>
                                <option value="grade_avg_asc" @if(request()->get('sort') == 'grade_avg_asc') selected
                                    @endif>{{ trans('admin/main.grades_average_ascending') }}
                                </option>
                                <option value="grade_avg_desc" @if(request()->get('sort') == 'grade_avg_desc') selected
                                    @endif>{{ trans('admin/main.grades_average_descending') }}
                                </option>
                                <option value="created_at_asc" @if(request()->get('sort') == 'created_at_asc') selected
                                    @endif>{{ trans('admin/main.create_date_ascending') }}
                                </option>
                                <option value="created_at_desc" @if(request()->get('sort') == 'created_at_desc')
                                    selected @endif>{{ trans('admin/main.create_date_descending') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.instructor') }}</label>
                            <select name="teacher_ids[]" multiple="multiple" data-search-option="just_teacher_role"
                                    class="form-control search-user-select2"
                                    data-placeholder="Search teachers">

                                @if(!empty($teachers) and $teachers->count() > 0)
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" selected>{{ $teacher->full_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.class') }}</label>
                            <select name="webinar_ids[]" multiple="multiple" class="form-control search-webinar-select2"
                                    data-placeholder="Search classes">

                                @if(!empty($webinars) and $webinars->count() > 0)
                                @foreach($webinars as $webinar)
                                <option value="{{ $webinar->id }}" selected>{{ $webinar->title }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.status') }}</label>
                            <select name="statue" data-plugin-selectTwo class="form-control populate">
                                <option value="">{{ trans('admin/main.all_status') }}</option>
                                <option value="active" @if(request()->get('status') == 'active') selected @endif>{{
                                    trans('admin/main.active') }}
                                </option>
                                <option value="inactive" @if(request()->get('status') == 'inactive') selected @endif>{{
                                    trans('admin/main.inactive') }}
                                </option>
                            </select>
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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">{{ trans('admin/main.title') }}</th>
                                    <th class="text-left">Students</th>
                                    <th class="text-center">Created at</th>
                                    <th class="text-center">Deadline</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($assignedAssignments as $assignedAssignmentObj)
                                <tr>
                                    <td>
                                        <span>{{ $assignedAssignmentObj->assignment->title }}</span>
                                    </td>

                                    <td class="text-left">{{ count(json_decode($assignedAssignmentObj->user_ids)) }}</td>

                                    <td class="text-center">
                                        {{ dateTimeFormat($assignedAssignmentObj->created_at,'F d Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ dateTimeFormat($assignedAssignmentObj->assignment_deadline,'F d Y') }}
                                    </td>
                                    <td>
                                        @can('admin_assignments_edits')
                                        <a href="{{ getAdminPanelUrl() }}/assignments/{{ $assignedAssignmentObj->id }}/edit"
                                           class="btn-transparent btn-sm text-primary" data-toggle="tooltip"
                                           data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('admin_assignments_delete')
                                        @include('admin.includes.delete_button',['url' =>
                                        getAdminPanelUrl().'/quizzes/'.$assignedAssignmentObj->id.'/delete' , 'btnClass' => 'btn-sm'])
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $assignedAssignments->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush
