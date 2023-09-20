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

                                @foreach($nationalCurriculum as $nationalCurriculumData)
                                <tr>
                                    <td>
                                        <span>{{ $nationalCurriculumData->id }}</span>
                                    </td>
                                    <td class="text-left">{{ $nationalCurriculumData->NationalCurriculumKeyStage->getTitleAttribute() }}</td>
                                    <td class="text-left">{{ $nationalCurriculumData->NationalCurriculumKeySubject->getTitleAttribute() }}</td>
                                    <td class="text-left">{{ dateTimeFormat($nationalCurriculumData->created_at, 'j M y | H:i') }}</td>
                                    <td>
                                        <a href="/admin/national_curriculum/{{ $nationalCurriculumData->id }}/edit" class="btn-transparent btn-sm text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        @include('admin.includes.delete_button',['url' => '/admin/national_curriculum/'.$nationalCurriculumData->id.'/delete' , 'btnClass' => 'btn-sm'])
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $nationalCurriculum->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush
