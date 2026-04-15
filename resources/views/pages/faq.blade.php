@extends('layouts.app')

@section('title', 'FAQ & Ajuda - Prefeitura de Assaí')

@section('content')
<main class="py-16 bg-slate-50 min-h-screen" style="padding-top: calc(var(--site-header-height, 130px) + 3rem);">
    <div class="container max-w-4xl px-4 mx-auto font-sans">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4" style="font-family: 'Montserrat', sans-serif;">Dúvidas Frequentes (FAQ)</h1>
        <p class="text-slate-600 mb-10 text-lg">Respostas para as perguntas mais comuns sobre os serviços digitais da Prefeitura Municipal de Assaí.</p>

        <div class="space-y-4">
            <details class="group border border-slate-200 bg-white rounded-lg shadow-sm [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-slate-900 font-bold hover:bg-slate-50 transition-colors">
                    <span style="font-family: 'Rawline', 'Open Sans', sans-serif;">Como emito a Nota Fiscal Eletrônica?</span>
                    <i class="fa-solid fa-chevron-down shrink-0 transition duration-300 group-open:-rotate-180"></i>
                </summary>
                <div class="px-5 pb-5 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    A emissão é feita através do portal e-Nota. Acesse a aba "Serviços ao Cidadão" e clique em "Nota Fiscal Eletrônica". É necessário possuir cadastro prévio junto ao departamento de tributação municipal.
                </div>
            </details>

            <details class="group border border-slate-200 bg-white rounded-lg shadow-sm [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-slate-900 font-bold hover:bg-slate-50 transition-colors">
                    <span style="font-family: 'Rawline', 'Open Sans', sans-serif;">Como consultar e emitir a guia do IPTU?</span>
                    <i class="fa-solid fa-chevron-down shrink-0 transition duration-300 group-open:-rotate-180"></i>
                </summary>
                <div class="px-5 pb-5 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Acesse o portal Conecta Assaí, selecione "IPTU Digital" e insira o número do cadastro do imóvel ou o CPF/CNPJ do proprietário para gerar o boleto atualizado.
                </div>
            </details>

            <details class="group border border-slate-200 bg-white rounded-lg shadow-sm [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-5 text-slate-900 font-bold hover:bg-slate-50 transition-colors">
                    <span style="font-family: 'Rawline', 'Open Sans', sans-serif;">Como registrar uma solicitação na Ouvidoria?</span>
                    <i class="fa-solid fa-chevron-down shrink-0 transition duration-300 group-open:-rotate-180"></i>
                </summary>
                <div class="px-5 pb-5 text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Utilize o link "Ouvidoria Municipal" no rodapé do site. Você será redirecionado para a plataforma GovFácil, onde poderá registrar denúncias, reclamações, sugestões ou elogios de forma anônima ou identificada.
                </div>
            </details>
        </div>
    </div>
</main>
@endsection