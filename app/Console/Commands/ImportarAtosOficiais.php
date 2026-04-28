<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Portaria;
use App\Models\Decreto;
use App\Models\DiarioOficial;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportarAtosOficiais extends Command
{
    protected $signature = 'importar:atos {tipo : O tipo de importacao (portarias, decretos, diarios)}';
    protected $description = 'Importa JSONs e faz o download fisico dos PDFs (com suporte a arquivos pesados)';

    public function handle()
    {
        // Desabilita limite de memória para execução de rotinas de carga pesada via CLI
        ini_set('memory_limit', '-1');

        $tipo = $this->argument('tipo');
        $arquivos = [
            'portarias' => 'portarias_assai_completo.json',
            'decretos'  => 'decretos_assai_completo.json',
            'diarios'   => 'diarios_assai_completo.json',
        ];

        if (!array_key_exists($tipo, $arquivos)) {
            $this->error("Tipo invalido. Use: portarias, decretos ou diarios.");
            return 1;
        }

        $caminho = base_path($arquivos[$tipo]);
        
        if (!File::exists($caminho)) {
            $this->error("Arquivo JSON nao encontrado: {$arquivos[$tipo]}");
            return 1;
        }

        $dados = json_decode(File::get($caminho), true);
        
        $bar = $this->output->createProgressBar(count($dados));
        $bar->start();

        foreach ($dados as $item) {
            match ($tipo) {
                'portarias' => $this->processarPortaria($item),
                'decretos'  => $this->processarDecreto($item),
                'diarios'   => $this->processarDiario($item),
            };
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nPersistencia de {$tipo} e I/O de disco finalizados.");
        return 0;
    }

    /**
     * Motor de Download Otimizado via Stream (Prevenção de Memory Exhaustion)
     */
    private function baixarEsalvarPdf(?string $url, string $pastaDestino, string $nomeArquivo): ?string
    {
        if (empty($url)) {
            return null;
        }

        $caminhoRelativo = "atos_oficiais/{$pastaDestino}/{$nomeArquivo}";
        $caminhoAbsoluto = storage_path("app/public/{$caminhoRelativo}");
        
        // Ponto de Restauração: Evita download redundante e permite continuar execuções falhas
        if (Storage::disk('public')->exists($caminhoRelativo)) {
            return $caminhoRelativo;
        }

        // Validação e criação recursiva do diretório alvo
        $diretorio = dirname($caminhoAbsoluto);
        if (!File::exists($diretorio)) {
            File::makeDirectory($diretorio, 0755, true);
        }

        try {
            // Parâmetro 'sink' força a escrita direta no disco (bypass na memória RAM)
            Http::withoutVerifying()
                ->timeout(120) // Incremento de timeout para arquivos > 50MB
                ->withOptions(['sink' => $caminhoAbsoluto])
                ->get($url);

            if (File::exists($caminhoAbsoluto)) {
                return $caminhoRelativo;
            }
        } catch (\Exception $e) {
            // Fallback: Exclusão de binário corrompido em caso de falha de socket/timeout
            if (File::exists($caminhoAbsoluto)) {
                File::delete($caminhoAbsoluto);
            }
        }

        return null;
    }

    private function processarPortaria(array $item): void
    {
        $data = Carbon::createFromFormat('d/m/Y', $item['data'])->format('Y-m-d');
        $numeroLimpo = Str::slug(str_replace('/', '-', $item['numero']));
        $nomeArquivo = "portaria_{$numeroLimpo}.pdf";
        
        $caminhoLocal = $this->baixarEsalvarPdf($item['pdf_url'], 'portarias', $nomeArquivo);

        Portaria::updateOrCreate(
            ['numero' => $item['numero'], 'data_publicacao' => $data],
            [
                'sumula' => $item['sumula'],
                'pdf_url' => empty($item['pdf_url']) ? null : $item['pdf_url'],
                'caminho_local' => $caminhoLocal,
            ]
        );
    }

    private function processarDecreto(array $item): void
    {
        $data = Carbon::createFromFormat('d/m/Y', $item['data'])->format('Y-m-d');
        $numeroLimpo = Str::slug(str_replace('/', '-', $item['numero']));
        $nomeArquivo = "decreto_{$numeroLimpo}.pdf";

        $caminhoLocal = $this->baixarEsalvarPdf($item['pdf_url'], 'decretos', $nomeArquivo);

        Decreto::updateOrCreate(
            ['numero' => $item['numero'], 'data_publicacao' => $data],
            [
                'tipo' => $item['tipo'],
                'sumula' => $item['sumula'],
                'pdf_url' => empty($item['pdf_url']) ? null : $item['pdf_url'],
                'caminho_local' => $caminhoLocal,
            ]
        );
    }

    private function processarDiario(array $item): void
    {
        $nomeArquivo = "diario_oficial_edicao_{$item['edicao']}.pdf";
        $caminhoLocal = $this->baixarEsalvarPdf($item['pdf_url'], 'diarios', $nomeArquivo);

        DiarioOficial::updateOrCreate(
            ['edicao' => $item['edicao']],
            [
                'data_publicacao'      => $item['data_publicacao'],
                'pdf_url'              => $item['pdf_url'],
                'caminho_local'        => $caminhoLocal,
                'assinante_id'         => $item['informacoes_assinante']['assinado_por'] ?? null,
                'assinante_nome'       => $item['informacoes_assinante']['nome_responsavel'] ?? null,
                'assinante_cpf'        => $item['informacoes_assinante']['cpf_responsavel'] ?? null,
                'assinante_email'      => $item['informacoes_assinante']['email_responsavel'] ?? null,
                'certificado_emissao'  => $item['informacoes_certificado']['emissao'] ?? null,
                'certificado_validade' => $item['informacoes_certificado']['validade'] ?? null,
                'certificado_versao'   => $item['informacoes_certificado']['versao'] ?? null,
                'certificado_serial'   => $item['informacoes_certificado']['serial'] ?? null,
                'certificado_hash'     => $item['informacoes_certificado']['hash'] ?? null,
                'carimbo_data_hora'    => isset($item['informacoes_carimbo_tempo']['data_hora']) 
                                            ? Carbon::parse($item['informacoes_carimbo_tempo']['data_hora'])->setTimezone('America/Sao_Paulo')->toDateTimeString() 
                                            : null,
                'carimbo_servidor'     => $item['informacoes_carimbo_tempo']['servidor'] ?? null,
                'carimbo_politica'     => $item['informacoes_carimbo_tempo']['politica'] ?? null,
            ]
        );
    }
}