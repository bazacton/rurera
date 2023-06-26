@extends(getTemplate().'.layouts.app')

@push('styles_top')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="/assets/vendors/flipbook/css/slide-menu.css">
<script src="/assets/vendors/flipbook/js/flipbook.min.js"></script>
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css">
<style>nav.navbar, nav.navbar1, footer {
                display: none;
        }</style>

<script type="text/javascript">

    $(document).ready(function () {
        $(".read-quiz-info").flipBook({
            pdfUrl:'store/1/books/2016-Sample-Reading-Booklet.pdf',
            btnZoomIn : {enabled:true},
            			btnZoomOut : {enabled:true},
            			btnToc : {enabled:false},
            			btnShare : {enabled:false},
            			btnDownloadPages : {enabled:false},
            			btnDownloadPdf : {enabled:false},
            			btnSound : {enabled:false},
                        btnAutoplay : {enabled:false},
                        btnSelect : {enabled:false},
                        btnBookmark : {enabled:false},
                        btnThumbs : {enabled:false},
                        btnPrint : {enabled:false},
                        currentPage:{enabled:false},
                        // btnNext: {enabled:true, icon: 'fa-long-arrow-right', title: 'Next page'},
                        // btnPrev: {enabled:true, icon: 'fa-long-arrow-left', title: 'Previouse page'},

                        viewMode:"swipe",
            			singlePageMode:true,

                        skin:'dark',

                        menuMargin:10,
                        menuBackground:'none',
                        menuShadow:'none',
                        menuAlignHorizontal:'right',
                        menuOverBook:true,

                        btnRadius:40,
                        btnMargin:4,
                        btnSize:14,
                        btnPaddingV:16,
                        btnPaddingH:16,
                        btnBorder:'2px solid rgba(255,255,255,.7)',
                        btnBackground:"rgba(0,0,0,.3)",
                        btnColor:'rgb(255,120,60)',

                        sideBtnRadius:60,
                        sideBtnSize:60,
                        sideBtnBackground:"rgba(0,0,0,.7)",
                        sideBtnColor:'rgb(255,120,60)',
        });
    });
</script>

@endpush

@section('content')
<section class="content-section">


    
    <section class="lms-quiz-section">
        <div class="read-quiz-info quiz-show">
        </div>
        <div class="container-fluid read-quiz-content">
            <section class="quiz-topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <div class="quiz-top-info">
                                <p>Smarter Balanced Grade 8 ELA Practice ( 3/ 25 Questions )</p>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12">
                            <div class="topbar-right">
                                <div class="quiz-pagination">
                                    <div class="swiper-container">
                                        <ul class="swiper-wrapper">
                                            <li class="swiper-slide"><a href="#">1</a></li>
                                            <li class="swiper-slide"><a href="#">2</a></li>
                                            <li class="swiper-slide"><a href="#">3</a></li>
                                            <li class="swiper-slide"><a href="#">4</a></li>
                                            <li class="swiper-slide"><a href="#">5</a></li>
                                            <li class="swiper-slide"><a href="#">6</a></li>
                                            <li class="swiper-slide"><a href="#">7</a></li>
                                            <li class="swiper-slide"><a href="#">8</a></li>
                                            <li class="has-flag swiper-slide"><a href="#"> 9</a></li>
                                            <li class="swiper-slide"><a href="#">10</a></li>
                                            <li class="has-flag swiper-slide"><a href="#">11</a></li>
                                            <li class="swiper-slide"><a href="#">12</a></li>
                                            <li class="swiper-slide"><a href="#">13</a></li>
                                            <li class="swiper-slide"><a href="#">14</a></li>
                                            <li class="swiper-slide"><a href="#">15</a></li>
                                            <li class="swiper-slide"><a href="#">16</a></li>
                                            <li class="swiper-slide"><a href="#">17</a></li>
                                            <li class="swiper-slide"><a href="#">18</a></li>
                                            <li class="swiper-slide"><a href="#">19</a></li>
                                            <li class="has-flag swiper-slide"><a href="#">20</a></li>
                                        </ul>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                                <div class="quiz-timer"><span class="timer-number">4<em>m</em></span> <span
                                        class="timer-number">50<em>s</em></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 col-sm-12 mt-50">
                    <span class="question-number-holder">
                    <span class="question-number">7</span>
                    <span class="question-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt" height="512.000000pt"
                            viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                stroke="none">
                                <path
                                    d="M1620 4674 c-46 -20 -77 -50 -103 -99 l-22 -40 -3 -1842 -2 -1843 -134 0 c-120 0 -137 -2 -177 -23 -24 -13 -57 -43 -74 -66 -27 -39 -30 -50 -30 -120 0 -66 4 -83 25 -114 14 -21 43 -50 64 -65 l39 -27 503 0 502 0 44 30 c138 97 118 306 -34 370 -27 11 -73 15 -168 15 l-130 0 0 750 0 750 1318 2 1319 3 40 28 c83 57 118 184 75 267 -10 19 -140 198 -290 398 -170 225 -270 367 -265 375 4 7 128 174 276 372 149 197 276 374 283 392 19 45 17 120 -5 168 -23 51 -79 101 -128 114 -26 7 -459 11 -1330 11 l-1293 0 0 20 c0 58 -56 137 -122 171 -45 23 -128 25 -178 3z"></path>
                            </g>
                        </svg>
                    </span>
                    </span>
                    <span>A family of 2 adults and 3 children went to a movie. the tickets cost $8 for adults and $5 for children. which expression represents the total cost of the tickets?</span>
                    <div class="img-holder text-center mb-50">
                        <figure><img src="../assets/default/img/graph-img.png" alt=""></figure>
                    </div>
                    <div class="mb-50 p-0 text-center">
                        <div class="question-label">
                            <span>Solve the follwing problems. Use pen and paper where required</span></div>
                        <span> <span>1 x 2 x 3</span> <span class="input-holder"> <input type="text"
                                                                                         class="editor-field input-simple extra-small"> </span> <span>1 + 2 + 3</span> </span>
                        <span> <span>2 x 2 x 2</span> <span class="input-holder"> <input type="text"
                                                                                         class="editor-field input-simple extra-small"> </span> <span>2 + 2 + 2</span> </span>
                        <span> <span>1 x 10 x 10</span> <span class="input-holder"> <input type="text"
                                                                                           class="editor-field input-simple extra-small"> </span> <span>1 + 10 + 10</span> </span>
                        <span> <span>0 x 10 x 10</span> <span class="input-holder"> <input type="text"
                                                                                           class="editor-field input-simple extra-small"> </span> <span>0 + 10 + 10</span> </span>
                        <span class="marks">1 mark</span>
                    </div>
                    <div class="prev-next-controls text-center mb-50">
                        <a href="#" class="review-btn">
                            Review
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt"
                                 height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                                 preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                        d="M1405 5080 c-350 -40 -655 -161 -975 -388 -18 -13 -21 -9 -48 47 -24 50 -28 70 -24 114 12 153 -150 248 -279 162 -42 -27 -79 -96 -79 -146 0 -47 38 -120 76 -144 18 -11 39 -24 47 -30 9 -5 498 -1013 1088 -2240 589 -1227 1088 -2264 1109 -2305 45 -89 80 -115 142 -107 65 9 115 71 105 132 -3 18 -228 496 -501 1063 -273 566 -496 1034 -496 1038 1 5 29 30 63 55 204 153 442 257 707 311 164 33 453 33 618 0 179 -36 311 -84 537 -197 128 -64 257 -120 330 -144 358 -117 765 -109 1118 19 90 33 130 65 158 125 22 48 24 89 5 141 -34 96 -999 2081 -1024 2107 -66 70 -129 76 -282 27 -181 -57 -256 -70 -415 -77 -170 -6 -278 5 -430 44 -133 34 -213 67 -413 167 -250 125 -368 166 -586 207 -127 23 -421 33 -551 19z m665 -297 c123 -34 232 -79 405 -167 77 -40 163 -81 190 -92 l50 -20 99 -210 c54 -115 101 -215 104 -222 2 -8 -35 6 -84 31 -179 90 -382 152 -576 178 l-93 12 -117 246 c-64 135 -120 255 -124 265 -8 22 -10 22 146 -21z m-814 -297 c74 -154 134 -284 134 -290 0 -6 -28 -22 -62 -35 -131 -49 -324 -161 -447 -260 -35 -29 -68 -48 -72 -44 -9 10 -290 595 -287 598 2 1 30 22 63 47 82 62 206 138 290 178 90 43 216 90 234 87 7 -1 74 -128 147 -281z m2804 -279 c88 -183 135 -290 127 -292 -153 -51 -500 -94 -523 -64 -15 20 -254 525 -254 536 0 6 37 13 82 17 94 8 216 33 333 70 44 13 84 24 88 23 4 -1 71 -132 147 -290z m-1739 -274 l166 -348 -176 -7 c-185 -7 -321 -28 -471 -72 -47 -14 -88 -22 -91 -18 -19 22 -328 687 -322 693 13 11 181 55 278 73 114 20 139 22 310 24 l141 2 165 -347z m729 47 c121 -62 328 -119 506 -140 l101 -12 91 -191 c50 -106 125 -263 167 -351 l75 -158 -67 7 c-186 18 -390 76 -545 154 l-92 46 -109 230 c-60 127 -133 280 -162 342 -59 124 -60 121 35 73z m-321 -451 c131 -27 312 -89 433 -149 57 -28 108 -57 114 -63 14 -15 306 -628 301 -633 -2 -2 -41 15 -88 38 -168 82 -416 155 -593 175 l-69 8 -153 323 c-85 177 -154 325 -154 328 0 9 99 -4 209 -27z m-835 -381 c81 -172 147 -317 146 -323 -2 -5 -40 -24 -84 -41 -164 -63 -298 -135 -431 -231 -32 -24 -62 -43 -65 -43 -6 0 -75 140 -236 477 l-63 132 62 49 c139 108 281 193 437 259 41 18 77 32 80 33 3 0 72 -141 154 -312z m2811 -281 l154 -318 -27 -10 c-106 -41 -319 -79 -438 -79 l-71 0 -152 321 c-84 176 -151 323 -148 325 2 3 66 9 141 14 124 9 296 39 350 60 12 5 25 8 30 6 4 -1 77 -145 161 -319z"></path>
                                </g>
                            </svg>
                        </a>
                        <a href="#" class="prev-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt"
                                 height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                                 preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                        d="M3620 5103 c-39 -13 -198 -168 -1238 -1207 -1095 -1093 -1194 -1195 -1212 -1244 -25 -67 -25 -117 0 -184 18 -49 117 -151 1212 -1244 1141 -1140 1195 -1193 1247 -1209 214 -69 408 147 315 352 -11 25 -377 398 -1093 1115 l-1076 1078 1076 1077 c701 703 1082 1091 1093 1115 61 135 -4 297 -140 348 -64 23 -121 24 -184 3z"></path>
                                </g>
                            </svg>
                        </a>
                        <a href="#" class="next-btn">
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="512.000000pt"
                                 height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                                 preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000"
                                   stroke="none">
                                    <path
                                        d="M1340 5111 c-118 -36 -200 -156 -187 -272 3 -27 14 -66 23 -86 11 -25 377 -398 1093 -1116 l1076 -1077 -1076 -1078 c-716 -717 -1082 -1090 -1093 -1115 -61 -135 4 -296 140 -347 66 -24 114 -25 180 -4 45 15 146 113 1242 1208 1095 1093 1194 1195 1212 1244 11 29 20 70 20 92 0 22 -9 63 -20 92 -18 49 -117 151 -1212 1244 -1096 1095 -1197 1193 -1242 1208 -52 17 -114 20 -156 7z"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="lms-drwa-lines" id="original" style="display:block;"></div>
                </div>
            </div>
        </div>
    </section>
    <a href="#" class="scroll-btn" style="display: block;">
        <div class="round">
            <div id="cta"><span class="arrow primera next"></span> <span class="arrow segunda next"></span></div>
        </div>
    </a>
</section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/draw-lines/draw-lines.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
@endpush
