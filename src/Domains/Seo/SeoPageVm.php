<?php

namespace kosuha606\VirtualAdmin\Domains\Seo;

use kosuha606\VirtualAdmin\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModelEntity;

/**
 *
 * @property $id
 * @property $url
 * @property $entity_id
 * @property $entity_class
 * @property $title
 * @property $meta_keywords
 * @property $mata_description
 * @property $og_title
 * @property $og_description
 * @property $og_url
 * @property $og_image
 * @property $og_type
 * @property $canonical
 * @property $noindex
 * @property $sitemap_importance
 * @property $sitemap_freq
 *
 */
class SeoPageVm extends VirtualModelEntity
{
    use MultilangTrait;

    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'url',
            'title',
            'meta_keywords',
            'mata_description',
            'og_title',
            'og_description',
            'og_url',
            'og_image',
            'og_type',
            'canonical',
            'noindex',
            'sitemap_importance',
            'sitemap_freq',
        ];
    }
}