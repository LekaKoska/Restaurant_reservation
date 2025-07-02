<?php
namespace App\Repository;

use App\Models\TablesInfoListModel;

class TableInfoRepostory
{
    private $tableInfoModel;

    public function __construct()
    {
        $this->tableInfoModel = new TablesInfoListModel();
    }

    public function checkStatus($request)
    {
     return $this->tableInfoModel->find($request->get('table_id'));
    }


}
