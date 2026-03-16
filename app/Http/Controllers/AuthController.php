<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostra a tela de login
    public function login()
    {
        return view('admin.login');
    }

    // Tenta fazer o login
    public function authenticate(Request $request)
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            
            // Redireciona para o painel se a senha estiver certa
            return redirect()->intended('/admin');
        }

        // Se errar a senha, volta com erro
        return back()->withErrors([
            'email' => 'O e-mail ou a senha estão incorretos.',
        ])->onlyInput('email');
    }

    // Faz o logout (sair)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Manda de volta pro site público
    }
}