<section class="p-25 panel-border border-radius-10">
    <div class="container">
        <div class="row">
            <canvas id="powerup_chart"></canvas>
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
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Select Practice Time </h2></div>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                <form action="/timestables/generate_powerup" method="post">
                    {{ csrf_field() }}
                    <div class="questions-select-option">
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input checked type="radio" id="ten-questions" value="1" name="practice_time" />
                                <label for="ten-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>1 Minute</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="twenty-questions" value="3" name="practice_time" />
                                <label for="twenty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>3 Minutes</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="thirty-questions" value="5" name="practice_time" />
                                <label for="thirty-questions" class="d-inline-flex flex-column justify-content-center">
                                <strong>5 Minutes</strong>
                                </label>
                            </li>
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
<section class="lms-performace-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="leaderboard-tab">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <ul class="lms-performace-table leaderboard">
                                <li class="lms-performace-head leaderboard-title" style="background-color: #fff;">
                                    <div><h2 class="text-center font-18">Serial#</h2></div>
                                    <div class="text-left"><span>User</span></div>
                                    <div class="text-center"><span>Total Books Read</span></div>
                                    <div class="text-center"><span>Time Spent</span></div>
                                    <div class="text-center"><span>Earned Points</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>1</span></div>
                                    <div class="score-des w-25">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>200</span></div>
                                    <div class="time-sepen text-center"><span>30 minutes</span></div>
                                    <div class="coin-earn text-center"><span>100</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>2</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>250</span></div>
                                    <div class="time-sepen text-center"><span>36 minutes</span></div>
                                    <div class="coin-earn text-center"><span>150</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>3</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>300</span></div>
                                    <div class="time-sepen text-center"><span>40 minutes</span></div>
                                    <div class="coin-earn text-center"><span>200</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>4</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>350</span></div>
                                    <div class="time-sepen text-center"><span>46 minutes</span></div>
                                    <div class="coin-earn text-center"><span>250</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>5</span></div>
                                    <div class="score-des w-25">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>200</span></div>
                                    <div class="time-sepen text-center"><span>50 minutes</span></div>
                                    <div class="coin-earn text-center"><span>400</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>6</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>900</span></div>
                                    <div class="time-sepen text-center"><span>100 minutes</span></div>
                                    <div class="coin-earn text-center"><span>300</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>7</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>500</span></div>
                                    <div class="time-sepen text-center"><span>70 minutes</span></div>
                                    <div class="coin-earn text-center"><span>400</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>8</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>350</span></div>
                                    <div class="time-sepen text-center"><span>60 minutes</span></div>
                                    <div class="coin-earn text-center"><span>500</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>9</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>525</span></div>
                                    <div class="time-sepen text-center"><span>80 minutes</span></div>
                                    <div class="coin-earn text-center"><span>200</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>10</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>400</span></div>
                                    <div class="time-sepen text-center"><span>80 minutes</span></div>
                                    <div class="coin-earn text-center"><span>320</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>11</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>500</span></div>
                                    <div class="time-sepen text-center"><span>80 minutes</span></div>
                                    <div class="coin-earn text-center"><span>200</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>12</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>100</span></div>
                                    <div class="time-sepen text-center"><span>20 minutes</span></div>
                                    <div class="coin-earn text-center"><span>250</span></div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <ul class="lms-performace-table leaderboard">
                                <li class="lms-performace-head leaderboard-title" style="background-color: #fff;">
                                    <div><h2 class="text-center font-18">Serial#</h2></div>
                                    <div class="text-left"><span>User</span></div>
                                    <div class="text-center"><span>Total Books Read</span></div>
                                    <div class="text-center"><span>Time Spent</span></div>
                                    <div class="text-center"><span>Earned Points</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>1</span></div>
                                    <div class="score-des w-25">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>200</span></div>
                                    <div class="time-sepen text-center"><span>30 minutes</span></div>
                                    <div class="coin-earn text-center"><span>100</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>2</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>250</span></div>
                                    <div class="time-sepen text-center"><span>36 minutes</span></div>
                                    <div class="coin-earn text-center"><span>150</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>3</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>300</span></div>
                                    <div class="time-sepen text-center"><span>40 minutes</span></div>
                                    <div class="coin-earn text-center"><span>200</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>4</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>350</span></div>
                                    <div class="time-sepen text-center"><span>46 minutes</span></div>
                                    <div class="coin-earn text-center"><span>250</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>5</span></div>
                                    <div class="score-des w-25">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>200</span></div>
                                    <div class="time-sepen text-center"><span>50 minutes</span></div>
                                    <div class="coin-earn text-center"><span>400</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>6</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>900</span></div>
                                    <div class="time-sepen text-center"><span>100 minutes</span></div>
                                    <div class="coin-earn text-center"><span>300</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>7</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>500</span></div>
                                    <div class="time-sepen text-center"><span>70 minutes</span></div>
                                    <div class="coin-earn text-center"><span>400</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>8</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>350</span></div>
                                    <div class="time-sepen text-center"><span>60 minutes</span></div>
                                    <div class="coin-earn text-center"><span>500</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>9</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>525</span></div>
                                    <div class="time-sepen text-center"><span>80 minutes</span></div>
                                    <div class="coin-earn text-center"><span>200</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>10</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>400</span></div>
                                    <div class="time-sepen text-center"><span>80 minutes</span></div>
                                    <div class="coin-earn text-center"><span>320</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>11</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">jessica alba</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>500</span></div>
                                    <div class="time-sepen text-center"><span>80 minutes</span></div>
                                    <div class="coin-earn text-center"><span>200</span></div>
                                </li>
                                <li class="lms-performace-des leaderboard-des">
                                    <div class="sr-no text-center"><span>12</span></div>
                                    <div class="score-des">
                                        <figure><img src="/store/870/avatar/617a4f7c09d61.png" alt="avatar" title="avatar" width="100%" height="auto" itemprop="image" loading="eager" /></figure>
                                        <span><a href="#">Angelina mark</a></span>
                                    </div>
                                    <div class="level-up text-center"><span>100</span></div>
                                    <div class="time-sepen text-center"><span>20 minutes</span></div>
                                    <div class="coin-earn text-center"><span>250</span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        @if(!empty($attempts_labels))
            var ctx = document.getElementById('powerup_chart').getContext('2d');
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