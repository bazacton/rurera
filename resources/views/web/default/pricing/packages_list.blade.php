@if(!empty($subscribes) and !$subscribes->isEmpty())
@foreach($subscribes as $subscribe)
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="subscribe-plan {{(isset( $selected_package ) && $selected_package == $subscribe->id)? 'active' : ''}} current-plan position-relative d-flex flex-column rounded-lg pb-25 pt-60 px-20 mb-30">
        <span class="subscribe-icon mb-20"><img src="{{ $subscribe->icon }}" height="auto" width="auto" alt="Box image"/></span>
        <div class="subscribe-title">
            <h3 itemprop="title" class="font-24 font-weight-500">{{ $subscribe->title }}</h3>
        </div>
        <div class="d-flex align-items-start text-dark-charcoal mt-10 subscribe-price">
            <span itemprop="price" class="font-36 line-height-1 packages-prices" data-package_price="{{$subscribe->price}}">{{ addCurrencyToPrice($subscribe->price) }}</span><span
                    class="yearly-price">{{ addCurrencyToPrice($subscribe->price) }} / month</span>
        </div>
        <button itemprop="button" type="submit" data-user_id="{{isset($childObj->id)?$childObj->id : 0}}" data-type="package_selection" data-id="{{$subscribe->id}}"
                class="package-selection btn w-100">Try for free
        </button>
        <span class="plan-label d-block font-weight-500 pt-20">
                                            Suitable for:
                                        </span>
        <ul class="mt-10 plan-feature">
            <li class="mt-10">Grammar school entrance</li>
            <li class="mt-10">Independent school entrance</li>
        </ul>
        <span class="plan-label d-block font-weight-500 pt-20">
                                            Subjects:
                                        </span>
        <ul class="mt-10 plan-feature">
            @php $is_available = ($subscribe->is_courses > 0)? '' : 'subscribe-no'; @endphp
            <li class="mt-10 {{$is_available}}">English, Maths, Science , Computer</li>
            <li class="mt-10 {{$is_available}}">Verbal reasoning, non-verbal reasoning</li>
            @php $is_available = ($subscribe->is_timestables > 0)? '' : 'subscribe-no'; @endphp
            <li class="mt-10 {{$is_available}}">Times Tables Practice</li>
            @php $is_available = ($subscribe->is_vocabulary > 0)? '' : 'subscribe-no'; @endphp
            <li class="mt-10 {{$is_available}}">Vocabulary</li>
            @php $is_available = ($subscribe->is_bookshelf > 0)? '' : 'subscribe-no'; @endphp
            <li class="mt-10 {{$is_available}}">Bookshelf</li>
        </ul>
        <span class="plan-label d-block font-weight-500 pt-20">
                                            Mock Tests Prep:
                                        </span>
        <ul class="mt-10 plan-feature">
            @php $is_available = ($subscribe->is_sats > 0)? '' : 'subscribe-no'; @endphp
            <li class="mt-10 {{$is_available}}">SATs</li>
            @php $is_available = ($subscribe->is_elevenplus > 0)? '' : 'subscribe-no'; @endphp
            <li class="mt-10 {{$is_available}}">ISEB Common Pre-Tests</li>
            <li class="mt-10 {{$is_available}}">GL 11+</li>
            <li class="mt-10 {{$is_available}}">CAT4</li>
        </ul>
    </div>
</div>
@endforeach
@endif

<script type="text/javascript">

    $(document).on('change', '.subscribed_for-field', function (e) {
        var package_month = 1;
        var package_discount = 0;
        if($(this).is(':checked')) {
            package_month = 12;
            package_discount = 25;
        }
        var currency_sign = $(".lms-membership-section").attr('data-currency_sign');
        console.log(package_month);
        $(".packages-prices").each(function(){
           var package_price = $(this).attr('data-package_price');
            var package_price_org = package_price;
           var discount_price = parseFloat(parseFloat(package_price))*package_discount / 100;
           var package_price = parseFloat(parseFloat(package_price))-discount_price;
           //var package_price = parseInt(package_price)*package_month;
           package_price_label = currency_sign+parseFloat(parseFloat(package_price).toFixed(2));
           if( package_month == 12) {
               var yearly_price = package_price * 12;
               yearly_price = parseFloat(parseFloat(yearly_price).toFixed(2));
               $(this).closest('.subscribe-price').find('.yearly-price').html(currency_sign + yearly_price + ' billed yearly');
           }else{
               var without_discount = package_price_org*12;
               var discount_price = parseFloat(parseFloat(package_price))*25 / 100;
               var yearly_price = parseFloat(parseFloat(package_price_org))-discount_price;
               yearly_price = without_discount-(yearly_price*12);
               yearly_price = parseFloat(parseFloat(yearly_price).toFixed(2));
               $(this).closest('.subscribe-price').find('.yearly-price').html('Save '+currency_sign+yearly_price+' with a yearly plan');
           }


           $(this).html(package_price_label+'/mo');
        });
    });
</script>