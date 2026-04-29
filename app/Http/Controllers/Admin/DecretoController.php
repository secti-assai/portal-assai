<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Decreto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DecretoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:gerir atos oficiais');
    }

    public function index(Request $request)
    {
        $decretos = Decreto::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where('numero', 'like', "%{$search}%")
                    ->orWhere('sumula', 'like', "%{$search}%");
            })
            ->latest('data_publicacao')
            ->paginate(15)
            ->withQueryString();

        return view('admin.decretos.index', compact('decretos'));
    }

    public function create()
    {
        $ultimo = Decreto::latest('data_publicacao')->latest('id')->first();
        return view('admin.decretos.create', compact('ultimo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:255',
            'data_publicacao' => 'required|date',
            'tipo' => 'nullable|string|max:255',
            'sumula' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'pdf_url' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('pdf_file')) {
            $fileName = 'decreto_' . str_replace('/', '-', $request->numero) . '.pdf';
            $validated['caminho_local'] = $request->file('pdf_file')->storeAs('atos_oficiais/decretos', $fileName, 'public');
        }

        Decreto::create($validated);

        return redirect()
            ->route('admin.decretos.index')
            ->with('success', 'Decreto cadastrado com sucesso!');
    }

    public function edit(Decreto $decreto)
    {
        return view('admin.decretos.edit', compact('decreto'));
    }

    public function update(Request $request, Decreto $decreto)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:255',
            'data_publicacao' => 'required|date',
            'tipo' => 'nullable|string|max:255',
            'sumula' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'pdf_url' => 'nullable|url|max:500',
        ]);

        if ($request->hasFile('pdf_file')) {
            if ($decreto->caminho_local) {
                Storage::disk('public')->delete($decreto->caminho_local);
            }
            $fileName = 'decreto-' . \Illuminate\Support\Str::slug(str_replace('/', '-', $request->numero)) . '.pdf';
            $validated['caminho_local'] = $request->file('pdf_file')->storeAs('atos_oficiais/decretos', $fileName, 'public');
        }

        $decreto->update($validated);

        return redirect()
            ->route('admin.decretos.index')
            ->with('success', 'Decreto atualizado com sucesso!');
    }

    public function destroy(Decreto $decreto)
    {
        if ($decreto->caminho_local) {
            Storage::disk('public')->delete($decreto->caminho_local);
        }

        $decreto->delete();

        return redirect()
            ->route('admin.decretos.index')
            ->with('success', 'Decreto excluído com sucesso!');
    }
}
