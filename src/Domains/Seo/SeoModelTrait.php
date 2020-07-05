<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModelManager;

trait SeoModelTrait
{
    /**
     * @return SeoPageVm
     * @throws \Exception
     */
    public function getSeo(): SeoPageVm
    {
        $id = $this->id;
        $modelClass = get_class($this);
        $models = VirtualModelManager::getEntity(SeoPageVm::class)::many([
            'where' => [
                ['=', 'entity_id', $id],
                ['=', 'entity_class', $modelClass],
            ]
        ]);

        return $models ? $models[0] : SeoPageVm::create([]);
    }

    /**
     * @return SeoPageVm
     * @throws \Exception
     */
    public function getUrl()
    {
        $id = $this->id;
        $modelClass = get_class($this);
        $models = VirtualModelManager::getEntity(SeoUrlVm::class)::many([
            'where' => [
                ['=', 'entity_id', $id],
                ['=', 'entity_class', $modelClass]
            ]
        ]);
        $model = $models ? $models[0] : VirtualModelManager::getEntity(SeoUrlVm::class)::create([]);

        return $model->url;
    }
}