@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{!empty($user) ?trans('/admin/main.edit'): trans('admin/main.new') }} {{ trans('admin/main.user') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard')
                    }}</a>
            </div>
            <div class="breadcrumb-item"><a>{{ trans('admin/main.users') }}</a>
            </div>
            <div class="breadcrumb-item">{{!empty($user) ?trans('/admin/main.edit'): trans('admin/main.new') }}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <form action="{{ getAdminPanelUrl() }}/users/store" method="Post">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label>{{ trans('/admin/main.full_name') }}</label>
                                        <input type="text" name="full_name"
                                               class="form-control  @error('full_name') is-invalid @enderror"
                                               value="{{ old('full_name') }}"
                                               placeholder="{{ trans('admin/main.create_field_full_name_placeholder') }}"/>
                                        @error('full_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input name="username" type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               id="username" value="{{ old('username') }}" aria-describedby="emailHelp">
                                        @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label">{{ trans('admin/main.password') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                    <span type="button" class="input-group-text">
                                                        <i class="fa fa-lock"></i>
                                                    </span>
                                            </div>
                                            <input type="password" name="password"
                                                   class="form-control @error('password') is-invalid @enderror"/>
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>


                                    @if(auth()->user()->isTeacher())

                                    <input type="hidden" id="roleId" name="role_id" value="1">

                                    @else
                                    <div class="form-group">
                                        <label>{{ trans('/admin/main.role_name') }}</label>
                                        <select class="form-control select2 @error('role_id') is-invalid @enderror"
                                                id="roleId" name="role_id">
                                            <option disabled selected>{{ trans('admin/main.select_role') }}</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ old(
                                            'role_id') === $role->id ? 'selected' :''}}>{{ $role->name }} - {{
                                            $role->caption }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group" id="groupSelect">
                                        <label class="input-label d-block">{{ trans('admin/main.group') }}</label>
                                        <select name="group_id"
                                                class="form-control select2 @error('group_id') is-invalid @enderror">
                                            <option value="" selected disabled></option>

                                            @foreach($userGroups as $userGroup)
                                            <option value="{{ $userGroup->id }}" @if(!empty($notification) and
                                                    !empty($notification->group) and $notification->group->id ==
                                                $userGroup->id) selected @endif>{{ $userGroup->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">@error('group_id') {{ $message }} @enderror</div>
                                    </div>

                                    @endif

                                    <div class="form-group">
                                        <label>Year</label>
                                        <select data-default_id="{{isset( $user->id)? $user->year_id : 0}}" class="form-control year_class_ajax_select @error('year_id') is-invalid @enderror"
                                                name="year_id">
                                            <option {{ !empty($trend) ?
                                            '' : 'selected' }} disabled>Select Year</option>

                                            @foreach($categories as $category)
                                            @if(!empty($category->subCategories) and count($category->subCategories))
                                            <optgroup label="{{  $category->title }}">
                                                @foreach($category->subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}">{{$subCategory->title }}</option>
                                                @endforeach
                                            </optgroup>
                                            @else
                                            <option value="{{ $category->id }}" class="font-weight-bold">{{
                                                $category->title }}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('year_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Student Class</label>
                                        <select data-default_id="{{isset( $user->id)? $user->class_id : 0}}" class="class_section_ajax_select student_section form-control select2 @error('class_id') is-invalid @enderror"
                                                id="class_id" name="class_id">
                                            <option disabled selected>Class</option>
                                        </select>
                                        @error('class_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Class Section</label>
                                        <select data-default_id="{{isset( $user->id)? $user->section_id : 0}}" class="section_ajax_select student_section form-control select2 @error('section_id') is-invalid @enderror"
                                                id="section_id" name="section_id">
                                            <option disabled selected>Section</option>
                                        </select>
                                        @error('section_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{ trans('/admin/main.status') }}</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                                name="status">
                                            <option disabled selected>{{ trans('admin/main.select_status') }}</option>
                                            @foreach (\App\User::$statuses as $status)
                                            <option
                                                    value="{{ $status }}" {{ old(
                                            'status') === $status ? 'selected' :''}}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
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
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush

