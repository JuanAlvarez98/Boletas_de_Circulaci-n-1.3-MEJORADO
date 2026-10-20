<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    private const ALLOWED_ROLES = ['admin', 'operador-emisor', 'supervisor'];

    /**
     * Mostrar el formulario para registrar un usuario.
     */
    public function create(): View
    {
        $roles = Role::query()
            ->whereIn('slug', self::ALLOWED_ROLES)
            ->get()
            ->sortBy(fn (Role $role) => array_search($role->slug, self::ALLOWED_ROLES, true));

        return view('users.create', compact('roles'));
    }

    /**
     * Registrar el usuario y asignarle un rol.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => [
                'required',
                'string',
                Rule::in(self::ALLOWED_ROLES),
                Rule::exists('roles', 'slug'),
            ],
        ], [
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'role.required' => 'Debe seleccionar un rol.',
            'role.in' => 'El rol seleccionado no está permitido.',
        ]);

        DB::transaction(function () use ($validated): void {
            $user = User::create([
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'password' => Hash::make($validated['password']),
            ]);

            $role = Role::where('slug', $validated['role'])->firstOrFail();
            $user->roles()->sync([$role->id]);
        });

        return redirect()
            ->route('users.index')
            ->with('status', 'Usuario creado correctamente.');
    }
}
