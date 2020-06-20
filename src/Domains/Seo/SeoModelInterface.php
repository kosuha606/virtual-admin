<?php


namespace kosuha606\VirtualAdmin\Domains\Seo;

/**
 * @package kosuha606\VirtualAdmin\Domains\Seo
 */
interface SeoModelInterface
{
    public function buildUrl();

    public function getSeo(): SeoPageVm;

    public function getUrl();
}