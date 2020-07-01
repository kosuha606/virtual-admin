<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;

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

        $seoPage = SeoPageVm::one(['where' => [
            ['=', 'url', $url]
        ]]);

        if ($seoPage && $seoPage->id) {
            return $seoPage;
        }

        $seoUrl = SeoUrlVm::one([
            'where' => [
                ['=', 'url', $url]
            ]
        ]);

        $seoPage = SeoPageVm::one([
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
        $seoUrl = SeoUrlVm::one([
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

        $model = $modelClass::one([
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
        $modelClass = get_class($model);
        $this->removeUrlByModel($model);

        SeoUrlVm::create([
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
        $oldModels = SeoUrlVm::many([
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