<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where('nome', 'like', "%{$search}%");
            })
            ->when($request->filled('perfil'), function ($query) use ($request) {
                $perfil = $request->string('perfil')->trim()->toString();
                $query->where('perfil', $perfil);
            })
            ->orderBy('nome', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias,nome',
            'perfil' => 'required|string|in:Cidadão,Turista,Empresário,Servidor Público',
            'ativo' => 'nullable|boolean',
        ]);

        Categoria::create([
            'nome' => $request->nome,
            'perfil' => $request->perfil,
            'ativo' => $request->has('ativo'),
        ]);

        return redirect()->route('admin.categorias.index')->with('sucesso', 'Tema cadastrado com sucesso!');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias,nome,' . $categoria->id,
            'perfil' => 'required|string|in:Cidadão,Turista,Empresário,Servidor Público',
            'ativo' => 'nullable|boolean',
        ]);

        $categoria->update([
            'nome' => $request->nome,
            'perfil' => $request->perfil,
            'ativo' => $request->has('ativo'),
        ]);

        return redirect()->route('admin.categorias.index')->with('sucesso', 'Tema atualizado com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('sucesso', 'Tema apagado permanentemente!');
    }
}
