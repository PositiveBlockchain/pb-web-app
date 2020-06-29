@extends('layouts.app')
@section('content')
    <div class="container mx-auto">
        <div class="flex items-center">
            <div class="md:w-full md:mx-auto">

                @if (session('status'))
                    <div
                        class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"
                        role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="font-semibold text-gray-700 py-3 px-6 mb-0 text-center">
                    <h1 class="text-2xl font-bold mb-5 text-gray-800">Sustainable Development Goals</h1>
                    <p>The mapping of the SDG goals with the projects is still in development mode.</p>
                </div>
                <div class="w-full p-6">
                    <sdg-list></sdg-list>
                    <div class="separator m-10"></div>
                    <projects-all-list></projects-all-list>
                </div>
            </div>
        </div>
    </div>
@endsection
