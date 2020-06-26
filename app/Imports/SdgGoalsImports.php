<?php


namespace App\Imports;


use App\SdgGoal;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SdgGoalsImports implements ToModel, WithCustomCsvSettings, WithHeadingRow {

    use Importable;

    /**
     * @param array $row
     * @return SdgGoal|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null
     */
    public function model(array $row)
    {
        return new SdgGoal([
            'goal_number' => $row['goal_number'],
            'goal_name' => $row['goal_name'],
            'goal_icon_path' => asset('storage/icons/' . $row['goal_icon_path']),
            'description' => $row['description'],
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
        ];
    }

}
