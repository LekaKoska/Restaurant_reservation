<?php
namespace App\Repository;

use App\Models\TablesInfoListModel;
class TableInfoRepository
{
    public function __construct(protected TablesInfoListModel $tableInfoModel)
    {}
    public function checkStatus($request)
    {
     return $this->tableInfoModel->where('id', $request->get('table_id'))->lockForUpdate()->first();
    }
    public function allTablesInfo(): array
    {
        return $this->tableInfoModel->orderBy("table_num")->paginate()->toArray();

    }
}
