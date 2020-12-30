<nav class="bg-gray-900 shadow mb-8 py-6">
    <div class="container mx-auto px-6 md:px-0">
        <div class="flex items-center justify-center">
            <div class="mr-6">
                <a href="{{config('app.url')}}" class="text-lg font-semibold text-gray-100 no-underline">
                    <img class="inline-block" width="50" src="{{asset('pb-sdg-logo.png')}}"
                         alt="Positive Blockchain SDG Logo"> Impact Dashboard
                </a>
            </div>
            <div class="flex-1 text-right">
                <a class="no-underline hover:underline text-gray-300 text-sm p-3"
                   href="{{route('web.projects.active')}}" title="Top active projects">Top 50 Active Projects</a>
                <a class="no-underline hover:underline text-gray-300 text-sm p-3"
                   href="{{route('web.sdgs')}}" title="Sdgs">Sdgs</a>
                <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{route('web.welcome')}}"
                   title="All Projects">All Projects</a>
                <a class="no-underline hover:underline text-gray-300 text-sm p-3" href="{{route('web.map')}}"
                   title="Display all projects on a map">Map</a>
            </div>
        </div>
    </div>
</nav>
