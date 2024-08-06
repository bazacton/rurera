@php
    $getPanelSidebarSettings = getPanelSidebarSettings();
@endphp


<div class="panel-sidebar px-25 pt-15" id="panelSidebar" style="position: inherit;top: 0px;">
    <button class="btn-transparent panel-sidebar-close sidebarNavToggle">
        <i data-feather="align-justify" width="24" height="24"></i>
        <i data-feather="x" width="24" height="24"></i>
    </button>

    <div class="user-info d-flex align-items-center flex-row flex-lg-column justify-content-lg-center">
        <a href="/panel">
            <img src="{{ $generalSettings['logo'] }}" class="img-cover" alt="LMS">
        </a>
    </div>


    <div class="nav-icons-or-start-live navbar-order">
                    <div class="xs-w-100 d-flex align-items-center justify-content-between ">
                        @if(!empty($authUser))
                        <div class="d-flex">
                            <div class="border-left mx-5 mx-lg-15"></div>
                        </div>
                        @endif

                        @if(!empty($authUser))


                        <div class="dropdown">
                            <a href="#!" class="navbar-user d-flex align-items-center ml-50 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <img src="{{ $authUser->getAvatar() }}" class="rounded-circle" alt="{{ $authUser->get_full_name() }}" width="100%" height="auto" itemprop="image" alt="rounded circle" loading="eager" title="rounded circle">
                                <span class="font-16 user-name ml-10 text-dark-blue font-16">{{ $authUser->get_full_name() }}</span>
                            </a>

                            <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                                <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                                    <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
                                </div>

                                <a class="dropdown-item" href="{{ $authUser->isAdmin() ? '/admin' : '/panel' }}">
                                    <img src="/assets/default/img/icons/sidebar/dashboard.svg" width="25" height="auto" itemprop="image" alt="nav-icon" title="nav-icon" loading="eager">
                                    <span class="font-16 text-dark-blue">{{ trans('public.my_panel') }}</span>
                                </a>
                                @if($authUser->isTeacher() or $authUser->isOrganization())
                                <a class="dropdown-item" href="{{ $authUser->getProfileUrl() }}">
                                    <img src="/assets/default/img/icons/profile.svg" width="25" height="auto" itemprop="image" alt="nav-icon"  title="nav-icon" loading="eager">
                                    <span class="font-16 text-dark-blue">{{ trans('publimc.y_profile') }}</span>
                                </a>
                                @endif
                                <a class="dropdown-item" href="/logout">
                                    <img src="/assets/default/img/icons/sidebar/logout.svg" height="auto" itemprop="image" width="25" alt="nav-icon"  title="nav-icon" loading="eager">
                                    <span class="font-16 text-dark-blue">{{ trans('panel.log_out') }}</span>
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center ml-md-50">
                            <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-16 login-btn">{{ trans('auth.login') }}</a>
                            <a href="/register" class="py-5 px-15 text-dark-blue font-16 register-btn">Get Started</a>
                        </div>
                        @endif
                    </div>

                </div>


    <ul class="sidebar-menu pt-10 @if(!empty($authUser->userGroup)) has-user-group @endif @if(empty($getPanelSidebarSettings) or empty($getPanelSidebarSettings['background'])) without-bottom-image @endif" @if((!empty($isRtl) and $isRtl)) data-simplebar-direction="rtl" @endif>

        <li class="sidenav-item {{ (request()->is('panel')) ? 'sidenav-item-active' : '' }}">
            <a href="/panel" class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.dashboard')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.dashboard') }}</span>
            </a>
        </li>

        @if($authUser->isOrganization())
            <li class="sidenav-item {{ (request()->is('panel/instructors') or request()->is('panel/manage/instructors*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.teachers')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('public.instructors') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/instructors') or request()->is('panel/manage/instructors*')) ? 'show' : '' }}" id="instructorsCollapse">
                    <ul class="sidenav-item-collapse">
                        <li class="mt-5 {{ (request()->is('panel/instructors/new')) ? 'active' : '' }}">
                            <a href="/panel/manage/instructors/new">{{ trans('public.new') }}</a>
                        </li>
                        <li class="mt-5 {{ (request()->is('panel/manage/instructors')) ? 'active' : '' }}">
                            <a href="/panel/manage/instructors">{{ trans('public.list') }}</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidenav-item {{ (request()->is('panel/students') or request()->is('panel/manage/students*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.students')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('quiz.students') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/students') or request()->is('panel/manage/students*')) ? 'show' : '' }}" id="studentsCollapse">
                    <ul class="sidenav-item-collapse">
                        <li class="mt-5 {{ (request()->is('panel/manage/students/new')) ? 'active' : '' }}">
                            <a href="/panel/manage/students/new">{{ trans('public.new') }}</a>
                        </li>
                        <li class="mt-5 {{ (request()->is('panel/manage/students')) ? 'active' : '' }}">
                            <a href="/panel/manage/students">{{ trans('public.list') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        <li class="sidenav-item {{ (request()->is('panel/webinars') or request()->is('panel/webinars/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.webinars')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.webinars') }}</span>
            </a>

            <div class="sidenav-dropdown {{ (request()->is('panel/webinars') or request()->is('panel/webinars/*')) ? 'show' : '' }}" id="webinarCollapse">
                <ul class="sidenav-item-collapse">
                    @if($authUser->isOrganization() || $authUser->isTeacher())
                        <li class="mt-5 {{ (request()->is('panel/webinars/new')) ? 'active' : '' }}">
                            <a href="/panel/webinars/new">{{ trans('public.new') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/webinars')) ? 'active' : '' }}">
                            <a href="/panel/webinars">{{ trans('panel.my_classes') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/webinars/invitations')) ? 'active' : '' }}">
                            <a href="/panel/webinars/invitations">{{ trans('panel.invited_classes') }}</a>
                        </li>
                    @endif

                    @if(!empty($authUser->organ_id))
                        <li class="mt-5 {{ (request()->is('panel/webinars/organization_classes')) ? 'active' : '' }}">
                            <a href="/panel/webinars/organization_classes">{{ trans('panel.organization_classes') }}</a>
                        </li>
                    @endif

                    <li class="mt-5 {{ (request()->is('panel/webinars/purchases')) ? 'active' : '' }}">
                        <a href="/panel/webinars/purchases">{{ trans('panel.my_purchases') }}</a>
                    </li>

                    @if($authUser->isOrganization() || $authUser->isTeacher())
                        <li class="mt-5 {{ (request()->is('panel/webinars/comments')) ? 'active' : '' }}">
                            <a href="/panel/webinars/comments">{{ trans('panel.my_class_comments') }}</a>
                        </li>
                    @endif

                    <li class="mt-5 {{ (request()->is('panel/webinars/my-comments')) ? 'active' : '' }}">
                        <a href="/panel/webinars/my-comments">{{ trans('panel.my_comments') }}</a>
                    </li>

                    <li class="mt-5 {{ (request()->is('panel/webinars/favorites')) ? 'active' : '' }}">
                        <a href="/panel/webinars/favorites">{{ trans('panel.favorites') }}</a>
                    </li>
                </ul>
            </div>
        </li>

        @if($authUser->isOrganization() or $authUser->isTeacher())
            <li class="sidenav-item {{ (request()->is('panel/bundles') or request()->is('panel/bundles/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-fill mr-10">
                    @include('web.default.panel.includes.sidebar_icons.bundles')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.bundles') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/bundles') or request()->is('panel/bundles/*')) ? 'show' : '' }}" id="bundlesCollapse">
                    <ul class="sidenav-item-collapse">
                        <li class="mt-5 {{ (request()->is('panel/bundles/new')) ? 'active' : '' }}">
                            <a href="/panel/bundles/new">{{ trans('public.new') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/bundles')) ? 'active' : '' }}">
                            <a href="/panel/bundles">{{ trans('update.my_bundles') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if(getFeaturesSettings('webinar_assignment_status'))
            <li class="sidenav-item {{ (request()->is('panel/assignments') or request()->is('panel/custom_quiz/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.assignments')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.assignments') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/assignments') or request()->is('panel/custom_quiz/*')) ? 'show' : '' }}" id="assignmentCollapse">
                    <ul class="sidenav-item-collapse">

                        <li class="mt-5 {{ (request()->is('panel/custom_quiz/my-assignments')) ? 'active' : '' }}">
                            <a href="/panel/custom_quiz/my-assignments">{{ trans('update.my_assignments') }}</a>
                        </li>

                        @if($authUser->isOrganization() || $authUser->isTeacher())
                            <li class="mt-5 {{ (request()->is('panel/custom_quiz/my-courses-assignments')) ? 'active' : '' }}">
                                <a href="/panel/custom_quiz/my-courses-assignments">{{ trans('update.students_assignments') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif


        <li class="sidenav-item {{ (request()->is('panel/meetings') or request()->is('panel/meetings/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.requests')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.meetings') }}</span>
            </a>

            <div class="sidenav-dropdown {{ (request()->is('panel/meetings') or request()->is('panel/meetings/*')) ? 'show' : '' }}" id="meetingCollapse">
                <ul class="sidenav-item-collapse">

                    <li class="mt-5 {{ (request()->is('panel/meetings/reservation')) ? 'active' : '' }}">
                        <a href="/panel/meetings/reservation">{{ trans('public.my_reservation') }}</a>
                    </li>

                    @if($authUser->isOrganization() || $authUser->isTeacher())
                        <li class="mt-5 {{ (request()->is('panel/meetings/requests')) ? 'active' : '' }}">
                            <a href="/panel/meetings/requests">{{ trans('panel.requests') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/meetings/settings')) ? 'active' : '' }}">
                            <a href="/panel/meetings/settings">{{ trans('panel.settings') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>

        <li class="sidenav-item {{ (request()->is('panel/quizzes') or request()->is('panel/quizzes/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.quizzes')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.quizzes') }}</span>
            </a>

            <div class="sidenav-dropdown {{ (request()->is('panel/quizzes') or request()->is('panel/quizzes/*')) ? 'show' : '' }}" id="quizzesCollapse">
                <ul class="sidenav-item-collapse">
                    @if($authUser->isOrganization() || $authUser->isTeacher())
                        <li class="mt-5 {{ (request()->is('panel/quizzes/new')) ? 'active' : '' }}">
                            <a href="/panel/quizzes/new">{{ trans('quiz.new_quiz') }}</a>
                        </li>
                        <li class="mt-5 {{ (request()->is('panel/quizzes')) ? 'active' : '' }}">
                            <a href="/panel/quizzes">{{ trans('public.list') }}</a>
                        </li>
                        <li class="mt-5 {{ (request()->is('panel/quizzes/results')) ? 'active' : '' }}">
                            <a href="/panel/quizzes/results">{{ trans('public.results') }}</a>
                        </li>
                    @endif

                    <li class="mt-5 {{ (request()->is('panel/quizzes/my-results')) ? 'active' : '' }}">
                        <a href="/panel/quizzes/my-results">{{ trans('public.my_results') }}</a>
                    </li>

                    <li class="mt-5 {{ (request()->is('panel/quizzes/opens')) ? 'active' : '' }}">
                        <a href="/panel/quizzes/opens">{{ trans('public.not_participated') }}</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="sidenav-item {{ (request()->is('panel/certificates') or request()->is('panel/certificates/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.certificate')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.certificates') }}</span>
            </a>

            <div class="sidenav-dropdown {{ (request()->is('panel/certificates') or request()->is('panel/certificates/*')) ? 'show' : '' }}" id="certificatesCollapse">
                <ul class="sidenav-item-collapse">
                    @if($authUser->isOrganization() || $authUser->isTeacher())
                        <li class="mt-5 {{ (request()->is('panel/certificates')) ? 'active' : '' }}">
                            <a href="/panel/certificates">{{ trans('public.list') }}</a>
                        </li>
                    @endif

                    <li class="mt-5 {{ (request()->is('panel/certificates/achievements')) ? 'active' : '' }}">
                        <a href="/panel/certificates/achievements">{{ trans('quiz.achievements') }}</a>
                    </li>

                    <li class="mt-5">
                        <a href="/certificate_validation">{{ trans('site.certificate_validation') }}</a>
                    </li>

                    <li class="mt-5 {{ (request()->is('panel/certificates/webinars')) ? 'active' : '' }}">
                        <a href="/panel/certificates/webinars">{{ trans('update.course_certificates') }}</a>
                    </li>

                </ul>
            </div>
        </li>

            <li class="sidenav-item {{ (request()->is('panel/store') or request()->is('panel/store/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-fill mr-10">
                    @include('web.default.panel.includes.sidebar_icons.store')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.store') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/store') or request()->is('panel/store/*')) ? 'show' : '' }}" id="storeCollapse">
                    <ul class="sidenav-item-collapse">
                        @if($authUser->isOrganization() || $authUser->isTeacher())
                            <li class="mt-5 {{ (request()->is('panel/store/products/new')) ? 'active' : '' }}">
                                <a href="/panel/store/products/new">{{ trans('update.new_product') }}</a>
                            </li>

                            <li class="mt-5 {{ (request()->is('panel/store/products')) ? 'active' : '' }}">
                                <a href="/panel/store/products">{{ trans('update.products') }}</a>
                            </li>

                            @php
                                $sellerProductOrderWaitingDeliveryCount = $authUser->getWaitingDeliveryProductOrdersCount();
                            @endphp

                            <li class="mt-5 {{ (request()->is('panel/store/sales')) ? 'active' : '' }}">
                                <a href="/panel/store/sales">{{ trans('panel.sales') }}</a>

                                @if($sellerProductOrderWaitingDeliveryCount > 0)
                                    <span class="d-inline-flex align-items-center justify-content-center font-weight-500 ml-15 panel-sidebar-store-sales-circle-badge">{{ $sellerProductOrderWaitingDeliveryCount }}</span>
                                @endif
                            </li>

                        @endif

                        <li class="mt-5 {{ (request()->is('panel/store/purchases')) ? 'active' : '' }}">
                            <a href="/panel/store/purchases">{{ trans('panel.my_purchases') }}</a>
                        </li>

                        @if($authUser->isOrganization() || $authUser->isTeacher())
                            <li class="mt-5 {{ (request()->is('panel/store/products/comments')) ? 'active' : '' }}">
                                <a href="/panel/store/products/comments">{{ trans('update.product_comments') }}</a>
                            </li>
                        @endif

                        <li class="mt-5 {{ (request()->is('panel/store/products/my-comments')) ? 'active' : '' }}">
                            <a href="/panel/store/products/my-comments">{{ trans('panel.my_comments') }}</a>
                        </li>
                    </ul>
                </div>
            </li>

        <li class="sidenav-item {{ (request()->is('panel/financial') or request()->is('panel/financial/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.financial')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.financial') }}</span>
            </a>

            <div class="sidenav-dropdown {{ (request()->is('panel/financial') or request()->is('panel/financial/*')) ? 'show' : '' }}" id="financialCollapse">
                <ul class="sidenav-item-collapse">

                    @if($authUser->isOrganization() || $authUser->isTeacher())
                        <li class="mt-5 {{ (request()->is('panel/financial/sales')) ? 'active' : '' }}">
                            <a href="/panel/financial/sales">{{ trans('financial.sales_report') }}</a>
                        </li>
                    @endif

                    <li class="mt-5 {{ (request()->is('panel/financial/summary')) ? 'active' : '' }}">
                        <a href="/panel/financial/summary">{{ trans('financial.financial_summary') }}</a>
                    </li>

                    <li class="mt-5 {{ (request()->is('panel/financial/payout')) ? 'active' : '' }}">
                        <a href="/panel/financial/payout">{{ trans('financial.payout') }}</a>
                    </li>

                    <li class="mt-5 {{ (request()->is('panel/financial/account')) ? 'active' : '' }}">
                        <a href="/panel/financial/account">{{ trans('financial.charge_account') }}</a>
                    </li>

                    <li class="mt-5 {{ (request()->is('panel/financial/subscribes')) ? 'active' : '' }}">
                        <a href="/panel/financial/subscribes">{{ trans('financial.subscribes') }}</a>
                    </li>

                    @if(($authUser->isOrganization() || $authUser->isTeacher()) and getRegistrationPackagesGeneralSettings('status'))
                        <li class="mt-5 {{ (request()->is('panel/financial/registration-packages')) ? 'active' : '' }}">
                            <a href="{{ route('panelRegistrationPackagesLists') }}">{{ trans('update.registration_packages') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </li>

        <li class="sidenav-item {{ (request()->is('panel/support') or request()->is('panel/support/*')) ? 'sidenav-item-active' : '' }}">
            <a class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-fill mr-10">
                    @include('web.default.panel.includes.sidebar_icons.support')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.support') }}</span>
            </a>

            <div class="sidenav-dropdown {{ (request()->is('panel/support') or request()->is('panel/support/*')) ? 'show' : '' }}" id="supportCollapse">
                <ul class="sidenav-item-collapse">
                    <li class="mt-5 {{ (request()->is('panel/support/new')) ? 'active' : '' }}">
                        <a href="/panel/support/new">{{ trans('public.new') }}</a>
                    </li>
                    <li class="mt-5 {{ (request()->is('panel/support')) ? 'active' : '' }}">
                        <a href="/panel/support">{{ trans('panel.classes_support') }}</a>
                    </li>
                    <li class="mt-5 {{ (request()->is('panel/support/tickets')) ? 'active' : '' }}">
                        <a href="/panel/support/tickets">{{ trans('panel.support_tickets') }}</a>
                    </li>
                </ul>
            </div>
        </li>

        @if(!$authUser->isUser() or (!empty($referralSettings) and $referralSettings['status'] and $authUser->affiliate))
            <li class="sidenav-item {{ (request()->is('panel/marketing') or request()->is('panel/marketing/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.marketing')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.marketing') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/marketing') or request()->is('panel/marketing/*')) ? 'show' : '' }}" id="marketingCollapse">
                    <ul class="sidenav-item-collapse">
                        @if(!$authUser->isUser())
                            <li class="mt-5 {{ (request()->is('panel/marketing/special_offers')) ? 'active' : '' }}">
                                <a href="/panel/marketing/special_offers">{{ trans('panel.discounts') }}</a>
                            </li>
                            <li class="mt-5 {{ (request()->is('panel/marketing/promotions')) ? 'active' : '' }}">
                                <a href="/panel/marketing/promotions">{{ trans('panel.promotions') }}</a>
                            </li>
                        @endif

                        @if(!empty($referralSettings) and $referralSettings['status'] and $authUser->affiliate)
                            <li class="mt-5 {{ (request()->is('panel/marketing/affiliates')) ? 'active' : '' }}">
                                <a href="/panel/marketing/affiliates">{{ trans('panel.affiliates') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @endif

        @if(getFeaturesSettings('forums_status'))
            <li class="sidenav-item {{ (request()->is('panel/forums') or request()->is('panel/forums/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-fill mr-10">
                    @include('web.default.panel.includes.sidebar_icons.forums')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.forums') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/forums') or request()->is('panel/forums/*')) ? 'show' : '' }}" id="forumsCollapse">
                    <ul class="sidenav-item-collapse">
                        <li class="mt-5 {{ (request()->is('panel/forums/topics')) ? 'active' : '' }}">
                            <a href="/forums/create-topic">{{ trans('update.new_topic') }}</a>
                        </li>
                        <li class="mt-5 {{ (request()->is('panel/forums/topics')) ? 'active' : '' }}">
                            <a href="/panel/forums/topics">{{ trans('update.my_topics') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/forums/posts')) ? 'active' : '' }}">
                            <a href="/panel/forums/posts">{{ trans('update.my_posts') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/forums/bookmarks')) ? 'active' : '' }}">
                            <a href="/panel/forums/bookmarks">{{ trans('update.bookmarks') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif


        @if($authUser->isTeacher())
            <li class="sidenav-item {{ (request()->is('panel/blog') or request()->is('panel/blog/*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-fill mr-10">
                    @include('web.default.panel.includes.sidebar_icons.blog')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.articles') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/blog') or request()->is('panel/blog/*')) ? 'show' : '' }}" id="blogCollapse">
                    <ul class="sidenav-item-collapse">
                        <li class="mt-5 {{ (request()->is('panel/blog/posts/new')) ? 'active' : '' }}">
                            <a href="/panel/blog/posts/new">{{ trans('update.new_article') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/blog/posts')) ? 'active' : '' }}">
                            <a href="/panel/blog/posts">{{ trans('update.my_articles') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/blog/comments')) ? 'active' : '' }}">
                            <a href="/panel/blog/comments">{{ trans('panel.comments') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if($authUser->isOrganization() || $authUser->isTeacher())
            <li class="sidenav-item {{ (request()->is('panel/noticeboard*') or request()->is('panel/course-noticeboard*')) ? 'sidenav-item-active' : '' }}">
                <a class="d-flex align-items-center">
                <span class="sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.noticeboard')
                </span>

                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.noticeboard') }}</span>
                </a>

                <div class="sidenav-dropdown {{ (request()->is('panel/noticeboard*') or request()->is('panel/course-noticeboard*')) ? 'show' : '' }}" id="noticeboardCollapse">
                    <ul class="sidenav-item-collapse">
                        <li class="mt-5 {{ (request()->is('panel/noticeboard')) ? 'active' : '' }}">
                            <a href="/panel/noticeboard">{{ trans('public.history') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/noticeboard/new')) ? 'active' : '' }}">
                            <a href="/panel/noticeboard/new">{{ trans('public.new') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/course-noticeboard')) ? 'active' : '' }}">
                            <a href="/panel/course-noticeboard">{{ trans('update.course_notices') }}</a>
                        </li>

                        <li class="mt-5 {{ (request()->is('panel/course-noticeboard/new')) ? 'active' : '' }}">
                            <a href="/panel/course-noticeboard/new">{{ trans('update.new_course_notices') }}</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @php
            $rewardSetting = getRewardsSettings();
        @endphp

        @if(!empty($rewardSetting) and $rewardSetting['status'] == '1')
            <li class="sidenav-item {{ (request()->is('panel/rewards')) ? 'sidenav-item-active' : '' }}">
                <a href="/panel/rewards" class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-strock mr-10">
                    @include('web.default.panel.includes.sidebar_icons.rewards')
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('update.rewards') }}</span>
                </a>
            </li>
        @endif

        <li class="sidenav-item {{ (request()->is('panel/notifications')) ? 'sidenav-item-active' : '' }}">
            <a href="/panel/notifications" class="d-flex align-items-center">
            <span class="sidenav-notification-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.notifications')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.notifications') }}</span>
            </a>
        </li>

        <li class="sidenav-item {{ (request()->is('panel/setting')) ? 'sidenav-item-active' : '' }}">
            <a href="/panel/setting" class="d-flex align-items-center">
                <span class="sidenav-setting-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.setting')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.settings') }}</span>
            </a>
        </li>

        @if($authUser->isTeacher() or $authUser->isOrganization())
            <li class="sidenav-item ">
                <a href="{{ $authUser->getProfileUrl() }}" class="d-flex align-items-center">
                <span class="sidenav-item-icon assign-strock mr-10">
                    <i data-feather="user" stroke="#1f3b64" stroke-width="1.5" width="24" height="24" class="mr-10 webinar-icon"></i>
                </span>
                    <span class="font-16 text-dark-blue font-weight-500">{{ trans('public.my_profile') }}</span>
                </a>
            </li>
        @endif

        <li class="sidenav-item">
            <a href="/logout" class="d-flex align-items-center">
                <span class="sidenav-logout-icon sidenav-item-icon mr-10">
                    @include('web.default.panel.includes.sidebar_icons.logout')
                </span>
                <span class="font-16 text-dark-blue font-weight-500">{{ trans('panel.log_out') }}</span>
            </a>
        </li>
    </ul>
</div>
