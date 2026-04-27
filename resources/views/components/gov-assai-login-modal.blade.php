<div x-data="{ modalSouAssaiense: {{ session()->has('gov_error') ? 'true' : 'false' }} }" 
     @open-modal-sou-assaiense.window="modalSouAssaiense = true"
     @keydown.escape.window="modalSouAssaiense = false" 
     x-show="modalSouAssaiense"
     class="fixed inset-0 z-[2147483647] flex items-center justify-center bg-slate-900/70 backdrop-blur-sm" 
     x-cloak
     role="dialog" aria-modal="true" aria-labelledby="modal-sou-assaiense-title">

    <div @click.away="modalSouAssaiense = false" 
         x-show="modalSouAssaiense" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl flex flex-col font-sans overflow-hidden">

        <header class="flex flex-col items-center justify-center px-6 py-8 border-b border-slate-100 bg-slate-50 relative">
            <button type="button" @click="modalSouAssaiense = false" aria-label="Fechar"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none bg-white rounded-full p-2 shadow-sm border border-slate-100 transition-colors">
                <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
            </button>
            <img src="{{ asset('img/gov.assai.png') }}" class="h-10 w-auto mb-3" alt="Gov.Assaí">
            <h2 id="modal-sou-assaiense-title" class="text-xl font-bold text-blue-900 text-center"
                style="font-family: 'Montserrat', sans-serif;">
                Entrar com Gov.Assaí
            </h2>
            <p class="text-sm text-slate-500 mt-1 text-center">Acesse os serviços digitais de Assaí</p>
        </header>

        <form action="{{ route('govassai.login') }}" method="POST" class="p-6 flex flex-col gap-5">
            @csrf

            {{-- Mensagem de erro da API --}}
            @if(session('gov_error'))
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mt-0.5 shrink-0 text-red-500"></i>
                <span>{!! session('gov_error') !!}</span>
            </div>
            @endif

            @if($errors->has('cpf') || $errors->has('password'))
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-700">
                <i class="fa-solid fa-circle-exclamation mt-0.5 shrink-0 text-red-500"></i>
                <span>{{ $errors->first('cpf') ?: $errors->first('password') }}</span>
            </div>
            @endif

            <div class="flex flex-col gap-1.5">
                <label for="gov-cpf" class="text-xs font-bold text-slate-500 uppercase tracking-wide">CPF</label>
                <div class="relative">
                    <i class="fa-regular fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="text" id="gov-cpf" name="cpf" placeholder="000.000.000-00" required
                        value="{{ old('cpf') }}"
                        class="w-full border border-slate-300 rounded-lg pl-10 pr-4 py-3 text-sm text-slate-700 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all"
                        autocomplete="off">
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="gov-password" class="text-xs font-bold text-slate-500 uppercase tracking-wide">Senha</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="password" id="gov-password" name="password" placeholder="Sua senha do Gov.Assaí" required
                        class="w-full border border-slate-300 rounded-lg pl-10 pr-4 py-3 text-sm text-slate-700 bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all">
                </div>
            </div>

            <div class="flex items-center justify-between mt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-600">
                    <span class="text-sm text-slate-600">Lembrar de mim</span>
                </label>
                <a href="https://gov.assai.pr.gov.br/password/reset" target="_blank" class="text-sm font-semibold text-blue-600 hover:underline">Esqueceu a senha?</a>
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full px-6 py-3.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-1 flex items-center justify-center gap-2 transition-colors shadow-md">
                    <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i> Entrar
                </button>
            </div>

            <div class="border-t border-slate-100 pt-5 mt-2 text-center">
                <p class="text-sm text-slate-600">Não tem conta?</p>
                <a href="https://gov.assai.pr.gov.br/cadastro" target="_blank" class="inline-flex items-center gap-2 mt-2 px-6 py-2.5 text-sm font-bold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                    <i class="fa-solid fa-user-plus"></i> Criar conta Gov.Assaí
                </a>
            </div>
        </form>
    </div>
</div>
