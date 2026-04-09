<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramaController extends Controller
{
    public function index(Request $request)
    {
        $programas = Programa::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->trim()->toString();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', "%{$search}%")
                        ->orWhere('descricao', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('ativo'), fn($query) => $query->where('ativo', (bool) $request->boolean('ativo')))
            ->orderBy('destaque', 'desc')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.programas.index', compact('programas'));
    }

    public function create()
    {
        return view('admin.programas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:100',
            'descricao' => 'required',
            'icone' => 'nullable|image|max:2048', // Aceita imagens de até 2MB
            'link' => 'nullable|url',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo');
        $dados['destaque'] = $request->has('destaque');

        if ($dados['destaque']) {
            $totalDestaques = Programa::where('destaque', true)->count();
            if ($totalDestaques >= 3) {
                return back()
                    ->withErrors(['destaque' => 'Limite de 3 destaques atingido. Remova um destaque antes de adicionar outro.'])
                    ->withInput();
            }
        }

        if ($request->hasFile('icone')) {
            $dados['icone'] = $request->file('icone')->store('programas', 'public');
        }

        Programa::create($dados);

        return redirect()->route('admin.programas.index')->with('sucesso', 'Programa cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $programa = Programa::findOrFail($id);
        return view('admin.programas.edit', compact('programa'));
    }

    public function update(Request $request, $id)
    {
        $programa = Programa::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:100',
            'descricao' => 'required',
            'icone' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo');
        $dados['destaque'] = $request->has('destaque');

        if ($dados['destaque'] && !$programa->destaque) {
            $totalDestaques = Programa::where('destaque', true)->count();
            if ($totalDestaques >= 3) {
                return back()
                    ->withErrors(['destaque' => 'Limite de 3 destaques atingido. Remova um destaque antes de adicionar outro.'])
                    ->withInput();
            }
        }

        if ($request->hasFile('icone')) {
            if ($programa->icone) Storage::disk('public')->delete($programa->icone);
            $dados['icone'] = $request->file('icone')->store('programas', 'public');
        }

        $programa->update($dados);

        return redirect()->route('admin.programas.index')->with('sucesso', 'Programa atualizado!');
    }

    public function destroy($id)
    {
        $programa = Programa::findOrFail($id);
        if ($programa->icone) Storage::disk('public')->delete($programa->icone);
        $programa->delete();
        
        return redirect()->route('admin.programas.index')->with('sucesso', 'Programa apagado!');
    }

    public function toggle($id)
    {
        $programa = Programa::findOrFail($id);
        
        // Inverte o valor (se for 1 vira 0, se for 0 vira 1)
        $programa->ativo = !$programa->ativo;
        $programa->save();
    
        return redirect()->route('admin.programas.index')
                         ->with('success', 'Status do programa alterado com sucesso!');
    }

    public function toggleStatus(Programa $programa)
    {
        $programa->ativo = !$programa->ativo;
        $programa->save();
        return response()->json(['status' => 'success', 'ativo' => $programa->ativo]);
    }

    public function toggleDestaque(Programa $programa)
    {
        // Só pode ativar destaque se o programa for ativo
        if (!$programa->destaque) {
            if (!$programa->ativo) {
                return response()->json([
                    'message' => 'Só programas ativos podem ser destaque.'
                ], 422);
            }
            $totalDestaques = Programa::where('destaque', true)->count();
            if ($totalDestaques >= 3) {
                return response()->json([
                    'message' => 'Limite de 3 destaques atingido. Remova um destaque antes de adicionar outro.'
                ], 422);
            }
        }

        $programa->destaque = !$programa->destaque;
        $programa->save();

        return response()->json(['destaque' => $programa->destaque]);
    }

}