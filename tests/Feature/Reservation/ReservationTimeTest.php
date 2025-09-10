<?php

namespace Tests\Feature\Reservation;

use App\Models\TablesInfoListModel;
use App\Models\TablesModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTimeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_without_reservation_cannot_add_time()
    {
        $user = User::factory()->create();
        $tableInfo = TablesInfoListModel::factory()->create();

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
        $tableInfo = TablesInfoListModel::factory()->create();
        $tableRes = TablesModel::factory()->create();

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
        $tableInfo = TablesInfoListModel::factory()->create();
        $tableRes = TablesModel::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/reservation/time/'. $user->id,
            [
                'user_id' => $user->id,
                'table_id' => $tableRes->id,
                'reservation_date' => '2025-02-06 19:00:00'
            ]);

        $response->assertStatus(201);
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
