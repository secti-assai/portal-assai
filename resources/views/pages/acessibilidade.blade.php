@extends('layouts.app')

@section('title', 'Acessibilidade - Prefeitura Municipal de Assaí')

@section('content')
<section class="py-12 bg-blue-900 md:py-20">
    <div class="container px-4 mx-auto max-w-5xl text-center">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Acessibilidade'],
        ]" dark />
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading">Acessibilidade</h1>
        <p class="mt-4 text-lg text-blue-100 max-w-2xl mx-auto">
            Diretrizes e ferramentas disponibilizadas para garantir o acesso universal à informação no portal da Prefeitura Municipal de Assaí.
        </p>
    </div>
</section>

<main id="conteudo-principal" accesskey="1" tabindex="-1" class="py-12 bg-gray-50 md:py-16">
    <div class="container px-4 mx-auto max-w-4xl">
        <div class="p-8 bg-white border border-gray-100 shadow-sm rounded-3xl md:p-12 prose prose-blue max-w-none">
            
            <h2>Compromisso com a Inclusão</h2>
            <p>Este portal foi desenvolvido seguindo as diretrizes do <strong>Modelo de Acessibilidade em Governo Eletrônico (e-MAG)</strong>, alinhado às normas internacionais de acessibilidade na web (WCAG). O objetivo arquitetural é garantir que todos os cidadãos, independentemente de limitações físicas, motoras ou sensoriais, possam navegar e consumir os serviços públicos de forma autônoma.</p>

            <hr class="my-8 border-gray-200">

            <h2>Ferramentas Disponíveis</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-8 not-prose">
                <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-100 text-blue-700 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">Alto Contraste</h3>
                    <p class="text-sm text-gray-600">Altera o esquema de cores do site para alto contraste, facilitando a leitura para pessoas com baixa visão, operando via inversão CSS nativa.</p>
                </div>
                
                <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-100 text-blue-700 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">Tamanho da Fonte</h3>
                    <p class="text-sm text-gray-600">Controles paramétricos no topo da página permitem redimensionar o texto dinamicamente (rem/em) para melhor legibilidade.</p>
                </div>

                <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-100 text-blue-700 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">VLibras</h3>
                    <p class="text-sm text-gray-600">Integração com a suíte VLibras do Governo Federal, traduzindo conteúdos estruturais para a Língua Brasileira de Sinais.</p>
                </div>
            </div>

            <hr class="my-8 border-gray-200">

            <h2>Atalhos de Teclado (Accesskeys)</h2>
            <p>A navegação rápida por âncoras é garantida pela padronização de atalhos HTML. A combinação de teclas de disparo varia conforme o *User Agent* (navegador) e o sistema operacional.</p>
            
            <div class="overflow-x-auto not-prose my-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-200 text-gray-700">
                            <th class="p-4 font-bold rounded-tl-xl">Âncora de Destino</th>
                            <th class="p-4 font-bold">Atalho (Accesskey)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <tr class="border-b border-gray-100">
                            <td class="p-4">Ir para o conteúdo principal</td>
                            <td class="p-4"><kbd class="px-2 py-1 text-sm font-mono bg-gray-200 rounded text-black font-bold">1</kbd></td>
                        </tr>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <td class="p-4">Ir para o menu principal de navegação</td>
                            <td class="p-4"><kbd class="px-2 py-1 text-sm font-mono bg-gray-200 rounded text-black font-bold">2</kbd></td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="p-4">Ir para a busca do portal</td>
                            <td class="p-4"><kbd class="px-2 py-1 text-sm font-mono bg-gray-200 rounded text-black font-bold">3</kbd></td>
                        </tr>
                        <tr>
                            <td class="p-4 rounded-bl-xl">Ir para o rodapé (contatos globais)</td>
                            <td class="p-4"><kbd class="px-2 py-1 text-sm font-mono bg-gray-200 rounded text-black font-bold">4</kbd></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>Comandos de Execução por Navegador:</h3>
            <ul>
                <li><strong>Chrome / Edge (Windows/Linux):</strong> <kbd>Alt</kbd> + <kbd>Accesskey</kbd></li>
                <li><strong>Firefox (Windows/Linux):</strong> <kbd>Alt</kbd> + <kbd>Shift</kbd> + <kbd>Accesskey</kbd></li>
                <li><strong>Safari / Chrome (macOS):</strong> <kbd>Control</kbd> + <kbd>Option</kbd> + <kbd>Accesskey</kbd></li>
            </ul>
        </div>
    </div>
</main>
@endsection