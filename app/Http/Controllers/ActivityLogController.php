<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    private const EXPORT_MAX_DAYS = 93;

    /**
     * @var array<string, class-string>
     */
    private const MODULES = [
        'noticias' => \App\Models\Noticia::class,
        'programas' => \App\Models\Programa::class,
        'servicos' => \App\Models\Servico::class,
        'eventos' => \App\Models\Evento::class,
        'banners' => \App\Models\Banner::class,
        'alertas' => \App\Models\Alerta::class,
        'secretarias' => \App\Models\Secretaria::class,
    ];

    /**
     * @var array<string, string>
     */
    private const MODULE_LABELS = [
        'noticias' => 'Notícias',
        'programas' => 'Programas',
        'servicos' => 'Serviços',
        'eventos' => 'Eventos',
        'banners' => 'Banners',
        'alertas' => 'Alertas',
        'secretarias' => 'Secretarias',
    ];

    /**
     * @var array<string, string>
     */
    private const EDIT_ROUTES = [
        'noticias' => 'admin.noticias.edit',
        'programas' => 'admin.programas.edit',
        'servicos' => 'admin.servicos.edit',
        'eventos' => 'admin.eventos.edit',
        'banners' => 'admin.banners.edit',
        'alertas' => 'admin.alertas.edit',
        'secretarias' => 'admin.secretarias.edit',
    ];

    /**
     * @var list<string>
     */
    private const SENSITIVE_FIELD_HINTS = [
        'password',
        'token',
        'email',
        'telefone',
        'phone',
        'cpf',
        'cnpj',
        'endereco',
        'address',
    ];

    public function index(Request $request): View
    {
        /** @var LengthAwarePaginator $activities */
        $activities = $this->buildFilteredQuery($request)
            ->with(['causer', 'subject'])
            ->latest()
            ->paginate(20);

        $activities->withQueryString();

        $users = User::query()
            ->whereIn('id', Activity::query()->where('causer_type', User::class)->whereNotNull('causer_id')->distinct()->pluck('causer_id'))
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();

        $events = [
            'created' => 'Criação',
            'updated' => 'Atualização',
            'deleted' => 'Exclusão',
            'restored' => 'Restauração',
        ];

        $activities->getCollection()->transform(fn (Activity $activity) => $this->appendMeta($activity));

        return view('admin.activity-logs.index', [
            'activities' => $activities,
            'modules' => self::MODULE_LABELS,
            'users' => $users,
            'events' => $events,
        ]);
    }

    public function export(Request $request): StreamedResponse|RedirectResponse
    {
        $from = (string) $request->string('from');
        $to = (string) $request->string('to');

        if ($from === '' || $to === '') {
            return redirect()
                ->route('admin.activity-logs.index', $request->query())
                ->with('erro', 'Para exportar, informe o período completo (De e Até).');
        }

        try {
            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate = Carbon::parse($to)->endOfDay();
        } catch (\Throwable) {
            return redirect()
                ->route('admin.activity-logs.index', $request->query())
                ->with('erro', 'Período inválido. Use datas válidas para exportação.');
        }

        if ($fromDate->gt($toDate)) {
            return redirect()
                ->route('admin.activity-logs.index', $request->query())
                ->with('erro', 'A data inicial não pode ser maior que a data final.');
        }

        if ($fromDate->diffInDays($toDate) > self::EXPORT_MAX_DAYS) {
            return redirect()
                ->route('admin.activity-logs.index', $request->query())
                ->with('erro', 'Período máximo para exportação é de 93 dias. Refine os filtros.');
        }

        $fileName = 'auditoria_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($request): void {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                return;
            }

            fputcsv($handle, [
                'id',
                'data_hora',
                'modulo',
                'evento',
                'descricao',
                'registro',
                'usuario',
                'subject_type',
                'subject_id',
                'causer_id',
                'campos_alterados',
            ], ';');

            $this->buildFilteredQuery($request)
                ->with(['causer', 'subject'])
                ->latest()
                ->chunk(500, function ($activities) use ($handle): void {
                    foreach ($activities as $activity) {
                        $activity = $this->appendMeta($activity);
                        $meta = $activity->meta;

                        fputcsv($handle, [
                            $activity->id,
                            $activity->created_at?->format('d/m/Y H:i:s'),
                            $meta['module_label'],
                            $meta['event_label'],
                            $activity->description,
                            $meta['subject_label'],
                            $activity->causer->name ?? 'Sistema',
                            $activity->subject_type,
                            $activity->subject_id,
                            $activity->causer_id,
                            implode(', ', array_map(fn (array $row): string => $row['key'], $meta['diff_rows'])),
                        ], ';');
                    }
                });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$fileName}\"");

        return $response;
    }

    public function show(Activity $activity): View
    {
        $activity->load(['causer', 'subject']);

        return view('admin.activity-logs.show', [
            'activity' => $this->appendMeta($activity),
        ]);
    }

    private function appendMeta(Activity $activity): Activity
    {
        $moduleKey = $this->resolveModuleKey($activity->subject_type);
        $properties = method_exists($activity->properties, 'toArray')
            ? $activity->properties->toArray()
            : (array) $activity->properties;

        $attributes = data_get($properties, 'attributes', []);
        $old = data_get($properties, 'old', []);
        $diffKeys = collect(array_keys($attributes))->merge(array_keys($old))->unique()->values()->all();
        $diffRows = $this->buildDiffRows($attributes, $old);

        $activity->setAttribute('meta', [
            'module_key' => $moduleKey,
            'module_label' => $moduleKey ? (self::MODULE_LABELS[$moduleKey] ?? $moduleKey) : class_basename((string) $activity->subject_type),
            'event_label' => $this->resolveEventLabel((string) $activity->event),
            'event_tone' => $this->resolveEventTone((string) $activity->event),
            'subject_label' => $this->resolveSubjectLabel($activity->subject, $attributes),
            'edit_url' => $this->resolveEditUrl($moduleKey, $activity->subject_id),
            'properties' => $properties,
            'attributes' => $attributes,
            'old' => $old,
            'diff_keys' => $diffKeys,
            'diff_rows' => $diffRows,
        ]);

        return $activity;
    }

    private function resolveModuleKey(?string $subjectType): ?string
    {
        return array_search($subjectType, self::MODULES, true) ?: null;
    }

    private function resolveEventLabel(string $event): string
    {
        return match ($event) {
            'created' => 'Criação',
            'updated' => 'Atualização',
            'deleted' => 'Exclusão',
            'restored' => 'Restauração',
            default => ucfirst($event),
        };
    }

    private function resolveEventTone(string $event): string
    {
        return match ($event) {
            'created' => 'emerald',
            'updated' => 'blue',
            'deleted' => 'red',
            'restored' => 'amber',
            default => 'slate',
        };
    }

    private function resolveEditUrl(?string $moduleKey, mixed $subjectId): ?string
    {
        if ($moduleKey === null || $subjectId === null || ! isset(self::EDIT_ROUTES[$moduleKey])) {
            return null;
        }

        return route(self::EDIT_ROUTES[$moduleKey], $subjectId);
    }

    private function resolveSubjectLabel(mixed $subject, array $attributes): string
    {
        foreach (['titulo', 'nome', 'mensagem', 'nome_secretario', 'descricao'] as $field) {
            $value = is_object($subject) ? data_get($subject, $field) : null;

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        foreach (['titulo', 'nome', 'mensagem', 'nome_secretario', 'descricao'] as $field) {
            $value = $attributes[$field] ?? null;

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        return 'Registro sem título identificável';
    }

    private function buildFilteredQuery(Request $request): Builder
    {
        $module = $request->string('module')->trim()->toString();
        $userId = $request->string('user_id')->trim()->toString();
        $event = $request->string('event')->trim()->toString();
        $from = $request->string('from')->trim()->toString();
        $to = $request->string('to')->trim()->toString();
        $queryText = $request->string('q')->trim()->toString();

        return Activity::query()
            ->when($request->filled('module') && $module !== '' && isset(self::MODULES[$module]), fn ($query) => $query->where('subject_type', self::MODULES[$module]))
            ->when($request->filled('user_id') && $userId !== '' && ctype_digit($userId), fn ($query) => $query->where('causer_type', User::class)->where('causer_id', (int) $userId))
            ->when($request->filled('event') && $event !== '', fn ($query) => $query->where('event', $event))
            ->when($request->filled('from') && $from !== '', fn ($query) => $query->whereDate('created_at', '>=', $from))
            ->when($request->filled('to') && $to !== '', fn ($query) => $query->whereDate('created_at', '<=', $to))
            ->when($request->filled('q') && $queryText !== '', function ($query) use ($queryText) {
                $query->where(function ($innerQuery) use ($queryText) {
                    $innerQuery
                        ->where('description', 'like', "%{$queryText}%")
                        ->orWhere('log_name', 'like', "%{$queryText}%")
                        ->orWhere('subject_type', 'like', "%{$queryText}%")
                        ->orWhere('event', 'like', "%{$queryText}%");
                });
            });
    }

    /**
     * @return list<array{key:string,sensitive:bool,old_display:string,new_display:string,changed:bool}>
     */
    private function buildDiffRows(array $attributes, array $old): array
    {
        $rows = [];

        foreach (collect(array_keys($attributes))->merge(array_keys($old))->unique()->values() as $key) {
            $oldValue = $old[$key] ?? null;
            $newValue = $attributes[$key] ?? null;

            $rows[] = [
                'key' => (string) $key,
                'sensitive' => $this->isSensitiveField((string) $key),
                'old_display' => $this->formatDiffValue($oldValue),
                'new_display' => $this->formatDiffValue($newValue),
                'changed' => $oldValue !== $newValue,
            ];
        }

        return $rows;
    }

    private function isSensitiveField(string $field): bool
    {
        $normalized = mb_strtolower($field);

        foreach (self::SENSITIVE_FIELD_HINTS as $hint) {
            if (str_contains($normalized, $hint)) {
                return true;
            }
        }

        return false;
    }

    private function formatDiffValue(mixed $value): string
    {
        if ($value === null) {
            return '∅';
        }

        if (is_bool($value)) {
            return $value ? 'Sim' : 'Não';
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        if (is_string($value)) {
            $timestamp = strtotime($value);

            if ($timestamp !== false && strlen($value) >= 10 && preg_match('/^\d{4}-\d{2}-\d{2}/', $value) === 1) {
                return date('d/m/Y H:i:s', $timestamp);
            }

            return trim($value) === '' ? '""' : $value;
        }

        if (is_array($value)) {
            return (string) json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return (string) json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}