@extends('layouts.app')

@section('title', 'Política de Cookies - Prefeitura de Assaí')

@section('content')
<main class="py-16 bg-white min-h-screen" style="padding-top: calc(var(--site-header-height, 130px) + 3rem);">
    <div class="container max-w-4xl px-4 mx-auto font-sans text-slate-700">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-8 border-b border-slate-200 pb-4" style="font-family: 'Montserrat', sans-serif;">Política de Cookies</h1>
        
        <div class="prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-800">
            <p>Este portal utiliza cookies para otimizar o funcionamento técnico, aprimorar a experiência de navegação e coletar dados estatísticos agregados. Ao prosseguir, o usuário consente com a utilização destas tecnologias.</p>

            <h2>1. Definição Técnica</h2>
            <p>Cookies são fragmentos de dados armazenados no navegador do usuário. Servem para gerenciar sessões, manter preferências e rastrear padrões de uso.</p>

            <h2>2. Tipologia de Cookies Utilizados</h2>
            <table class="w-full text-left border-collapse mt-4 mb-8">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200">
                        <th class="p-3 font-semibold">Categoria</th>
                        <th class="p-3 font-semibold">Função</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm">
                    <tr>
                        <td class="p-3 font-bold">Estritamente Necessários</td>
                        <td class="p-3">Garantem as funções primárias do site (login, segurança, integridade da sessão). Não podem ser desativados.</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-bold">Desempenho e Analíticos</td>
                        <td class="p-3">Coletam dados anônimos sobre interações no portal (páginas visitadas, tempo de permanência), permitindo a otimização do fluxo de informação.</td>
                    </tr>
                    <tr>
                        <td class="p-3 font-bold">Funcionais</td>
                        <td class="p-3">Armazenam escolhas do usuário (como preferências de acessibilidade e alto contraste) para evitar reconfiguração a cada acesso.</td>
                    </tr>
                </tbody>
            </table>

            <h2>3. Gestão e Exclusão</h2>
            <p>O usuário pode, a qualquer momento, configurar seu navegador para bloquear a instalação de cookies ou alertá-lo quando um cookie estiver sendo enviado. Observa-se que a desativação de cookies estritamente necessários poderá comprometer funções estruturais do portal.</p>
        </div>
    </div>
</main>
@endsection