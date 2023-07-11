@php
$getPanelSidebarSettings = getPanelSidebarSettings();
@endphp


<div class="panel-sidebar top-navbar px-25 pt-15" id="panelSidebar" style="position: inherit;top: 0px;">
    <button class="btn-transparent panel-sidebar-close sidebarNavToggle">
        <i data-feather="align-justify" width="24" height="24"></i>
        <i data-feather="x" width="24" height="24"></i>
    </button>

    <div class="user-info d-flex align-items-center flex-row flex-lg-column justify-content-lg-center">
        <a href="/panel">
            <img src="{{ $generalSettings['logo'] }}" class="img-cover" alt="LMS">
        </a>
    </div>


    <div class="nav-icons-or-start-live navbar-order user-panel-menu ml-auto">
        <div class="xs-w-100 d-flex align-items-center justify-content-between ">
            @if(!empty($authUser))
            <div class="d-flex">
                <div class="border-left mx-5 mx-lg-15"></div>
            </div>
            @endif

            @if(!empty($authUser))


            <div class="dropdown">
                <a href="#!" class="navbar-user d-flex align-items-center ml-50 dropdown-toggle" type="button"
                   id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <img src="{{ $authUser->getAvatar() }}" class="rounded-circle" alt="{{ $authUser->full_name }}"
                         width="100%" height="auto" itemprop="image" alt="rounded circle" loading="eager"
                         title="rounded circle">
                    <span class="font-16 user-name ml-10 text-dark-blue font-14">{{ $authUser->full_name }}</span>
                </a>

                <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                    <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                        <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
                    </div>

                    <a class="dropdown-item" href="javascript:;" id="sub-dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <span class="font-14 text-dark-blue">{{ trans('panel.financial') }}</span>
                        <ul class="sidenav-item-collapse" aria-labelledby="sub-dropdown1">
                            <li class="mt-0">
                                <a href="/panel/financial/summary">Financial summary</a>
                            </li>
                            <li class="mt-10">
                                <a href="/panel/financial/payout">Payout</a>
                            </li>

                            <li class="mt-5">
                                <a href="/panel/financial/account">Charge account</a>
                            </li>

                            <li class="mt-5">
                                <a href="/panel/financial/subscribes">Subscribe</a>
                            </li>
                        </ul>
                    </a>


                    <a class="dropdown-item" href="javascript:;" id="sub-dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <span class="font-14 text-dark-blue">{{ trans('panel.support') }}</span>
                        <ul class="sidenav-item-collapse" aria-labelledby="sub-dropdown2">
                            <li class="mt-0">
                                <a href="/panel/support/new">New</a>
                            </li>
                            <li class="mt-10">
                                <a href="/panel/support">Courses support</a>
                            </li>
                            <li class="mt-10">
                                <a href="/panel/support/tickets">Tickets</a>
                            </li>
                        </ul>
                    </a>


                    <a class="dropdown-item" href="/panel/notifications">
                        <span class="font-14 text-dark-blue">{{ trans('panel.notifications') }}</span>
                    </a>

                    <a class="dropdown-item" href="/logout">

                        <span class="font-14 text-dark-blue">{{ trans('panel.log_out') }}</span>
                    </a>
                </div>
            </div>
            @else
            <div class="d-flex align-items-center ml-md-50">
                <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-14 login-btn">{{ trans('auth.login') }}</a>
                <a href="/register" class="py-5 px-15 text-dark-blue font-14 register-btn">Get Started</a>
            </div>
            @endif
        </div>

    </div>
</div>
