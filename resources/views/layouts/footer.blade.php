<footer accesskey="4" tabindex="-1" class="bg-[#0f172a] text-slate-300 pt-16 pb-8 font-sans border-t border-slate-800 focus:outline-none">
    <div class="container max-w-7xl px-4 mx-auto">
        
        {{-- Grelha Principal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-x-8 gap-y-12 mb-12 text-center lg:text-left">

            {{-- 1. Logo e Informações de Contato --}}
            <div class="md:col-span-2 lg:col-span-2 lg:pr-6">
                {{-- mx-auto centraliza no mobile / lg:mx-0 alinha à esquerda no desktop --}}
                <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura Municipal de Assaí" class="h-16 md:h-20 w-auto object-contain mb-8 mx-auto lg:mx-0" loading="lazy" decoding="async" width="240" height="140">

                <address class="mb-6 text-sm leading-relaxed text-slate-400 not-italic">
                    <strong class="text-white">Prefeitura Municipal de Assaí</strong><br>
                    Av. Rio de Janeiro, 720 - Centro.<br>
                    CEP: 86220-000 | Assaí - PR
                </address>
                
                {{-- justify-center centraliza o flex no mobile --}}
                <div class="flex items-start justify-center lg:justify-start gap-3 mb-3 text-sm">
                    <svg class="w-5 h-5 text-yellow-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 1m6-1a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold text-white tracking-wide text-left">
                        <span class="sr-only">Horário de Atendimento:</span>
                        Segunda a Sexta:<br>08h às 11h30 e 13h às 17h
                    </span>
                </div>
                
                <div class="flex items-center justify-center lg:justify-start gap-3 mb-8 text-sm">
                    <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span class="font-bold text-white tracking-wide">
                        <span class="sr-only">Telefone:</span>
                        (43) 3262-1313
                    </span>
                </div>

                {{-- Redes Sociais --}}
                <div class="flex justify-center lg:justify-start gap-3">
                    <a href="https://www.facebook.com/prefeituraassai/" target="_blank" rel="noopener noreferrer" aria-label="Acessar Facebook da Prefeitura" class="flex items-center justify-center w-10 h-10 transition-all bg-slate-800 rounded-lg hover:bg-blue-600 hover:-translate-y-1 text-slate-300 hover:text-white focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" /></svg>
                    </a>
                    <a href="https://www.instagram.com/prefeituraassai/" target="_blank" rel="noopener noreferrer" aria-label="Acessar Instagram da Prefeitura" class="flex items-center justify-center w-10 h-10 transition-all bg-slate-800 rounded-lg hover:bg-pink-600 hover:-translate-y-1 text-slate-300 hover:text-white focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.88z" /></svg>
                    </a>
                    <a href="https://www.youtube.com/@prefeituradeassaiassai1062" target="_blank" rel="noopener noreferrer" aria-label="Acessar YouTube da Prefeitura" class="flex items-center justify-center w-10 h-10 transition-all bg-slate-800 rounded-lg hover:bg-red-600 hover:-translate-y-1 text-slate-300 hover:text-white focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a2.993 2.993 0 00-2.108-2.117C19.13 3.5 12 3.5 12 3.5s-7.13 0-9.39.569A2.993 2.993 0 00.502 6.186C0 8.446 0 12 0 12s0 3.554.502 5.814a2.993 2.993 0 002.108 2.117C4.87 20.5 12 20.5 12 20.5s7.13 0 9.39-.569a2.993 2.993 0 002.108-2.117C24 15.554 24 12 24 12s0-3.554-.502-5.814zM9.545 15.568V8.432l6.545 3.568-6.545 3.568z" /></svg>
                    </a>
                </div>
            </div>

            {{-- 2. Links - Serviços --}}
            <div class="space-y-4">
                <h3 class="mb-4 text-sm font-bold tracking-widest text-slate-100 uppercase font-heading">Serviços</h3>
                <nav aria-label="Navegação de Serviços">
                    <ul class="space-y-3 text-sm font-medium text-slate-400">
                        <li><a href="https://conecta.assai.pr.gov.br/" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Conecta Assaí</a></li>
                        <li><a href="https://gov.assai.pr.gov.br/" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Gov.Assaí</a></li>
                        <li><a href="https://conecta.assai.pr.gov.br/servico/99" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">IPTU                        <a href="https://www.govfacilcidadao.com.br/login" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Ouvidoria Municipal</a></a></li>
                        <li><a href="https://e-gov.betha.com.br/e-nota/login.faces" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Nota Fiscal</a></li>
                        <li><a href="{{ route('servicos.index') }}" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Serviços ao Cidadão</a></li>
                    </ul>
                </nav>
            </div>

            {{-- 3. Links - Legislação --}}
            <div class="space-y-4">
                <h3 class="mb-4 text-sm font-bold tracking-widest text-slate-100 uppercase font-heading">Legislação</h3>
                <nav aria-label="Navegação de Legislação">
                    <ul class="space-y-3 text-sm font-medium text-slate-400">
                        <li><a href="https://leis.org/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Leis Municipais</a></li>
                        <li><a href="https://www.assai.pr.gov.br/licitacoes" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Licitações</a></li>
                        <li><a href="https://valedosol.assai.pr.gov.br/lgpd" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Política de Privacidade</a></li>
                        <li><a href="{{ route('pages.acessibilidade') }}" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Acessibilidade</a></li>
                    </ul>
                </nav>
            </div>

            {{-- 4. Links - Transparência --}}
            <div class="space-y-4">
                <h3 class="mb-4 text-sm font-bold tracking-widest text-slate-100 uppercase font-heading">Transparência</h3>
                <nav aria-label="Navegação de Transparência">
                    <ul class="space-y-3 text-sm font-medium text-slate-400">
                        <li><a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Portal da Transparência</a></li>
                        <li><a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Diário Oficial</a></li>
                        <li><a href="https://www.govfacilcidadao.com.br/login" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Ouvidoria Municipal</a></li>
                        <li><a href="https://assai.atende.net/subportal/e-sic" target="_blank" rel="noopener noreferrer" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">e-SIC</a></li>
                    </ul>
                </nav>
            </div>

            {{-- 5. Links - Institucional --}}
            <div class="space-y-4">
                <h3 class="mb-4 text-sm font-bold tracking-widest text-slate-100 uppercase font-heading">Institucional</h3>
                <nav aria-label="Navegação Institucional">
                    <ul class="space-y-3 text-sm font-medium text-slate-400">
                        <li><a href="{{ route('pages.sobre') }}" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">A Cidade</a></li>
                        <li><a href="{{ route('pages.sobre') }}#simbolos" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Hino e Símbolos</a></li>
                        <li><a href="{{ route('pages.turismo') }}" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Turismo e Lazer</a></li>
                        <li><a href="{{ route('secretarias.index') }}" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Secretarias</a></li>
                        <li><a href="{{ route('contato.index') }}" class="rounded-sm transition-colors hover:text-yellow-400 focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:outline-none">Fale Conosco</a></li>
                    </ul>
                </nav>
            </div>

        </div>

        {{-- Fechamento / Barra Inferior --}}
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6 pt-8 border-t border-slate-800">
            <div class="text-center lg:text-left">
                <p class="text-[13px] text-slate-400">
                    &copy; {{ date('Y') }} Prefeitura Municipal de Assaí. Todos os direitos reservados.
                </p>
            </div>

            <div class="flex items-center gap-2.5 px-4 py-2 bg-slate-800/60 rounded-lg border border-slate-700 w-full lg:w-auto justify-center">
                <svg class="w-4 h-4 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="text-[11px] sm:text-xs font-bold text-slate-300 tracking-wide uppercase">Desenvolvido pela Secretaria de Ciência, Tecnologia e Inovação</span>
            </div>
        </div>
    </div>
</footer>