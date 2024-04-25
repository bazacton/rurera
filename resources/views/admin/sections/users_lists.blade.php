@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Students</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Students

            </div>
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
                </ul>
                <div class="card">

                    <div class="section-code text-right p-10">
                        <a href="javascript:;" class="print-users-logins" data-type_class="sections-users">Print Login Cards</a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">
                                        <label><input type="checkbox" class="form-control select-all" data-type_class="sections-users" name="select_all" value="1"></label>
                                        Student</th>
                                    <th class="text-left">Coins</th>
                                    <th class="text-left">Last Activity</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($users as $userObj)
                                @php $last_login = ($userObj->last_login > 0)? dateTimeFormat($userObj->last_login, 'j M y | H:i') : '-'; @endphp
                                <tr>
                                    <td>
                                        <span><label><input type="checkbox" class="form-control sections-users" value="{{ $userObj->id }}"></label>{{ $userObj->get_full_name() }}</span>
                                    </td>
                                    <td class="text-left">{{ $userObj->getRewardPoints() }}</td>
                                    <td class="text-left">{{ ($userObj->getLastActivity() > 0)? dateTimeFormat($userObj->getLastActivity(), 'j M y | H:i') : $last_login }}</td>
                                    <td>
                                        @can('admin_classes_edit')
                                        <a href="/admin/classes/{{ $userObj->id }}/edit" class="btn-transparent btn-sm text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('admin_classes_delete')
                                        @include('admin.includes.delete_button',['url' => '/admin/classes/'.$userObj->id.'/delete' , 'btnClass' => 'btn-sm'])
                                        @endcan
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')
<script>
    $('body').on('change', '.select-all', function (e) {
        var type_class = $(this).attr('data-type_class');
        var is_checked = $(this).prop('checked');
        if( is_checked == true){
            $("."+type_class).prop('checked', true);
        }else{
            $("."+type_class).prop('checked', false);
        }
    });
    $('body').on('click', '.print-users-logins', function (e) {
        var type_class = $(this).attr('data-type_class');
        var student_ids = [];
        $('input.' + type_class + ':checked').each(function() {
            student_ids.push($(this).val());
        });
        var url = '/admin/students/print_details?users='+student_ids;
        window.open(url, '_blank');

    });



</script>
@endpush
