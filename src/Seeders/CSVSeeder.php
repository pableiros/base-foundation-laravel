<?php

namespace Pableiros\BaseFoundationLaravel\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class CSVSeeder extends Seeder
{
    abstract protected function getCSVName();
    abstract protected function getTableName();
    abstract protected function getInsert($array);

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path('csv/' . $this->getCSVName());
        $csv = fopen($filename, 'r');
        $tableName = $this->getTableName();

        while(($array = fgetcsv($csv, 200, ',')) != false) {
            $exists = DB::table($tableName)
                ->where(['id' => $array[0]])
                ->first() != null;

            if ($exists == false) {
                $insert = $this->getInsert($array);
                $insert = array_merge($insert,
                    [
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ]
                );

                DB::table($tableName)->insert($insert);
            }
        }
    }
}
