<?php

namespace kosuha606\VirtualAdmin\Domains\Sitemap;

use kosuha606\VirtualAdmin\Domains\Seo\SeoModelInterface;
use kosuha606\VirtualAdmin\Domains\Seo\SeoPageVm;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Sitemap
 */
class SitemapService
{
    /** @var SitemapProviderInterface */
    private $provider;

    /** @var SitemapVm  */
    private $sitemap;

    /**
     * SitemapService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->provider = VirtualModelManager::getInstance()->getProvider(SitemapProviderInterface::class);
        $this->sitemap = VirtualModelManager::getEntity(SitemapVm::class)::create([]);
    }

    /**
     * @return SitemapVm
     * @throws \Exception
     */
    public function buildSitemap(): SitemapVm
    {
        $storageProvider = VirtualModelManager::getInstance()->getProvider('storage');
        $storageClasses = $storageProvider->getAvailableModelClasses();
        $baseUrl = $this->provider->getBaseUrl();

        $seoPages = VirtualModelManager::getEntity(SeoPageVm::class)::many(['where' => [
            ['=', 'entity_id', null]
        ]]);
        /** @var SeoPageVm $page */
        foreach ($seoPages as $page) {
            $this->addSeoPageToSitemap($baseUrl.$page->url, $page);
        }

        // Записываем в карту сайта все сущности
        /** @var VirtualModelEntity $storageClass */
        foreach ($storageClasses as $storageClass) {
            if (in_array(SeoModelInterface::class, class_implements($storageClass, true))) {
                $models = $storageClass::many(['where' => [['all']]]);

                /** @var SeoModelInterface $model */
                foreach ($models as $model) {
                    $seo = $model->getSeo();
                    $url = $model->getUrl();
                    $this->addSeoPageToSitemap($baseUrl.$url, $seo);
                }
            }
        }

        return $this->sitemap;
    }

    /**
     * Добавить один url в карту сайта
     * @param $url
     * @param SeoPageVm $seoPageVm
     */
    public function addSeoPageToSitemap(
        $url,
        SeoPageVm $seoPageVm
    ) {
        if ($seoPageVm->noindex) {
            return;
        }

        $buildDate = time();
        $importance = 0.3;
        $freq = 'daily';

        if ($seoPageVm->sitemap_freq) {
            $freq = $seoPageVm->sitemap_freq;
        }

        if ($seoPageVm->sitemap_importance) {
            $importance = $seoPageVm->sitemap_importance;
        }

        $this->sitemap->addItem(new SitemapItemDto($url, $buildDate, $freq, $importance));
    }
}