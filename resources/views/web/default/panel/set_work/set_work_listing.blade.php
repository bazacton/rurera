

<section class="dashboard">

    <div class="db-form-tabs">
        <div class="db-members">
            <div class="row g-3 list-unstyled">
                <div class="col-12">
                    <div class="card pt-0">
                        <div class="card-body">

                            <ul class="rurera-tabs-frontend set-work-ajax d-flex flex-wrap align-items-center pb-60">
                                <li class="active font-weight-500 pb-10" data-type="active">Inprogress</li>
                                <li class="font-weight-500 pb-10" data-type="completed">Completed</li>
                                <li class="font-weight-500 pb-10" data-type="expired">Overdue</li>
                            </ul>	

                            <div class="list-group list-group-custom set-work-content list-group-flush totalChilds"
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




