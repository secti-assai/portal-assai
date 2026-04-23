<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vaga;
use Illuminate\Http\Request;

class VagaAdminController extends Controller
{
    public function __construct()
    {
        // Utilizando o padrão de middleware do Spatie Permission alinhado com suas rotas
        $this->middleware('permission:gerenciar vagas');
    }

    /**
     * Exibe a listagem de vagas.
     */
    public function index()
    {
        $vagas = Vaga::latest()->paginate(15);
        return view('admin.vagas.index', compact('vagas')); 
    }

    /**
     * Exibe o formulário para criar uma nova vaga.
     */
    public function create()
    {
        return view('admin.vagas.create');
    }

    /**
     * Valida e armazena uma nova vaga no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'           => 'required|string|max:255',
            'tipo'             => 'required|in:formal,informal',
            'setor_ou_contato' => 'required|string|max:255',
            'descricao'        => 'nullable|string',
            'data_limite'      => 'nullable|date',
            'link_acao'        => 'nullable|string|max:255',
            // Validação de URL relaxada (string) para permitir links de WhatsApp (ex: https://wa.me/...)
        ]);

        // Tratamento do status provindo de checkbox HTML (se ausente = false)
        $validated['status'] = $request->has('status');

        Vaga::create($validated);

        return redirect()
            ->route('admin.vagas.index')
            ->with('success', 'Oportunidade cadastrada com sucesso!');
    }

    /**
     * Exibe o formulário de edição de uma vaga específica.
     */
    public function edit(Vaga $vaga)
    {
        return view('admin.vagas.edit', compact('vaga'));
    }

    /**
     * Valida e atualiza os dados da vaga no banco de dados.
     */
    public function update(Request $request, Vaga $vaga)
    {
        $validated = $request->validate([
            'titulo'           => 'required|string|max:255',
            'tipo'             => 'required|in:formal,informal',
            'setor_ou_contato' => 'required|string|max:255',
            'descricao'        => 'nullable|string',
            'data_limite'      => 'nullable|date',
            'link_acao'        => 'nullable|string|max:255',
        ]);

        $validated['status'] = $request->has('status');

        $vaga->update($validated);

        return redirect()
            ->route('admin.vagas.index')
            ->with('success', 'Oportunidade atualizada com sucesso!');
    }

    /**
     * Remove a vaga do banco de dados.
     */
    public function destroy(Vaga $vaga)
    {
        $vaga->delete();

        return redirect()
            ->route('admin.vagas.index')
            ->with('success', 'Oportunidade excluída com sucesso!');
    }
}