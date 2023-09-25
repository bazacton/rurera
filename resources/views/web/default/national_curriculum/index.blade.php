@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<script src="/assets/default/vendors/charts/chart.js"></script>
@endpush

@section('content')
<section class="pages-sub-header lms-course-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-9">



                <div class="chart"><canvas id="chartRadar2"></canvas></div>

                <script>
                        $(document).ready(function () {
                            var options = {
                                type: "bar",
                                data: {
                                    labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                                    datasets: [
                                        { label: "Questions Attempt", data: [75, 68, 80, 50, 90, 65, 40], borderWidth: 0, backgroundColor: "#417290", borderColor: "#417290" },
                                        { label: "Coins Earned", data: [175, 168, 180, 150, 190, 165, 140], borderWidth: 0, backgroundColor: "#fd1656", borderColor: "#417290" },
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                },
                            };
                            var ctx11 = document.getElementById("chartRadar").getContext("2d");
                            new Chart(ctx11, options);
                        });
                    </script>


                <script>
                    $(document).ready(function () {
                        var options = {
                            type: "bar",
                            data: {
                                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                                datasets: [
                                    { label: "Questions Attempt", data: [75, 68, 80, 50, 90, 65, 40, 78, 68, 85, 75, 67], borderWidth: 0, backgroundColor: "#417290", borderColor: "#417290" },
                                    { label: "Coins Earned", data: [175, 168, 180, 150, 190, 165, 140, 178, 168, 185, 175, 167], borderWidth: 0, backgroundColor: "#fd1656", borderColor: "#417290" },
                                ],
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                //scales: { x: { grid: { display: false }, border: { display: false } }, y: { grid: { display: false }, border: { display: false } } },
                            },
                        };
                        var ctx11 = document.getElementById("chartRadar2").getContext("2d");
                        new Chart(ctx11, options);
                    });
                </script>

                <p class="lms-subtitle">Programme of study</p>
                <h1 class="font-30 font-weight-bold">National Curriculum</h1>
                <p>Skills available for England key stage 2, Year 5 maths objectives</p>
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
                                        <option value="{{ $subCategory->id }}" @if(!empty($nationalCurriculum) and
                                                $nationalCurriculum->
                                            key_stage == $subCategory->id) selected="selected" @endif>{{
                                            $subCategory->title }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @else
                                    <option value="{{ $category->id }}" class="font-weight-bold"
                                            @if(!empty($nationalCurriculum)
                                            and $nationalCurriculum->key_stage == $category->id) selected="selected"
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
                    <img src="../assets/default/img/ukflag-img.png">
                </figure>

            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="lms-element-nav">
                    <ul>
                        <li>
                            <a href="#lms-numbers">Numbers</a>
                        </li>
                        <li>
                            <a href="#lms-measurement">Measurement</a>
                        </li>
                        <li>
                            <a href="#">Geometry</a>
                        </li>
                        <li>
                            <a href="#">Statistics</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@include('web.default.national_curriculum.single_curriculum',['nationalCurriculum'=> $nationalCurriculum])
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
        $('body').on('change', '.category-id-field', function (e) {
            var category_id = $(this).val();
            var subject_id = $(this).attr('data-subject_id');
			subject_id = (subject_id > 0)? subject_id : 2065;
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
                url: '/national-curriculum/curriculum_by_subject',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'category_id': category_id, 'subject_id': subject_id},
                success: function (response) {
                    rurera_remove_loader(thisObj, 'page');
                    $(".lms-curriculums-section").html(response);
                }
            });

        });


    });

</script>
@endpush
