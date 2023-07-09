<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends CoreModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function setQuery($query, $values, $column, $notFoundHandler = null) {
        if (isset($values[$column]) && is_numeric($values[$column])) {
            $query->where($column, '=', $values[$column]);
        } else if ($notFoundHandler != null) {
            $notFoundHandler($query);
        }
    }

    protected static function setPaginateIfNeeded($query, $values, $defaultKey)
    {
        $result = null;

        if (is_per_page_set($values)) {
            $result = $query->simplePaginate($values['per_page']);
        } else {
            $result = [$defaultKey => $query->get()];
        }

        return $result;
    }

    protected static function setWhereIdIfNeeded($query, $values, $id)
    {
        if (isset($values[$id])) {
            $query->where($id, '=', $values[$id]);
        }
    }

    protected static function setMultipleWhereIdIfNeeded($query, $values, $id)
    {
        if (isset($values[$id])) {
            $ids = explode(',', $values[$id]);

            $query->where(function($query) use ($id, $ids) {
                foreach ($ids as $idToCompare) {
                    $query->orWhere($id, '=', $idToCompare);
                }
            });
        }
    }
}
