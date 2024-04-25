@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{$pageTitle}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">{{$pageTitle}}</div>
        </div>
    </div>


    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">Author Name</th>
                                    <th class="text-left">Author Points</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($authors as $authorsObj)
                                <tr>
                                    <td>
                                        <span>{{ $authorsObj->get_full_name() }}</span>
                                    </td>
                                    <td class="text-left">{{ $authorsObj->author_points }}</td>
                                    <td>
                                        <a href="/admin/author_points/{{ $authorsObj->id }}" class="btn-transparent btn-sm text-primary" data-toggle="tooltip" data-placement="top" title="Author Points Breakdown">
                                            <i class="fa fa-list"></i>
                                        </a>
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush
