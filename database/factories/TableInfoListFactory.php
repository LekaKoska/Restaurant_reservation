<?php

namespace Database\Factories;

use App\Models\TablesInfoListModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TableInfoListFactory extends Factory
{
   
     protected $model = TablesInfoListModel::class;
    public function definition(): array
    {
        $location = ['north', 'east', 'west', 'south'];
        return [
            'table_num' => $this->faker->numberBetween(1, 23),
            'location' => $this->faker->randomElement($location),
        ];
    }
}
