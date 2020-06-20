<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualModelHelppack\ServiceManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Seo
 */
class SeoUrlObserver
{
    /**
     * После сохранения основной модели необходимо
     * сохранить сгенерированную ссылку для модели
     *
     * @param SeoModelInterface $model
     * @throws \Exception
     */
    public function afterSave(SeoModelInterface $model)
    {
        ServiceManager::getInstance()->get(SeoService::class)->generateUrlByModel($model);
    }

    /**
     * @param SeoModelInterface $model
     * @throws \Exception
     */
    public function afterDelete(SeoModelInterface $model)
    {
        ServiceManager::getInstance()->get(SeoService::class)->removeUrlByModel($model);
    }
}