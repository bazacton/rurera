@extends(getTemplate().'.layouts.app')

@push('styles_top')
    @if($page->id == 11 || $page->id == 50)
        <link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endif
@endpush

@section('content')

@if($page->id == 32)


<section class="cart-banner position-relative text-center pages-sub-header ebook-header">
    <div class="container h-100">
        <div class="row h-100  text-left">
            <div class="col-12 col-md-9 col-lg-7">
                <h1 class="font-30 font-weight-bold">e-book Library</h1>
            </div>
        </div>
        <div class="products-filter mt-30">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-9">
                    <ul class="sub-header-iconlist d-flex align-items-center">
                        <li><a href="#">
                                <span>

                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                            <path d="M433 4945 c-100 -31 -190 -112 -241 -215 l-27 -55 0 -1555 0 -1555 29 -60 c38 -77 114 -153 191 -191 l60 -29 806 -3 806 -2 -53 -268 c-30 -147 -59 -290 -64 -319 l-11 -51 -122 -4 c-115 -3 -127 -5 -188 -35 -89 -44 -146 -108 -208 -232 -56 -111 -64 -158 -31 -191 20 -20 33 -20 1180 -20 1147 0 1160 0 1180 20 36 36 31 69 -32 193 -61 122 -119 186 -207 230 -61 30 -73 32 -188 35 l-122 4 -11 51 c-5 29 -34 172 -64 319 l-53 268 806 2 806 3 60 29 c77 38 153 114 191 191 l29 60 3 1572 2 1572 -21 56 c-28 74 -99 146 -174 174 l-56 21 -2117 -1 c-1729 0 -2125 -3 -2159 -14z m4231 -155 c49 -11 85 -37 111 -81 20 -33 20 -55 23 -1171 l2 -1138 -2240 0 -2241 0 3 1103 c3 1096 3 1102 24 1147 36 77 100 127 179 141 61 10 4094 10 4139 -1z m134 -2852 c-3 -343 -6 -358 -85 -429 -76 -69 88 -64 -2158 -64 l-2040 0 -45 21 c-57 27 -97 67 -124 124 -20 42 -21 65 -24 348 l-4 302 2242 0 2242 0 -4 -302z m-1899 -710 c6 -29 35 -173 65 -320 l53 -268 -457 0 -457 0 53 268 c30 147 59 291 65 320 l10 52 329 0 329 0 10 -52z m453 -757 c66 -11 126 -48 162 -100 14 -20 26 -40 26 -44 0 -4 -441 -7 -980 -7 -539 0 -980 2 -980 5 0 3 12 24 27 46 31 47 99 90 157 100 64 10 1524 10 1588 0z"/>
                                            <path d="M1220 4620 c-18 -18 -20 -33 -20 -160 l0 -140 -140 0 c-127 0 -142 -2 -160 -20 -20 -20 -20 -33 -20 -860 0 -827 0 -840 20 -860 20 -20 33 -20 1660 -20 1627 0 1640 0 1660 20 20 20 20 33 20 860 0 827 0 840 -20 860 -20 20 -33 20 -825 20 l-805 0 -640 160 c-352 88 -656 160 -675 160 -22 0 -43 -8 -55 -20z m705 -308 l550 -138 3 -712 c1 -392 -1 -712 -5 -712 -5 0 -255 63 -558 138 l-550 138 -3 712 c-1 392 1 712 5 712 5 0 256 -63 558 -138z m-725 -770 c0 -509 2 -621 14 -637 10 -14 96 -40 337 -101 l324 -82 -417 -1 -418 -1 0 720 0 720 80 0 80 0 0 -618z m2880 -102 l0 -720 -720 0 -720 0 0 720 0 720 720 0 720 0 0 -720z"/>
                                            <path d="M2800 3920 l0 -80 80 0 80 0 0 80 0 80 -80 0 -80 0 0 -80z"/>
                                            <path d="M3120 3920 l0 -80 400 0 400 0 0 80 0 80 -400 0 -400 0 0 -80z"/>
                                            <path d="M2800 3600 l0 -80 160 0 160 0 0 80 0 80 -160 0 -160 0 0 -80z"/>
                                            <path d="M3280 3600 l0 -80 320 0 320 0 0 80 0 80 -320 0 -320 0 0 -80z"/>
                                            <path d="M2800 3280 l0 -80 280 0 280 0 0 80 0 80 -280 0 -280 0 0 -80z"/>
                                            <path d="M3520 3280 l0 -80 200 0 200 0 0 80 0 80 -200 0 -200 0 0 -80z"/>
                                            <path d="M2800 2960 l0 -80 360 0 360 0 0 80 0 80 -360 0 -360 0 0 -80z"/>
                                            <path d="M3680 2960 l0 -80 120 0 120 0 0 80 0 80 -120 0 -120 0 0 -80z"/>
                                            <path d="M2455 2061 c-87 -40 -135 -120 -135 -223 1 -142 97 -238 240 -238 144 0 240 96 240 240 0 104 -53 187 -142 224 -52 22 -153 20 -203 -3z m155 -171 c11 -11 20 -33 20 -50 0 -17 -9 -39 -20 -50 -11 -11 -33 -20 -50 -20 -17 0 -39 9 -50 20 -11 11 -20 33 -20 50 0 17 9 39 20 50 11 11 33 20 50 20 17 0 39 -9 50 -20z"/>
                                        </g>
                                    </svg>

                                </span>
                                All Book</a></li>
                        <li><a href="#">
                                <span>

                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="702.000000pt" height="866.000000pt" viewBox="0 0 702.000000 866.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,866.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                            <path d="M880 8641 c-8 -5 -51 -16 -95 -26 -197 -43 -370 -141 -516 -291 -108 -111 -171 -214 -238 -387 l-31 -79 0 -3521 0 -3521 21 -75 c25 -89 93 -239 140 -308 46 -68 183 -208 254 -258 84 -60 180 -109 284 -145 l88 -30 3050 0 3050 0 46 49 c53 56 61 80 55 156 -6 72 -42 125 -105 156 -47 24 -54 24 -380 27 l-333 3 0 620 0 619 338 0 c307 0 341 2 378 19 46 21 83 65 107 127 14 38 15 303 12 2930 -3 1589 -7 2928 -10 2976 -9 148 -89 377 -176 505 -55 82 -209 231 -293 285 -130 83 -295 147 -425 162 -82 10 -5204 17 -5221 7z m5242 -427 c113 -28 185 -71 278 -164 95 -95 135 -164 169 -293 21 -77 21 -81 21 -2902 l0 -2825 -2852 0 c-2775 0 -2855 -1 -2940 -20 -99 -22 -224 -70 -286 -112 -24 -15 -47 -28 -51 -28 -5 0 -14 -7 -21 -15 -7 -8 -21 -15 -31 -15 -19 0 -19 70 -19 2928 0 2403 2 2931 13 2947 7 11 19 40 26 65 18 62 47 124 66 140 8 7 15 18 15 25 0 18 165 185 184 185 9 0 16 5 16 10 0 6 9 10 19 10 11 0 21 3 23 8 2 4 35 18 73 32 64 23 89 25 290 30 121 3 1283 7 2582 8 2123 2 2368 0 2425 -14z m-362 -7204 l0 -620 -2420 0 -2420 0 -92 30 c-161 51 -286 154 -361 297 -51 97 -67 168 -67 293 0 184 51 310 175 435 90 91 191 144 340 178 11 3 1106 5 2433 6 l2412 1 0 -620z"/>
                                            <path d="M3278 6976 c-36 -6 -70 -14 -74 -18 -4 -5 -18 -8 -30 -8 -13 0 -26 -4 -29 -10 -3 -5 -17 -10 -31 -10 -13 0 -24 -4 -24 -10 0 -5 -9 -10 -20 -10 -11 0 -20 -4 -20 -10 0 -5 -9 -10 -20 -10 -11 0 -20 -4 -20 -10 0 -5 -4 -10 -10 -10 -22 0 -180 -123 -246 -191 -135 -141 -206 -270 -264 -479 -29 -107 -29 -362 0 -476 61 -239 189 -437 372 -577 96 -73 255 -151 376 -185 87 -24 114 -27 252 -26 85 0 175 5 200 12 137 34 280 97 395 175 79 53 205 183 259 266 61 94 89 152 127 266 31 94 33 110 37 272 3 135 0 187 -12 244 -69 299 -244 541 -496 681 -25 14 -61 34 -80 45 -46 26 -179 69 -254 82 -75 14 -300 12 -388 -3z m414 -425 c211 -81 350 -232 402 -437 26 -100 21 -246 -10 -340 -64 -193 -239 -362 -429 -415 -29 -8 -97 -14 -165 -14 -68 0 -136 6 -165 14 -160 45 -320 179 -399 337 -58 115 -73 299 -35 434 53 193 202 351 396 419 81 29 93 30 228 27 94 -3 132 -8 177 -25z"/>
                                            <path d="M2875 4498 c-122 -31 -316 -117 -391 -173 -51 -39 -224 -217 -257 -264 -106 -154 -177 -367 -177 -532 0 -109 13 -143 78 -199 44 -39 46 -40 123 -40 77 0 80 1 119 37 70 63 79 81 91 194 19 184 63 283 179 399 77 77 149 122 250 156 51 18 94 19 600 19 604 0 579 2 714 -69 88 -45 204 -166 248 -257 47 -95 58 -138 58 -221 0 -92 28 -165 85 -217 l45 -41 90 0 c89 0 90 0 129 35 59 54 71 87 71 204 0 169 -68 373 -177 532 -44 64 -230 247 -288 284 -92 58 -221 114 -321 140 l-99 25 -565 -1 c-336 -1 -581 -6 -605 -11z"/>
                                        </g>
                                    </svg>

                                </span>
                                Non-fiction</a></li>
                        <li><a href="#">
                                <span>

                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">

                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                            <path d="M3576 5105 c-78 -28 -136 -115 -136 -205 0 -64 37 -184 88 -285 l49 -98 -30 -86 c-35 -102 -46 -231 -28 -336 74 -423 512 -686 914 -548 l84 30 110 -54 c206 -101 337 -107 428 -20 29 29 47 57 55 87 31 116 -29 302 -166 515 -29 45 -32 60 -37 145 -20 358 -300 638 -657 657 -93 5 -96 6 -174 56 -208 131 -387 183 -500 142z m176 -206 c34 -11 79 -30 101 -41 l40 -20 -49 -30 c-27 -17 -67 -46 -88 -64 -22 -19 -43 -34 -47 -34 -19 0 -76 180 -64 201 9 14 40 11 107 -12z m619 -217 c189 -66 319 -234 335 -435 11 -133 -40 -275 -134 -378 l-50 -54 -98 75 c-128 96 -439 407 -534 533 l-73 98 34 36 c62 65 183 129 279 147 50 9 186 -3 241 -22z m-372 -683 c69 -69 167 -160 218 -202 l92 -76 -45 -7 c-138 -20 -320 48 -418 156 -98 109 -151 266 -132 394 l7 45 76 -92 c42 -51 133 -149 202 -218z m879 -192 c34 -82 48 -152 33 -161 -24 -15 -201 45 -201 68 0 7 11 23 25 36 14 13 42 49 62 81 21 32 41 56 44 53 4 -2 21 -37 37 -77z"/>
                                            <path d="M1489 4629 c-26 -28 -29 -38 -29 -100 l0 -69 -71 0 c-65 0 -73 -2 -100 -29 -44 -44 -38 -111 15 -153 15 -13 40 -18 89 -18 l67 0 0 -60 c0 -70 17 -111 55 -128 51 -23 107 -7 131 39 8 16 14 55 14 89 l0 60 60 0 c34 0 74 7 89 15 58 29 66 124 14 165 -20 16 -40 20 -94 20 l-69 0 0 71 c0 65 -2 73 -29 100 -42 42 -102 41 -142 -2z"/>
                                            <path d="M2390 3854 c-396 -50 -723 -239 -912 -525 -73 -110 -102 -169 -143 -292 -22 -67 -40 -104 -52 -109 -10 -4 -70 -21 -133 -38 -345 -95 -577 -237 -662 -404 -31 -61 -35 -157 -9 -226 54 -142 236 -279 490 -370 l89 -32 4 -91 c3 -78 8 -100 33 -146 111 -202 394 -215 516 -22 16 25 34 63 40 83 5 21 15 38 22 38 28 0 230 -29 234 -34 4 -4 -331 -733 -342 -745 -5 -5 -91 -25 -245 -56 -193 -40 -384 -64 -630 -77 -162 -8 -231 -16 -248 -26 -13 -9 -60 -89 -115 -198 l-92 -184 -85 0 c-65 0 -90 -4 -106 -18 -43 -34 -54 -79 -32 -127 24 -54 32 -55 478 -55 446 0 454 1 478 55 22 48 11 93 -32 127 -18 15 -48 18 -243 18 -123 0 -223 2 -223 5 0 3 21 47 47 99 l46 93 131 7 c316 17 486 42 871 129 251 56 279 61 395 61 139 0 213 -15 315 -65 104 -52 184 -148 185 -222 0 -58 46 -107 100 -107 54 0 100 49 100 107 1 74 79 167 187 222 99 50 173 65 313 65 116 0 144 -5 395 -61 396 -89 501 -105 816 -125 l186 -12 47 -93 c25 -51 46 -95 46 -98 0 -3 -390 -5 -866 -5 l-865 0 -103 -100 -103 -100 -153 0 -153 0 -103 100 -103 100 -228 0 c-201 0 -231 -2 -249 -18 -43 -34 -54 -79 -32 -127 22 -49 51 -55 245 -55 l178 0 85 -86 c47 -47 97 -92 112 -100 39 -20 457 -20 496 0 15 8 65 53 112 100 l85 86 1018 0 c1106 0 1059 -2 1085 55 22 48 11 93 -32 127 -16 14 -41 18 -106 18 l-85 0 -92 184 c-55 109 -102 189 -115 198 -17 10 -86 18 -248 26 -229 12 -422 35 -610 73 -116 23 -261 56 -265 61 -12 12 -346 740 -342 744 4 5 211 34 239 34 4 0 12 -17 17 -38 15 -52 62 -124 104 -156 151 -115 361 -71 452 95 25 46 30 68 33 146 l4 92 52 17 c95 31 244 101 313 147 196 131 271 286 212 442 -18 48 -38 76 -103 140 -123 122 -293 207 -556 281 -69 20 -133 39 -143 43 -13 4 -28 35 -46 91 -138 423 -468 715 -919 810 -95 21 -392 35 -482 24z m330 -204 c266 -33 504 -147 662 -319 159 -171 234 -351 273 -653 3 -27 4 -48 1 -48 -2 0 -76 -18 -163 -40 -355 -89 -620 -124 -933 -124 -240 0 -388 14 -640 60 -147 27 -440 99 -451 111 -10 11 8 156 30 244 76 303 255 528 526 660 204 99 453 138 695 109z m-1458 -1021 c-4 -94 8 -134 48 -154 92 -48 536 -149 820 -187 237 -32 624 -32 860 0 273 37 634 116 784 172 76 29 88 54 84 166 -2 61 0 84 9 84 33 0 270 -86 363 -132 115 -57 213 -140 226 -191 34 -140 -181 -276 -592 -376 -431 -104 -1103 -167 -1519 -142 -453 28 -853 84 -1172 165 -343 87 -541 224 -509 351 17 69 158 173 321 237 78 30 250 86 270 87 6 1 9 -30 7 -80z m116 -855 c52 -11 82 -22 82 -31 0 -7 -13 -27 -29 -45 -24 -27 -36 -33 -71 -33 -35 0 -47 6 -71 33 -35 38 -43 107 -11 98 9 -3 54 -13 100 -22z m2482 -9 c0 -24 -9 -44 -29 -67 -24 -27 -36 -33 -71 -33 -35 0 -47 6 -71 33 -16 18 -29 38 -29 46 0 10 95 38 193 55 4 0 7 -15 7 -34z m-1598 -192 c3 -85 8 -105 33 -152 117 -213 413 -213 530 0 25 47 30 67 33 152 l4 98 66 -3 65 -3 72 -155 c40 -85 110 -236 157 -335 l84 -180 -155 -1 c-127 -1 -171 -5 -236 -23 -109 -29 -230 -91 -298 -152 l-57 -51 -57 51 c-68 61 -189 123 -298 152 -65 18 -109 22 -236 23 l-157 1 13 25 c7 14 77 162 155 330 78 168 144 308 147 313 2 4 33 7 67 7 l64 0 4 -97z m398 22 c0 -57 -3 -68 -29 -97 -24 -27 -36 -33 -71 -33 -35 0 -47 6 -71 33 -26 29 -29 40 -29 97 l0 65 100 0 100 0 0 -65z"/>
                                            <path d="M2374 3445 c-217 -39 -366 -115 -496 -253 -95 -101 -178 -261 -178 -343 0 -44 47 -91 93 -92 56 -1 87 28 119 112 89 232 289 365 582 387 100 7 133 19 151 55 26 49 15 96 -29 131 -26 21 -135 23 -242 3z"/>
                                            <path d="M689 3631 c-27 -27 -29 -35 -29 -100 l0 -71 -71 0 c-65 0 -73 -2 -100 -29 -42 -42 -41 -102 2 -142 28 -26 38 -29 100 -29 l69 0 0 -69 c0 -64 2 -72 31 -100 45 -46 108 -40 151 13 13 15 18 40 18 89 l0 67 61 0 c93 0 138 33 139 103 0 31 -7 45 -31 68 -28 26 -38 29 -100 29 l-69 0 0 71 c0 65 -2 73 -29 100 -23 23 -38 29 -71 29 -33 0 -48 -6 -71 -29z"/>
                                            <path d="M1267 376 c-78 -73 -14 -198 88 -172 110 28 88 196 -25 196 -25 0 -45 -8 -63 -24z"/>
                                        </g>
                                    </svg>

                                </span>
                                Fiction</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-12 col-lg-3">
                    <form action="#">
                        <div class="d-flex align-items-center reading-levels">
                            <select name="sort" class="form-control font-16">
                                <option value="">All Reading Levels</option>
                                <option value="newest">Newest</option>
                                <option value="expensive">Highest Price</option>
                                <option value="inexpensive">Lowest Price</option>
                                <option value="bestsellers">Bestsellers</option>
                                <option value="best_rates">Best Rated</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@elseif($page->id == 31)
<section class="pages-sub-header lms-course-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-9">
                <p class="lms-subtitle">Programme of study</p>
                <h1 class="font-30 font-weight-bold">National Curriculum</h1>
                <p>Skills available for England key stage 2, Year 5 maths objectives</p>
                <div class="lms-course-select">
                    <form>
                        <div class="form-inner">
                            <div class="form-select-field">
                                <select>
                                    <option>Key Stage</option>
                                </select>
                            </div>
                            <div class="form-select-field">
                                <select>
                                    <option>Maths</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-3 sub-header-img">
                <figure>
                    <img src="../assets/default/img/ukflag-img.png">
                </figure>

            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="lms-element-nav">
                    <ul>
                        <li>
                            <a href="#lms-numbers">Numbers</a>
                        </li>
                        <li>
                            <a href="#lms-measurement">Measurement</a>
                        </li>
                        <li>
                            <a href="#">Geometry</a>
                        </li>
                        <li>
                            <a href="#">Statistics</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@elseif($page->id == 21)
<section class="site-top-banner products-top-header search-top-banner opacity-04 position-relative">
    <div class="container h-100">
        <div class="row h-100 justify-content-center text-center">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="top-search-categories-form">
                    <h1 class="font-30 mb-15">{{ $pageTitle }}</h1>

                    <div class="search-input bg-white flex-grow-1">
                        <form action="/blog" method="get">
                            <div class="form-group d-flex align-items-center m-0">
                                <span class="search-icon"><i data-feather="search" width="20" height="20" class=""></i></span>
                                <input type="text" name="search" class="form-control border-0" value="{{ request()->get('search') }}" placeholder="How can we help?"/>
                                <button type="submit" class="btn btn-primary">{{ trans('home.find') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@elseif($page->id == 25)
<section class="cart-banner position-relative text-center pages-sub-header">
    <div class="container h-100">
        <div class="row h-100 align-items-center text-left">
            <div class="col-12 col-md-9 col-lg-9">
                <p class="lms-subtitle">Start Learning with confidence</p>
                <h1 class="font-30 font-weight-bold">ks2- year - 5</h1>
                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its
                    layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using
                    'Content here, content here',</p>
            </div>
            <div class="col-12 col-md-3 col-lg-3 sub-header-img">
                <figure><img src="../assets/default/img/sub-header-icon.png" alt="#">
                        <figcaption>
                            <div class="header-img-title">
                                <strong>Want to read this book again?</strong>
                            </div>
                        </figcaption>
                </figure>
            </div>
        </div>
    </div>
</section>
<section class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="post-show" style="overflow:hidden;">
                @else
                <section class="cart-banner position-relative text-center pages-sub-header">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center justify-content-center text-center">
                            <div class="col-12 col-md-9 col-lg-7">
                                <h1 class="font-30 font-weight-bold">{{ $page->title }}</h1>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="container mt-10 mt-md-40">
                    <div class="row">
                        <div class="col-12">
                            <div class="post-show mt-30">
                                @endif

                                {!! nl2br($page->content) !!}
                            </div>
                        </div>
                    </div>
                </section>
                @endsection

                @push('scripts_bottom')
                    @if($page->id == 11 || $page->id == 50)
                        <script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
                        <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
                    @endif
                    @if($page->id == 44)
                        <script src="/assets/default/vendors/draw-lines/draw-lines.js"></script>
                    @endif
                @endpush
