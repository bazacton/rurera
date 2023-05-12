@extends(getTemplate().'.layouts.appstart')
@php
$i = 0;

@endphp

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css">
<link rel="stylesheet" href="/assets/admin/css/quiz-css.css">


@section('content')

<div class="lms-content-holder">
    <p class="lms-sub-heading">put these numbers in order from <strong>smallest</strong> or <strong>largest</strong></p>
    <div class="lms-sorting-fields sortable">
        <div class="field-holder">
            <span>30,817</span>
        </div>
        <div class="field-holder">
            <span>87,181</span>
        </div>
        <div class="field-holder">
            <span>87,135</span>
        </div>
        <div class="field-holder">
            <span>13,924</span>
        </div>
        <div class="field-holder">
            <span>87,181</span>
        </div>
    </div>
    <p class="lms-sub-heading">
        Which sign makes the statement true? 
        <span class="lms-sign-match">69,722 <em>?</em> 69,722</span>
    </p>
    <div class="lms-radio-select">
        <div class="field-holder">
            <input type="radio" name="sign" id="sign1">
            <label for="sign1">></label>
        </div>
        <div class="field-holder">
            <input type="radio" name="sign" id="sign2">
            <label for="sign2"><</label>
        </div>
        <div class="field-holder">
            <input type="radio" name="sign" id="sign3">
            <label for="sign3">=</label>
        </div>
    </div>
    <p class="lms-sub-heading">Which of the following are <strong>cardinal</strong> numbers? (there may be more than one)</p>
    <div class="form-box inline-fields">
        <div class="form-field">
            <input id="check11" type="checkbox">
            <label for="check11">
                ninety-two
            </label>
        </div>
        <div class="form-field">
            <input id="check12" type="checkbox">
            <label for="check12">
                ninety
            </label>
        </div>
        <div class="form-field">
            <input id="check13" type="checkbox">
            <label for="check13">
                eighty-eight
            </label>
        </div>
        <div class="form-field">
            <input id="check14" type="checkbox">
            <label for="check14">
                73
            </label>
        </div>
    </div>
    <div class="form-box">
        <div class="form-field">
            <input id="check1" type="checkbox">
            <label for="check1">
                <span>1.</span>
                Comprehension
            </label>
        </div>
        <div class="form-field">
            <input id="check2" type="checkbox">
            <label for="check2">
                <span>2.</span>
                Comprehension
            </label>
        </div>
        <div class="form-field">
            <input id="check3" type="checkbox">
            <label for="check3">
                <span>3.</span>
                Comprehension
            </label>
        </div>
    </div>
    <p class="lms-sub-heading">How do you write this number using words? <span class="lms-numbers">812,711</span></p>
    <div class="lms-sorting-fields multi-lines sortable">
        <div class="field-holder">
            <span class="sort-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span>eight hundred and twelve thousand seven hundred and eleven</span>
        </div>
        <div class="field-holder">
            <span class="sort-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span>eight hundred and twelve thousand seven hundred and eleven</span>
        </div>
        <div class="field-holder">
            <span class="sort-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span>eight hundred and twelve thousand seven hundred and eleven</span>
        </div>
        <div class="field-holder">
            <span class="sort-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span>eight hundred and twelve thousand seven hundred and eleven</span>
        </div>
        <div class="field-holder">
            <span class="sort-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span>eight hundred and twelve thousand seven hundred and eleven</span>
        </div>
    </div>
    <p class="lms-sub-heading" style="color: #82a724;">Read the follwing description of a relationship:</p>
    <div class="lms-description">
        <div class="description-inner">
            <p>Whenever Edmond's teacher asigns an essay to write, Edmond always writes 4<br /> pages more than the minimum</p>
            <p>Let m represent the minimum number of pages and we represent the number of<br /> pages Edmond writes.</p>
        </div>
    </div>
    <p class="lms-sub-heading">Complete the table using the equation w = m + 4.</p>
    <div class="lms-table">
        <table>
            <thead>
                <tr>
                    <th>m</th>
                    <th>w</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td> <input type="text"> </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>8</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="lms-sub-heading">Which shape has cordinates (6,6)?</p>
    <div class="lms-shape-select">
        <figure>
            <img src="/store/1/default_images/shap-img1.png" alt="">
        </figure>
        <div class="lms-radio-select">
            <div class="field-holder">
                <input type="radio" name="sign" id="sign11">
                <label for="sign11">
                    <img src="/store/1/default_images/shape-sm1.png" alt="">
                </label>
            </div>
            <div class="field-holder">
                <input type="radio" name="sign" id="sign12">
                <label for="sign12">
                    <img src="/store/1/default_images/shape-sm2.png" alt="">
                </label>
            </div>
            <div class="field-holder">
                <input type="radio" name="sign" id="sign13">
                <label for="sign13">
                    <img src="/store/1/default_images/shape-sm3.png" alt="">
                </label>
            </div>
            <div class="field-holder">
                <input type="radio" name="sign" id="sign14">
                <label for="sign14">
                    <img src="/store/1/default_images/shape-sm4.png" alt="">
                </label>
            </div>
        </div>
    </div>
    <p class="lms-sub-heading">Where is the magic shop?</p>
    <div class="lms-magic-shop">
        <figure>
            <img src="/store/1/default_images/shop-img.png" alt="">
        </figure>
        <div class="shop-input-fields">
            <label>
                (<input type="text">, <input type="text">)
            </label>
        </div>
    </div>
    <p class="lms-sub-heading">Tick the diagram that is the net of a cone.</p>
    <div class="lms-diagram">
        <div class="diagram-field">
            <label for="diagram1">
                <img src="/store/1/default_images/diagram-img1.png" alt="">
                <input type="checkbox" id="diagram1">
            </label>
        </div>
        <div class="diagram-field">
            <label for="diagram2">
                <img src="/store/1/default_images/diagram-img2.png" alt="">
                <input type="checkbox" id="diagram2">
            </label>
        </div>
        <div class="diagram-field">
            <label for="diagram3">
                <img src="/store/1/default_images/diagram-img3.png" alt="">
                <input type="checkbox" id="diagram3">
            </label>
        </div>
    </div>
    <p class="lms-sub-heading mb-10 font-md">Complete the sentences to describe the translations.</p>
    <div class="lms-describe-sentences">
        <figure>
            <img src="/store/1/default_images/sentence-img.png" alt="">
        </figure>
        <div class="sentence-field">
            <span class="question-lable">a)</span>
            <p>Shab A has been translated <input type="text" value="3"> squares to the right and <br /> 
            <input type="text" value="4"> squares down. </p>
        </div>
        <div class="sentence-field">
            <span class="question-lable">b)</span>
            <p>Shab B has been translated <input type="text" value="7"> squares to the <span>left</span> <br /> 
            and <input type="text" value="2"> squares <span>up</span> </p>
        </div>
        <div class="sentence-field">
            <span class="question-lable">c)</span>
            <p>Shab C has been translated <input type="text" value="5"> squares to the <span>right</span> <br /> 
            and <input type="text" value="0"> squares <span>up/down</span> </p>
        </div>
    </div>
    <div class="lms-question-list">
        <div class="question-inner">
            <div class="question-header">
                <span class="question-lable">Question List</span>
                <p>
                    <span>Question 12 of 14</span>
                    <span>Total Points: 60 out of 140</span>
                </p>
            </div>
            <div class="question-body" style="background: url(/store/1/default_images/mountain-img2.jpg) no-repeat 0 0 /cover; min-height:440px;">
                <h4>Read this abstract about Everest and choose<br /> one correct answer in each drop-down list.</h4>
                <div class="body-inner">
                    <p>
                        The most
                        <label class="select-box">
                            <select>
                                <option>dangerous</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                            </select>
                        </label>
                        area of the mountain is often
                    </p>
                    <p>
                        Considered to be the khumbu
                        <label class="select-box">
                            <select>
                                <option>Ice Fall</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                            </select>
                        </label>,
                        which is
                    </p>
                    <p>
                        Particularly dangerous due to the
                        <label class="select-box">
                            <select>
                                <option>Ice Fall</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                                <option>dummy text</option>
                            </select>
                        </label><br />
                        movement of the ice fall.
                    </p>
                </div>
            </div>
            <div class="question-footer">
                <span>Postpone</span>
                <input type="submit" value="Submit">
            </div>
        </div>
    </div>
    <div class="lms-question-list">
        <div class="question-inner">
            <div class="question-header">
                <span class="question-lable">Question List</span>
                <p>
                    <span>Question 12 of 14</span>
                    <span>Total Points: 60 out of 140</span>
                </p>
            </div>
            <div class="question-body" style="background: url(/store/1/default_images/mountain-img3.jpg) no-repeat 0 0 /cover; min-height:440px;">
                <h4>Drag the words and drop them to the appropriate places</h4>
                <div class="body-inner">
                    <p>Each year, in the period from April to May, the <input type="text" value="jet stream"> moves north causing <br />
                    the <input type="text" value="winds" class="input-small"> to calm and <input type="text" value="temperatures"> to warm enough for people to try <br />
                    to summit. this is called the ' <input type="text"> ' there is a similar period each fall in <br />
                    November.</p>
                    <div class="search-fields">
                        <div class="field-holder">
                            <input type="text">
                        </div>
                        <div class="field-holder">
                            <input type="text">
                        </div>
                        <div class="field-holder">
                            <input type="text">
                        </div>
                        <div class="field-holder">
                            <input type="text" class="input-small">
                        </div>
                    </div>
                </div>
            </div>
            <div class="question-footer">
                <span>Postpone</span>
                <input type="submit" value="Submit">
            </div>
        </div>
    </div>
    <div class="lms-question-list">
        <div class="question-inner">
            <div class="question-header">
                <span class="question-lable">Question List</span>
                <p>
                    <span>Question 12 of 14</span>
                    <span>Total Points: 60 out of 140</span>
                </p>
            </div>
            <div class="question-body" style="background: url(/store/1/default_images/mount-img1.png) no-repeat bottom left #fff; min-height:440px; min-height: 610px;  background-size: 100%;">
                <h4 class="text-dark">Fill in the blanks in this fragment about</h4>
                <div class="body-inner">
                    <p class="text-dark">
                        Everst is known as the Earth's <input type="text" class="text-left" value="highest"> mountain. its <br />
                        peak is about 8,848 <input type="text" value="metres" class="text-left"> (29,029 ft) above <br />
                        <input type="text" class="text-left input-small" value="sea"> level.
                    </p>
                </div>
            </div>
            <div class="question-footer">
                <span>Postpone</span>
                <input type="submit" value="Submit">
            </div>
        </div>
    </div>
    @foreach($questions as $key => $question)
	
	@php
	$question_layout = html_entity_decode(json_decode(base64_decode(trim(stripslashes($question->question_layout)))));
	@endphp
	
    @if($key == 0)
    <h2><span>Q 1</span> - {{ $question->question_title }} <span>&#x1F50A;</span> </h2>
    <div class="left-content has-bg">
		<div id="leform-form-1" class="leform-form leform-elements leform-form-input-medium leform-form-icon-inside leform-form-description-bottom ui-sortable" _data-parent="1" _data-parent-col="0" style="min-height: 1539px; display: block;">
		{!! $question_layout !!}
		
		<div class="form-btn">
			<input class="submit-btn" type="submit" value="Submit">
		</div>
		</div>
        <h3 style="color: #4f4d7f;"><span>Solve the following problems: Use pen and paper where required</span></h3>
        <form>
            <div class="form-box">
                <div class="form-field">
                    <input id="check1" type="checkbox">
                    <label for="check1">
                        <span>1.</span>
                        Comprehension
                    </label>
                </div>
                <div class="form-field">
                    <input id="check2" type="checkbox">
                    <label for="check2">
                        <span>2.</span>
                        Comprehension
                    </label>
                </div>
                <div class="form-field">
                    <input id="check3" type="checkbox">
                    <label for="check3">
                        <span>3.</span>
                        Comprehension
                    </label>
                </div>
                <div class="form-btn">
                    <input class="submit-btn" type="submit" value="Submit">
                </div>
            </div>
            <span class="marks">[1]</span>
        </form>
    </div>
    <div class="right-content">
        <!-- vertical range-slider -->
        <div class="range-container vertical">
            <div class="range-box">
                <span class="range-bar-holder">
                    <span class="track-bar" style="background-color: #4bc1ef;"></span>
                    <span class="track-bar" style="background-color: #a4b96a;"></span>
                    <span class="track-bar" style="background-color: #fecc49;"></span>
                    <span class="track-bar" style="background-color: #f59618;"></span>
                    <span class="track-bar" style="background-color: #c12f16;"></span>
                </span>
                <input orient="vertical" type="range" id="range" min="0" max="100">
                <label for="range">
                    50
                </label>
            </div>
        </div>
        <p class="mastery-text" style="color: #50517d;">1400 Mastery Coins</p>
    </div>
    @endif
    @endforeach
</div>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/video/video.min.js"></script>
<script src="/assets/default/vendors/jquery.simple.timer/jquery.simple.timer.js"></script>
<script src="/assets/default/js/parts/quiz-start.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
        const range = document.getElementById('range')
        range.addEventListener('input', (e) => {
            const value = +e.target.value
            const label = e.target.nextElementSibling

            const range_width = getComputedStyle(e.target).getPropertyValue('width')
            const label_width = getComputedStyle(label).getPropertyValue('width')

            const num_width = +range_width.substring(0, range_width.length - 2)
            const num_label_width = +label_width.substring(0, label_width.length - 2)

            const max = +e.target.max
            const min = +e.target.min

            const left = value * (num_width / max) - num_label_width / 2 + scale(value, min, max, 10, -10)
            label.style.left = `${left}px`
            
            label.innerHTML = value
        })
        const scale = (num, in_min, in_max, out_min, out_max) => {
            return (num - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
        }
    </script>
    <script>
    $( function() {
        $( ".sortable" ).sortable();
    } );
  </script>
@endpush
