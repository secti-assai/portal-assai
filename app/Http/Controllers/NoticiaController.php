<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    // 1. LISTAR TODAS (Para a tabela)
    public function index(Request $request)
    {
        $categorias = \App\Models\Categoria::orderBy('nome')->pluck('nome', 'id')->toArray();

        $noticias = Noticia::query()
            ->with('categoriaRel')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', "%{$search}%")
                        ->orWhere('conteudo', 'like', "%{$search}%");
                });
            })
            // Status Filtro atualizado para usar o campo 'ativo'
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->trim()->toString();
                if ($status === 'publicado') {
                    $query->where('ativo', true);
                }
                if ($status === 'rascunho') {
                    $query->where('ativo', false);
                }
            })
            ->when($request->filled('categoria'), function ($query) use ($request) {
                $categoria_id = $request->integer('categoria');
                if ($categoria_id > 0) {
                    $query->where('categoria_id', $categoria_id);
                }
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
        $categorias = \App\Models\Categoria::where('ativo', true)->orderBy('nome')->pluck('nome', 'id')->toArray();
        return view('admin.noticias.create', compact('categorias'));
    }

    // 3. SALVAR NO BANCO
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'categoria' => 'nullable|integer|exists:categorias,id',
            'resumo' => 'nullable',
            'conteudo' => 'required',
            'data_publicacao' => 'required|date',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ativo' => 'nullable|boolean',
            'destaque' => 'nullable|boolean',
        ]);

        $caminhoImagem = null;
        if ($request->hasFile('imagem_capa')) {
            $caminhoImagem = $request->file('imagem_capa')->store('noticias', 'public');
        }

        $perfisAlvo = null;
        if ($request->filled('categoria')) {
            $categoria = \App\Models\Categoria::find($request->categoria);
            if ($categoria) {
                $perfisAlvo = [$categoria->perfil];
            }
        }

        Noticia::create([
            'titulo' => $request->titulo,
            'slug' => Str::slug($request->titulo) . '-' . time(), 
            'categoria_id' => $request->categoria,
            'resumo' => $request->resumo,
            'conteudo' => $request->conteudo,
            'imagem_capa' => $caminhoImagem,
            'data_publicacao' => $request->data_publicacao,
            'ativo' => $request->has('ativo'),
            'destaque' => $request->has('destaque'),
            'perfis_alvo' => $perfisAlvo,
        ]);

        return redirect()->route('admin.noticias.index')->with('sucesso', 'Notícia cadastrada com sucesso!');
    }

    // 4. MOSTRAR A NOTÍCIA PÚBLICA (Site)
    public function show($slug)
    {
        $noticia = Noticia::where('slug', $slug)->where('ativo', true)->firstOrFail();
        return view('noticias.show', compact('noticia'));
    }

    // 5. FORMULÁRIO DE EDITAR
    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        $categorias = \App\Models\Categoria::where('ativo', true)
            ->orWhere('id', $noticia->categoria_id) // garante que a categoria atual apareça, mesmo se inativa
            ->orderBy('nome')
            ->pluck('nome', 'id')
            ->toArray();
            
        return view('admin.noticias.edit', compact('noticia', 'categorias'));
    }

    // 6. ATUALIZAR DADOS DA EDIÇÃO
    public function update(Request $request, $id)
    {
        $noticia = Noticia::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:255',
            'categoria' => 'nullable|integer|exists:categorias,id',
            'resumo' => 'nullable',
            'conteudo' => 'required',
            'data_publicacao' => 'required|date',
            'imagem_capa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ativo' => 'nullable|boolean',
            'destaque' => 'nullable|boolean',
        ]);

        $perfisAlvo = $noticia->perfis_alvo; // mantém o atual por padrão
        if ($request->filled('categoria')) {
            $categoria = \App\Models\Categoria::find($request->categoria);
            if ($categoria) {
                $perfisAlvo = [$categoria->perfil];
            }
        } else {
            $perfisAlvo = null;
        }

        $noticia->titulo = $request->titulo;
        $noticia->slug = Str::slug($request->titulo) . '-' . time();
        $noticia->categoria_id = $request->categoria;
        $noticia->resumo = $request->resumo;
        $noticia->conteudo = $request->conteudo;
        $noticia->data_publicacao = $request->data_publicacao;
        $noticia->ativo = $request->has('ativo');
        $noticia->destaque = $request->has('destaque');
        $noticia->perfis_alvo = $perfisAlvo;

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

        if ($noticia->imagem_capa) {
            Storage::disk('public')->delete($noticia->imagem_capa);
        }

        $noticia->delete();

        return redirect()->route('admin.noticias.index')->with('sucesso', 'Notícia apagada permanentemente!');
    }
}