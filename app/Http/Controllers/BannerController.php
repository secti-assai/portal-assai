<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();
                $query->where('id', 'like', "%{$search}%");
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->trim()->toString();
                $query->where('ativo', $status === 'ativo');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imagePath = $request->file('imagem')->store('banners', 'public');

        Banner::create([
            'imagem' => $imagePath,
            'exibir_inteira' => $request->has('exibir_inteira'),
            'ativo' => $request->has('ativo'),
        ]);

        return redirect()->route('admin.banners.index')->with('sucesso', 'Banner criado com sucesso!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('imagem')) {
            if ($banner->imagem && Storage::disk('public')->exists($banner->imagem)) {
                Storage::disk('public')->delete($banner->imagem);
            }
            $banner->imagem = $request->file('imagem')->store('banners', 'public');
        }

        $banner->exibir_inteira = $request->has('exibir_inteira');
        $banner->ativo = $request->has('ativo');
        $banner->save();

        return redirect()->route('admin.banners.index')->with('sucesso', 'Banner atualizado!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->imagem && Storage::disk('public')->exists($banner->imagem)) {
            Storage::disk('public')->delete($banner->imagem);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('sucesso', 'Banner apagado!');
    }

    public function toggleAtivo($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->ativo = !$banner->ativo;
        $banner->save();
        return back()->with('sucesso', 'Status do banner atualizado!');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->ativo = !$banner->ativo;
        $banner->save();
        return response()->json(['status' => 'success', 'ativo' => $banner->ativo]);
    }
}