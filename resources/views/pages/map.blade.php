@extends('layouts.app')
@section('content')
    <div class="container mx-auto">
        <h1 class="text-center font-bold text-2xl mb-2 text-gray-800">Global Social Impact Map</h1>
        <p class="text-center mb-5"><br> Click on a marker to get more details about the project.</p>

        <div class="flex items-center">

            <div class="md:w-full md:mx-auto">
                <project-map>

                </project-map>
            </div>
        </div>
        <p class="text-sm mt-2">The map tiles are provided by <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>.
            The performance can a bit slow, as the markers take a bit longer to be rendered. In another version markers
            will be clustered.</p>
    </div>
@endsection
