<?php

namespace Artisan\Jigsaw\Sitemap;

use Spatie\ArrayToXml\ArrayToXml;

class Sitemap
{
    public $container;
    public $urls = [];

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function fill($urls)
    {
        $this->urls = $urls;

        return $this;
    }

    public function create(...$collections)
    {
        $this->container->events->afterCollections(function ($jigsaw) use ($collections) {
            $objects = $jigsaw->getCollections()->only($collections)->flatten(1)->map(function ($item) {
                return [
                    'loc'        => $item->getUrl(),
                    'lastmod'    => date('Y-m-d', $item->date),
                    'changefreq' => 'weekly',
                ];
            });

            $objects->prepend($this->urls);

            $sitemap = ArrayToXml::convert(['url' => $objects->toArray()], [
                'rootElementName' => 'urlset',
                '_attributes'     => [
                    'xmlns' => "http://www.sitemaps.org/schemas/sitemap/0.9",
                    'xmlns:xhtml' => "http://www.w3.org/1999/xhtml",
                ],
            ]);

            var_dump($this->container['cwd']);
            // file_put_contents(__DIR__ . '/source/sitemap.xml', $sitemap);
        });
    }
}