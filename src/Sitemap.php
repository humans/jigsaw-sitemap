<?php

namespace Artisan\Jigsaw;

use Illuminate\Container\Container;
use Spatie\ArrayToXml\ArrayToXml;

class Sitemap
{
    protected $collections;

    protected $container;

    protected $urls = [];

    /**
     * Create a new Sitemap instance.
     *
     * @param  Container  $container  This container is from Jigsaw's bootstrap
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Prefill the sitemap with URLs.
     *
     * Here you can manually add some pages that aren't hooked up to
     * collections.
     *
     * @param  array  $urls
     * @return $this
     */
    public function fill($urls)
    {
        $this->urls = $urls;

        return $this;
    }

    /**
     * Set the collections to create sitemap URLs for.
     *
     * @param  array  $collections
     * @return $this
     */
    public function collections(...$collections)
    {
        $this->collections = $collections;

        return $this;
    }

    /**
     * Write the sitemap on the source directory.
     *
     * @return void
     */
    public function create()
    {
        $this->container->events->afterCollections(function ($jigsaw) {
            $objects = $jigsaw->getCollections()->only($this->collections)->flatten(1)->map(function ($item) {
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

            file_put_contents(
                $this->container['cwd'] . '/source/sitemap.xml',
                $sitemap
            );
        });
    }
}
