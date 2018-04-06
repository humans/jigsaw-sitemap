# Jigsaw Sitemap

This package is still in development, use at your own risk.

## Usage

Install the package.

```
composer install artisan/jigsaw-sitemap
```

Set up the sitemap on your `bootstrap.php` file.

```
use Artisan\Jigsaw\Sitemap;

(new Sitemap($container))->create(['posts']);
```

You can also add some defaults for those special URLs:

```
(new Sitemap($container))->fill([
    [
        'loc'        => 'https://example.com',
        'lastmod'    => '2014-01-1',
        'changefreq' => 'weekly',
    ]
])->create(['posts']);
```