<?php

namespace Tables;

use App\Models\TablesInfoListModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableTest extends TestCase
{
    use RefreshDatabase;

    public function test_retrieve_all_tables()
    {
         $tableInfo = TablesInfoListModel::factory()->create();

        $response = $this->getJson('/api/tables');


        $response->assertStatus(200);
        $response->assertJsonFragment([

            'table_id' => $tableInfo->table_num,
            'location' => $tableInfo->location,
            'status' => $tableInfo->status
        ]);
    }


}
