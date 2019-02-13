<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemalocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(!empty($keywords))
        @foreach($keywords as $k)
            <url>
                <loc>{{ url($k->keyword_text) . '-numbers' }}</loc>
                {{--                <lastmod>{{ $k->created_at->tz('UTC')->toAtomString() }}</lastmod>--}}
                <changefreq>hourly</changefreq>
                <priority>0.6</priority>
            </url>
        @endforeach
    @endif
</urlset>