<figure>
    <div class="image-box">
        <a href="{{ $product->getUrl() }}" class="image-box__a" itemprop="url">
            <img src="{{ $product->thumbnail }}" class="img-cover" width="160" height="160" alt="{{ $product->title }}" itemprop="image">
        </a>
    </div>

    <figcaption class="product-card-body">

        <a href="{{ $product->getUrl() }}" itemprop="url">
            <h3 class="product-title font-weight-bold font-18" itemprop="title">{{ $product->title,'title' }}</h3>
        </a>


        @if( ($product->point - $authUser->getRewardPoints()) > 0)
        <div class="product-price-box mt-15">
            <span class="real" itemprop="price"><i data-feather="zap" width="20" height="20" class=""></i> {{ ($product->point - $authUser->getRewardPoints()) }} Coins Remaining</span>
        </div>
        @endif
    </figcaption>
    @if( ($product->point - $authUser->getRewardPoints()) < 1)
    <button type="button" class="cart-button" itemprop="Cart Button"><a  class="bt-button" href="{{ $product->getUrl() }}" itemprop="url">BUY</a></button>
    @endif

</figure>