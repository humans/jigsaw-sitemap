# Jigsaw Sitemap

This package is still in development, use at your own risk.

## Usage

Install the package.

```bash
composer install artisan/jigsaw-sitemap
```

Make sure to add the `source/sitemap.xml` to your gitignore to avoid having to commit it every time it builds.

Set up the sitemap on your `bootstrap.php` file.

```php
use Artisan\Jigsaw\Sitemap;

(new Sitemap($container))->collections('posts')->create();
```

You can also add some defaults for those special URLs:

```php
(new Sitemap($container))->fill([
    [
        'loc'        => 'https://example.com',
        'lastmod'    => '2014-01-1',
        'changefreq' => 'weekly',
    ]
])->collections('posts', 'donuts')->create();
```
