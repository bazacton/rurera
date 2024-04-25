@extends('admin.layouts.app')
@php use App\Http\Controllers\Web\QuestionsAttemptController;
$QuestionsAttemptController = new QuestionsAttemptController();
@endphp

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

    a.progrss-bar {
        width: 50px !important;
        background: #fff;
        border: 1px solid #000;
        height: 20px;
        display: inline-flex;
    }
    span.progrss-bar-span {
        background: green;
    }
</style>
@endpush


@section('content')

<section class="section">
    <div class="section-header">
        <h1>Assignment Progress</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{ trans('admin/main.dashboard') }}</a>
            </div>
            <div class="breadcrumb-item active"><a href="/admin/assignments">Assignment</a>
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped font-14">
                                    <tr>
                                        <th class="text-center">Student</th>
                                        <th class="text-center">Attempts</th>
                                        <th class="text-center">Last Activity</th>
                                    </tr>

                                    @if( $assignmentObj->students->count() > 0)
                                        @foreach( $assignmentObj->students as $assignmentTopicObj)
                                            <tr>
                                                <td>
                                                    <span>{{$assignmentTopicObj->user->get_full_name()}}</span>
                                                </td>
                                                <td>
                                                    @php $attempt_counter = 1; $counter = 1; @endphp
                                                    @foreach( $assignmentTopicObj->AssignmentResults as $resultObj)

                                                        @php
                                                        $parent_type = isset( $resultObj->quiz_result_type )? $resultObj->quiz_result_type : '';

                                                        $detail_link = '';
                                                        if( $parent_type == 'practice' || $parent_type == 'sats' || $parent_type == '11plus' || $parent_type == 'assessment' || $parent_type == 'book_page' || $parent_type == 'vocabulary' || $parent_type == 'assignment'){
                                                            $detail_link = '/panel/quizzes/'.$resultObj->id.'/check_answers';
                                                        }
                                                        if( $parent_type == 'timestables' || $parent_type == 'timestables_assignment'){
                                                            $detail_link = '/panel/results/'.$resultObj->id.'/timetables';
                                                        }
                                                        @endphp

                                                       <a href="{{$detail_link}}" class="progrss-bar"><span class="progrss-bar-span" style="width:{{$QuestionsAttemptController->get_percetange_corrct_answer($resultObj)}}%"></span></a>
                                                       @php $attempt_counter++; @endphp

                                                    @endforeach
                                                    @while($counter <= ($assignmentObj->no_of_attempts - $assignmentTopicObj->AssignmentResults->count()))
                                                        <a href="javascript:;" class="progrss-bar"><span class="progrss-bar-span" style="width:0%"></span></a>
                                                    @php $counter++; @endphp
                                                    @endwhile
                                                </td>

                                                <td>
                                                    @if( $assignmentTopicObj->updated_at != '')
                                                        <span>{{ dateTimeFormat($assignmentTopicObj->updated_at, 'j M y') }}</span>
                                                    @endif
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

