<?php

use Illuminate\Database\Seeder;
use App\Zone;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Zone::create([
            'name' => "Veszélyzóna",
            'site_id' => 1
        ]);
        Zone::create([
            'name' => "Nagyon veszélyes zóna",
            'site_id' => 4
        ]);
        Zone::create([
            'name' => "Nem veszélyes zóna",
            'site_id' => 7
        ]);
    }
}
