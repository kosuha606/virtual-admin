<?php

use kosuha606\VirtualAdmin\Form\SecondaryFormBuilder;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Model\Request;
use kosuha606\VirtualAdmin\Model\Session;
use kosuha606\VirtualAdmin\Services\RequestService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualAdmin\Test\Models\ProductRestsVm;
use kosuha606\VirtualAdmin\Test\Models\ProductVm;
use kosuha606\VirtualAdmin\Test\TestRequestProvider;
use kosuha606\VirtualAdmin\Test\TestSessionProvider;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualModelHelppack\Test\VirtualTestCase;
use PHPUnit\Framework\TestCase;

class SecondaryFormTest extends VirtualTestCase
{
    /** @var TestSessionProvider */
    public $sessionProvider;

    /** @var TestRequestProvider */
    public $requestProvider;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->provider->memoryStorage = [
            ProductRestsVm::class => [
                [
                    'id' => 1,
                    'productId' => 1,
                    'qty' => 10,
                    'userType' => 'b2c',
                ],
                [
                    'id' => 2,
                    'productId' => 1,
                    'qty' => 15,
                    'userType' => 'b2b',
                ],
            ],
            ProductVm::class => [
                [
                    'id' => 1,
                    'name' => 'Первый',
                    'price' => 100,
                    'price2B' => 200,
                ],
                [
                    'id' => 2,
                    'name' => 'Второй',
                    'price' => 200,
                    'price2B' => 300,
                ],
            ]
        ];

        $this->sessionProvider = new TestSessionProvider();
        $this->requestProvider = new TestRequestProvider();

        VirtualModelManager::getInstance()->setProvider($this->sessionProvider);
        VirtualModelManager::getInstance()->setProvider($this->requestProvider);
    }

    public function tearDown()
    {
        RequestService::$request = null;
        unset($this->sessionProvider);
        unset($this->requestProvider);
        parent::tearDown();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws Exception
     */
    public function testForm()
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $product = ProductVm::one(['where' => [['=', 'id', 1]]]);

        $config = $secondaryService->buildForm()
            ->setMasterModel($product)
            ->setMasterModelField('productId')
            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
            ->setRelationClass(ProductRestsVm::class)
            ->setTabName('Остатки')
            ->setRelationEntities(ProductRestsVm::many(['where' => [['=', 'productId', $product->id]]]))
            ->setConfig(function ($model) {
                return [
                    [
                        'field' => 'productId',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $model->productId,
                    ],
                    [
                        'field' => 'qty',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $model->qty,
                    ],
                    [
                        'field' => 'userType',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $model->userType,
                    ],
                ];
            })
            ->getConfig()
        ;

        // В сессию записывается одна запись
        $this->assertEquals(1, count($this->sessionProvider->memoryStorage));
        $configString = json_encode($config, JSON_UNESCAPED_UNICODE);
        $relationClass = str_replace('\\', '\\\\',  ProductRestsVm::class);
        $this->assertEquals($configString, '{"tab":"Остатки","tabLink":"ostatki","type":"one.to.one","initialConfig":[{"field":"productId","component":"InputField","value":null},{"field":"qty","component":"InputField","value":null},{"field":"userType","component":"InputField","value":null}],"relationClass":"'.$relationClass.'","dataConfig":[[{"field":"productId","component":"InputField","value":1},{"field":"qty","component":"InputField","value":10},{"field":"userType","component":"InputField","value":"b2c"}],[{"field":"productId","component":"InputField","value":1},{"field":"qty","component":"InputField","value":15},{"field":"userType","component":"InputField","value":"b2b"}]],"isViewOnly":false}');
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws Exception
     */
    public function testProcess()
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $product = ProductVm::one(['where' => [['=', 'id', 1]]]);
        $secondaryService->processRememberedForm($product);

        // Устанавливаем состояние сессии
        $this->sessionProvider->memoryStorage = [
            Session::class => [
                [
                    'id' => 0,
                    'key' => $secondaryService->getRealSessionKey(),
                    'value' => [
                        ProductRestsVm::class => [
                            'masterModelId' => 1,
                            'masterModelField' => 'productId',
                            'masterModelClass' => ProductVm::class,
                            'relationType' => SecondaryFormBuilder::ONE_TO_ONE
                        ]
                    ]
                ]
            ]
        ];

        $this->requestProvider->memoryStorage = [
            Request::class => [
                [
                    'get' => [],
                    'post' => [
                        'secondary_form' => [
                            ProductRestsVm::class => [
                                [
                                    'productId' => 1,
                                    'qty' => 10,
                                    'userType' => 'b2c',
                                ],
                                [
                                    'productId' => 1,
                                    'qty' => 16,
                                    'userType' => 'b2c',
                                ],
                                [
                                    'productId' => 1,
                                    'qty' => 15,
                                    'userType' => 'b2b',
                                ],
                            ]
                        ]
                    ],
                    'isAjax' => false,
                    'isPost' => true,
                ]
            ]
        ];

        $this->assertTrue(true);
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws Exception
     */
    public function testMultiProcess()
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $product = ProductVm::one(['where' => [['=', 'id', 1]]]);
        $secondaryService->processRememberedForm($product);

        // Устанавливаем состояние сессии
        $this->sessionProvider->memoryStorage = [
            Session::class => [
                [
                    'id' => 0,
                    'key' => $secondaryService->getRealSessionKey(),
                    'value' => [
                        ProductRestsVm::class => [
                            'masterModelId' => 1,
                            'masterModelField' => 'productId',
                            'masterModelClass' => ProductVm::class,
                            'relationType' => SecondaryFormBuilder::ONE_TO_ONE
                        ]
                    ]
                ]
            ]
        ];

        $this->requestProvider->memoryStorage = [
            Request::class => [
                [
                    'get' => [],
                    'post' => [
                        'secondary_form' => [
                            ProductRestsVm::class => [
                                [
                                    'productId' => 1,
                                    'qty' => 10,
                                    'userType' => 'b2c',
                                ],
                                [
                                    'productId' => 1,
                                    'qty' => 16,
                                    'userType' => 'b2c',
                                ],
                                [
                                    'productId' => 1,
                                    'qty' => 15,
                                    'userType' => 'b2b',
                                ],
                            ]
                        ]
                    ],
                    'isAjax' => false,
                    'isPost' => true,
                ]
            ]
        ];

        $this->assertTrue(true);
    }
}