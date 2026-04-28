<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiarioOficial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiarioOficialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:gerir atos oficiais');
    }

    public function index(Request $request)
    {
        $diarios = DiarioOficial::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where('edicao', 'like', "%{$search}%")
                    ->orWhere('assinante_nome', 'like', "%{$search}%");
            })
            ->latest('data_publicacao')
            ->paginate(15)
            ->withQueryString();

        return view('admin.diarios.index', compact('diarios'));
    }

    public function create()
    {
        return view('admin.diarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'edicao' => 'required|integer|unique:diarios_oficiais,edicao',
            'data_publicacao' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf|max:20480', // 20MB
            'pdf_url' => 'nullable|url|max:500',
            'assinante_id' => 'nullable|string|max:255',
            'assinante_nome' => 'nullable|string|max:255',
            'assinante_cpf' => 'nullable|string|size:11',
            'assinante_email' => 'nullable|email|max:255',
            'certificado_emissao' => 'nullable|date',
            'certificado_validade' => 'nullable|date',
            'certificado_versao' => 'nullable|string|max:10',
            'certificado_serial' => 'nullable|string|max:255',
            'certificado_hash' => 'nullable|string|max:255',
            'carimbo_data_hora' => 'nullable|date_format:Y-m-d\TH:i',
            'carimbo_servidor' => 'nullable|string|max:50',
            'carimbo_politica' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('pdf_file')) {
            $validated['caminho_local'] = $request->file('pdf_file')->store('atos_oficiais/diarios', 'public');
        }

        DiarioOficial::create($validated);

        return redirect()
            ->route('admin.diarios.index')
            ->with('success', 'Diário Oficial cadastrado com sucesso!');
    }

    public function edit(DiarioOficial $diario)
    {
        return view('admin.diarios.edit', compact('diario'));
    }

    public function update(Request $request, DiarioOficial $diario)
    {
        $validated = $request->validate([
            'edicao' => 'required|integer|unique:diarios_oficiais,edicao,' . $diario->id,
            'data_publicacao' => 'required|date',
            'pdf_file' => 'nullable|file|mimes:pdf|max:20480',
            'pdf_url' => 'nullable|url|max:500',
            'assinante_id' => 'nullable|string|max:255',
            'assinante_nome' => 'nullable|string|max:255',
            'assinante_cpf' => 'nullable|string|size:11',
            'assinante_email' => 'nullable|email|max:255',
            'certificado_emissao' => 'nullable|date',
            'certificado_validade' => 'nullable|date',
            'certificado_versao' => 'nullable|string|max:10',
            'certificado_serial' => 'nullable|string|max:255',
            'certificado_hash' => 'nullable|string|max:255',
            'carimbo_data_hora' => 'nullable|date_format:Y-m-d\TH:i',
            'carimbo_servidor' => 'nullable|string|max:50',
            'carimbo_politica' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('pdf_file')) {
            if ($diario->caminho_local) {
                Storage::disk('public')->delete($diario->caminho_local);
            }
            $validated['caminho_local'] = $request->file('pdf_file')->store('atos_oficiais/diarios', 'public');
        }

        $diario->update($validated);

        return redirect()
            ->route('admin.diarios.index')
            ->with('success', 'Diário Oficial atualizado com sucesso!');
    }

    public function destroy(DiarioOficial $diario)
    {
        if ($diario->caminho_local) {
            Storage::disk('public')->delete($diario->caminho_local);
        }

        $diario->delete();

        return redirect()
            ->route('admin.diarios.index')
            ->with('success', 'Diário Oficial excluído com sucesso!');
    }
}
