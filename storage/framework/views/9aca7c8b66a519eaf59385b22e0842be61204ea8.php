<?php
if (empty($authUser) and auth()->check()) {
$authUser = auth()->user();
}

$navBtnUrl = null;
$navBtnText = null;

if(request()->is('forums*')) {
$navBtnUrl = '/forums/create-topic';
$navBtnText = trans('update.create_new_topic');
} else {
$navbarButton = getNavbarButton(!empty($authUser) ? $authUser->role_id : null);

if (!empty($navbarButton)) {
$navBtnUrl = $navbarButton->url;
$navBtnText = $navbarButton->title;
}
}
$navbarPages = isset( $navData['navbarPages'] )? $navData['navbarPages'] : array();
$profile_navs = isset( $navData['profile_navs'] )? $navData['profile_navs'] : array();
?>

<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar1 navbar-expand-lg navbar-light top-navbar">
    <div class="<?php echo e((!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container-fluid'); ?>">
        <div class="d-flex align-items-center justify-content-between w-100">

            <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 <?php echo e((empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : ''); ?>"
               href="https://rurera.chimpstudio.co.uk/" itemprop="url">
                <?php if(!empty($generalSettings['logo'])): ?>
                <img src="<?php echo e($generalSettings['logo']); ?>" class="img-cover" alt="site logo" title="site logo"
                     width="100%" height="auto" itemprop="image" loading="eager">
                <?php endif; ?>
            </a>

            <button class="navbar-toggler navbar-order" type="button" id="navbarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content " id="navbarContent">
                <div class="navbar-toggle-header text-right d-lg-none">
                    <button class="btn-transparent" id="navbarClose">
                        <i data-feather="x" width="32" height="32"></i>
                    </button>
                </div>

                <ul class="navbar-nav mr-auto d-flex align-items-center">
                    <?php if(!empty($authUser)): ?>
                    <li class="nav-item "><a class="nav-link" href="/panel">Dashboard</a></li>
                    <?php endif; ?>

                    <?php if(!empty($navbarPages) and count($navbarPages)): ?>
                    <?php $__currentLoopData = $navbarPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navbarPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $is_menu_show = true; $is_panel = false; ?>


                        <?php if(isset( $authUser ) && $authUser->isUser()): ?>
                            <?php $is_panel = true; ?>
                            <?php if( !isset( $navbarPage['is_student_panel'] ) || $navbarPage['is_student_panel'] != 1): ?>
                                <?php $is_menu_show = false; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php if(isset( $authUser ) && $authUser->isParent()): ?>
                        <?php $is_panel = true; ?>
                        <?php if( !isset( $navbarPage['is_parent_panel'] ) || $navbarPage['is_parent_panel'] != 1): ?>
                            <?php $is_menu_show = false; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                        <?php if( (!isset( $navbarPage['is_other_panel'] ) || $navbarPage['is_other_panel'] != 1) && $is_panel == false): ?>
                            <?php $is_menu_show = false; ?>
                        <?php endif; ?>



                    <?php if( $is_menu_show == false): ?>
                        <?php continue; ?>
                    <?php endif; ?>


                    <li class="nav-item <?php echo e((isset( $navbarPage['menu_classes']) && $navbarPage['menu_classes'] != '')
                            ?$navbarPage['menu_classes'] : ''); ?><?php echo e((isset( $navbarPage['is_mega_menu']) && $navbarPage['is_mega_menu'] == 1)
                            ?' has-mega-menu' : ''); ?>">
                        <a class="nav-link" href="<?php echo e($navbarPage['link']); ?>"><?php echo e($navbarPage['title']); ?></a>

                        <?php if( (isset( $navbarPage['title']) && $navbarPage['title'] == 'Courses') &&
                        !empty($course_navigation)): ?>
                        <div class="lms-mega-menu">
                            <div class="mega-menu-head">
                                <ul class="mega-menu-nav d-flex nav">
                                    <?php $count = 1; ?>
                                    <?php $__currentLoopData = $course_navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navigation_slug => $nagivation_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($count == 1): ?>
                                    <style>
                                        :root {
                                            --category-color: #2c72af;
                                        }
                                    </style>
                                    <?php endif; ?>


                                    <li>
                                        <a href="#" data-category_color="<?php echo e($nagivation_data['color']); ?>"
                                           class="<?php echo e(($count == 1)? 'active' : ''); ?>" id="<?php echo e($navigation_slug); ?>-tab"
                                           data-toggle="tab"
                                           data-target="#<?php echo e($navigation_slug); ?>"
                                           role="tab"
                                           aria-controls="<?php echo e($navigation_slug); ?>" aria-selected="true"><?php echo e($nagivation_data['title']); ?></a>
                                    </li>
                                    <?php $count++; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </ul>
                            </div>
                            <div class="mega-menu-body tab-content">
                                <?php $count = 1; ?>
                                <?php $__currentLoopData = $course_navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navigation_slug => $nagivation_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                <div class="tab-pane fade <?php echo e(($count == 1)? 'show active' : ''); ?>"
                                     id="<?php echo e($navigation_slug); ?>" role="tabpanel"
                                     aria-labelledby="<?php echo e($navigation_slug); ?>-tab">
                                    <div class="row">

                                        <?php if( (isset( $nagivation_data['menu_data'] ) && $nagivation_data['menu_data'] !=
                                        '')): ?>
                                        <div class="col-12 col-lg-3 col-md-4">
                                            <?php echo $nagivation_data['menu_data']; ?>

                                        </div>
                                        <?php endif; ?>
                                        <?php if( isset( $nagivation_data['chapters'] ) && !empty(
                                        $nagivation_data['chapters'])): ?>
                                        <?php if( (isset( $nagivation_data['menu_data'] ) && $nagivation_data['menu_data'] !=
                                        '')): ?>
                                        <div class="col-12 col-lg-9 col-md-8">
                                            <?php else: ?>
                                            <div class="col-12 col-lg-12 col-md-12 pl-30">
                                                <?php endif; ?>
                                                <div class="row">
                                                    <?php $__currentLoopData = $nagivation_data['chapters']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapter_id =>
                                                    $chapter_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if( (isset( $nagivation_data['menu_data'] ) &&
                                                    $nagivation_data['menu_data'] != '')): ?>
                                                    <div class="col-12 col-lg-4 col-md-6">
                                                        <?php else: ?>
                                                        <div class="col-12 col-lg-3 col-md-6">
                                                            <?php endif; ?>
                                                            <div class="menu-colum-text">
                                                                <a
                                                                        href="/<?php echo e($navigation_slug); ?>/<?php echo e($chapter_data['chapter_slug']); ?>"><strong><?php echo e(isset(
                                                                        $chapter_data['chapter_title'] )?
                                                                        $chapter_data['chapter_title'] :
                                                                        ''); ?></strong></a>
                                                                <?php if( isset( $chapter_data['topics']) && !empty(
                                                                $chapter_data['topics'] ) ): ?>
                                                                <ul class="topic-list">
                                                                    <?php $topics_count = 1; ?>
                                                                    <?php $__currentLoopData = $chapter_data['topics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic_id =>
                                                                    $topic_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if( $topics_count <= 8): ?>
                                                                    <li>
                                                                        <a href="/course/<?php echo e($chapter_data['chapter_slug']); ?>#subject_<?php echo e($topic_id); ?>"><?php echo e($topic_title); ?></a>
                                                                    </li>
                                                                    <?php else: ?>
                                                                    <li style="display:none;"><a
                                                                                href="/course/<?php echo e($chapter_data['chapter_slug']); ?>#subject_<?php echo e($topic_id); ?>"><?php echo e($topic_title); ?></a>
                                                                    </li>
                                                                    <?php endif; ?>
                                                                    <?php $topics_count++; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if( count($chapter_data['topics']) > 8): ?>
                                                                    <li class="load-more"><a
                                                                                href="/course/<?php echo e($chapter_data['chapter_slug']); ?>">...</a>
                                                                    </li>
                                                                    <?php endif; ?>
                                                                </ul>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php $count++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <?php else: ?>
                                <?php if( isset( $navbarPage['submenu'] ) && $navbarPage['submenu'] != '' && (!isset(
                                $navbarPage['is_mega_menu'] ) || $navbarPage['is_mega_menu'] != 1)): ?>
                                <div class="sidenav-dropdown">
                                    <ul class="sidenav-item-collapse">
                                        <?php echo $navbarPage['submenu']; ?>

                                    </ul>
                                </div>
                                <?php endif; ?>

                                <?php if( isset( $navbarPage['is_mega_menu'] ) && $navbarPage['is_mega_menu'] == 1): ?>
                                <?php echo $navbarPage['submenu']; ?>

                                <?php endif; ?>

                                <?php endif; ?>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <?php if(!empty($authUser)): ?>
                        <li class="nav-item "><a class="nav-link" href="/panel/analytics">Analytics</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <?php if(isset( $authUser )): ?>
                <?php echo $__env->make('web.default.includes.notification-dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(isset( $authUser ) && $authUser->isUser()): ?>
                <div class="coin-counts">
                    <strong>
                        <img src="/assets/default/img/coin-img.png" alt="">
                        <?php echo e($authUser->getRewardPoints()); ?>

                    </strong>
                </div>
            <?php endif; ?>



            <div class="nav-icons-or-start-live navbar-order">
                <div class="xs-w-100 d-flex align-items-center justify-content-between">
                    <?php if(!empty($authUser)): ?>
                    <div class="d-flex">
                        <div class="border-left mx-5 mx-lg-15"></div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($authUser)): ?>


                    <div class="dropdown">
                        <a href="#!" class="navbar-user d-flex align-items-center dropdown-toggle" type="button"
                           id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <img src="<?php echo e($authUser->getAvatar()); ?>" class="rounded-circle"
                                 alt="<?php echo e($authUser->full_name); ?>" width="100%" height="auto" itemprop="image"
                                 alt="rounded circle" loading="eager" title="rounded circle">
                        </a>

                        <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                            <div class="dropdown-item user-nav-detail">
                                <img src="<?php echo e($authUser->getAvatar()); ?>" class="rounded-circle" alt="<?php echo e($authUser->full_name); ?>" width="100%" height="auto" itemprop="image"
                                 alt="rounded circle" loading="eager" title="rounded circle">
                                <span class="font-14 text-dark-blue user-name"><?php echo e($authUser->full_name); ?></span>
                                <span class="font-14 text-dark-blue user-email"><?php echo e($authUser->email); ?></span>
                                <a href="/panel" class="font-14 text-dark-blue user-manage-btn">Manage Account</a>
                            </div>
                            <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                                <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
                            </div>


                            <?php if( !empty( $profile_navs ) ): ?>
                            <div class="user-nav-list">
                            <?php $__currentLoopData = $profile_navs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile_nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <a class="dropdown-item " href="/panel/switch_user/<?php echo e($profile_nav['id']); ?>">
                                <img src="<?php echo e($profile_nav->getAvatar()); ?>" class="rounded-circle" alt="<?php echo e($profile_nav['full_name']); ?>" width="100%" height="auto" itemprop="image"
                                 alt="rounded circle" loading="eager" title="rounded circle">
								<?php $full_name = (isset( $navData['is_parent'] ) && $navData['is_parent'] == true)? 'Parent' :  $profile_nav['full_name']; ?>
                                <span class="font-14 text-dark-blue user-list-name"><?php echo e($full_name); ?></span>
                                <span class="font-14 text-dark-blue user-list-email"><?php echo e($profile_nav['email']); ?></span>
                            </a>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>

                            <a class="dropdown-item nav-logout" href="/logout">
                                <img src="/assets/default/img/icons/sidebar/logout.svg" height="auto" itemprop="image"
                                     width="25" alt="nav-icon" title="nav-icon" loading="eager">
                                <span class="font-14 text-dark-blue"><?php echo e(trans('panel.log_out')); ?></span>
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="d-flex align-items-center ml-md-50">
                        <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-14 login-btn"><?php echo e(trans('auth.login')); ?></a>
                        <a href="/register" class="py-5 px-15 text-dark-blue font-14 register-btn">Get Started</a>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</nav>

<?php $__env->startPush('scripts_bottom'); ?>
<script src="/assets/default/js/parts/navbar.min.js"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH E:\XAMPP_7.4.2\htdocs\rurera\resources\views/web/default/includes/navbar.blade.php ENDPATH**/ ?>