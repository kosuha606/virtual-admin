<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualAdmin\Domains\Search\SearchableInterface;
use kosuha606\VirtualAdmin\Domains\Search\SearchIndexInfoDTO;
use kosuha606\VirtualAdmin\Domains\Search\SearchProviderInterface;
use kosuha606\VirtualAdmin\Domains\Search\SearchVm;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class TestSearchProvider extends MemoryModelProvider implements SearchProviderInterface
{
    public function type()
    {
        return SearchVm::KEY;
    }

    public function createIndex($caller, SearchableInterface $model)
    {
        // TODO: Implement createIndex() method.
    }

    public function indexInfo($caller): SearchIndexInfoDTO
    {
        return new SearchIndexInfoDTO(0);
    }

    public function index($caller, SearchableInterface $model)
    {
        // nothing
    }

    public function batchIndex($caller, $models)
    {
        // nothing
    }

    public function removeIndex($caller,SearchableInterface $model)
    {
        // nothing
    }

    public function search($caller, $text)
    {
        // nothing
    }

    public function advancedSearch($caller, $config)
    {
        // nothing
    }

    public function reindexAll($caller)
    {
        // TODO: Implement reindexAll() method.
    }

}