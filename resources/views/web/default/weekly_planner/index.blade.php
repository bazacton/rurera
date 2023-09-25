@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="pages-sub-header lms-course-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-9">
                <p class="lms-subtitle">Programme of study</p>
                <h1 class="font-30 font-weight-bold">Weekly Planner</h1>
                <p>Skills available for England key stage 2, Year 5 maths objectives</p>
            </div>
            <div class="col-12 col-md-3 col-lg-3 sub-header-img">
                <figure>
                    <img src="../assets/default/img/ukflag-img.png">
                </figure>

            </div>
        </div>
    </div>
</section>


<section class="lms-planner-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-9 lms-planner-section-fetch">

                @include('web.default.weekly_planner.single_weekly_planner',['weeklyPlanner'=> $weeklyPlanner])
            </div>
            <div class="col-lg-3 col-md-3 col-12 lms-planner-sidebar">
                <div class="lms-course-select">
                    <form>
                        <div class="form-inner flex-column mx-0">
                            <div class="form-field mb-15">
                                <h5>Key Stages</h5>
                                <ul class="key_stage_id category-id-field">

                                    @if(!empty( $categories ))
                                    @foreach($categories as $category)
                                    @if(!empty($category->subCategories) and count($category->subCategories))
                                        @foreach($category->subCategories as $subCategory)
                                        @php $checked = ($weeklyPlanner->key_stage == $subCategory->id)? 'checked' : ''; @endphp
                                        <li>
                                            <input type="radio" value="{{ $subCategory->id }}" name="key-stage" id="{{ $subCategory->id }}" {{$checked}}>
                                            <label for="{{ $subCategory->id }}">{{$subCategory->title }}</label>
                                        </li>
                                        @endforeach
                                    @endif
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="category_subjects_list mb-15">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="lms-element-nav">
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



<a href="#" class="scroll-btn">
    <div class="round">
        <div id="cta"><span class="arrow primera next "></span> <span class="arrow segunda next "></span></div>
    </div>
</a>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('change', '.category-id-field li input[type=radio]', function (e) {
            var category_id = $(this).val();
            console.log(category_id);
            var subject_id = $(this).attr('data-subject_id');
			subject_id = (subject_id > 0)? subject_id : 2065;
            $.ajax({
                type: "GET",
                url: '/national-curriculum/subjects_by_category_frontend',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'category_id': category_id, 'subject_id': subject_id, 'only_field': 'yes'},
                success: function (response) {
                    $(".category_subjects_list").html(response);
                }
            });

        });
        $('.category-id-field li input[type=radio]:checked').change();

        $('body').on('change', '.choose-curriculum-subject li input[type=radio]', function (e) {
            var thisObj = $(this);
            rurera_loader(thisObj, 'page');
            var subject_id = $(this).val();
            var category_id = $('.category-id-field li input[type=radio]:checked').val();
            $.ajax({
                type: "GET",
                url: '/weekly-planner/weekly_planner_by_subject',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'category_id': category_id, 'subject_id': subject_id},
                success: function (response) {
                    rurera_remove_loader(thisObj, 'page');
                    $(".lms-planner-section-fetch").html(response);

                    $('.lms-element-nav ul').html('');
                    console.log($(".lms-element-nav-li").length);
                    $(".lms-element-nav-li").each(function(){
                        $('.lms-element-nav ul').append('<li>'+$(this).html()+'</li>');
                    });


                }
            });

        });


    });

</script>
@endpush
