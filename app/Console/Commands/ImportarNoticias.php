<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ImportarNoticias extends Command
{
    protected $signature = 'importar:noticias {--force : Força a atualização}';
    protected $description = 'Importa notícias com limpeza profunda de títulos e conteúdos repetidos';

    public function handle()
    {
        ini_set('memory_limit', '512M');
        $caminhoArquivo = base_path('noticias_assai_completo.json');
        if (!file_exists($caminhoArquivo)) {
            $this->error("JSON não encontrado.");
            return;
        }

        $noticias = json_decode(file_get_contents($caminhoArquivo), true);

        if (!is_array($noticias)) {
            $this->error("O arquivo JSON é inválido ou está vazio (pode ser um ponteiro Git LFS).");
            return;
        }

        $bar = $this->output->createProgressBar(count($noticias));
        $bar->start();

        // 0. Garante que existe uma categoria "Geral" para todos os perfis
        $categoriaGeral = Categoria::firstOrCreate(
            ['nome' => 'Geral'],
            ['ativo' => true, 'perfis' => []]
        );

        foreach (array_reverse($noticias) as $item) {
            $titulo = trim($item['titulo']);
            $conteudo = trim($item['conteudo']);
            $dataRaw = $item['data'];

            // 1. SE O TÍTULO VIER VAZIO: Extrair da primeira linha do conteúdo
            if (empty($titulo) || $titulo == "Título não encontrado") {
                $linhas = explode("\n", $conteudo);
                $titulo = trim($linhas[0]);
                array_shift($linhas); // Remove a linha que virou título
                $conteudo = implode("\n", $linhas);
            }

            // 2. LIMPEZA PROFUNDA: Remover rastro de datas e "Postado em" do início do texto
            $conteudo = preg_replace('/^.*Postado em: \d{2}\/\d{2}\/\d{4}/isU', '', $conteudo);
            $conteudo = str_replace('Mais notícias', '', $conteudo);
            $titulo = str_replace(['Home Notícias', 'Home', 'Notícias'], '', $titulo);

            try {
                $dataFinal = Carbon::createFromFormat('d/m/Y', $dataRaw)->format('Y-m-d');
            } catch (\Exception $e) {
                $dataFinal = now()->format('Y-m-d');
            }

            // Evitar duplicados por título limpo + data
            if (!$this->option('force')) {
                $noticiaExistente = Noticia::where('titulo', trim($titulo))->where('data_publicacao', $dataFinal)->first();
                if ($noticiaExistente) {
                    $noticiaExistente->categorias()->syncWithoutDetaching([$categoriaGeral->id]);
                    $bar->advance();
                    continue;
                }
            }

            // 3. Download da Imagem (mesma lógica anterior)
            $imagemLocal = null;
            if (!empty($item['imagem_url'])) {
                try {
                    $res = Http::withoutVerifying()->timeout(15)->get($item['imagem_url']);
                    if ($res->successful()) {
                        $nome = Str::slug(substr($titulo, 0, 50)) . '-' . uniqid() . '.jpg';
                        Storage::disk('public')->put('noticias/' . $nome, $res->body());
                        $imagemLocal = 'noticias/' . $nome;
                    }
                } catch (\Exception $e) {}
            }

            // 4. Salvar
            $noticia = Noticia::updateOrCreate(
                ['titulo' => trim($titulo), 'data_publicacao' => $dataFinal],
                [
                    'slug' => Str::slug(substr($titulo, 0, 80)) . '-' . uniqid(),
                    'resumo' => trim($item['resumo']),
                    'conteudo' => nl2br(trim($conteudo)), // Mantém quebras de linha
                    'imagem_capa' => $imagemLocal,
                    'ativo' => true,
                    'perfis_alvo' => null, // Explicita que é para todos
                ]
            );

            // Vincula a categoria Geral
            $noticia->categorias()->syncWithoutDetaching([$categoriaGeral->id]);

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n🎉 Importação limpa concluída!");
    }
}
