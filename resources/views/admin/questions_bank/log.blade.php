@extends('admin.layouts.app')

@push('styles_top')


@endpush

@section('content')

<section class="section form-class" data-question_save_type="update_question">
    <div class="section-header">
        <h1>{{ $pageTitle }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">{{ $pageTitle }}</div>
        </div>

    </div>

    <div class="section-body lms-quiz-create">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-30">
                            <div class="lms-dashboard-card">
                                <div class="lms-card-body">
                                    <div class="lms-card-title">
                                        <h4 style="text-transform: capitalize;">Activity</h4>
                                    </div>
                                    <ul class="lms-card-timeline">

                                        @if( !empty( $questionLogs ))
                                        @foreach($questionLogs as $logObj)


                                        <li class="lms-card-list active">
                                            <div class="lms-card-icons"><i data-feather="arrow-right-circle" width="20"
                                                                           height="20"
                                                                           class=""></i></div>
                                            <div class="lms-card-info">
                                                <h5>{{$logObj->user->full_name}} @ <b>{{ dateTimeFormat
                                                        ($logObj->action_at, 'j M y | H:i')
                                                        }} <span><i data-feather="arrow-right" width="20" height="20"
                                                                    class=""></i></span>
                                                </h5>
                                                <p>{{$logObj->action_type}}</p>
                                                <p>{!! $logObj->log_data !!}</p>
                                                @if($logObj->action_type == 'Status Updated - Published' &&
                                                $logObj->action_role ==
                                                'reviewer')
                                                @php
                                                $log_storred_data = json_decode($logObj->log_storred_data);
                                                $log_storred_data = (array) $log_storred_data;
                                                if(!empty($log_storred_data)){
                                                $log_storred_data['Solution'] = $log_storred_data['Solution'].'
                                                ('.$log_storred_data['Solution Label'].')';
                                                $log_storred_data['Difficulty Level'] = $log_storred_data['Difficulty
                                                Level'].'
                                                ('.$log_storred_data['Difficulty Level Label'].')';
                                                unset($log_storred_data['Solution Label']);
                                                unset($log_storred_data['Difficulty Level Label']);
                                                unset($log_storred_data['status_details']);
                                                $log_storred_data['Accepted'] = 20;
                                                }

                                                @endphp
                                                @if( !empty( $log_storred_data ))
                                                @foreach( $log_storred_data as $storred_dataObj_key =>
                                                $storred_dataObj_value)
                                                <span>{{$storred_dataObj_key}}: {{$storred_dataObj_value}}</span><br>
                                                @endforeach
                                                @endif

                                                @endif
                                            </div>
                                        </li>

                                        @endforeach
                                        @endif
                                    </ul>
                                    <div class="text-center mt-4"><a class="lms-card-btn" href="#">View More <i
                                                data-feather="arrow-right"
                                                width="20" height="20" class=""></i></a></div>
                                </div>
                            </div>
                        </div>

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

<script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace()
</script>

@endpush
