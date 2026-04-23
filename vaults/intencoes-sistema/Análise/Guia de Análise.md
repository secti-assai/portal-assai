# Guia de Análise

## Queries Não Respondidas

Analisar regularmente queries que o sistema não conseguiu responder para identificar gaps.

### Comandos Úteis

```bash
# Ver todas as queries não respondidas
php artisan tinker
> App\Models\QueryNaoRespondida::orderBy('created_at', 'desc')->limit(20)->get()

# Queries com baixa confiança
> App\Models\QueryNaoRespondida::where('confianca', '<', 30)->get()
```

## Intenções Mais Usadas

```bash
php artisan tinker
> App\Models\Intencao::orderBy('uso_count', 'desc')->limit(10)->get()
```

## Próximas Ações

- [ ] Analisar queries não respondidas esta semana
- [ ] Atualizar intenções com baixo score
- [ ] Adicionar novas intenções para gaps encontrados
