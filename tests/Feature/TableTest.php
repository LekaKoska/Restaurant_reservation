<?php

namespace Tests\Feature;

use App\Models\ReservationTimeModel;
use App\Models\TablesInfoListModel;
use App\Models\TablesModel;
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



             $this->actingAs($user)->postJson('api/reservation/',
            [
                'user_id' => $user->id,
                'guest_number' => 3,
                'table_id' => $table->id
            ])->assertCreated();



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
            ])->assertStatus(403);

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

    public function test_table_already_taken()
    {
        $user = User::factory()->create();

        $table = TablesInfoListModel::create(
            [
                'table_num' => 3,
                'location' => 'north',
                'status' => TablesInfoListModel::STATUS_TAKEN
            ]);

        $response = $this->actingAs($user)->postJson('/api/reservation/',
            [
                'guest_number' => 3,
                'table_id' => $table->id,

            ])->assertStatus(403);

        $response->assertJson(
            [
                'status' => false,
                'message' => "This table is already taken!"
            ]);

        $this->assertDatabaseMissing('tables',
            [   'user_id' => $user->id,
                'table_id' => $table->id
            ]);

    }

    public function test_user_without_reservation_cannot_add_time()
    {
        $user = User::factory()->create();
        $tableInfo = TablesInfoListModel::create(
            [
                'table_num' => 3,
                'location' => 'north',
                'status' => TablesInfoListModel::STATUS_AVAILABLE
            ]);



       $response = $this->actingAs($user)->postJson('/api/reservation/time/'. $user->id,
            [
                'table_id' => $tableInfo->id,
                'reservation_date' => '2025-07-07 21:00:00'
            ]);

       $response->assertStatus(403);


       $response->assertJson(
           [
               'status' => false,
               'message' => 'You dont have reservation!'
           ]);

        $this->assertDatabaseMissing('reservation', [
            'user_id' => $user->id,
            'table_id' => $tableInfo->id,
            'reservation_date' => '2025-07-07 21:00:00'
        ]);

    }

    public function test_unauthenticated_user_cannot_add_time_to_reservation()
    {

        $user = User::factory()->create();
        $tableInfo = TablesInfoListModel::create(
            [
                'table_num' => 3,
                'location' => 'north',
                'status' => TablesInfoListModel::STATUS_AVAILABLE
            ]);
        $tableRes = TablesModel::create(
            [
                'guest_number' => 4,
                'table_id' => $tableInfo->id,
                'user_id' => $user->id
            ]);

        $response = $this->postJson('/api/reservation/time/'. $user->id,
            [
                'table_id' => $tableRes->id,
                'reservation_date' => '2025-02-06 19:00:00'
            ]);


        $response->assertUnauthorized();

        $response->assertStatus(401);

        $response->assertJson(
            [
                'message' => "Unauthenticated."
            ]);

    }
    public function test_user_with_reservation_adding_time_successfully()
    {
        $user = User::factory()->create();
        $tableInfo = TablesInfoListModel::create(
            [
                'table_num' => 3,
                'location' => 'north',
                'status' => TablesInfoListModel::STATUS_AVAILABLE
            ]);
        $tableRes = TablesModel::create(
            [
                'guest_number' => 4,
                'table_id' => $tableInfo->id,
                'user_id' => $user->id
            ]);

        $response = $this->actingAs($user)->postJson('/api/reservation/time/'. $user->id,
            [
                'table_id' => $tableRes->id,
                'reservation_date' => '2025-02-06 19:00:00'
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('reservation',
            [
                'table_id' => $tableRes->id,
                'reservation_date' => '2025-02-06 19:00:00'
            ]);
        $response->assertJson(
            [
                'status' => true,
                'message' => "Order accepted, check your mail for reservation info"
            ]);

    }

}
