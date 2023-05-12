@extends('admin.layouts.app')

@push('libraries_top')

@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>{{$pageTitle}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/admin/">{{trans('admin/main.dashboard')}}</a>
            </div>
            <div class="breadcrumb-item">{{$pageTitle}}</div>
        </div>
    </div>


    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped font-14">
                                <tr>
                                    <th class="text-left">Question Title</th>
                                    <th class="text-left">Total Points</th>
                                    <th class="text-left">Points Breakdown</th>
                                    
                                    
                                    
                                </tr>

                                @foreach($author_points as $author_pointsObj)
                                <tr>
                                    <td>
                                        <span>{{ $author_pointsObj->questions->question_title }}</span>
                                    </td>
                                    <td class="text-left">{{ $author_pointsObj->points }}</td>
                                    @php
                                        $points_details = json_decode($author_pointsObj->points_details);
                                        $points_details = (array) $points_details;
                                        if( !empty( $points_details )) {
                                            unset( $points_details['Solution Label']);
                                            unset( $points_details['Difficulty Level Label']);
                                            unset( $points_details['status_details']);
                                        }
                                    @endphp
                                    <td class="text-left">
                                        <br>
                                        @foreach($points_details as $point_title => $point_value)
                                            <span>{{$point_title}} : {{ $point_value }}<br></span>
                                        @endforeach
                                        <br>
                                    </td>

                                </tr>
                                @endforeach

                            </table>
                        </div>
                        {{ $author_points->links() }}
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts_bottom')

@endpush
