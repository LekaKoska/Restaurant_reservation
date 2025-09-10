<?php

namespace Tests\Feature\Reservation;

use App\Models\TablesInfoListModel;
use App\Models\TablesModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_login_user_can_make_reservation()
    {
        $user = User::factory()->create();

        $table = TablesInfoListModel::factory()->create();

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

        $tableInfo = TablesInfoListModel::factory()->create();

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

        $table = TablesInfoListModel::factory()->create();

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

        $table = TablesInfoListModel::factory()->taken()->create();

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

    public function test_unverified_email_user_cannot_add_reservation()
    {
        $user = User::factory()->unverified()->create();
        $tableInfo = TablesInfoListModel::factory()->create();
        $response = $this->actingAs($user)->post('/api/reservation/',
            [
                'table_id' => $tableInfo->id,
                'guest_number' => 4
            ])->assertStatus(403);

        $response->assertJson([
            'message' => 'Email not verified'
        ]);
        $this->assertDatabaseMissing('tables',
            [
                'user_id' => $user->id
            ]);
    }

    public function test_invalid_id_for_deleting_reservation()
    {
        $user = User::factory()->create();
        $table = TablesInfoListModel::factory()->create();
        $reservation = TablesModel::factory()->create(
            [
                'guest_number' => 3,
                'table_id' => $table->id,
                'user_id' => $user->id
            ]);
                                                                                    // invalid id
        $response = $this->actingAs($user)->deleteJson('/api/reservation/delete/' . 55)->assertStatus(403);

        $response->assertJsonFragment(
            [
                'status' => false
            ]);



    }

    public function test_deleting_reservation_successfully()
    {
        $user = User::factory()->create();
        $table = TablesInfoListModel::factory()->create();
        $reservation = TablesModel::factory()->create(
            [
                'guest_number' => 3,
                'table_id' => $table->id,
                'user_id' => $user->id
            ]);

        $response = $this->actingAs($user)->deleteJson('/api/reservation/delete/' . $user->id)->assertStatus(200);

        $response->assertJsonFragment(
            [
                'status' => true,
                'message' => "Your reservation has been canceled"
            ]);

    }

}
