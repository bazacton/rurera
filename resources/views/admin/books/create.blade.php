@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($book) ?trans('/admin/main.edit'): trans('admin/main.new') }} Book</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/glossary">Book</a>
            </div>
            <div class="breadcrumb-item">{{!empty($book) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/books/{{ !empty($book) ? $book->id.'/store' : 'store' }}"
                              method="Post">
                            {{ csrf_field() }}


                            <div class="form-group">
                                <label>Book Title</label>
                                <input type="text" name="book_title"
                                       class="form-control  @error('book_title') is-invalid @enderror"
                                       value="{{ !empty($book) ? $book->book_title : old('book_title') }}"
                                       placeholder="{{ trans('admin/main.choose_title') }}"/>

                                @error('book_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="input-label">Book PDF</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="input-group-text admin-file-manager"
                                                data-input="book_pdf" data-preview="holder">
                                            <i class="fa fa-chevron-up"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="book_pdf"
                                           id="book_pdf"
                                           value="{{ !empty($book) ? $book->book_pdf : old('book_pdf') }}"
                                           class="form-control"/>
                                </div>
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
