<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index(Request $request)
    {
        $alertas = Alerta::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', "%{$search}%")
                        ->orWhere('mensagem', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->trim()->toString();

                $query->where('ativo', $status === 'ativo');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.alertas.index', compact('alertas'));
    }

    public function create()
    {
        return view('admin.alertas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'mensagem' => 'required|max:255',
            'link' => 'nullable|url'
        ]);

        Alerta::create([
            'titulo' => $request->titulo,
            'mensagem' => $request->mensagem,
            'link' => $request->link,
            'ativo' => $request->has('ativo'),
        ]);

        return redirect()->route('admin.alertas.index')->with('sucesso', 'Alerta criado com sucesso!');
    }

    public function edit($id)
    {
        $alerta = Alerta::findOrFail($id);
        return view('admin.alertas.edit', compact('alerta'));
    }

    public function update(Request $request, $id)
    {
        $alerta = Alerta::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:255',
            'mensagem' => 'required|max:255',
            'link' => 'nullable|url'
        ]);

        $alerta->update([
            'titulo' => $request->titulo,
            'mensagem' => $request->mensagem,
            'link' => $request->link,
            'ativo' => $request->has('ativo'),
        ]);

        return redirect()->route('admin.alertas.index')->with('sucesso', 'Alerta atualizado!');
    }

    public function destroy($id)
    {
        Alerta::findOrFail($id)->delete();
        return redirect()->route('admin.alertas.index')->with('sucesso', 'Alerta apagado!');
    }
    
    public function toggleAtivo($id)
    {
        $alerta = Alerta::findOrFail($id);
        $alerta->ativo = !$alerta->ativo;
        $alerta->save();
        return back()->with('sucesso', 'Status do alerta atualizado!');
    }

    public function toggleStatus(Alerta $alerta)
    {
        $alerta->ativo = !$alerta->ativo;
        $alerta->save();
        return response()->json(['status' => 'success', 'ativo' => $alerta->ativo]);
    }

}