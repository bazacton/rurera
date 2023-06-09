@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/admin/css/draw-editor.css?ver={{$rand_id}}">
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<style>

    .hide-class {
        display: none;
    }

    .questions-list ul li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .questions-list ul li a.parent-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }
</style>
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
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/admin/books/{{ !empty($book) ? $book->id.'/store' : 'store' }}"
                              method="Post">
                            {{ csrf_field() }}

                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="basic-settings" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="editor-settings" data-toggle="tab" href="#editor" role="tab" aria-controls="editor" aria-selected="true">Editor</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane mt-3 fade active show" id="basic" role="tabpanel" aria-labelledby="basic-settings">


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

                                    <div class="questions-list">
                                        <ul>
                                            @foreach( $book->bookPages as $bookPage)
                                            @php $infoLinkArray = array(); @endphp

                                            @if(!empty($bookPage->PageInfoLinks))
                                                @foreach( $bookPage->PageInfoLinks as $pageInfoLink)
                                                    @php
                                                        if( !in_array( $pageInfoLink->info_type, array('text','highlighter'))){
                                                            $infoLinkArray[$pageInfoLink->info_type] = $pageInfoLink->info_type;
                                                        }
                                                    @endphp
                                                @endforeach
                                            @endif

                                            <li data-id="{{$bookPage->id}}">
                                                <img src="/{{$bookPage->page_path}}" height="200" width="auto">
                                                <input type="text" name="book_pages_titles[]" value="{{$bookPage->page_title}}">
                                                <input type="hidden" name="book_pages[]" value="{{$bookPage->id}}">
                                                <a href="javascript:;" class="parent-remove"><span class="fas fa-trash"></span></a>
                                                @if( !empty( $infoLinkArray ))
                                                    @foreach( $infoLinkArray as $infoLinkData)
                                                        <img src="/assets/default/img/book-icons/{{$infoLinkData}}.png">
                                                    @endforeach
                                                @endif

                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>


                                    <div class="text-right mt-4">
                                        <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                    </div>


                                </div>

                                <div class="tab-pane mt-3 fade" id="editor" role="tabpanel" aria-labelledby="editor-settings">
                                    <div class="editor-zone" style="height:956px; width:770px;position:relative;">

                                        @if( !empty($book->bookPages ) )
                                        @php $i = 1; @endphp
                                        @foreach( $book->bookPages as $bookPage)
                                        <div class="book-dropzone {{ ($i > 1)? 'hide' : 'active'}}"
                                             style="background:url('/{{$bookPage->page_path}}');"
                                             data-page_id="{{$bookPage->id}}">


                                            @if(!empty($bookPage->PageInfoLinks))
                                            @foreach( $bookPage->PageInfoLinks as $pageInfoLink)
                                            @include('admin.books.includes.'.$pageInfoLink->info_type,['pageInfoLink'=> $pageInfoLink])
                                            @endforeach
                                            @endif


                                        </div>
                                        @php $i++; @endphp
                                        @endforeach

                                        @include('admin.books.includes.editor_controls')
                                        <br>
                                        <br>
                                        <div class="generate"><a class="btn btn-primary" href="javascript:;">Save Page</a></div>
                                        @endif
                                    </div>
                                </div>

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
<script src="/assets/admin/js/book-editor.js?ver={{$rand_id}}"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".questions-list ul").sortable();


    });
</script>
@endpush
