<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Telefone;
use App\Models\Secretaria;
use Illuminate\Http\Request;

class TelefoneController extends Controller
{
    public function index()
    {
        $telefones = Telefone::with('secretaria')->orderBy('nome', 'asc')->paginate(20);
        return view('admin.telefones.index', compact('telefones'));
    }

    public function create()
    {
        $secretarias = Secretaria::orderBy('nome', 'asc')->get();
        return view('admin.telefones.create', compact('secretarias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'numero' => 'required|string|max:50',
            'secretaria_id' => 'nullable|exists:secretarias,id',
        ]);

        Telefone::create($request->all());

        return redirect()->route('admin.telefones.index')->with('success', 'Telefone adicionado com sucesso!');
    }

    public function edit(Telefone $telefone)
    {
        $secretarias = Secretaria::orderBy('nome', 'asc')->get();
        return view('admin.telefones.edit', compact('telefone', 'secretarias'));
    }

    public function update(Request $request, Telefone $telefone)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'numero' => 'required|string|max:50',
            'secretaria_id' => 'nullable|exists:secretarias,id',
        ]);

        $telefone->update($request->all());

        return redirect()->route('admin.telefones.index')->with('success', 'Telefone atualizado com sucesso!');
    }

    public function destroy(Telefone $telefone)
    {
        $telefone->delete();
        return redirect()->route('admin.telefones.index')->with('success', 'Telefone excluído com sucesso!');
    }

    public function toggleStatus(Telefone $telefone)
    {
        $telefone->update(['ativo' => !$telefone->ativo]);
        return back()->with('success', 'Status do telefone atualizado!');
    }
}
