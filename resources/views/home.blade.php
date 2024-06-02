@extends('layouts.app')

@section('title', 'PLELIX')

@section('content')

<div class="container mx-auto mt-12">
    <div class="text-center">
        <img src="/images/plelix.png" alt="PLELIX" class="rounded-full mx-auto w-60">
    </div>

    <div class="mb-8">
        <h2 class="text-3xl font-bold mb-4">PELÍCULAS DESTACADAS</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($movies as $movie)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg bg-yellow-100">
                    <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-bold">{{ $movie['title'] }}</h3>
                        <p class="mt-2 text-gray-600">{{ \Illuminate\Support\Str::limit($movie['overview'], 50) }}</p>
                        <a href="{{ route('movie.show', $movie['id']) }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Ver más</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-8">
        <div class="flex justify-center">
            @if($currentPage > 1)
            <a href="{{ route('home', ['page' => $currentPage - 1]) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 mr-2">Anterior</a>
            @endif

            @for($i = max(1, $currentPage - 5); $i <= min($currentPage + 5, $totalPages); $i++)
            <a href="{{ route('home', ['page' => $i]) }}" class="bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300 mx-1 {{ $currentPage == $i ? 'bg-blue-500 text-white' : '' }}">{{ $i }}</a>
            @endfor

            @if($currentPage < $totalPages)
            <a href="{{ route('home', ['page' => $currentPage + 1]) }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 ml-2">Siguiente</a>
            @endif
        </div>
    </div>

@endsection



