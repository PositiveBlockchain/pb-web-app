<?php

namespace App\Http\Controllers;

use App\SdgGoal;
use Illuminate\Http\Request;

class SdgGoalsApiController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SdgGoal::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\SdgGoal $sdgGoal
     * @return \Illuminate\Http\Response
     */
    public function show(SdgGoal $sdgGoal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\SdgGoal $sdgGoal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SdgGoal $sdgGoal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SdgGoal $sdgGoal
     * @return \Illuminate\Http\Response
     */
    public function destroy(SdgGoal $sdgGoal)
    {
        //
    }
}
