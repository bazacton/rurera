@extends(getTemplate().'.layouts.app')

@push('styles_top')
<link rel="stylesheet" href="/assets/default/vendors/swiper/swiper-bundle.min.css">
    @endpush

    @section('content')

<section class="container mt-0 mt-md-0 pt-30">
        <div class="row">
            <div class="col-12">
                <table class="table text-center custom-table table-striped">
                    <thead>
                    <tr>
                        <th class="text-left">Page Name</th>
                        <th class="text-center">SEO Title</th>
                        <th class="text-center">Link</th>
                        <th class="text-center">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( !empty( $all_pages ) )
                    @foreach( $all_pages as $pageData)
                        <tr>
                            <td class="text-left">{{$pageData->name}}</td>
                            <td class="text-align-middle">{{$pageData->getTitleAttribute()}}</td>
                            <td class="text-center align-middle"><a href="{{$pageData->link}}">{{$pageData->link}}</a></td>
                            <td class="text-center align-middle">{{$pageData->getSeoDescriptionAttribute()}}</td>
                        </tr>
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
