<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', "%{$search}%")
                        ->orWhere('local', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->trim()->toString();

                if ($status === 'agendado') {
                    $query->where('status', 'confirmado')
                        ->where('data_inicio', '>=', now());
                }

                if ($status === 'realizado') {
                    $query->where('status', 'confirmado')
                        ->where('data_inicio', '<', now());
                }

                if ($status === 'cancelado') {
                    $query->where('status', $status);
                }
            })
            ->when($request->filled('mes_referencia'), function ($query) use ($request) {
                $mesReferencia = $request->string('mes_referencia')->trim()->toString();
                [$ano, $mes] = array_pad(explode('-', $mesReferencia), 2, null);

                if ($ano !== null && $mes !== null) {
                    $query->whereYear('data_inicio', (int) $ano)
                        ->whereMonth('data_inicio', (int) $mes);
                }
            })
            ->orderBy('data_inicio', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('admin.eventos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:100',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'imagem' => 'nullable|image|max:2048',
            'status' => 'required|in:confirmado,cancelado',
        ]);

        $dados = $request->all();

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('eventos', 'public');
        }

        Evento::create($dados);

        return redirect()->route('admin.eventos.index')->with('sucesso', 'Evento agendado com sucesso!');
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        return view('admin.eventos.edit', compact('evento'));
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:100',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'imagem' => 'nullable|image|max:2048',
            'status' => 'required|in:confirmado,cancelado',
        ]);

        $dados = $request->all();

        if ($request->hasFile('imagem')) {
            if ($evento->imagem) Storage::disk('public')->delete($evento->imagem);
            $dados['imagem'] = $request->file('imagem')->store('eventos', 'public');
        }

        $evento->update($dados);

        return redirect()->route('admin.eventos.index')->with('sucesso', 'Evento atualizado!');
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        if ($evento->imagem) Storage::disk('public')->delete($evento->imagem);
        $evento->delete();
        return redirect()->route('admin.eventos.index')->with('sucesso', 'Evento cancelado/apagado!');
    }

    public function toggleAtivo($id)
    {
        // Campo 'ativo' descontinuado. Use o formulário de edição para alterar o status.
        return back()->with('sucesso', 'Use o formulário de edição para alterar o status do evento.');
    }
}