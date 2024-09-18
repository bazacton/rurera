@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="cart-banner position-relative single-post-subheader pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <a href="/blog" itemprop="url" class="post-back-btn font-18 font-weight-normal">Back to blog</a>
                    
                    <h1 class="font-30 font-weight-bold my-20">{{ $post->title }}</h1>

                    <div class="post-date">
                        <span class="mt-15 d-block font-16">{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-50 mb-50 lms-blog blog-single-post">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9 col-md-9">
                    <div class="post-show pb-70 pr-50">

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

                    <div class="single-post-block">
                        <div class="post-inner">
                            <ul class="numbers-list">
                                <li><span>Why everybody needs a brand</span></li>
                                <li><span>Find yor propostion, personality and purpose</span></li>
                                <li><span>Freelancing tips: How you can usebrand propostion</span></li>
                                <li><span>Useful resources for your Freelancing business</span></li>
                                <li><span>Create a brand with value</span></li>
                            </ul>
                        </div>
                    </div>

                </div>
                @if( !empty( $headings_array ) )
					<div class="col-12 col-lg-3 col-md-3">
						<div class="blog-sidebar">
						   <h2 class="mb-20">Content</h2>
							<div class="single-post-nav mb-30">
								<nav>
									<ul>
										@php $counter = 1; @endphp
										@foreach( $headings_array as $heading_id => $heading_text)
											<li><a href="#{{$heading_id}}" class="{{($counter == 1)? 'current' : ''}}">{{$heading_text}}</a></li>
											@php $counter++; @endphp
										@endforeach
									</ul>
								</nav>
							</div>
                            <div class="share-links">
                                <h2 class="mb-20">Share Article</h2>
                                <ul>
                                    <li><a href="#"><img src="/assets/default/svgs/instagram-blog.svg"  height="150" width="150" alt="instagram"></a></li>
                                    <li><a href="#"><img src="/assets/default/svgs/linkedin-blog.svg"  height="2500" width="2500" alt="linkedin"></a></li>
                                    <li><a href="#"><img src="/assets/default/svgs/tiktok-blog.svg"  height="150" width="150" alt="tiktok"></a></li>
                                </ul>
                            </div>
						</div>
					</div>
				@endif
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
