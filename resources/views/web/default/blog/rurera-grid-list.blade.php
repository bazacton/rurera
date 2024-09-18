<div class="blog-grid-card rurera-grid"  itemscope itemtype="https://schema.org/NewsArticle">
    <div class="blog-grid-detail">
        <span class="badge created-at d-flex align-items-center">
            <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
            <span  itemprop="datePublished" content="2023-04-05T08:00:00+08:00">{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>
        </span>

        <h2 class="blog-grid-title mt-10" itemprop="headline">
            <a href="{{ $post->getUrl() }}" itemprop="url">{{ $post->title }}</a>
        </h2>
        <div class="mt-20 mb-10 blog-grid-desc" itemprop="description">{!! truncate(strip_tags($post->description), 200) !!}</div>
        @php
            $meta_description = explode(',', $post->meta_description);
            if( !empty( $meta_description ) ){

            }

        @endphp

    </div>
    <div class="blog-grid-image">
        <img src="{{ $post->image }}" class="img-cover" alt="{{ $post->title }}" title="{{ $post->title }}" width="100%" height="100%" itemprop="image" loading="eager">
    </div>

</div>
