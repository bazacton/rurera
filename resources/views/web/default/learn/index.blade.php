@extends('web.default.panel.layouts.panel_layout')
@php use App\Models\Webinar; @endphp

@push('styles_top')

@endpush

@section('content')
<section class="content-section">
    <div class="categories-element-title rurera-hide">
        <h2 class="font-22"><span>{{$categoryObj->category->getTitleAttribute()}} - {{$categoryObj->getTitleAttribute()}}</span></h2>
        <p>{{$categoryObj->category->getTitleAttribute()}} courses - Comprehensive list of courses for Children Aged 5, 6 and 7.</p>
    </div>

    <div class="categories-boxes row">
        <div class="col-12">
            <div class="subjects-heading">
                <h2 class="font-22">Subjects - {{$categoryObj->getTitleAttribute()}}</h2>
            </div>
        </div>

        <div class="col-12">
        @if( !empty( $courses_list ) )
           @foreach( $courses_list as $courseObj)
                @php $subject_percentage = Webinar::getSubjectPercentage($courseObj); @endphp
                    <div class="categories-card medium">
                        <div class="categories-icon" style="background:{{$courseObj->background_color}}">
                            @if($courseObj->icon_code != '')
                                   {!! $courseObj->icon_code !!}
                           @else
                               <img src="{!! $courseObj->thumbnail !!}">
                           @endif
                        </div>
                        <div class="categories-text">
                            <h4 class="categories-title font-19 font-weight-bold"><a href="/{{$categoryObj->slug}}/{{$courseObj->slug}}">{{$courseObj->getTitleAttribute()}}</a></h4>
                            @if( isset( $subject_percentage['percentage'] ) && $subject_percentage['percentage'] > 0)
                                <div class="levels-progress horizontal">
                                    <span class="progress-numbers">{{$subject_percentage['skills_attempted']}}/{{$subject_percentage['total_skils']}} Lessons</span>
                                    <span class="progress-box">
                                        <span class="progress-count" style="width: {{$subject_percentage['percentage']}}%;"></span>
                                    </span>
                                </div>
                            @else
                                <a href="/{{$categoryObj->slug}}/{{$courseObj->slug}}" class="learning-btn">Start Learning</a>
                            @endif
                            <span class="subject-info">{{$courseObj->chapters->count()}} Units and {{$courseObj->webinar_sub_chapters->count()}} Lessons</span>
                        </div>
                    </div>
           @endforeach
       @endif
        </div>
    </div>

</section>


<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Leave Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to leave this page?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Stay</button>
        <button type="button" class="btn btn-primary" id="leaveButton">Leave</button>
      </div>
    </div>
  </div>
</div>



@endsection

@push('scripts_bottom')
@if (!auth()->subscription('courses'))
    <script>
        if( $(".subscription-modal").length > 0){
            $(".subscription-modal").modal('show');
        }
    </script>
@endif

@endpush
