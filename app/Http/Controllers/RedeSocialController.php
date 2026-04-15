<?php

namespace App\Http\Controllers;

use App\Models\RedeSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RedeSocialController extends Controller
{
    public function index()
    {
        // Garante que existam exatamente 4 posições no banco
        for ($i = 1; $i <= 4; $i++) {
            RedeSocial::firstOrCreate(['ordem' => $i]);
        }

        $posts = RedeSocial::orderBy('ordem', 'asc')->get();

        return view('admin.redes_sociais.index', compact('posts'));
    }

    public function updateAll(Request $request)
    {
        $posts = RedeSocial::orderBy('ordem', 'asc')->get();

        foreach ($posts as $post) {
            $pos = $post->ordem;

            // Atualiza o link se foi preenchido
            if ($request->has("link.$pos")) {
                $post->link = $request->input("link.$pos");
            }

            // Atualiza a imagem se uma nova foi enviada
            if ($request->hasFile("imagem.$pos")) {
                // Deleta a antiga para não lotar o servidor
                if ($post->imagem && Storage::disk('public')->exists($post->imagem)) {
                    Storage::disk('public')->delete($post->imagem);
                }
                $post->imagem = $request->file("imagem.$pos")->store('redes_sociais', 'public');
            }

            $post->save();
        }

        return redirect()->back()->with('sucesso', 'Vitrine do Instagram atualizada com sucesso!');
    }
}