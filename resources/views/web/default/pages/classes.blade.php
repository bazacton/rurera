@extends(getTemplate().'.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section class="pages-sub-header courses-sub-header position-relative">
        <div class="container h-100">
          <div class="row h-100 align-items-center justify-content-center flex-column text-center">
            <div class="col-12 col-md-12 col-lg-8">
              <h1 class="font-30 mb-30">Experience interactive <br> learning Experience </h1>
              <p>Courses available for <a href="#">Maths</a>, <a href="#" style="color: #b88e88;">English</a>, 
                <a href="#" style="color: #a5013e;">English Reading</a>, <a href="#" style="color: #015da5;">science</a> and 
                <a href="#">computing</a>
                <br> that will surely help you grow and capture innovative ideas.
              </p>
              <div class="mt-50 d-flex align-items-center justify-content-center position-relative">
                <a href="#" class="btn btn-primary">View all courses</a>
                <a href="#" class="btn btn-outline-primary ml-15">Take a Course</a>
              </div>
            </div>
          </div>
        </div>
        <div class="svg-container"></div>
    </section>

    <div class="container mt-30">

        <section class="mt-lg-50 pt-lg-20 mt-md-40 pt-md-40">
            <form action="/classes" method="get" id="filtersForm">


                <div class="row mt-20">
                    <div class="col-12 col-lg-12">

                        @if(empty(request()->get('card')) or request()->get('card') == 'grid')
                            <div class="row">
                                @foreach($webinars as $webinar)
                                    <div class="col-12 col-lg-3 mt-20">
                                        @include('web.default.includes.webinar.grid-card',['webinar' => $webinar])
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>

            </form>
            <div class="mt-50 pt-30">
                {{ $webinars->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        </section>
    </div>

@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>

    <script src="/assets/default/js/parts/categories.min.js"></script>
@endpush
