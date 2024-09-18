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
                        <th class="text-left">Page Name</th>
                        <th class="text-center">SEO Title</th>
                        <th class="text-center">Link</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Follow</th>
                        <th class="text-center">XMl</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background: #ffd5d5;">
                        <td class="text-center" colspan="6">Pages</td>
                    </tr>
                    @if( !empty( $all_pages ) )
                    @foreach( $all_pages as $pageData)
                        <tr>
                            <td class="text-left">{{$pageData->name}}</td>
                            <td class="text-align-middle">{{$pageData->getTitleAttribute()}}</td>
                            <td class="text-center align-middle"><a href="{{$pageData->link}}">{{$pageData->link}}</a></td>
                            <td class="text-center align-middle">{{$pageData->getSeoDescriptionAttribute()}}</td>
                            <td class="text-center align-middle">{{($pageData->robot == 0)? 'No' : 'Yes'}}</td>
                            <td class="text-center align-middle">{{($pageData->include_xml == 0)? 'No' : 'Yes'}}</td>
                        </tr>
                    @endforeach
                    @endif

                    
                    @if( !empty( $all_courses ) )
                       @foreach( $all_courses as $courseData)
                           <tr>
                               <td class="text-left">{{$courseData->getTitleAttribute()}}</td>
                               <td class="text-align-middle">{{$courseData->seo_title}}</td>
                               <td class="text-center align-middle">{{$courseData->getSeoDescriptionAttribute()}}</td>
                               <td class="text-center align-middle">{{($courseData->seo_robot_access == 0)? 'No' : 'Yes'}}</td>
                               <td class="text-center align-middle">{{($courseData->include_xml == 0)? 'No' : 'Yes'}}</td>
                           </tr>
                       @endforeach
                       @endif

                    @if( !empty( $all_books ) )
                       @foreach( $all_books as $bookData)
                           <tr>
                               <td class="text-left">{{$bookData->book_title}}</td>
                               <td class="text-align-middle">{{$bookData->seo_title}}</td>
                               <td class="text-center align-middle"><a href="/books/{{$bookData->book_slug}}">/books/{{$bookData->book_slug}}</a></td>
                               <td class="text-center align-middle">{{$bookData->seo_description}}</td>
                               <td class="text-center align-middle">{{($bookData->seo_robot_access == 0)? 'No' : 'Yes'}}</td>
                               <td class="text-center align-middle">{{($bookData->include_xml == 0)? 'No' : 'Yes'}}</td>
                           </tr>
                       @endforeach
                       @endif


                    @if( !empty( $all_products ) )
                       @foreach( $all_products as $productData)
                           <tr>
                               <td class="text-left">{{$productData->getTitleAttribute()}}</td>
                               <td class="text-align-middle">{{$productData->seo_title}}</td>
                               <td class="text-center align-middle"><a href="/products/{{$productData->slug}}">/products/{{$productData->slug}}</a></td>
                               <td class="text-center align-middle">{{$productData->seo_description}}</td>
                               <td class="text-center align-middle">{{($productData->seo_robot_access == 0)? 'No' : 'Yes'}}</td>
                              <td class="text-center align-middle">{{($productData->include_xml == 0)? 'No' : 'Yes'}}</td>
                           </tr>
                       @endforeach
                       @endif

                    <tr style="background: #ffd5d5;">
                        <td class="text-center" colspan="6">Blog</td>
                    </tr>
                    @if( !empty( $all_blog_posts ) )
                       @foreach( $all_blog_posts as $blogPostData)
                           <tr>
                               <td class="text-left">{{$blogPostData->getTitleAttribute()}}</td>
                               <td class="text-align-middle">{{$blogPostData->seo_title}}</td>
                               <td class="text-center align-middle"><a href="/blog/{{$blogPostData->slug}}">/blog/{{$blogPostData->slug}}</a></td>
                               <td class="text-center align-middle">{{$blogPostData->meta_description}}</td>
                               <td class="text-center align-middle">{{(getPageRobot('blog') == 0)? 'No' : 'Yes'}}</td>
                              <td class="text-center align-middle">{{($blogPostData->include_xml == 0)? 'No' : 'Yes'}}</td>
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
