@extends('admin.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<style>
    .hide-class {
        display: none;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">{{ trans('admin/main.testimonials') }}</div>
        </div>
    </div>


    <div class="section-body">

        <div class="d-flex align-items-center justify-content-between">
            <div class="">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h2 class="section-title ml-4">{{ !empty($testimonial) ? trans('admin/main.edit') : trans('admin/main.create') }}</h2>

                    <div class="card-body">
                        <form action="{{ getAdminPanelUrl() }}/testimonials/{{ !empty($testimonial) ? $testimonial->id.'/update' : 'store' }}" method="Post">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-12 col-lg-6">

                                    @if(!empty(getGeneralSettings('content_translate')))
                                    <div class="form-group">
                                        <label class="input-label">{{ trans('auth.language') }}</label>
                                        <select name="locale" class="form-control {{ !empty($testimonial) ? 'js-edit-content-locale' : '' }}">
                                            @foreach($userLanguages as $lang => $language)
                                            <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}
                                            </option>
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

                                    <div class="form-group mt-15">
                                        <label class="input-label">{{ trans('admin/main.user_avatar') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="input-group-text admin-file-manager" data-input="user_avatar" data-preview="holder">
                                                    <i class="fa fa-upload"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="user_avatar" id="user_avatar" value="{{ !empty($testimonial->user_avatar) ? $testimonial->user_avatar : old('user_avatar') }}"
                                                   class="form-control @error('user_avatar') is-invalid @enderror" placeholder="{{ trans('admin/main.testimonial_user_avatar_placeholder') }}"/>
                                            <div class="input-group-append">
                                                <button type="button" class="input-group-text admin-file-view" data-input="user_avatar">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>

                                            @error('user_avatar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label d-block">Testimonial By</label>
                                        <select name="testimonial_by" class="form-control" data-placeholder="Select Testimonial By">
                                            <option value="teacher" {{ (!empty($testimonial) and $testimonial->testimonial_by == 'teacher') ? 'selected' : '' }}>Teacher</option>
                                            <option value="student" {{ (!empty($testimonial) and $testimonial->testimonial_by == 'student') ? 'selected' : '' }}>Student</option>
                                            <option value="parent" {{ (!empty($testimonial) and $testimonial->testimonial_by == 'parent') ? 'selected' : '' }}>Parent</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>{{ trans('admin/main.user_name') }}</label>
                                        <input type="text" name="user_name" class="form-control  @error('user_name') is-invalid @enderror"
                                               value="{{ !empty($testimonial) ? $testimonial->user_name : old('user_name') }}"/>
                                        @error('user_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="text" name="testimonial_date" class="datepicker form-control" value="{{ !empty($testimonial->testimonial_date) ? dateTimeFormat
                                        ($testimonial->testimonial_date, 'Y-n-d') :'' }}"/>
                                    </div>


                                    <div class="form-group">
                                        <label>Year / Grade</label>
                                        <input type="text" name="user_bio" class="form-control  @error('user_bio') is-invalid @enderror"
                                               value="{{ !empty($testimonial) ? $testimonial->user_bio : old('user_bio') }}"/>
                                        @error('user_bio')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Country</label>

                                        <select name="country" class="form-control" data-placeholder="Select Country">
                                            @foreach($contries_list as $country_name)
                                            <option value="{{$country_name}}" {{ (!empty($testimonial) and $testimonial->country == $country_name) ? 'selected' : '' }}>{{$country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control  @error('city') is-invalid @enderror"
                                               value="{{ !empty($testimonial) ? $testimonial->city : old('city') }}"/>
                                        @error('city')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label d-block">Testimonial Type</label>
                                        <select name="testimonial_type" class="form-control testimonial-type" data-placeholder="Select Testimonial Type">
                                            <option value="text" {{ (!empty($testimonial) and $testimonial->testimonial_type == 'text') ? 'selected' : '' }}>Text</option>
                                            <option value="image" {{ (!empty($testimonial) and $testimonial->testimonial_type == 'image') ? 'selected' : '' }}>Image</option>
                                            <option value="video" {{ (!empty($testimonial) and $testimonial->testimonial_type == 'video') ? 'selected' : '' }}>Video</option>
                                        </select>
                                    </div>


                                    <div class="form-group hide-class">
                                        <label>{{ trans('admin/main.rate') }}</label>
                                        <input type="number" name="rate" class="form-control  @error('rate') is-invalid @enderror"
                                               value="{{ !empty($testimonial) ? $testimonial->rate : old('rate') }}" placeholder="{{ trans('admin/main.testimonial_rate_placeholder') }}"/>
                                        @error('rate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="conditional-fields text-fields">

                                <div class="form-group mt-15">
                                    <label class="input-label">{{ trans('admin/main.comment') }}</label>
                                    <textarea id="summernote" name="comment" class="summernote form-control @error('comment')  is-invalid @enderror">{!! !empty($testimonial) ? $testimonial->comment : old('comment')  !!}</textarea>
                                    @error('comment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="conditional-fields image-fields">

                                <div class="form-group mt-15">
                                    <label class="input-label">Image</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="input-group-text admin-file-manager" data-input="testimonial_image" data-preview="holder">
                                                <i class="fa fa-upload"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="testimonial_image" id="testimonial_image"
                                               value="{{ !empty($testimonial->testimonial_image) ? $testimonial->testimonial_image : old('testimonial_image') }}"
                                               class="form-control @error('testimonial_image') is-invalid @enderror" placeholder="Testimonial Image"/>
                                        <div class="input-group-append">
                                            <button type="button" class="input-group-text admin-file-view" data-input="testimonial_image">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>

                                        @error('testimonial_image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="conditional-fields video-fields">

                                <div class="form-group">
                                    <label>Video URL</label>
                                    <input type="text" name="testimonial_video" class="form-control  @error('testimonial_video') is-invalid @enderror"
                                           value="{{ !empty($testimonial) ? $testimonial->testimonial_video : old('testimonial_video') }}"/>
                                    @error('testimonial_video')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-group custom-switches-stacked">
                                <label class="custom-switch pl-0">
                                    <input type="hidden" name="status" value="disable">
                                    <input type="checkbox" name="status" id="testimonialStatus" value="active" {{ (!empty($testimonial) and $testimonial->status == 'active') ? 'checked="checked"' : ''
                                    }} class="custom-switch-input"/>
                                    <span class="custom-switch-indicator"></span>
                                    <label class="custom-switch-description mb-0 cursor-pointer" for="testimonialStatus">{{ trans('admin/main.active') }}</label>
                                </label>
                            </div>

                            <div class=" mt-4">
                                <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
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
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '.testimonial-type', function (e) {
            var testimonial_type = $(this).val();
            $(".conditional-fields").addClass('hide-class');
            $('.' + testimonial_type + "-fields").removeClass('hide-class');
        });
        $(".testimonial-type").change();


    });
</script>
@endpush
