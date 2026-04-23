<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Intencao;
use App\Services\IntencaoIndexer;
use Illuminate\Console\Command;

class ManageIntencioes extends Command
{
    protected $signature = 'ia:intencoes {action=list} {--id= : ID da intenção}';
    protected $description = 'Gerenciar intenções da IA (list, show, enable, disable, delete, reindex)';

    public function handle(): void
    {
        $action = $this->argument('action');
        $id = $this->option('id');

        match ($action) {
            'list' => $this->listar(),
            'show' => $this->mostrar($id),
            'enable' => $this->ativar($id),
            'disable' => $this->desativar($id),
            'delete' => $this->deletar($id),
            'reindex' => $this->reindexar(),
            default => $this->error("Ação desconhecida: {$action}"),
        };
    }

    private function listar(): void
    {
        $intencoes = Intencao::all(['id', 'intencao_id', 'resposta', 'prioridade', 'uso_count', 'ativa']);

        if ($intencoes->isEmpty()) {
            $this->info('Nenhuma intenção encontrada.');
            return;
        }

        $this->table(
            ['ID', 'Identificador', 'Prioridade', 'Usos', 'Ativa', 'Resposta (resumo)'],
            $intencoes->map(fn($i) => [
                $i->id,
                $i->intencao_id,
                $i->prioridade,
                $i->uso_count,
                $i->ativa ? '✓' : '✗',
                substr($i->resposta, 0, 50) . '...',
            ])->toArray()
        );
    }

    private function mostrar(?string $id): void
    {
        if (!$id) {
            $this->error('ID é obrigatório. Use --id=valor');
            return;
        }

        $intencao = Intencao::where('intencao_id', $id)->first();

        if (!$intencao) {
            $this->error("Intenção não encontrada: {$id}");
            return;
        }

        $this->info("Intenção: {$intencao->intencao_id}");
        $this->line("─────────────────────────────────────");
        $this->line("ID do banco: {$intencao->id}");
        $this->line("Prioridade: {$intencao->prioridade}");
        $this->line("Usos: {$intencao->uso_count}");
        $this->line("Ativa: " . ($intencao->ativa ? 'Sim' : 'Não'));
        $this->line("");
        $this->line("Resposta:");
        $this->line($intencao->resposta);
        $this->line("");
        $this->line("Contexto:");
        $this->line($intencao->contexto ?? '(vazio)');
        $this->line("");
        $this->line("Triggers:");
        if (!empty($intencao->triggers)) {
            foreach ($intencao->triggers as $trigger) {
                $this->line("  - {$trigger}");
            }
        } else {
            $this->line("  (nenhum)");
        }
    }

    private function ativar(?string $id): void
    {
        if (!$id) {
            $this->error('ID é obrigatório. Use --id=valor');
            return;
        }

        $intencao = Intencao::where('intencao_id', $id)->first();

        if (!$intencao) {
            $this->error("Intenção não encontrada: {$id}");
            return;
        }

        $intencao->update(['ativa' => true]);
        $this->info("Intenção ativada: {$id}");
        IntencaoIndexer::rebuild();
    }

    private function desativar(?string $id): void
    {
        if (!$id) {
            $this->error('ID é obrigatório. Use --id=valor');
            return;
        }

        $intencao = Intencao::where('intencao_id', $id)->first();

        if (!$intencao) {
            $this->error("Intenção não encontrada: {$id}");
            return;
        }

        $intencao->update(['ativa' => false]);
        $this->info("Intenção desativada: {$id}");
        IntencaoIndexer::rebuild();
    }

    private function deletar(?string $id): void
    {
        if (!$id) {
            $this->error('ID é obrigatório. Use --id=valor');
            return;
        }

        $intencao = Intencao::where('intencao_id', $id)->first();

        if (!$intencao) {
            $this->error("Intenção não encontrada: {$id}");
            return;
        }

        if (!$this->confirm("Deletar intenção '{$id}'? Esta ação não pode ser desfeita.")) {
            $this->info('Cancelado.');
            return;
        }

        $intencao->delete();
        $this->info("Intenção deletada: {$id}");
        IntencaoIndexer::rebuild();
    }

    private function reindexar(): void
    {
        $this->info('Reconstruindo índice de intenções...');
        IntencaoIndexer::rebuild();
        $this->info('Índice reconstruído com sucesso!');
    }
}
