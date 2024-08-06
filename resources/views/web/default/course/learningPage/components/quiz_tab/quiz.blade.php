@php
@endphp

<div class="{{ ($item->result_status == 'passed') ? 'quiz-passed' : '' }} tab-item p-10 cursor-pointer {{ $class ?? '' }}"
     data-type="{{ $type }}"
     data-id="{{ $item->id }}">

    <div class="d-flex align-items-center">
        <div class="flex-grow-1">
            <span class="font-weight-500 font-16 text-dark-blue d-block">{{ $item->title }}</span>

            <div class="d-flex align-items-center justify-content-between">
                <span class="font-12 text-gray d-block">
                    @if(!empty($item->time))
                        {{ $item->time .' '. trans('public.min') }}
                    @else
                        {{ trans('update.unlimited_time') }}
                    @endif

                    {{ ($item->quizQuestions ? ' | ' . $item->quizQuestions->count() .' '. trans('public.questions') : '') }}
                </span>

            </div>
        </div>
        @if($item->result_status == 'passed')
            <svg fill="#0bda3f" height="40px" width="40px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-490 -490 1470.00 1470.00" xml:space="preserve" stroke="#0bda3f" stroke-width="16.17"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <polygon points="452.253,28.326 197.831,394.674 29.044,256.875 0,292.469 207.253,461.674 490,54.528 "></polygon> </g></svg>
        @else
            <span class="chapter-icon bg-gray300 mr-10">
                <i data-feather="award" class="text-gray" width="16" height="16"></i>
            </span>
        @endif
         

    </div>
</div>
