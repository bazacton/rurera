@extends('admin.layouts.app')


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{ trans('admin/main.new_subscribe') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">{{ trans('admin/main.subscribes') }}</div>
        </div>
    </div>


    <div class="section-body card">

        <div class="d-flex align-items-center justify-content-between">
            <div class="">
                <h2 class="section-title ml-4">{{ !empty($subscribe) ? trans('admin/main.edit') : trans('admin/main.create') }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card-body">
                    <form action="/admin/financial/subscribes/{{ !empty($subscribe) ? $subscribe->id.'/update' : 'store' }}" method="Post">
                        {{ csrf_field() }}

                        @if(!empty(getGeneralSettings('content_translate')))
                        <div class="form-group">
                            <label class="input-label">{{ trans('auth.language') }}</label>
                            <select name="locale" class="form-control {{ !empty($subscribe) ? 'js-edit-content-locale' : '' }}">
                                @foreach($userLanguages as $lang => $language)
                                <option value="{{ $lang }}" @if(request()->get('locale', app()->getLocale()) == $lang) selected @endif>{{ $language }}</option>
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
                            <label>{{ trans('admin/main.title') }}</label>
                            <input type="text" name="title"
                                   class="form-control  @error('title') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->title : old('title') }}"/>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin/main.short_description') }} ({{ trans('admin/main.optional') }})</label>
                            <input type="text" name="description"
                                   class="form-control "
                                   value="{{ !empty($subscribe) ? $subscribe->description : old('description') }}"
                                   placeholder="{{ trans('admin/main.short_description_placeholder') }}"
                            />
                        </div>


                        <div class="form-group">
                            <label>{{ trans('admin/main.usable_count') }}</label>
                            <input type="text" name="usable_count"
                                   class="form-control  @error('usable_count') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->usable_count : old('usable_count') }}"/>
                            @error('usable_count')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ trans('admin/main.days') }}</label>
                            <input type="text" name="days"
                                   class="form-control  @error('days') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->days : old('days') }}"/>
                            @error('days')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Trial Period</label>
                            <input type="text" name="trial_period"
                                   class="form-control  @error('trial_period') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->trial_period : old('trial_period') }}"/>
                            @error('trial_period')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>{{ trans('admin/main.price') }}</label>
                            <input type="text" name="price"
                                   class="form-control  @error('price') is-invalid @enderror"
                                   value="{{ !empty($subscribe) ? $subscribe->price : old('price') }}"/>
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mt-15">
                            <label class="input-label">{{ trans('admin/main.icon') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="input-group-text admin-file-manager" data-input="icon" data-preview="holder">
                                        <i class="fa fa-chevron-up"></i>
                                    </button>
                                </div>
                                <input type="text" name="icon" id="icon" value="{{ !empty($subscribe->icon) ? $subscribe->icon : old('icon') }}"
                                       class="form-control @error('icon') is-invalid @enderror"/>
                                @error('icon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text admin-file-view" data-input="icon">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_courses" value="0">
                                <input type="checkbox" name="is_courses" id="is_courses" value="1" {{ (!empty($subscribe) and $subscribe->is_courses) ? 'checked="checked"' : '' }}
                                class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_courses">Courses</label>
                            </label>
                        </div>

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_timestables" value="0">
                                <input type="checkbox" name="is_timestables" id="is_timestables" value="1" {{ (!empty($subscribe) and $subscribe->is_timestables) ? 'checked="checked"' : '' }}
                                class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_timestables">Timestables</label>
                            </label>
                        </div>

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_vocabulary" value="0">
                                <input type="checkbox" name="is_vocabulary" id="is_vocabulary" value="1" {{ (!empty($subscribe) and $subscribe->is_vocabulary) ? 'checked="checked"' : '' }}
                                class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_vocabulary">Vocabulary</label>
                            </label>
                        </div>

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_bookshelf" value="0">
                                <input type="checkbox" name="is_bookshelf" id="is_bookshelf" value="1" {{ (!empty($subscribe) and $subscribe->is_bookshelf) ? 'checked="checked"' : '' }}
                                class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_bookshelf">Bookshelf</label>
                            </label>
                        </div>

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_sats" value="0">
                                <input type="checkbox" name="is_sats" id="is_sats" value="1" {{ (!empty($subscribe) and $subscribe->is_sats) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_sats">SATS</label>
                            </label>
                        </div>
                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_elevenplus" value="0">
                                <input type="checkbox" name="is_elevenplus" id="is_elevenplus" value="1" {{ (!empty($subscribe) and $subscribe->is_elevenplus) ? 'checked="checked"' : '' }}
                                class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_elevenplus">11Plus</label>
                            </label>
                        </div>

                        <div class="form-group custom-switches-stacked">
                            <label class="custom-switch pl-0">
                                <input type="hidden" name="is_popular" value="0">
                                <input type="checkbox" name="is_popular" id="isPopular" value="1" {{ (!empty($subscribe) and $subscribe->is_popular) ? 'checked="checked"' : '' }}
                                class="custom-switch-input"/>
                                <span class="custom-switch-indicator"></span>
                                <label class="custom-switch-description mb-0 cursor-pointer" for="isPopular">{{ trans('admin/pages/financial.is_popular') }}</label>
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
</section>
@endsection

