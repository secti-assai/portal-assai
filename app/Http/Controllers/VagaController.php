<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\View\View;

class VagaController extends Controller
{
    public function formais(): View
    {
        $vagas = Vaga::ativas()->where('tipo', 'formal')->orderBy('created_at', 'desc')->get();
        return view('pages.cidade.oportunidades', compact('vagas'));
    }

    public function informais(): View
    {
        $vagas = Vaga::ativas()->where('tipo', 'informal')->orderBy('created_at', 'desc')->get();
        return view('pages.cidade.informais', compact('vagas'));
    }
}