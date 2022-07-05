<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('invoice_types')->truncate();

        $types = [
            'Sąskaita faktūra',
            'PVM Sąskaita faktūra',
            'Išankstinė sąskaita faktūra',
            'Kreditinė sąskaita faktūra'
        ];

        foreach ($types as $type) {
            DB::table('invoice_types')->insert([
                'name' => $type
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
