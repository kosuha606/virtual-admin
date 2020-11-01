<?php

namespace kosuha606\VirtualAdmin\Helpers;

class ConstructorHelper
{
    /**
     * @param $widgetConfig
     * @return array|mixed
     */
    public static function normalizeConfig($widgetConfig)
    {
        $result = [];

        if (isset($widgetConfig['value'])) {
            return $widgetConfig['value'];
        }

        if (!is_array($widgetConfig)) {
            return $widgetConfig;
        }

        foreach ($widgetConfig as $value) {
            if (!is_array($value)) {
                return $value;
            }
            $data = json_decode($value['value'], true);
            if (!$data) {
                $result[$value['code']] = $value['value'];
            } else {
                $result[$value['code']] = self::normalizeConfig($data);
            }
        }

        return $result;
    }
}
