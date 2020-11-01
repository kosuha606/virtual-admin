<?php

namespace kosuha606\VirtualAdmin\Form;

use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModelHelppack\ServiceManager;

class SecondaryFormBuilder
{
    const ONE_TO_ONE = 'one.to.one';

    const ONE_TO_MANY = 'one.to.many';

    /** @var int  */
    private $id;

    /** @var bool  */
    private $viewOnly = false;

    /** @var mixed */
    private $masterMmodel;

    /** @var mixed */
    private $masterModelId;

    /** @var mixed */
    private $masterModelField;

    /** @var mixed */
    private $relationType;

    /** @var array */
    private $relationEntities = [];

    /** @var mixed */
    private $relationClass;

    /** @var string */
    private $tabName = 'Tab';

    /** @var mixed */
    private $config;

    /** @var SecondaryFormService */
    private $formService;

    /** @var StringService */
    private $stringService;

    /**
     * @param SecondaryFormService $formService
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(
        SecondaryFormService $formService
    ) {
        $this->formService = $formService;
        $this->id = $this->formService->getFormTypeCounter();
        $this->stringService = ServiceManager::getInstance()->get(StringService::class);
    }

    /**
     * @return VirtualModelEntity
     */
    public function getMasterModel()
    {
        return $this->masterMmodel;
    }

    /**
     * @param VirtualModelEntity $model
     * @return SecondaryFormBuilder
     */
    public function setMasterModel($model)
    {
        $this->masterMmodel = $model;
        $this->formService->loadWorkModel($model);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * @param mixed $relationType
     * @return SecondaryFormBuilder
     */
    public function setRelationType($relationType)
    {
        $this->relationType = $relationType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTabName()
    {
        return $this->tabName;
    }

    /**
     * @param string $tabName
     * @return SecondaryFormBuilder
     */
    public function setTabName($tabName)
    {
        $this->tabName = $tabName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInitialConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $initialConfig
     * @return SecondaryFormBuilder
     */
    public function setConfig($initialConfig)
    {
        $this->config = $initialConfig;

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getConfig()
    {
        $this->formService->rememberForm($this);
        $items = [];
        $initialConfig = $this->getInitialConfig();
        $relationClass = $this->getRelationClass();

        $initialConfigData = $initialConfig(new $relationClass());

        foreach ($this->getRelationEntities() as $entity) {
            $items[] = $initialConfig($entity);
        }

        if (
            $this->getRelationType() === self::ONE_TO_ONE &&
            count($items) === 0
        ) {
            $items[] = $initialConfigData;
        }

        return [
            'tab' => $this->getTabName(),
            'tabLink' => $this->stringService->transliterate($this->getTabName()),
            'type' => $this->getRelationType(),
            'initialConfig' => $initialConfigData,
            'relationClass' => $this->getRelationClass(),
            'dataConfig' => $items,
            'isViewOnly' => $this->isViewOnly(),
        ];
    }

    /**
     * @return array
     */
    public function getRelationEntities(): array
    {
        return $this->relationEntities;
    }

    /**
     * @param array $relationEntities
     * @return SecondaryFormBuilder
     */
    public function setRelationEntities(array $relationEntities)
    {
        $this->relationEntities = $relationEntities;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelationClass()
    {
        return $this->relationClass;
    }

    /**
     * @param mixed $relationClass
     * @return SecondaryFormBuilder
     */
    public function setRelationClass($relationClass)
    {
        $this->relationClass = $relationClass;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMasterModelField()
    {
        return $this->masterModelField;
    }

    /**
     * @param mixed $masterModelField
     * @return SecondaryFormBuilder
     */
    public function setMasterModelField($masterModelField)
    {
        $this->masterModelField = $masterModelField;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMasterModelId()
    {
        return $this->masterModelId;
    }

    /**
     * @param mixed $masterModelId
     * @return SecondaryFormBuilder
     */
    public function setMasterModelId($masterModelId)
    {
        $this->masterModelId = $masterModelId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isViewOnly(): bool
    {
        return $this->viewOnly;
    }

    /**
     * @param bool $viewOnly
     * @return SecondaryFormBuilder
     */
    public function setViewOnly(bool $viewOnly): SecondaryFormBuilder
    {
        $this->viewOnly = $viewOnly;

        return $this;
    }
}
