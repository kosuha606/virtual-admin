<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;
use kosuha606\VirtualContent\Domains\Page\Models\PageVm;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Seo
 */
class SeoService
{
    private $langService;

    public function __construct(LanguageService $languageService)
    {
        $this->langService = $languageService;
    }

    /**
     * Получить SeoPageVm по урл адресу
     *
     * @param $url
     * @return SeoPageVm
     * @throws \Exception
     */
    public function findSeoPageByUrl($url)
    {
        $languages = array_keys($this->langService->getLanguages());
        $languages = array_map(function($item) {
            return '/'.$item.'/';
        }, $languages);
        $url = str_replace($languages, '/', $url);

        if ($url === '/') {
            // Для главной страницы обработка отдельная
            $homePage = PageVm::one(['where' => [['=', 'is_home', 1]]]);
            $seoPage = $homePage->getSeo();
        } else {
            $seoPage = VirtualModelManager::getEntity(SeoPageVm::class)::one(['where' => [
                ['=', 'url', $url]
            ]]);
        }

        if ($seoPage && $seoPage->id) {
            return $seoPage;
        }

        $seoUrl = VirtualModelManager::getEntity(SeoUrlVm::class)::one([
            'where' => [
                ['=', 'url', $url]
            ]
        ]);

        $seoPage = VirtualModelManager::getEntity(SeoPageVm::class)::one([
            'where' => [
                ['=', 'entity_id', $seoUrl->entity_id],
                ['=', 'entity_class', $seoUrl->entity_class],
            ]
        ]);

        if ($seoPage && $seoPage->id) {
            return $seoPage;
        }

        return SeoPageVm::create();
    }

    /**
     * Получить модель по url
     *
     * @param $url
     * @return bool
     * @throws \Exception
     */
    public function findModelByUrl($url)
    {
        $seoUrl = VirtualModelManager::getEntity(SeoUrlVm::class)::one([
           'where' => [
               ['=', 'url', $url]
           ]
        ]);

        if (!$seoUrl) {
            return false;
        }

        $modelClass = $seoUrl->entity_class;

        if (!$modelClass) {
            return false;
        }

        $model = VirtualModelManager::getEntity($modelClass)::one([
            'where' => [
                ['=', 'id', $seoUrl->entity_id]
            ]
        ]);

        return $model;
    }

    /**
     * Генерация модели SeoUrlVm по модели сео
     *
     * @param SeoModelInterface $model
     * @throws \Exception
     */
    public function generateUrlByModel(SeoModelInterface $model)
    {
        $url = $model->buildUrl();
        $id = $model->id;

        if (!$id) {
            return;
        }

        $modelClass = get_class($model);
        $this->removeUrlByModel($model);

        VirtualModelManager::getEntity(SeoUrlVm::class)::create([
            'entity_id' => $id,
            'entity_class' => $modelClass,
            'url' => $url,
        ])->save();
    }

    /**
     * Удалить SeoUrlVm по связанной сео модели
     *
     * @param SeoModelInterface $model
     * @throws \Exception
     */
    public function removeUrlByModel(SeoModelInterface $model)
    {
        $id = $model->id;
        $modelClass = get_class($model);

        /** @var SeoUrlVm[] $oldModels */
        $oldModels = VirtualModelManager::getEntity(SeoUrlVm::class)::many([
            'where' => [
                ['=', 'entity_id', $id],
                ['=', 'entity_class', $modelClass],
            ]
        ]);

        // Удаляем все старые url модели этой сущности
        if ($oldModels) {
            foreach ($oldModels as $oldModel) {
                $oldModel->delete();
            }
        }
    }
}