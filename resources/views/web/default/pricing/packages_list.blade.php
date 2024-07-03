@php use App\Models\Subscribe;
$packages_only = isset( $packages_only )? $packages_only : array();
if( empty( $subscribes )){
	$subscribes = Subscribe::where('id', '>', 0);
	if( !empty($packages_only)){
		$subscribes = $subscribes->whereIn('id', $packages_only);
	}
	$subscribes = $subscribes->get();
	
}


$selected_package = isset( $selected_package )? $selected_package : 0; $subscribed_childs = isset( $subscribed_childs )? $subscribed_childs : 0; $purchase_title = ( $subscribed_childs == 0)? 'Try for free' : 'Subscribe'; 
@endphp
@if(!empty($subscribes) and !$subscribes->isEmpty())
@foreach($subscribes as $subscribe)
@php 
$purchase_title = ( $subscribed_childs == 0)? 'Try for free' : 'Subscribe'; 
$is_subscribed = (isset( $selected_package ) && $selected_package == $subscribe->id)? true : false; 
$purchase_title = ($is_subscribed == true)? 'Subscribed' : $purchase_title;
$subscribe_btn_class = ($is_subscribed == true)? 'disabled-style disabled-div' : '';
$user_subscribed_for = isset( $user_subscribed_for)? $user_subscribed_for : 1;
$selection_class = (auth()->user())? 'package-selection' : 'subscription-modal';
$packages_count = $subscribes->count();
$element_class = ($packages_count < 3)? 'col-lg-6 col-md-6 col-sm-12' : 'col-lg-4 col-md-6 col-sm-12';
$element_class = ($packages_count < 2)? 'col-lg-12 col-md-12 col-sm-12' : $element_class;
$show_details = isset( $show_details )? $show_details : true;
@endphp
<div class="{{$element_class}}">
    <div class="subscribe-plan {{(isset( $selected_package ) && $selected_package == $subscribe->id)? 'active' : ''}} current-plan position-relative d-flex flex-column rounded-lg pb-25 pt-40 px-20 mb-30">
        <span class="subscribe-icon mb-20"><img src="{{ $subscribe->icon }}" height="auto" width="auto" alt="Box image"/></span>
        <div class="subscribe-title text-left">
            <h3 itemprop="title" class="font-24 font-weight-500 text-left">{{ $subscribe->title }}</h3>
			<p>{{ $subscribe->description }}</p>
        </div>
        <div class="d-flex align-items-start text-dark-charcoal mb-20 subscribe-price">
            <span itemprop="price" class="font-36 line-height-1 packages-prices" data-package_id="{{$subscribe->id}}" data-package_price="{{$subscribe->price}}">{{ addCurrencyToPrice($subscribe->price) }}</span><span
                    class="yearly-price">{{ addCurrencyToPrice($subscribe->price) }} / month</span>
        </div>
        <button itemprop="button" type="submit" data-user_id="{{isset($childObj->id)?$childObj->id : 0}}" data-type="package_selection" data-id="{{$subscribe->id}}"
                class="{{$selection_class}} btn w-100 {{$subscribe_btn_class}}">{{$purchase_title}}
        </button>
		
		@if($show_details === true)
		
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
		@endif
    </div>
</div>
@endforeach
@endif

<script type="text/javascript">

    $(document).on('change', '.subscribed_for-field', function (e) {
		var user_subscribed_for = $(".package-register-form").attr('data-user_subscribed_for');
		var selected_package = '{{$selected_package}}';
        var package_month = 1;
        var package_discount = 0;
        if($(this).is(':checked')) {
            package_month = 12;
            package_discount = 25;
        }
        var currency_sign = $(".lms-membership-section").attr('data-currency_sign');
		$('.subscribe-plan').find('.package-selection').removeClass('disabled-style');
		$('.subscribe-plan').find('.package-selection').removeClass('disabled-div');
        $(".packages-prices").each(function(){
           var package_price = $(this).attr('data-package_price');
		   var package_id = $(this).attr('data-package_id');
		   
		   if(package_id == selected_package && user_subscribed_for == package_month){
			   $(this).closest('.subscribe-plan').find('.package-selection').addClass('disabled-style');
			   $(this).closest('.subscribe-plan').find('.package-selection').addClass('disabled-div');
		   }
		   
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
	$(".subscribed_for-field").change();
</script>