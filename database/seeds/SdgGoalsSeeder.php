<?php

use App\SdgGoal;
use Illuminate\Database\Seeder;
use App\Imports\SdgGoalsImports;

class SdgGoalsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SdgGoal::truncate();
        (new SdgGoalsImports)->import('sdgs.csv', 'local', \Maatwebsite\Excel\Excel::CSV);
    }
}
