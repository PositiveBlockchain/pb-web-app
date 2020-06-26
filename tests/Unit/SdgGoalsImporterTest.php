<?php


namespace Tests\Unit;


use App\Imports\SdgGoalsImports;
use App\SdgGoal;
use Maatwebsite\Excel\Importer;
use Tests\TestCase;

class SdgGoalsImporterTest extends TestCase {

    public function testIfSdgCsvFileExists()
    {
        $this->assertFileExists(storage_path('app/sdgs.csv'));
    }

    public function testToImportSdgGoalsFromCSV()
    {
        SdgGoal::truncate();
        $importer = (new SdgGoalsImports())->import('sdgs.csv', 'local', \Maatwebsite\Excel\Excel::CSV);
        $this->assertInstanceOf(Importer::class, $importer);
        $this->assertDatabaseHas('sdg_goals', [
            'goal_number' => '17',
        ]);
    }

}
