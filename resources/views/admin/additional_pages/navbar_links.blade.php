@extends('admin.layouts.app')


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.settings_navbar_links') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ trans('admin/main.settings_navbar_links') }}</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12 col-md-8 col-lg-6">
                                    <form action="{{ getAdminPanelUrl() }}/additional_page/navbar_links/store" method="post">
                                        {{ csrf_field() }}

                                        <input type="hidden" name="navbar_link" value="{{ !empty($navbarLinkKey) ? $navbarLinkKey : 'newLink' }}">

                                        @if(!empty(getGeneralSettings('content_translate')))
                                            <div class="form-group">
                                                <label class="input-label">{{ trans('auth.language') }}</label>
                                                <select name="locale" class="form-control js-edit-content-locale">
                                                    @foreach($userLanguages as $lang => $language)
                                                        <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale', $selectedLocal)) == mb_strtolower($lang)) selected @endif>{{ $language }}</option>
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
                                            <input type="text" name="value[title]" value="{{ (!empty($navbar_link)) ? $navbar_link->title : old('value.title') }}" class="form-control  @error('value.title') is-invalid @enderror"/>
                                            @error('value.title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('public.link') }}</label>
                                            <input type="text" name="value[link]" value="{{ (!empty($navbar_link)) ? $navbar_link->link : old('value.link') }}" class="form-control  @error('value.link') is-invalid @enderror"/>
                                            @error('value.link')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('admin/main.order') }}</label>
                                            <input type="number" name="value[order]" value="{{ (!empty($navbar_link)) ? $navbar_link->order : old('value.order') }}" class="form-control  @error('value.order') is-invalid @enderror"/>
                                            @error('value.order')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Menu Classes</label>
                                            <input type="text" name="value[menu_classes]" value="{{ (!empty
                                                                                            ($navbar_link) && isset( $navbar_link->menu_classes )) ?
                                                                                            $navbar_link->menu_classes : old('value
                                                                                            .menu_classes') }}" class="form-control  @error('value.menu_classes') is-invalid @enderror"/>
                                            @error('value.menu_classes')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        
                                        
                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[is_mega_menu]" value="0">
                                                <input type="checkbox" name="value[is_mega_menu]" id="is_mega_menu" value="1" {{ (!empty($navbar_link) && isset( $navbar_link->is_mega_menu ) && $navbar_link->is_mega_menu == 1) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_mega_menu">Mega Menu</label>
                                            </label>
                                        </div>

                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[is_other_panel]" value="0">
                                                    <input type="checkbox" name="value[is_other_panel]" id="is_other_panel" value="1" {{ (!empty($navbar_link) && isset( $navbar_link->is_other_panel ) && $navbar_link->is_other_panel == 1) ? 'checked="checked"' : '' }} {{ (!isset( $navbar_link->is_other_panel )) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_other_panel">Show on all Other Panels</label>
                                            </label>
                                        </div>

                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[is_student_panel]" value="0">
                                                <input type="checkbox" name="value[is_student_panel]" id="is_student_panel" value="1" {{ (!empty($navbar_link) && isset( $navbar_link->is_student_panel ) && $navbar_link->is_student_panel == 1) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_student_panel">Show on Student Panel</label>
                                            </label>
                                        </div>

                                        <div class="form-group custom-switches-stacked">
                                            <label class="custom-switch pl-0">
                                                <input type="hidden" name="value[is_parent_panel]" value="0">
                                                <input type="checkbox" name="value[is_parent_panel]" id="is_parent_panel" value="1" {{ (!empty($navbar_link) && isset( $navbar_link->is_parent_panel ) && $navbar_link->is_parent_panel == 1) ? 'checked="checked"' : '' }} class="custom-switch-input"/>
                                                <span class="custom-switch-indicator"></span>
                                                <label class="custom-switch-description mb-0 cursor-pointer" for="is_parent_panel">Show on Parent Panel</label>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>Sub Menu</label>
                                            <textarea placeholder='<li><a href="#">Sub Menu 1</a></li>' name="value[submenu]" class="form-control">{{ (!empty
                                                ($navbar_link) && isset( $navbar_link->submenu )) ?
                                                $navbar_link->submenu : old('value
                                                .submenu') }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-1">{{ trans('admin/main.submit') }}</button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th>{{ trans('admin/main.title') }}</th>
                                        <th>{{ trans('admin/main.link') }}</th>
                                        <th>{{ trans('admin/main.order') }}</th>
                                        <th>{{ trans('admin/main.actions') }}</th>
                                    </tr>

                                    @if(!empty($items))
                                        @foreach($items as $key => $val)
                                            <tr>
                                                <td>{{ $val['title'] }}</td>
                                                <td>{{ $val['link'] }}</td>
                                                <td>{{ $val['order'] }}</td>
                                                <td>
                                                    <a href="{{ getAdminPanelUrl() }}/additional_page/navbar_links/{{ $key }}/edit" class="btn-sm" data-toggle="tooltip" data-placement="top" title="{{ trans('admin/main.edit') }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    @include('admin.includes.delete_button',['url' => getAdminPanelUrl().'/additional_page/navbar_links/'. $key .'/delete','btnClass' => 'btn-sm'])
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
