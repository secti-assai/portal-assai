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
        // Versão para PostgreSQL (split_part e CAST para INTEGER)
        $ultimo = Portaria::orderByRaw("CAST(NULLIF(split_part(numero, '/', 2), '') AS INTEGER) DESC NULLS LAST")
            ->orderByRaw("CAST(NULLIF(split_part(numero, '/', 1), '') AS INTEGER) DESC NULLS LAST")
            ->first();

        return view('admin.portarias.create', compact('ultimo'));
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
            $fileName = 'portaria_' . str_replace('/', '-', $request->numero) . '.pdf';
            $validated['caminho_local'] = $request->file('pdf_file')->storeAs('atos_oficiais/portarias', $fileName, 'public');
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
            $fileName = 'portaria-' . \Illuminate\Support\Str::slug(str_replace('/', '-', $request->numero)) . '.pdf';
            $validated['caminho_local'] = $request->file('pdf_file')->storeAs('atos_oficiais/portarias', $fileName, 'public');
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
