<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramaController extends Controller
{
    public function index(Request $request)
    {
        $programas = Programa::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q')->trim()->toString();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', "%{$search}%")
                        ->orWhere('descricao', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('ativo'), fn($query) => $query->where('ativo', (bool) $request->boolean('ativo')))
            ->orderBy('destaque', 'desc')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.programas.index', compact('programas'));
    }

    public function create()
    {
        $categorias = \App\Models\Categoria::where('ativo', true)->orderBy('nome')->pluck('nome', 'id')->toArray();
        return view('admin.programas.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:100',
            'descricao' => 'required',
            'icone' => 'nullable|image|max:10240', // Aceita imagens de até 10MB
            'link' => 'nullable|url',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo');
        $dados['destaque'] = $request->has('destaque');

        if ($request->filled('categoria_id')) {
            $categoria = \App\Models\Categoria::find($request->categoria_id);
            if ($categoria) {
                $dados['perfis_alvo'] = [$categoria->perfil];
            }
        }

        if ($dados['destaque']) {
            $totalDestaques = Programa::where('destaque', true)->count();
            if ($totalDestaques >= 7) {
                return back()
                    ->withErrors(['destaque' => 'Limite de 7 destaques atingido. Remova um destaque antes de adicionar outro.'])
                    ->withInput();
            }
        }

        if ($request->hasFile('icone')) {
            $dados['icone'] = $this->storeAsWebp($request->file('icone'), 'programas');
        }

        Programa::create($dados);

        return redirect()->route('admin.programas.index')->with('sucesso', 'Programa cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $programa = Programa::findOrFail($id);
        $categorias = \App\Models\Categoria::where('ativo', true)
            ->orWhere('id', $programa->categoria_id)
            ->orderBy('nome')
            ->pluck('nome', 'id')
            ->toArray();
        return view('admin.programas.edit', compact('programa', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $programa = Programa::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:100',
            'descricao' => 'required',
            'icone' => 'nullable|image|max:10240',
            'link' => 'nullable|url',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $dados = $request->all();
        $dados['ativo'] = $request->has('ativo');
        $dados['destaque'] = $request->has('destaque');

        if ($request->filled('categoria_id')) {
            $categoria = \App\Models\Categoria::find($request->categoria_id);
            if ($categoria) {
                $dados['perfis_alvo'] = [$categoria->perfil];
            }
        } else {
            $dados['perfis_alvo'] = null;
        }

        if ($dados['destaque'] && !$programa->destaque) {
            $totalDestaques = Programa::where('destaque', true)->count();
            if ($totalDestaques >= 7) {
                return back()
                    ->withErrors(['destaque' => 'Limite de 7 destaques atingido. Remova um destaque antes de adicionar outro.'])
                    ->withInput();
            }
        }

        if ($request->hasFile('icone')) {
            if ($programa->icone) Storage::disk('public')->delete($programa->icone);
            $dados['icone'] = $this->storeAsWebp($request->file('icone'), 'programas');
        }

        $programa->update($dados);

        return redirect()->route('admin.programas.index')->with('sucesso', 'Programa atualizado!');
    }

    public function destroy($id)
    {
        $programa = Programa::findOrFail($id);
        if ($programa->icone) Storage::disk('public')->delete($programa->icone);
        $programa->delete();
        
        return redirect()->route('admin.programas.index')->with('sucesso', 'Programa apagado!');
    }

    public function toggle($id)
    {
        $programa = Programa::findOrFail($id);
        
        // Inverte o valor (se for 1 vira 0, se for 0 vira 1)
        $programa->ativo = !$programa->ativo;
        $programa->save();
    
        return redirect()->route('admin.programas.index')
                         ->with('success', 'Status do programa alterado com sucesso!');
    }

    public function toggleStatus(Programa $programa)
    {
        $programa->ativo = !$programa->ativo;
        $programa->save();
        return response()->json(['status' => 'success', 'ativo' => $programa->ativo]);
    }

    public function toggleDestaque(Programa $programa)
    {
        // Só pode ativar destaque se o programa for ativo
        if (!$programa->destaque) {
            if (!$programa->ativo) {
                return response()->json([
                    'message' => 'Só programas ativos podem ser destaque.'
                ], 422);
            }
            $totalDestaques = Programa::where('destaque', true)->count();
            if ($totalDestaques >= 7) {
                return response()->json([
                    'message' => 'Limite de 7 destaques atingido. Remova um destaque antes de adicionar outro.'
                ], 422);
            }
        }

        $programa->destaque = !$programa->destaque;
        $programa->save();

        return response()->json(['destaque' => $programa->destaque]);
    }
    private function storeAsWebp($file, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $safeName = \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $safeName . '_' . time() . '.webp';
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