@extends('admin.layouts.app')

@push('styles_top')
<link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="/assets/default/css/quiz-layout.css">
<link rel="stylesheet" href="/assets/default/css/quiz-frontend.css">
<link rel="stylesheet" href="/assets/default/css/quiz-create-frontend.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    .year-group-select, .subject-group-select, .subchapter-group-select li {
        cursor: pointer;
    }


    .questions-list li {
        background: #efefef;
        margin-bottom: 10px;
        padding: 5px 10px;
    }

    .questions-list li a.parent-li-remove {
        float: right;
        margin: 8px 0 0 0;
        color: #ff0000;
    }

    .question-area {
        border-bottom: 2px solid #efefef;
        margin-bottom: 30px;
    }


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
<style>
    /*!
     * Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
     *
     * Copyright 2012 Stefan Petre
     * Improvements by Andrew Rowls
     * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
     */
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
        <h1>{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new') }} Quest</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/assignments">Quest</a>
            </div>
            <div class="breadcrumb-item">{{!empty($assignment) ?trans('/admin/main.edit'): trans('admin/main.new')
                }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="/admin/daily_quests/{{ !empty($assignment) ? $assignment->id.'/update' : 'store' }}"
                                  method="Post" class="rurera-form-validation">
                                {{ csrf_field() }}

                                <div class="row col-lg-12 col-md-12 col-sm-4 col-12">
                                    <div class="populated-content-area col-lg-12 col-md-12 col-sm-12 col-12">


                                        @if( !empty($categories ))

                                        <div class="years-group populated-data">
                                            <div class="form-group">
                                                <label class="input-label">Quest Type</label>
                                                <div class="input-group">

                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="practice" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                 <img src="/assets/default/img/assignment-logo/practice.png">
                                                                    <h3>Learn</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="sats">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/sats.png">
                                                                    <h3>SATs</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="11plus">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/11plus.png">
                                                                    <h3>11 Plus</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="independent_exams">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/independent-exams.png">
                                                                    <h3>Independent Exams</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="iseb">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/iseb.png">
                                                                    <h3>ISEB</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="cat4">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/cat4.png">
                                                                    <h3>CAT 4</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="vocabulary">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/vocabulary.png">
                                                                    <h3>Vocabulary</h3>
                                                               </div>

                                                              </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="timestables">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/timestables.png">
                                                                    <h3>Timestables</h3>
                                                               </div>

                                                              </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="books">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <img src="/assets/default/img/assignment-logo/practice.png">
                                                                    <h3>Books</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_topic_type]"
                                                                   class="quest_topic_type_check" value="learning_journey">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                 <img src="/assets/default/img/assignment-logo/practice.png">
                                                                    <h3>Learning Journey</h3>
                                                               </div>
                                                          </span>
                                                        </label>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="form-section quest_topic_type_fields timestables_fields">
                                                <h2 class="section-title">Times Tables</h2>

                                                <div class="form-group">
                                                    <label class="input-label">Timestables Method</label>
                                                    <div class="input-group">

                                                        <div class="radio-buttons">
                                                            <label class="card-radio">
                                                                <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][timestables_mode]"
                                                                       class="timestables_mode_check" value="freedom_mode" checked>
                                                                <span class="radio-btn"><i class="las la-check"></i>
                                                                    <div class="card-icon">
                                                                     <img src="/assets/default/svgs/eagle.svg">
                                                                        <h3>Freedom mode</h3>
                                                                   </div>
                                                              </span>
                                                            </label>

                                                            <label class="card-radio">
                                                                <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][timestables_mode]"
                                                                       class="timestables_mode_check" value="powerup_mode" checked>
                                                                <span class="radio-btn"><i class="las la-check"></i>
                                                                    <div class="card-icon">
                                                                        <img src="/assets/default/svgs/battery-level.svg">
                                                                        <h3>Power-Up</h3>
                                                                   </div>
                                                              </span>
                                                            </label>

                                                            <label class="card-radio">
                                                                <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][timestables_mode]"
                                                                       class="timestables_mode_check" value="trophy_mode" checked>
                                                                <span class="radio-btn"><i class="las la-check"></i>
                                                                    <div class="card-icon">
                                                                        <img src="/assets/default/svgs/shuttlecock.svg">
                                                                        <h3>Trophy Mode</h3>
                                                                   </div>
                                                              </span>
                                                            </label>

                                                            <label class="card-radio">
                                                                <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][timestables_mode]"
                                                                       class="timestables_mode_check" value="treasure_mission" checked>
                                                                <span class="radio-btn"><i class="las la-check"></i>
                                                                    <div class="card-icon">
                                                                        <img src="/assets/default/img/treasure.png">
                                                                        <h3>Treasure Mission</h3>
                                                                   </div>
                                                              </span>
                                                            </label>

                                                            <label class="card-radio">
                                                                <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][timestables_mode]"
                                                                       class="timestables_mode_check" value="showdown_mode" checked>
                                                                <span class="radio-btn"><i class="las la-check"></i>
                                                                    <div class="card-icon">
                                                                        <img src="/assets/default/img/showdown.png">
                                                                        <h3>Showdown</h3>
                                                                   </div>
                                                              </span>
                                                            </label>

                                                        </div>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group quest_topic_type_fields timestables_fields">

                                            </div>

                                            <div class="form-section">
                                                <h2 class="section-title">General information</h2>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Quest Title</label>
                                                <input type="text"
                                                       name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][title]"
                                                       value="{{ !empty($assignment) ? $assignment->title : old('title') }}"
                                                       class="js-ajax-title form-control rurera-req-field"
                                                       placeholder=""/>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Quest Description</label>
                                                <textarea
                                                        name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][description]"
                                                        class="form-control summernote-editor-mintool"
                                                        placeholder="" rows="20"></textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>


                                            <div class="form-group">
                                                <label class="input-label">Quest Icon</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text admin-file-manager" data-input="quest_icon" data-preview="holder">
                                                            <i class="fa fa-upload"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="quest_icon" id="quest_icon" value="{{ !empty($assignment) ? $assignment->quest_icon : old('quest_icon') }}" class="form-control @error('quest_icon')  is-invalid @enderror"/>
                                                    <div class="input-group-append">
                                                        <button type="button" class="input-group-text admin-file-view" data-input="quest_icon">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('quest_icon')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-section">
                                                <h2 class="section-title">Schedule</h2>
                                            </div>
											
											<div class="form-group">
                                                <label class="input-label">Date Type</label>
                                                <div class="input-group">


                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][date_type]"
                                                                   class="date_type_change" value="daily" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Daily</h3>
                                                               </div>

                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][date_type]"
                                                                   class="date_type_change" value="weekly">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Weekly</h3>
                                                               </div>

                                                          </span>
                                                        </label>
                                                    </div>

                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-4">
                                                    <div class="form-group dates_daily_fields">
                                                        <label class="input-label">Quest Dates</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button type="button" class="input-group-text" data-input="logo" data-preview="holder">
                                                                    <i class="fa fa-calendar-week"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" autocomplete="off"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_dates]"
                                                                   value="{{ !empty($assignment) ? dateTimeFormat($assignment->quest_dates, 'Y-m-d', false) : old('quest_dates') }}"
                                                                   class="form-control practice-start-date rureramultidatespicker rurera-req-field @error('quest_dates') is-invalid @enderror"
                                                                   min="{{date('Y-m-d')}}"
                                                                   placeholder=""/>
                                                            @error('quest_dates')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
													
											<div class="form-group dates_weekly_fields rurera-hide">
                                                <label class="input-label">Weeks</label>
                                                <div class="input-group">
                                                    <select name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][weeks_dates][]" class="form-control select2 class_condition" multiple>
														@foreach( $weeks_array as $week_key => $week_value)
															<option value="{{$week_key}}">{{$week_value}}</option>
														@endforeach
                                                    </select>
                                                </div>
                                            </div>
													
                                                </div>

                                            </div>
											
											

                                            <div class="form-group">
                                                <label class="input-label">Quest Method</label>
                                                <div class="input-group">

                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_method]"
                                                                   class="quest_method_check" value="correct_answers" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                            <h3>Correct answers</h3>
                                                                       </div>

                                                                  </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_method]"
                                                                   class="quest_method_check" value="correct_answers_in_row" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                            <h3>Correct Answers in Row</h3>
                                                                       </div>

                                                                  </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_method]"
                                                                   class="quest_method_check" value="lessons_score" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                            <h3>Lessons / Practices Score</h3>
                                                                       </div>
                                                                  </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_method]"
                                                                   class="quest_method_check" value="screen_time" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                        <div class="card-icon">
                                                                            <h3>Screen Time</h3>
                                                                       </div>
                                                                  </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6 quest_method_check_fields correct_answers_fields correct_answers_in_row_fields">
                                                    <div class="form-group">
                                                        <label class="input-label">No of Correct Answers</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][no_of_answers]"
                                                                   value="0" data-label=""
                                                                   class="js-ajax-title form-control correct_answers_percentage range-slider-field" min="0" step="1"  max="100"
                                                                   placeholder=""/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6 quest_method_check_fields correct_answers_in_row_fields lessons_score_fields">
                                                    <div class="form-group">
                                                        <label class="input-label">No of Lessons / Practices</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][no_of_practices]"
                                                                   value="0" data-label=""
                                                                   class="js-ajax-title form-control correct_answers_percentage range-slider-field" min="1" max="20"
                                                                   placeholder=""/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6 quest_method_check_fields lessons_score_fields">
                                                    <div class="form-group">
                                                        <label class="input-label">Lessons / Practices Score</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][lessons_score]"
                                                                   value="0" data-label="%"
                                                                   class="js-ajax-title form-control correct_answers_percentage range-slider-field" min="0" max="100"
                                                                   placeholder=""/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6 quest_method_check_fields screen_time_fields">
                                                    <div class="form-group">
                                                        <label class="input-label">Screen Time (Minutes)</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][screen_time]"
                                                                   value="0" data-label=""
                                                                   class="js-ajax-title form-control correct_answers_percentage range-slider-field" min="1" max="5000"
                                                                   placeholder=""/>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Coins Type</label>
                                                <div class="input-group">


                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][coins_type]"
                                                                   class="coins_type_check" value="custom" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Custom</h3>
                                                               </div>

                                                          </span>
                                                        </label>
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][coins_type]"
                                                                   class="coins_type_check" value="percentage">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>%</h3>
                                                               </div>

                                                          </span>
                                                        </label>
                                                    </div>

                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6 coins_type_check_fields custom_fields">
                                                    <div class="form-group">
                                                        <label class="input-label">No of Coins</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][no_of_coins]"
                                                                   value="0" data-label=""
                                                                   class="js-ajax-title form-control correct_answers_percentage range-slider-field" min="0" step="1"  max="100"
                                                                   placeholder=""/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-6 coins_type_check_fields percentage_fields">
                                                    <div class="form-group">
                                                        <label class="input-label">Coins Percentage</label>

                                                        <div class="invalid-feedback"></div>
                                                        <div class="range-slider">
                                                            <div id="slider_thumb" class="range-slider_thumb" style="left: 0px;">0</div>
                                                            <div class="range-slider_line">
                                                                <div id="slider_line" class="range-slider_line-fill" style="width: 0%;"></div>
                                                            </div>
                                                            <input type="range"
                                                                   name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][coins_percentage]"
                                                                   value="0" data-label="%"
                                                                   class="js-ajax-title form-control correct_answers_percentage range-slider-field" min="0" step="100" max="500"
                                                                   placeholder=""/>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-section">
                                                <h2 class="section-title">User Criteria</h2>
                                            </div>

                                            <div class="form-group">
                                                <label class="input-label">Assignment Assign Type</label>
                                                <div class="input-group">


                                                    <div class="radio-buttons">
                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_assign_type]"
                                                                   class="duration_conditional_check" value="All">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>All</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_assign_type]"
                                                                   class="duration_conditional_check" value="Class" checked>
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Class</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                        <label class="card-radio">
                                                            <input type="radio" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][quest_assign_type]"
                                                                   class="duration_conditional_check" value="Individual">
                                                            <span class="radio-btn"><i class="las la-check"></i>
                                                                <div class="card-icon">
                                                                    <h3>Individual</h3>
                                                               </div>

                                                          </span>
                                                        </label>

                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="form-group duration_conditional_fields">
                                                <label class="input-label">Class</label>
                                                <div class="input-group">
                                                    <select name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_type]" class="form-control select2 class_condition">
                                                        <option value="">Select</option>
                                                        @if( !empty( $classes) )
                                                        @foreach( $classes as $classObj)
                                                        <option value="{{$classObj->id}}" @if(!empty($assignment) && $assignment->assignment_type == 'Individual') selected @endif>
                                                            {{$classObj->title}}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>


                                            <ul class="col-10 col-md-10 col-lg-10 admin-rurera-tabs nav nav-pills" id="assignment_tabs" role="tablist">
                                                @if( !empty( $sections) )
                                                @foreach( $sections as $sectionObj)
                                                <li class="nav-item conditional_sections rurera-hide class_sections_{{$sectionObj->parent_id}}" data-section_id="{{$sectionObj->id}}">
                                                    <a class="nav-link" id="section-tabid-{{$sectionObj->id}}" data-toggle="tab" href="#section-tab-{{$sectionObj->id}}" role="tab"
                                                       aria-controls="section-tab-{{$sectionObj->id}}" aria-selected="true"><span class="tab-title">{{$sectionObj->title}}</span></a>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                            <input type="hidden" name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][section_id]" class="section_id">

                                            <div class="tab-content users-section" id="myTabContent2">
                                                @if( !empty( $sections) )
                                                @foreach( $sections as $sectionObj)
                                                <div class="tab-pane mt-3 fade" id="section-tab-{{$sectionObj->id}}" role="tabpanel" aria-labelledby="section-tab-{{$sectionObj->id}}-tab">
                                                    @if( !empty( $sectionObj->users) )
                                                    <div class="users_list_block">
                                                        <span><input type="checkbox" class="select_all" id="select_all_{{$sectionObj->id}}" value="{{$sectionObj->id}}"
                                                                     name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][class_ids][]"><label for="select_all_{{$sectionObj->id}}">Select All</label></span>
                                                        <ul class="users-list">
                                                            @foreach( $sectionObj->users as $userObj)
                                                            <li data-user_id="{{$userObj->id}}">
                                                                <span><input type="checkbox" id="select_user{{$userObj->id}}" value="{{$userObj->id}}"
                                                                             name="ajax[{{ !empty($assignment) ? $assignment->id : 'new' }}][assignment_users][]"><label
                                                                            for="select_user{{$userObj->id}}">{{$userObj->get_full_name()}}</label></span>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                                @endif

                                            </div>

                                        </div>
                                        @endif

                                    </div>


                                </div>

                                <div class="mt-20 mb-20">
                                    <button type="submit"
                                            class="js-submit-quiz-form btn btn-sm btn-primary">{{
                                        !empty($assignment) ?
                                        trans('public.save_change') : trans('public.create') }}
                                    </button>

                                    @if(empty($assignment) and !empty($inWebinarPage))
                                    <button type="button"
                                            class="btn btn-sm btn-danger ml-10 cancel-accordion">{{
                                        trans('public.close') }}
                                    </button>
                                    @endif
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script src="/assets/default/js/admin/filters.min.js"></script>
<script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        $('.rureramultidatespicker').datepicker({
           multidate: true,
           format: 'dd-mm-yyyy',
           startDate: 'today',
       });
        if ($('.summernote-editor-mintool').length) {

            $('.summernote-editor-mintool').summernote({
                toolbar: [
                    ['font', ['bold', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                callbacks: {
                    onChange: function (contents, $editable) {
                        $('.summernote-editor_' + parent_field_id).val(EditorValueEnocde(contents));
                        trigger_field_change($('.summernote-editor_' + parent_field_id));
                    }
                }
            });
        }


        $('body').on('change', '.select_all', function (e) {
            if ($(this).is(':checked')) {
                $(this).closest('.users_list_block').find('.users-list').find('input').prop('checked', true);
                console.log('checked');
            } else {
                $(this).closest('.users_list_block').find('.users-list').find('input').prop('checked', false);
                console.log('unchecked');
            }
            ;
        });

        $('body').on('click', '.year-group-select', function (e) {
            var thisObj = $('.populated-content-area');
            var year_id = $(this).attr('data-year_id');
            $(".year_id_field").val(year_id);
            rurera_loader(thisObj, 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/custom_quiz/subjects_by_year',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"year_id": year_id},
                success: function (return_data) {
                    $(".populated-data").addClass('rurera-hide');
                    rurera_remove_loader(thisObj, 'button');
                    if (return_data != '') {
                        $(".populated-content-area").append(return_data);
                        subjects_callback();
                    }
                }
            });
        });

        var subjects_callback_bk = function () {
            $('body').on('click', '.subject-group-selects', function (e) {
                var thisObj = $('.populated-content-area');
                var subject_id = $(this).attr('data-subject_id');
                $(".subject_id_field").val(subject_id);
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/topics_subtopics_by_subject',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subject_id": subject_id},
                    success: function (return_data) {
                        $(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        if (return_data != '') {
                            //$(".populated-content-area").append(return_data);
                            $(".topics-subtopics-content-area").append(return_data);
                            questions_callback();
                        }
                    }
                });
            });
        }

        var subjects_callback = function () {
            $('body').on('change', '.subject_ajax_select', function (e) {
                var thisObj = $('.populated-content-area');
                var subject_id = $(this).val();
                $(".subject_id_field").val(subject_id);
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/topics_subtopics_by_subject',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subject_id": subject_id},
                    success: function (return_data) {
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        if (return_data != '') {
                            //$(".populated-content-area").append(return_data);
                            $(".topics-subtopics-content-area").append(return_data);
                            $("#questions-tab").click();
                            questions_callback();
                        }
                    }
                });
            });
        }
        subjects_callback();


        var questions_callback = function () {
            $('body').on('click', '.subchapter-group-select li', function (e) {
                var thisObj = $('.populated-content-area');
                var subchapter_id = $(this).attr('data-subchapter_id');
                rurera_loader(thisObj, 'div');
                jQuery.ajax({
                    type: "GET",
                    url: '/admin/custom_quiz/questions_by_subchapter',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"subchapter_id": subchapter_id},
                    success: function (return_data) {
                        //$(".populated-data").addClass('rurera-hide');
                        rurera_remove_loader(thisObj, 'button');
                        //$(".questions-populate-area").html(return_data);
                        $(".selected-questions-group").append(return_data);
                        questions_select_callback();

                    }
                });
            });
        }

        var questions_select_callback = function () {
            $('body').on('click', '.questions-group-select li', function (e) {
                var thisObj = $('.populated-content-area');
                var question_id = $(this).attr('data-question_id');
                var question_title = $(this).find('a').html();
                $('.questions-list li[data-question_id="' + question_id + '"]').remove();
                $(".questions-list").append('<li data-question_id="' + question_id + '"><input type="hidden" name="ajax[new][question_list_ids][]" value="' + question_id + '">' + question_title + '<a href="javascript:;" class="parent-li-remove"><span class="fas fa-trash"></span></a></li>');
            });


        }

        var currentRequest = null;
        var question_search = function () {
            $('body').on('keyup', '.search-questions', function (e) {
                var input, filter, ul, li, a, i, txtValue;
                var search_question_bank = $('.search_question_bank').is(":checked");
                if (search_question_bank == false) {
                    input = document.getElementById("search-questions");
                    filter = input.value.toUpperCase();
                    ul = document.getElementById("questions-group-select");
                    li = ul.getElementsByTagName("li");
                    for (i = 0; i < li.length; i++) {
                        a = li[i].getElementsByTagName("a")[0];
                        txtValue = a.textContent || a.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1 || li[i].className.indexOf("alwaysshow") > -1) {
                            li[i].style.display = "";
                        } else {
                            li[i].style.display = "none";
                        }
                    }
                } else {
                    var input = $(this).val();
                    var thisObj = $('.questions-populate-area');
                    var year_id = $(".year_id_field").val();
                    var subject_id = $(".subject_id_field").val();
                    rurera_loader(thisObj, 'div');

                    currentRequest = jQuery.ajax({
                        type: "GET",
                        url: '/admin/custom_quiz/questions_by_keyword',
                        beforeSend: function () {
                            if (currentRequest != null) {
                                currentRequest.abort();
                            }
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"keyword": input, "year_id": year_id, "subject_id": subject_id},
                        success: function (return_data) {
                            rurera_remove_loader(thisObj, 'button');
                            $(".questions-group-select").html(return_data);
                        }
                    });
                }
            });
        }

        question_search();


        $(".questions-list").sortable();


        $('body').on('click', '.rurera-back-btn', function (e) {
            $(this).closest('.populated-data').prev('.populated-data').removeClass('rurera-hide');
            $(this).closest('.populated-data').addClass('rurera-hide');
            $(this).closest('.populated-data').remove();
            if ($(this).hasClass('questions-list-btn')) {
                console.log('questions-btn');
            }
        });

        $('body').on('change', '.conditional_check', function (e) {
            var current_value = $(this).val();
            $(".conditional_fields").addClass('rurera-hide');
            $('.' + current_value + '_field').removeClass('rurera-hide');
        });

        $('body').on('change', '.class_condition', function (e) {
            var current_value = $(this).val();
            $(".conditional_sections").addClass('rurera-hide');
            $(".users-section").addClass('rurera-hide');
            var duration_conditional_check = $(".duration_conditional_check:checked").val();
            if( duration_conditional_check == 'Individual' || duration_conditional_check == 'Class') {
                $('.class_sections_' + current_value).removeClass('rurera-hide');
            }
            if( duration_conditional_check == 'Individual') {
                $(".users-section").removeClass('rurera-hide');
            }

        });
        $('body').on('click', '.conditional_sections', function (e) {
            var current_value = $(this).attr('data-section_id');
            $(".section_id").val(current_value);
        });


        $('body').on('change', '.duration_conditional_check', function (e) {
            var current_value = $(this).val();
            $(".duration_conditional_fields").removeClass('rurera-hide');
            $(".users-section").removeClass('rurera-hide');
            var section_value = $(".conditional_sections:checked").val();
            $('.class_sections_' + section_value).removeClass('rurera-hide');
            if( current_value == 'All'){
                $(".duration_conditional_fields").addClass('rurera-hide');
                $(".users-section").addClass('rurera-hide');
                $(".conditional_sections").addClass('rurera-hide');
            }
            $(".duration_type_fields").addClass('rurera-hide');
            if( current_value != 'Individual') {
                $(".users-section").addClass('rurera-hide');
            }
            $('.' + current_value + '_fields').removeClass('rurera-hide');
        });

        $('body').on('change', '.quest_topic_type_check', function (e) {
            var current_value = $(this).val();
            $(".quest_topic_type_fields").addClass('rurera-hide');
            $('.' + current_value + '_fields').removeClass('rurera-hide');
            var total_questions = 0;
            var current_questions = 0;
            if (current_value == 'timestables') {
                total_questions = 200;
            }
            if( current_value == '11plus' || current_value == 'independent_exams' || current_value == 'iseb' || current_value == 'cat4'){
                total_questions = 50;
                current_questions = 50;
            }

            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            $(".no_of_questions").val(current_questions);
            slider_fields_refresh();
        });

        $('body').on('change', '.quest_method_check', function (e) {
            var current_value = $(this).val();
            $(".quest_method_check_fields").addClass('rurera-hide');
            $('.quest_method_check_fields.' + current_value + '_fields').removeClass('rurera-hide');
        });

        $('body').on('change', '.coins_type_check', function (e) {
            var current_value = $(this).val();
            $(".coins_type_check_fields").addClass('rurera-hide');
            $('.coins_type_check_fields.' + current_value + '_fields').removeClass('rurera-hide');
        });




        $('body').on('change', '.year_quiz_ajax_select', function (e) {
            var year_id = $(this).val();
            var quiz_type = $(".quest_topic_type_check:checked").val();
            var thisObj = $(this);//$(".quiz-ajax-fields");
            $(".yeargroup-ajax-fields").html('');
            rurera_loader(thisObj, 'button');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/types_quiz_by_year',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"quiz_type": quiz_type, "year_id": year_id},
                success: function (return_data) {
                    if (quiz_type == 'practice') {
                        $(".practice-quiz-ajax-fields").html(return_data);
                    } else {
                        $(".quiz-ajax-fields").html(return_data);
                    }
                    rurera_remove_loader(thisObj, 'button');
                }
            });
        });

        $('body').on('change', '.year_group_quiz_ajax_select', function (e) {
            var year_group = $(this).val();
            var quiz_type = $(".quest_topic_type_check:checked").val();
            var thisObj = $(this);//$(".yeargroup-ajax-fields");
            $(".practice-quiz-ajax-fields").html('');
            $(".quiz-ajax-fields").html('');
            rurera_loader(thisObj, 'button');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/types_quiz_by_year_group',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"quiz_type": quiz_type, "year_group": year_group},
                success: function (return_data) {
                    $(".yeargroup-ajax-fields").html(return_data);
                    rurera_remove_loader(thisObj, 'button');
                }
            });
        });

        $('body').on('change', '.assignment_subject_check', function (e) {
            var subject_id = $(this).val();
            var thisObj = $(this);
            rurera_loader($(".practice-quiz-topics-list"), 'div');
            jQuery.ajax({
                type: "GET",
                url: '/admin/common/topics_subtopics_by_subject',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {"subject_id": subject_id},
                success: function (return_data) {
                    rurera_remove_loader($(".practice-quiz-topics-list"), 'button');
                    $(".practice-quiz-topics-list").html(return_data);
                }
            });
        });

        var slider_fields_refresh = function () {
            $('.range-slider-field').each(function () {
                var thisObj = $(this);
                //var sliderStructure = $('<div class="range-slider"><div id="slider_thumb" class="range-slider_thumb" style="left: 425.5px;">0</div><div class="range-slider_line"><div id="slider_line" class="range-slider_line-fill" style="width: 46%;"></div></div>'+thisObj.clone().wrap('<div>').parent().html() +'</div>');
                //thisObj.replaceWith(sliderStructure);
                var sliderInput = thisObj;
                var sliderThumb = thisObj.closest('.range-slider').find('.range-slider_thumb');
                var sliderLine = thisObj.closest('.range-slider').find('.range-slider_line-fill');
                showSliderValue(sliderInput, sliderThumb, sliderLine);
                $(window).on("resize", function () {
                    showSliderValue(sliderInput, sliderThumb, sliderLine);
                });
                sliderInput.on('input', function () {
                    showSliderValue(sliderInput, sliderThumb, sliderLine);
                });
            });
        }
        slider_fields_refresh();


        function showSliderValue(sliderInput, sliderThumb, sliderLine) {
            var label_value = sliderInput.attr('data-label');
            label_value = (label_value != undefined && label_value != 'undefined') ? label_value : '';
            sliderThumb.html(sliderInput.val() + label_value);
            var max_value = sliderInput.attr('max');
            var current_percentage = (sliderInput.val() * 100 / max_value);
            var bulletPosition = sliderInput.val() / sliderInput.attr('max');
            var space = sliderInput.width() - sliderThumb.width();
            space = parseInt(space) + parseInt(20);
            var text_to_display = sliderInput.val();
            if (sliderInput.hasClass('time_interval')) {
                $(".time_interval_data").html(sliderInput.val() + ' Seconds, ' + formatTime(sliderInput.val(), 'm', 's'));
            }
            if (sliderInput.hasClass('practice_interval')) {
                $(".practice_interval_data").html(sliderInput.val() + ' Minutes, ' + formatTime(sliderInput.val(), 'h', 'm'));
            }

            sliderThumb.css('left', (bulletPosition * space) + 'px');
            sliderLine.css('width', current_percentage + '%');
        }

        function formatTime(seconds, label_1, label_2) {
            var minutes = Math.floor(seconds / 60);
            var remainingSeconds = seconds % 60;

            var formattedTime = "";

            if (minutes > 0) {
                formattedTime += minutes + label_1 + " ";
            }

            formattedTime += remainingSeconds + label_2;

            return formattedTime;
        }
		
		
		$('body').on('change', '.date_type_change', function (e) {
			var current_value = $(this).val();
			$(".dates_daily_fields").addClass('rurera-hide');
			$(".dates_weekly_fields").addClass('rurera-hide');
			$('.dates_'+current_value+'_fields').removeClass('rurera-hide');
		});

        $('body').on('change', '.topic_selection', function (e) {
            var current_value = $(this).val();
            var total_questions = $(this).find('option[value="' + current_value + '"]').attr('data-total_questions');
            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            //$( ".no_of_questions" ).val( $( "#slider-range-max" ).slider( "value" ) );
            $(".no_of_questions").val(0);
        });

        $('body').on('change', '.topics_multi_selection', function (e) {

            var total_questions = 0;
            $('.topics_multi_selection:checked').each(function () {
                total_questions = parseInt(total_questions) + parseInt($(this).attr('data-total_questions'));
            });

            $(".max_questions").html('Max: ' + total_questions);
            $(".no_of_questions").attr('max', total_questions);
            //$( ".no_of_questions" ).val( $( "#slider-range-max" ).slider( "value" ) );
            $(".no_of_questions").val(0);
        });


        $(".conditional_check").change();
        $(".duration_conditional_check:checked").change();
        $(".quest_topic_type_check:checked").change();
        $(".quest_method_check:checked").change();
        $(".coins_type_check:checked").change();
        $(".year_quiz_ajax_select").change();
        $(".year_group_quiz_ajax_select").change();


        $('body').on('change', '.topic-section-parent', function (e) {
            let $this = $(this);
            let parent = $this.parent().closest('.section-box');
            let isChecked = e.target.checked;

            if (isChecked) {
                parent.find('input[type="checkbox"].section-child').prop('checked', true);
            } else {
                parent.find('input[type="checkbox"].section-child').prop('checked', false);
            }

            $(".topics_multi_selection").change();
        });

        $('body').on('apply.daterangepicker', '.practice-start-date', function (ev, picker) {
            $(".practice-due-date").attr('min', picker.startDate.format('YYYY-MM-DD'));
            $(".reviewer-date").attr('min', picker.startDate.format('YYYY-MM-DD'));
            resetRureraDatePickers();
        });

        $('body').on('apply.daterangepicker', '.practice-due-date', function (ev, picker) {
            $(".reviewer-date").attr('min', picker.startDate.format('YYYY-MM-DD'));
            resetRureraDatePickers();
        });

    });

</script>
@endpush
