<?php

namespace kosuha606\VirtualAdmin\Domains\Sitemap;

use kosuha606\VirtualModel\VirtualModelEntity;

/**
 * @property SitemapItemDto[] $items
 * @method static getSitemapContent()
 */
class SitemapVm extends VirtualModelEntity
{
    public static function providerType()
    {
        return SitemapProviderInterface::class;
    }

    public function attributes(): array
    {
        return [
            'items',
        ];
    }

    public function addItem(SitemapItemDto $dto)
    {
        if (!isset($this->attributes['items'])) {
            $this->attributes['items'] = [];
        }

        $this->attributes['items'][] = $dto;
    }
}