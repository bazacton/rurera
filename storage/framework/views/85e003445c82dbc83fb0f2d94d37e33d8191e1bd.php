<div class="categories-boxes">
    <div class="categories-card">
        <span class="topic-numbers" style="background-color: #fff; color: #27325e;"><?php echo e(trans('webinars.'.$webinar->type)); ?></span>
        <div class="categories-icon"" style="background:<?php echo e($webinar->background_color); ?>">
            <?php echo $webinar->icon_code; ?>

        </div>
        <a href="<?php echo e($webinar->getUrl()); ?>">
            <h4 class="categories-title"><?php echo e(clean($webinar->title,'title')); ?></h4>
        </a>
    </div>
</div>


<?php /**PATH E:\XAMPP_7.4.2\htdocs\rurera\resources\views/web/default/includes/webinar/grid-card.blade.php ENDPATH**/ ?>