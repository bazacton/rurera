@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{!empty($school) ?trans('/admin/main.edit'): trans('admin/main.new') }} School</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active"><a href="/admin/schools">Schools</a>
                </div>
                <div class="breadcrumb-item">{{!empty($school) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="/admin/schools/{{ !empty($school) ? $school->id.'/store' : 'store' }}"
                                  method="Post">
                                {{ csrf_field() }}


                                <div class="form-group">
                                    <label>School Name</label>
                                    <input type="text" name="title"
                                           class="form-control  @error('title') is-invalid @enderror"
                                           value="{{ !empty($school) ? $school->title : old('title') }}"
                                           placeholder="{{ trans('admin/main.choose_title') }}"/>

                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="text-right mt-4">
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
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
    <script src="/assets/default/js/admin/filters.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
@endpush
