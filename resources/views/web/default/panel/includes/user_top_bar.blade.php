
<div class="user-profile-icons">
    <ul>
        <li class="sidebar-logo-mobile">
            <a class="sidebar-logo"
               href="{{url('/')}}/" itemprop="url">
                <img src="/assets/default/img/sidebar/logo.svg"><span class="sidebar-logo-text"></span>
            </a>
        </li>
        @if(auth()->check() && (auth()->user()->isUser()))
        <li class="dropdown dropdown-list-toggle">
            <strong>
                <img src="/assets/default/img/panel-sidebar/1.png" alt="">
                @if(!empty($unReadNotifications) and count($unReadNotifications))
                {{ count($unReadNotifications) }}
                @else
                0
                @endif
            </strong>

            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">{{ trans('admin/main.notifications') }}
                    <div class="float-right">
                        @can('admin_notifications_markAllRead')
                        <a href="{{ getAdminPanelUrl() }}/notifications/mark_all_read">{{ trans('admin/main.mark_all_read') }}</a>
                        @endcan
                    </div>
                </div>

                <div class="dropdown-list-content dropdown-list-icons">
                    @foreach($unReadNotifications as $unreadNotification)
                    <a href="{{ getAdminPanelUrl() }}/notifications" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white d-flex align-items-center justify-content-center">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            {{ $unreadNotification->title }}
                            <div class="time text-primary">{{ dateTimeFormat($unreadNotification->created_at,'Y M j | H:i') }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ getAdminPanelUrl() }}/notifications">{{ trans('admin/main.view_all') }} <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li>
            <div class="assignments">
                <strong>
                    <img src="/assets/default/img/sidebar/games.svg" alt="">
					@if( $authUser->game_time > 0)
						{{getTimeWithText($authUser->game_time, false, false, false)}}
					@else
						0 m
					@endif
                </strong>
            </div>
        </li>

        <li class="dropdown dropdown-list-toggle">
            <strong>
                <img src="/assets/default/img/panel-sidebar/coins.svg" alt="">
                {{$authUser->getRewardPoints()}}
            </strong>
            <div class="dropdown-menu user-coins-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">
                    <img src="/assets/default/img/panel-sidebar/coins.svg" alt="">
                    <div class="coins-text">
                        Coins
                        <span>You have {{$authUser->getRewardPoints()}} Coins <a href="/shop">Go to Shop</a></span>
                    </div>
                </div>
            </div>
        </li>
        @endif

        <li class="sidebar-no-mobile">
            <div class="xs-w-100 d-flex align-items-center justify-content-between">
                @if(!empty($authUser))
                <!-- <div class="d-flex">
                    <div class="border-left mx-5 mx-lg-15"></div>
                </div> -->
                @endif

                @if(!empty($authUser))

                @if(auth()->check() && (auth()->user()->isUser()))
                <div class="dropdown">
                    <a href="#!" class="navbar-user d-flex align-items-center dropdown-toggle" type="button"
                       id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <img src="{{ $authUser->getAvatar() }}" class="rounded-circle"
                             alt="{{ $authUser->get_full_name() }}" width="100%" height="auto" itemprop="image"
                             alt="rounded circle" loading="eager" title="rounded circle">
                    </a>

                    <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                        <div class="dropdown-item user-nav-detail">
                            <img src="{{ $authUser->getAvatar() }}" class="rounded-circle" alt="{{ $authUser->get_full_name() }}" width="100%" height="auto" itemprop="image"
                                 alt="rounded circle" loading="eager" title="rounded circle">
                            <span class="font-16 text-dark-blue user-name">{{ $authUser->get_full_name() }}</span>
                            <a href="/panel/setting" class="font-16 text-dark-blue user-manage-btn">Manage Account</a>
                        </div>
                        <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                            <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
                        </div>


                        @if( !empty( $profile_navs ) )
                        <div class="user-nav-list">
                            @foreach( $profile_navs as $profile_nav)

                            <a class="dropdown-item " href="/panel/switch_user/{{$profile_nav['id']}}">
                                <img src="{{ $profile_nav->getAvatar() }}" class="rounded-circle" alt="{{ $profile_nav['full_name'] }}" width="100%" height="auto" itemprop="image"
                                     alt="rounded circle" loading="eager" title="rounded circle">
                                @php $full_name = (isset( $navData['is_parent'] ) && $navData['is_parent'] == true)? 'Parent Dashboard' : $profile_nav['full_name']; @endphp
                                <span class="font-16 text-dark-blue user-list-name">{{ $full_name }}</span>
                                <span class="font-16 text-dark-blue user-list-email">{{ $profile_nav['email'] }}</span>
                            </a>

                            @endforeach
                        </div>
                        @endif

                        <a class="dropdown-item nav-logout" href="/logout">
                            <img src="/assets/default/img/icons/sidebar/logout.svg" height="auto" itemprop="image"
                                 width="25" alt="nav-icon" title="nav-icon" loading="eager">
                            <span class="font-16 text-dark-blue">{{ trans('panel.log_out') }}</span>
                        </a>
                    </div>
                </div>

                @endif
                @else
                <div class="d-flex align-items-center ml-md-50">
                    <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-16 login-btn">Log in</a>
                    <a href="/register" class="py-5 px-15 text-dark-blue font-16 register-btn">Try for free</a>
                </div>
                @endif
            </div>
        </li>
        <li class="menu-button-mobile">
            <button class="navbar-toggler navbar-order" type="button" id="navbarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
        </li>
    </ul>
</div>