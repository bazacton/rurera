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
        <a href="/spells" class="db-back-btn">Back to List</a>
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
                                    <th class="sorting">Definition</th>
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
    $(document).on('click', '.phonics-btn', function (e) {
        var player_id = $(this).attr('data-id');
        var audio_elements = $(this).find('.player-box-audio');
        console.log(player_id);
        var current_index = 0;

        // Function to play next audio with delay
        function playNextWithDelay() {
            if (current_index < audio_elements.length) {
                // Play the current audio
                console.log(audio_elements);
                audio_elements[current_index].play();

                // Increment index for the next audio
                current_index++;

                // Call recursively with a delay of 1 second
                setTimeout(playNextWithDelay, 1000);
            }
        }

        // Toggle pause class
        $(this).toggleClass("pause");

        // Check if paused or not
        if ($(this).hasClass('pause')) {
            // Start playing the sequence
            playNextWithDelay();
        } else {
            // Pause the current audio
            audio_elements[current_index - 1].pause();
        }
    });


</script>
@endpush
