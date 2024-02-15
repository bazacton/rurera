@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Schools</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Schools</div>
        </div>
    </div>


    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="/admin/schools" method="get" class="row mb-0">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.search') }}</label>
                            <input type="text" class="form-control" name="title" value="{{ request()->get('title') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.status') }}</label>
                            <select name="statue" data-plugin-selectTwo class="form-control populate">
                                <option value="">{{ trans('admin/main.all_status') }}</option>
                                <option value="active" @if(request()->get('status') == 'active') selected @endif>{{ trans('admin/main.active') }}</option>
                                <option value="inactive" @if(request()->get('status') == 'inactive') selected @endif>{{ trans('admin/main.inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}</button>
                    </div>
                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    @can('admin_glossary_create')
                    <div class="card-header">
                        <div class="text-right">
                            <a href="/admin/schools/create" class="btn btn-primary">New School</a>
                        </div>
                    </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">{{ trans('admin/main.title') }}</th>
                                    <th class="text-left">Added by</th>
                                    <th class="text-left">Added Date</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($schools as $schoolData)
                                <tr>
                                    <td>
                                        <span>{{ $schoolData->title }}</span>
                                    </td>
                                    <td class="text-left">{{ $schoolData->user->full_name }}</td>
                                    <td class="text-left">{{ dateTimeFormat($schoolData->created_at, 'j M y | H:i') }}</td>
                                    <td>
                                        @can('admin_glossary_edit')
                                        <a href="/admin/schools/{{ $schoolData->id }}/edit" class="btn-transparent btn-sm text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('admin_glossary_delete')
                                        @include('admin.includes.delete_button',['url' => '/admin/schools/'.$schoolData->id.'/delete' , 'btnClass' => 'btn-sm'])
                                        @endcan
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $schools->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush
