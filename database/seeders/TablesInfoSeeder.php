<?php

namespace Database\Seeders;

use App\Models\TablesInfoListModel;
use App\Models\TablesModel;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TablesInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $table_nums = range(1, 23);

        foreach ($table_nums as $table_num) {

            if ($table_num >= 1 && $table_num <= 6) {

                $location = TablesInfoListModel::LOCATION[0];
            }
            elseif ($table_num >= 7 && $table_num <= 11) {

                $location = TablesInfoListModel::LOCATION[1];
            }
            elseif ($table_num >= 12 && $table_num <= 17) {

                $location = TablesInfoListModel::LOCATION[2];
            }
            elseif ($table_num >= 18 && $table_num <= 23) {

                $location = TablesInfoListModel::LOCATION[3];
            }


            TablesInfoListModel::create([
                'table_num' => $table_num,
                'location' => $location
            ]);
        }



    }
}
