@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
    <div class="container mx-auto mt-12">
        <div class="relative mb-8">
            <a href="{{ route('home') }}" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">Volver a
                Inicio</a>
        </div>

        <div class="text-center">
            <h1 class="text-4xl font-bold mb-8">Perfil de Usuario</h1>
        </div>
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Actualizar Perfil</h2>
            <form action="{{ route('perfil.update') }}" method="POST" class="bg-blue-200 p-4 rounded shadow-md">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"
                        class="w-full border border-gray-300 px-4 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 px-4 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 px-4 py-2 rounded">
                </div>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Actualizar</button>
            </form>
            <br />
            <form action="{{ route('perfil.destroy') }}" method="POST"
                onsubmit="return confirm('¿Seguro que quieres eliminar tu cuenta? Esta acción no se puede deshacer.');"
                class="bg-blue-200 p-4 rounded shadow-md">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar
                    Cuenta</button>
            </form>
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Películas Favoritas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($favoriteMovies as $movie)
                    <div class="bg-white p-4 rounded shadow-md">
                        <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}"
                            class="mb-4 w-full">
                        <form action="{{ route('favorites.destroy', $movie['id']) }}" method="POST"
                            onsubmit="return confirm('¿Seguro que quieres eliminar esta película de tus favoritos?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 w-full">Eliminar</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">Reseñas</h2>
            @foreach ($reviews as $review)
                <div class="bg-white p-4 rounded shadow-md mb-4">
                    <p>{{ $review->review }}</p>
                    <small class="text-gray-500">Publicado el: {{ $review->created_at->format('d/m/Y') }}</small>
                </div>
            @endforeach
        </div>
    </div>
@endsection
