@extends(getTemplate().'.layouts.app')

@push('styles_top')
<style>
    .hide{display:none;}
</style>

@endpush

@section('content')
<section class="heatmap-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="heatmap-heading mb-30 pl-15">
                    <h2 class="font-weight-normal m-0 font-18">Average per Table</h2>
                    <span>How quickly correctly answers each table. Measured in second per question. Under 3s/q is considered to be automatic recall.</span>
                </div>
                <div class="heatmap-table-boxes mb-30">
                    <ul class="d-flex">
                        <li>
                            <div class="heatmap-box">
                                <div class="box-top"><span>10 <span>&#215;</span></span>
                                    <span>2 <span>&#215;</span></span>
                                    <span>5 <span>&#215;</span></span>
                                </div>
                                <div class="box-body"><strong>0.93s</strong> <strong>0.91s</strong>
                                    <strong>0.96s</strong>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="heatmap-box">
                                <div class="box-top"><span>3 <span>&#215;</span></span>
                                    <span>4 <span>&#215;</span></span> <span>8 <span>&#215;</span></span>
                                </div>
                                <div class="box-body"><strong>0.95s</strong> <strong>0.91s</strong>
                                    <strong>0.97s</strong>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="heatmap-box">
                                <div class="box-top"><span>6 <span>&#215;</span></span>
                                    <span>7 <span>&#215;</span></span> <span>9 <span>&#215;</span></span>
                                </div>
                                <div class="box-body"><strong>0.96s</strong> <strong>1.0s</strong> <strong>1.0s</strong>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="heatmap-box" style="background-color: #84b741;">
                                <div class="box-top"><span>6 <span>&#215;</span></span>
                                    <span>7 <span>&#215;</span></span>
                                </div>
                                <div class="box-body"><strong>1.0s</strong> <strong>1.1s</strong></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="heatmap-heading mb-30 pl-15">
                    <h2 class="font-weight-normal m-0 font-18">Heatmap</h2>
                    <span>How quickly Rumaisa correctly answers each indivdual questions</span>
                </div>
                <div class="heatmap-select-option">
                    <div class="select-field">
                        <input checked type="radio" id="select-one" name="heatmap">
                        <label for="select-one"> 2-12<span>&#215;</span> </label>
                        <input type="radio" id="select-two" name="heatmap">
                        <label for="select-two" class="border-right-0"> 2-20<span>&#215;</span> </label>
                    </div>
                    <strong>Rumaisa Heatmap as of May 2023</strong>
                    <a href="#" class="heatmap-download-btn"> <img src="../assets/default/img/download.png"
                                                                   alt="download button"> </a>
                </div>
                <div class="heatmap-table-holder mb-20">

                    <table class="heatmap-table">
                        <thead>
                        <tr>
                            <th></th>
                            @php $count = 2; @endphp
                            @while($count <= 12)
                            <th>{{$count}}</th>
                            @php $count++; @endphp
                            @endwhile
                        </tr>
                        </thead>


                        @php $table_main_count = 1; $dates_array = array(); @endphp
                        @if( !empty( $times_tables_data ) )
                        @foreach( $times_tables_data as $date => $tableData)
                        @php $activeClass = ($table_main_count == 1)? 'active' : 'hide'; $dates_array[] = $date; @endphp
                        <tbody class="summary-table-item {{$activeClass}}" data-datestring="{{$date}}">
                        @php $count = 2; @endphp
                        @while($count <= 12)
                        @php $table_count = 2;
                        $from_table_array = isset( $tableData[$count] )? $tableData[$count] : array();
                        @endphp

                        <tr>
                            <td>{{$count}}</td>
                            @while($table_count <= 12)
                            @php
                            $to_tableObj = isset( $from_table_array[$table_count] )?
                            $from_table_array[$table_count] : array();
                            $class = isset( $to_tableObj['class'] )? $to_tableObj['class'] : '';


                            @endphp
                            <td class="{{$class}}">
                                <span>{{$count}} <span>&#215;</span> {{$table_count}}</span></td>
                            @php $table_count++; @endphp
                            @endwhile
                        </tr>

                        @php $count++; @endphp
                        @endwhile
                        </tbody>
                        @php $table_main_count++; @endphp
                        @endforeach
                        @endif

                    </table>


                </div>
                <div class="heatmap-heading mb-20">
                    <span>Drag to time travel or click below to focus a table</span>
                </div>
                <div class="heatmap-range-slider">
                    <a href="#" class="range-play-btn"><span>&#9654;</span></a>
                    <div id="storlekslider"></div>
                    <div class="range-value">
                        <input type="text" name="storlek" id="storlek_testet" value=""/>
                        <span>May 2023</span>
                    </div>
                </div>
                <div class="heatmap-table-text">
                    <ul class="d-flex justify-content-between">
                        <li><span class="text-label">Table</span></li>
                        <li>10<span>&#215;</span></li>
                        <li>2<span>&#215;</span></li>
                        <li>5<span>&#215;</span></li>
                        <li>3<span>&#215;</span></li>
                        <li>4<span>&#215;</span></li>
                        <li>8<span>&#215;</span></li>
                        <li>6<span>&#215;</span></li>
                        <li>7<span>&#215;</span></li>
                        <li>9<span>&#215;</span></li>
                        <li>11<span>&#215;</span></li>
                        <li>12<span>&#215;</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
    if (jQuery('#storlekslider').length > 0) {
        var valMap = <?php echo json_encode($dates_array); ?>;
        const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        $("#storlekslider").slider({
            max: valMap.length - 1,
            slide: function(event, ui) {
                var datestring = valMap[ui.value];
                jsTimestamp = new Date(valMap[ui.value] * 1000);
                var month_label = months[jsTimestamp.getMonth()];
                $(".range-value span").html(month_label+' '+jsTimestamp.getFullYear());
                $("#storlek_testet").val(jsTimestamp.getDate());
                $("#storlek_testet").attr('data-datestring', datestring);
                $(".summary-table-item").removeClass('active');
                $(".summary-table-item").addClass('hide');
                $('.summary-table-item[data-datestring="'+datestring+'"]').addClass('active');
                $('.summary-table-item[data-datestring="'+datestring+'"]').removeClass('hide');




                $(ui.value).val(jsTimestamp.getDate());
            }
        });
    }

    if (jQuery('#storlek_testet').length > 0) {
        $("#storlek_testet").keyup(function () {

            $("#storlekslider").slider("value", $(this).val());
            var value1 = $("#storlek_testet").val();
        });
    }
</script>
@endpush
