@php
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
@endphp
@if( !isset( $authUser ) || !$authUser->isUser())
<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar1 navbar-expand-lg navbar-light top-navbar">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container-fluid'}}">
        <div class="d-flex align-items-center justify-content-between w-100">

            <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}"
               href="{{url('/')}}/" itemprop="url">
                @if(!empty($generalSettings['logo']))
                <img src="{{ $generalSettings['logo'] }}" class="img-cover" alt="Rurera Logo" title="Rurera Logo"
                     width="185" height="38" itemprop="image" loading="eager">
                @endif
            </a>

            <button class="navbar-toggler navbar-order" type="button" aria-label="navbar toggler" id="navbarToggle">
            Menu <span class="navbar-toggler-icon"></span>
            </button>

            <div class="mx-lg-30 d-none d-lg-flex flex-grow-1 navbar-toggle-content " id="navbarContent">
                <a class="mobile-logo"
                       href="{{url('/')}}/" itemprop="url">
                    <img src="{{ $generalSettings['logo'] }}" alt="Rurera Logo" title="Rurera Logo" width="185" height="38" itemprop="image" loading="eager">
                    </a>
                <div class="navbar-toggle-header text-right d-lg-none">
                    <button class="btn-transparent" id="navbarClose">
                        Close
                        <i data-feather="x" width="32" height="32"></i>
                    </button>
                </div>

                <ul class="navbar-nav mr-auto d-flex align-items-center">
                    @if(!empty($navbarPages) and count($navbarPages))
                    @foreach($navbarPages as $navbarPage)
                        @php $is_menu_show = true; $is_panel = false; @endphp
                        @if(isset( $authUser ) && $authUser->isUser()) @php $is_panel = true; @endphp @if( !isset( $navbarPage['is_student_panel'] ) || $navbarPage['is_student_panel'] != 1) @php $is_menu_show = false; @endphp @endif @endif
						@if(isset( $authUser ) && $authUser->isParent()) @php $is_panel = true; @endphp @if( !isset( $navbarPage['is_parent_panel'] ) || $navbarPage['is_parent_panel'] != 1) @php $is_menu_show = false; @endphp @endif @endif
                        @if( (!isset( $navbarPage['is_other_panel'] ) || $navbarPage['is_other_panel'] != 1) && $is_panel == false) @php $is_menu_show = false; @endphp @endif
						@if( $is_menu_show == false) @php continue; @endphp @endif
						@php $active_class = ('/'.request()->segment(count(request()->segments())) == $navbarPage['link'])? 'current-page' : ''; @endphp
						<li class="nav-item {{ (isset( $navbarPage['menu_classes']) && $navbarPage['menu_classes'] != '')
                            ?$navbarPage['menu_classes'] : '' }}{{ (isset( $navbarPage['is_mega_menu']) && $navbarPage['is_mega_menu'] == 1)
                            ?' has-mega-menu' : '' }} {{$active_class}}">
                        <a class="nav-link" href="{{ $navbarPage['link'] }}">{{ $navbarPage['title'] }}</a>
                        @if( (isset( $navbarPage['title']) && $navbarPage['title'] == 'Courses') &&
                        !empty($course_navigation))
                        <div class="lms-mega-menu">
                            <div class="mega-menu-head">
                                <ul class="mega-menu-nav d-flex nav">
                                    @php $count = 1; @endphp
                                    @foreach($course_navigation as $navigation_slug => $nagivation_data)
                                    @if($count == 1)
                                    <style>
                                        :root {
                                            --category-color: #2c72af;
                                        }
                                    </style>
                                    @endif

                                    <li>
                                        <a href="#{{$navigation_slug}}" data-category_color="{{$nagivation_data['color']}}"
                                           class="{{ ($count == 1)? 'active' : ''}}" id="{{$navigation_slug}}-tab"
                                           data-toggle="tab"
                                           data-target="#{{$navigation_slug}}"
                                           role="tab"
                                           aria-controls="{{$navigation_slug}}" aria-selected="true">{{$nagivation_data['title']}}</a>
                                    </li>
                                    @php $count++; @endphp
                                    @endforeach

                                </ul>
                            </div>
                            <div class="mega-menu-body tab-content">
                                @php $count = 1; @endphp
                                @foreach($course_navigation as $navigation_slug => $nagivation_data)
                                <div class="tab-pane fade {{ ($count == 1)? 'show active' : ''}}"
                                     id="{{$navigation_slug}}" role="tabpanel"
                                     aria-labelledby="{{$navigation_slug}}-tab">
                                    <div class="row">
                                        @if( (isset( $nagivation_data['menu_data'] ) && $nagivation_data['menu_data'] !=
                                        ''))
                                        <div class="col-12 col-lg-3 col-md-4">
                                            {!! $nagivation_data['menu_data'] !!}
                                        </div>
                                        @endif
                                        @if( isset( $nagivation_data['chapters'] ) && !empty(
                                        $nagivation_data['chapters']))
                                        @if( (isset( $nagivation_data['menu_data'] ) && $nagivation_data['menu_data'] !=
                                        ''))
                                        <div class="col-12 col-lg-9 col-md-8">
                                            @else
                                            <div class="col-12 col-lg-12 col-md-12 pl-30">
                                                @endif
                                                <div class="row">
                                                    @foreach($nagivation_data['chapters'] as $chapter_id =>
                                                    $chapter_data)
                                                    @if( (isset( $nagivation_data['menu_data'] ) &&
                                                    $nagivation_data['menu_data'] != ''))
                                                    <div class="col-12 col-lg-4 col-md-6">
                                                        @else
                                                        <div class="col-12 col-lg-3 col-md-6">
                                                            @endif
                                                            <div class="menu-colum-text">
                                                                <a
                                                                        href="/{{$navigation_slug}}/{{$chapter_data['chapter_slug']}}"><strong>{!! isset(
                                                                        $chapter_data['chapter_icon_code'] )?
                                                                        $chapter_data['chapter_icon_code'] :
                                                                        '' !!}{{isset(
                                                                        $chapter_data['chapter_title'] )?
                                                                        $chapter_data['chapter_title'] :
                                                                        ''}}</strong></a>
                                                                @if( isset( $chapter_data['topics']) && !empty(
                                                                $chapter_data['topics'] ) )
                                                                <ul class="topic-list">
                                                                    @php $topics_count = 1; @endphp
                                                                    @foreach($chapter_data['topics'] as $topic_id =>
                                                                    $topicData)
                                                                    @php
                                                                    $topic_title = isset( $topicData['title'] )? $topicData['title'] : '';
                                                                    $topic_custom_link = isset( $topicData['custom_link'] )? $topicData['custom_link'] : '';
                                                                    $chapter_link = '/course/'.$chapter_data['chapter_slug'].'#subject_'.$topic_id;
                                                                    $chapter_link = ($topic_custom_link != '')? $topic_custom_link : $chapter_link;
                                                                    @endphp
                                                                    @if( $topics_count <= 8)
                                                                    <li>
                                                                        <a href="{{$chapter_link}}">{{$topic_title}}</a>
                                                                    </li>
                                                                    @else
                                                                    <li style="display:none;"><a
                                                                                href="/course/{{$chapter_data['chapter_slug']}}#subject_{{$topic_id}}">{{$topic_title}}</a>
                                                                    </li>
                                                                    @endif
                                                                    @php $topics_count++; @endphp
                                                                    @endforeach
                                                                    @if( count($chapter_data['topics']) > 8)
                                                                    <li class="load-more"><a
                                                                                href="/course/{{$chapter_data['chapter_slug']}}">...</a>
                                                                    </li>
                                                                    @endif
                                                                </ul>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @php $count++; @endphp
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                @if( isset( $navbarPage['submenu'] ) && $navbarPage['submenu'] != '' && (!isset(
                                $navbarPage['is_mega_menu'] ) || $navbarPage['is_mega_menu'] != 1))
                                <div class="sidenav-dropdown">
                                    <ul class="sidenav-item-collapse">
                                        {!! $navbarPage['submenu'] !!}
                                    </ul>
                                </div>
                                @endif
                                @if( isset( $navbarPage['is_mega_menu'] ) && $navbarPage['is_mega_menu'] == 1) {!! $navbarPage['submenu'] !!} @endif
                                @endif
                    </li>
                    @endforeach
                    @endif
                </ul>
                <div class="mobile-login-reg-buttons">
                    <a class="mobile-login-btn" href="/login">Log in</a>
                    <a class="mobile-register-btn" href="/register-as">Try for free</a>
                </div>
            </div>
            @if(isset( $authUser ))
                @include('web.default.includes.notification-dropdown')
            @endif
            @if(isset( $authUser ) && $authUser->isUser())
                <div class="coin-counts">
                    <strong>
                        <img src="/assets/default/img/coin-img.png" alt="">
                        {{$authUser->getRewardPoints()}}
                    </strong>
                </div>
            @endif
            <div class="nav-icons-or-start-live navbar-order">
                <div class="xs-w-100 d-flex align-items-center justify-content-between">
                    @if(!empty($authUser))
                    @endif
                    @if(!empty($authUser))
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
                                <span class="font-16 text-dark-blue user-email">{{ $authUser->email }}</span>
                                <a href="/panel" class="font-16 text-dark-blue user-manage-btn">Manage Account</a>
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
								@php $full_name = (isset( $navData['is_parent'] ) && $navData['is_parent'] == true)? 'Parent' :  $profile_nav['full_name']; @endphp
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
                    @else
                    <div class="d-flex align-items-center ml-md-50">
                        <a href="/login" class="py-5 px-15 mr-10 text-dark-blue font-16 login-btn">Log in</a>
                        <a href="/register-as" class="py-5 px-15 text-dark-blue font-16 register-btn">Try for free</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
@endif