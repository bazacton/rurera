<div class="blog-grid-card">
    <div class="blog-grid-detail">
        <span class="badge created-at d-flex align-items-center">
            <i data-feather="calendar" width="20" height="20" class="mr-5"></i>
            <span>{{ dateTimeFormat($post->created_at, 'j M Y') }}</span>
        </span>
        <a href="{{ $post->getUrl() }}">
            <h3 class="blog-grid-title mt-10">{{ $post->title }}</h3>
        </a>

        <div class="mt-20 blog-grid-desc">{!! truncate(strip_tags($post->description), 200) !!}</div>
        @php
            $meta_description = explode(',', $post->meta_description);
            if( !empty( $meta_description ) ){
                
            }
            
        @endphp
        
        @if( !empty( $meta_description ))
        <ul class="blog-tags">
            @foreach( $meta_description as $meta_title)
                @if(trim($meta_title) != '')
                    <li>{{trim($meta_title)}}</li>
                @endif
            @endforeach
        </ul>
        @endif
    </div>
    <div class="blog-grid-image">
        <img src="{{ $post->image }}" class="img-cover" alt="{{ $post->title }}">
    </div>
    

    
</div>
