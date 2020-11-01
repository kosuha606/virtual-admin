<?php

namespace kosuha606\VirtualAdmin\Structures;

use kosuha606\VirtualAdmin\Domains\Seo\SeoPageVm;
use kosuha606\VirtualAdmin\Form\SecondaryFormBuilder;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualModelHelppack\ServiceManager;

class SecondaryForms
{
    /**
     * @param $inModel
     * @return array
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public static function SEO_PAGE($model)
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $configSeo = $secondaryService->buildForm()
            ->setMasterModel($model)
            ->setMasterModelId($model->id.','.get_class($model))
            ->setMasterModelField('entity_id,entity_class')
            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
            ->setRelationClass(SeoPageVm::class)
            ->setTabName('SEO_data')
            ->setRelationEntities(SeoPageVm::many(['where' => [
                ['=', 'entity_id', $model->id],
                ['=', 'entity_class', get_class($model)]
            ]]))
            ->setConfig(function ($inModel) use ($model) {
                $stringService = ServiceManager::getInstance()->get(StringService::class);

                return [
                    [
                        'field' => 'id',
                        'label' => '',
                        'component' => DetailComponents::HIDDEN_FIELD,
                        'value' => $inModel->id,
                    ],
                    [
                        'field' => 'entity_id',
                        'label' => '',
                        'component' => DetailComponents::HIDDEN_FIELD,
                        'value' => $model->id,
                    ],
                    [
                        'field' => 'entity_class',
                        'label' => '',
                        'component' => DetailComponents::HIDDEN_FIELD,
                        'value' => get_class($model),
                    ],
                    DetailComponents::MULTILANG_FIELD(
                        DetailComponents::INPUT_FIELD,
                        'title',
                        'Заголовок',
                        $inModel->title,
                        $inModel
                    ),
                    DetailComponents::MULTILANG_FIELD(
                        DetailComponents::INPUT_FIELD,
                        'meta_keywords',
                        'Мета ключевые слова',
                        $inModel->meta_keywords,
                        $inModel
                    ),
                    DetailComponents::MULTILANG_FIELD(
                        DetailComponents::INPUT_FIELD,
                        'mata_description',
                        'Мета описание',
                        $inModel->mata_description,
                        $inModel
                    ),
                    DetailComponents::MULTILANG_FIELD(
                        DetailComponents::INPUT_FIELD,
                        'og_title',
                        'OG заголовок',
                        $inModel->og_title,
                        $inModel
                    ),
                    DetailComponents::MULTILANG_FIELD(
                        DetailComponents::INPUT_FIELD,
                        'og_description',
                        'OG описание',
                        $inModel->og_description,
                        $inModel
                    ),
                    [
                        'field' => 'og_url',
                        'label' => 'OG адресс',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $inModel->og_url,
                    ],
                    [
                        'field' => 'og_image',
                        'label' => 'OG изображение',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $inModel->og_image,
                    ],
                    [
                        'field' => 'og_type',
                        'label' => 'OG тип',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $inModel->og_type,
                    ],
                    [
                        'field' => 'canonical',
                        'label' => 'Canonical',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $inModel->canonical,
                    ],
                    [
                        'field' => 'noindex',
                        'label' => 'Noindex',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $inModel->noindex,
                    ],
                    [
                        'field' => 'sitemap_importance',
                        'label' => 'Sitemap приоритет',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $inModel->sitemap_importance,
                    ],
                    [
                        'field' => 'sitemap_freq',
                        'label' => 'Sitemap частота обновления',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $inModel->sitemap_freq,
                    ],
                ];
            })
            ->getConfig()
        ;

        return $configSeo;
    }
}
