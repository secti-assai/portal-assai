<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GovAssaiAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'cpf'      => 'required',
            'password' => 'required',
        ]);

        try {
            $baseUrl = config('services.govassai.url', 'https://gov.assai.pr.gov.br');
            $secret  = config('services.govassai.portal_secret');

            $response = Http::withHeaders(array_filter([
                'Accept'          => 'application/json',
                'X-Portal-Secret' => $secret ?: null,
            ]))->timeout(10)->post($baseUrl . '/api/portal/login', [
                'cpf'      => preg_replace('/[^0-9]/', '', $request->cpf),
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                session(['gov_user' => [
                    'id'       => $data['user']['id']       ?? null,
                    'nome'     => $data['user']['name']      ?? 'Cidadão',
                    'nivel'    => $data['user']['nivel']     ?? 'Bronze',
                    'girassois'=> $data['user']['girassois'] ?? 0,
                    'cpf_mask' => $data['user']['cpf_mask']  ?? null,
                ]]);

                return back()->with('success', 'Login efetuado com sucesso! Bem-vindo ao Gov.Assaí.');
            }

            // Resposta de erro da API
            $errorMsg = $response->json('error') ?? 'Credenciais inválidas.';

            if ($response->status() === 404) {
                $errorMsg = 'CPF não cadastrado no Gov.Assaí. <a href="https://gov.assai.pr.gov.br/cadastro" target="_blank" class="underline">Crie sua conta</a>.';
            }

            return back()->with('gov_error', $errorMsg);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::warning('Gov.Assai fora do ar: ' . $e->getMessage());
            return back()->with('gov_error', 'O serviço Gov.Assaí está temporariamente indisponível. Tente novamente em instantes.');
        } catch (\Exception $e) {
            Log::error('Erro ao conectar com Gov.Assai: ' . $e->getMessage());
            return back()->with('gov_error', 'Erro interno. Tente novamente mais tarde.');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('gov_user');
        return back()->with('success', 'Você saiu da sua conta Gov.Assaí.');
    }
}
