@extends('layouts.app')

@section('title', 'Lei Geral de Proteção de Dados - Prefeitura de Assaí')

@section('content')
<main class="py-16 bg-white min-h-screen" style="padding-top: calc(var(--site-header-height, 130px) + 3rem);">
    <div class="container max-w-4xl px-4 mx-auto font-sans text-slate-700">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-8 border-b border-slate-200 pb-4" style="font-family: 'Montserrat', sans-serif;">Lei Geral de Proteção de Dados (LGPD)</h1>
        
        <div class="prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-800 prose-a:text-[#006eb7] prose-a:no-underline hover:prose-a:underline">
            <p>A Prefeitura Municipal de Assaí, em conformidade com a Lei Federal nº 13.709/2018 (Lei Geral de Proteção de Dados Pessoais - LGPD), estabelece diretrizes rigorosas para o tratamento de dados pessoais dos cidadãos, garantindo privacidade, transparência e segurança jurídica.</p>

            <h2>Princípios do Tratamento de Dados</h2>
            <ul>
                <li><strong>Finalidade e Adequação:</strong> O tratamento de dados é realizado estritamente para propósitos legítimos, específicos e informados.</li>
                <li><strong>Necessidade:</strong> Coleta limitada ao mínimo necessário para a realização das finalidades.</li>
                <li><strong>Livre Acesso e Transparência:</strong> Garantia aos titulares de informações claras e precisas sobre o tratamento de seus dados.</li>
                <li><strong>Segurança:</strong> Aplicação de medidas técnicas e administrativas aptas a proteger os dados de acessos não autorizados.</li>
            </ul>

            <h2>Direitos do Titular</h2>
            <p>O titular dos dados pessoais tem direito a obter da Prefeitura, a qualquer momento, mediante requisição formal:</p>
            <ul>
                <li>Confirmação da existência de tratamento;</li>
                <li>Acesso aos dados;</li>
                <li>Correção de dados incompletos, inexatos ou desatualizados;</li>
                <li>Anonimização, bloqueio ou eliminação de dados desnecessários;</li>
                <li>Revogação do consentimento, nos termos da lei.</li>
            </ul>

            <h2>Encarregado de Proteção de Dados (DPO)</h2>
            <p>Para o exercício dos direitos dos titulares ou esclarecimento de dúvidas sobre a aplicação da LGPD no município, contate o Encarregado de Proteção de Dados através do canal da Ouvidoria Municipal ou e-SIC.</p>
        </div>
    </div>
</main>
@endsection