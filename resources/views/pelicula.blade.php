@extends('layouts.app')

@section('title', $movie['title'])

@section('content')
    <div class="container mx-auto">
        <div class="relative">
            <a href="{{ route('home') }}"
                class="sticky left-6 bottom-6 bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 z-10">Volver a
                Inicio</a>
        </div>
        <div class="my-5"></div>
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row bg-yellow-100 rounded-lg overflow-hidden shadow-lg">
            <div class="w-full md:w-1/2 mb-4 md:mb-0">
                @if (isset($movie['poster_path']))
                    <img src="https://image.tmdb.org/t/p/w300{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}"
                        class="w-full mx-auto rounded-md ">
                @else
                    <div class="w-full h-64 bg-gray-800 flex items-center justify-center rounded-md shadow-md">
                        <span class="text-gray-600">No hay imagen disponible</span>
                    </div>
                @endif
            </div>
            <div class="w-full md:w-1/2 p-6">
                <h1 class="text-4xl font-bold mb-4">{{ $movie['title'] }}</h1>
                <div class="my-10"></div>
                <div class="flex items-center mb-2">
                    <p class="text-gray-600 mr-2">Año:</p>
                    <p>{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</p>
                </div>
                <div class="flex items-center mb-2">
                    <p class="text-gray-600 mr-2">Género(s):</p>
                    @foreach ($movie['genres'] as $genre)
                        <span
                            class="inline-block mr-2 bg-blue-500 text-white rounded-full px-2 py-1 text-sm">{{ $genre['name'] }}</span>
                    @endforeach
                </div>
                <div class="flex items-center mb-2">
                    <p class="text-gray-600 mr-2">Duración:</p>
                    <p>{{ $movie['runtime'] }} minutos</p>
                </div>
                <div class="flex items-center mb-2">
                    <p class="text-gray-600 mr-2">Puntuación:</p>
                    <p>{{ $movie['vote_average'] }} / 10</p>
                </div>
                <div class="flex items-center mb-2">
                    <p class="text-gray-600 mr-2">Críticas:</p>
                    <p>{{ $movie['vote_count'] }}</p>
                </div>
                <div class="my-10"></div>
                <form action="{{ route('favorites.store', $movie['id']) }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-800">Añadir a
                        Favoritos</button>
                </form>
                <div class="my-10"></div>
                <h2 class="text-2xl font-bold mt-4">Reparto de actores</h2>
                <ul class="list-disc pl-4">
                    @foreach (array_slice($credits['cast'], 0, 8) as $actor)
                        <li>{{ $actor['name'] }} como {{ $actor['character'] }}</li>
                    @endforeach
                </ul>
                <div class="my-10"></div>
                @if (count($videos['results']) > 0)
                    <iframe class="w-full rounded-md mt-4 shadow-md" width="700" height="475"
                        src="https://www.youtube.com/embed/{{ $videos['results'][0]['key'] }}" frameborder="0"
                        allowfullscreen></iframe>
                @else
                    <p class="mt-4">No hay trailer disponible.</p>
                @endif
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Escribe una crítica</h2>
            <form action="{{ route('reviews.store', $movie['id']) }}" method="POST">
                @csrf
                <textarea name="review" rows="4" class="w-full p-2 rounded-md border border-gray-300 bg-yellow-100"
                    placeholder="Escribe tu crítica aquí..."></textarea>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 hover:bg-blue-600">Enviar
                    Crítica</button>
            </form>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Críticas de Usuarios</h2>
            @foreach ($reviews as $review)
                <div class="bg-white text-black p-4 rounded-md mb-4 shadow-md bg-yellow-100">
                    <p class="font-bold">{{ $review->user->name }}</p>
                    <p>{{ $review->review }}</p>
                </div>
            @endforeach
        </div>

    </div>

@endsection
