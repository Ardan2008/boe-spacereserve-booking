User-agent: *
Allow: /
Disallow: /{{ $disallowAdmin ?? 'admin/formLogin' }}
Disallow: /admin/
Disallow: /receipt/public/

Sitemap: {{ url('/sitemap.xml') }}
