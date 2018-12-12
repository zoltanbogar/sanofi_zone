<?php

use Illuminate\Database\Seeder;
use App\Site;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Site::truncate();

        Site::create([
            'name' => "Veres"
        ]);
        Site::create([
            'name' => "Csanyikvölgy"
        ]);
        Site::create([
            'name' => "Újpest"
        ]);
        Site::create([
            'name' => "Kábszer raktár",
            'parent_id' => 1
        ]);
        Site::create([
            'name' => "Gyógyszer raktár",
            'parent_id' => 1
        ]);
        Site::create([
            'name' => "Étkező",
            'parent_id' => 2
        ]);
        Site::create([
            'name' => "Folyosó",
            'parent_id' => 4
        ]);
    }
}
