<section class="p-25 panel-border border-radius-10">
    <div class="container">
        <div class="row">
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