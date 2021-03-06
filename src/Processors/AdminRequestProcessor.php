<?php

namespace kosuha606\VirtualAdmin\Processors;

use kosuha606\VirtualAdmin\Controllers\CrudController;
use kosuha606\VirtualAdmin\Domains\Transaction\TransactionVm;
use kosuha606\VirtualAdmin\Dto\AdminResponseDTO;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Interfaces\AdminControllerInterface;
use kosuha606\VirtualAdmin\Interfaces\AdminRoutesLoaderInterface;
use kosuha606\VirtualAdmin\Services\AdminConfigService;
use kosuha606\VirtualAdmin\Services\AlertService;
use kosuha606\VirtualAdmin\Services\MenuService;
use kosuha606\VirtualAdmin\Services\PermissionService;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModelHelppack\ValidatableVirtualModel;
use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualAdmin\Classes\Pagination;

/**
 * @description Обработчик запросов к админке
 * @description Настройки роутов загружаются из конфигов в папке
 */
class AdminRequestProcessor
{
    /** @var AdminConfigService */
    private $adminConfigService;

    /** @var null|array */
    private $config = null;

    /** @var AdminControllerInterface */
    private $controller;

    /** @var MenuService */
    private $menuService;

    /** @var CrudController */
    private $crudController;

    /** @var AlertService */
    private $alertService;

    /** @var PermissionService */
    private $permissionService;

    /** @var UserService */
    private $userService;

    /** @var AdminRoutesLoaderInterface[] */
    private $routeLoaders = [];

    /** @var SecondaryFormService */
    private $secondaryFormService;

    /**
     * @param AdminConfigService $adminConfigService
     * @param MenuService $menuService
     * @param CrudController $crudController
     * @param AlertService $alertService
     * @param PermissionService $permissionService
     * @param UserService $userService
     * @param SecondaryFormService $secondaryFormService
     */
    public function __construct(
        AdminConfigService $adminConfigService,
        MenuService $menuService,
        CrudController $crudController,
        AlertService $alertService,
        PermissionService $permissionService,
        UserService $userService,
        SecondaryFormService $secondaryFormService
    ) {
        $this->adminConfigService = $adminConfigService;
        $this->menuService = $menuService;
        $this->crudController = $crudController;
        $this->alertService = $alertService;
        $this->permissionService = $permissionService;
        $this->userService = $userService;
        $this->secondaryFormService = $secondaryFormService;
    }

    /**
     * @description Обработка запроса с учетом сложной формы
     * @param $controller
     * @param $action
     * @param array $requestData
     * @return AdminResponseDTO
     * @throws \Exception
     */
    public function processComplexForm($controller, $action, $requestData = [])
    {
        if (
            isset($requestData['post']) &&
            $this->isComplexFormArray($requestData['post'])
        ) {
            foreach ($requestData['post'] as $forms) {
                foreach ($forms as $form) {
                    $formRequest = $requestData;
                    $formRequest['post'] = $form;
                    $response = $this->process($controller, $action, $formRequest);
                }
            }

            return $response;
        }

        return $this->process($controller, $action, $requestData);
    }

    /**
     * @todo refactor
     * @description Основной код обработки запроса на действие
     * @param $controller
     * @param $action
     * @param [] $requestData
     * @return AdminResponseDTO
     * @throws \Exception
     */
    public function process($controller, $action, $requestData = []): AdminResponseDTO
    {
        $user = $this->userService->current();
        $this->permissionService->ensureActionAvailable('admin.access', $user);
        $this->ensureConfigCorrect($controller, $action);

        $handler = $this->config['routes'][$controller][$action]['handler'];
        $response = new AdminResponseDTO('', []);
        $requestData = [
            'get' => $requestData['get'] ?? [],
            'post' => $requestData['post'] ?? [],
            'delete' => $requestData['delete'] ?? [],
        ];

        // Если хэндлер - колбэк, вызываем его
        if (is_callable($handler)) {
            $handlerResponse = $handler($this->getController());

            if (!$handlerResponse instanceof AdminResponseDTO) {
                throw new \Exception('Handler must return AdminResponseDTO');
            }

            $response = $handlerResponse;
        }

        // Если хэндлер - массив, рендерим вид по названию действия
        if (is_array($handler)) {

            if (isset($handler['crud'])) {
                $crudModel = $handler['crud']['model'];
                $crudAction = $handler['crud']['action'];
                $id = $requestData['get']['id'] ?? null;

                $this->permissionService->ensureEntityTypeAvailable($crudModel, $user);

                if (!$id) {
                    $id = $requestData['post']['id'] ?? null;
                }

                switch ($crudAction) {
                    case 'actionList':
                        $defaultOrder = isset($handler['crud']['orderBy']) ?
                            [$handler['crud']['orderBy']['field'] => $handler['crud']['orderBy']['direction']]
                            : [];
                        $filter = $requestData['get']['filter'] ?? [];
                        $order = $requestData['get']['order'] ?? $defaultOrder;
                        $page  = $requestData['get']['page'] ?? 1;
                        $itemPerPage = $requestData['get']['per_page'] ?? 10;
                        $pagination = new Pagination($page, $itemPerPage);

                        if (isset($handler['filter']) && is_callable($handler['filter'])) {
                            $filterCallback = $handler['filter'];
                            $resultFilter = [];

                            foreach ($filter as $filterKey => $filterValue) {
                                $function = $filterCallback($filterKey);
                                $resultFilter[] = [$function, $filterKey, $filterValue];
                            }

                            $filter = $resultFilter;
                        } else {
                            $resultFilter = [];

                            foreach ($filter as $filterKey => $filterValue) {
                                $resultFilter[] = ['=', $filterKey, $filterValue];
                            }

                            $filter = $resultFilter;
                        }

                        if (isset($handler['filter']) && is_array($handler['filter'])) {
                            $filter = array_merge($filter, $handler['filter']);
                        }

                        $response->json['models'] = VirtualModelEntity::allToArray($this->crudController->actionList(
                            $crudModel,
                            $pagination,
                            $filter,
                            $order
                        ));

                        if (isset($handler['list_config'])) {
                            foreach ($handler['list_config'] as $fieldConfig) {
                                if (isset($fieldConfig['value']) && is_callable($fieldConfig['value'])) {
                                    $listConfigCallback = $fieldConfig['value'];
                                    foreach ($response->json['models'] as $modelIndex => $model) {
                                        $response->json['models'][$modelIndex][$fieldConfig['field']] = $listConfigCallback($model);
                                    }
                                }
                            }
                        }

                        if (isset($handler['crud']['orderBy'])) {
                            $response->json['defaultSort'] = $handler['crud']['orderBy'];
                        }

                        $response->json['pagination'] = $pagination;
                        break;
                    case 'actionView':
                        $model = $this->crudController->actionView(
                            $crudModel,
                            $id,
                            $requestData['post']
                        );
                        $handler['item'] = $model;
                        $successMessage = null;
                        $this->permissionService->ensureEntityAvailable($model, $user);

                        try {
                            TransactionVm::begin('secondary');
                            $this->secondaryFormService->processRememberedForm($model);
                            TransactionVm::commit('secondary');
                        } catch (\Exception $exception) {
                            TransactionVm::rollback('secondary');
                            throw $exception;
                        }

                        if (!empty($requestData['post'])) {
                            if ($model instanceof ValidatableVirtualModel && !$model->validate()->isValid()) {
                                $response->json['result'] = false;
                                $response->json['errors'] = $model->getErrors();
                                $this->alertService->error('Не удалось выполнить сохранение');
                            } else {
                                $successMessage = 'Успешно сохранено';
                            }
                        }

                        foreach ($handler as &$handlerItem) {
                            if (is_callable($handlerItem)) {
                                $handlerItem = $handlerItem($model);
                            }
                        }

                        if (!empty($requestData['delete'])) {
                            $model->delete();
                            $response->json['model'] = null;
                            $successMessage = 'Успешно удалено';
                        } else {
                            $response->json['model'] = $model->toArray();
                        }

                        $response->json['detail_config'] = ['no' => 'config'];
                        if (isset($handler['detail_config'])) {
                            $response->json['detail_config'] = $handler['detail_config'];
                        }

                        if ($successMessage) {
                            $this->alertService->success($successMessage);
                        }

                        break;
                }
            }

            $response->jsVars = array_merge($response->json, $handler);
            $response->html = $this->getController()->renderView($action, $handler);
        }

        return $response;
    }

    /**
     * @description Проверка того что объект правильно сконфигурирован
     * @return void
     * @throws \Exception
     */
    public function ensureConfigCorrect($controller, $action)
    {
        if (!$this->controller) {
            throw new \Exception('Controler must be defined in AdminRequestProcessor');
        }

        if (!$this->config) {
            throw new \Exception('Config must be set to AdminRequestProcessor');
        }

        if (!isset($this->config['routes'])) {
            throw new \Exception('Config must have routes');
        }

        if (!isset($this->config['routes'][$controller])) {
            throw new \Exception("No such controller $controller in config");
        }

        if (!isset($this->config['routes'][$controller][$action])) {
            throw new \Exception("No such action $action in controller $controller");
        }

        if (!isset($this->config['routes'][$controller][$action]['handler'])) {
            throw new \Exception("No handler definition in config for controller $controller and action $action");
        }
    }

    /**
     * @return null
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param null $config
     * @return void
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param $dir
     * @return void
     */
    public function loadConfig($dir = null, $afterMerge = null)
    {
        if ($dir) {
            $this->setConfig($this->adminConfigService->loadConfigs($dir));
        } else {
            $config = [];

            foreach ($this->routeLoaders as $routeLoader) {
                if (method_exists($routeLoader, 'changeExistedRoutes')) {
                    $routeLoader->changeExistedRoutes($config);
                }
                $config = AdminConfigService::merge($config, $routeLoader->routesData());
            }

            $this->setConfig($config);
        }

        if ($afterMerge && is_callable($afterMerge)) {
            $config = call_user_func($afterMerge, $config);
            $this->setConfig($config);
        }

        $this->menuService->processConfig($this->getConfig());
    }

    /**
     * @param AdminRoutesLoaderInterface $routesLoader
     * @return AdminRequestProcessor
     */
    public function addRoutesLoader(AdminRoutesLoaderInterface $routesLoader)
    {
        $this->routeLoaders[] = $routesLoader;

        return $this;
    }

    /**
     * @return AdminControllerInterface
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param AdminControllerInterface $controller
     */
    public function setController(AdminControllerInterface $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menuService->getMenu();
    }

    /**
     * Определяет является ли массив массивом данных от сложной формы
     * @param $array
     * @return bool
     */
    private function isComplexFormArray($array)
    {
        foreach ($array as $items) {
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (is_array($item)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }

        return false;
    }
}
