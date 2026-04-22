<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Configuração da API IA Externa
    |--------------------------------------------------------------------------
    |
    | URL da API externa que processará as mensagens inteligentes
    | Exemplo: http://127.0.0.1:8001
    |
    */

    'external_api' => [
        'url' => env('IA_API_URL', 'http://127.0.0.1:8001'),
        'timeout' => env('IA_API_TIMEOUT', 30),
        'token' => env('IA_API_TOKEN', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Local
    |--------------------------------------------------------------------------
    |
    | Se verdadeiro, usará respostas locais quando API externa falhar
    |
    */
    'use_local_fallback' => env('IA_USE_LOCAL_FALLBACK', true),
];
