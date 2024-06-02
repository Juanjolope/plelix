<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\PerfilController;

Route::middleware('auth')->group(function () {
    // Rutas relacionadas con la API
    Route::get('/', [ApiController::class, 'getHome'])->name('home');
    Route::get('/cartelera', [ApiController::class, 'getCartelera'])->name('cartelera');
    Route::get('/proxima', [ApiController::class, 'getProxima'])->name('proxima');
    Route::get('/valorada', [ApiController::class, 'getValorada'])->name('valorada');
    Route::get('/pelicula/{id}', [ApiController::class, 'show'])->name('movie.show');
    Route::get('/pelicula/{id}', [ApiController::class, 'show'])->name('movie.show');
    Route::post('/pelicula/{id}/review', [ApiController::class, 'storeReview'])->name('reviews.store');
    Route::post('/pelicula/{id}/favorite', [ApiController::class, 'storeFavorite'])->name('favorites.store');
    Route::get('/search', [ApiController::class, 'searchMovies']);
    Route::delete('/perfil/favorite/{id}', [ApiController::class, 'destroyFavorite'])->name('favorites.destroy');

});

Route::middleware('guest')->group(function () {
    //rutas de registro
    Route::get('/register', [RegisterController::class, 'create'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    //rutas de inicio de sesion
    Route::get('/login', [SessionsController::class, 'create'])->name('login.index');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    //rutas de admin
    Route::get('/admin', [AdminController::class, 'index'])->middleware('auth.admin')->name('admin.index');
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.destroyUser');
    Route::delete('/admin/review/{id}', [AdminController::class, 'destroyReview'])->name('admin.destroyReview');
    //rutas de perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::delete('/perfil', [PerfilController::class, 'destroy'])->name('perfil.destroy');
    Route::get('/logout', [SessionsController::class, 'destroy'])->name('login.destroy');
});
