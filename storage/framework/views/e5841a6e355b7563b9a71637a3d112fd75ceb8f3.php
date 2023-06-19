<div class="blog-grid-card"  itemscope itemtype="https://schema.org/NewsArticle">
    <div class="blog-grid-detail">
        <span class="badge created-at d-flex align-items-center">
            <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
            <span  itemprop="datePublished" content="2023-04-05T08:00:00+08:00"><?php echo e(dateTimeFormat($post->created_at, 'j M Y')); ?></span>
        </span>
        <a itemprop="url" href="<?php echo e($post->getUrl()); ?>">
            <h2 class="blog-grid-title mt-10" itemprop="title"><?php echo e($post->title); ?></h2>
        </a>

        <div class="mt-20 blog-grid-desc" itemprop="description"><?php echo truncate(strip_tags($post->description), 200); ?></div>
        <?php
            $meta_description = explode(',', $post->meta_description);
            if( !empty( $meta_description ) ){

            }

        ?>

        <?php if( !empty( $meta_description )): ?>
        <ul class="blog-tags">
            <?php $__currentLoopData = $meta_description; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meta_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(trim($meta_title) != ''): ?>
                    <li itemprop="name"><?php echo e(trim($meta_title)); ?></li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endif; ?>
    </div>
    <div class="blog-grid-image">
        <img src="<?php echo e($post->image); ?>" class="img-cover" alt="<?php echo e($post->title); ?>" title="<?php echo e($post->title); ?>" width="100%" height="auto" itemprop="image" loading="eager">
    </div>

</div>
<?php /**PATH E:\XAMPP_7.4.2\htdocs\rurera\resources\views/web/default/blog/grid-list.blade.php ENDPATH**/ ?>