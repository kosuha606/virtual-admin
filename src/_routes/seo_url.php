<?php


use kosuha606\VirtualAdmin\Domains\Seo\SeoModelInterface;
use kosuha606\VirtualAdmin\Domains\Seo\SeoService;
use kosuha606\VirtualAdmin\Domains\Seo\SeoUrlVm;
use kosuha606\VirtualAdmin\Dto\AdminResponseDTO;
use kosuha606\VirtualAdmin\Services\AlertService;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\ServiceManager;

$baseEntity = 'seo_url';
$stringService = ServiceManager::getInstance()->get(StringService::class);
$baseEntityCamel = $stringService->transliterate($baseEntity);
$entityClass = SeoUrlVm::class;
$listTitle = 'Генерировать url';
$detailTitle = 'Генерировать url';

return [
    'routes' => [
        $baseEntity => [
            'regen' => [
                'handler' => function() {
                    $result = [
                        'result' => true
                    ];
                    $modelClasses = VirtualModelManager::getInstance()->getProvider('storage')->getAvailableModelClasses();
                    $seoService = ServiceManager::getInstance()->get(SeoService::class);

                    SeoUrlVm::deleteByCondition(['where' => '1']);
                    foreach ($modelClasses as $modelClass) {
                        if (!in_array(SeoModelInterface::class, class_implements($modelClass))) {
                            continue;
                        }

                        $models = $modelClass::many(['where' => [['all']]]);

                        foreach ($models as $model) {
                            $seoService->generateUrlByModel($model);
                        }
                    }

                    ServiceManager::getInstance()->get(AlertService::class)->success('Успешно сгенерированы url');

                    return new AdminResponseDTO('', $result);
                }
            ],
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'parent' => 'seo',
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $detailTitle,
                    'entity' => $baseEntity,
                    'component' => 'detail',
                    'detail_config' => [
                        'noback' => true,
                        'notabs' => true,
                        'nobuttons' => true,
                    ],
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionView',
                    ],
                    'config' => function ($model) {
                        $seoUrlsCnt = SeoUrlVm::count(['where' => [['all']]]);

                        return [
                            [
                                'field' => 'name',
                                'component' => 'GenurlsPage',
                                'label' => 'Название',
                                'props' => [
                                    'urlsCnt' => $seoUrlsCnt,
                                ]
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];
