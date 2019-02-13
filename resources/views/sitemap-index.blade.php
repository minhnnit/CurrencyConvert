<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if($page >=0)
        @for ($i = 0; $i<= $page; $i++)
            <sitemap>
                <loc>{{ url('/sitemap/keywords_' . $i .'.xml') }}</loc>
                <lastmod>{{ \Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
            </sitemap>
        @endfor
    @endif
</sitemapindex>
