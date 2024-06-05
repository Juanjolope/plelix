<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Review;

class AdminController extends Controller
{
    public function index()
    {
        // obtenemos todos los usuarios que tenemos en la base de datos
        $users = User::all();

        // obtenemos las criticas con sus usuarios
        $reviews = Review::with('user')->get();

        // dirigimos a la vista del admin con los usuarios y las criticas
        return view('admin.index', compact('users', 'reviews'));
    }

    public function destroyUser($id)
    {
        // buscamos al usuario por su id y lo eleminamos
        User::findOrFail($id)->delete();

        // dirigimos a la pagnia de admin con un mensaje de que el usuario se a elimnado
        return redirect()->route('admin.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function destroyReview($id)
    {
        // buscamos la critica por la id y la eliminamos
        Review::findOrFail($id)->delete();

        // nos dirigomos a la vista de admin con el mensaje de que se a eliminado la critica exitosamente
        return redirect()->route('admin.index')->with('success', 'Crítica eliminada exitosamente.');
    }
}
