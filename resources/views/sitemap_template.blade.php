<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://otherworlds.es/es/home</loc>
        <lastmod>2024-11-05</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://otherworlds.es/en/home</loc>
        <lastmod>2024-11-05</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://otherworlds.es/en/places</loc>
        <lastmod>2024-11-05</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>https://otherworlds.es/es/lugares</loc>
        <lastmod>2024-11-05</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach($urls as $url)
        <url>
            <loc>{{ $url }}</loc>
            <lastmod>{{ now() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
