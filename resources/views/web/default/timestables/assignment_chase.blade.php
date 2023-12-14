<section class="page-section py-60 challenge-sec" style="background-color: #333;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="challenge-box-holder">
                    <div class="section-title mb-50">
                        <a href="#" itemprop="button" class="back-btn mb-30" style="margin-right: auto;">
                            <span>←</span>
                        </a>
                        <h2 itemprop="title" class="font-50 font-weight-bold mb-0 text-white">Assignments</h2>
                    </div>
                    <div class="challenge-box-outer">
                        <div class="challenge-box">
                            <div class="challenge-controls nav" id="myTab" role="tablist">
                                <ul class="nav" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Assignments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link past-assignments" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Past Assignments</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <table class="simple-table text-left">
                                        <thead>
                                        <tr>
                                            <th>Task</th>
                                            <th>Due</th>
                                            <th>Questions</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if( !empty( $user_active_assignments ) && $user_active_assignments->count() > 0 )
                                            @foreach( $user_active_assignments as $assignmentObj)
                                                <tr>
                                                    <td>
                                                        <strong>{{$assignmentObj->assignments->title}}</strong>
                                                    </td>
                                                    <td>
                                                        {{ dateTimeFormat($assignmentObj->timestables_events->expired_at, 'd/m/Y') }} <br/>
                                                        <span class="time">{{ dateTimeFormat($assignmentObj->timestables_events->expired_at, 'h:s') }}</span>
                                                    </td>
                                                    <td>{{$assignmentObj->assignments->no_of_questions}}</td>
                                                    <td>
                                                        <span class="icon-img">
                                                            <span class="img-box">
                                                                <img src="" alt="">
                                                            </span>
                                                        </span>
                                                        <p>
                                                            <span class="item-name">Egg</span>
                                                            <em>0 / 200</em>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <a href="/timestables/assignment/{{$assignmentObj->id}}" class="play-btn">Play</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="4">No Records Found</td>
                                        </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <table class="simple-table text-left">
                                        <thead>
                                        <tr>
                                            <th>Task</th>
                                            <th>Attempted</th>
                                            <th>Questions</th>
                                            <th>Coin Earn</th>
                                        </tr>
                                        </thead>
                                        <tbody class="past-assignments-list">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts_bottom')
<script src="/assets/default/vendors/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">

    $(document).on('click', '.past-assignments', function (e) {
        var thisObj = $(this);
        var ajax_type = 'past_assignments';
        rurera_loader($(".show-section-data"), 'div');
        jQuery.ajax({
           type: "GET",
           url: '/timestables/'+ajax_type,
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           data: {'ajax_type':ajax_type},
           success: function (return_data) {
               jQuery(".past-assignments-list").html(return_data);
               rurera_remove_loader($(".show-section-data"), 'button');
               console.log(return_data);
           }
       });
    });
</script>
