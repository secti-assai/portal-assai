<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerDestaque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerDestaqueController extends Controller
{
    public function index()
    {
        $banners = BannerDestaque::orderBy('ordem', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.banner_destaques.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner_destaques.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'imagem' => 'required|image|max:2048',
            'link'   => 'nullable|url|max:255',
            'ordem'  => 'nullable|integer',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo');
        $dados['ordem'] = $request->ordem ?? 0;

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $this->storeAsWebp($request->file('imagem'), 'banner_destaques');
        }

        BannerDestaque::create($dados);

        return redirect()->route('admin.banner-destaques.index')->with('sucesso', 'Banner criado com sucesso!');
    }

    public function edit(BannerDestaque $banner_destaque)
    {
        return view('admin.banner_destaques.edit', ['banner' => $banner_destaque]);
    }

    public function update(Request $request, BannerDestaque $banner_destaque)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'imagem' => 'nullable|image|max:2048',
            'link'   => 'nullable|url|max:255',
            'ordem'  => 'nullable|integer',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo');
        $dados['ordem'] = $request->ordem ?? 0;

        if ($request->hasFile('imagem')) {
            if ($banner_destaque->imagem) {
                Storage::disk('public')->delete($banner_destaque->imagem);
            }
            $dados['imagem'] = $this->storeAsWebp($request->file('imagem'), 'banner_destaques');
        }

        $banner_destaque->update($dados);

        return redirect()->route('admin.banner-destaques.index')->with('sucesso', 'Banner atualizado com sucesso!');
    }

    public function destroy(BannerDestaque $banner_destaque)
    {
        if ($banner_destaque->imagem) {
            Storage::disk('public')->delete($banner_destaque->imagem);
        }
        $banner_destaque->delete();
        return redirect()->route('admin.banner-destaques.index')->with('sucesso', 'Banner excluído!');
    }

    private function storeAsWebp($file, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.webp';
        $path = storage_path('app/public/' . $folder . '/' . $filename);
        $sourcePath = $file->getRealPath();
        
        if (!file_exists(storage_path('app/public/' . $folder))) {
            mkdir(storage_path('app/public/' . $folder), 0755, true);
        }

        if (!$sourcePath || !\function_exists('imagewebp')) {
            return $file->store($folder, 'public');
        }

        $image = null;
        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                if (\function_exists('imagecreatefromjpeg')) {
                    $image = @\imagecreatefromjpeg($sourcePath);
                }
                break;
            case 'png':
                if (\function_exists('imagecreatefrompng')) {
                    $image = @\imagecreatefrompng($sourcePath);
                }
                if ($image) {
                    \imagepalettetotruecolor($image);
                    \imagealphablending($image, true);
                    \imagesavealpha($image, true);
                }
                break;
            case 'webp':
                if (\function_exists('imagecreatefromwebp')) {
                    $image = @\imagecreatefromwebp($sourcePath);
                }
                break;
        }

        if ($image) {
            \imagewebp($image, $path, 80);
            \imagedestroy($image);
            return $folder . '/' . $filename;
        }

        return $file->store($folder, 'public');
    }
}