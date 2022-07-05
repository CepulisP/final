<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('currencies')->truncate();

        $currencies = [
            ['name' => 'Euras', 'sign' => '€'],
            ['name' => 'Doleris', 'sign' => '$'],
        ];

        foreach ($currencies as $currency) {
            DB::table('currencies')->insert([
                'name' => $currency['name'],
                'sign' => $currency['sign']
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
