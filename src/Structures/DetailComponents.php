<?php

namespace kosuha606\VirtualAdmin\Structures;

use kosuha606\VirtualAdmin\Form\SecondaryFormBuilder;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Domains\Multilang\LangVm;
use kosuha606\VirtualAdmin\Domains\Multilang\TranslationVm;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModelHelppack\ServiceManager;

/**
 * @package kosuha606\VirtualAdmin\Services
 */
class DetailComponents
{
    /** @var LangVm[] */
    private static $langs;

    private static $translationForms = [];

    const INPUT_FIELD = 'InputField';

    const PASSWORD_FIELD = 'PasswordField';

    const HTML_FIELD = 'HtmlField';

    const HIDDEN_FIELD = 'HiddenField';

    const TEXTAREA_FIELD = 'TextField';

    const SELECT_FIELD = 'SelectField';

    const CHECKBOX_FIELD = 'CheckboxField';

    const REDACTOR_FIELD = 'RedactorField';

    const IMAGE_FIELD = 'ImageField';

    const CONFIG_BUILDER_FIELD = 'ConfigBuilderField';

    const VERSION_FIELD = 'VersionField';

    /**
     * @param $component
     * @param $field
     * @param $label
     * @param $value
     * @return array
     * @throws \Exception
     */
    public static function MULTILANG_FIELD(
        $component,
        $field,
        $label,
        $value,
        $model
    ) {
        if (!self::$langs) {
            self::$langs = VirtualModelEntity::allToArray(LangVm::many(['where' => [['all']]]));
        }

        $modelClass = get_class($model);
        if (!isset(self::$translationForms[$modelClass])) {
            $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);
            $secondaryService->buildForm()
                ->setMasterModelId($model->id.','.get_class($model))
                ->setMasterModel($model)
                ->setMasterModelField('entity_id,entity_class')
                ->setRelationClass(TranslationVm::class)
                ->setConfig(function ($model) {})
                ->getConfig()
            ;

            self::$translationForms[$modelClass] = true;
        }

        $existedItems = [];
        $translations = VirtualModelEntity::allToArray(TranslationVm::many([
            'where' => [
                ['=', 'entity_id', $model->id],
                ['=', 'entity_class', $modelClass],
                ['=', 'attribute', $field],
            ]
        ]));

        foreach ($translations as $translation) {
            $translationData = [];
            foreach ($translation as $translationAttribute => $translationValue) {
                $translationData[] = [
                    'field' => $translationAttribute,
                    'value' => $translationValue
                ];
            }

            $existedItems[] = $translationData;
        }

        $k = 1;

        return [
            'field' => $field,
            'label' => $label,
            'component' => 'MultilangField',
            'value' => $value,
            'additionalValues' => [
                'items' => $existedItems,
                'relationClass' => TranslationVm::class
            ],
            'props' => [
                'relationClass' => TranslationVm::class,
                'component' => $component,
                'langs' => self::$langs,
                'entity_id' => $model->id,
                'entity_class' => $modelClass,
            ]
        ];
    }

}
