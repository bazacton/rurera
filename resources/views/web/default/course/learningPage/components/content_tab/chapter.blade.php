    @php
        $percent = $course->getProgress(true);
        $progressObj = $course->getQuizzesLearningProgressStat();
    @endphp
    @if(!empty($course->chapters) and count($course->chapters))

        <div class="course-complete">
            <h3>Course Completion</h3>
            <div class="course-bar-holder">
                <span>{{ $percent }}% completed</span>
                <span class="text-right">{{ $progressObj['passed'] }}/{{ $progressObj['count'] }}</span>
                <div class="course-bar">
                    <div class="course-bar-inner"></div>
                </div>
            </div>
        </div>

        <select name="sort" class="form-control font-16 chapter_dropdown">
            @foreach($sub_chapters[$current_webinar] as $chapter_id => $sub_chapter)
                @php
                    $selected = ($current_chapter == $sub_chapter['id'])? 'selected' : '';
                @endphp
                <option value="{{ $sub_chapter['id'] }}" {{$selected}}>{{ $sub_chapter['title'] }}</option>
            @endforeach
        </select>
        <div class="accordion-content-wrapper mt-15" id="chapterAccordion" role="tablist" aria-multiselectable="true">
            @foreach($course->chapters as $chapter)
                <div id="collapseChapter{{ $chapter->id  }}" aria-labelledby="chapter_{{ $chapter->id  }}" class="collapse chapter_items" role="tabpanel">
                        <div class="panel-collapse text-gray">

                            @if(!empty($chapter->chapterItems) and count($chapter->chapterItems))
                                @foreach($chapter->chapterItems as $chapterItem)
                                    @if($chapterItem->type == \App\Models\WebinarChapterItem::$chapterQuiz and !empty($chapterItem->quiz) and $chapterItem->quiz->status == 'active')
                                            <div class="sub_chapter_items sub_chapter_item_id_{{ $quiz_sub_chapter[$chapterItem->quiz->id]  }} hide" role="tabpanel">
                                                @include('web.default.course.learningPage.components.quiz_tab.quiz' ,['item' => $chapterItem->quiz, 'type' => 'quiz'])
                                            </div>
                                    @elseif($chapterItem->type == \App\Models\WebinarChapterItem::$chapterTextLesson and !empty($chapterItem->textLesson) and $chapterItem->textLesson->status == 'active')
                                        <div class="sub_chapter_items sub_chapter_item_id_{{ $chapterItem->textLesson->sub_chapter_id  }} hide" role="tabpanel">
                                            @include('web.default.course.learningPage.components.content_tab.content' , ['item' => $chapterItem->textLesson, 'type' => 'text_lesson'])
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
            @endforeach
        </div>
    @endif
