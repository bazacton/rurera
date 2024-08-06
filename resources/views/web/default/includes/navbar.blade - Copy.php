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
@endphp
@if( !$authUser->isUser())
<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar1 navbar-expand-lg navbar-light top-navbar">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container-fluid'}}">
        <div class="d-flex align-items-center justify-content-between w-100">

            <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}" href="/">
                @if(!empty($generalSettings['logo']))
                <img src="{{ $generalSettings['logo'] }}" class="img-cover" alt="site logo" title="site logo" width="100%" height="auto" itemprop="image" loading="eager" >
                @endif
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

                    @if(!empty($navbarPages) and count($navbarPages))
                    @foreach($navbarPages as $navbarPage)
                    <li class="nav-item {{ (isset( $navbarPage['menu_classes']) && $navbarPage['menu_classes'] != '')
                            ?$navbarPage['menu_classes'] : '' }}{{ (isset( $navbarPage['is_mega_menu']) && $navbarPage['is_mega_menu'] == 1)
                            ?' has-mega-menu' : '' }}">
                        <a class="nav-link" href="{{ $navbarPage['link'] }}">{{ $navbarPage['title'] }}</a>

                        @if( (isset( $navbarPage['title']) && $navbarPage['title'] == 'Courses') && !empty($course_navigation))
                        <div class="lms-mega-menu">
                            <div class="mega-menu-head">
                                <ul class="mega-menu-nav d-flex nav">
                                    @php $count = 1; @endphp
                                    @foreach($course_navigation as $navigation_slug => $nagivation_data)
                                    @if($count == 1)
                                        <style>
                                            :root {
                                              --category-color: {{$nagivation_data['color']}};
                                            }
                                        </style>
                                    @endif


                                    <li>
                                        <a href="#" data-category_color="{{$nagivation_data['color']}}" class="{{ ($count == 1)? 'active' : ''}}" id="{{$navigation_slug}}-tab" data-toggle="tab"
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

                                <div class="tab-pane fade {{ ($count == 1)? 'show active' : ''}}" id="{{$navigation_slug}}" role="tabpanel" aria-labelledby="{{$navigation_slug}}-tab">
                                    <div class="row">

                                            @if( (isset( $nagivation_data['menu_data'] ) && $nagivation_data['menu_data'] != ''))
                                            <div class="col-12 col-lg-3 col-md-4">
                                                {!! $nagivation_data['menu_data'] !!}
                                            </div>
                                        @endif
                                        @if( isset( $nagivation_data['chapters'] ) && !empty( $nagivation_data['chapters']))
                                        @if( (isset( $nagivation_data['menu_data'] ) && $nagivation_data['menu_data'] != ''))
                                            <div class="col-12 col-lg-9 col-md-8">
                                        @else
                                            <div class="col-12 col-lg-12 col-md-12 pl-30">
                                        @endif
                                            <div class="row">
                                                @foreach($nagivation_data['chapters'] as $chapter_id => $chapter_data)
                                                @if( (isset( $nagivation_data['menu_data'] ) && $nagivation_data['menu_data'] != ''))
                                                    <div class="col-12 col-lg-4 col-md-6">
                                                @else
                                                    <div class="col-12 col-lg-3 col-md-6">
                                                @endif
                                                    <div class="menu-colum-text">
                                                        <a
                                                            href="/course/{{$chapter_data['chapter_slug']}}"><strong>{{isset( $chapter_data['chapter_title'] )? $chapter_data['chapter_title'] : ''}}</strong></a>
                                                        @if( isset( $chapter_data['topics']) && !empty( $chapter_data['topics'] ) )
                                                        <ul class="topic-list">
                                                            @php $topics_count = 1; @endphp
                                                            @foreach($chapter_data['topics'] as $topic_id => $topic_title)
                                                                @if( $topics_count <= 8)
                                                                    <li><a href="/course/{{$chapter_data['chapter_slug']}}#subject_{{$topic_id}}">{{$topic_title}}</a></li>
                                                                @else
                                                                    <li style="display:none;"><a href="/course/{{$chapter_data['chapter_slug']}}#subject_{{$topic_id}}">{{$topic_title}}</a></li>
                                                                @endif
                                                                @php $topics_count++; @endphp
                                                            @endforeach
                                                            @if( count($chapter_data['topics']) > 8)
                                                                <li class="load-more"><a href="/course/{{$chapter_data['chapter_slug']}}">...</a></li>
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
                        @if( isset( $navbarPage['submenu'] ) && $navbarPage['submenu'] != '' && (!isset( $navbarPage['is_mega_menu'] ) || $navbarPage['is_mega_menu'] != 1))
                        <div class="sidenav-dropdown">
                            <ul class="sidenav-item-collapse">
                                {!! $navbarPage['submenu'] !!}
                            </ul>
                        </div>
                        @endif

                        @if( isset( $navbarPage['is_mega_menu'] ) && $navbarPage['is_mega_menu'] == 1)
                        {!! $navbarPage['submenu'] !!}
                        @endif

                        @endif
                    </li>
                    @endforeach
                    @endif
                </ul>
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
                                <span class="font-16 text-dark-blue">{{ trans('public.my_profile') }}</span>
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
        </div>
    </div>
</nav>

@push('scripts_bottom')
<script src="/assets/default/js/parts/navbar.min.js"></script>
@endpush
@endif
