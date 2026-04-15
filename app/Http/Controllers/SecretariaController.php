<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use App\Support\Concerns\NormalizesSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SecretariaController extends Controller
{
    use NormalizesSearch;

    public function index(Request $request)
    {
        $searchTerm = $request->string('search')->trim()->toString();
        if ($searchTerm === '') {
            $searchTerm = $request->string('q')->trim()->toString();
        }

        $secretarias = Secretaria::query()
            ->when($searchTerm !== '', function ($query) use ($searchTerm) {
                $search = $searchTerm;

                $query->where(function ($subQuery) use ($search) {
                    $busca = '%' . $this->normalizeSearchTerm($search) . '%';

                    $subQuery->whereRaw($this->normalizedColumnSql('nome') . ' LIKE ?', [$busca])
                        ->orWhereRaw($this->normalizedColumnSql('nome_secretario') . ' LIKE ?', [$busca]);
                });
            })
            ->orderBy('nome', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.secretarias.index', compact('secretarias'));
    }

    public function create()
    {
        return view('admin.secretarias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:255',
            'nome_secretario' => 'required|max:255',
            'descricao' => 'nullable',
            'foto' => 'nullable|image|max:2048', // Até 2MB
            'telefone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|max:255',
        ]);

        $dados = $request->all();

        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto')->store('secretarias', 'public');
        }

        Secretaria::create($dados);

        return redirect()->route('admin.secretarias.index')->with('sucesso', 'Secretaria cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $secretaria = Secretaria::findOrFail($id);
        return view('admin.secretarias.edit', compact('secretaria'));
    }

    public function update(Request $request, $id)
    {
        $secretaria = Secretaria::findOrFail($id);

        $request->validate([
            'nome' => 'required|max:255',
            'nome_secretario' => 'required|max:255',
            'descricao' => 'nullable',
            'foto' => 'nullable|image|max:2048',
            'telefone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|max:255',
        ]);

        $dados = $request->all();

        if ($request->hasFile('foto')) {
            if ($secretaria->foto) Storage::disk('public')->delete($secretaria->foto);
            $dados['foto'] = $request->file('foto')->store('secretarias', 'public');
        }

        $secretaria->update($dados);

        return redirect()->route('admin.secretarias.index')->with('sucesso', 'Secretaria atualizada!');
    }

    public function destroy($id)
    {
        $secretaria = Secretaria::findOrFail($id);
        if ($secretaria->foto) Storage::disk('public')->delete($secretaria->foto);
        $secretaria->delete();
        
        return redirect()->route('admin.secretarias.index')->with('sucesso', 'Secretaria apagada!');
    }

}