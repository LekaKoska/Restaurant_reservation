<?php
namespace App\Repository;

use App\Models\TablesInfoListModel;

class TableInfoRepostory
{


    public function __construct(protected TablesInfoListModel $tableInfoModel)
    {}

    public function checkStatus($request)
    {
     return $this->tableInfoModel->find($request->get('table_id'));
    }

    public function allTablesInfo()
    {
        return $this->tableInfoModel->all();
    }
}
