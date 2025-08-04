<?php

namespace Tests\Feature;

use App\Models\TablesInfoListModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableTest extends TestCase
{
    use RefreshDatabase;

    public function test_retrieve_all_tables()
    {
        TablesInfoListModel::create([

            'table_num' => 1,
            'location' => 'north',
            'status' => 'available'
        ]);

        $response = $this->get('/api/tables');

        $response->assertStatus(200);
        $response->assertJsonFragment([

            'table_id' => 1,
            'location' => 'north',
            'status' => 'available'
        ]);
    }

    public function test_login_user_can_make_reservation()
    {
        $user = User::factory()->create();
        $table = TablesInfoListModel::create(
            [
                'table_num' => 1,
                'location' => 'north',
                'status' => TablesInfoListModel::STATUS_AVAILABLE
            ]);



        $response = $this->actingAs($user)->postJson('api/reservation/',
            [
                'user_id' => $user->id,
                'guest_number' => 3,
                'table_id' => $table->id
            ]);


        $response->assertCreated();

        $this->assertDatabaseHas('tables',
            ['user_id' => $user->id]);



    }

    public function test_user_can_have_only_one_reservation()
    {
        $user = User::factory()->create();

        $tableInfo = TablesInfoListModel::create(
            [
                'table_num' => 3,
                'location' => 'south',
                'status' => TablesInfoListModel::STATUS_AVAILABLE
            ]);



        $response = $this->actingAs($user)->postJson('api/reservation/',
            [
                'guest_number' => 3,
                'table_id' => $tableInfo->id,
                'user_id' => $user->id
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('tables', ['user_id' => $user->id]);



        $response = $this->actingAs($user)->postJson('api/reservation/',
            [
                'guest_number' => 3,
                'table_id' => $tableInfo->id,
                'user_id' => $user->id
            ]);

        $response->assertStatus(403);



        $response->assertJson(['message' => 'You already have reservation']);

    }


    public function test_unauthenticated_user_cannot_make_reservation()
    {

        $table = TablesInfoListModel::create(
            [
                'table_num' => 1,
                'location' => 'north',
                'status' => TablesInfoListModel::STATUS_AVAILABLE
            ]);
        $response = $this->postJson('/api/reservation/',
            [
                'guest_number' => 3,
                'table_id' => $table->id

            ]);

        $response->assertUnauthorized();

        $response->assertJson(
            [
                'message' => 'Unauthenticated.'
            ]);
    }
}
