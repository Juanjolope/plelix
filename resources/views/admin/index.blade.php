@extends('layouts.app')

@section('title', 'Admin - Panel de Control')

@section('content')
    <div class="container mx-auto mt-12">
        <div class="relative mb-8">
            <a href="{{ route('home') }}" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">Ir a PLELIX</a>
        </div>

        <div class="text-center">
            <h1 class="text-4xl font-bold mb-8">Panel de Control del Administrador</h1>
        </div>

        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-4">Usuarios</h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200">ID</th>
                        <th class="py-2 px-4 border-b border-gray-200">Nombre</th>
                        <th class="py-2 px-4 border-b border-gray-200">Email</th>
                        <th class="py-2 px-4 border-b border-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->id }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <form action="{{ route('admin.destroyUser', $user->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4">Críticas</h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200">ID</th>
                        <th class="py-2 px-4 border-b border-gray-200">Usuario</th>
                        <th class="py-2 px-4 border-b border-gray-200">Críticas</th>
                        <th class="py-2 px-4 border-b border-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $review->id }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $review->user->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $review->review }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <form action="{{ route('admin.destroyReview', $review->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que quieres eliminar esta crítica?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
