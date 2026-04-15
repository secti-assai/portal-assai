<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PerfilController extends Controller
{
    public function definir(Request $request)
    {
        $request->validate([
            'perfil' => 'required|in:cidadao,empresario,turista,servidor,todos'
        ]);

        // Grava o cookie por 1 ano
        Cookie::queue('portal_perfil', $request->perfil, 525600);

        return redirect()->back()->with('sucesso_perfil', 'Perfil atualizado com sucesso.');
    }
}