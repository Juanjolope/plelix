<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Portal Web de Películas</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css">
</head>

<body class="bg-blue-300 text-white-800 flex flex-col min-h-screen">
    <nav class="flex py-3 bg-blue-900 text-white fixed top-0 left-0 w-full z-50">
        <div class="flex items-center w-1/2 px-12 mr-auto">
            <img src="/images/plelix.png" alt="PLELIX" class="h-10 rounded-full">
            @if (auth()->check())
                <ul class="flex justify-start pt-1 mx-4">
                    <li class="mx-2">
                        <a href="{{ route('cartelera') }}"
                            class="font-semibold hover:bg-blue-700 py-3 px-4 rounded-md">En Cartelera</a>
                    </li>
                    <li class="mx-2">
                        <a href="{{ route('proxima') }}"
                            class="font-semibold hover:bg-blue-700 py-3 px-4 rounded-md">Próximas</a>
                    </li>
                    <li class="mx-2">
                        <a href="{{ route('valorada') }}"
                            class="font-semibold hover:bg-blue-700 py-3 px-4 rounded-md">Mejor Valoradas</a>
                    </li>
                </ul>
            @endif
        </div>

        <ul class="w-1/2 px-16 ml-auto flex justify-end pt-1">
            <li class="relative mx-4">
                <input id="movie-search" type="text" placeholder="Buscar película..."
                    class="px-4 py-2 rounded-md bg-white text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div id="suggestions" class="absolute bg-white text-black w-full mt-1 rounded-md shadow-lg hidden">
                </div>
            </li>
            @if (auth()->check())
                <li class="mx-8">
                    <p class="text-xl">Bienvenido <b>{{ auth()->user()->name }}</b></p>
                </li>
                <li class="mx-8">
                    <a href="{{ route('perfil.index') }}"
                        class="font-bold py-2 px-4 rounded-md bg-green-600 hover:bg-green-400">Perfil</a>
                </li>
                <li>
                    <a href="{{ route('login.destroy') }}"
                        class="font-bold py-2 px-4 rounded-md bg-red-600 hover:bg-red-400">Cerrar Sesión</a>
                </li>
            @else
                <li class="mx-6">
                    <a href="{{ route('login.index') }}"
                        class="font-semibold hover:bg-blue-700 py-3 px-4 rounded-md">Iniciar Sesión</a>
                </li>
                <li>
                    <a href="{{ route('register.index') }}"
                        class="font-semibold border-2 border-white py-2 px-4 rounded-md hover:bg-white hover:text-blue-700">Regístrate</a>
                </li>
            @endif
        </ul>
    </nav>

    <div class="mt-20 flex-grow">
        @yield('content')
    </div>

    <script src="js/search.js"></script>
    <br/>
    <footer class="bg-blue-900 py-2 text-center text-white mt-auto">
        <p class="mb-2">© {{ date('Y') }} Juan José López Romero</p>
        <p>Todos los derechos reservados.</p>
    </footer>
</body>

</html>
