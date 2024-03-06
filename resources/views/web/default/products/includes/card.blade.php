<div class="product-card">
    <figure>
        <div class="image-box">
            <a href="{{ $product->getUrl() }}" class="image-box__a" itemprop="url">
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

                <img src="{{ $product->thumbnail }}" class="img-cover" width="160" height="160" alt="{{ $product->title }}" itemprop="image">
            </a>
            @if(in_array($product->id, $shortlisted_products))
                <a href="javascript:;" class="favorite-btn shortlist-btn" data-type="remove" data-product_id="{{ $product->id }}">
                    <img class="heart-fill" src="/assets/default/svgs/heart-fill.svg" height="30" width="30" alt="">
                </a>
            @else
                <a href="javascript:;" class="favorite-btn shortlist-btn" data-type="add" data-product_id="{{ $product->id }}">
                    <img class="heart-alt" src="/assets/default/svgs/heart-alt.svg" height="30" width="30" alt="">
                </a>
            @endif
        </div>

        <figcaption class="product-card-body">
            
            <a href="{{ $product->getUrl() }}" itemprop="url">
                <h3 class="product-title font-weight-bold font-18" itemprop="title">{{ $product->title,'title' }}</h3>
            </a>

            <div class="product-price-box mt-15">
                <span class="real" itemprop="price"><i data-feather="zap" width="20" height="20" class=""></i> {{ $product->point }} Coins</span>
            </div>
        </figcaption>
        <button type="button" class="cart-button" itemprop="Cart Button"><a  class="bt-button" href="{{ $product->getUrl() }}" itemprop="url">BUY</a></button>
    </figure>
</div>
