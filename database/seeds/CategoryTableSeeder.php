<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $categories = ["culture", "events", "history", "monuments", "nature", "nightlife", "people", "places"];
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'category_name' => $category
            ]);
        }
    }
}
