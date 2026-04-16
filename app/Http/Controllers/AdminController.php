<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Programa;
use App\Models\Secretaria;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ── KPIs principais ───────────────────────────────────────────────────
        $totalNoticias      = Noticia::count();
        $totalEventosAtivos = Evento::where('data_inicio', '>=', now())->count();
        $totalServicos      = Servico::where('ativo', true)->count();
        $totalProgramas     = Programa::where('ativo', true)->count();

        // Secretaria pode não existir em todos os projetos – usa 0 como fallback
        $totalSecretarias = class_exists(\App\Models\Secretaria::class)
            ? \App\Models\Secretaria::count()
            : 0;

        // Total de usuários (visível apenas ao admin)
        $totalUsuarios = \App\Models\User::count();

        // ── Listas para widgets ───────────────────────────────────────────────
        $topServicos     = Servico::orderByDesc('acessos')->take(5)->get();
        $ultimasNoticias = Noticia::orderByDesc('created_at')->take(5)->get();

        $proximosEventos = Evento::where('data_inicio', '>=', now())
            ->orderBy('data_inicio', 'asc')
            ->take(5)
            ->get();
        if ($proximosEventos->isEmpty()) {
            $proximosEventos = Evento::latest()->take(5)->get();
        }

        $ultimosProgramas = Programa::orderByDesc('created_at')->take(5)->get();
        $bannersAtivos    = Banner::where('ativo', true)->orderByDesc('created_at')->take(5)->get();

        // ── Dados do usuário logado ────────────────────────────────────────────
        $usuario       = Auth::user();
        $meusPapeis    = $usuario->getRoleNames();         // Collection de strings
        $minhasPerms   = $usuario->getAllPermissions()->pluck('name'); // todos (diretos + via role)

        return view('admin.dashboard', compact(
            'totalNoticias',
            'totalEventosAtivos',
            'totalServicos',
            'totalProgramas',
            'totalSecretarias',
            'totalUsuarios',
            'topServicos',
            'ultimasNoticias',
            'proximosEventos',
            'ultimosProgramas',
            'bannersAtivos',
            'meusPapeis',
            'minhasPerms'
        ));
    }
}

