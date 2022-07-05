<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('banks')->truncate();

        $banks = [
            'Swedbank',
            'Lietuvos bankas',
            'SEB',
            'Luminor',
            'Šiaulių bankas',
            'Citadele',
            'Medicinos bankas'
        ];

        foreach ($banks as $bank) {
            DB::table('banks')->insert([
                'name' => $bank
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
