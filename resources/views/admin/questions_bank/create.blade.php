@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/css/quiz-create.css">
@endpush

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ $pageTitle }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{ $pageTitle }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="/admin/quizzes/store" id="webinarForm" class="webinar-form">
                                {{ csrf_field() }}
                                <section>

                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            @if(!empty(getGeneralSettings('content_translate')))
                                                <div class="form-group">
                                                    <label class="input-label">{{ trans('auth.language') }}</label>
                                                    <select name="locale" class="form-control {{ !empty($quiz) ? 'js-edit-content-locale' : '' }}">
                                                        @foreach($userLanguages as $lang => $language)
                                                            <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('locale')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            @else
                                                <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                            @endif

                                            <div class="form-group">
                                                <label class="input-label d-block">{{ trans('admin/main.webinar') }}</label>
                                                <select name="webinar_id" class="form-control search-webinar-select2 @error('webinar_id') is-invalid @enderror" data-placeholder="{{ trans('admin/main.search_webinar') }}">

                                                </select>

                                                @error('webinar_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">{{ trans('quiz.quiz_title') }}</label>
                                                <input type="text" value="{{ old('title') }}" name="title" class="form-control @error('title')  is-invalid @enderror" placeholder=""/>
                                                @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">{{ trans('public.time') }} <span class="braces">({{ trans('public.minutes') }})</span></label>
                                                <input type="text" value="{{ old('time') }}" name="time" class="form-control @error('time')  is-invalid @enderror" placeholder="{{ trans('forms.empty_means_unlimited') }}"/>
                                                @error('time')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">{{ trans('quiz.number_of_attemps') }}</label>
                                                <input type="text" name="attempt" value="{{ old('attempt') }}" class="form-control @error('attempt')  is-invalid @enderror" placeholder="{{ trans('forms.empty_means_unlimited') }}"/>
                                                @error('attempt')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">{{ trans('quiz.pass_mark') }}</label>
                                                <input type="text" name="pass_mark" value="{{ old('pass_mark') }}" class="form-control @error('pass_mark')  is-invalid @enderror" placeholder=""/>
                                                @error('pass_mark')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-4 d-flex align-items-center justify-content-between">
                                                <label class="cursor-pointer" for="certificateSwitch">{{ trans('quiz.certificate_included') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="certificate" class="custom-control-input" id="certificateSwitch">
                                                    <label class="custom-control-label" for="certificateSwitch"></label>
                                                </div>
                                            </div>

                                            <div class="form-group mt-4 d-flex align-items-center justify-content-between">
                                                <label class="cursor-pointer" for="statusSwitch">{{ trans('quiz.active_quiz') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="status" class="custom-control-input" id="statusSwitch">
                                                    <label class="custom-control-label" for="statusSwitch"></label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </section>

                                <div class="col-12 col-md-12">
                                <div  class="question-create-form">
                                    <div class="row nomrgn" >
                                        <div class="col-md-3 nopadd h-100">
                                            <div class="col-md-12">
                                                <div id="modules" class="col-sm-12 drag-field nopadd">
                                                    <p class="drag col-md-6 group_drag" data-drag_type="Group"><a class="btn btn-default">Group</a></p>
                                                    <p class="drag col-md-6 group_field" data-drag_type="P"><a class="btn btn-default">P</a></p>
                                                    <p class="drag col-md-6 group_field" data-drag_type="Text"><a class="btn btn-default">Text</a></p>
                                                    <p class="drag col-md-6 group_field" data-drag_type="Dropdown"><a class="btn btn-default">Dropdown</a></p>
                                                    <p class="drag col-md-6 group_field hide" data-drag_type="Textarea"><a class="btn btn-default">Textarea</a></p>
                                                    <p class="drag col-md-6 group_field hide" data-drag_type="Email"><a class="btn btn-default">Email</a></p>
                                                    <p class="drag col-md-6 group_field" data-drag_type="Radio Button"><a class="btn btn-default">Radio Button</a></p>
                                                    <p class="drag col-md-6 group_field" data-drag_type="Image"><a class="btn btn-default">Image</a></p>

                                                    <p class="drag col-sm-6 group_field hide" data-drag_type="divide">
                                                        <a class="btn btn-default">
                                                            <svg style="width:15px; height:auto;" version="1.0" xmlns="http://www.w3.org/2000/svg" width="820.000000pt" height="844.000000pt" viewBox="0 0 820.000000 844.000000" preserveAspectRatio="xMidYMid meet">
                                                            <g transform="translate(0.000000,844.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                                            <path d="M3911 8424 c-691 -116 -1118 -818 -905 -1488 93 -291 309 -541 588 -678 695 -340 1509 82 1642 852 46 269 -23 582 -181 820 -245 369 -705 568 -1144 494z"/>
                                                            <path d="M860 5230 c-206 -35 -400 -137 -551 -289 -192 -193 -285 -405 -296 -676 -12 -301 81 -546 287 -755 142 -144 282 -227 477 -283 l78 -22 3210 -3 c2869 -2 3219 -1 3293 13 483 91 832 512 832 1005 0 464 -287 843 -750 988 l-85 27 -3225 1 c-1774 1 -3245 -2 -3270 -6z"/>
                                                            <path d="M3897 2284 c-220 -40 -424 -144 -589 -303 -99 -94 -165 -181 -224 -294 -87 -167 -124 -306 -131 -492 -8 -204 32 -389 125 -568 349 -680 1249 -837 1807 -315 374 349 471 900 240 1358 -135 268 -378 478 -665 574 -164 54 -393 71 -563 40z"/>
                                                            </g>
                                                            </svg>
                                                        </a>
                                                    </p>
                                                    <p class="drag col-sm-6 group_field" data-drag_type="sqroot"><a class="btn btn-default"><svg style="width:15px; height:auto;" id="svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="400" height="171.42857142857142" viewBox="0, 0, 400,171.42857142857142"><g id="svgg"><path id="path0" d="M46.241 16.127 C 61.090 59.288,61.927 109.399,48.508 151.878 C 44.072 165.920,44.011 166.703,47.167 169.010 C 54.323 174.243,56.753 172.156,61.687 156.538 C 74.661 115.467,75.036 83.532,63.250 23.502 L 62.254 18.433 216.381 18.433 L 370.507 18.433 370.507 11.982 L 370.507 5.530 206.551 5.530 L 42.595 5.530 46.241 16.127 " stroke="none" fill="#000000" fill-rule="evenodd"></path></g></svg></a></p>        
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-9 nopadd h-100">
                                            <div class="dropzone" id="dropzone" style="height:500px; background:#f2f2f2;">
                                            </div>
                                            <div class="col-sm-6 field-options"></div>
                                        </div>

                                    </div>
                                    <div class="hide">
                                        <div class="p-fields">
                                            <textarea rows="5" cols="40" class="trigger_field" data-field_id="paragraph_value" data-field_type="text" data-id=""></textarea>
                                            <input type="text" class="trigger_field" data-field_id="top_margin" data-field_type="top_margin" size="6" placeholder="Top Margin" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="left_margin" data-field_type="left_margin" size="6" placeholder="Left Margin" data-id="">
                                        </div>


                                        <div class="image-fields">
                                            <input class="trigger_field image-field" data-field_id="image_value" data-field_type="image" data-id="" type="file">
                                            <input type="text" class="trigger_field" data-field_id="top_margin" data-field_type="top_margin" size="6" placeholder="Top Margin" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="left_margin" data-field_type="left_margin" size="6" placeholder="Left Margin" data-id="">
                                        </div>


                                        <div class="text-fields">
                                            <input type="text" class="trigger_field" data-field_id="placeholder" data-field_type="placeholder" placeholder="Placeholder" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="correct_answer" data-field_type="correct_answer" placeholder="Correct Answere" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="max_digits" data-field_type="max_digits" placeholder="Maximum Digits" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="top_margin" data-field_type="top_margin" size="6" placeholder="Top Margin" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="left_margin" data-field_type="left_margin" size="6" placeholder="Left Margin" data-id="">
                                        </div>

                                        <div class="dropdown-fields">
                                            <input type="text" class="trigger_field" data-field_id="select_options" data-field_type="select_options" placeholder="Options Comma Separated" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="correct_answer" data-field_type="correct_answer" placeholder="Correct Answere" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="top_margin" data-field_type="top_margin" size="6" placeholder="Top Margin" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="left_margin" data-field_type="left_margin" size="6" placeholder="Left Margin" data-id="">
                                        </div>
                                        <div class="radio-fields">
                                            <input type="text" class="trigger_field" data-field_id="radio_text" data-field_type="radio_text" placeholder="Option text" data-id="">
                                            <select class="trigger_field" data-field_id="is_it_correct" data-field_type="select_field" data-id="">
                                                <option value="">Is it correct?</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            <input type="text" class="trigger_field" data-field_id="top_margin" data-field_type="top_margin" size="6" placeholder="Top Margin" data-id="">
                                            <input type="text" class="trigger_field" data-field_id="left_margin" data-field_type="left_margin" size="6" placeholder="Left Margin" data-id="">
                                        </div>
                                    </div>
                                </div>
                            </div>


                    </div>
                </div>

                                <div class="mt-5 mb-5">
                                <button type="button" class="quiz-stage-generate btn btn-primary">{{ !empty($quiz) ? trans('admin/main.save_change') : trans('admin/main.create') }}</button>
                                <button type="submit" class="submit-btn-quiz-create btn btn-primary hide">{{ !empty($quiz) ? trans('admin/main.save_change') : trans('admin/main.create') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>

<script>
var saveSuccessLang = '{{ trans('webinars.success_store') }}';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

<script src="/assets/default/js/admin/quiz.min.js"></script>
<script src="/assets/default/js/admin/quiz-create.js"></script>
@endpush
