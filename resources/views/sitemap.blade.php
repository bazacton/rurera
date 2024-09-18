<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="https://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns:video="https://www.google.com/schemas/sitemap-video/1.1/sitemap-video.xsd">
@php $sitemap_array = File::get(storage_path('sitemap.html')); $sitemap_array = json_decode($sitemap_array);@endphp
@foreach( $sitemap_array as $url => $params ) @php $params = (array) $params; @endphp
@if( $url == '')
	@php continue; @endphp
@endif
<url>
	<loc>{{$url}}</loc>
	<lastmod>{{$params['lastmod']}}</lastmod>
	<changefreq>{{$params['changefreq']}}</changefreq>
	<priority>{{$params['priority']}}</priority>
	@if( isset( $params['images'] ) && !empty( $params['images'] ) )
		@foreach( $params['images'] as $imageData)
			@php $imageData = (array) $imageData; @endphp
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