<section class="page-section py-60 deals-section " style="background-color:#333">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-title mb-50">
                    <a href="#" itemprop="button" class="back-btn mb-30" style="margin-right: auto;">
                        <span>←</span>
                    </a>
                    <h1 itemprop="title" class="font-50 font-weight-bold mb-0 text-white">Global Arena</h1>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="listings-card">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @if( !empty( $timestablesTournamentsEvents ) )
                            @foreach( $timestablesTournamentsEvents as $tournamentEventObj)
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="deals-card" style="background:{{$tournamentEventObj->tournament->bg_color}}">
                                            <div class="card">
                                                <div class="card-timer">
                                                    <p id="timer" data-id="{{$tournamentEventObj->id}}" class="tournament-timer" data-timer="{{$tournamentEventObj->time_remaining}}">{{$tournamentEventObj->time_remaining}}</p>
                                                </div>
                                                <a href="#">
                                                    <h5>{{$tournamentEventObj->tournament->title}}</h5>
                                                    <p>$265,200 <span>{{$tournamentEventObj->tournament->sub_title}}</span></p>
                                                </a>
                                            </div>
                                        </div>
                                        <ul>
                                            <li>
                                                <div class="card-btn">
                                                    <a href="#"><i>&#x207A;</i> Join tournament</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="#">
                                                            <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                            <div class="text">
                                                                <h6>Emma Thompson</h6>
                                                                <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 98,321 <span>Whiz</span></p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a href="#">
                                                            <img src="https://themesbrand.com/velzon/html/creative/assets/images/users/avatar-1.jpg" alt="#" height="32" width="32">
                                                            <div class="text">
                                                                <h6>Liam Parker</h6>
                                                                <p><img src="/assets/default/svgs/diamond.svg" alt="#" height="15" width="15"> 75,092 <span>Enthusiast</span></p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var mySwiper  = null;
    if (jQuery('.listings-card .swiper-container').length > 0) {
        mySwiper  = new Swiper(".listings-card .swiper-container", {
            slidesPerView: 4,
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            //loop: true,
            //autoplay: {delay: 5e3, disableOnInteraction: !1},
            breakpoints: {
                991: {
                    slidesPerView: 4,
                    spaceBetween: 20
                },
                660: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 0
                },
                320: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            },
        });
    }

    if (jQuery('.tournament-timer').length > 0) {

        var global_arenas = [];
        var global_arenas_intervals = [];
        var global_interval_active = [];

        jQuery('.tournament-timer').each(function() {
            var thisObj = jQuery(this);
            var tournament_event_id = jQuery(this).attr('data-id');

            global_arenas_intervals[tournament_event_id] = setInterval(function () {
                var seconds_count = thisObj.attr('data-timer');
                //console.log(seconds_count);
                seconds_count = parseInt(seconds_count) - parseInt(1);
                thisObj.attr('data-timer', seconds_count);
                thisObj.html(seconds_count);
                if( seconds_count == 0) {
                    //thisObj.closest('.swiper-slide').remove();
                    mySwiper[0].slideNext();
                    clearInterval(global_arenas_intervals[tournament_event_id]);
                }

                global_arenas[tournament_event_id] = ( global_arenas[tournament_event_id] == undefined)? null : global_arenas[tournament_event_id];

                /*if( seconds_count == 0) {
                    global_arenas[tournament_event_id] = jQuery.ajax({
                        type: "POST",
                        beforeSend: function () {
                            if (global_arenas[tournament_event_id] != null) {
                                global_arenas[tournament_event_id].abort();
                            }
                        },
                        url: '/timestables/update_tournament_event',
                        async: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {'seconds_count': seconds_count, 'tournament_event_id': tournament_event_id},
                        success: function (return_data) {
                            console.log(return_data);
                            if( return_data != ''){
                                $(".swiper-wrapper").append(return_data);
                            }
                        }
                    });
                }*/

            }, 1000);
        });

    }


</script>