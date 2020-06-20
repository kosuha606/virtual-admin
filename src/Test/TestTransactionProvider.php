<?php

namespace kosuha606\VirtualAdmin\Test;

use kosuha606\VirtualAdmin\Domains\Transaction\TransactionVm;
use kosuha606\VirtualModel\VirtualModelProvider;

class TestTransactionProvider extends VirtualModelProvider
{
    private static $transation;

    public function type()
    {
        return TransactionVm::KEY;
    }

    public function environemnt(): string
    {
        return TransactionVm::KEY;
    }

    protected function findOne($modelClass, $config)
    {
        return null;
    }

    protected function findMany($modelClass, $config)
    {
        return null;
    }

    public static function begin()
    {
        // nothing to do
    }

    public static function commit()
    {
        // nothing to do
    }

    /**
     *
     */
    public static function rollback()
    {
        // nothing to do
    }
}

