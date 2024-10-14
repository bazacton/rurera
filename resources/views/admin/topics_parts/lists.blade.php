@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Topics Parts</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Topics Parts</div>
        </div>
    </div>


    <div class="section-body">

        <section class="card">
            <div class="card-body">
                <form action="/admin/topics_parts" method="get" class="row mb-0">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{trans('admin/main.category')}}</label>
                            <select name="category_id" data-plugin-selectTwo class="form-control populate ajax-category-courses">
                                <option value="">{{trans('admin/main.all_categories')}}</option>
                                @foreach($categories as $category)
                                @if(!empty($category->subCategories) and count($category->subCategories))
                                <optgroup label="{{  $category->title }}">
                                    @foreach($category->subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @if(request()->get('category_id') == $subCategory->id) selected="selected" @endif>{{ $subCategory->title }}</option>
                                    @endforeach
                                </optgroup>
                                @else
                                <option value="{{ $category->id }}" @if(request()->get('category_id') == $category->id) selected="selected" @endif>{{ $category->title }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}</button>
                    </div>
                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    @can('admin_glossary_create')
                    <div class="card-header">
                        <div class="text-right">
                            <a href="/admin/topics_parts/create" class="btn btn-primary">New Topic Part</a>
                        </div>
                    </div>
                    @endcan

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">Paragraph</th>
                                    <th class="text-left">Category</th>
                                    <th class="text-left">Added by</th>
                                    <th class="text-left">Added Date</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>

                                @foreach($TopicParts as $TopicPartsData)
                                <tr>
                                    <td>
                                        <span>{{ $TopicPartsData->paragraph }}</span>
                                    </td>
                                    <td class="text-left">{{ $TopicPartsData->category->getTitleAttribute() }}</td>
                                    <td class="text-left">{{ $TopicPartsData->user->get_full_name() }}</td>
                                    <td class="text-left">{{ dateTimeFormat($TopicPartsData->created_at, 'j M y | H:i') }}</td>
                                    <td>
                                        @can('admin_glossary_edit')
                                        <a href="/admin/topics_parts/{{ $TopicPartsData->id }}/edit" class="btn-transparent btn-sm text-primary" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan

                                        @can('admin_glossary_delete')
                                        @include('admin.includes.delete_button',['url' => '/admin/topics_parts/'.$TopicPartsData->id.'/delete' , 'btnClass' => 'btn-sm'])
                                        @endcan
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $TopicParts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush
