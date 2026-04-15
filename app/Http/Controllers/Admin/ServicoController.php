<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Support\Concerns\NormalizesSearch;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    use NormalizesSearch;

    public function index(Request $request)
    {
        $ordenacao = $request->string('ordenacao')->trim()->toString();

        // Removido array de icones prefixados, pois agora usamos FontAwesome livremente

        $searchTerm = $request->string('search')->trim()->toString();
        if ($searchTerm === '') {
            $searchTerm = $request->string('q')->trim()->toString();
        }

        $servicos = Servico::query()
            ->when($searchTerm !== '', function ($query) use ($searchTerm) {
                $search = $searchTerm;

                $query->where(function ($subQuery) use ($search) {
                    $busca = '%' . $this->normalizeSearchTerm($search) . '%';

                    $subQuery->whereRaw($this->normalizedColumnSql('titulo') . ' LIKE ?', [$busca])
                        ->orWhereRaw($this->normalizedColumnSql('link') . ' LIKE ?', [$busca]);
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->trim()->toString();

                $query->where('ativo', $status === 'ativo');
            });

        if ($ordenacao === 'mais_acessados') {
            $servicos->orderByDesc('acessos')->orderBy('titulo');
        } elseif ($ordenacao === 'menos_acessados') {
            $servicos->orderBy('acessos')->orderBy('titulo');
        } else {
            $servicos->orderBy('titulo');
        }

        $servicos = $servicos->paginate(10)->appends($request->query());

        return view('admin.servicos.index', compact('servicos'));
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
            'descricao'     => 'nullable|string|max:255',
            'link'          => 'required|url|max:2048',
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
            'descricao'     => 'nullable|string|max:255',
            'link'          => 'required|url|max:2048',
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
