<?php

namespace kosuha606\VirtualAdmin\Domains\Sitemap;

/**
 * @package kosuha606\VirtualAdmin\Domains\Sitemap
 */
interface SitemapProviderInterface
{
    public function getSitemapContent();

    public function getBaseUrl();
}