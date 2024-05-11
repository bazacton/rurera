@extends('admin.layouts.app')

@push('libraries_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    /*!
     * Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
     *
     * Copyright 2012 Stefan Petre
     * Improvements by Andrew Rowls
     * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
     */
    .ui-datepicker {
        z-index: 99999 !important;
    }
    .datepicker {
      padding: 4px;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      direction: ltr;
    }
    .datepicker-inline {
      width: 220px;
    }
    .datepicker.datepicker-rtl {
      direction: rtl;
    }
    .datepicker.datepicker-rtl table tr td span {
      float: right;
    }
    .datepicker-dropdown {
      top: 0;
      left: 0;
    }
    .datepicker-dropdown:before {
      content: '';
      display: inline-block;
      border-left: 7px solid transparent;
      border-right: 7px solid transparent;
      border-bottom: 7px solid #999999;
      border-top: 0;
      border-bottom-color: rgba(0, 0, 0, 0.2);
      position: absolute;
    }
    .datepicker-dropdown:after {
      content: '';
      display: inline-block;
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-bottom: 6px solid #ffffff;
      border-top: 0;
      position: absolute;
    }
    .datepicker-dropdown.datepicker-orient-left:before {
      left: 6px;
    }
    .datepicker-dropdown.datepicker-orient-left:after {
      left: 7px;
    }
    .datepicker-dropdown.datepicker-orient-right:before {
      right: 6px;
    }
    .datepicker-dropdown.datepicker-orient-right:after {
      right: 7px;
    }
    .datepicker-dropdown.datepicker-orient-bottom:before {
      top: -7px;
    }
    .datepicker-dropdown.datepicker-orient-bottom:after {
      top: -6px;
    }
    .datepicker-dropdown.datepicker-orient-top:before {
      bottom: -7px;
      border-bottom: 0;
      border-top: 7px solid #999999;
    }
    .datepicker-dropdown.datepicker-orient-top:after {
      bottom: -6px;
      border-bottom: 0;
      border-top: 6px solid #ffffff;
    }
    .datepicker > div {
      display: none;
    }
    .datepicker table {
      margin: 0;
      -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    .datepicker td,
    .datepicker th {
      text-align: center;
      width: 20px;
      height: 20px;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      border: none;
    }
    .table-striped .datepicker table tr td,
    .table-striped .datepicker table tr th {
      background-color: transparent;
    }
    .datepicker table tr td.day:hover,
    .datepicker table tr td.day.focused {
      background: #eeeeee;
      cursor: pointer;
    }
    .datepicker table tr td.old,
    .datepicker table tr td.new {
      color: #999999;
    }
    .datepicker table tr td.disabled,
    .datepicker table tr td.disabled:hover {
      background: none;
      color: #999999;
      cursor: default;
    }
    .datepicker table tr td.highlighted {
      background: #d9edf7;
      border-radius: 0;
    }
    .datepicker table tr td.today,
    .datepicker table tr td.today:hover,
    .datepicker table tr td.today.disabled,
    .datepicker table tr td.today.disabled:hover {
      background-color: #fde19a;
      background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
      background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
      background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
      background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
      background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
      background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
      background-repeat: repeat-x;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
      border-color: #fdf59a #fdf59a #fbed50;
      border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
      filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
      color: #000;
    }
    .datepicker table tr td.today:hover,
    .datepicker table tr td.today:hover:hover,
    .datepicker table tr td.today.disabled:hover,
    .datepicker table tr td.today.disabled:hover:hover,
    .datepicker table tr td.today:active,
    .datepicker table tr td.today:hover:active,
    .datepicker table tr td.today.disabled:active,
    .datepicker table tr td.today.disabled:hover:active,
    .datepicker table tr td.today.active,
    .datepicker table tr td.today:hover.active,
    .datepicker table tr td.today.disabled.active,
    .datepicker table tr td.today.disabled:hover.active,
    .datepicker table tr td.today.disabled,
    .datepicker table tr td.today:hover.disabled,
    .datepicker table tr td.today.disabled.disabled,
    .datepicker table tr td.today.disabled:hover.disabled,
    .datepicker table tr td.today[disabled],
    .datepicker table tr td.today:hover[disabled],
    .datepicker table tr td.today.disabled[disabled],
    .datepicker table tr td.today.disabled:hover[disabled] {
      background-color: #fdf59a;
    }
    .datepicker table tr td.today:active,
    .datepicker table tr td.today:hover:active,
    .datepicker table tr td.today.disabled:active,
    .datepicker table tr td.today.disabled:hover:active,
    .datepicker table tr td.today.active,
    .datepicker table tr td.today:hover.active,
    .datepicker table tr td.today.disabled.active,
    .datepicker table tr td.today.disabled:hover.active {
      background-color: #fbf069 \9;
    }
    .datepicker table tr td.today:hover:hover {
      color: #000;
    }
    .datepicker table tr td.today.active:hover {
      color: #fff;
    }
    .datepicker table tr td.range,
    .datepicker table tr td.range:hover,
    .datepicker table tr td.range.disabled,
    .datepicker table tr td.range.disabled:hover {
      background: #eeeeee;
      -webkit-border-radius: 0;
      -moz-border-radius: 0;
      border-radius: 0;
    }
    .datepicker table tr td.range.today,
    .datepicker table tr td.range.today:hover,
    .datepicker table tr td.range.today.disabled,
    .datepicker table tr td.range.today.disabled:hover {
      background-color: #f3d17a;
      background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
      background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
      background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
      background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
      background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
      background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
      background-repeat: repeat-x;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
      border-color: #f3e97a #f3e97a #edde34;
      border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
      filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
      -webkit-border-radius: 0;
      -moz-border-radius: 0;
      border-radius: 0;
    }
    .datepicker table tr td.range.today:hover,
    .datepicker table tr td.range.today:hover:hover,
    .datepicker table tr td.range.today.disabled:hover,
    .datepicker table tr td.range.today.disabled:hover:hover,
    .datepicker table tr td.range.today:active,
    .datepicker table tr td.range.today:hover:active,
    .datepicker table tr td.range.today.disabled:active,
    .datepicker table tr td.range.today.disabled:hover:active,
    .datepicker table tr td.range.today.active,
    .datepicker table tr td.range.today:hover.active,
    .datepicker table tr td.range.today.disabled.active,
    .datepicker table tr td.range.today.disabled:hover.active,
    .datepicker table tr td.range.today.disabled,
    .datepicker table tr td.range.today:hover.disabled,
    .datepicker table tr td.range.today.disabled.disabled,
    .datepicker table tr td.range.today.disabled:hover.disabled,
    .datepicker table tr td.range.today[disabled],
    .datepicker table tr td.range.today:hover[disabled],
    .datepicker table tr td.range.today.disabled[disabled],
    .datepicker table tr td.range.today.disabled:hover[disabled] {
      background-color: #f3e97a;
    }
    .datepicker table tr td.range.today:active,
    .datepicker table tr td.range.today:hover:active,
    .datepicker table tr td.range.today.disabled:active,
    .datepicker table tr td.range.today.disabled:hover:active,
    .datepicker table tr td.range.today.active,
    .datepicker table tr td.range.today:hover.active,
    .datepicker table tr td.range.today.disabled.active,
    .datepicker table tr td.range.today.disabled:hover.active {
      background-color: #efe24b \9;
    }
    .datepicker table tr td.selected,
    .datepicker table tr td.selected:hover,
    .datepicker table tr td.selected.disabled,
    .datepicker table tr td.selected.disabled:hover {
      background-color: #9e9e9e;
      background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
      background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
      background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
      background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
      background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
      background-image: linear-gradient(to bottom, #b3b3b3, #808080);
      background-repeat: repeat-x;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
      border-color: #808080 #808080 #595959;
      border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
      filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
      color: #fff;
      text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .datepicker table tr td.selected:hover,
    .datepicker table tr td.selected:hover:hover,
    .datepicker table tr td.selected.disabled:hover,
    .datepicker table tr td.selected.disabled:hover:hover,
    .datepicker table tr td.selected:active,
    .datepicker table tr td.selected:hover:active,
    .datepicker table tr td.selected.disabled:active,
    .datepicker table tr td.selected.disabled:hover:active,
    .datepicker table tr td.selected.active,
    .datepicker table tr td.selected:hover.active,
    .datepicker table tr td.selected.disabled.active,
    .datepicker table tr td.selected.disabled:hover.active,
    .datepicker table tr td.selected.disabled,
    .datepicker table tr td.selected:hover.disabled,
    .datepicker table tr td.selected.disabled.disabled,
    .datepicker table tr td.selected.disabled:hover.disabled,
    .datepicker table tr td.selected[disabled],
    .datepicker table tr td.selected:hover[disabled],
    .datepicker table tr td.selected.disabled[disabled],
    .datepicker table tr td.selected.disabled:hover[disabled] {
      background-color: #808080;
    }
    .datepicker table tr td.selected:active,
    .datepicker table tr td.selected:hover:active,
    .datepicker table tr td.selected.disabled:active,
    .datepicker table tr td.selected.disabled:hover:active,
    .datepicker table tr td.selected.active,
    .datepicker table tr td.selected:hover.active,
    .datepicker table tr td.selected.disabled.active,
    .datepicker table tr td.selected.disabled:hover.active {
      background-color: #666666 \9;
    }
    .datepicker table tr td.active,
    .datepicker table tr td.active:hover,
    .datepicker table tr td.active.disabled,
    .datepicker table tr td.active.disabled:hover {
      background-color: #006dcc;
      background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
      background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: linear-gradient(to bottom, #0088cc, #0044cc);
      background-repeat: repeat-x;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
      border-color: #0044cc #0044cc #002a80;
      border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
      filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
      color: #fff;
      text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .datepicker table tr td.active:hover,
    .datepicker table tr td.active:hover:hover,
    .datepicker table tr td.active.disabled:hover,
    .datepicker table tr td.active.disabled:hover:hover,
    .datepicker table tr td.active:active,
    .datepicker table tr td.active:hover:active,
    .datepicker table tr td.active.disabled:active,
    .datepicker table tr td.active.disabled:hover:active,
    .datepicker table tr td.active.active,
    .datepicker table tr td.active:hover.active,
    .datepicker table tr td.active.disabled.active,
    .datepicker table tr td.active.disabled:hover.active,
    .datepicker table tr td.active.disabled,
    .datepicker table tr td.active:hover.disabled,
    .datepicker table tr td.active.disabled.disabled,
    .datepicker table tr td.active.disabled:hover.disabled,
    .datepicker table tr td.active[disabled],
    .datepicker table tr td.active:hover[disabled],
    .datepicker table tr td.active.disabled[disabled],
    .datepicker table tr td.active.disabled:hover[disabled] {
      background-color: #0044cc;
    }
    .datepicker table tr td.active:active,
    .datepicker table tr td.active:hover:active,
    .datepicker table tr td.active.disabled:active,
    .datepicker table tr td.active.disabled:hover:active,
    .datepicker table tr td.active.active,
    .datepicker table tr td.active:hover.active,
    .datepicker table tr td.active.disabled.active,
    .datepicker table tr td.active.disabled:hover.active {
      background-color: #003399 \9;
    }
    .datepicker table tr td span {
      display: block;
      width: 23%;
      height: 54px;
      line-height: 54px;
      float: left;
      margin: 1%;
      cursor: pointer;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
    }
    .datepicker table tr td span:hover {
      background: #eeeeee;
    }
    .datepicker table tr td span.disabled,
    .datepicker table tr td span.disabled:hover {
      background: none;
      color: #999999;
      cursor: default;
    }
    .datepicker table tr td span.active,
    .datepicker table tr td span.active:hover,
    .datepicker table tr td span.active.disabled,
    .datepicker table tr td span.active.disabled:hover {
      background-color: #006dcc;
      background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
      background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
      background-image: linear-gradient(to bottom, #0088cc, #0044cc);
      background-repeat: repeat-x;
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
      border-color: #0044cc #0044cc #002a80;
      border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
      filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
      color: #fff;
      text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .datepicker table tr td span.active:hover,
    .datepicker table tr td span.active:hover:hover,
    .datepicker table tr td span.active.disabled:hover,
    .datepicker table tr td span.active.disabled:hover:hover,
    .datepicker table tr td span.active:active,
    .datepicker table tr td span.active:hover:active,
    .datepicker table tr td span.active.disabled:active,
    .datepicker table tr td span.active.disabled:hover:active,
    .datepicker table tr td span.active.active,
    .datepicker table tr td span.active:hover.active,
    .datepicker table tr td span.active.disabled.active,
    .datepicker table tr td span.active.disabled:hover.active,
    .datepicker table tr td span.active.disabled,
    .datepicker table tr td span.active:hover.disabled,
    .datepicker table tr td span.active.disabled.disabled,
    .datepicker table tr td span.active.disabled:hover.disabled,
    .datepicker table tr td span.active[disabled],
    .datepicker table tr td span.active:hover[disabled],
    .datepicker table tr td span.active.disabled[disabled],
    .datepicker table tr td span.active.disabled:hover[disabled] {
      background-color: #0044cc;
    }
    .datepicker table tr td span.active:active,
    .datepicker table tr td span.active:hover:active,
    .datepicker table tr td span.active.disabled:active,
    .datepicker table tr td span.active.disabled:hover:active,
    .datepicker table tr td span.active.active,
    .datepicker table tr td span.active:hover.active,
    .datepicker table tr td span.active.disabled.active,
    .datepicker table tr td span.active.disabled:hover.active {
      background-color: #003399 \9;
    }
    .datepicker table tr td span.old,
    .datepicker table tr td span.new {
      color: #999999;
    }
    .datepicker .datepicker-switch {
      width: 145px;
    }
    .datepicker .datepicker-switch,
    .datepicker .prev,
    .datepicker .next,
    .datepicker tfoot tr th {
      cursor: pointer;
    }
    .datepicker .datepicker-switch:hover,
    .datepicker .prev:hover,
    .datepicker .next:hover,
    .datepicker tfoot tr th:hover {
      background: #eeeeee;
    }
    .datepicker .cw {
      font-size: 10px;
      width: 12px;
      padding: 0 2px 0 5px;
      vertical-align: middle;
    }
    .input-append.date .add-on,
    .input-prepend.date .add-on {
      cursor: pointer;
    }
    .input-append.date .add-on i,
    .input-prepend.date .add-on i {
      margin-top: 3px;
    }
    .input-daterange input {
      text-align: center;
    }
    .input-daterange input:first-child {
      -webkit-border-radius: 3px 0 0 3px;
      -moz-border-radius: 3px 0 0 3px;
      border-radius: 3px 0 0 3px;
    }
    .input-daterange input:last-child {
      -webkit-border-radius: 0 3px 3px 0;
      -moz-border-radius: 0 3px 3px 0;
      border-radius: 0 3px 3px 0;
    }
    .input-daterange .add-on {
      display: inline-block;
      width: auto;
      min-width: 16px;
      height: 18px;
      padding: 4px 5px;
      font-weight: normal;
      line-height: 18px;
      text-align: center;
      text-shadow: 0 1px 0 #ffffff;
      vertical-align: middle;
      background-color: #eeeeee;
      border: 1px solid #ccc;
      margin-left: -5px;
      margin-right: -5px;
    }

</style>
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>Daily Quests</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">Daily Quests</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Quests</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalQuests }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="section-body">

        <section class="card rurera-hide">
            <div class="card-body">
                <form action="{{ getAdminPanelUrl() }}/quizzes" method="get" class="row mb-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.search') }}</label>
                            <input type="text" class="form-control" name="title" value="{{ request()->get('title') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.start_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="fsdate" class="text-center form-control" name="from"
                                       value="{{ request()->get('from') }}" placeholder="Start Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.end_date') }}</label>
                            <div class="input-group">
                                <input type="date" id="lsdate" class="text-center form-control" name="to"
                                       value="{{ request()->get('to') }}" placeholder="End Date">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.filters') }}</label>
                            <select name="sort" data-plugin-selectTwo class="form-control populate">
                                <option value="">{{ trans('admin/main.filter_type') }}</option>
                                <option value="have_certificate" @if(request()->get('sort') == 'have_certificate')
                                    selected @endif>{{ trans('admin/main.quizzes_have_certificate') }}
                                </option>
                                <option value="students_count_asc" @if(request()->get('sort') == 'students_count_asc')
                                    selected @endif>{{ trans('admin/main.students_ascending') }}
                                </option>
                                <option value="students_count_desc" @if(request()->get('sort') == 'students_count_desc')
                                    selected @endif>{{ trans('admin/main.students_descending') }}
                                </option>
                                <option value="passed_count_asc" @if(request()->get('sort') == 'passed_count_asc')
                                    selected @endif>{{ trans('admin/main.passed_students_ascending') }}
                                </option>
                                <option value="passed_count_desc" @if(request()->get('sort') == 'passed_count_desc')
                                    selected @endif>{{ trans('admin/main.passes_students_descending') }}
                                </option>
                                <option value="grade_avg_asc" @if(request()->get('sort') == 'grade_avg_asc') selected
                                    @endif>{{ trans('admin/main.grades_average_ascending') }}
                                </option>
                                <option value="grade_avg_desc" @if(request()->get('sort') == 'grade_avg_desc') selected
                                    @endif>{{ trans('admin/main.grades_average_descending') }}
                                </option>
                                <option value="created_at_asc" @if(request()->get('sort') == 'created_at_asc') selected
                                    @endif>{{ trans('admin/main.create_date_ascending') }}
                                </option>
                                <option value="created_at_desc" @if(request()->get('sort') == 'created_at_desc')
                                    selected @endif>{{ trans('admin/main.create_date_descending') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.instructor') }}</label>
                            <select name="teacher_ids[]" multiple="multiple" data-search-option="just_teacher_role"
                                    class="form-control search-user-select2"
                                    data-placeholder="Search teachers">

                                @if(!empty($teachers) and $teachers->count() > 0)
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" selected>{{ $teacher->get_full_name() }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.class') }}</label>
                            <select name="webinar_ids[]" multiple="multiple" class="form-control search-webinar-select2"
                                    data-placeholder="Search classes">

                                @if(!empty($webinars) and $webinars->count() > 0)
                                @foreach($webinars as $webinar)
                                <option value="{{ $webinar->id }}" selected>{{ $webinar->title }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="input-label">{{ trans('admin/main.status') }}</label>
                            <select name="statue" data-plugin-selectTwo class="form-control populate">
                                <option value="">{{ trans('admin/main.all_status') }}</option>
                                <option value="active" @if(request()->get('status') == 'active') selected @endif>{{
                                    trans('admin/main.active') }}
                                </option>
                                <option value="inactive" @if(request()->get('status') == 'inactive') selected @endif>{{
                                    trans('admin/main.inactive') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 d-flex align-items-center justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">{{ trans('admin/main.show_results') }}
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        @can('admin_assignments_create')
                        <div class="text-right">
                            <a href="{{ getAdminPanelUrl() }}/daily_quests/create" class="btn btn-primary ml-2">Create
                                Quest</a>
                        </div>
                        @endcan
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">{{ trans('admin/main.title') }}</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Quest Created</th>
                                    <th class="text-center">Recurring</th>
                                    <th class="text-center">{{ trans('admin/main.status') }}</th>
                                    <th>{{ trans('admin/main.actions') }}</th>
                                </tr>


                                @foreach($quests as $questObj)
                                @php $dates_string = ''; $dates_array = json_decode($questObj->quest_dates);

                                if( !empty( $dates_array ) ){
                                    $formattedDates = array();
                                    foreach ($dates_array as $timestamp) {
                                        $formattedDates[] = date('d-m-Y', $timestamp);
                                    }
                                    $dates_string = implode(',', $formattedDates);
                                }
                                @endphp
                                <tr>
                                    <td>
                                        <span>{{$questObj->title}}</span>
                                    </td>
                                    <td>
                                        <span>{{$questObj->quest_topic_type}}</span>
                                    </td>
                                    <td>
                                        <span>{{ dateTimeFormat($questObj->created_at, 'j M Y H:i') }}</span>
                                    </td>
                                    <td>
                                        <span>{{$questObj->recurring_type}}</span>
                                    </td>

                                    <td class="text-center">
                                        @if($questObj->status != 'inactive')
                                        <span class="text-success">{{ trans('admin/main.active') }}</span>
                                        @else
                                        <span class="text-warning">{{ trans('admin/main.inactive') }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="javascript:;" data-dates="{{$dates_string}}"
                                           class="btn-transparent btn-sm text-primary edit-quest-btn" data-quest_id="{{$questObj->id}}" data-toggle="tooltip"
                                           data-placement="top" title="{{ trans('admin/main.edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $quests->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div id="edit-quest-modal-box" class="edit-quest-modal modal fade" role="dialog" data-backdrop="static">>
    <div class="modal-dialog">
        <div class="modal-content edit-quest-modal-div">
            <div class="modal-body ">
                <form name="edit-quest-modal" id="edit-quest-form">

                    <div class="form-group rurera-hide">
                        <div class="date-tags ">
                            <a href="javasc">26-03-024 <span class="icon-box">&#x2716;</span></a>
                            <a href="#">27-04-024 <span class="icon-box">&#x2716;</span></a>
                            <a href="#">25-03-024 <span class="icon-box">&#x2716;</span></a>
                            <a href="#">29-03-024 <span class="icon-box">&#x2716;</span></a>
                            <a href="#">22-02-024 <span class="icon-box">&#x2716;</span></a>
                            <a href="#">21-05-024 <span class="icon-box">&#x2716;</span></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="input-label">Quest Dates</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="input-group-text" data-input="logo" data-preview="holder">
                                    <i class="fa fa-calendar-week"></i>
                                </button>
                            </div>
                            <input type="hidden" class="quest-id-field">
                            <input type="text" autocomplete="off"
                                   name="s"
                                   value=""
                                   class="form-control practice-start-date  rureramultidatespicker rureradatepicker1 rurera-req-field" dataType="quest_date" min="{{date('Y-m-d')}}"
                                   placeholder=""/>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <a href="javascript:;" class="btn btn-primary edit-quest-submit-btn">Submit</a>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts_bottom')
<script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script src="/assets/default/js/admin/filters.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {




        $('body').on('click', '.edit-quest-btn', function (e) {
            var dates_string = $(this).attr('data-dates');
            var quest_id = $(this).attr('data-quest_id');
            $(".quest-id-field").val(quest_id);
            $(".practice-start-date").val(dates_string);
            

            var dates_array = dates_string.split(',');
            var date_tags = '';
            dates_array.forEach(function(date){
                date_tags += '<a href="javascript:;">'+date+' <span class="icon-box">&#x2716;</span><input type="hidden" class="edit-quest-dates" name="quest_dates[]" value="'+date+'"</a>';
            });

            $(".date-tags").html(date_tags);



            $(".edit-quest-modal").modal('show');
            $(".practice-start-date").focus();
            $('.rureramultidatespicker').datepicker({
                       multidate: true,
                       format: 'dd-mm-yyyy',
                       startDate: 'today',
                   });
        });

        $('body').on('click', '.date-tags a', function (e) {
            $(this).remove();
        });

        $('body').on('click', '.edit-quest-submit-btn', function (e) {

            rurera_loader($(".edit-quest-modal-div"), 'div');
            var quest_id = $('.quest-id-field').val();
            var questDates = [];
            $('input[name="quest_dates[]"]').each(function() {
                questDates.push($(this).val());
            });
            var dates_string = questDates.join(',');
            var dates_string = $(".practice-start-date").val();
            jQuery.ajax({
               type: "POST",
               url: '/admin/daily_quests/update_dates',
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: {'quest_id':quest_id, 'dates_string':dates_string},
               success: function (return_data) {
                   rurera_remove_loader($(".edit-quest-modal-div"), 'button');
                   $(".edit-quest-modal").modal('hide');
                   console.log(return_data);
               }
           });
        });
    });
</script>
@endpush
