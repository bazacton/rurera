<section class="p-25 panel-border border-radius-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Select Arithmetic Operations </h2></div>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                <form action="/timestables/generate" method="post">
                    {{ csrf_field() }}
                    <div class="questions-select-option">
                        <ul class="mb-20 d-flex align-items-center">
                            <li>
                                <input  type="radio" value="multiplication_division" id="multi-divi" name="question_type" />
                                <label for="multi-divi" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">
                                    8 per correct answer
                                </span>
                                <strong>Multiplication and Division</strong>
                                </label>
                            </li>
                            <li>
                                <input checked type="radio" value="multiplication" id="multi-only" name="question_type" />
                                <label for="multi-only" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">4 per correct answer</span>
                                <strong>Multiplication only</strong>
                                </label>
                            </li>
                            <li>
                                <input type="radio" value="division" id="divi-only" name="question_type" />
                                <label for="divi-only" class="d-inline-flex flex-column justify-content-center">
                                <span class="mb-5">4 per correct answer</span>
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
                        <li><input type="checkbox" value="10" name="question_values[]" id="ten" /> <label for="ten" >10</label></li>
                        <li><input type="checkbox" value="2" name="question_values[]" id="two" /> <label for="two">2</label></li>
                        <li><input type="checkbox" value="5" name="question_values[]" id="five" /> <label for="five" >5</label></li>
                        <li><input type="checkbox" value="3" name="question_values[]" checked id="three" /> <label for="three">3</label></li>
                        <li><input type="checkbox" value="4" name="question_values[]" checked id="four" /> <label for="four">4</label></li>
                        <li><input type="checkbox" value="8" name="question_values[]" id="eight" /> <label for="eight">8</label></li>
                        <li><input type="checkbox" value="6" name="question_values[]" id="six" /> <label for="six">6</label></li>
                        <li><input type="checkbox" value="7" name="question_values[]" id="seven" /> <label for="seven">7</label></li>
                        <li><input type="checkbox" value="9" name="question_values[]" id="nine" /> <label for="nine">9</label></li>
                        <li><input type="checkbox" value="11" name="question_values[]" id="eleven" /> <label for="eleven">11</label></li>
                        <li><input type="checkbox" value="12" name="question_values[]" id="twelve" /> <label for="twelve" >12</label></li>
                        <li><input type="checkbox" value="13" name="question_values[]" id="thirteen" /> <label for="thirteen" >13</label></li>
                        <li><input type="checkbox" value="14" name="question_values[]" id="fourteen" /> <label for="fourteen" >14</label></li>
                        <li><input type="checkbox" value="15" name="question_values[]" id="fifteen" /> <label for="fifteen" >15</label></li>
                        <li><input type="checkbox" value="16" name="question_values[]" id="sixteen" /> <label for="sixteen" >16</label></li>
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