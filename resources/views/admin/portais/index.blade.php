@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">
    <x-admin.page-header title="Gestão de Portais" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Portais']]">
        <x-slot:action>
            <a href="{{ route('admin.portais.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                Novo Portal
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('success'))
        <div class="p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl">{{ session('success') }}</div>
    @endif

    <div class="bg-white border shadow-sm rounded-xl border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse table-fixed">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-200">
                    <th class="p-4 w-20">Ícone</th>
                    <th class="p-4">Título</th>
                    <th class="p-4">URL</th>
                    <th class="p-4 w-32">Status</th>
                    <th class="p-4 w-32 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($portais as $portal)
                <tr class="hover:bg-slate-50">
                    <td class="p-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg border border-blue-100">
                            <i class="fa-solid {{ $portal->icone ?? 'fa-circle-nodes' }} text-xl"></i>
                        </div>
                    </td>
                    <td class="p-4 font-bold text-slate-800 truncate">{{ $portal->titulo }}</td>
                    <td class="p-4 truncate">
                        <a href="{{ $portal->url }}" target="_blank" class="text-blue-500 hover:underline">{{ $portal->url }}</a>
                    </td>
                    <td class="p-4">
                        <button onclick="togglePortal({{ $portal->id }})" id="status-btn-{{ $portal->id }}" class="px-2 py-0.5 rounded text-[11px] font-bold {{ $portal->ativo ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $portal->ativo ? 'Ativo' : 'Inativo' }}
                        </button>
                    </td>
                    <td class="p-4 text-center flex items-center justify-center gap-2">
                        <a href="{{ route('admin.portais.edit', $portal->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Editar">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.portais.destroy', $portal->id) }}" method="POST" onsubmit="return confirm('Excluir este portal?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Excluir">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    function togglePortal(id) {
        fetch(`/admin/portais/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const btn = document.getElementById(`status-btn-${id}`);
            if (data.ativo) {
                btn.className = 'px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800';
                btn.textContent = 'Ativo';
            } else {
                btn.className = 'px-2 py-0.5 rounded text-[11px] font-bold bg-rose-100 text-rose-800';
                btn.textContent = 'Inativo';
            }
        });
    }
</script>
@endpush
@endsection
