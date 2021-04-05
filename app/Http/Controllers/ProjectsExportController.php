<?php

namespace App\Http\Controllers;

use App\ProjectsExporter;
use Maatwebsite\Excel\Facades\Excel;

class ProjectsExportController extends Controller {

    public function __invoke()
    {
        return Excel::download(new ProjectsExporter(), 'pb-projects.xlsx');
    }

}
