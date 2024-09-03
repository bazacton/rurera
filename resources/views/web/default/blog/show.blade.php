@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="cart-banner position-relative">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-12 col-md-9 col-lg-7">

                    <h1 class="font-30 font-weight-bold">{{ $post->title }}</h1>

                    <div class="d-flex flex-column lms-blog-header flex-sm-row align-items-center align-sm-items-start">
                        @if(!empty($post->author))
                        <span class="mt-10 mt-md-20 font-16 font-weight-500">
                            <span class="lms-blog-author-img"><img src="{{ $post->author->getAvatar(100) }}" class="img-cover" alt=""></span>
                            {{ trans('public.created_by') }}
                                @if($post->author->isTeacher())
                                    <a href="{{ $post->author->getProfileUrl() }}" target="_blank" >{{ $post->author->get_full_name() }}</a>
                                @elseif(!empty($post->author->get_full_name()))
                                    <span>{{ $post->author->get_full_name() }}</span>
                                @endif
                                
                        </span>
                        @endif

                        <span class="mt-10 mt-md-20 font-16 font-weight-500">{{ trans('public.in') }}
                            <a href="{{ $post->category->getUrl() }}">{{ $post->category->title }}</a>
                        </span>
                        <span class="mt-10 mt-md-20 font-16 font-weight-500">{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="container mt-10 mt-md-40 lms-blog">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="post-show pb-70">

                    {!! nl2br($post->content) !!}
                </div>

                {{-- post Comments --}}
                @if($post->enable_comment)
                    @include('web.default.includes.comments',[
                            'comments' => $post->comments,
                            'inputName' => 'blog_id',
                            'inputValue' => $post->id
                        ])
                @endif
                {{-- ./ post Comments --}}

            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script>
        var webinarDemoLang = '{{ trans('webinars.webinar_demo') }}';
        var replyLang = '{{ trans('panel.reply') }}';
        var closeLang = '{{ trans('public.close') }}';
        var saveLang = '{{ trans('public.save') }}';
        var reportLang = '{{ trans('panel.report') }}';
        var reportSuccessLang = '{{ trans('panel.report_success') }}';
        var messageToReviewerLang = '{{ trans('public.message_to_reviewer') }}';
    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
@endpush
