<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index(Request $request)
    {
        $icones = [
            'padrao' => 'Padrão (Genérico)',
            'saude' => 'Saúde (Coração/Cruz)',
            'vagas' => 'Vagas/Emprego (Maleta)',
            'documentos' => 'Documentos/Notas (Papel)',
            'ouvidoria' => 'Ouvidoria (Megafone/Chat)',
            'alvara' => 'Alvará/Empresa (Prédio)',
            'educacao' => 'Educação (Capelo/Livro)',
        ];

        $iconesCompatibilidade = [
            'padrao' => ['padrao', 'heroicon-o-currency-dollar', 'heroicon-o-wrench-screwdriver'],
            'saude' => ['saude'],
            'vagas' => ['vagas', 'heroicon-o-truck'],
            'documentos' => ['documentos', 'heroicon-o-document-text', 'heroicon-o-clipboard-document-check'],
            'ouvidoria' => ['ouvidoria', 'heroicon-o-phone', 'heroicon-o-envelope'],
            'alvara' => ['alvara', 'heroicon-o-building-library', 'heroicon-o-key'],
            'educacao' => ['educacao', 'heroicon-o-computer-desktop', 'heroicon-o-map-pin'],
        ];

        $servicos = Servico::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', "%{$search}%")
                        ->orWhere('link', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->trim()->toString();

                $query->where('ativo', $status === 'ativo');
            })
            ->when($request->filled('icone'), function ($query) use ($request, $iconesCompatibilidade) {
                $icone = $request->string('icone')->trim()->toString();

                $iconesPermitidos = $iconesCompatibilidade[$icone] ?? [$icone];

                $query->whereIn('icone', $iconesPermitidos);
            })
            ->orderBy('titulo')
            ->paginate(10)
            ->withQueryString();

        return view('admin.servicos.index', compact('servicos', 'icones'));
    }

    public function create()
    {
        $secretarias = \App\Models\Secretaria::orderBy('nome')->get();
        return view('admin.servicos.create', compact('secretarias'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'titulo'        => 'required|max:50',
            'url_acesso'    => 'required|url|max:2048',
            'icone'         => 'nullable|string|max:50',
            'secretaria_id' => 'nullable|exists:secretarias,id',
        ]);

        $dados['ativo'] = $request->has('ativo');

        Servico::create($dados);

        return redirect()->route('admin.servicos.index')->with('sucesso', 'Serviço cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $servico = Servico::findOrFail($id);
        $secretarias = \App\Models\Secretaria::orderBy('nome')->get();
        return view('admin.servicos.edit', compact('servico', 'secretarias'));
    }

    public function update(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);

        $dados = $request->validate([
            'titulo'        => 'required|max:50',
            'url_acesso'    => 'required|url|max:2048',
            'icone'         => 'nullable|string|max:50',
            'secretaria_id' => 'nullable|exists:secretarias,id',
        ]);

        $dados['ativo'] = $request->has('ativo');

        $servico->update($dados);

        return redirect()->route('admin.servicos.index')->with('sucesso', 'Serviço atualizado!');
    }

    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();
        return redirect()->route('admin.servicos.index')->with('sucesso', 'Serviço apagado!');
    }
    
    // Função para o botão de ativar/desativar rápido
    public function toggleAtivo($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->ativo = !$servico->ativo;
        $servico->save();
        return back()->with('sucesso', 'Status atualizado!');
    }

    public function toggleStatus(Servico $servico)
    {
        $servico->ativo = !$servico->ativo;
        $servico->save();
        return response()->json(['status' => 'success', 'ativo' => $servico->ativo]);
    }

}