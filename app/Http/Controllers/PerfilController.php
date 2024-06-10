<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class PerfilController extends Controller
{

    private $apiKey = '46d99bb606e9ad6440b0b4aabf265921';
    private $apiUrl = 'https://api.themoviedb.org/3';

    //funcion para mostrar el perfil de usuario
        public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener las películas favoritas y las reseñas del usuario
        $favorites = Favorite::where('user_id', $user->id)->get();
        $reviews = Review::where('user_id', $user->id)->get();

        // Inicializar un array para almacenar las películas favoritas
        $favoriteMovies = [];

        // recorremos las peliculas favoritas
        foreach ($favorites as $favorite) {
            $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
                ->get("{$this->apiUrl}/movie/{$favorite->movie_id}", [
                    'api_key' => $this->apiKey,
                    'language' => 'es-ES',
                ]);

            // Verificar si la solicitud fue exitosa antes de agregar la película al array
            if ($response->successful()) {
                $favoriteMovies[] = $response->json();
            }
        }

        // Pasar las películas favoritas y las criticas a la vista
        return view('perfil', compact('favoriteMovies', 'reviews'));
    }

    //funcion para actualizar los datos del ususario
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('perfil.index')->with('error', 'Usuario no autenticado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado exitosamente.');

    }

    //funcino para eliminar el usuario
    public function destroy()
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('perfil.index')->with('error', 'Usuario no logado.');
        }

        $user->delete();

        // cerrar sesion después de eliminar el usuario
        Auth::logout();

        return redirect()->route('home');
    }

}
