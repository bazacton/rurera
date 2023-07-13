@extends(getTemplate().'.layouts.app')

@push('styles_top')

@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-10 mx-auto">
            <div class="heatmap-table-holder mb-20">

                <table class="heatmap-table">
                    <thead>
                    <tr>
                        <th></th>
                        @php $count = 2; @endphp
                        @while($count <= 12)
                        <th>{{$count}}</th>
                        @php $count++; @endphp
                        @endwhile
                    </tr>
                    </thead>


                    @if( !empty( $times_tables_data ) )
                        @foreach( $times_tables_data as $tableData)
                            <tbody>
                            @php $count = 2; @endphp
                            @while($count <= 12)
                                @php $table_count = 2;
                                    $from_table_array = isset( $tableData[$count] )? $tableData[$count] : array();
                                @endphp

                                    <tr>
                                        <td>{{$count}}</td>
                                        @while($table_count <= 12)
                                        @php
                                            $to_tableObj = isset( $from_table_array[$table_count] )? $from_table_array[$table_count] : array();
                                            $class = isset( $to_tableObj['class'] )? $to_tableObj['class'] : '';


                                        @endphp
                                        <td class="{{$class}}"><span>{{$count}} <span>&#215;</span> {{$table_count}}</span></td>
                                        @php $table_count++; @endphp
                                        @endwhile
                                    </tr>

                                @php $count++; @endphp
                            @endwhile
                            </tbody>
                        @endforeach
                    @endif
                </table>


            </div>
        </div>
    </div>

    @endsection

    @push('scripts_bottom')
    @endpush
