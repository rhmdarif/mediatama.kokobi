<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Factory::create('id_ID');

        for ($i=0; $i < 10; $i++) {
            DB::table('topics')
                ->insert([
                    'user_id' => 1,
                    'group_id' => 1,
                    'title' => $faker->sentence(13),
                    'body' => implode('\n\r', $faker->paragraphs(6)),
                    'like_count' => rand(0, 50),
                    'share_count' => rand(1, 20),
                    'created_at' => date("Y-m-d H:i:s")
                ]);
        }
    }
}
