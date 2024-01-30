@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/vendors/jquerygrowl/jquery.growl.css">
<link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
<script src="/assets/default/vendors/charts/chart.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<style>
    .hide {
        display: none !important;
    }
</style>
@endpush

@section('content')

<section class="content-section">
    <section class="pt-10">
        <a href="/spells">Back to List</a>
        <div class="container">

            <div class="row pt-15 pb-70">

                @if( !empty( $spellQuiz))

                <div class="col-12">
                    <section class="lms-data-table spells spells-data-list elevenplus-block">
                        <h3 class="font-22 mb-30">
                            {{$spellQuiz->getTitleAttribute()}} Words List
                            <span>We have a great range of question types to&nbsp;choose&nbsp;from.</span>
                        </h3>
                        <div class="spells-table-inner">
                            <table class="table table-striped table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th class="sorting sorting_asc"></th>
                                    <th class="sorting">Word</th>
                                    <th class="sorting">Defination</th>
                                    <th class="sorting">Sentences</th>
                                </tr>
                                </thead>
                                <tbody class="vocabulary-block">
                                {!! $words_response !!}
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                @endif

            </div>
        </div>
    </section>

</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/vendors/jquerygrowl/jquery.growl.js"></script>
<script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.graph-data-ul li a', function (e) {
            $('.graph-data-ul li a').removeClass('active');
            $(this).addClass('active');
            var graph_id = $(this).attr('data-graph_id');
            $('.graph_div').addClass('hide');
            $('.' + graph_id).removeClass('hide');
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {

        var audioElements = $(".player-box-audio");
        audioElements.each(function () {
            var audio = this;
            audio.addEventListener('ended', function () {
                $(this).closest('.play-btn').toggleClass("pause");
            });
        });


    });
    $(document).on('click', '.play-btn', function (e) {
        var player_id = $(this).attr('data-id');

        $(this).toggleClass("pause");
        if ($(this).hasClass('pause')) {
            document.getElementById(player_id).play();
        } else {
            document.getElementById(player_id).pause();
        }
    });


</script>
@endpush
