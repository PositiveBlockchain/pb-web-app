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
                    List of 50 recently added or updated projects
                </div>

                <div class="w-full p-6">
                    <projects-active-list></projects-active-list>
                </div>
            </div>
        </div>
    </div>

@endsection
