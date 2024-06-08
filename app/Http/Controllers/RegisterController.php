<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    // funcion para mostrar la vista de registro
    public function create() {
        return view('auth.register');
    }

    // funcion para guardar al usuario en la base de datos
    public function store() {
        // validar datos
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z]).*$/',
        ], [
            'password.regex' => 'La contraseña debe contener al menos 8 caracteres y una letra mayúscula.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
        ]);

        // creamos el usuario con los datos
        $user = User::create(request(['name', 'email', 'password']));

        // iniciamos sesion automaticamente
        auth()->login($user);

        // dirigimos al usuario a la home
        return redirect()->to('/');
    }
}
