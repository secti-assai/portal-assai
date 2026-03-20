<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Banner;
use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Programa;
use App\Models\Servico;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalNoticias      = Noticia::count();
        $totalEventosAtivos = Evento::where('data_inicio', '>=', now())->count();
        $totalServicos      = Servico::where('ativo', true)->count();
        $totalAlertas      = Alerta::where('ativo', true)->count();


        $topServicos    = Servico::orderByDesc('acessos')->take(5)->get();
        $ultimasNoticias = Noticia::orderByDesc('created_at')->take(5)->get();

        $proximosEventos = Evento::where('data_inicio', '>=', now())
            ->orderBy('data_inicio', 'asc')
            ->take(5)
            ->get();
        if ($proximosEventos->isEmpty()) {
            $proximosEventos = Evento::latest()->take(5)->get();
        }

        $ultimosProgramas = Programa::orderByDesc('created_at')->take(5)->get();

        $alertasAtivos = Alerta::where('ativo', true)->orderByDesc('created_at')->take(5)->get();
        $bannersAtivos = Banner::where('ativo', true)->orderByDesc('created_at')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalNoticias',
            'totalEventosAtivos',
            'totalServicos',
            'totalAlertas',
            'topServicos',
            'ultimasNoticias',
            'proximosEventos',
            'ultimosProgramas',
            'alertasAtivos',
            'bannersAtivos'
        ));
    }
}
