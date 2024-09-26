@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/css/blog.min.css">
@endpush

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
                    
                    <div class="row mb-50">
                        <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
                            <div class="rurera-blog blog-medium" itemscope="" itemtype="https://schema.org/NewsArticle">
                                <div class="blog-grid-detail">
                                    <span class="badge created-at d-flex align-items-center">
                                    <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
                                    <span itemprop="datePublished" content="2023-04-05T08:00:00+08:00">19 Sep 2023</span>
                                    </span>
                                    <h2 class="blog-grid-title mt-10" itemprop="headline">
                                    <a href="/blog/personalized-learning-with-educational-technology-a-game-changer-in-education" itemprop="url">2 Ways to Boost Learning and SATs Success with Rurera</a>
                                    </h2>
                                </div>
                                <div class="blog-grid-image">
                                    <img src="/store/1/default_images/blogs/blog-13.webp" class="img-cover" alt="2 Ways to Boost Learning and SATs Success with Rurera" title="2 Ways to Boost Learning and SATs Success with Rurera" width="100%" height="100%" itemprop="image" loading="eager">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
                            <div class="rurera-blog blog-medium" itemscope="" itemtype="https://schema.org/NewsArticle">
                                <div class="blog-grid-detail">
                                    <span class="badge created-at d-flex align-items-center">
                                    <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
                                    <span itemprop="datePublished" content="2023-04-05T08:00:00+08:00">27 Apr 2023</span>
                                    </span>
                                    <h2 class="blog-grid-title mt-10" itemprop="headline">
                                    <a href="/blog/navigating-the-rurera-reward-redemption-process-for-11-exams-and-more" itemprop="url">Experience realistic 11+ mock exams designed to simulate act</a>
                                    </h2>
                                </div>
                                <div class="blog-grid-image">
                                    <img src="/store/1/default_images/blogs/blog-29.jpg" class="img-cover" alt="Experience realistic 11+ mock exams designed to simulate act" title="Experience realistic 11+ mock exams designed to simulate act" width="100%" height="100%" itemprop="image" loading="eager">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4 mt-20 mt-lg-0">
                            <div class="rurera-blog blog-medium" itemscope="" itemtype="https://schema.org/NewsArticle">
                                <div class="blog-grid-detail">
                                    <span class="badge created-at d-flex align-items-center">
                                    <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
                                    <span itemprop="datePublished" content="2023-04-05T08:00:00+08:00">28 Apr 2023</span>
                                    </span>
                                    <h2 class="blog-grid-title mt-10" itemprop="headline">
                                    <a href="/blog/elevating-education-exploring-the-future-of-learning-for-year-6-students" itemprop="url">How to Explore the Future of Learning for Year 6 Students.</a>
                                    </h2>
                                </div>
                                <div class="blog-grid-image">
                                    <img src="/store/1/default_images/blogs/blog-27.jpg" class="img-cover" alt="How to Explore the Future of Learning for Year 6 Students." title="How to Explore the Future of Learning for Year 6 Students." width="100%" height="100%" itemprop="image" loading="eager">
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="single-post-block mb-50">
                        <div class="post-inner">
                            <ul class="order-list">
                                <li><span>Why everybody needs a brand</span></li>
                                <li><span>Find yor propostion, personality and purpose</span></li>
                                <li><span>Freelancing tips: How you can usebrand propostion</span></li>
                                <li><span>Useful resources for your Freelancing business</span></li>
                                <li><span>Create a brand with value</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="blog-newsletter text-center py-40">
                        <span class="icon-box">
                            <img src="../assets/default/svgs/envelope-mail-svgrepo-com.svg" alt="envelope image" height="800" width="800">
                        </span>
                        <div class="section-title mb-30">
                            <h2 class="font-40 mb-0">Want more Stuff like this?</h2>
                            <span class="d-block pt-5 font-19">Get the best viral stories straight into your box!</span>
                        </div>
                        <form action="">
                            <div class="form-element">
                                <input type="email" placeholder="Your email address">
                                <button type="submit">Subscribe</button>
                            </div>
                            <span class="d-block text-right font-14 ">Don't worry, we don't spam</span>
                        </form>
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
