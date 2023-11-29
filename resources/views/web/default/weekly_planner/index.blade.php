@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<style>
    .is_child {
        display: none;
    }
</style>
@endpush

@section('content')
<section class="pages-sub-header lms-course-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-9">
                <p class="lms-subtitle font-16 mb-10">Programme of study</p>
                <h1 class="font-50 font-weight-bold mb-15">Weekly Course Planner</h1>
                <p class="font-19 mb-30">Skills available for England key stage 2, Year 5 maths objectives</p>
                <div class="lms-course-select">
                    <form>
                        <div class="form-inner">
                            <div class="form-select-field">
                                <select class="key_stage_id category-id-field" data-subject_id="0">
                                    <option>Key Stage</option>
                                    @if(!empty( $categories ))
                                    @foreach($categories as $category)
                                    @if(!empty($category->subCategories) and count($category->subCategories))
                                    <optgroup label="{{  $category->title }}">
                                        @foreach($category->subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}" @if(!empty($weeklyPlanner) and
                                                $weeklyPlanner->
                                            key_stage == $subCategory->id) selected="selected" @endif>{{
                                            $subCategory->title }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @else
                                    <option value="{{ $category->id }}" class="font-weight-bold"
                                            @if(!empty($weeklyPlanner)
                                            and $weeklyPlanner->key_stage == $category->id) selected="selected"
                                        @endif>{{
                                        $category->title }}
                                    </option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                                <div class="category_subjects_list">

                                </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-3 sub-header-img">
                <figure>
                    <img src="../assets/default/img/ukflag-img.png" height="185" width="275" alt="#">
                </figure>

            </div>
            <div class="col-12 col-md-12 col-lg-12">

                <div class="lms-element-nav1" style="display:none">
                    <ul>
                        <li class="has-child element-nav-slide-li" style="display: inherit;" data-id="1_4"><a href="javascript:;">1 - 4</a>
                        <ul>
                            <li class="is_child child_1_4"><a href="#1">1</a></li>
                            <li class="is_child child_1_4"><a href="#2">2</a></li>
                            <li class="is_child child_1_4"><a href="#3">3</a></li>
                            <li class="is_child child_1_4"><a href="#4">4</a></li>
                        </ul>
                        </li>


                        <li class="has-child element-nav-slide-li" style="display: inherit;" data-id="5_8"><a href="javascript:;">5 - 8</a>
                            <ul>
                                <li class="is_child child_5_8"><a href="#1">5</a></li>
                                <li class="is_child child_5_8"><a href="#2">6</a></li>
                                <li class="is_child child_5_8"><a href="#3">7</a></li>
                                <li class="is_child child_5_8"><a href="#4">8</a></li>
                            </ul>
                        </li>


                    </ul>
                </div>


                <div class="lms-element-nav">
                    <ul>

                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="lms-planner-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 lms-planner-section-fetch">

                @include('web.default.weekly_planner.single_weekly_planner',['weeklyPlanner'=> $weeklyPlanner])
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('body').on('mouseover', '.element-nav-slide-li1', function (e) {
            var thisObj = $(this);
            var data_id = thisObj.attr('data-id');
            console.log(data_id);
            $(".child_"+data_id).show( "slow" );
            //thisObj.closest('.has-child').find('.planner-sub-links ul').animate({left: '250px'});
        });
        $('body').on('mouseleave', '.element-nav-slide-li1', function (e) {
            var thisObj = $(this);
            var data_id = thisObj.attr('data-id');
            console.log(data_id);
            $(".child_"+data_id).hide( "slow" );
            //thisObj.closest('.has-child').find('.planner-sub-links ul').animate({left: '250px'});
        });

        $('body').on('change', '.category-id-field', function (e) {
            var category_id = $(this).val();
            console.log(category_id);
            var subject_id = $(this).attr('data-subject_id');
			subject_id = (subject_id > 0)? subject_id : 2010;
            $.ajax({
                type: "GET",
                url: '/national-curriculum/subjects_by_category',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'category_id': category_id, 'subject_id': subject_id, 'only_field': 'yes'},
                success: function (response) {
                    $(".category_subjects_list").html(response);
                }
            });

        });
        $(".category-id-field").change();

        $('body').on('change', '.choose-curriculum-subject', function (e) {
            var thisObj = $(this);
            rurera_loader(thisObj, 'page');
            var subject_id = $(this).val();
            var category_id = $('.category-id-field').val();
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

                    $('.lms-element-nav ul').html('<li><h3>Week</h3></li>');
                    $(".lms-element-nav-li").each(function(){
                        $('.lms-element-nav ul').append('<li>'+$(this).html()+'</li>');
                    });


                }
            });

        });


    });

</script>
@endpush
