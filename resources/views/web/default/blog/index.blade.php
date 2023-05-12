@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="site-top-banner products-top-header search-top-banner opacity-04 position-relative">
        
        <div class="container h-100">
            <div class="row h-100 justify-content-center text-center">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="top-search-categories-form">
                        <h1 class="font-30 mb-15">{{ $pageTitle }}</h1>

                        <div class="search-input bg-white flex-grow-1">
                            <form action="/blog" method="get">
                                <div class="form-group d-flex align-items-center m-0">
                                    <span class="search-icon"><i data-feather="search" width="20" height="20" class=""></i></span>
                                    <input type="text" name="search" class="form-control border-0" value="{{ request()->get('search') }}" placeholder="{{ trans('home.blog_search_placeholder') }}"/>
                                    <button type="submit" class="btn btn-primary">{{ trans('home.find') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="container mt-10 mt-md-40 lms-blog">
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
@endsection
