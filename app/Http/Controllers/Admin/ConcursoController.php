<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concurso;
use Illuminate\Http\Request;

class ConcursoController extends Controller
{
    public function index()
    {
        $concursos = Concurso::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.concursos.index', compact('concursos'));
    }

    public function create()
    {
        return view('admin.concursos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'link' => 'required|url',
        ]);

        Concurso::create($request->all());

        return redirect()->route('admin.concursos.index')->with('success', 'Concurso criado com sucesso!');
    }

    public function edit(Concurso $concurso)
    {
        return view('admin.concursos.edit', compact('concurso'));
    }

    public function update(Request $request, Concurso $concurso)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'link' => 'required|url',
        ]);

        $concurso->update($request->all());

        return redirect()->route('admin.concursos.index')->with('success', 'Concurso atualizado com sucesso!');
    }

    public function destroy(Concurso $concurso)
    {
        $concurso->delete();
        return redirect()->route('admin.concursos.index')->with('success', 'Concurso excluído com sucesso!');
    }

    public function toggleStatus(Concurso $concurso)
    {
        $concurso->update(['ativo' => !$concurso->ativo]);
        return back()->with('success', 'Status do concurso atualizado!');
    }
}
