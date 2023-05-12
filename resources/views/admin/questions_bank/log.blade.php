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
                        
                        @if( !empty( $questionLogs ))
                            @foreach($questionLogs as $logObj)
                            <div class="question-log-item">
                                <div class="action_by">
                                    {{$logObj->user->full_name}} at <b>{{ dateTimeFormat($logObj->action_at, 'j M y | H:i') }}</b>
                                </div>
                                <div class="action_type">
                                    {{$logObj->action_type}}
                                </div>
                                <div class="log_data">
                                    {!! $logObj->log_data !!}
                                </div>
                                
                                @if($logObj->action_type == 'Status Updated - Published' && $logObj->action_role == 'reviewer')
                                    @php
                                        $log_storred_data = json_decode($logObj->log_storred_data);
                                        $log_storred_data = (array) $log_storred_data;
                                        if(!empty($log_storred_data)){
                                            $log_storred_data['Solution'] = $log_storred_data['Solution'].' ('.$log_storred_data['Solution Label'].')';
                                            $log_storred_data['Difficulty Level'] = $log_storred_data['Difficulty Level'].' ('.$log_storred_data['Difficulty Level Label'].')';
                                            unset($log_storred_data['Solution Label']);
                                            unset($log_storred_data['Difficulty Level Label']);
                                            unset($log_storred_data['status_details']);
                                            $log_storred_data['Accepted'] = 20;
                                        }
                                        
                                    @endphp
                                    @if( !empty( $log_storred_data ))
                                        @foreach( $log_storred_data as $storred_dataObj_key => $storred_dataObj_value)
                                        <span>{{$storred_dataObj_key}}: {{$storred_dataObj_value}}</span><br>
                                        @endforeach
                                    @endif
                                    
                                @endif
                                
                            </div><hr><br>
                            @endforeach
                        @endif

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
