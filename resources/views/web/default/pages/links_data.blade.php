@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endpush

    @section('content')

<section class="mt-0 mt-md-0 pt-30">
        <div class="row">
            <div class="col-12">
                <table class="table text-center custom-table table-striped">
                    <thead>
                    <tr>
                        <th class="text-left">Image Src</th>
                        <th class="text-center">Alt Tag</th>
                        <th class="text-center">Title Tag</th>
                        <th class="text-center">Width</th>
                        <th class="text-center">Height</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( !empty( $pages_data ) )
                    @foreach( $pages_data as $page_link => $images_array)
                    <tr style="background: #ffd5d5;">
                        <td class="text-center" colspan="6">{{$page_link}}</td>
                    </tr>
						@if( !empty( $images_array ) )
							@foreach( $images_array as $imageData)
                        <tr>
                            <td class="text-left"><a href="{{$imageData['src']}}"><img src="{{$imageData['src']}}" height="100"></a></td>
                            <td class="text-align-middle">{{$imageData['alt']}}</td>
                            <td class="text-center align-middle">{{$imageData['title']}}</td>
                            <td class="text-center align-middle">{{$imageData['width']}}</td>
                            <td class="text-center align-middle">{{$imageData['height']}}</td>
                        </tr>
							@endforeach
						@endif
                    @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
</section>

    @endsection

    @push('scripts_bottom')
    <script src="/assets/default/vendors/swiper/swiper-bundle.min.js"></script>
    @endpush
