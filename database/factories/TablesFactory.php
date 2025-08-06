<?php

namespace Database\Factories;

use App\Models\TablesInfoListModel;
use App\Models\TablesModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TablesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TablesModel::class;

    public function definition(): array
    {
        return [
            'guest_number' => $this->faker->numberBetween(1, 9),
            'table_id' => TablesInfoListModel::all()->random()->id,
            'user_id' => User::all()->random()->id
        ];
    }
}
