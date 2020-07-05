<?php

namespace kosuha606\VirtualAdmin\Domains\Design;

use kosuha606\VirtualAdmin\Helpers\ConstructorHelper;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Design
 */
class DesignService
{
    /** @var VirtualModelEntity */
    private $virtualModelEntity = DesignVm::class;

    /**
     * @param VirtualModelEntity $virtualModelEntity
     */
    public function setVirtualModelEntity($virtualModelEntity)
    {
        $this->virtualModelEntity = $virtualModelEntity;
    }

    /**
     * @param $content
     * @return string
     * @throws \Exception
     */
    public function renderDesignForRoute($route, $content)
    {
        $virtualModelEntity = VirtualModelManager::getEntity($this->virtualModelEntity);

        $designs = $virtualModelEntity::many(['where' => [['all']]]);

        /** @var DesignVm $matchedDesign */
        $matchedDesign = null;

        /** @var DesignVm $design */
        foreach ($designs as $design) {
            if (preg_match("/{$design->route}/i", $route)) {
                if (!$matchedDesign) {
                    $matchedDesign = $design;
                } elseif ($matchedDesign->priority < $design->priority) {
                    $matchedDesign = $design;
                }
            }
        }

        if (!$matchedDesign) {
            throw new \Exception('Для текущего роута не найден дизайн');
        }

        /** @var DesignWidgetVm[] $widgets */
        $widgets = VirtualModelManager::getEntity(DesignWidgetVm::class)::many(['where' => [['=', 'design_id', $matchedDesign->id]]]);

        if (method_exists($matchedDesign, 'langAttribute')) {
            $template = $matchedDesign->langAttribute('template');
        } else {
            $template = $matchedDesign->template;
        }
        $positionTemplates = [];

        foreach ($widgets as $designWidget) {
            if (!isset($positionTemplates[$designWidget->position])) {
                $positionTemplates[$designWidget->position] = [];
            }

            $widget = VirtualModelManager::getEntity(WidgetVm::class)::one(['where' => [['=', 'id', $designWidget->widget_id]]]);
            $widgetClass = $widget->widget_class;
            $widgetConfig = json_decode($designWidget->config, true);
            $widgetConfig = $this->normalizeWidgetConfig($widgetConfig);
            $positionTemplates[$designWidget->position][] = [
                'order' => $designWidget->order,
                'content' => $widgetClass::widget($widgetConfig)
            ];
        }

        foreach ($positionTemplates as $position => &$positionTemplate) {
            uasort(
                $positionTemplate,
                function ($a, $b) {
                    return $a['order'] <=> $b['order'];
                }
            );

            foreach ($positionTemplate as $positionTemplateContent) {
                $template = str_replace($position, $positionTemplateContent['content'].$position, $template);
            }

            $template = str_replace($position, '', $template);
        }


        return str_replace('%content%', $content, $template);
    }

    public function normalizeWidgetConfig($widgetConfig)
    {
        return ConstructorHelper::normalizeConfig($widgetConfig);
    }
}