<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SessionsController extends Controller
{
    //funcion para mostrar la vista de inicio de sesion
    public function create() {

        return view('auth.login');
    }

    //funcion para el inicio de sesion
    public function store() {

        //verificamos que los datos proporcionados son los mismos que los de la base de datos
        if(auth()->attempt(request(['email', 'password'])) == false) {

            //sifalla devolvemos el mensaje de error
            return back()->withErrors([
                'message' => 'El correo electrónico o la contraseña son incorrectos, por favor inténtalo de nuevo',
            ]);

        } else {
            //si va todo bien verificamos si es el admin o si es un usuario normal y dirigimos a cada uno a su vista
            if(auth()->user()->role == 'admin') {
                return redirect()->route('admin.index');
            } else {
                return redirect()->to('/');
            }
        }
    }

    //funcion para destruir la sesion y cerrar sesion
    public function destroy() {

        auth()->logout();

        return redirect()->to('/');
    }
}
