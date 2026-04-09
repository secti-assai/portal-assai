@extends('layouts.app')

@section('title', 'Turismo e Lazer - Prefeitura Municipal de Assaí')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative pt-8 pb-20 overflow-hidden bg-blue-900 md:pt-12 md:pb-28 lg:pt-20 lg:pb-40">
    <div class="absolute inset-0">
        <svg class="absolute w-full h-full opacity-5" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="bamboo" width="40" height="40" patternUnits="userSpaceOnUse">
                    <rect x="18" y="0" width="4" height="40" fill="white" opacity="0.5"/>
                    <rect x="0" y="18" width="40" height="4" fill="white" opacity="0.3"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#bamboo)"/>
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-t from-blue-950 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto text-center max-w-5xl">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Turismo'],
        ]" dark />
        <span class="inline-flex items-center gap-2 px-5 py-2 mb-8 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-md">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
            Turismo e Cultura
        </span>
        <h1 class="text-4xl font-extrabold text-white md:text-6xl lg:text-7xl font-heading tracking-tight mb-6 leading-none">
            Descubra <span class="text-yellow-400">Assaí</span>
        </h1>
        <p class="max-w-3xl mx-auto text-lg text-blue-100 md:text-xl lg:text-2xl leading-relaxed font-light">
            Uma viagem imersiva pela tradição da imigração japonesa, natureza exuberante e a gastronomia nipônica mais autêntica do Norte do Paraná.
        </p>
        <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3 sm:gap-4 mt-10 w-full">
            <a href="#castelo" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 font-bold text-blue-900 transition bg-yellow-400 rounded-full hover:bg-yellow-300 hover:-translate-y-0.5 shadow-lg text-sm md:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                Explorar os Pontos Turísticos
            </a>
            <a href="{{ route('agenda.index') }}" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 font-bold text-white transition border-2 border-white/40 rounded-full hover:border-white hover:bg-white/10 text-sm md:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Ver Agenda de Eventos
            </a>
        </div>
    </div>
</section>

{{-- ===== DESTAQUES RÁPIDOS ===== --}}
<section class="relative z-20 -mt-16">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-4 md:gap-5">
            <div class="flex flex-col items-center justify-center p-5 text-center bg-slate-50 border rounded-2xl border-slate-400 ring-1 ring-slate-300/90 shadow-[0_10px_24px_rgba(15,23,42,0.16)] col-span-1">
                <span class="text-2xl md:text-3xl font-black text-blue-700 font-heading mb-1">🏯</span>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">1º Castelo Japonês</span>
                <span class="text-xs text-slate-600 mt-0.5">do Brasil</span>
            </div>
            <div class="flex flex-col items-center justify-center p-5 text-center bg-slate-50 border rounded-2xl border-slate-400 ring-1 ring-slate-300/90 shadow-[0_10px_24px_rgba(15,23,42,0.16)] col-span-1">
                <span class="text-2xl md:text-3xl font-black text-blue-700 font-heading mb-1">🌸</span>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">1º Tanabata Matsuri</span>
                <span class="text-xs text-slate-600 mt-0.5">do Brasil — 1978</span>
            </div>
            <div class="flex flex-col items-center justify-center p-5 text-center bg-slate-50 border rounded-2xl border-slate-400 ring-1 ring-slate-300/90 shadow-[0_10px_24px_rgba(15,23,42,0.16)] col-span-1">
                <span class="text-2xl md:text-3xl font-black text-blue-700 font-heading mb-1">⛩️</span>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Templo Budista</span>
                <span class="text-xs text-slate-600 mt-0.5">mais antigo do PR</span>
            </div>
            <div class="flex flex-col items-center justify-center p-5 text-center bg-yellow-400 border shadow-lg rounded-2xl border-yellow-600 ring-1 ring-yellow-500/40 col-span-1 sm:col-span-2 md:col-span-1">
                <span class="text-2xl md:text-3xl font-black text-blue-900 font-heading mb-1">🍜</span>
                <span class="text-xs font-bold text-blue-900 uppercase tracking-wider">Polo Gastronômico</span>
                <span class="text-xs text-blue-900 mt-0.5">nipônico do PR</span>
            </div>
        </div>
    </div>
</section>

{{-- ===== CASTELO JAPONÊS — DESTAQUE ===== --}}
<section id="castelo" class="py-16 bg-[#f8fbff] md:py-24 lg:py-32 border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="flex flex-col overflow-hidden bg-slate-50 border shadow-2xl rounded-3xl border-slate-300/70 ring-1 ring-slate-200/70 lg:flex-row">
            <div class="lg:w-1/2 relative min-h-[320px] lg:min-h-[540px] bg-slate-200">
                <img src="{{ asset('img/assai_1.jpg') }}" alt="Castelo Japonês de Assaí — Memorial da Imigração" class="absolute inset-0 object-cover w-full h-full transition duration-700 hover:scale-105" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent lg:bg-gradient-to-r lg:from-black/60 lg:via-black/10 lg:to-transparent"></div>
                <div class="absolute top-6 left-6">
                    <span class="px-3 py-1.5 text-xs font-bold tracking-wider text-emerald-900 uppercase bg-yellow-400 rounded-full shadow">Cartão Postal</span>
                </div>
                <div class="absolute bottom-6 left-6 lg:bottom-10 lg:left-10 text-white [text-shadow:0_2px_10px_rgba(0,0,0,0.6)]">
                    <p class="text-xs font-bold tracking-widest uppercase text-yellow-400 mb-1">Inaugurado em 2018</p>
                    <p class="text-2xl font-extrabold font-heading leading-tight !text-white">25 m de altura<br>4 pavimentos</p>
                </div>
            </div>
            <div class="flex flex-col justify-center p-8 lg:w-1/2 lg:p-14">
                <span class="inline-block text-emerald-700 font-bold tracking-wider uppercase text-xs border border-emerald-200 bg-emerald-50 px-3 py-1 rounded-full mb-4 w-fit">Memorial da Imigração Japonesa</span>
                <h2 class="mb-5 text-3xl font-extrabold text-slate-800 font-heading md:text-4xl leading-tight">
                    Castelo Japonês<br><span class="text-blue-700">— O Primeiro do Brasil</span>
                </h2>
                <div class="space-y-4 text-[15px] md:text-base leading-7 md:leading-relaxed text-slate-600">
                    <p>Erguido em 2018 para celebrar os <strong>110 anos da imigração japonesa no Brasil</strong>, o Castelo Japonês de Assaí é uma obra única: trata-se do <strong>primeiro castelo de arquitetura japonesa do país</strong>. Com 25 metros de altura distribuídos em 4 pavimentos majestosos, sua silhueta é inspirada no lendário <strong>Castelo de Himeji</strong>, na província de Hyogo — cidade coirmã do Paraná.</p>
                    <p>Posicionado no ponto mais alto de Assaí, oferece uma <strong>vista panorâmica de 360° deslumbrante</strong>. No seu interior, um museu histórico guarda relíquias, fotografias e documentos originais que narram a épica saga dos pioneiros japoneses que desbravaram estas terras em 1932.</p>
                </div>
                <div class="pt-6 mt-6 border-t border-slate-100 grid grid-cols-2 gap-3">
                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Visita Gratuita
                    </div>
                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Vista Panorâmica 360°
                    </div>
                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Ponto mais alto da cidade
                    </div>
                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Museu Histórico Interativo
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== POLO GASTRONÔMICO ===== --}}
<section class="py-20 bg-blue-950 md:py-28 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.04]">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="food-pattern" x="0" y="0" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="20" fill="none" stroke="white" stroke-width="1"/><circle cx="25" cy="25" r="10" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#food-pattern)"/></svg>
    </div>
    <div class="container relative z-10 px-4 mx-auto max-w-6xl">
        <div class="grid items-center grid-cols-1 gap-12 md:grid-cols-2">
            <div class="space-y-5 text-white">
                <span class="inline-block text-blue-200 font-bold tracking-wider uppercase text-xs border border-blue-600 bg-blue-800/60 px-3 py-1 rounded-full">Gastronomia</span>
                <h2 class="text-3xl font-extrabold font-heading md:text-4xl leading-tight !text-white">
                    Polo Gastronômico<br><span class="text-yellow-300">Nipônico do Paraná</span>
                </h2>
                <p class="text-blue-50 text-[15px] md:text-base leading-7 md:leading-relaxed">Assaí ostenta com orgulho o título de <strong class="text-white">cidade com a maior proporção de descendentes japoneses do Brasil</strong>. Isso tem um reflexo direto e delicioso na mesa: aqui, a culinária japonesa não é uma tendência — é uma herança de mais de 90 anos.</p>
                <p class="text-blue-50 text-[15px] md:text-base leading-7 md:leading-relaxed">Restaurantes familiares de receitas guardadas a sete chaves, centros gastronômicos como o <strong class="text-white">Assahí</strong>, yakitorias e doceiras artesanais de wagashi atraem visitantes de toda a região Norte do Paraná em busca dos sabores genuínos do Japão profundo.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    @php
                    $sabores = [
                        ['nome' => 'Sushi & Sashimi', 'icon' => '🍣', 'desc' => 'Ingredientes frescos'],
                        ['nome' => 'Ramen Artesanal', 'icon' => '🍜', 'desc' => 'Receita original'],
                        ['nome' => 'Wagashi', 'icon' => '🍡', 'desc' => 'Doces japoneses'],
                        ['nome' => 'Yakitori', 'icon' => '🍢', 'desc' => 'Churrasquinho japonês'],
                    ];
                    @endphp
                    @foreach($sabores as $s)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/15 border border-white/30">
                        <span class="text-2xl">{{ $s['icon'] }}</span>
                        <div>
                            <p class="text-white font-bold text-sm font-heading">{{ $s['nome'] }}</p>
                            <p class="text-blue-100 text-xs">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-3 font-bold text-blue-900 transition bg-yellow-400 rounded-full hover:bg-yellow-300 hover:-translate-y-0.5 shadow-lg text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Acompanhe a Nossa Agenda
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-2xl overflow-hidden aspect-square bg-yellow-600 flex flex-col items-center justify-center p-8 text-center hover:-translate-y-1 hover:shadow-xl transition">
                    <span class="text-6xl mb-4">🍣</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">Culinária Nipônica</p>
                    <p class="text-yellow-100 text-xs mt-1">Autêntica & Tradicional</p>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-square bg-emerald-700 flex flex-col items-center justify-center p-8 text-center hover:-translate-y-1 hover:shadow-xl transition">
                    <span class="text-6xl mb-4">🌿</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">Ingredientes Locais</p>
                    <p class="text-emerald-100 text-xs mt-1">Campo à Mesa</p>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-square bg-blue-700 flex flex-col items-center justify-center p-8 text-center hover:-translate-y-1 hover:shadow-xl transition">
                    <span class="text-6xl mb-4">👨‍🍳</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">Chefs de Família</p>
                    <p class="text-blue-200 text-xs mt-1">3ª Geração</p>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-square bg-indigo-700 flex flex-col items-center justify-center p-8 text-center hover:-translate-y-1 hover:shadow-xl transition">
                    <span class="text-6xl mb-4">🏆</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">Destino Gastronômico</p>
                    <p class="text-indigo-200 text-xs mt-1">Norte do Paraná</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== PASSEIOS E TRADIÇÃO ===== --}}
<section class="py-16 bg-[#eaf3ff] md:py-24 lg:py-28 border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="text-center mb-14">
            <span class="inline-block text-emerald-700 font-bold tracking-wider uppercase text-xs border border-emerald-200 bg-emerald-50 px-3 py-1 rounded-full mb-4">Roteiro Cultural</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Passeios e Tradição</h2>
            <p class="mt-4 text-base text-slate-700 max-w-2xl mx-auto">Parques arborizados, templos centenários e a alma nipônica de uma cidade única no Brasil.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            {{-- Parque Ikeda --}}
            <article class="tour-card group relative aspect-[3/4] overflow-hidden rounded-2xl bg-slate-900 shadow-xl">
                <img src="{{ asset('img/assai_2.jpg') }}" alt="Parque Ikeda — Assaí" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>

                <div class="card-cover absolute bottom-0 left-0 right-0 p-6 transition-opacity duration-300">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-300">🌿 Parque</span>
                    <h3 class="mt-1 text-2xl font-extrabold text-white font-heading">Parque Ikeda</h3>
                    <button type="button" onclick="toggleInteractiveCard(this)" class="mt-5 w-full rounded-xl border border-white/40 py-2.5 text-[11px] font-bold uppercase tracking-[0.18em] text-white transition hover:border-emerald-500 hover:bg-emerald-500 hover:text-slate-900">
                        Saiba Mais
                    </button>
                </div>

                <div class="details-panel card-panel absolute inset-0 z-20 bg-white p-6 transition-transform duration-500 ease-in-out flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600">Roteiro Cultural</span>
                            <button type="button" onclick="toggleInteractiveCard(this)" class="rounded-md border border-slate-200 px-2 py-1 text-xs transition hover:bg-slate-900 hover:text-white">—</button>
                        </div>
                        <h3 class="mt-4 text-2xl font-extrabold text-slate-900 font-heading">Parque Ikeda</h3>
                        <p class="mt-5 text-sm leading-relaxed text-slate-600">Um oásis verde de <strong>27 mil m²</strong> no coração de Assaí. A pista de caminhada contorna um lago sereno e leva ao imponente <strong>portal Torii</strong>, ideal para passeios em família.</p>
                        <ul class="mt-5 space-y-2">
                            <li class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-slate-600"><span class="h-1.5 w-1.5 bg-emerald-500"></span> Trilha de Caminhada</li>
                            <li class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-slate-600"><span class="h-1.5 w-1.5 bg-emerald-500"></span> Portal Torii</li>
                        </ul>
                    </div>
                </div>
            </article>

            {{-- Shoshinji --}}
            <article class="tour-card group relative aspect-[3/4] overflow-hidden rounded-2xl bg-slate-900 shadow-xl">
                <img src="{{ asset('img/assai_3.jpg') }}" alt="Templo Budista Shoshinji — Assaí" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>

                <div class="card-cover absolute bottom-0 left-0 right-0 p-6 transition-opacity duration-300">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-300">⛩️ Templo</span>
                    <h3 class="mt-1 text-2xl font-extrabold text-white font-heading">Templo Shoshinji</h3>
                    <button type="button" onclick="toggleInteractiveCard(this)" class="mt-5 w-full rounded-xl border border-white/40 py-2.5 text-[11px] font-bold uppercase tracking-[0.18em] text-white transition hover:border-indigo-500 hover:bg-indigo-500 hover:text-slate-900">
                        Saiba Mais
                    </button>
                </div>

                <div class="details-panel card-panel absolute inset-0 z-20 bg-white p-6 transition-transform duration-500 ease-in-out flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-600">Patrimônio Cultural</span>
                            <button type="button" onclick="toggleInteractiveCard(this)" class="rounded-md border border-slate-200 px-2 py-1 text-xs transition hover:bg-slate-900 hover:text-white">—</button>
                        </div>
                        <h3 class="mt-4 text-2xl font-extrabold text-slate-900 font-heading">Templo Shoshinji</h3>
                        <p class="mt-5 text-sm leading-relaxed text-slate-600">O <strong>templo budista em atividade mais antigo do Paraná</strong>, inaugurado em 1948 e construído em madeira pelos próprios fiéis, preserva arquitetura nipônica original e ambiente de contemplação.</p>
                        <ul class="mt-5 space-y-2">
                            <li class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-slate-600"><span class="h-1.5 w-1.5 bg-indigo-500"></span> Madeira original de 1948</li>
                            <li class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-slate-600"><span class="h-1.5 w-1.5 bg-indigo-500"></span> Espaço para Meditação</li>
                        </ul>
                    </div>
                </div>
            </article>

            {{-- Praça da Matriz --}}
            <article class="tour-card group relative aspect-[3/4] overflow-hidden rounded-2xl bg-slate-900 shadow-xl">
                <img src="{{ asset('img/igreja_matriz.jpg') }}" alt="Praça da Matriz — Assaí" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>

                <div class="card-cover absolute bottom-0 left-0 right-0 p-6 transition-opacity duration-300">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-yellow-300">🏛️ Praça</span>
                    <h3 class="mt-1 text-2xl font-extrabold text-white font-heading">Praça da Matriz</h3>
                    <button type="button" onclick="toggleInteractiveCard(this)" class="mt-5 w-full rounded-xl border border-white/40 py-2.5 text-[11px] font-bold uppercase tracking-[0.18em] text-white transition hover:border-yellow-500 hover:bg-yellow-500 hover:text-slate-900">
                        Saiba Mais
                    </button>
                </div>

                <div class="details-panel card-panel absolute inset-0 z-20 bg-white p-6 transition-transform duration-500 ease-in-out flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-yellow-600">Centro Histórico</span>
                            <button type="button" onclick="toggleInteractiveCard(this)" class="rounded-md border border-slate-200 px-2 py-1 text-xs transition hover:bg-slate-900 hover:text-white">—</button>
                        </div>
                        <h3 class="mt-4 text-2xl font-extrabold text-slate-900 font-heading">Praça da Matriz</h3>
                        <p class="mt-5 text-sm leading-relaxed text-slate-600">O coração de Assaí. A <strong>Igreja Matriz São José</strong> domina a praça central, onde toda quarta-feira acontece a tradicional <strong>Feira Teia da Cidadania</strong> com artesanato e produtos locais.</p>
                        <ul class="mt-5 space-y-2">
                            <li class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-slate-600"><span class="h-1.5 w-1.5 bg-yellow-500"></span> Igreja desde 1944</li>
                            <li class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-slate-600"><span class="h-1.5 w-1.5 bg-yellow-500"></span> Feira às Quartas</li>
                        </ul>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- ===== FESTIVIDADES ===== --}}
<section class="py-20 bg-[#f8fbff] md:py-28 border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="text-center mb-14">
            <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-indigo-700 bg-indigo-600 px-3 py-1 rounded-full mb-4">Calendário Cultural</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Festividades Inesquecíveis</h2>
            <p class="mt-4 text-base text-slate-700 max-w-2xl mx-auto">Assaí celebra o ano inteiro com eventos únicos que misturam tradição japonesa, agropecuária e muita animação.</p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div class="group relative p-7 rounded-2xl border border-slate-300/70 ring-1 ring-slate-200/70 bg-slate-50 hover:-translate-y-1 hover:shadow-lg transition duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 text-8xl opacity-10 leading-none font-black font-heading text-yellow-500 select-none">🌾</div>
                <div class="relative z-10">
                    <div class="flex items-center justify-center w-12 h-12 text-yellow-700 bg-yellow-200 rounded-xl mb-5 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-yellow-600 uppercase tracking-wider">Junho · Agro & Cultura</span>
                    <h4 class="text-xl font-extrabold text-slate-800 font-heading mt-1 mb-3">ExpoAsa</h4>
                    <p class="text-sm text-slate-700 leading-relaxed">Realizada desde <strong>1943</strong>, é considerada a <strong>exposição agropecuária mais antiga do Brasil</strong>. Durante dias, a cidade ferve com shows artísticos, leilões, gastronomia típica e tecnologia rural — uma celebração viva do orgulho do campo assaiense.</p>
                </div>
            </div>

            <div class="group relative p-7 rounded-2xl border border-slate-300/70 ring-1 ring-slate-200/70 bg-slate-50 hover:-translate-y-1 hover:shadow-lg transition duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 text-8xl opacity-10 leading-none font-black font-heading text-blue-500 select-none">🎋</div>
                <div class="relative z-10">
                    <div class="flex items-center justify-center w-12 h-12 text-blue-700 bg-blue-200 rounded-xl mb-5 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Outubro · Tradicional</span>
                    <h4 class="text-xl font-extrabold text-slate-800 font-heading mt-1 mb-3">Tanabata Matsuri</h4>
                    <p class="text-sm text-slate-700 leading-relaxed">A <strong>primeira festa de Tanabata do Brasil</strong> nasceu em Assaí em 1978! Adultos e crianças registram seus sonhos em tanzaku coloridos e os dependuram em galhos de bambu. Uma noite mágica de estrelas, yukata e tradição centenária.</p>
                </div>
            </div>

            <div class="group relative p-7 rounded-2xl border border-slate-300/70 ring-1 ring-slate-200/70 bg-slate-50 hover:-translate-y-1 hover:shadow-lg transition duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 text-8xl opacity-10 leading-none font-black font-heading text-pink-500 select-none">🎶</div>
                <div class="relative z-10">
                    <div class="flex items-center justify-center w-12 h-12 text-pink-700 bg-pink-200 rounded-xl mb-5 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    </div>
                    <span class="text-xs font-bold text-pink-600 uppercase tracking-wider">Agosto & Novembro · Ancestral</span>
                    <h4 class="text-xl font-extrabold text-slate-800 font-heading mt-1 mb-3">Bon Odori</h4>
                    <p class="text-sm text-slate-700 leading-relaxed">Dança sagrada da cultura japonesa para <strong>honrar e celebrar os antepassados</strong>. As ruas de Assaí se transformam com yukatas coloridas, tambores Taiko e coreografias que emocionam. Única no Estado, a festa acontece duas vezes por ano — uma raridade no Brasil.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section class="py-20 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-950 md:py-24 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="dots2" width="30" height="30" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="1.5" fill="white"/></pattern></defs><rect width="100%" height="100%" fill="url(#dots2)"/></svg>
    </div>
    <div class="container relative z-10 px-4 mx-auto max-w-4xl text-center">
        <p class="text-yellow-400 font-bold tracking-widest uppercase text-xs mb-6">Assaí espera por você</p>
        <h2 class="text-4xl font-extrabold font-heading md:text-5xl leading-tight mb-6 !text-white [text-shadow:0_2px_10px_rgba(0,0,0,0.45)]">
            Planeje a sua visita<br>ao coração japonês do Paraná.
        </h2>
        <p class="text-blue-100 text-lg leading-relaxed max-w-2xl mx-auto mb-10">
            A 46&nbsp;km de Londrina e 339&nbsp;km de Curitiba, Assaí combina história, natureza e sabores únicos numa experiência turística que você não vai esquecer.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 px-7 py-3 md:py-3.5 font-bold text-blue-900 transition bg-yellow-400 rounded-full hover:bg-yellow-300 hover:-translate-y-0.5 shadow-lg text-sm md:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Ver na Agenda
            </a>
            <a href="{{ route('pages.sobre') }}" class="inline-flex items-center gap-2 px-7 py-3 md:py-3.5 font-bold text-white transition border-2 border-white/40 rounded-full hover:border-white hover:bg-white/10 text-sm md:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Conheça a História
            </a>
        </div>
    </div>
</section>

<style>
    .tour-card .card-panel {
        transform: translateY(100%);
    }

    .tour-card.card-open .card-panel {
        transform: translateY(0);
    }

    .tour-card.card-open .card-cover {
        opacity: 0;
        pointer-events: none;
    }
</style>

<script>
    function toggleInteractiveCard(button) {
        const card = button.closest('.tour-card');
        if (!card) return;

        card.classList.toggle('card-open');
    }
</script>

@endsection