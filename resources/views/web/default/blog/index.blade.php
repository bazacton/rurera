@extends(getTemplate().'.layouts.app')

@section('content')
    <section class="blog-sub-header products-top-header search-top-banner position-relative">
        <div class="container h-100">
            <div class="row h-100 justify-content-center text-center text-white">
                <div class="col-12 col-md-12 col-lg-12">
 			<h1 class="font-48 mb-15">Welcome to Learning blog</h1>
                   
                </div>
                <div class="col-12 col-md-12 col-lg-12">
 <div class="top-search-categories-form">
                       <div class="search-input bg-white flex-grow-1">
                        <form action="/blog" method="get">
                            <div class="form-group d-flex align-items-center m-0">
                                <span class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg></span>
                                <input type="text" name="search" class="form-control border-0" value=""
                                    placeholder="Search for blog posts...">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="svg-container"></div>
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
