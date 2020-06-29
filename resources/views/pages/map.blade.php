@extends('layouts.app')
@section('content')
    <div class="container mx-auto">
        <h1 class="text-center font-bold text-2xl mb-2">Global Social Impact Map</h1>
        <p class="text-center mb-5">The map loads currently 500 projects from the database. <br>The performance is a bit
            slow, as the markers
            take a bit longer to be rendered. <br> Click on a marker to get more details about the project.</p>

        <div class="flex items-center">

            <div class="md:w-full md:mx-auto">
                <project-map>

                </project-map>
            </div>
        </div>
        <p class="text-sm mt-2">The map tiles are provided by <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>.</p>
    </div>
@endsection
