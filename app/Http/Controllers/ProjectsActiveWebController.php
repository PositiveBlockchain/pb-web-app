<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectsActiveWebController extends Controller {

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        return view('projects.projects-active');
    }
}
