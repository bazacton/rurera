<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    @foreach( Cache::get('sitemap') as $url => $params )
    <url>
        <loc>{{$url}}</loc>
        <lastmod>{{$params['lastmod']}}</lastmod>
        <changefreq>{{$params['changefreq']}}</changefreq>
        <priority>{{$params['priority']}}</priority>
        @if( isset( $params['images'] ) && !empty( $params['images'] ) )
            @foreach( $params['images'] as $imageData)
                <image:image>
                    <image:loc>{{isset( $imageData['loc'] )? $imageData['loc'] : ''}}</image:loc>
                    <image:title>{{isset( $imageData['title'] )? $imageData['title'] : ''}}</image:title>
                    <image:caption>{{isset( $imageData['caption'] )? $imageData['caption'] : ''}}</image:caption>
                </image:image>
            @endforeach
        @endif
    </url>
    @endforeach
</urlset>