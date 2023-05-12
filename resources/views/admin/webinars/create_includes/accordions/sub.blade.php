@php
$sub_chapter_id  = isset( $sub_chapter_id )? $sub_chapter_id : 0;
$chapter  = isset( $chapter )? $chapter : '';
@endphp

<li data-id="{{ !empty($chapterItem) ? $chapterItem->id :'' }}" class="sub-chapter-parent accordion-row bg-white rounded-sm border border-gray300 mt-20 py-15 py-lg-30 px-10 px-lg-20">
    <div class="d-flex align-items-center justify-content-between " role="tab" id="quiz_{{ !empty($subChapterInfo) ? $subChapterInfo->id :'record' }}">
        <div class="d-flex align-items-center" href="#collapseQuiz{{ !empty($subChapterInfo) ? $subChapterInfo->id :'record' }}" aria-controls="collapseQuiz{{ !empty($subChapterInfo) ? $subChapterInfo->id :'record' }}" data-parent="#{{ !empty($chapter) ? 'chapterContentAccordion'.$chapter->id : 'quizzesAccordion' }}" role="button" data-toggle="collapse" aria-expanded="true">
            <span class="chapter-icon chapter-content-icon mr-10">
                <i data-feather="bookmark" class=""></i>
            </span>

            <span class="font-weight-bold text-dark-blue d-block cursor-pointer">
                {{ !empty($subChapterInfo) ? $subChapterInfo->sub_chapter_title : trans('public.add_new_quizzes') }}
            </span>
        </div>

        <div class="d-flex align-items-center">

            @if(!empty($subChapterInfo) and $subChapterInfo->status != \App\Models\WebinarChapter::$chapterActive)
            <span class="disabled-content-badge mr-10">{{ trans('public.disabled') }}</span>
            @endif

            @if(!empty($subChapterInfo) and !empty($chapterItem))
            <button type="button" data-item-id="{{ $subChapterInfo->id }}" data-item-type="{{ \App\Models\WebinarChapterItem::$chapterQuiz }}" data-chapter-id="{{ !empty($chapter) ? $chapter->id : '' }}" class="js-change-content-chapter btn btn-sm btn-transparent text-gray mr-10">
                <i data-feather="grid" class="" height="20"></i>
            </button>
            @endif

            @if(!empty($chapter))
            <i data-feather="move" class="move-icon mr-10 cursor-pointer" height="20"></i>
            @endif

            @if(!empty($subChapterInfo))
            @php

            $sub_chapter_items  = get_subchapter_items($subChapterInfo->id);
            $delete_action = ($sub_chapter_items > 0)? 'nopermit-del' : 'delete-action';

            @endphp

            <a href="/admin/webinars/{{ $subChapterInfo->id }}/delete_sub_chapter" data-total="{{$sub_chapter_items}}" class="{{$delete_action}} 22 btn btn-sm btn-transparent text-gray">
                <i data-feather="trash-2" class="mr-10 cursor-pointer" height="20"></i>
            </a>
            @endif

            <i class="collapse-chevron-icon" data-feather="chevron-down" height="20" href="#collapseQuiz{{ !empty($subChapterInfo) ? $subChapterInfo->id :'record' }}" aria-controls="collapseQuiz{{ !empty($subChapterInfo) ? $subChapterInfo->id :'record' }}" data-parent="#chapterContentAccordion{{ !empty($chapter) ? $chapter->id :'' }}" role="button" data-toggle="collapse" aria-expanded="true"></i>
        </div>
    </div>




    <div id="collapseQuiz{{ !empty($subChapterInfo) ? $subChapterInfo->id :'record' }}" aria-labelledby="quiz_{{ !empty($subChapterInfo) ? $subChapterInfo->id :'record' }}" class=" collapse @if(empty($subChapterInfo)) show @endif" role="tabpanel">
        <div class="panel-collapse text-gray">
            @include('admin.quizzes.create_sub_chapter_form',
            [
            'inWebinarPage' => true,
            'selectedWebinar' => $webinar,
            'subChapter' => $subChapterInfo ?? null,
            'quizQuestions' => !empty($subChapterInfo) ? $subChapterInfo->quizQuestions : [],
            'chapters' => $webinar->chapters,
            'webinarChapterPages' => !empty($webinarChapterPages),
            'creator' => $webinar->creator
            ]
            )
        </div>
    </div>



</li>



@if($sub_chapter_id > 0 && isset( $sub_chapter_lessions[$sub_chapter_id] ) && !empty( $sub_chapter_lessions[$sub_chapter_id] ))
@foreach($sub_chapter_lessions[$sub_chapter_id] as $chapterItem)
@include('admin.webinars.create_includes.accordions.text-lesson' ,['textLesson' => $chapterItem , 'chapter' => $chapter, 'chapterItem' => $chapterItem])
@endforeach
@endif
@if($sub_chapter_id > 0 && isset( $sub_chapter_questions[$sub_chapter_id] ) && !empty( $sub_chapter_questions[$sub_chapter_id] ))
@foreach($sub_chapter_questions[$sub_chapter_id] as $chapterItem)
@include('admin.webinars.create_includes.accordions.quiz' ,['quizInfo' => $chapterItem , 'chapter' => $chapter, 'chapterItem' => $chapterItem])
@endforeach
@endif