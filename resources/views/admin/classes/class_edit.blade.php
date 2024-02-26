<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/admin/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.css">
<style>
    /**********************************************
    Questions Select, Questions Block style Start
    **********************************************/
    .questions-select-option ul {
        overflow: hidden;
    }

    .questions-select-option li {
        position: relative;
        flex: 1 1 0px;
    }

    .questions-select-option label {
        background-color: #e8e8e8;
        padding: 6px 20px;
        margin: 0;
        border-right: 1px solid rgba(0, 0, 0, 0.1);
        width: 100%;
        text-align: center;
        height: 100%;
        cursor: pointer;
        min-height: 55px;
    }

    .questions-select-option input,
    .questions-select-number input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .questions-select-option li:first-child label {
        border-radius: 5px 0 0 5px;
    }

    .questions-select-option li:last-child label {
        border-radius: 0 5px 5px 0;
    }

    .questions-select-option input:checked ~ label {
        background-color: var(--primary);
        color: #fff;
    }

    .questions-select-option label strong {
        font-weight: 500;
        font-size: 15px;
    }

    .questions-select-option label span {
        font-size: 14px;
    }

    .questions-select-number li {
        flex-basis: 33%;
        padding: 0 0 10px 10px;
    }

    .questions-select-number label {
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.1);
        width: 100%;
        text-align: center;
        margin: 0;
        border-radius: 5px;
        min-height: 70px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
    }

    .questions-select-number label.disabled {
        background-color: inherit;
    }

    .questions-select-number label.selectable {
        background-color: #fff;
    }

    .questions-select-number input:checked ~ label {
        background-color: var(--primary);
        color: #fff;
    }

    .questions-select-number ul {
        margin: 0 0 0 -10px;
        flex-wrap: wrap;
    }

    .questions-submit-btn {
        background-color: var(--primary);
        display: block;
        width: 92%;
        color: #fff;
        font-size: 24px;
        font-weight: 700;
        border-radius: 0;
        position: relative;
        z-index: 0;
        margin: 0 auto;
        height: 55px;
    }

    .questions-submit-btn:hover {
        color: #fff;
    }

    .questions-submit-btn:before,
    .questions-submit-btn:after {
        content: "";
        position: absolute;
        display: block;
        width: 100%;
        height: 105%;
        top: -1px;
        left: -1px;
        z-index: -1;
        pointer-events: none;
        background: var(--primary);
        transform-origin: top left;
        -ms-transform: skew(-30deg, 0deg);
        -webkit-transform: skew(-30deg, 0deg);
        transform: skew(-30deg, 0deg);
    }

    .questions-submit-btn:after {
        left: auto;
        right: -1px;
        transform-origin: top right;
        -ms-transform: skew(30deg, 0deg);
        -webkit-transform: skew(30deg, 0deg);
        transform: skew(30deg, 0deg);
    }
</style>
@php $tables_no = isset( $class->timestables_no)? json_decode($class->timestables_no) : array(); @endphp

<section class="section">


    <div class="section-body populated-data">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                        <form action="{{ getAdminPanelUrl() }}/classes/{{ !empty($class) ? $class->id.'/store' : 'store' }}"
                              method="Post">
                            {{ csrf_field() }}

                            @if(!empty(getGeneralSettings('content_translate')))
                            <div class="form-group">
                                <label class="input-label">{{ trans('auth.language') }}</label>
                                <select name="locale"
                                        class="form-control {{ !empty($class) ? 'js-edit-content-locale' : '' }}">
                                    @foreach($userLanguages as $lang => $language)
                                    <option value="{{ $lang }}" @if(mb_strtolower(request()->get('locale',
                                        app()->getLocale())) == mb_strtolower($lang)) selected @endif>{{ $language }}
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

                            <div class="form-group">
                                <label>Curriculum</label>
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                    <option {{ !empty($trend) ?
                                    '' : 'selected' }} disabled>{{ trans('admin/main.choose_category') }}</option>

                                    @foreach($categories as $category)
                                    @if(!empty($category->subCategories) and count($category->subCategories))
                                    <optgroup label="{{  $category->title }}">
                                        @foreach($category->subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}" @if(!empty($class) and $class->
                                            category_id == $subCategory->id) selected="selected" @endif>{{
                                            $subCategory->title }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @else
                                    <option value="{{ $category->id }}" class="font-weight-bold" @if(!empty($class)
                                            and $class->category_id == $category->id) selected="selected" @endif>{{
                                        $category->title }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ trans('/admin/main.title') }}</label>
                                <input type="text" name="title"
                                       class="form-control  @error('title') is-invalid @enderror"
                                       value="{{ !empty($class) ? $class->title : old('title') }}"
                                       placeholder="{{ trans('admin/main.choose_title') }}"/>
                                @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group assignment_topic_type_fields timestables_fields ">
                                <label>Timestables</label>
                                <div class="questions-select-number">
                                    <ul class="d-flex justify-content-center flex-wrap mb-30">
                                        <li><input type="checkbox" value="10" name="tables_no[]" {{in_array(10,$tables_no)?
                                            'checked' : ''}} id="tables_ten" /> <label for="tables_ten">10</label></li>
                                        <li><input type="checkbox" value="2" name="tables_no[]" {{in_array(2,$tables_no)?
                                            'checked' : ''}} id="tables_two" /> <label for="tables_two">2</label></li>
                                        <li><input type="checkbox" value="5" name="tables_no[]" {{in_array(5,$tables_no)?
                                            'checked' : ''}} id="tables_five" /> <label for="tables_five">5</label></li>
                                        <li><input type="checkbox" value="3" name="tables_no[]" {{in_array(3,$tables_no)?
                                            'checked' : ''}} id="tables_three" /> <label for="tables_three">3</label></li>
                                        <li><input type="checkbox" value="4" name="tables_no[]" {{in_array(4,$tables_no)?
                                            'checked' : ''}} id="tables_four" /> <label for="tables_four">4</label></li>
                                        <li><input type="checkbox" value="8" name="tables_no[]" {{in_array(8,$tables_no)?
                                            'checked' : ''}} id="tables_eight" /> <label for="tables_eight">8</label></li>
                                        <li><input type="checkbox" value="6" name="tables_no[]" {{in_array(6,$tables_no)?
                                            'checked' : ''}} id="tables_six" /> <label for="tables_six">6</label></li>
                                        <li><input type="checkbox" value="7" name="tables_no[]" {{in_array(7,$tables_no)?
                                            'checked' : ''}} id="tables_seven" /> <label for="tables_seven">7</label></li>
                                        <li><input type="checkbox" value="9" name="tables_no[]" {{in_array(9,$tables_no)?
                                            'checked' : ''}} id="tables_nine" /> <label for="tables_nine">9</label></li>
                                        <li><input type="checkbox" value="11" name="tables_no[]" {{in_array(11,$tables_no)?
                                            'checked' : ''}} id="tables_eleven" /> <label for="tables_eleven">11</label></li>
                                        <li><input type="checkbox" value="12" name="tables_no[]" {{in_array(12,$tables_no)?
                                            'checked' : ''}} id="tables_twelve" /> <label for="tables_twelve">12</label></li>
                                        <li><input type="checkbox" value="13" name="tables_no[]" {{in_array(13,$tables_no)?
                                            'checked' : ''}} id="tables_thirteen" /> <label for="tables_thirteen">13</label></li>
                                        <li><input type="checkbox" value="14" name="tables_no[]" {{in_array(14,$tables_no)?
                                            'checked' : ''}} id="tables_fourteen" /> <label for="tables_fourteen">14</label></li>
                                        <li><input type="checkbox" value="15" name="tables_no[]" {{in_array(15,$tables_no)?
                                            'checked' : ''}} id="tables_fifteen" /> <label for="tables_fifteen">15</label></li>
                                        <li><input type="checkbox" value="16" name="tables_no[]" {{in_array(16,$tables_no)?
                                            'checked' : ''}} id="tables_sixteen" /> <label for="tables_sixteen">16</label></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="apply_all" type="checkbox" name="apply_all"
                                           class="custom-control-input">
                                    <label class="custom-control-label"
                                           for="apply_all">Apply To All Users</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input id="hasSubCategory" type="checkbox" name="has_sub"
                                           class="custom-control-input" {{ (!empty($class->sections))
                                    ? 'checked' : '' }}>
                                    <label class="custom-control-label"
                                           for="hasSubCategory">Sections</label>
                                </div>
                            </div>

                            <div id="subCategories"
                                 class="ml-0 {{ (!empty($class->sections)) ? '' : ' d-none' }}">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <strong class="d-block">Sections</strong>

                                    <button type="button" class="btn btn-success add-btn"><i class="fa fa-plus"></i> Add
                                    </button>
                                </div>

                                <ul class="draggable-lists list-group">

                                    @if((!empty($class->sections)))
                                    @foreach($class->sections as $key => $sectionObj)
                                    <li class="form-group list-group">

                                        <div class="p-2 border rounded-sm">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text cursor-pointer move-icon">
                                                        <i class="fa fa-arrows-alt"></i>
                                                    </div>
                                                </div>

                                                <input type="text" name="sections[{{ $sectionObj->id }}][title]"
                                                       class="form-control w-auto flex-grow-1"
                                                       value="{{ $sectionObj->title }}"
                                                       placeholder="{{ trans('admin/main.choose_title') }}"/>

                                                <input type="text" name="section_code"
                                               class="form-control"
                                               value="{{ $sectionObj->class_code }}" readonly disabled/>


                                                <div class="input-group-append">
                                                    @include('admin.includes.delete_button',[
                                                    'url' => getAdminPanelUrl("/classes/{$sectionObj->id}/delete"),
                                                    'deleteConfirmMsg' => trans('update.category_delete_confirm_msg'),
                                                    'btnClass' => 'btn btn-danger text-white',
                                                    'noBtnTransparent' => true
                                                    ])
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <div class="text-right">
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>

                        <li class="form-group main-row list-group d-none">
                            <div class="p-2 border rounded-sm">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text cursor-pointer move-icon">
                                            <i class="fa fa-arrows-alt"></i>
                                        </div>
                                    </div>

                                    <input type="text" name="sections[record][title]"
                                           class="form-control w-auto flex-grow-1"
                                           placeholder="{{ trans('admin/main.choose_title') }}"/>

                                    <div class="input-group-append">
                                        <button type="button" class="btn remove-btn btn-danger"><i
                                                    class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </div>
        </div>
    </div>
</section>
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

<script src="/assets/default/js/admin/categories.min.js"></script>
<script src="/assets/admin/vendor/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>