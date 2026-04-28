<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:gerir atos oficiais');
    }

    public function index(Request $request)
    {
        $portarias = Portaria::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where('numero', 'like', "%{$search}%")
                    ->orWhere('sumula', 'like', "%{$search}%");
            })
            ->latest('data_publicacao')
            ->paginate(15)
            ->withQueryString();

        return view('admin.portarias.index', compact('portarias'));
    }

    public function create()
    {
        return view('admin.portarias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:255',
            'data_publicacao' => 'required|date',
            'sumula' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB
            'pdf_url' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('pdf_file')) {
            $validated['caminho_local'] = $request->file('pdf_file')->store('atos_oficiais/portarias', 'public');
        }

        Portaria::create($validated);

        return redirect()
            ->route('admin.portarias.index')
            ->with('success', 'Portaria cadastrada com sucesso!');
    }

    public function edit(Portaria $portaria)
    {
        return view('admin.portarias.edit', compact('portaria'));
    }

    public function update(Request $request, Portaria $portaria)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:255',
            'data_publicacao' => 'required|date',
            'sumula' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'pdf_url' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('pdf_file')) {
            if ($portaria->caminho_local) {
                Storage::disk('public')->delete($portaria->caminho_local);
            }
            $validated['caminho_local'] = $request->file('pdf_file')->store('atos_oficiais/portarias', 'public');
        }

        $portaria->update($validated);

        return redirect()
            ->route('admin.portarias.index')
            ->with('success', 'Portaria atualizada com sucesso!');
    }

    public function destroy(Portaria $portaria)
    {
        if ($portaria->caminho_local) {
            Storage::disk('public')->delete($portaria->caminho_local);
        }

        $portaria->delete();

        return redirect()
            ->route('admin.portarias.index')
            ->with('success', 'Portaria excluída com sucesso!');
    }
}
