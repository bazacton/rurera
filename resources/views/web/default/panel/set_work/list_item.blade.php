<div class="list-group-item">
    <div class="row align-items-center">
        <div class="col-auto col-lg-2 pr-15">
            <h6 class="listing-title font-16 font-weight-500">Title</h6>
            <h6 class="font-16 font-weight-normal"><a href="#"><img class="quiz-type-icon mr-5" src="/assets/default/img/assignment-logo/{{$assignmentObj->assignment_type}}.png">
                    {{$assignmentObj->title}}</a></h6>
        </div>
        <div class="col-auto">
            <h6 class="listing-title font-16 font-weight-500">Student</h6>
            <h6 class="font-16 font-weight-normal">
                @if( $assignmentObj->students->count() > 0)
                @foreach($assignmentObj->students as $studentObj)
                <span class="font-16">{{$studentObj->user->get_full_name()}}</span>
                @endforeach
                @endif
            </h6>
        </div>
        <div class="col-auto">
            <h6 class="listing-title font-16 font-weight-500">Type</h6>
            <h6 class="font-16 font-weight-normal">
                <span class="font-16">{{ get_topic_type($assignmentObj->assignment_type) }}</span>
            </h6>
        </div>
        <div class="col-auto last-activity activity-date">
            <h6 class="listing-title font-16 font-weight-500">Due Date</h6>
            <span class="font-16 d-block">{{ dateTimeFormat($assignmentObj->assignment_end_date, 'j M Y') }}</span>
        </div>
        <div class="col-auto last-activity activity-date">
            <h6 class="listing-title font-16 font-weight-500">Completion Date</h6>
            <span class="font-16 d-block">-</span>
        </div>
        <div class="col-auto ms-auto last-activity action-activity">
            <h6 class="listing-title font-16 font-weight-500">Action</h6>
            <a href="/panel/set-work/{{$assignmentObj->id}}/progress" class="detail-btn">Details</a>
            @php $completed_count = $assignmentObj->students->where('status', 'completed')->count(); @endphp
            @if( $completed_count == 0 && $assignmentObj->status == 'active')
            <a href="javascript:;" data-confirm-type="link" data-confirm-action="/panel/set-work/{{$assignmentObj->id}}/remove" class="remove-btn confirm-delete"><img src="/assets/default/svgs/delete-menu.svg"></a>
            @endif

        </div>
    </div> <!--[ row end ]-->
</div>