<section class="p-25 panel-border border-radius-10">
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
            <canvas id="trophy_chart"></canvas>
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
                       @foreach( $results_data as $resultsRow)
                           <tr>
                               <td>{{dateTimeFormat($resultsRow->created_at,'j M Y')}}</td>
                               <td>{{$resultsRow->quizz_result_questions_list->where('status', '=', 'correct')->count()}}</td>
                           </tr>
                       @endforeach
                   </tbody>
               </table>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        @if(!empty($attempts_labels))
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
                        borderWidth: 2
                    }]
                },

            });
        @endif

    });

</script>