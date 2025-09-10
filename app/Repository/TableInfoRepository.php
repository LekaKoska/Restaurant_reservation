<?php
namespace App\Repository;

use App\Models\TablesInfoListModel;

class TableInfoRepository
{


    public function __construct(protected TablesInfoListModel $tableInfoModel)
    {}

    public function checkStatus($request)
    {
     return $this->tableInfoModel->find($request->get('table_id'));
    }

    public function allTablesInfo(): array
    {
        return $this->tableInfoModel->all()->map(function($table){
            return [
                "table_id" => $table->table_num,
                "location" => $table->location,
                "status" => $table->status
            ];
        })->toArray();
    }
}
