<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Necessário para apagar a foto física

class NoticiaController extends Controller
{
    // 1. LISTAR TODAS (Para a tabela)
    public function index(Request $request)
    {
        $categorias = Noticia::query()
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria', 'categoria')
            ->toArray();

        $noticias = Noticia::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', "%{$search}%")
                        ->orWhere('conteudo', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->trim()->toString();

                if ($status === 'publicado') {
                    $query->whereDate('data_publicacao', '<=', now()->toDateString());
                }

                if ($status === 'rascunho') {
                    $query->whereDate('data_publicacao', '>', now()->toDateString());
                }
            })
            ->when($request->filled('categoria'), function ($query) use ($request) {
                $categoria = $request->string('categoria')->trim()->toString();

                $query->where('categoria', $categoria);
            })
            ->orderByDesc('data_publicacao')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.noticias.index', compact('noticias', 'categorias'));
    }

    // 2. FORMULÁRIO DE CRIAR
    public function create()
    {
        return view('admin.noticias.create');
    }

    // 3. SALVAR NO BANCO
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'categoria' => 'required',
            'resumo' => 'nullable',
            'conteudo' => 'required',
            'data_publicacao' => 'required|date',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $caminhoImagem = null;
        if ($request->hasFile('imagem_capa')) {
            $caminhoImagem = $request->file('imagem_capa')->store('noticias', 'public');
        }

        Noticia::create([
            'titulo' => $request->titulo,
            'slug' => Str::slug($request->titulo) . '-' . time(), 
            'categoria' => $request->categoria,
            'resumo' => $request->resumo,
            'conteudo' => $request->conteudo,
            'imagem_capa' => $caminhoImagem,
            'data_publicacao' => $request->data_publicacao,
        ]);

        // Redireciona de volta para a tabela
        return redirect()->route('admin.noticias.index')->with('sucesso', 'Notícia cadastrada com sucesso!');
    }

    // 4. MOSTRAR A NOTÍCIA PÚBLICA (Site)
    public function show($slug)
    {
        $noticia = Noticia::where('slug', $slug)->firstOrFail();
        return view('noticias.show', compact('noticia'));
    }

    // 5. FORMULÁRIO DE EDITAR
    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        return view('admin.noticias.edit', compact('noticia'));
    }

    // 6. ATUALIZAR DADOS DA EDIÇÃO
    public function update(Request $request, $id)
    {
        $noticia = Noticia::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:255',
            'categoria' => 'required',
            'resumo' => 'nullable',
            'conteudo' => 'required',
            'data_publicacao' => 'required|date',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $noticia->titulo = $request->titulo;
        // Atualiza o slug caso o título tenha mudado
        $noticia->slug = Str::slug($request->titulo) . '-' . time();
        $noticia->categoria = $request->categoria;
        $noticia->resumo = $request->resumo;
        $noticia->conteudo = $request->conteudo;
        $noticia->data_publicacao = $request->data_publicacao;

        // Se a pessoa enviou uma FOTO NOVA, a gente apaga a antiga do servidor e salva a nova
        if ($request->hasFile('imagem_capa')) {
            if ($noticia->imagem_capa) {
                Storage::disk('public')->delete($noticia->imagem_capa);
            }
            $noticia->imagem_capa = $request->file('imagem_capa')->store('noticias', 'public');
        }

        $noticia->save();

        return redirect()->route('admin.noticias.index')->with('sucesso', 'Notícia atualizada com sucesso!');
    }

    // 7. UPLOAD DE IMAGEM VIA CKEDITOR
    public function uploadImagemEditor(Request $request)
    {
        if (!$request->hasFile('upload')) {
            return response()->json(['error' => ['message' => 'Nenhum arquivo enviado.']], 400);
        }

        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ]);

        try {
            $path = $request->file('upload')->store('editor', 'public');
            return response()->json(['url' => asset('storage/' . $path)]);
        } catch (\Exception $e) {
            return response()->json(['error' => ['message' => 'Erro ao fazer upload.']], 500);
        }
    }

    // 8. APAGAR NOTÍCIA DE VEZ
    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);

        // Remove a foto da pasta do servidor antes de apagar a notícia do banco
        if ($noticia->imagem_capa) {
            Storage::disk('public')->delete($noticia->imagem_capa);
        }

        $noticia->delete();

        return redirect()->route('admin.noticias.index')->with('sucesso', 'Notícia apagada permanentemente!');
    }
}