<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 50) as $index) {

            // Sugeneruojama ar užsakymas bus skubus ar ne
            $random = rand(0 ,1);
            if($random == 0)
                $is_fast = 'on';
            else
                $is_fast = 'off';

            DB::table('orders')->insert([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'email' => $faker->email,
                'adress' => $faker->streetName,
                'city' => $faker->city,
                'created_at' => $faker->date($format = 'Y-m-d', $max = 'now') ,
                'is_fast' => $is_fast

            ]);
        }
    }
}