<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(LoginRequest $request) {
        $credentials = $request->validated();

        // Intenta iniciar sesión con las credenciales validadas
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Evita fijación de sesión
            return redirect()->intended('dashboard');
        }

        // Si falla, regresa con error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) {
        $data = $request->validated();

        // Crea el usuario con la contraseña encriptada de forma segura
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Lo loguea automáticamente tras registrarse
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); // Cambia el token CSRF por seguridad

        return redirect()->route('login');
    }
}
