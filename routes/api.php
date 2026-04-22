<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiChatController;
use App\Http\Controllers\BuscaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas de Chat IA (sem autenticação obrigatória)
Route::prefix('ai-chat')->group(function () {
    Route::post('/conversation', [AiChatController::class, 'getOrCreateConversation'])->name('ai-chat.create');
    Route::post('/send', [AiChatController::class, 'sendMessage'])->name('ai-chat.send');
    Route::get('/messages', [AiChatController::class, 'getMessages'])->name('ai-chat.messages');
    Route::post('/clear', [AiChatController::class, 'clearConversation'])->name('ai-chat.clear');
});

// Rotas de Busca Inteligente
Route::prefix('ia')->group(function () {
    // Endpoints públicos (testes)
    Route::get('/health', [BuscaController::class, 'health']);
    Route::post('/teste-perguntar', [BuscaController::class, 'testePerguntar']);

    // Endpoints protegidos por API Key
    Route::middleware('api.key')->group(function () {
        Route::post('/perguntar', [BuscaController::class, 'perguntar']);
        Route::post('/reindex', [BuscaController::class, 'reindex']);
        Route::get('/stats/tokens', [BuscaController::class, 'statsTokens']);
        Route::get('/stats/token/{token}', [BuscaController::class, 'statsToken']);
        Route::post('/stats/clear', [BuscaController::class, 'statsClear']);
    });
});
