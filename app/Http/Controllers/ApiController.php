<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Review;
use App\Models\Favorite;
use Illuminate\Database\QueryException;



class ApiController extends Controller
{
    private $apiKey = '46d99bb606e9ad6440b0b4aabf265921'; //clave de la API
    private $apiUrl = 'https://api.themoviedb.org/3'; // URL por defecto de la API

    // funcion para obtener peliculas populares o destacadas
    public function getHome()
    {
        // para tener el número de página actual o sino el por defecto que seria 1
        $page = request('page', 1);

        // solicitud a la API para obtener películas populares
        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
            ->get("{$this->apiUrl}/movie/popular", [
                'api_key' => $this->apiKey,
                'language' => 'es-ES',
                'page' => $page
            ]);

        // pasamos JSON y la pasamos a la vista
        $movies = $response->json();

        return view('home', [
            'movies' => $movies['results'],
            'totalPages' => $movies['total_pages'],
            'currentPage' => $page
        ]);
    }

    //igual que get home pero para obtener las proximas peliculas
    public function getProxima()
    {
        $page = request('page', 1);
        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
            ->get("{$this->apiUrl}/movie/upcoming", [
                'api_key' => $this->apiKey,
                'language' => 'es-ES',
                'page' => $page
            ]);

        $moviesUpcoming = $response->json();

        return view('proxima', [
            'moviesUpcoming' => $moviesUpcoming['results'],
            'totalPages' => $moviesUpcoming['total_pages'],
            'currentPage' => $page
        ]);
    }

    //igual que gethome pero para las peliculas que estan en cartelera
    public function getCartelera()
    {
        $page = request('page', 1);
        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
        ->get("{$this->apiUrl}/movie/now_playing", [
            'api_key' => $this->apiKey,
            'language' => 'es-ES',
            'page' => $page
        ]);

        $playingMovies = $response->json();

        return view('cartelera', [
            'playingMovies' => $playingMovies['results'],
            'totalPages' => $playingMovies['total_pages'],
            'currentPage' => $page
        ]);
    }

    //igual que gethome pero para las pelis con mas valoracion
    public function getValorada()
    {
        $page = request('page', 1);
        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
        ->get("{$this->apiUrl}/movie/top_rated", [
            'api_key' => $this->apiKey,
            'language' => 'es-ES',
            'page' => $page
        ]);

        $ratedMovies = $response->json();

        return view('valorada', [
            'ratedMovies' => $ratedMovies['results'],
            'totalPages' => $ratedMovies['total_pages'],
            'currentPage' => $page
        ]);
    }

    //Funcion para obtener todos los datos de las peliculas de la API
    public function show($id)
    {
        $movie = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
            ->get("{$this->apiUrl}/movie/{$id}?api_key={$this->apiKey}&language=es-ES")
            ->json();

        $credits = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
            ->get("{$this->apiUrl}/movie/{$id}/credits?api_key={$this->apiKey}&language=es-ES")
            ->json();

        $videos = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
            ->get("{$this->apiUrl}/movie/{$id}/videos?api_key={$this->apiKey}&language=es-ES")
            ->json();

        $reviews = Review::where('movie_id', $id)->with('user')->get();

        return view('pelicula', [
            'movie' => $movie,
            'credits' => $credits,
            'videos' => $videos,
            'reviews' => $reviews
        ]);
    }

    // funcion para crear y guardar una critica
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'review' => 'required|string|max:500',
        ]);

        try {
            Review::create([
                'movie_id' => $id,
                'user_id' => auth()->id(),
                'review' => $request->review,
            ]);
        } catch (QueryException $exception) {
            return redirect()->route('movie.show', $id)->with('error', 'Ya has enviado una crítica para esta película.');
        }

        return redirect()->route('movie.show', $id)->with('success', 'Crítica enviada exitosamente');
    }

    //funcion para crear y guardar una pelicula en favoritos
    public function storeFavorite(Request $request, $id)
    {
        try {
            Favorite::create([
                'movie_id' => $id,
                'user_id' => auth()->id(),
            ]);
        } catch (QueryException $exception) {
            return redirect()->route('movie.show', $id)->with('error', 'Esta película ya está en tus favoritos.');
        }

        return redirect()->route('movie.show', $id)->with('success', 'Película añadida a favoritos');
    }

    //funcion para buscar peliculas
    public function searchMovies(Request $request)
    {
        $query = $request->input('query');
        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0NmQ5OWJiNjA2ZTlhZDY0NDBiMGI0YWFiZjI2NTkyMSIsInN1YiI6IjY2NDc5NWJmYTIxZDg3MzBhNDhiYzEyYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.FJrWZLOU9h30oLSMRvKu5MEfG0IyGQpkdLi53Rmp5EY')
            ->get("https://api.themoviedb.org/3/search/movie", [
                'api_key' => config('services.tmdb.api_key'),
                'query' => $query,
                'language' => 'es-ES'
            ]);

        return response()->json($response->json()['results']);
    }

    //funcion para eliminar una pelicula de los favoritos de un usuario
    public function destroyFavorite($id)
    {
        $favorite = Favorite::where('user_id', auth()->id())->where('movie_id', $id)->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->route('perfil.index')->with('success', 'Película eliminada de favoritos');
        }

        return redirect()->route('perfil.index')->with('error', 'No se encontró la película en tus favoritos');
    }

    //funcion para eliminar una critica que ha escrito el usuario
    public function destroyReview($id)
    {
        $review = Review::where('user_id', auth()->id())->where('id', $id)->first();

        if ($review) {
            $review->delete();
            return redirect()->route('perfil.index')->with('success', 'Crítica eliminada correctamente');
        }

        return redirect()->route('perfil.index')->with('error', 'No se encontró la crítica');
    }


}
