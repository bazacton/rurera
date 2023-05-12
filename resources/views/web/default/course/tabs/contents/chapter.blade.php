<div class="row">
    <div class="col-12 lms-chapter-area">
        <div class="sidebar-nav">
            <ul>
             <li><a href="#">Subjects</a></li>
             <li><a href="#">Scince</a></li>
             <li><a href="#">History</a></li>
             <li><a href="#">Geography</a></li>
             <li><a href="#">Maths</a></li>
             <li><a href="#">English</a></li>
             <li><a href="#">Art</a></li>
             <li><a href="#">Language</a></li>
             <li><a href="#">Design and technology</a></li>
             <li><a href="#">PE</a></li>
             <li><a href="#">Music</a></li>
             <li><a href="#">Computing</a></li>
            </ul> 
         </div>
        <div class="accordion-content-wrapper" id="chaptersAccordion" role="tablist" aria-multiselectable="true">


            <div class="mastery-banner-card">
                <div class="mastery-text">
                    <strong>Mastery Chellenge</strong>
                    <p>Strengthen skills you've already practiced in <br /> just 6 questions</p>
                    <a href="#">Get started</a>
                </div>
            </div>

            <ul class="lms-chapter-ul">
                @foreach($course->chapters as $chapter)

                @if((!empty($chapter->chapterItems) and count($chapter->chapterItems)) or (!empty($chapter->quizzes) and count($chapter->quizzes)))
                <li><div class="lms-chapter-title"><strong>{{ $chapter->title }}</strong><span>1400/1400 Mastery Points</span></div>

                    @if(!empty($sub_chapters[$chapter->id]) and count($sub_chapters[$chapter->id]))
                    <ul>
                        @foreach($sub_chapters[$chapter->id] as $sub_chapter)
                        @if(!empty($sub_chapter))
                            <li><a href="/course/learning/{{$course->slug}}?webinar={{$chapter->id}}&chapter={{$sub_chapter['id']}}">{{ $sub_chapter['title'] }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
