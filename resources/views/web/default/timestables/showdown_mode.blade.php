<section class="p-25 panel-border border-radius-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-30 text-center"><h2>Select Practice Time </h2></div>
            </div>
            <div class="col-12 col-lg-12 mx-auto">
                User Current ranking : {{$user_rank}}
                <form action="/timestables/generate_showdown_mode" method="post">
                    {{ csrf_field() }}
                    <h3>It will be five minutes, try to answer the maximum questions.</h3>

                    <div class="form-btn">
                        <button type="submit" class="questions-submit-btn btn"><span>Play</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>