
<div class="lms-choose-plan d-flex mb-30">
    <div class="lms-choose-field">
        <form class="subscription-tenure-form" method="post" action="javascript:;">
            {{ csrf_field() }}
            <strong class="choose-title d-block mb-20 font-24">Choose a plan</strong>
            <div class="lms-radio-select">
                <ul class="lms-radio-btn-group d-inline-flex align-items-center">
                    <li>
                        <input type="radio" id="month" value="1" data-discount="0"
                               name="subscribe_for" checked="checked"/>
                        <label class="lms-label" for="month">
                            <span>01 month</span>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="three_months" value="3" data-discount="5"
                               name="subscribe_for"/>
                        <label class="lms-label" for="three_months">
                            <span>03 month <span>(5%)</span> </span>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="six_months" value="6" data-discount="10"
                               name="subscribe_for"/>
                        <label class="lms-label" for="six_months">
                            <span>06 month <span>(10%)</span> </span>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="year" value="12" data-discount="20"
                               name="subscribe_for"/>
                        <label class="lms-label" for="year">
                            <span>whole year <span>(20%)</span></span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="form-group">
                <a href="javascript:;" class="nav-link btn-primary rounded-pill mb-25 text-center subscription-tenure-btn">
                    Next
                </a>
            </div>
        </form>
    </div>
</div>
<script>
    $('meta[name="csrf-token"]').attr('content', '{{$csrf_token}}');
</script>