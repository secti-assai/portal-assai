<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração Gov.Assaí</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-slate-100 font-sans">

    <div class="w-full max-w-md p-8 bg-white border shadow-2xl rounded-2xl border-slate-200">
        
        <div class="flex flex-col items-center mb-8">
            <div class="flex items-center justify-center w-16 h-16 mb-4 text-white bg-blue-900 rounded-full shadow-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800">Gov.Assaí</h1>
            <p class="text-sm font-medium text-slate-500">Acesso Restrito ao Painel</p>
        </div>

        @if ($errors->any())
            <div class="p-3 mb-6 text-sm font-medium text-red-700 bg-red-100 border-l-4 border-red-500 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('authenticate') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block mb-1 text-sm font-bold text-slate-700">E-mail Institucional</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none bg-slate-50 focus:bg-white transition">
            </div>

            <div>
                <label for="password" class="block mb-1 text-sm font-bold text-slate-700">Senha</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none bg-slate-50 focus:bg-white transition">
            </div>

            <button type="submit" class="w-full py-3.5 mt-2 font-bold text-white transition shadow-lg bg-blue-600 rounded-xl hover:bg-blue-700 hover:-translate-y-0.5">
                Entrar no Sistema
            </button>
        </form>

        <div class="mt-8 text-xs text-center text-slate-400">
            &copy; {{ date('Y') }} Prefeitura Municipal de Assaí.<br>Secretaria de Ciência, Tecnologia e Inovação.
        </div>
    </div>

</body>
</html>