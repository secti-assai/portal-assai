<?php

namespace App\Http\Controllers;

use App\Models\Executivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExecutivoController extends Controller
{
    /**
     * Exibe a tela única de gestão do Prefeito e Vice-Prefeito.
     */
    public function index()
    {
        $executivos = Executivo::all();
        $prefeito = $executivos->where('cargo', 'Prefeito')->first();
        $vicePrefeito = $executivos->where('cargo', 'Vice-Prefeito')->first();

        return view('admin.executivos.index', compact('prefeito', 'vicePrefeito'));
    }

    /**
     * Processa a atualização dos dados de um gestor específico.
     */
    public function update(Request $request, $id)
    {
        $executivo = Executivo::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB
        ]);

        $dados = $request->only(['nome']);

        if ($request->hasFile('foto')) {
            // Remove a foto antiga do disco
            if ($executivo->foto && Storage::disk('public')->exists($executivo->foto)) {
                Storage::disk('public')->delete($executivo->foto);
            }
            // Salva a nova foto
            $dados['foto'] = $request->file('foto')->store('executivos', 'public');
        }

        $executivo->update($dados);

        return redirect()->route('admin.executivos.index')
            ->with('sucesso', "Dados de {$executivo->cargo} atualizados com sucesso!");
    }
}