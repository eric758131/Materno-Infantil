<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login
     */
    public function show(): View
    {
        // Si el usuario ya está autenticado, redirigir al welcome
        if (Auth::check()) {
            return view('welcome');
        }
        
        return view('auth.login');
    }

    /**
     * Maneja el intento de autenticación
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Verificar si el usuario está activo
            if ($user->estado !== 'activo') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta no está activa. Por favor, contacta al administrador.',
                ])->onlyInput('email');
            }

            // Regenerar la sesión por seguridad
            $request->session()->regenerate();

            // Redirigir a la vista welcome
            return redirect()->intended('/');
        }

        // Si la autenticación falla
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}