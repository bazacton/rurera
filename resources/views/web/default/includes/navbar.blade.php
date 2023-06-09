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

<div id="navbarVacuum"></div>
<nav id="navbar" class="navbar1 navbar-expand-lg navbar-light top-navbar">
    <div class="{{ (!empty($isPanel) and $isPanel) ? 'container-fluid' : 'container-fluid'}}">
        <div class="d-flex align-items-center justify-content-between w-100">

            <a class="navbar-brand navbar-order d-flex align-items-center justify-content-center mr-0 {{ (empty($navBtnUrl) and empty($navBtnText)) ? 'ml-auto' : '' }}" href="/">
                @if(!empty($generalSettings['logo']))
                <img src="{{ $generalSettings['logo'] }}" class="img-cover" alt="site logo">
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
                    @if(!empty($categories) and count($categories))
                    <li class="mr-lg-25">
                        <div class="menu-category">
                            <ul>
                                <li class="cursor-pointer user-select-none d-flex xs-categories-toggle">
                                    <i data-feather="grid" width="20" height="20" class="mr-10 d-none d-lg-block"></i>
                                    All Courses

                                    <ul class="cat-dropdown-menu">
                                        @foreach($categories as $category)
                                        <li>
                                            <a href="{{ (!empty($category->subCategories) and count($category->subCategories)) ? '#!' : $category->getUrl() }}">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $category->icon }}" class="cat-dropdown-menu-icon mr-10" alt="{{ $category->title }} icon">
                                                    {{ $category->title }}
                                                </div>

                                                @if(!empty($category->subCategories) and count($category->subCategories))
                                                <i data-feather="chevron-right" width="20" height="20" class="d-none d-lg-inline-block ml-10"></i>
                                                <i data-feather="chevron-down" width="20" height="20" class="d-inline-block d-lg-none"></i>
                                                @endif
                                            </a>

                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                            <ul class="sub-menu">
                                                @foreach($category->subCategories as $subCategory)
                                                <li>
                                                    <a href="{{ $subCategory->getUrl() }}">
                                                        @if(!empty($subCategory->icon))
                                                        <img src="{{ $subCategory->icon }}" class="cat-dropdown-menu-icon mr-10" alt="{{ $subCategory->title }} icon">
                                                        @endif

                                                        {{ $subCategory->title }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

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
                                        <div class="col-12 col-lg-3 col-md-4">
                                            <div class="courses-detail">
                                                <div class="detail-inner">
                                                    <div class="detail-text">
                                                        <span class="icon-img">
                                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="424.000000pt"
                                                                 height="600.000000pt" viewBox="0 0 424.000000 600.000000"
                                                                 preserveAspectRatio="xMidYMid meet">

                                                            <g transform="translate(0.000000,600.000000) scale(0.100000,-0.100000)"
                                                               fill="#000000" stroke="none">
                                                            <path
                                                                d="M3745 5920 c-50 -12 -97 -35 -190 -95 -85 -54 -122 -85 -236 -197 -49 -47 -94 -73 -156 -88 -25 -6 -36 -4 -49 11 -20 23 -27 23 -67 5 -66 -30 -155 -56 -188 -56 -19 0 -47 7 -64 16 -42 22 -125 10 -210 -32 -57 -27 -76 -43 -100 -81 -40 -65 -75 -94 -97 -82 -37 20 -76 10 -102 -24 -15 -19 -26 -39 -26 -46 0 -6 -9 -30 -20 -52 -12 -22 -23 -59 -26 -82 -3 -23 -12 -68 -20 -100 -8 -32 -14 -79 -14 -103 0 -25 -4 -64 -9 -87 -5 -23 -15 -69 -21 -102 -18 -88 -50 -175 -78 -215 -14 -19 -26 -36 -26 -36 -1 -1 -10 -4 -21 -8 -36 -10 -49 9 -56 86 -4 41 -12 92 -19 114 -10 34 -18 42 -56 56 -25 9 -53 14 -62 11 -21 -6 -97 -99 -106 -130 -10 -31 -30 -29 -45 5 -7 15 -19 37 -27 50 -14 21 -16 21 -44 7 -41 -21 -48 -19 -66 18 -22 47 -77 80 -117 71 -43 -9 -119 -45 -135 -64 -48 -55 -71 -172 -73 -364 -1 -96 -5 -109 -31 -100 -25 8 -109 -48 -134 -90 -37 -61 -16 -330 32 -427 7 -15 16 -39 20 -55 23 -105 27 -628 5 -682 -11 -26 -16 -30 -27 -21 -8 6 -14 16 -14 22 0 30 -34 96 -54 105 -24 11 -54 0 -69 -25 -13 -21 -24 -15 -36 17 -6 17 -16 44 -23 61 -8 22 -24 37 -52 49 -23 10 -63 41 -91 69 -27 28 -54 51 -60 51 -26 0 -93 -43 -125 -80 -34 -40 -49 -45 -101 -37 -37 6 -61 -10 -113 -71 -44 -51 -96 -147 -96 -176 0 -8 -9 -36 -20 -61 -11 -26 -26 -89 -32 -139 -11 -89 -10 -96 20 -224 18 -72 41 -154 52 -182 23 -59 26 -113 6 -129 -7 -6 -16 -30 -19 -52 -3 -22 -18 -59 -33 -82 -34 -52 -41 -114 -20 -187 25 -89 161 -482 178 -515 23 -45 58 -161 58 -193 0 -19 -10 -37 -33 -58 -31 -27 -33 -33 -35 -104 -2 -59 2 -84 18 -115 11 -21 20 -51 20 -66 0 -29 -35 -121 -60 -159 -10 -14 -35 -61 -57 -105 -22 -44 -58 -114 -80 -156 -51 -94 -69 -155 -72 -240 -2 -65 -1 -68 31 -91 74 -54 118 -61 118 -19 0 11 4 23 10 26 5 3 10 15 10 26 0 10 4 19 8 19 16 0 42 72 42 118 1 49 23 121 88 287 l39 99 64 21 c71 23 99 39 128 76 11 14 44 38 73 54 47 25 67 28 185 34 107 5 135 10 152 25 11 10 18 23 15 30 -2 6 2 20 10 31 13 18 27 20 148 19 137 0 305 -16 370 -36 28 -8 48 -8 85 2 26 7 97 14 157 16 60 2 114 8 119 13 6 6 11 27 10 46 -2 60 25 68 167 51 67 -9 210 22 283 60 60 31 361 257 382 287 26 37 19 83 -15 109 -36 26 -36 27 -10 80 23 47 26 111 7 148 -14 28 -72 48 -161 55 -66 5 -96 25 -117 78 -7 18 -23 48 -36 67 -43 65 -23 120 62 163 57 29 102 80 109 123 7 38 10 42 44 48 20 3 48 6 62 6 42 0 143 55 216 116 38 32 74 63 79 70 6 6 41 32 78 58 61 42 77 48 150 57 104 13 159 42 259 138 82 77 138 152 138 183 0 10 -7 29 -15 41 -13 21 -12 27 25 79 94 131 129 251 107 363 -7 34 -21 70 -32 82 -26 28 -142 85 -172 86 -27 0 -27 0 -11 44 17 47 -3 64 -81 69 -49 4 -72 0 -111 -18 -28 -13 -50 -26 -50 -30 0 -5 -8 -8 -18 -8 -9 0 -65 -23 -122 -51 -63 -31 -130 -56 -169 -62 -63 -11 -63 -11 -83 16 -11 15 -42 39 -69 52 l-49 25 -77 -21 c-60 -16 -83 -18 -101 -9 -16 7 -22 16 -18 26 3 9 6 19 6 24 0 17 150 91 245 121 65 21 223 49 275 49 152 0 219 31 341 156 103 105 169 147 276 174 130 34 219 84 265 151 42 62 78 150 84 206 5 49 -22 162 -44 186 -35 39 -94 60 -179 65 -80 4 -82 5 -88 33 -7 29 -18 42 -49 53 -14 5 -29 -5 -61 -39 -49 -53 -81 -61 -70 -18 3 15 7 32 8 38 1 5 12 28 25 50 24 42 56 110 78 160 14 34 41 141 56 227 9 51 8 64 -12 113 l-22 55 27 40 c15 22 32 40 36 40 18 0 76 106 97 175 22 73 23 145 1 171 -7 8 -29 14 -55 14 -48 0 -57 9 -56 53 1 34 -21 73 -46 79 -9 2 -30 1 -47 -2z m49 -52 c9 -12 16 -39 16 -59 0 -48 19 -63 70 -54 44 7 47 4 54 -54 5 -41 -28 -152 -58 -195 -12 -17 -39 -50 -62 -72 -61 -61 -67 -88 -36 -154 l25 -54 -18 -91 c-23 -116 -64 -228 -115 -317 -31 -54 -41 -83 -43 -122 -2 -49 -1 -51 25 -54 22 -3 36 6 70 43 54 58 75 54 84 -16 4 -27 10 -49 14 -49 4 0 23 6 41 14 54 22 154 6 189 -31 63 -64 74 -209 23 -309 -35 -70 -79 -124 -101 -124 -9 0 -30 -8 -47 -18 -38 -23 -139 -59 -186 -67 -21 -3 -48 -14 -62 -25 -14 -11 -30 -20 -36 -20 -6 0 -11 -4 -11 -9 0 -5 -9 -12 -19 -16 -10 -3 -54 -41 -97 -83 -141 -139 -157 -147 -319 -162 -174 -16 -237 -28 -336 -63 -183 -65 -239 -103 -239 -161 0 -25 7 -40 26 -55 33 -26 42 -26 120 1 62 21 64 21 103 3 22 -9 50 -29 63 -42 13 -14 33 -29 46 -34 40 -16 186 29 282 86 88 52 167 79 232 80 36 0 70 -4 74 -8 5 -5 1 -22 -9 -38 -26 -46 -22 -59 16 -59 41 0 133 -37 177 -72 l35 -27 0 -103 c0 -96 -3 -108 -32 -168 -18 -36 -51 -89 -73 -118 -43 -56 -49 -85 -25 -112 12 -13 13 -23 6 -41 -13 -32 -183 -204 -222 -225 -45 -23 -119 -44 -157 -44 -54 0 -130 -44 -252 -146 -140 -116 -201 -149 -294 -157 -37 -4 -75 -12 -82 -18 -8 -6 -14 -28 -14 -49 0 -31 -7 -44 -35 -69 -20 -17 -50 -38 -68 -45 -96 -44 -115 -112 -59 -216 55 -102 87 -138 130 -145 124 -19 174 -30 183 -41 16 -19 4 -94 -21 -137 -27 -46 -21 -76 20 -101 27 -15 31 -22 25 -44 -3 -14 -12 -31 -19 -36 -118 -97 -245 -192 -315 -236 -77 -48 -99 -58 -184 -73 -53 -10 -105 -16 -114 -13 -10 3 -47 7 -83 11 -53 4 -72 2 -100 -14 -31 -17 -35 -23 -32 -54 2 -19 -1 -38 -7 -41 -6 -4 -56 -8 -113 -10 -57 -2 -115 -9 -131 -16 -22 -11 -37 -11 -76 -1 -104 26 -452 40 -522 21 -28 -8 -39 -17 -44 -38 -12 -50 -20 -52 -142 -51 -94 0 -120 -3 -151 -19 -20 -10 -49 -22 -64 -25 -15 -4 -40 -24 -55 -44 -29 -37 -91 -72 -130 -73 -24 0 -31 14 -13 25 11 7 170 330 170 345 0 6 5 10 10 10 6 0 10 4 10 9 0 9 78 184 98 219 4 8 45 26 92 41 47 16 99 36 115 45 17 9 38 16 48 16 9 0 17 4 17 8 0 11 154 48 279 67 58 9 107 18 110 19 3 2 54 7 113 10 59 4 131 11 159 16 101 19 125 14 200 -42 20 -16 41 -28 47 -28 13 0 63 -26 71 -37 3 -5 35 -31 71 -58 36 -27 80 -63 97 -79 18 -16 35 -27 38 -24 6 6 -74 82 -119 113 -16 11 -40 32 -54 47 -14 15 -54 46 -89 69 -35 23 -62 43 -61 44 2 2 90 -1 197 -7 208 -10 262 -8 261 6 0 5 -48 11 -107 12 -60 2 -135 5 -168 8 -89 7 -383 8 -394 1 -6 -3 -54 -8 -108 -10 -54 -3 -123 -10 -154 -16 -94 -19 -97 -13 -28 71 33 41 77 92 97 113 20 20 32 37 28 37 -5 0 -56 -49 -115 -109 -58 -59 -119 -115 -136 -124 -25 -13 -162 -56 -230 -72 -11 -2 -29 -9 -40 -14 -35 -17 -149 -58 -177 -65 -16 -4 -28 -2 -28 3 0 6 28 63 62 128 33 65 88 172 120 238 33 66 64 129 71 140 6 11 35 63 64 115 28 52 57 101 63 107 6 7 14 21 18 30 17 43 58 91 86 103 17 7 60 23 96 37 58 22 80 31 155 64 168 74 566 168 953 225 59 9 64 25 5 18 -26 -3 -64 -7 -83 -9 -74 -8 -189 -26 -284 -45 -54 -11 -103 -20 -108 -20 -11 0 25 50 68 97 13 14 24 30 24 36 0 6 -37 -27 -82 -72 -69 -68 -92 -84 -138 -98 -30 -9 -62 -17 -70 -18 -31 -4 -142 -36 -180 -52 -8 -3 -17 -7 -20 -8 -3 -1 -18 -7 -35 -14 -65 -25 -132 -49 -175 -62 -25 -7 -62 -21 -83 -31 -22 -11 -41 -18 -43 -16 -2 2 11 27 29 54 19 28 37 57 41 65 3 8 24 41 46 74 22 33 62 103 90 155 94 179 126 235 163 290 20 30 37 59 37 63 0 5 21 35 46 68 40 53 49 59 81 59 35 0 111 8 298 30 52 6 122 6 200 0 66 -6 167 -13 225 -15 58 -3 143 -7 190 -10 51 -3 117 1 165 9 l80 14 -95 0 c-94 -1 -482 20 -518 27 -64 12 -421 -1 -524 -20 -16 -2 -28 -1 -28 3 0 4 18 31 40 61 22 29 40 58 40 63 0 19 71 150 95 176 14 15 25 32 25 38 0 6 9 19 20 29 11 10 20 23 20 29 0 6 13 25 28 41 15 17 43 55 61 85 19 30 51 75 71 100 20 25 43 56 50 70 7 14 27 43 45 65 17 22 40 54 51 72 33 55 132 189 162 219 15 16 52 60 81 98 80 103 82 106 138 160 29 28 69 77 90 108 21 31 69 93 107 137 38 44 83 101 100 127 23 36 37 48 58 49 15 0 35 8 45 16 23 21 146 79 166 79 9 0 19 5 22 10 3 6 14 10 25 10 10 0 44 13 77 30 63 32 66 39 6 15 -21 -8 -67 -21 -103 -30 -36 -9 -80 -25 -98 -36 -18 -10 -39 -19 -46 -19 -7 0 -30 -11 -51 -25 -20 -15 -40 -24 -43 -21 -2 3 13 26 34 52 41 49 105 131 139 179 18 26 92 113 106 125 3 3 19 25 37 50 17 25 43 59 58 75 14 17 37 47 50 68 30 46 47 67 103 129 24 27 41 51 38 54 -6 7 -87 -72 -87 -84 0 -4 -11 -20 -24 -37 -14 -16 -56 -70 -95 -120 -39 -49 -92 -113 -118 -142 -25 -28 -50 -58 -54 -65 -26 -42 -7 51 26 127 8 17 30 71 50 120 20 50 49 107 65 127 36 45 39 60 6 29 -27 -25 -126 -218 -126 -244 0 -9 -4 -19 -10 -22 -13 -8 -50 -132 -52 -171 -1 -23 -14 -46 -45 -81 -24 -26 -63 -73 -85 -103 -23 -30 -66 -84 -96 -120 -75 -90 -82 -99 -121 -150 -19 -24 -42 -51 -51 -60 -10 -8 -38 -42 -63 -75 -71 -93 -125 -151 -132 -143 -4 3 -2 15 4 25 5 11 17 82 26 159 38 338 65 466 127 604 16 35 27 71 25 80 -3 12 -6 11 -12 -5 -4 -11 -16 -38 -26 -60 -33 -76 -89 -247 -89 -273 0 -15 -4 -33 -9 -40 -10 -16 -48 31 -79 98 -12 25 -35 65 -51 89 -16 25 -28 48 -25 53 3 4 0 8 -5 8 -6 0 -11 -4 -11 -9 0 -20 40 -101 50 -101 5 0 10 -7 10 -17 0 -18 78 -165 93 -174 10 -7 3 -79 -29 -294 -33 -225 -25 -207 -136 -328 -41 -45 -94 -104 -117 -132 -23 -27 -47 -57 -54 -65 -7 -8 -37 -46 -67 -85 -30 -38 -57 -72 -60 -75 -11 -10 -145 -198 -161 -226 -21 -36 -131 -199 -162 -238 -19 -25 -136 -193 -185 -266 -9 -14 -22 -29 -29 -33 -7 -4 -13 -12 -13 -17 0 -13 -121 -190 -130 -190 -4 0 1 53 12 118 16 105 30 293 32 427 0 28 -8 145 -17 260 l-17 210 26 75 c14 41 27 93 29 115 9 84 13 245 6 249 -4 3 -12 -60 -18 -139 -8 -91 -18 -155 -28 -174 -8 -17 -13 -31 -10 -31 4 0 3 -5 -1 -12 -5 -7 -16 28 -26 80 -14 73 -26 105 -58 154 -39 61 -52 68 -27 15 6 -15 15 -27 19 -27 4 0 10 -17 14 -37 3 -21 12 -47 19 -59 13 -21 24 -89 30 -185 2 -30 8 -128 14 -219 14 -229 15 -223 -6 -211 -10 5 -44 31 -75 58 -77 66 -173 133 -189 133 -14 0 80 -90 94 -90 7 0 53 -41 152 -135 l42 -40 -3 -75 c-5 -114 -14 -272 -18 -300 -20 -144 -29 -194 -41 -217 -8 -15 -15 -31 -15 -36 0 -4 -34 -56 -76 -115 -42 -59 -84 -118 -94 -132 -9 -14 -35 -62 -58 -106 -22 -45 -60 -108 -85 -140 -25 -33 -64 -95 -87 -139 -103 -193 -180 -316 -192 -309 -5 3 -7 12 -5 18 3 7 1 32 -3 57 -5 24 -11 66 -14 93 -3 27 -15 85 -25 130 -11 45 -27 134 -36 199 -8 65 -20 129 -26 143 -21 56 -74 358 -78 447 -1 9 -5 17 -10 17 -11 0 -5 -127 9 -185 5 -22 12 -62 15 -90 6 -49 27 -139 46 -201 14 -46 20 -134 9 -134 -5 0 -25 13 -43 30 -41 36 -107 65 -167 74 -63 10 -112 26 -131 43 -39 33 -169 90 -169 73 0 -6 6 -10 13 -10 7 0 35 -15 62 -34 66 -44 125 -70 205 -91 80 -21 109 -35 186 -94 59 -45 61 -48 72 -111 6 -36 13 -69 15 -75 3 -10 23 -121 36 -205 19 -122 1 -208 -70 -330 -21 -36 -45 -83 -53 -105 -7 -22 -32 -71 -55 -110 -23 -38 -41 -73 -41 -77 0 -4 -16 -43 -36 -85 -19 -42 -45 -100 -56 -127 -12 -28 -41 -89 -65 -135 -24 -46 -43 -90 -43 -98 0 -27 -17 -12 -39 35 -16 35 -21 61 -19 102 3 49 6 57 35 75 29 18 32 25 33 68 0 52 -19 122 -55 202 -13 28 -32 71 -44 97 -11 26 -21 52 -21 58 0 5 -4 18 -10 28 -5 9 -26 71 -46 137 -20 66 -40 125 -44 130 -15 22 -30 96 -30 149 0 42 5 61 19 75 28 28 42 57 45 96 1 20 10 41 21 49 17 12 18 19 8 72 -6 33 -17 73 -24 89 -15 38 -15 35 -39 130 -42 159 -44 191 -26 336 2 14 13 44 25 67 12 23 21 47 21 54 0 27 59 137 94 176 40 44 76 58 107 42 30 -16 55 -4 90 45 18 25 49 52 73 63 l41 20 61 -57 c33 -32 74 -63 91 -70 24 -10 36 -26 54 -73 13 -34 29 -63 35 -65 6 -2 25 10 43 27 39 38 55 30 72 -34 15 -56 37 -96 53 -96 26 0 53 45 60 100 8 65 9 257 3 460 -5 133 -17 219 -36 245 -27 36 -60 247 -55 344 2 50 8 69 26 88 32 34 76 56 102 49 46 -11 54 12 61 169 8 177 13 223 30 258 24 51 65 82 125 97 48 12 52 11 84 -14 19 -14 36 -36 40 -50 8 -32 32 -40 69 -21 16 8 31 15 32 15 1 0 12 -20 24 -45 12 -24 26 -47 31 -50 18 -11 49 16 77 67 37 68 67 89 113 80 50 -11 67 -55 69 -179 1 -59 30 -87 79 -80 78 13 111 79 158 317 8 41 18 118 23 172 5 53 12 101 15 107 4 6 11 36 16 67 13 78 62 181 94 196 21 9 29 8 44 -5 10 -10 24 -17 31 -17 16 0 63 52 98 108 53 85 193 130 291 96 44 -16 58 -17 110 -6 32 7 82 23 110 37 62 30 58 30 89 5 32 -25 73 -26 99 -1 11 10 36 26 55 35 19 9 72 53 119 98 157 151 236 205 340 234 63 17 67 17 84 -8z m-1438 -1942 c-15 -25 -32 -49 -39 -53 -6 -4 -18 -21 -26 -36 -8 -15 -35 -53 -61 -85 -25 -31 -61 -83 -80 -114 -19 -32 -38 -58 -42 -58 -4 0 -26 -31 -48 -70 -22 -38 -45 -70 -49 -70 -5 0 -11 -8 -15 -17 -3 -10 -17 -36 -31 -58 -29 -46 -55 -102 -55 -119 0 -6 -12 -24 -27 -41 -16 -16 -32 -37 -38 -46 -22 -36 -50 -75 -70 -99 -13 -14 -42 -58 -66 -99 -24 -40 -53 -88 -63 -105 -11 -17 -37 -65 -59 -106 -86 -162 -105 -197 -139 -255 -19 -33 -50 -82 -69 -110 -43 -64 -57 -85 -68 -110 -5 -11 -27 -41 -48 -67 -57 -70 -69 -90 -117 -180 -64 -122 -89 -173 -88 -175 1 -2 -101 -203 -131 -258 -43 -80 -167 -345 -167 -358 0 -9 -5 -19 -10 -22 -9 -6 -130 -247 -130 -260 0 -2 -13 -26 -28 -52 -15 -26 -34 -64 -42 -83 -8 -19 -24 -51 -37 -71 -13 -20 -37 -71 -54 -115 -16 -43 -36 -93 -45 -111 -52 -113 -75 -184 -81 -248 -4 -52 -13 -82 -33 -116 -15 -25 -30 -54 -32 -65 -5 -30 -36 -28 -69 6 -31 31 -31 32 -25 103 6 64 17 91 93 242 47 94 114 224 149 290 35 66 64 124 64 129 0 5 28 66 62 135 101 206 117 240 144 310 15 36 40 85 55 109 16 24 29 48 29 55 0 7 17 42 38 77 40 71 57 104 98 195 15 33 46 89 69 125 23 37 60 100 82 140 77 144 107 196 159 276 29 44 61 98 71 120 23 50 127 217 168 269 17 22 50 67 72 100 22 33 80 119 128 190 49 72 103 153 121 180 18 28 67 97 109 155 42 58 96 134 121 170 86 128 179 263 199 290 34 46 145 191 158 205 23 25 19 6 -7 -39z"/>
                                                            <path
                                                                d="M3165 4299 c-66 -4 -129 -9 -140 -12 -11 -4 -54 -8 -95 -11 -93 -5 -198 -28 -268 -57 -70 -29 -53 -47 18 -20 29 11 74 23 99 26 25 4 53 9 61 12 8 3 31 7 50 9 19 2 68 9 109 16 57 9 76 9 79 0 2 -7 12 -12 23 -12 21 0 49 -16 114 -65 22 -16 59 -39 83 -49 23 -10 42 -22 42 -26 0 -14 61 -33 71 -23 6 6 -7 17 -36 32 -24 12 -47 26 -50 32 -4 5 -23 18 -43 29 -20 10 -57 37 -82 59 l-45 40 164 0 c104 0 167 3 174 10 8 8 -13 11 -71 12 -45 1 -94 2 -109 3 -16 0 -82 -2 -148 -5z"/>
                                                            <path
                                                                d="M3510 4300 c0 -5 5 -10 11 -10 5 0 7 5 4 10 -3 6 -8 10 -11 10 -2 0 -4 -4 -4 -10z"/>
                                                            <path
                                                                d="M2162 4197 c-7 -18 -12 -49 -12 -68 0 -35 -23 -221 -39 -324 -6 -33 -13 -77 -16 -97 -3 -22 -2 -38 4 -38 17 0 19 15 40 205 5 44 14 130 21 190 6 61 15 122 20 138 13 39 -4 34 -18 -6z"/>
                                                            <path
                                                                d="M570 598 c-23 -11 -21 -12 29 -18 49 -4 53 -6 37 -19 -15 -12 -19 -13 -26 -1 -7 11 -11 11 -24 1 -11 -9 -14 -24 -10 -54 3 -23 9 -45 13 -50 13 -14 115 13 139 37 22 21 22 24 7 40 -9 9 -27 16 -41 16 -21 0 -24 3 -18 25 4 18 2 25 -9 25 -8 0 -27 2 -43 5 -16 2 -40 -1 -54 -7z m135 -88 c0 -8 -15 -19 -33 -24 -27 -7 -36 -6 -50 8 -15 15 -15 18 -2 26 23 15 85 8 85 -10z"/>
                                                            <path d="M775 469 c-4 -6 -4 -13 -1 -16 8 -8 36 5 36 17 0 13 -27 13 -35 -1z"/>
                                                            </g>
                                                            </svg>
                                                        </span>
                                                        <h2>Courses</h2>
                                                        <p>The design path includes branding, print design, graphic design, UX and UI. You will also find fantastic 1-to-1 and corporate training
                                                            options.</p>
                                                        <a href="#" class="view-btn">View all courses</a>
                                                    </div>
                                                    <div class="detail-icons">
                                                                                                                <span class="icon-img">
                                                                                                                    <img src="../assets/default/img/bycicle.png" alt="image">
                                                                                                                </span>
                                                        <span class="icon-img">
                                                                                                                    <img src="../assets/default/img/women.png" alt="image">
                                                                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if( isset( $nagivation_data['chapters'] ) && !empty( $nagivation_data['chapters']))
                                            <div class="col-12 col-lg-9 col-md-8">
                                                <div class="row">
                                                    @foreach($nagivation_data['chapters'] as $chapter_id => $chapter_data)
                                                    <div class="col-12 col-lg-4 col-md-6">
                                                        <div class="menu-colum-text">
                                                            <h2>{{isset( $chapter_data['chapter_title'] )? $chapter_data['chapter_title'] : ''}}</h2>
                                                            @if( isset( $chapter_data['topics']) && !empty( $chapter_data['topics'] ) )
                                                                <ul class="topic-list">
                                                                    @php $topics_count = 1; @endphp
                                                                    @foreach($chapter_data['topics'] as $topic_id => $topic_title)
                                                                        @if( $topics_count <= 5)
                                                                            <li><a href="/course/{{$chapter_data['chapter_slug']}}#subject_{{$topic_id}}">{{$topic_title}}</a></li>
                                                                        @endif
                                                                        @php $topics_count++; @endphp
                                                                    @endforeach
                                                                    <li class="load-more"><a href="#">load More..</a></li>
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="col-12 col-lg-4 col-md-6">
                                                        <div class="get-offer">
                                                            <strong>20% Off</strong>
                                                        </div>
                                                    </div>
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

                        @include(getTemplate().'.includes.notification-dropdown')
                    </div>
                    @endif

                    @if(!empty($authUser))


                    <div class="dropdown">
                        <a href="#!" class="navbar-user d-flex align-items-center ml-50 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            <img src="{{ $authUser->getAvatar() }}" class="rounded-circle" alt="{{ $authUser->full_name }}">
                            <span class="font-16 user-name ml-10 text-dark-blue font-14">{{ $authUser->full_name }}</span>
                        </a>

                        <div class="dropdown-menu user-profile-dropdown" aria-labelledby="dropdownMenuButton">
                            <div class="d-md-none border-bottom mb-20 pb-10 text-right">
                                <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
                            </div>

                            <a class="dropdown-item" href="{{ $authUser->isAdmin() ? '/admin' : '/panel' }}">
                                <img src="/assets/default/img/icons/sidebar/dashboard.svg" width="25" alt="nav-icon">
                                <span class="font-14 text-dark-blue">{{ trans('public.my_panel') }}</span>
                            </a>
                            @if($authUser->isTeacher() or $authUser->isOrganization())
                            <a class="dropdown-item" href="{{ $authUser->getProfileUrl() }}">
                                <img src="/assets/default/img/icons/profile.svg" width="25" alt="nav-icon">
                                <span class="font-14 text-dark-blue">{{ trans('public.my_profile') }}</span>
                            </a>
                            @endif
                            <a class="dropdown-item" href="/logout">
                                <img src="/assets/default/img/icons/sidebar/logout.svg" width="25" alt="nav-icon">
                                <span class="font-14 text-dark-blue">{{ trans('panel.log_out') }}</span>
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="d-flex align-items-center ml-md-50">
                        <a href="/login" class="py-5 px-10 mr-10 text-dark-blue font-14">{{ trans('auth.login') }}</a>
                        <a href="/register" class="py-5 px-10 text-dark-blue font-14">{{ trans('auth.register') }}</a>
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
