<?php

namespace Pableiros\BaseFoundationLaravel\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class CoreModel extends Model
{
    protected $hidden = ['pivot', 'created_at', 'updated_at', 'deleted_at'];

    public function __construct(array $attributes = [])
    {
        parent::__construct(...func_get_args());
    }

    public static function table()
    {
        return with(new static)->table;
    }

    public static function insertAll(array $items, $casts = [])
    {
        $now = \Carbon\Carbon::now();
        $encryptValuesRequired = count($casts) > 0;

        $items = collect($items)->map(function (array $data) use ($now, $encryptValuesRequired, $casts) {
            if ($encryptValuesRequired) {
                foreach ($data as $key => $value) {
                    if (isset($casts[$key]) && $casts[$key] == 'encrypted') {
                        $data[$key] = Crypt::encryptString($value);
                    }
                }
            }

            return array_merge([
                'created_at' => $now,
                'updated_at' => $now,
            ], $data);
        })->all();

        return DB::table(static::table())->insert($items);
    }

    public static function resetAutoincrement($tableName = null)
    {
        if ($tableName == null) {
            $tableName = static::table();
        }

        $max = DB::table($tableName)->max('id') + 1;
        DB::statement('ALTER SEQUENCE ' . $tableName . '_id_seq RESTART WITH ' . $max);
    }

    public static function performSafeTruncate()
    {
        $all = static::withTrashed()->get();

        foreach ($all as $item) {
            $item->forceDelete();
        }

        static::resetAutoincrement();
    }

    protected static function decrypt($value)
    {
        return Crypt::decryptString($value);
    }

    protected static function decryptArray($array, $properties)
    {
        foreach ($array as $content) {
            foreach ($properties as $property) {
                $content->{$property} = self::decrypt($content->{$property});
            }
        }

        return $array;
    }

    protected function getCountFromTable($table, $extraQueryFunc)
    {
        $query = DB::table($table)->selectRaw('count(*) as count');

        if ($extraQueryFunc != null) {
            $query = $extraQueryFunc($query);
        }

        $result = $query->first();
        return $result->count;
    }

    protected function removeManyToMany($class, $count, $foreignId)
    {
        if ($count > 0) {
            $class::where($foreignId, '=', $this->id)->forceDelete();
        }
    }
}
