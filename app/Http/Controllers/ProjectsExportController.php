<?php

namespace App\Http\Controllers;

use App\ProjectsExporter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProjectsExportController extends Controller {

    public function __invoke(Request $request)
    {
        if ($request->exists('download') && $request->get('download') === env('EXPORT_KEY')) {
            return Excel::download(new ProjectsExporter(), 'pb-projects.xlsx');
        }
        abort(Response::HTTP_UNAUTHORIZED, 'Not allowed');
    }

}
