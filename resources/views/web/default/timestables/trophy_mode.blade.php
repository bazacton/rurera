<style>
    .hide{display:none;}
    .above_12{display:none;}
</style>
@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<div class="timestables-mode-block">
<div class="timestables-mode-content">
<div class="section-title mb-30">
    <h2 itemprop="title" class="font-22 mb-0"><a href="/timestables-practice" class="timestables-back-btn"></a> Trophy Mode</h2>
</div>
@if( (5 - $results_data->count()) > 0)
<section class="border-bottom-4 border-radius-10 mb-5" >
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="referral-withdraw mb-30">
                      <div class="withdraw-card p-15 d-flex align-items-center flex-wrap">
                          <div class="icon-box">
                              <img src="/assets/default/svgs/shuttlecock.svg" alt="">
                          </div>
                              <div class="withdraw-text">
                                  <h3 class="blog-grid-title font-18 font-weight-bold mb-5" itemprop="title">You need to play {{(5 - $results_data->count())}} more games to earn a Badge</h3>
                              </div>
                      </div>
                    </div>
                  </div>
            </div>
    </div>
</section>
@endif
<section class="p-25 panel-border border-bottom-4 border-radius-10 mb-30" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Select Practice Time </h2></div>
            </div>

            <div class="col-12 col-lg-12 mx-auto">
                <form action="/timestables/generate_trophymode" method="post">
                    {{ csrf_field() }}
                    <h3>It will be one minute, try to answer the maximum questions.</h3>

                    <div class="form-btn">
                        <button type="submit" class="questions-submit-btn btn"><span>Play</span></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>


<section class="p-25 panel-border border-bottom-4 border-radius-10 mb-30" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="trophy-levels">
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Explorer')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Explorer</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Junior')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Junior</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Smarty')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Smarty</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Brainy')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Brainy</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Genius')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Genius</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Creative')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Creative</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-active-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Champion')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Champion</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Mastery')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Mastery</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Majesty')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Majesty</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Expert')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Expert</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                    <li {{(isset( auth()->user()->trophy_badge) && auth()->user()->trophy_badge == 'Maestro')? 'class=active' : '' }}>
                        <a href="#">
                            <span class="levels-text">Maestro</span>
                            <span class="icon-box">
                                <img src="/assets/default/img/trophy-levels-img.png" alt="">
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>
<section class="p-25 panel-border border-bottom-4 border-radius-10 mb-30" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Trophy History</h2></div>
            </div>
            <div class="col-12">
                <div class="chart-box" style="height: 200px; width:100%;">
                    <canvas id="trophy_chart" style="height:200px;width: content-box;"></canvas>
                </div>
               @if( !empty( $attempts_array ) )

               @endif
               <table class="simple-table text-left">
                   <thead>
                       <tr>
                           <th>When</th>
                           <th>Your Score</th>
                       </tr>
                   </thead>
                   <tbody>
                   @if( $results_data->count() > 0)
                       @foreach( $results_data as $resultsRow)
                           <tr>
                               <td>{{dateTimeFormat($resultsRow->created_at,'j M Y')}}</td>
                               <td>{{$resultsRow->quizz_result_questions_list->where('status', '=', 'correct')->count()}}</td>
                           </tr>
                       @endforeach
                   @else
                   <tr>
                       <td colspan="2" class="text-center">No records found</td>
                  </tr>
                   @endif
                   </tbody>
               </table>

            </div>

        </div>
        </div>
    </section>

</div>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
<script src="/assets/default/vendors/chartjs/chart.min.js"></script>


<script>
    $(document).ready(function () {
            var ctx = document.getElementById('trophy_chart').getContext('2d');
            var chart_labels = '{{json_encode($attempts_labels)}}';
            var chart_labelsArray = JSON.parse(chart_labels.replace(/&quot;/g, '"'));

           var chart_values = '{{json_encode($attempts_values)}}';
           var chart_valuesArray = JSON.parse(chart_values.replace(/&quot;/g, '"'));
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chart_labelsArray,
                    datasets: [{
                        label: 'Questions',
                        data: chart_valuesArray,
                        backgroundColor: 'transparent',
                        borderColor: '#43d477',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

    });

</script>

@endpush