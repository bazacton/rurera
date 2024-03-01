@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Sections</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Sections </div>
        </div>
    </div>


    <div class="section-body">


        <div class="row">
            <div class="col-12 col-md-12">
                <ul class="col-10 col-md-10 col-lg-10 admin-rurera-tabs nav nav-pills" id="assignment_tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="topics-tab" href="/admin/classes">
                            <span class="tab-title">Classes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="topics-tab" href="/admin/sections" >
                            <span class="tab-title">Sections</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="topics-tab" href="/admin/sections/joining-requests" >
                            <span class="tab-title">Joining Requests</span>
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
                                    <th class="text-left">No of Students</th>
                                    <th>Class Code</th>
                                </tr>

                                @foreach($sections as $sectionData)
                                <tr>
                                    <td>
                                        <span>{{ $sectionData->title }} {{ isset( $sectionData->sectionClass->title )? '('.$sectionData->sectionClass->title.')' : '' }}</span>
                                    </td>
                                    <td class="text-left">{{ $sectionData->category->getTitleAttribute() }}</td>
                                    <td class="text-left"><a href="/admin/sections/users?section={{$sectionData->id}}">{{ $sectionData->users->count() }}</a></td>
                                    <td>
                                        {{ $sectionData->class_code }}
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $sections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush
