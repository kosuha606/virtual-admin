<?php

namespace kosuha606\VirtualAdmin\Controllers;

use kosuha606\VirtualAdmin\Domains\Transaction\TransactionVm;
use kosuha606\VirtualAdmin\Classes\Pagination;
use kosuha606\VirtualModel\VirtualModelEntity;

class CrudController
{
    /**
     * @param $modelClass
     * @param int $page
     * @param array $filter
     * @return array
     * @throws \Exception
     */
    public function actionList($modelClass, Pagination $pagination, $filter = [], $orderBy = [])
    {
        try {
            $total = $modelClass::count([
                'where' => $filter
            ]);
            $pagination->totals = $total;
        } catch (\Exception $exception) {
            $pagination->totals = 999;
        }

        /** @var VirtualModelEntity $modelClass */
        $models = $modelClass::many([
            'where' => $filter,
            'orderBy' => $orderBy,
            'limit' => $pagination->getLimit(),
            'offset' => $pagination->getOffset(),
        ]);

        return $models;
    }

    /**
     * @param $modelClass
     * @param $id
     * @return VirtualModelEntity
     * @throws \Exception
     */
    public function actionView($modelClass, $id, $data = [])
    {
        /** @var VirtualModelEntity $modelClass */
        $model = $modelClass::one([
            'where' => [
                ['=', 'id', $id]
            ]
        ]);

        if ($data) {
            $model = $this->actionEdit($modelClass, $data, $id);
        }

        return $model;
    }

    /**
     * @param $modelClass
     * @param $data
     * @param null $id
     * @return |null
     * @throws \Exception
     */
    public function actionEdit($modelClass, $data, $id=null)
    {
        $model = null;

        try {
            TransactionVm::begin('crud_edit');

            /** @var VirtualModelEntity $modelClass */
            if ($id) {
                $model = $modelClass::one([
                    'where' => [
                        ['=', 'id', $id]
                    ]
                ]);
                foreach ($data as $field => $value) {
                    if (!$model->hasAttribute($field)) {
                        continue;
                    }
                    $model->setAttribute($field, $value);
                }
            } else {
                $model = $modelClass::create($data);
            }
            $model->save();

            TransactionVm::commit('crud_edit');
        } catch (\Exception $exception) {
            TransactionVm::rollback('crud_edit');
            throw $exception;
        }

        return $model;

    }
}