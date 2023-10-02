<div class="product-card">
    <figure>
        <div class="image-box">
            <a href="{{ $product->getUrl() }}" class="image-box__a">
                @php
                    $hasDiscount = $product->getActiveDiscount();
                @endphp

                @if($product->getAvailability() < 1)
                    <span class="out-of-stock-badge">
                    <span>{{ trans('update.out_of_stock') }}</span>
                </span>
                @elseif($hasDiscount)
                <span class="badge badge-danger">{{ trans('public.offer',['off' => $hasDiscount->percent]) }}</span>
                @elseif($product->isPhysical() and empty($product->delivery_fee))
                    <span class="badge badge-warning">{{ trans('update.free_shipping') }}</span>
                @endif

                <img src="{{ $product->thumbnail }}" class="img-cover" width="160" height="160" alt="{{ $product->title }}">
            </a>
        </div>

        <figcaption class="product-card-body">
            
            <a href="{{ $product->getUrl() }}">
                <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue">{{ $product->title,'title' }}</h3>
            </a>

            <div class="product-price-box mt-25">
                <span class="real font-14"><i data-feather="zap" width="20" height="20" class=""></i> {{ $product->point }} Coins</span>
            </div>
        </figcaption>
        <button type="button" class="cart-button"><a  class="bt-button" href="{{ $product->getUrl() }}">BUY</a></button>
    </figure>
</div>
