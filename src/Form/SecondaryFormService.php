<?php

namespace kosuha606\VirtualAdmin\Form;

use kosuha606\VirtualAdmin\Services\RequestService;
use kosuha606\VirtualAdmin\Services\SessionService;
use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * Сервис отвечающий за работу с второстепенными формами сущности
 */
class SecondaryFormService
{
    const SESSION_KEY = 'secondary_form';

    private $realSessionKey = self::SESSION_KEY;

    private $isSessionCleared = false;

    private $formTypeCounter = 0;

    /**
     * @var SessionService
     */
    private $sessionService;
    /**
     * @var RequestService
     */
    private $requestService;

    public function __construct(
        SessionService $sessionService,
        RequestService $requestService
    ) {
        $this->sessionService = $sessionService;
        $this->requestService = $requestService;
    }

    /**
     * Построить форму
     * @return SecondaryFormBuilder
     * @throws \Exception
     */
    public function buildForm(VirtualModelEntity $model = null): SecondaryFormBuilder
    {
        if (
            !$this->isSessionCleared
            && !$this->requestService->request()->isPost
            && $model
        ) {
            $this->loadWorkModel($model);
            $this->clearSession();
        }

        return new SecondaryFormBuilder($this);
    }

    /**
     * Запомнить форму
     * @param SecondaryFormBuilder $builder
     * @throws \Exception
     */
    public function rememberForm(SecondaryFormBuilder $builder)
    {
        $formSession = $this->sessionService->get($this->realSessionKey);

        $value = [];
        if ($formSession->value) {
            $value = $formSession->value;
        }

        $modelClass = get_class($builder->getMasterModel());
        $value['baseModelId'] = $builder->getMasterModel()->id;
        $value['baseModelClass'] = $modelClass;

        $value[$builder->getRelationClass()] = [
            'masterModelId' => $builder->getMasterModelId() ?: $builder->getMasterModel()->id,
            'masterModelField' => $builder->getMasterModelField(),
            'masterModelClass' => $modelClass,
            'relationType' => $builder->getRelationType(),
            'viewOnly' => $builder->isViewOnly(),
        ];

        $this->sessionService->save($this->realSessionKey, $value);
    }

    public function loadWorkModel(VirtualModelEntity $modelEntity)
    {
        $modelClassKey = str_replace('\\', '_', get_class($modelEntity));
        $this->realSessionKey = self::SESSION_KEY.'_'.$modelEntity->id.'_'.$modelClassKey;
    }


    /**
     * Выполнить обработку запомненных форм
     * @throws \Exception
     */
    public function processRememberedForm(VirtualModelEntity $model)
    {
        $this->loadWorkModel($model);

        if (!$this->requestService->request()->isPost) {
            $this->sessionService->remove($this->realSessionKey);
            return;
        }

        $postData = $this->requestService->request()->post;
        $sessionConfig = $this->sessionService->get($this->realSessionKey);

        if (isset($postData['id']) && isset($sessionConfig->value['baseModelId'])) {
            if ($postData['id'] !== $sessionConfig->value['baseModelId']) {
                throw new \LogicException('Была открыта другая модель для редактирования, перезагрузите страницу');
            }
        }

        if (!isset($postData[self::SESSION_KEY])) {
            // Если нет данных пищем пустой массив
            $postData[self::SESSION_KEY] = [];

            if (!$sessionConfig->value) {
                return;
            }

            foreach ($sessionConfig->value as $sessClass => $data) {
                $postData[self::SESSION_KEY][$sessClass] = [];
            }
        }

        $secondaryClasses = array_keys($sessionConfig->value);
        unset($secondaryClasses['baseModelId']);
        unset($secondaryClasses['baseModelClass']);

        foreach ($sessionConfig->value as $modelClass => $modelConfig) {
            if (!is_array($modelConfig)) {
                continue;
            }

            if (!isset($postData[self::SESSION_KEY][$modelClass]) && !$modelConfig['viewOnly']) {
                $postData[self::SESSION_KEY][$modelClass] = [];
            }
        }

        /**
         * Создаем новые связанные модели
         * @var VirtualModelEntity $modelClass
         * @var  $data
         */
        foreach ($postData[self::SESSION_KEY] as $modelClass => $data) {
            $sessionModelData = $sessionConfig->value[$modelClass];

            if (
                empty($sessionModelData['masterModelId'])
                || empty($sessionModelData['masterModelField'])
            ) {
                continue;
            }

            $values = explode(',', $sessionModelData['masterModelId']);
            $fields = explode(',', $sessionModelData['masterModelField']);
            $where = [];
            foreach ($values as $index => $value) {
                $where[] = [
                    '=',
                    $fields[$index],
                    $value,
                ];
            }
            /** @var VirtualModelEntity[] $oldModels */
            $oldModels = $modelClass::many(['where' => $where], 'id');

            foreach ($data as $attributes) {
                if (!empty($attributes['id'])) {
                    $model = $modelClass::one(['where' => [['=', 'id', $attributes['id']]]]);
                    $model->setAttributes($attributes);
                    $model->save();
                    unset($oldModels[$attributes['id']]);
                } else {
                    $modelClass::create($attributes)->save();
                }
            }

            foreach ($oldModels as $oldModel) {
                $oldModel->delete();
            }
        }
    }

    /**
     * @return int
     */
    public function getFormTypeCounter(): int
    {
        $this->formTypeCounter++;

        return $this->formTypeCounter;
    }

    /**
     * @param int $formTypeCounter
     */
    public function setFormTypeCounter(int $formTypeCounter)
    {
        $this->formTypeCounter = $formTypeCounter;
    }

    /**
     * @throws \Exception
     */
    public function clearSession()
    {
        $this->isSessionCleared = true;
        $this->sessionService->remove($this->realSessionKey);
    }
}