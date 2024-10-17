@extends(getTemplate() .'.panel.layouts.panel_layout_full')

@push('styles_top')
<style type="text/css">
    .frontend-field-error, .field-holder:has(.frontend-field-error),
    .form-field:has(.frontend-field-error), .input-holder:has(.frontend-field-error) {
        border: 1px solid #dd4343;
    }

    .hide {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="dashboard-students-holder">
<section class="member-card-header pb-20 mb-15">
    <div class="d-flex align-items-center justify-content-between flex-md-row">
        <h2 class="section-title font-36">Set Work</h2>
        <div class="dropdown">
        <a class="btn subscription-modal font-18 p-0" href="/panel/set-work/create" data-type="child_register"><img src="/assets/default/svgs/add-con.svg"> Add Work
        </a>
    </div>
    </div>
</section>
@include('web.default.flash_message')
<section class="dashboard">

    <div class="db-form-tabs">
        <div class="db-members">
            <div class="row g-3 list-unstyled">
                <div class="col-12">
                    <div class="card pt-0">
                        <div class="card-body">

                            <ul class="rurera-tabs-frontend set-work-ajax d-flex flex-wrap align-items-center">
                                <li class="active font-weight-bold font-18 pb-10" data-type="active">Inprogress</li>
                                <li class="font-weight-bold font-18 pb-10" data-type="completed">Completed</li>
                                <li class="font-weight-bold font-18 pb-10" data-type="expired">Overdue</li>
                            </ul>	

                            <div class="list-group list-group-custom set-work-content list-group-flush totalChilds pt-0"
                                 data-childs="12">
                                <div class="rurera-tables-list mb-30">
                                @if( $assignments->count() > 0 )
                                @foreach($assignments as $assignmentObj)
                                    @include('web.default.panel.set_work.list_item',['assignmentObj' => $assignmentObj])
                                @endforeach
                                @else
                                    @php $no_records_data = '<div class="no-record-found-head mb-20">
                                            <ul class="d-flex align-items-center justify-content-between">
                                                <li><h6 class="listing-title font-16 font-weight-500">Title</h6></li>
                                                <li><h6 class="listing-title font-16 font-weight-500">Student</h6></li>
                                                <li><h6 class="listing-title font-16 font-weight-500">Type</h6></li>
                                                <li><h6 class="listing-title font-16 font-weight-500">Action</h6></li>
                                            </ul>
                                    </div>'; @endphp
                                    @include('web.default.default.list_no_record',['no_records_data' => $no_records_data])
                                @endif
                                </div>

                                <div class="rurera-pagination">
                                    {{ $assignments->links() }}
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
</div>




@endsection

@push('scripts_bottom')

<script type="text/javascript">
var searchRequest = null;
$('body').on('click', '.set-work-ajax li', function (e) {
    rurera_loader($(".set-work-content"), 'div');
    $(".set-work-ajax li").removeAttr('class');
    $(this).addClass('active');
    var assignment_status = $(this).attr('data-type');
    searchRequest = jQuery.ajax({
        type: "GET",
        url: '/panel/set-work/search',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            if (searchRequest != null) {
                searchRequest.abort();
            }
        },
        data: {"assignment_status": assignment_status},
        success: function (return_data) {
            rurera_remove_loader($(".set-work-content"), 'div');
            $(".set-work-content").html(return_data);
        }
    });

});
</script>
@endpush