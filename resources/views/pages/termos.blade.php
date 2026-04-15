@extends('layouts.app')

@section('title', 'Termos de Uso - Prefeitura de Assaí')

@section('content')
<main class="py-16 bg-white min-h-screen" style="padding-top: calc(var(--site-header-height, 130px) + 3rem);">
    <div class="container max-w-4xl px-4 mx-auto font-sans text-slate-700">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-8 border-b border-slate-200 pb-4" style="font-family: 'Montserrat', sans-serif;">Termos de Uso do Portal</h1>
        
        <div class="prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-800">
            <p>O acesso e uso do Portal da Prefeitura Municipal de Assaí são regulados por estes Termos de Uso. A navegação pelas páginas institucionais implica na aceitação integral destas normativas.</p>

            <h2>1. Escopo e Propósito</h2>
            <p>O portal tem a finalidade de disponibilizar informações institucionais, serviços eletrônicos, publicações legais e canais de comunicação oficiais para garantir transparência administrativa e simplificar o acesso do cidadão aos serviços públicos.</p>

            <h2>2. Responsabilidades do Cidadão (Usuário)</h2>
            <ul>
                <li>Utilizar o portal e os serviços de forma idônea, respeitando a legislação vigente.</li>
                <li>Fornecer dados precisos e verdadeiros ao preencher formulários e acessar serviços eletrônicos vinculados ao município.</li>
                <li>Preservar o sigilo de credenciais de acesso aos sistemas autenticados (como Nota Fiscal e Portal do Contribuinte).</li>
            </ul>

            <h2>3. Responsabilidades da Administração Pública</h2>
            <ul>
                <li>Manter o sistema disponível, salvo interrupções necessárias para manutenção técnica ou por razões de força maior.</li>
                <li>Proteger a confidencialidade dos dados transitados, em consonância com a Política de Privacidade e a LGPD.</li>
                <li>Garantir a veracidade e temporalidade das informações fiscais e legislativas publicadas nos diários oficiais do domínio.</li>
            </ul>

            <h2>4. Direitos Autorais e Propriedade Intelectual</h2>
            <p>Todos os elementos visuais, código-fonte, textos, fotografias e brasões disponíveis neste domínio são protegidos por legislação de propriedade intelectual. É permitida a reprodução de textos normativos e informativos para fins educativos ou informativos, desde que citada a fonte original (Prefeitura Municipal de Assaí).</p>

            <h2>5. Modificações dos Termos</h2>
            <p>A Prefeitura de Assaí reserva-se o direito de alterar os presentes Termos de Uso a qualquer momento, visando o aprimoramento jurídico e tecnológico do sistema. O uso contínuo do site após atualizações caracteriza aceitação do novo texto legal.</p>
        </div>
    </div>
</main>
@endsection