<div class="product-card">
    <figure>
        <div class="image-box">
            <a href="<?php echo e($product->getUrl()); ?>" class="image-box__a">
                <?php
                    $hasDiscount = $product->getActiveDiscount();
                ?>

                <?php if($product->getAvailability() < 1): ?>
                    <span class="out-of-stock-badge">
                    <span><?php echo e(trans('update.out_of_stock')); ?></span>
                </span>
                <?php elseif($hasDiscount): ?>
                <span class="badge badge-danger"><?php echo e(trans('public.offer',['off' => $hasDiscount->percent])); ?></span>
                <?php elseif($product->isPhysical() and empty($product->delivery_fee)): ?>
                    <span class="badge badge-warning"><?php echo e(trans('update.free_shipping')); ?></span>
                <?php endif; ?>

                <img src="<?php echo e($product->thumbnail); ?>" class="img-cover" alt="<?php echo e($product->title); ?>">
            </a>
        </div>

        <figcaption class="product-card-body">
            
            <a href="<?php echo e($product->getUrl()); ?>">
                <h3 class="mt-15 product-title font-weight-bold font-16 text-dark-blue"><?php echo e($product->title,'title'); ?></h3>
            </a>

            <div class="product-price-box mt-25">
                <span class="real font-14"><i data-feather="zap" width="20" height="20" class=""></i> <?php echo e($product->point); ?> Coins</span>
            </div>
        </figcaption>
        <button type="button" class="cart-button"><a  class="bt-button" href="<?php echo e($product->getUrl()); ?>">BUY</a></button>
    </figure>
</div>
<?php /**PATH E:\XAMPP_7.4.2\htdocs\rurera\resources\views/web/default/products/includes/card.blade.php ENDPATH**/ ?>