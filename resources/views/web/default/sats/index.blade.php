@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
@endpush

@section('content')
<section class="content-section">

    <section class="pt-80" style="background-color: var(--panel-bg);">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="sats-summary">
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="sats-summary-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#00aeef" version="1.1" id="Layer_1" viewBox="0 0 496 496" xml:space="preserve">
                                        <g>
                                            <g>
                                                <g>
                                                    <path d="M464,112.808v-36.12L387.312,0H160v112H40c-22.056,0-40,17.944-40,40v256c0,22.056,17.944,40,40,40h96v32h-32v16h288v-16     h-32v-32h96c22.056,0,40-17.944,40-40V152C496,132.688,482.232,116.528,464,112.808z M384,19.312L444.688,80H384V19.312z M176,16     h192v80h80v256H176V16z M344,480H152v-32h192V480z M480,408c0,13.232-10.768,24-24,24H40c-13.232,0-24-10.768-24-24v-8h464V408z      M480,384H16V152c0-13.232,10.768-24,24-24h120v240h304V129.472c9.288,3.312,16,12.112,16,22.528V384z"/>
                                                    <path d="M144,200c0-30.872-25.128-56-56-56s-56,25.128-56,56s25.128,56,56,56S144,230.872,144,200z M96,184c0,4.416-3.584,8-8,8     s-8-3.584-8-8s3.584-8,8-8S96,179.584,96,184z M88,240c-5.56,0-10.856-1.152-15.672-3.216C73.816,229.504,80.28,224,88,224     c7.72,0,14.184,5.504,15.672,12.784C98.856,238.848,93.56,240,88,240z M88,208c-13.056,0-24.264,7.872-29.232,19.104     C52.144,219.96,48,210.48,48,200c0-20.4,15.408-37.096,35.168-39.512C72.24,162.728,64,172.424,64,184     C64,197.232,74.768,208,88,208s24-10.768,24-24c0-11.576-8.24-21.272-19.168-23.512C112.592,162.904,128,179.6,128,200     c0,10.48-4.144,19.96-10.768,27.104C112.264,215.872,101.056,208,88,208z"/>
                                                    <path d="M32,312c0,30.872,25.128,56,56,56s56-25.128,56-56s-25.128-56-56-56S32,281.128,32,312z M88,352     c-5.56,0-10.856-1.152-15.672-3.216C73.816,341.504,80.28,336,88,336c7.72,0,14.184,5.504,15.672,12.784     C98.856,350.848,93.56,352,88,352z M96,296c0,4.416-3.584,8-8,8s-8-3.584-8-8c0-4.416,3.584-8,8-8S96,291.584,96,296z      M83.168,272.488C72.24,274.728,64,284.424,64,296c0,13.232,10.768,24,24,24s24-10.768,24-24c0-11.576-8.24-21.272-19.168-23.512     C112.592,274.904,128,291.6,128,312c0,10.48-4.144,19.96-10.768,27.104C112.264,327.872,101.056,320,88,320     c-13.056,0-24.264,7.872-29.232,19.104C52.144,331.96,48,322.48,48,312C48,291.6,63.408,274.904,83.168,272.488z"/>
                                                    <path d="M288,63.312V48h-80v80h80V82.968l28.648-20.464l-9.296-13.016L288,63.312z M272,74.744l-15.136,10.808l-11.208-11.208     l-11.312,11.312l20.792,20.792L272,94.4V112h-48V64h48V74.744z"/>
                                                    <path d="M288,159.312V144h-80v80h80v-45.032l28.648-20.464l-9.296-13.016L288,159.312z M272,170.744l-15.136,10.808     l-11.208-11.208l-11.312,11.312l20.792,20.792L272,190.4V208h-48v-48h48V170.744z"/>
                                                    <path d="M288,255.312V240h-80v80h80v-45.032l28.648-20.464l-9.296-13.008L288,255.312z M272,266.744l-15.136,10.808     l-11.208-11.208l-11.312,11.312l20.792,20.792L272,286.4V304h-48v-48h48V266.744z"/>
                                                    <rect x="320" y="112" width="96" height="16"/>
                                                    <rect x="320" y="208" width="96" height="16"/>
                                                    <rect x="320" y="304" width="96" height="16"/>
                                                    <rect x="320" y="272" width="96" height="16"/>
                                                    <rect x="320" y="176" width="96" height="16"/>
                                                    <rect x="320" y="80" width="32" height="16"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="summary-text">
                                    <label>SATs Assessments</label>
                                    <div class="score">{{$authUser->getConductedAssessments('sats')}} / {{count($sats)}}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="sats-summary-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #8cc811;">
                                        <g id="Group_1264" transform="translate(-188.102 -869.102)">
                                            <g id="Group_1262">
                                                <g id="speedometer" transform="translate(188.102 869.102)">
                                                    <path id="Path_1547" d="M20.484 3.515a12 12 0 0 0-16.97 16.97 12 12 0 0 0 16.97-16.97zM12 22.593A10.594 10.594 0 1 1 22.593 12 10.606 10.606 0 0 1 12 22.593zm0 0" class="cls-1"></path>
                                                    <path id="Path_1548" d="M118.647 321.206a.7.7 0 0 0-.5-.206h-8.094a.7.7 0 0 0-.5.206l-2.228 2.228a.7.7 0 0 0-.012.982 9.357 9.357 0 0 0 13.569 0 .7.7 0 0 0-.012-.982zm-4.544 4.716a7.882 7.882 0 0 1-5.273-2l1.517-1.517h7.512l1.517 1.517a7.882 7.882 0 0 1-5.273 2zm0 0" class="cls-1" transform="translate(-102.104 -305.954)"></path>
                                                    <path id="Path_1549" d="M216.719 120.194a.7.7 0 0 0-.919.38l-1.606 3.876h-.091a2.063 2.063 0 1 0 1.39.541l1.606-3.877a.7.7 0 0 0-.38-.919zm-2.616 6.969a.654.654 0 1 1 .654-.654.655.655 0 0 1-.657.654zm0 0" class="cls-1" transform="translate(-202.104 -114.509)"></path>
                                                    <path id="Path_1550" d="M65.375 56A9.385 9.385 0 0 0 56 65.375a.7.7 0 0 0 .7.7h1.25a.7.7 0 1 0 0-1.406h-.516a7.933 7.933 0 0 1 1.83-4.409l.362.362a.7.7 0 1 0 .994-.994l-.362-.362a7.934 7.934 0 0 1 4.41-1.83v.516a.7.7 0 1 0 1.406 0v-.516a7.934 7.934 0 0 1 4.41 1.83l-.362.362a.7.7 0 0 0 .994.994l.362-.362a7.932 7.932 0 0 1 1.83 4.409H72.8a.7.7 0 0 0 0 1.406h1.25a.7.7 0 0 0 .7-.7A9.385 9.385 0 0 0 65.375 56zm0 0" class="cls-1" transform="translate(-53.376 -53.375)"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            <div class="summary-text">
                                <label>Average Score</label>
                                    @php $resultData = $QuestionsAttemptController->get_result_data('sats', 0, 'type');
                                        $resultData = $QuestionsAttemptController->prepare_result_array($resultData);
                                        $total_attempts = $total_questions_attempt = $correct_questions = 0;
                                    @endphp

                                    @if( !empty( $resultData ) )
                                        @foreach( $resultData as $resultObj)
                                            @php
                                                $total_questions_attempt += $resultObj->attempted;
                                                $correct_questions += $resultObj->correct;
                                            @endphp

                                        @endforeach
                                    @endif
                                    @php
                                        $total_percentage = 0;
                                        if( $total_questions_attempt > 0 && $correct_questions > 0){
                                            $total_percentage = ($correct_questions * 100) / $total_questions_attempt;
                                        }
                                    @endphp
                                <div class="score">{{round($total_percentage, 2)}}%</div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="sats-summary-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none" style="color:#e67035">
                                    <path style="fill: #e67035;" fill-rule="evenodd" clip-rule="evenodd" d="M5.01112 11.5747L6.29288 10.2929C6.68341 9.90236 7.31657 9.90236 7.7071 10.2929C8.09762 10.6834 8.09762 11.3166 7.7071 11.7071L4.7071 14.7071C4.51956 14.8946 4.26521 15 3.99999 15C3.73477 15 3.48042 14.8946 3.29288 14.7071L0.292884 11.7071C-0.0976406 11.3166 -0.0976406 10.6834 0.292884 10.2929C0.683408 9.90236 1.31657 9.90236 1.7071 10.2929L3.0081 11.5939C3.22117 6.25933 7.61317 2 13 2C18.5229 2 23 6.47715 23 12C23 17.5228 18.5229 22 13 22C9.85817 22 7.05429 20.5499 5.22263 18.2864C4.87522 17.8571 4.94163 17.2274 5.37096 16.88C5.80028 16.5326 6.42996 16.599 6.77737 17.0283C8.24562 18.8427 10.4873 20 13 20C17.4183 20 21 16.4183 21 12C21 7.58172 17.4183 4 13 4C8.72441 4 5.23221 7.35412 5.01112 11.5747ZM13 5C13.5523 5 14 5.44772 14 6V11.5858L16.7071 14.2929C17.0976 14.6834 17.0976 15.3166 16.7071 15.7071C16.3166 16.0976 15.6834 16.0976 15.2929 15.7071L12.2929 12.7071C12.1054 12.5196 12 12.2652 12 12V6C12 5.44772 12.4477 5 13 5Z" fill="#000000"/>
                                </svg>
                            </div>
                            <div class="summary-text">
                                <label>Average time</label>
                                @php $assessmentTime = $authUser->assesstmentTotalTimeAllowed('sats');
                                $average_time = isset( $assessmentTime['average_time'] )? $assessmentTime['average_time'] : 0;
                                $time_consumed = isset( $assessmentTime['time_consumed'] )? $assessmentTime['time_consumed'] : 0;
                                @endphp
                                <div class="score">{{$time_consumed}}m / {{$average_time}}m</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <div class="sats-summary-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#0272b6" version="1.1" id="Capa_1" width="800px" height="800px" viewBox="0 0 185.872 185.871" xml:space="preserve">
                                    <g>
                                        <g>
                                            <g>
                                                <g>
                                                    <path d="M91.733,47.389c-18.389,0-33.305-5.964-33.305-13.317v13.317c0,7.365,14.916,13.32,33.305,13.32      c18.396,0,33.302-5.956,33.302-13.32V34.071C125.029,41.431,110.128,47.389,91.733,47.389z"/>
                                                    <path d="M91.733,3.52c-18.389,0-33.305,5.961-33.305,13.323v13.32c0,7.365,14.916,13.317,33.305,13.317      c18.396,0,33.302-5.961,33.302-13.317v-13.32C125.029,9.48,110.128,3.52,91.733,3.52z M91.733,26.825      c-18.301,0-29.968-5.915-29.968-9.989c0-4.076,11.667-9.995,29.968-9.995c18.298,0,29.959,5.919,29.959,9.995      C121.686,20.91,110.031,26.825,91.733,26.825z"/>
                                                    <path d="M94.272,15.308c-3.848-0.621-5.44-1.029-5.44-1.662c0-0.536,0.95-1.087,3.891-1.087c3.255,0,5.35,0.451,6.524,0.654      l1.322-2.18c-1.505-0.308-3.532-0.581-6.577-0.636V8.695h-4.436v1.833c-4.844,0.405-7.651,1.739-7.651,3.44      c0,1.878,3.297,2.844,8.15,3.535c3.35,0.481,4.802,0.944,4.802,1.678c0,0.779-1.766,1.199-4.354,1.199      c-2.936,0-5.605-0.401-7.508-0.849l-1.352,2.256c1.696,0.426,4.658,0.773,7.693,0.837v1.833h4.424v-1.964      c5.213-0.387,8.062-1.857,8.062-3.581C101.823,17.187,99.655,16.127,94.272,15.308z"/>
                                                    <path d="M58.428,51.587c0.012,0,0.034,0.006,0.052,0.013c0-0.07-0.052-0.131-0.052-0.195V51.587z"/>
                                                    <path d="M91.733,64.73c-6.929,0-13.351-0.843-18.675-2.29c1.09,2.016,1.726,4.235,1.726,6.686v7.015      c4.99,1.19,10.732,1.915,16.949,1.915c18.396,0,33.302-5.961,33.302-13.326V51.404C125.029,58.77,110.128,64.73,91.733,64.73z"/>
                                                    <path d="M91.733,82.069c-6.217,0-11.959-0.728-16.949-1.912v9.42c8.126-4.926,20.371-7.276,32.117-7.276      c5.943,0,12.008,0.612,17.61,1.827c0.262-0.673,0.518-1.352,0.518-2.064V68.74C125.029,76.102,110.128,82.069,91.733,82.069z"/>
                                                </g>
                                                <g>
                                                    <path d="M33.301,99.68C14.912,99.68,0,93.712,0,86.359v13.32c0,7.367,14.912,13.316,33.301,13.316      c18.396,0,33.308-5.949,33.308-13.316v-13.32C66.603,93.712,51.697,99.68,33.301,99.68z"/>
                                                    <path d="M33.301,117.009C14.912,117.009,0,111.054,0,103.698v13.311c0,7.368,14.912,13.329,33.301,13.329      c18.396,0,33.308-5.961,33.308-13.329v-13.311C66.603,111.06,51.697,117.009,33.301,117.009z"/>
                                                    <path d="M33.301,134.351C14.912,134.351,0,128.396,0,121.034v13.316c0,7.368,14.912,13.323,33.301,13.323      c18.396,0,33.308-5.961,33.308-13.323v-13.316C66.603,128.396,51.697,134.351,33.301,134.351z"/>
                                                    <path d="M33.301,151.693C14.912,151.693,0,145.726,0,138.369v13.324c0,7.355,14.912,13.322,33.301,13.322      c18.396,0,33.308-5.967,33.308-13.322v-13.324C66.603,145.726,51.697,151.693,33.301,151.693z"/>
                                                    <path d="M33.301,169.028C14.912,169.028,0,163.067,0,155.712v13.316c0,7.362,14.912,13.323,33.301,13.323      c18.396,0,33.308-5.961,33.308-13.323v-13.316C66.603,163.067,51.697,169.028,33.301,169.028z"/>
                                                    <path d="M33.301,55.801C14.912,55.801,0,61.762,0,69.121v13.323c0,7.365,14.912,13.32,33.301,13.32      c18.396,0,33.308-5.961,33.308-13.32V69.121C66.603,61.762,51.697,55.801,33.301,55.801z M33.301,79.116      c-18.295,0-29.968-5.919-29.968-9.995c0-4.08,11.673-9.989,29.968-9.989c18.301,0,29.974,5.909,29.974,9.989      C63.269,73.197,51.596,79.116,33.301,79.116z"/>
                                                    <path d="M35.837,67.599c-3.845-0.624-5.435-1.029-5.435-1.666c0-0.536,0.953-1.083,3.891-1.083c3.255,0,5.349,0.447,6.528,0.654      l1.315-2.183c-1.504-0.304-3.535-0.579-6.567-0.636v-1.696h-4.445v1.833c-4.844,0.405-7.651,1.742-7.651,3.443      c0,1.87,3.306,2.844,8.15,3.535c3.349,0.487,4.801,0.947,4.801,1.684c0,0.779-1.766,1.196-4.354,1.196      c-2.935,0-5.599-0.398-7.499-0.853l-1.361,2.256c1.702,0.429,4.664,0.779,7.693,0.834v1.836h4.436v-1.967      c5.206-0.387,8.056-1.852,8.056-3.578C43.397,69.474,41.227,68.408,35.837,67.599z"/>
                                                </g>
                                                <g>
                                                    <path d="M106.901,134.351c-18.386,0-33.301-5.955-33.301-13.316v13.316c0,7.368,14.916,13.323,33.301,13.323      c18.396,0,33.308-5.955,33.308-13.323v-13.316C140.208,128.396,125.296,134.351,106.901,134.351z"/>
                                                    <path d="M106.901,151.687c-18.386,0-33.301-5.968-33.301-13.323v13.323c0,7.362,14.916,13.329,33.301,13.329      c18.396,0,33.308-5.967,33.308-13.329v-13.323C140.208,145.726,125.296,151.687,106.901,151.687z"/>
                                                    <path d="M106.901,169.028c-18.386,0-33.301-5.961-33.301-13.316v13.316c0,7.356,14.916,13.323,33.301,13.323      c18.396,0,33.308-5.967,33.308-13.323v-13.316C140.208,163.067,125.296,169.028,106.901,169.028z"/>
                                                    <path d="M106.901,90.476c-18.386,0-33.301,5.967-33.301,13.326v13.317c0,7.355,14.916,13.322,33.301,13.322      c18.396,0,33.308-5.967,33.308-13.322v-13.317C140.208,96.437,125.296,90.476,106.901,90.476z M106.901,113.788      c-18.298,0-29.964-5.913-29.964-9.993c0-4.079,11.667-9.989,29.964-9.989c18.305,0,29.971,5.91,29.971,9.989      C136.872,107.875,125.206,113.788,106.901,113.788z"/>
                                                    <path d="M109.44,102.268c-3.848-0.615-5.438-1.023-5.438-1.663c0-0.536,0.95-1.071,3.892-1.071c3.257,0,5.34,0.444,6.527,0.651      l1.321-2.187c-1.51-0.304-3.544-0.578-6.57-0.639v-1.696h-4.445v1.836c-4.847,0.402-7.654,1.735-7.654,3.44      c0,1.869,3.301,2.838,8.154,3.525c3.343,0.487,4.804,0.95,4.804,1.688c0,0.779-1.766,1.199-4.359,1.199      c-2.936,0-5.603-0.408-7.502-0.853l-1.352,2.259c1.692,0.433,4.651,0.779,7.69,0.834v1.834h4.427v-1.967      c5.206-0.385,8.062-1.852,8.062-3.575C116.997,104.143,114.83,103.083,109.44,102.268z"/>
                                                </g>
                                            </g>
                                            <polygon points="153.995,165.99 172.091,165.99 172.091,60.982 185.872,60.982 163.043,21.649 140.208,60.982 153.995,60.982       "/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="summary-text">
                                <label>Coins earned</label>
                                <div class="score">{{$authUser->getRewardPointsByType('sats')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-12">
                    <div class="section-title text-left mb-50">
                        <h2 class="mt-0 mb-10">KS2 SATs Online 10-Minutes test practices</h2>
                        <p> Work through a variety of practice questions to improve your skills and become familiar with
                            the <br> types of questions you'll encounter on the SATs. </p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="listing-search lms-jobs-form mb-50">
                        <form>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Product</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option selected="selected">One option selected</option>
                                                <option>Subject Matter Expert (SME)</option>
                                                <option>Online Instructor/Educator</option>
                                                <option>Curriculum Developer</option>
                                                <option>Learning Experience Designer</option>
                                                <option>Administrator</option>
                                                <option>Quality Assurance Specialist</option>
                                                <option>Marketing and Enrollment Manager</option>
                                                <option>Technical Support Specialist</option>
                                                <option>Data Analyst</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Year</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option selected="selected">All</option>
                                                <option>Subject Matter Expert (SME)</option>
                                                <option>Online Instructor/Educator</option>
                                                <option>Curriculum Developer</option>
                                                <option>Learning Experience Designer</option>
                                                <option>Administrator</option>
                                                <option>Quality Assurance Specialist</option>
                                                <option>Marketing and Enrollment Manager</option>
                                                <option>Technical Support Specialist</option>
                                                <option>Data Analyst</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label class="input-label">Pack type</label>
                                        <div class="input-field select-arrow">
                                            <select class="lms-jobs-select">
                                                <option selected="selected">All</option>
                                                <option>Subject Matter Expert (SME)</option>
                                                <option>Online Instructor/Educator</option>
                                                <option>Curriculum Developer</option>
                                                <option>Learning Experience Designer</option>
                                                <option>Administrator</option>
                                                <option>Quality Assurance Specialist</option>
                                                <option>Marketing and Enrollment Manager</option>
                                                <option>Technical Support Specialist</option>
                                                <option>Data Analyst</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group mb-0">
                                        <button type="submit"
                                                class="btn-primary px-20 border-0 rounded-pill text-white text-uppercase">
                                            Filter
                                        </button>
                                        <a href="#" class="clear-btn ml-10 text-uppercase text-primary">Clear
                                            Filters</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="sats-listing-card medium">
                        <table>
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Questions</th>
                                <th>Attempts</th>
                                <th>Last attempt</th>
                                <th>Accuracy</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( !empty( $sats))
                            @foreach( $sats as $satObj)
                            @php $resultData = $QuestionsAttemptController->get_result_data($satObj->id);

                            $is_passed = isset( $resultData->is_passed )? $resultData->is_passed : false;
                            $in_progress = isset( $resultData->in_progress )? $resultData->in_progress : false;
                            $current_status = isset( $resultData->current_status )? $resultData->current_status : '';
                            $button_label = ($in_progress == true)? 'Resume' :'Practice Now';
                            $button_label = ($is_passed == true) ? 'Practice Again' : $button_label;

                            @endphp
                            <tr>
                                <td>

                                    <img src="../assets/default/img/sats-list-img1.png" alt="">
                                    <h4><a href="/sats/{{$satObj->id}}/start">{{$satObj->getTitleAttribute()}}-<br>reading</a>
                                    </h4>
                                </td>
                                <td>54</td>
                                <td>0</td>
                                <td>12</td>
                                <td>
                                    <div class="attempt-progress">
                                        <span class="progress-number">0%</span>
                                        <span class="progress-holder">
                                            <span class="progressbar"
                                                  style="width: 0%;"></span>
                                        </span>
                                    </div>
                                   {{ user_assign_topic_template($satObj->id, 'sats', $childs, $parent_assigned_list)}}
                                </td>
                            </tr>
                            @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="filters-container">
                        <div class="accordion lms-list-accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <div class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne"> Year Group <span class="arrow"></span>
                                        </button>
                                    </div>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                     data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="Categories-list pb-15">
                                            <h6 class="font-19 mt-20">KS1</h6>
                                            <a href="/products?category_id=1"
                                               class="d-flex align-items-center font-14 mt-10">
                                                <span>English</span>
                                            </a>
                                            <a href="/products?category_id=2"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Math</span>
                                            </a>
                                            <h6 class="font-19 mt-15">KS2</h6>
                                            <a href="/products?category_id=3"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Math airthmatic </span>
                                            </a>
                                            <a href="/products?category_id=4"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Math Reasoning </span>
                                            </a>
                                            <a href="/products?category_id=5"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>English reading</span>
                                            </a>
                                            <a href="/products?category_id=6"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>English SPag</span>
                                            </a>
                                            <h6 class="font-19 mt-15">Assesment Type</h6>
                                            <a href="/products?category_id=7"
                                               class="d-flex align-items-center font-14 mt-10">
                                                <span>Past Yearly asseement</span>
                                            </a>
                                            <a href="/products?category_id=8"
                                               class="d-flex align-items-center font-14 mt-10">
                                                <span>Practice asseement</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <div class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo"> School Year <span class="arrow"></span>
                                        </button>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                                     data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="Categories-list pb-15">
                                            <h6 class="font-19 mt-20">School Year</h6>
                                            <a href="/products?category_id=1"
                                               class="d-flex align-items-center font-14 mt-10">
                                                <span>Year 6</span>
                                            </a>
                                            <a href="/products?category_id=2"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Year 5</span>
                                            </a>
                                            <a href="/products?category_id=3"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Year 4</span>
                                            </a>
                                            <a href="/products?category_id=4"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Year 3</span>
                                            </a>
                                            <a href="/products?category_id=5"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Year 2</span>
                                            </a>
                                            <h6 class="font-19 mt-15">Subject</h6>
                                            <a href="/products?category_id=6"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Maths</span>
                                            </a>
                                            <a href="/products?category_id=7"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>English </span>
                                            </a>
                                            <a href="/products?category_id=8"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Verbal Reasoning</span>
                                            </a>
                                            <a href="/products?category_id=9"
                                               class="d-flex align-items-center font-14 mt-15">
                                                <span>Non-Verbal Reasoning</span>
                                            </a>
                                            <h6 class="font-19 mt-15">Exam Board</h6>
                                            <a href="/products?category_id=10"
                                               class="d-flex align-items-center font-14 mt-10">
                                                <span>GL</span>
                                            </a>
                                            <a href="/products?category_id=10"
                                               class="d-flex align-items-center font-14 mt-10">
                                                <span>CEM</span>
                                            </a>
                                            <a href="/products?category_id=10"
                                               class="d-flex align-items-center font-14 mt-10">
                                                <span>All Boards</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mt-60">
                        {{ $sats->appends(request()->input())->links('vendor.pagination.panel') }}
                    </div>
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
<script src="/assets/default/js/helpers.js"></script>
<script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
<script src="/assets/default/vendors/masonry/masonry.pkgd.min.js"></script>
@endpush
