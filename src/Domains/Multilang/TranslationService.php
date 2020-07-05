<?php

namespace kosuha606\VirtualAdmin\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\ServiceManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Multilang
 */
class TranslationService
{
    public $enableAutoTranslate = true;

    public $sourceLang = 'ru';

    public $autoTranslateLimit = 10;

    public $autoTranslateRequestsCount = 0;

    /** @var AutoTranslatorProviderInterface */
    private $autoTranslateProvider;

    public function __construct()
    {
        $this->autoTranslateProvider = VirtualModelManager::getInstance()->getProvider(AutoTranslatorProviderInterface::class);
    }

    public function translate($value)
    {
        try {
            $staticTranslation = StaticTranslationVm::one([
                'where' => [
                    ['=', 'value', $value]
                ]
            ]);

            if (!$staticTranslation->id) {
                $staticTranslation = StaticTranslationVm::create([
                    'value' => $value
                ]);
                $ids = $staticTranslation->save();
                $staticTranslation->id = $ids[0];
            }

            $result = $staticTranslation->langAttribute('value');
        } catch (\Exception $exception) {
            $result = '';
        }

        return $result;
    }

    /**
     * @param VirtualModel $model
     * @param $field
     * @param LangVm $langVm
     * @return string|null
     * @throws \ErrorException
     * @throws \Exception
     */
    public function autoTranslate(VirtualModel $model, $field, LangVm $langVm)
    {
        if ($this->autoTranslateRequestsCount >= $this->autoTranslateLimit) {
            return '';
        }

        $translated = $this->autoTranslateProvider->autoTranslate($this->sourceLang, $langVm->code, $model->$field);
        $this->autoTranslateRequestsCount++;

        TranslationVm::create([
            'entity_id' => $model->id,
            'entity_class' => get_class($model),
            'lang_id' => $langVm->id,
            'attribute' => $field,
            'data' => $translated,
        ])->save();

        return $translated;
    }

}