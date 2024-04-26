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
<section class="member-card-header pb-50">
    <div class="d-flex align-items-start align-items-md-center justify-content-between flex-md-row">
        <h1 class="section-title font-22">Set Work</h1>
        <div class="dropdown">
        <a class="btn btn-sm btn-primary subscription-modal" href="/panel/set-work/create" data-type="child_register"><img src="/assets/default/svgs/add-con.svg"> Add Work
        </a>
    </div>
    </div>
</section>
<section class="dashboard">

    <div class="db-form-tabs">
        <div class="db-members">
            <div class="row g-3 list-unstyled">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="list-group list-group-custom list-group-flush mb-0 totalChilds"
                                 data-childs="12">
                                @if( !empty( $assignments ) )
                                @foreach($assignments as $assignmentObj)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto col-lg-2 pr-15">
                                            <h6 class="listing-title font-14 font-weight-500">Title</h6>
                                            <h6 class="font-16 font-weight-normal"><a href="#">{{$assignmentObj->title}}</a></h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="listing-title font-14 font-weight-500">Student</h6>
                                            <h6 class="font-16 font-weight-normal">
                                                @if( $assignmentObj->students->count() > 0)
                                                    @foreach($assignmentObj->students as $studentObj)
                                                      <img src="{{$studentObj->user->getAvatar()}}" class="mr-5 rounded-circle"> <span class="font-16">{{$studentObj->user->get_full_name()}}</span>
                                                    @endforeach
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="listing-title font-14 font-weight-500">Type</h6>
                                            <h6 class="font-16 font-weight-normal">
                                                <img class="quiz-type-icon mr-5" src="/assets/default/img/assignment-logo/{{$assignmentObj->assignment_type}}.png">
                                                <span class="font-16">{{ get_topic_type($assignmentObj->assignment_type) }} ({{$assignmentObj->assignment_type}})</span>
                                            </h6>
                                        </div>
                                        <div class="col-auto last-activity activity-date">
                                            <h6 class="listing-title font-14 font-weight-500">Due Date</h6>
                                            <span class="font-16 d-block">{{ dateTimeFormat($assignmentObj->assignment_end_date, 'j M Y') }}</span>
                                        </div>
                                        <div class="col-auto ms-auto last-activity action-activity">
                                            <h6 class="listing-title font-14 font-weight-500">Action</h6>
                                            <a href="/panel/set-work/{{$assignmentObj->id}}/progress" class="detail-btn">Details</a>
                                        </div>
                                    </div> <!--[ row end ]-->
                                </div>

                                @endforeach
                                @endif
                            </div>
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