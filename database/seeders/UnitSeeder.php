<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('units')->truncate();

        $units = [
            ['name' => 'Vienetai', 'sign' => 'vnt.'],
            ['name' => 'Valandos', 'sign' => 'val.'],
            ['name' => 'Dienos', 'sign' => 'd'],
            ['name' => 'Mėnesiai', 'sign' => 'mėn'],
            ['name' => 'Metrai', 'sign' => 'm'],
            ['name' => 'Kvadratiniai metrai', 'sign' => 'm²'],
            ['name' => 'Kubiniai metrai', 'sign' => 'm³'],
            ['name' => 'Kilometrai', 'sign' => 'km'],
            ['name' => 'Gramai', 'sign' => 'g'],
            ['name' => 'Kilogramai', 'sign' => 'kg'],
            ['name' => 'Litrai', 'sign' => 'l'],
        ];

        foreach ($units as $unit) {
            DB::table('units')->insert([
                'name' => $unit['name'],
                'sign' => $unit['sign']
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
