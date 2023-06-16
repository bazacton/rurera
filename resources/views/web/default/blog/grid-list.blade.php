<div class="blog-grid-card"  itemscope itemtype="https://schema.org/NewsArticle">
    <div class="blog-grid-detail">
        <span class="badge created-at d-flex align-items-center">
            <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
            <span  itemprop="datePublished" content="2023-04-05T08:00:00+08:00">{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>
        </span>
        <a itemprop="url" href="{{ $post->getUrl() }}">
            <h2 class="blog-grid-title mt-10" itemprop="title">{{ $post->title }}</h2>
        </a>

        <div class="mt-20 blog-grid-desc" itemprop="description">{!! truncate(strip_tags($post->description), 200) !!}</div>
        @php
            $meta_description = explode(',', $post->meta_description);
            if( !empty( $meta_description ) ){

            }

        @endphp

        @if( !empty( $meta_description ))
        <ul class="blog-tags">
            @foreach( $meta_description as $meta_title)
                @if(trim($meta_title) != '')
                    <li itemprop="name">{{trim($meta_title)}}</li>
                @endif
            @endforeach
        </ul>
        @endif
    </div>
    <div class="blog-grid-image">
        <img src="{{ $post->image }}" class="img-cover" alt="{{ $post->title }}" title="{{ $post->title }}" width="100%" height="auto" itemprop="image">
    </div>

</div>
