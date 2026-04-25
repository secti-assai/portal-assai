<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portal;
use Illuminate\Http\Request;

class PortalAdminController extends Controller
{
    public function index()
    {
        $portais = Portal::orderBy('titulo')->get();
        return view('admin.portais.index', compact('portais'));
    }

    public function create()
    {
        return view('admin.portais.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'url' => 'required|url',
            'icone' => 'nullable|string|max:100',
            'ativo' => 'boolean',
        ]);

        Portal::create($request->all());

        return redirect()->route('admin.portais.index')->with('success', 'Portal criado com sucesso!');
    }

    public function edit(Portal $portal)
    {
        return view('admin.portais.edit', compact('portal'));
    }

    public function update(Request $request, Portal $portal)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'url' => 'required|url',
            'icone' => 'nullable|string|max:100',
            'ativo' => 'boolean',
        ]);

        $portal->update($request->all());

        return redirect()->route('admin.portais.index')->with('success', 'Portal atualizado com sucesso!');
    }

    public function destroy(Portal $portal)
    {
        $portal->delete();
        return redirect()->route('admin.portais.index')->with('success', 'Portal removido com sucesso!');
    }

    public function toggle(Portal $portal)
    {
        $portal->ativo = !$portal->ativo;
        $portal->save();

        return response()->json(['success' => true, 'ativo' => $portal->ativo]);
    }
}
