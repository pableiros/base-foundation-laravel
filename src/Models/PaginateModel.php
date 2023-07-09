<?php

namespace Pableiros\BaseFoundationLaravel\Models;

class PaginateModel extends BaseModel
{
    public static function getName()
    {
    }

    public static function getAll($values)
    {
        $query = self::getInstanceWithColumns($values);
        return self::setPaginateIfNeeded($query, $values, static::getName());
    }

    public static function getTotalPaginas($values)
    {
        $totalPaginas = 0;

        if (is_per_page_set($values)) {
            $paginate = static::getInstanceWithColumns($values)->paginate($values['per_page']);
            $totalPaginas = $paginate->lastPage();
        }

        return ['total_paginas' => $totalPaginas];
    }
}