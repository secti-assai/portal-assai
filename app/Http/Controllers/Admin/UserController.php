<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:gerir usuarios');
    }

    public function index(Request $request): View
    {
        $usuarios = User::with('roles', 'permissions')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim()->toString();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'ilike', '%' . $search . '%')
                        ->orWhere('email', 'ilike', '%' . $search . '%');
                });
            })
            ->when($request->filled('role'), function ($query) use ($request) {
                $role = $request->string('role')->trim()->toString();

                $query->role($role);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $roles = Role::orderBy('name')->pluck('name', 'name');

        return view('admin.users.index', compact('usuarios', 'roles'));
    }

    public function create(): View
    {
        $roles       = Role::query()->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'permissions'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($this->resolveRoleNames($request));
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')
            ->with('sucesso', "Usuário \"{$user->name}\" criado com sucesso.");
    }

    public function edit(User $user): View
    {
        $roles       = Role::query()->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($this->resolveRoleNames($request));
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')
            ->with('sucesso', "Usuário \"{$user->name}\" atualizado com sucesso.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Ação negada: Não é possível excluir a própria conta de utilizador.');
        }

        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return back()->with('error', 'Ação crítica bloqueada: O portal exige a manutenção de pelo menos um administrador ativo.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário removido do sistema com sucesso.');
    }

    /**
     * @return array<int, string>
     */
    private function resolveRoleNames(UserRequest $request): array
    {
        $selectedRoles = collect($request->input('roles', []))
            ->filter(static fn ($role): bool => is_string($role) && trim($role) !== '')
            ->map(static fn (string $role): string => trim($role));

        $newRoles = $this->parseNewRoles((string) $request->input('new_roles', ''));

        $roleNames = $selectedRoles
            ->merge($newRoles)
            ->map(static function (string $role): string {
                return mb_strtolower($role) === 'admin' ? 'admin' : $role;
            })
            ->unique()
            ->values();

        $rolesToCreate = $roleNames->filter(static fn (string $role): bool => $role !== 'admin');

        $rolesToCreate->each(static function (string $role): void {
            Role::firstOrCreate(['name' => $role]);
        });

        Role::firstOrCreate(['name' => 'admin']);

        return $roleNames->all();
    }

    /**
     * @return Collection<int, string>
     */
    private function parseNewRoles(string $newRoles): Collection
    {
        return collect(explode(',', $newRoles))
            ->map(static fn (string $role): string => trim($role))
            ->filter(static fn (string $role): bool => $role !== '')
            ->values();
    }
}
