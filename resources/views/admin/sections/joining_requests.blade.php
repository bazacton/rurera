@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Joining Requests</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Joining Requests </div>
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
                        <a class="nav-link " id="topics-tab" href="/admin/sections" >
                            <span class="tab-title">Sections</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="topics-tab" href="/admin/sections/joining-requests" >
                            <span class="tab-title">Joining Requests</span>
                        </a>
                    </li>
                </ul>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">Student</th>
                                    <th class="text-left">Class</th>
                                    <th class="text-left">Section</th>
                                    <th>Action</th>
                                </tr>

                                @foreach($joining_requests as $requestObj)
                                <tr>
                                    <td>
                                        <span>{{ $requestObj->student->get_full_name() }}</span>
                                    </td>
                                    <td class="text-left">{{ isset( $requestObj->section->sectionClass->title)? $requestObj->section->sectionClass->title : '' }}</td>
                                    <td class="text-left">{{ $requestObj->section->title }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn-transparent btn-sm text-primary request-action" data-action_type="approved" data-request_id="{{$requestObj->id}}">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <a href="javascript:;" class="btn-transparent btn-sm text-primary request-action" data-action_type="cancelled" data-request_id="{{$requestObj->id}}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $joining_requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

<script>
    $(document).on('click', '.request-action', function (e) {
        rurera_loader($("#userSettingForm"), 'div');
        var action_type = $(this).attr('data-action_type');
        var request_id = $(this).attr('data-request_id');
        jQuery.ajax({
           type: "POST",
           url: '/admin/sections/join-request-action',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {'action_type':action_type,'request_id':request_id},
           success: function (return_data) {
               window.location.href = '/admin/sections/joining-requests';
           }
       });

    });
</script>
@endpush
