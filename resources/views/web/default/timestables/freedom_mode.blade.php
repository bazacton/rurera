@extends('web.default.panel.layouts.panel_layout')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<div class="timestables-mode-block">

<div class="timestables-mode-content">
<div class="section-title mb-30">
    <h2 itemprop="title" class="font-22 mb-0"><a href="/timestables-practice" class="timestables-back-btn"></a> Freedom Mode</h2>
</div>
<section class="p-25 panel-border border-bottom-4 border-radius-10 mb-30" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Select Arithmetic Operations </h2></div>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                <form action="/timestables-practice/freedom-mode/play" method="post">
                    {{ csrf_field() }}
                    <div class="questions-select-option">
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input  type="radio" value="multiplication_division" id="multi-divi" name="question_type" />
                                <label for="multi-divi" class="d-inline-flex flex-column justify-content-center">

                                <strong>Multiplication and Division</strong>
                                </label>
                            </li>
                            <li>
                                <input checked type="radio" value="multiplication" id="multi-only" name="question_type" />
                                <label for="multi-only" class="d-inline-flex flex-column justify-content-center">
                                <strong>Multiplication only</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" value="division" id="divi-only" name="question_type" />
                                <label for="divi-only" class="d-inline-flex flex-column justify-content-center">
                                <strong>Division only</strong>
                                </label>
                            </li>
                        </ul>
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input checked type="radio" id="ten-questions" value="10" name="no_of_questions" />
                                <label for="ten-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>10 questions</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="twenty-questions" value="20" name="no_of_questions" />
                                <label for="twenty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>20 questions</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="thirty-questions" value="30" name="no_of_questions" />
                                <label for="thirty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>30 questions</strong>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="questions-select-number">
                        <ul class="d-flex justify-content-center flex-wrap mb-30">
                        <li {{in_array(10,$locked_tables)? 'class=disable-timetable noselect' : ''}}><input type="checkbox" value="10" name="question_values[]" id="ten" {{in_array(10,$locked_tables)? 'disabled' : ''}}  /> <label for="ten" >10</label></li>
                        <li {{in_array(2,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="2" name="question_values[]" id="two" {{in_array(2,$locked_tables)? 'disabled' : ''}} /> <label for="two">2</label></li>
                        <li {{in_array(5,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="5" name="question_values[]" id="five" {{in_array(5,$locked_tables)? 'disabled' : ''}} /> <label for="five" >5</label></li>
                        <li {{in_array(3,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="3" name="question_values[]" id="three" {{in_array(3,$locked_tables)? 'disabled' : ''}} /> <label for="three">3</label></li>
                        <li {{in_array(4,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="4" name="question_values[]" id="four" {{in_array(4,$locked_tables)? 'disabled' : ''}} /> <label for="four">4</label></li>
                        <li {{in_array(8,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="8" name="question_values[]" id="eight" {{in_array(8,$locked_tables)? 'disabled' : ''}} /> <label for="eight">8</label></li>
                        <li {{in_array(6,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="6" name="question_values[]" id="six" {{in_array(6,$locked_tables)? 'disabled' : ''}} /> <label for="six">6</label></li>
                        <li {{in_array(7,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="7" name="question_values[]" id="seven" {{in_array(7,$locked_tables)? 'disabled' : ''}} /> <label for="seven">7</label></li>
                        <li {{in_array(9,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="9" name="question_values[]" id="nine" {{in_array(9,$locked_tables)? 'disabled' : ''}} /> <label for="nine">9</label></li>
                        <li {{in_array(11,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="11" name="question_values[]" id="eleven" {{in_array(11,$locked_tables)? 'disabled' : ''}} /> <label for="eleven">11</label></li>
                        <li {{in_array(12,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="12" name="question_values[]" id="twelve" {{in_array(12,$locked_tables)? 'disabled' : ''}} /> <label for="twelve" >12</label></li>
                        <li {{in_array(13,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="13" name="question_values[]" id="thirteen" {{in_array(13,$locked_tables)? 'disabled' : ''}} /> <label for="thirteen" >13</label></li>
                        <li {{in_array(14,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="14" name="question_values[]" id="fourteen" {{in_array(14,$locked_tables)? 'disabled' : ''}} /> <label for="fourteen" >14</label></li>
                        <li {{in_array(15,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="15" name="question_values[]" id="fifteen" {{in_array(15,$locked_tables)? 'disabled' : ''}} /> <label for="fifteen" >15</label></li>
                        <li {{in_array(16,$locked_tables)? 'class=disable-timetable noselect' : ''}} ><input type="checkbox" value="16" name="question_values[]" id="sixteen" {{in_array(16,$locked_tables)? 'disabled' : ''}} /> <label for="sixteen" >16</label></li>
                        </ul>
                    </div>
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
                <div class="section-title mb-30 text-center"><h2>Freedom Mode History</h2></div>
            </div>
            <div class="col-12">
               @if( !empty( $attempts_array ) )

               @endif
               <table class="simple-table text-left">
                   <thead>
                       <tr>
                           <th>When</th>
                           <th>Average Time</th>
                           <th>Earned Coins</th>
                           <th>Earned Play Time</th>
                       </tr>
                   </thead>
                   <tbody>
                   @if( $results_data->count() > 0)
                       @foreach( $results_data as $resultsRow)
						@php 
						if($resultsRow->status == 'waiting'){ continue; }
						$average_time = ($resultsRow->total_time_consumed > 0 )? getTimeWithText($resultsRow->total_time_consumed / $resultsRow->total_attempted) : 0; @endphp
                           <tr>
                               <td><a href="/panel/results/{{$resultsRow->id}}/timetables">{{dateTimeFormat($resultsRow->created_at,'j M Y')}}</a></td>
                               <td>{{$average_time}}</td>
                               <td>{{$resultsRow->total_coins_earned}}</td>
                               <td>{{getTimeWithText($resultsRow->total_game_time)}}</td>
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
<div class="modal fade disable-timetables-table" id="disable-timetables-table" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <p class="noselect">It appears you've mastered the selected table, Additional practice in the freedom mode for that selected table is not required. If you wish to further focus on particular locked tables, just ask your teacher or parent to set up a special practice for you.</p>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/apexcharts/apexcharts.min.js"></script>
<script src="/assets/default/vendors/chartjs/chart.min.js"></script>
<script>
    $("body").on("click", ".disable-timetable", function (e) {
        $(".disable-timetables-table").modal('show');
    });
</script>
@endpush