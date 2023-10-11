@extends(getTemplate().'.layouts.app')

@section('content')
<section class="blog-sub-header lms-call-to-action position-relative pt-70 pb-70">
        <div class="container">
            <div class="line-shap-holder h-100">
                <div class="line-shap-svg">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="cell-card">
                        <div class="cell-body">
                            <div class="row">
                                <div class="col-12 col-lg-8 col-md-8 mx-auto">
                                    <div class="cell-inner text-center">
                                        <h1 class="font-50 mb-15"><span class="text-scribble">Blog</span> updates from Rurera</h1>
                                        <p class="mb-50 font-19">Discover and explore the world through words where thoughts and imagination come to Life. Catch up on the latest news, success stories and more..</p>
                                        <form class="w-75 mx-auto">
                                            <div class="field-holder has-icon d-flex">
                                                <span class="search-icon">
                                                    <img src="../assets/default/svgs/search.svg" alt="default search" title="default search" width="100%" height="auto" loading="eager">
                                                </span>
                                                <input class="px-40" type="text" placeholder="What we can help you find ?">
                                                <button type="submit">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-10 mt-md-10 lms-blog">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    @foreach($blog as $post)
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="mt-30">
                                @include('web.default.blog.grid-list',['post' => $post])
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-20 mt-md-50 pt-30">
            {{ $blog->appends(request()->input())->links('vendor.pagination.panel') }}
        </div>

    </section>
    <section class="lms-newsletter blog-newsletter mt-70">
        <div class="container">
            <div class="row">
            <div class="col-12">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-lg-5 col-md-7">
                    <h2 class="mb-15 text-white font-40">Ready to start learning <br /> using Rurera</h2>
                    <p class="mb-0 text-white">Determine what skills or knowledge you want to acquire or improve upon selecting the appropriate learning platform.</p>
                    <div class="lms-btn-group mt-30 "><a href="{{url('/')}}/register" class="lms-btn rounded-pill text-white border-white">Signup</a></div>
                    </div>
                    <div class="col-12 col-lg-7 col-md-7">
                        <div class="svg-holder">
                            <span class="icon-svg">
                                <img class="w-100" src="../assets/default/svgs/blog-newsletter.svg" alt="default newsletter" title="default newsletter" width="100%" height="auto" loading="eager" />
                            </span>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection
