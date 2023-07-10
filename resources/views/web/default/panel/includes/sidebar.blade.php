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


    <div class="nav-icons-or-start-live navbar-order user-panel-menu">
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

                    <a class="dropdown-item" href="javascript:;">

                        <span class="font-14 text-dark-blue">{{ trans('panel.financial') }}</span>
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

                            @if(($authUser->isOrganization() || $authUser->isTeacher()) and
                            getRegistrationPackagesGeneralSettings('status'))
                            <li class="mt-5 {{ (request()->is('panel/financial/registration-packages')) ? 'active' : '' }}">
                                <a href="{{ route('panelRegistrationPackagesLists') }}">{{
                                    trans('update.registration_packages') }}</a>
                            </li>
                            @endif
                        </ul>
                    </a>



                    <a class="dropdown-item" href="javascript:;">

                                            <span class="font-14 text-dark-blue">{{ trans('panel.support') }}</span>
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
